<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Car;
use App\Models\Employee;
use App\Notifications\NewBookingNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class BookingController extends Controller
{
    public function create(Request $request)
    {
        $car = null;
        if ($request->filled('car_id')) {
            $car = Car::with('brand')->findOrFail($request->car_id);
        }
        $cars = Car::with('brand')->where('is_active', true)->orderBy('name')->get();

        return view('store.booking.create', compact('car', 'cars'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'car_id' => 'required|exists:cars,id',
            'client_name' => 'required|string|max:255',
            'client_phone' => 'required|string|max:20',
            'client_email' => 'nullable|email|max:255',
            'down_payment' => 'required|integer|min:0',
            'duration_years' => 'required|integer|min:1|max:10',
            'interest_rate' => 'nullable|numeric|min:0|max:50',
            'notes' => 'nullable|string|max:1000',
            'booking_type' => 'nullable|string|in:test_drive,purchase,inquiry',
            'location' => 'nullable|string|max:500',
        ]);

        // احسب القسط والإجمالي من الـ server
        $car = Car::findOrFail($data['car_id']);
        $interestRate = isset($data['interest_rate']) && $data['interest_rate'] > 0
                            ? (float) $data['interest_rate']
                            : 4.0; // نسبة افتراضية 4%
        $principal = max(0, $car->cash_price - $data['down_payment']);
        $totalMonths = $data['duration_years'] * 12;
        $monthlyRate = ($interestRate / 100) / 12;

        if ($monthlyRate > 0) {
            $monthly = $principal * ($monthlyRate * pow(1 + $monthlyRate, $totalMonths))
                       / (pow(1 + $monthlyRate, $totalMonths) - 1);
        } else {
            $monthly = $totalMonths > 0 ? $principal / $totalMonths : 0;
        }

        $data['monthly_installment'] = (int) round($monthly);
        $data['total_price'] = (int) round($monthly * $totalMonths + $data['down_payment']);
        $data['interest_rate'] = $interestRate;
        $data['status'] = 'new';
        $data['source'] = 'website';

        $booking = Booking::create($data);

        // Auto assign to a sales rep
        app(\App\Services\BookingAssignmentService::class)->autoAssign($booking);

        // Notify Admins
        $admins = Employee::where('role', 'admin')->orWhere('id', 1)->get();
        Notification::send($admins, new NewBookingNotification($booking));

        $whatsappText = urlencode(
            "طلب حجز جديد من موقع \n".
            "الاسم: {$data['client_name']}\n".
            "الهاتف: {$data['client_phone']}\n".
            "السيارة: {$car->name}\n".
            'المقدم: '.number_format($data['down_payment'])." ﷼\n".
            "المدة: {$data['duration_years']} سنة\n".
            'القسط: '.number_format($data['monthly_installment']).' ﷼ / شهر'
        );

        // إرسال رسالة واتساب ترحيبية للعميل
        $settings = \App\Models\Setting::whereIn('key', ['whatsapp_template_new_lead'])->pluck('value', 'key');
        $template = $settings['whatsapp_template_new_lead'] ?? '';

        if (! empty($template) && ! empty($booking->client_phone)) {
            $message = str_replace(
                ['{customer_name}', '{car_name}', '{status}'],
                [$booking->client_name, $car->name, Booking::STATUSES[$data['status']]['label'] ?? 'جديد'],
                $template
            );
            $twilioService = app(\App\Services\TwilioWhatsAppService::class);
            $twilioService->sendWhatsApp($booking->client_phone, $message);
        }

        return redirect()->route('store.booking.success', $booking->id)
            ->with('whatsapp_text', $whatsappText);
    }

    public function success(Booking $booking)
    {
        return view('store.booking.success', compact('booking'));
    }
}
