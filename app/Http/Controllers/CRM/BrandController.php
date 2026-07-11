<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\BrandType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BrandController extends Controller
{
    public function index()
    {
        $brands = Brand::withCount('cars')->with('brandType')->latest()->paginate(20);
        $brandTypes = BrandType::orderBy('sort_order')->orderBy('id')->get();

        return view('crm.brands.index', compact('brands', 'brandTypes'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|array',
            'name.ar' => 'required|string|max:100',
            'name.en' => 'required|string|max:100',
            'logo' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'brand_type_id' => 'nullable|exists:brand_types,id',
        ]);
        $data['slug'] = Str::slug($data['name']['en']);
        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('brands', 'public');
        }
        Brand::create($data);

        return back()->with('success', 'تمت إضافة الماركة');
    }

    public function update(Request $request, Brand $brand)
    {
        $data = $request->validate([
            'name' => 'required|array',
            'name.ar' => 'required|string|max:100',
            'name.en' => 'required|string|max:100',
            'logo' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'is_active' => 'boolean',
            'brand_type_id' => 'nullable|exists:brand_types,id',
        ]);
        $data['is_active'] = $request->boolean('is_active');
        if ($request->hasFile('logo')) {
            if ($brand->logo) {
                Storage::disk('public')->delete($brand->logo);
            }
            $data['logo'] = $request->file('logo')->store('brands', 'public');
        }
        $brand->update($data);

        return back()->with('success', 'تم تحديث الماركة');
    }

    public function destroy(Brand $brand)
    {
        if ($brand->logo) {
            Storage::disk('public')->delete($brand->logo);
        }
        $brand->delete();

        return back()->with('success', 'تم حذف الماركة');
    }
}
