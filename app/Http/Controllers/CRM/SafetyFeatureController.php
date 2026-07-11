<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use App\Models\SafetyFeature;
use Illuminate\Http\Request;

class SafetyFeatureController extends Controller
{
    public function index()
    {
        $safetyFeatures = SafetyFeature::latest()->paginate(20);

        return view('crm.safety-features.index', compact('safetyFeatures'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|array',
            'name.ar' => 'required|string',
            'name.en' => 'required|string',
            'icon' => 'nullable|string',
        ]);

        SafetyFeature::create($request->all());

        return back()->with('success', 'تمت إضافة ميزة السلامة بنجاح');
    }

    public function update(Request $request, SafetyFeature $safetyFeature)
    {
        $request->validate([
            'name' => 'required|array',
            'name.ar' => 'required|string',
            'name.en' => 'required|string',
            'icon' => 'nullable|string',
        ]);

        $safetyFeature->update($request->all());

        return back()->with('success', 'تم تحديث ميزة السلامة بنجاح');
    }

    public function destroy(SafetyFeature $safetyFeature)
    {
        $safetyFeature->delete();

        return back()->with('success', 'تم حذف ميزة السلامة');
    }
}
