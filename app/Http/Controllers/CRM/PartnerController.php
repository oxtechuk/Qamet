<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use Illuminate\Http\Request;

class PartnerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $partners = Partner::query()->orderBy('sort_order')->get();
        return view('crm.settings.partners.index', compact('partners'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'nullable|string|max:255',
            'logo' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'link' => 'nullable|url',
            'sort_order' => 'nullable|integer'
        ]);

        $data = $request->except('logo');
        
        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('partners', 'public');
        }

        Partner::create($data);

        return back()->with('success', __('تم إضافة الشريك بنجاح'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $partner = Partner::findOrFail($id);
        
        $request->validate([
            'name' => 'nullable|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'link' => 'nullable|url',
            'sort_order' => 'nullable|integer'
        ]);

        $data = $request->except('logo');

        if ($request->hasFile('logo')) {
            if ($partner->logo) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($partner->logo);
            }
            $data['logo'] = $request->file('logo')->store('partners', 'public');
        }

        $partner->update($data);

        return back()->with('success', __('تم تعديل الشريك بنجاح'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $partner = Partner::findOrFail($id);
        
        if ($partner->logo) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($partner->logo);
        }
        
        $partner->delete();

        return back()->with('success', __('تم حذف الشريك بنجاح'));
    }
}
