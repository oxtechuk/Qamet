<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use App\Models\BrandType;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BrandTypeController extends Controller
{
    public function index()
    {
        $brandTypes = BrandType::withCount('brands')->orderBy('sort_order')->orderBy('id')->paginate(20);

        return view('crm.brand-types.index', compact('brandTypes'));
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
        BrandType::create($data);

        return back()->with('success', __('تمت إضافة نوع الماركة'));
    }

    public function update(Request $request, BrandType $brandType)
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
        $brandType->update($data);

        return back()->with('success', __('تم تحديث نوع الماركة'));
    }

    public function destroy(BrandType $brandType)
    {
        if ($brandType->brands()->exists()) {
            return back()->with('error', __('لا يمكن الحذف: توجد ماركات مرتبطة بهذا النوع'));
        }
        $brandType->delete();

        return back()->with('success', __('تم حذف نوع الماركة'));
    }
}
