<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\BookingNote;
use App\Models\Car;
use App\Models\Employee;
use App\Notifications\NewBookingNotification;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $query = Booking::with(['car.brand', 'employee'])->latest();

        // فلترة بالحالة
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // فلترة بالموظف
        if ($request->filled('employee_id')) {
            $query->where('assigned_to', $request->employee_id);
        }
        if (! auth()->user()->hasRole('admin')) {
            $query->where('assigned_to', \auth()->id());
        }
        // بحث
        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('client_name', 'like', "%$s%")
                    ->orWhere('client_phone', 'like', "%$s%");
            });
        }

        $bookings = $query->paginate(20);
        $employees = Employee::where('is_active', true)->get();
        $statuses = Booking::STATUSES;
        $cars = Car::with('brand')->where('is_active', true)->get();

        return view('crm.bookings.index', compact('bookings', 'employees', 'statuses', 'cars'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'client_name' => 'required|string|max:191',
            'client_phone' => 'required|string|max:191',
            'client_email' => 'nullable|email|max:191',
            'car_id' => 'nullable|exists:cars,id',
            'total_price' => 'nullable|numeric',
            'down_payment' => 'nullable|numeric',
            'duration_years' => 'nullable|integer',
            'monthly_installment' => 'nullable|numeric',
            'notes' => 'nullable|string',
            'type' => 'nullable|string',
            'booking_type' => 'nullable|string|in:test_drive,purchase,inquiry',
            'location' => 'nullable|string|max:500',
        ]);

        $booking = Booking::create([
            'client_name' => $request->client_name,
            'client_phone' => $request->client_phone,
            'client_email' => $request->client_email,
            'car_id' => $request->car_id,
            'total_price' => $request->total_price ?? 0,
            'down_payment' => $request->down_payment ?? 0,
            'duration_years' => $request->duration_years ?? 5,
            'monthly_installment' => $request->monthly_installment ?? 0,
            'notes' => $request->notes,
            'booking_type' => $request->booking_type,
            'location' => $request->location,
            'source' => 'CRM (يدوي)',
            'status' => 'new',
            'assigned_to' => auth('employee')->id(), // assign to the creator by default
        ]);

        return back()->with('success', 'تم إنشاء الطلب بنجاح');
    }

    public function show(Booking $booking)
    {
        $booking->load(['car.brand', 'employee', 'notes_list.employee', 'documents.employee']);
        $employees = Employee::where('is_active', true)->get();
        $statuses = Booking::STATUSES;

        return view('crm.bookings.show', compact('booking', 'employees', 'statuses'));
    }

    public function updateStatus(Request $request, Booking $booking)
    {
        $request->validate(['status' => 'required|in:'.implode(',', array_keys(Booking::STATUSES))]);

        $oldStatus = $booking->status;
        $booking->update([
            'status' => $request->status,
            'last_contacted_at' => now(),
        ]);

        // تسجيل تغيير الحالة في الـ Notes
        BookingNote::create([
            'booking_id' => $booking->id,
            'employee_id' => auth('employee')->id(),
            'note' => 'تم تغيير الحالة من "'.Booking::STATUSES[$oldStatus]['label'].'" إلى "'.Booking::STATUSES[$request->status]['label'].'"',
            'type' => 'status_change',
            'old_status' => $oldStatus,
            'new_status' => $request->status,
        ]);

        if ($booking->assignedTo) {
            $booking->assignedTo->notify(new NewBookingNotification($booking, __('تحديث حالة الطلب'), __('تم تغيير حالة طلب العميل').' '.$booking->client_name.' '.__('إلى').' '.Booking::STATUSES[$request->status]['label']));
        }

        // إرسال رسالة واتساب للعميل إذا كان القالب مفعلاً
        $settings = \App\Models\Setting::whereIn('key', ['whatsapp_template_status_update'])->pluck('value', 'key');
        $template = $settings['whatsapp_template_status_update'] ?? '';

        if (! empty($template) && ! empty($booking->client_phone)) {
            $message = str_replace(
                ['{customer_name}', '{car_name}', '{status}'],
                [$booking->client_name, $booking->car?->name ?? 'السيارة', Booking::STATUSES[$request->status]['label']],
                $template
            );
            $twilioService = app(\App\Services\TwilioWhatsAppService::class);
            $twilioService->sendWhatsApp($booking->client_phone, $message);
        }

        return back()->with('success', 'تم تحديث حالة الطلب بنجاح');
    }

    public function assign(Request $request, Booking $booking)
    {
        $request->validate(['employee_id' => 'required|exists:employees,id']);
        $booking->update(['assigned_to' => $request->employee_id]);

        // Notify the assigned employee
        $employee = Employee::find($request->employee_id);
        if ($employee) {
            $employee->notify(new NewBookingNotification($booking, __('طلب جديد'), __('تم تعيين طلب جديد لك للعميل').' '.$booking->client_name));
        }

        return back()->with('success', 'تم توزيع الطلب على الموظف');
    }

    public function addNote(Request $request, Booking $booking)
    {
        $request->validate(['note' => 'required|string|max:2000', 'type' => 'in:note,call']);
        BookingNote::create([
            'booking_id' => $booking->id,
            'employee_id' => auth('employee')->id(),
            'note' => $request->note,
            'type' => $request->type ?? 'note',
        ]);

        return back()->with('success', 'تمت إضافة الملاحظة');
    }

    public function uploadDocument(Request $request, Booking $booking)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'file' => 'required|file|max:10240', // 10MB max
        ]);

        $file = $request->file('file');
        $path = $file->store('booking_documents', 'public');

        $booking->documents()->create([
            'employee_id' => auth('employee')->id(),
            'title' => $request->title ?? $file->getClientOriginalName(),
            'file_path' => $path,
            'file_type' => $file->getClientOriginalExtension(),
        ]);

        return back()->with('success', 'تم رفع المستند بنجاح');
    }

    public function deleteDocument(\App\Models\BookingDocument $document)
    {
        if ($document->file_path && \Illuminate\Support\Facades\Storage::disk('public')->exists($document->file_path)) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($document->file_path);
        }
        $document->delete();

        return back()->with('success', 'تم حذف المستند بنجاح');
    }

    public function destroy(Booking $booking)
    {
        $booking->delete();

        return redirect()->route('crm.bookings.index')->with('success', 'تم حذف الطلب');
    }
}
