<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use App\Models\Feature;
use Illuminate\Http\Request;

class FeatureController extends Controller
{
    public function index()
    {
        $features = Feature::latest()->paginate(20);
        return view('crm.features.index', compact('features'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|array',
            'name.ar' => 'required|string',
            'name.en' => 'required|string',
            'icon' => 'nullable|string',
        ]);

        Feature::create($request->all());

        return back()->with('success', 'تمت إضافة الخاصية بنجاح');
    }

    public function update(Request $request, Feature $feature)
    {
        $request->validate([
            'name' => 'required|array',
            'name.ar' => 'required|string',
            'name.en' => 'required|string',
            'icon' => 'nullable|string',
        ]);

        $feature->update($request->all());

        return back()->with('success', 'تم تحديث الخاصية بنجاح');
    }

    public function destroy(Feature $feature)
    {
        $feature->delete();
        return back()->with('success', 'تم حذف الخاصية');
    }
}
