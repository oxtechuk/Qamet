<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use App\Models\CarCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CarCategoryController extends Controller
{
    public function index()
    {
        $categories = CarCategory::withCount('cars')->orderBy('sort_order')->orderBy('id')->paginate(20);

        return view('crm.car-categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'       => 'required|array',
            'name.ar'    => 'required|string|max:100',
            'name.en'    => 'required|string|max:100',
            'sort_order' => 'nullable|integer|min:0|max:65535',
            'is_active'  => 'boolean',
        ]);
        $data['slug'] = Str::slug($data['name']['en'].'-'.uniqid());
        $data['is_active'] = $request->boolean('is_active', true);
        $data['sort_order'] = $data['sort_order'] ?? 0;
        CarCategory::create($data);

        return back()->with('success', __('تمت إضافة التصنيف'));
    }

    public function update(Request $request, CarCategory $carCategory)
    {
        $data = $request->validate([
            'name'       => 'required|array',
            'name.ar'    => 'required|string|max:100',
            'name.en'    => 'required|string|max:100',
            'sort_order' => 'nullable|integer|min:0|max:65535',
            'is_active'  => 'boolean',
        ]);
        $data['is_active'] = $request->boolean('is_active');
        $data['sort_order'] = $data['sort_order'] ?? 0;
        $carCategory->update($data);

        return back()->with('success', __('تم تحديث التصنيف'));
    }

    public function destroy(CarCategory $carCategory)
    {
        if ($carCategory->cars()->exists()) {
            return back()->with('error', __('لا يمكن الحذف: توجد سيارات مرتبطة بهذا التصنيف'));
        }
        $carCategory->delete();

        return back()->with('success', __('تم حذف التصنيف'));
    }
}
