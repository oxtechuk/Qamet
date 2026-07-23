<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use App\Models\ProjectDesign;
use Illuminate\Http\Request;

class ProjectDesignController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $designs = ProjectDesign::query()->orderBy('sort_order')->get();

        return view('crm.settings.designs.index', compact('designs'));
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
            'name' => 'required|array',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:5000',
            'sort_order' => 'nullable|integer',
            'is_featured' => 'nullable|boolean',
            'color' => 'nullable|string|max:50',
            'link' => 'nullable|string',
            'type' => 'required|in:social,featured_offer',
            'price' => 'nullable|string',
            'top_speed' => 'nullable|string',
            'power' => 'nullable|string',
            'year' => 'nullable|string',
            'badge_text' => 'nullable|string',
        ]);

        $data = $request->except('image');
        $data['is_featured'] = $request->boolean('is_featured');

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('designs', 'public');
        }

        ProjectDesign::create($data);

        return back()->with('success', __('تم إضافة التصميم بنجاح'));
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
        $design = ProjectDesign::findOrFail($id);

        $request->validate([
            'name' => 'required|array',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:5000',
            'sort_order' => 'nullable|integer',
            'is_featured' => 'nullable|boolean',
            'color' => 'nullable|string|max:50',
            'link' => 'nullable|string',
            'type' => 'required|in:social,featured_offer',
            'price' => 'nullable|string',
            'top_speed' => 'nullable|string',
            'power' => 'nullable|string',
            'year' => 'nullable|string',
            'badge_text' => 'nullable|string',
        ]);

        $data = $request->except('image');
        $data['is_featured'] = $request->boolean('is_featured');

        if ($request->hasFile('image')) {
            if ($design->image) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($design->image);
            }
            $data['image'] = $request->file('image')->store('designs', 'public');
        }

        $design->update($data);

        return back()->with('success', __('تم تعديل التصميم بنجاح'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $design = ProjectDesign::findOrFail($id);

        if ($design->image) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($design->image);
        }

        $design->delete();

        return back()->with('success', __('تم حذف التصميم بنجاح'));
    }

    public function toggleFeatured(string $id)
    {
        $design = ProjectDesign::findOrFail($id);
        $design->update(['is_featured' => ! $design->is_featured]);

        return back()->with('success', __('تم تغيير حالة التصميم بنجاح'));
    }
}
