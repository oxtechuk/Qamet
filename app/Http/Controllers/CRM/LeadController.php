<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\ContactSource;
use App\Models\Employee;
use App\Models\Lead;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class LeadController extends Controller
{
    public function index(Request $request)
    {
        $query = Lead::with(['contactSource', 'car.brand', 'employee'])->latest();

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('client_name', 'like', "%{$s}%")
                    ->orWhere('client_phone', 'like', "%{$s}%")
                    ->orWhere('client_email', 'like', "%{$s}%");
            });
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('contact_source_id')) {
            $query->where('contact_source_id', $request->contact_source_id);
        }
        if ($request->filled('employee_id')) {
            $query->where('assigned_to', $request->employee_id);
        }

        $leads = $query->paginate(20)->withQueryString();
        $statuses = Lead::STATUSES;
        $sources = ContactSource::activeOrdered()->get();
        $employees = Employee::where('is_active', true)->orderBy('name')->get();

        return view('crm.leads.index', compact('leads', 'statuses', 'sources', 'employees'));
    }

    public function create()
    {
        $statuses = Lead::STATUSES;
        $sources = ContactSource::activeOrdered()->get();
        $cars = Car::with('brand')->where('is_active', true)->orderByDesc('id')->get();
        $employees = Employee::where('is_active', true)->orderBy('name')->get();

        return view('crm.leads.create', compact('statuses', 'sources', 'cars', 'employees'));
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        Lead::create($data);

        return redirect()->route('crm.leads.index')->with('success', __('تم إضافة العميل بنجاح'));
    }

    public function show(Lead $lead)
    {
        $lead->load(['contactSource', 'car.brand', 'employee', 'orders.car.brand']);

        return view('crm.leads.show', compact('lead'));
    }

    public function edit(Lead $lead)
    {
        $statuses = Lead::STATUSES;
        $sources = ContactSource::activeOrdered()->get();
        $cars = Car::with('brand')->where('is_active', true)->orderByDesc('id')->get();
        $employees = Employee::where('is_active', true)->orderBy('name')->get();

        return view('crm.leads.edit', compact('lead', 'statuses', 'sources', 'cars', 'employees'));
    }

    public function update(Request $request, Lead $lead)
    {
        $data = $this->validated($request);
        $lead->update($data);

        return redirect()->route('crm.leads.show', $lead)->with('success', __('تم تحديث بيانات العميل'));
    }

    public function destroy(Lead $lead)
    {
        $lead->delete();

        return redirect()->route('crm.leads.index')->with('success', __('تم حذف السجل'));
    }

    private function validated(Request $request): array
    {
        $statuses = array_keys(Lead::STATUSES);

        $data = $request->validate([
            'client_name' => 'required|string|max:200',
            'client_phone' => 'nullable|string|max:40',
            'client_email' => 'nullable|email|max:200',
            'contact_source_id' => 'required|exists:contact_sources,id',
            'status' => ['required', Rule::in($statuses)],
            'started_at' => 'required|date',
            'status_details' => 'nullable|string|max:5000',
            'car_id' => 'nullable|exists:cars,id',
            'assigned_to' => 'nullable|exists:employees,id',
        ]);

        return $data;
    }
}
