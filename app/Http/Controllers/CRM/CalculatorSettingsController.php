<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use App\Models\CalculatorBank;
use App\Models\CalculatorFactor;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CalculatorSettingsController extends Controller
{
    public function index()
    {
        $banks = CalculatorBank::query()->orderBy('sort_order')->orderBy('id')->get();
        $factors = CalculatorFactor::query()->orderBy('type')->orderBy('sort_order')->orderBy('id')->get()->groupBy('type');

        return view('crm.calculator.index', compact('banks', 'factors'));
    }

    public function storeBank(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:120',
            'annual_rate' => 'required|numeric|min:0|max:100',
            'sort_order' => 'nullable|integer|min:0|max:65535',
            'is_active' => 'boolean',
        ]);
        $data['is_active'] = $request->boolean('is_active', true);
        $data['sort_order'] = $data['sort_order'] ?? 0;
        CalculatorBank::create($data);

        return back()->with('success', __('تمت إضافة البنك'));
    }

    public function updateBank(Request $request, CalculatorBank $calculatorBank)
    {
        $data = $request->validate([
            'name' => 'required|string|max:120',
            'annual_rate' => 'required|numeric|min:0|max:100',
            'sort_order' => 'nullable|integer|min:0|max:65535',
            'is_active' => 'boolean',
        ]);
        $data['is_active'] = $request->boolean('is_active');
        $data['sort_order'] = $data['sort_order'] ?? 0;
        $calculatorBank->update($data);

        return back()->with('success', __('تم تحديث البنك'));
    }

    public function destroyBank(CalculatorBank $calculatorBank)
    {
        $calculatorBank->delete();

        return back()->with('success', __('تم حذف البنك'));
    }

    public function storeFactor(Request $request)
    {
        $data = $this->validatedFactor($request, null);
        CalculatorFactor::create($data);

        return back()->with('success', __('تمت إضافة العامل'));
    }

    public function updateFactor(Request $request, CalculatorFactor $calculatorFactor)
    {
        $data = $this->validatedFactor($request, $calculatorFactor);
        $calculatorFactor->update($data);

        return back()->with('success', __('تم تحديث العامل'));
    }

    public function destroyFactor(CalculatorFactor $calculatorFactor)
    {
        $calculatorFactor->delete();

        return back()->with('success', __('تم حذف العامل'));
    }

    private function validatedFactor(Request $request, ?CalculatorFactor $existing): array
    {
        $types = [
            CalculatorFactor::TYPE_GENDER,
            CalculatorFactor::TYPE_AGE_BAND,
            CalculatorFactor::TYPE_SALARY_BAND,
            CalculatorFactor::TYPE_EMPLOYMENT,
        ];

        $codeRule = Rule::unique('calculator_factors', 'code')
            ->where('type', $request->input('type'));
        if ($existing) {
            $codeRule->ignore($existing->id);
        }

        $rules = [
            'type' => ['required', Rule::in($types)],
            'code' => [
                'required',
                'string',
                'max:64',
                'regex:/^[a-z0-9_]+$/',
                $codeRule,
            ],
            'label_ar' => 'required|string|max:200',
            'label_en' => 'nullable|string|max:200',
            'min_age' => 'nullable|integer|min:0|max:120',
            'max_age' => 'nullable|integer|min:0|max:120',
            'rate_adjustment' => 'required|numeric|between:-20,20',
            'sort_order' => 'nullable|integer|min:0|max:65535',
            'is_active' => 'boolean',
        ];

        $data = $request->validate($rules);

        if ($data['type'] === CalculatorFactor::TYPE_AGE_BAND) {
            $request->validate([
                'min_age' => 'required|integer|min:0|max:120',
                'max_age' => 'required|integer|min:0|max:120|gte:min_age',
            ]);
        } else {
            $data['min_age'] = null;
            $data['max_age'] = null;
        }

        $data['is_active'] = $request->boolean('is_active', true);
        $data['sort_order'] = $data['sort_order'] ?? 0;

        return $data;
    }
}
