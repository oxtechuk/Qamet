<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use App\Models\CalculatorLead;
use Illuminate\Http\Request;

class CalculatorLeadController extends Controller
{
    public function index(Request $request)
    {
        $query = CalculatorLead::with('car.brand')->latest();

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('name', 'like', "%{$s}%")
                    ->orWhere('phone', 'like', "%{$s}%");
            });
        }

        $leads = $query->paginate(20)->withQueryString();

        return view('crm.calculator-leads.index', compact('leads'));
    }

    public function destroy(CalculatorLead $calculatorLead)
    {
        $calculatorLead->delete();
        return back()->with('success', __('تم حذف السجل بنجاح'));
    }
}
