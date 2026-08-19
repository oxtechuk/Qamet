<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use App\Models\CarType;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CarTypeController extends Controller
{
    public function index()
    {
        $types = CarType::withCount('cars')->orderBy('sort_order')->orderBy('id')->paginate(20);

        return view('crm.car-types.index', compact('types'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|array',
            'name.ar' => 'required|string|max:100',
            'name.en' => 'required|string|max:100',
            'sort_order' => 'nullable|integer|min:0|max:65535',
            'is_active' => 'boolean',
        ]);
        $data['slug'] = Str::slug($data['name']['en'].'-'.uniqid());
        $data['is_active'] = $request->boolean('is_active', true);
        $data['sort_order'] = $data['sort_order'] ?? 0;
        CarType::create($data);

        return back()->with('success', __('تمت إضافة النوع'));
    }

    public function update(Request $request, CarType $carType)
    {
        $data = $request->validate([
            'name' => 'required|array',
            'name.ar' => 'required|string|max:100',
            'name.en' => 'required|string|max:100',
            'sort_order' => 'nullable|integer|min:0|max:65535',
            'is_active' => 'boolean',
        ]);
        $data['is_active'] = $request->boolean('is_active');
        $data['sort_order'] = $data['sort_order'] ?? 0;
        $carType->update($data);

        return back()->with('success', __('تم تحديث النوع'));
    }

    public function destroy(CarType $carType)
    {
        $carType->delete();

        return back()->with('success', __('تم حذف النوع'));
    }
}
