<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BlogCategoryController extends Controller
{
    public function index()
    {
        $categories = BlogCategory::withCount('posts')->orderBy('sort_order')->paginate(20);

        return view('crm.blog-categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|array',
            'name.ar' => 'required|string|max:100',
            'name.en' => 'required|string|max:100',
            'icon' => 'nullable|string|max:100',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $data['slug'] = Str::slug($data['name']['en']);
        $data['sort_order'] = $request->input('sort_order', 0);

        BlogCategory::create($data);

        return back()->with('success', 'تمت إضافة التصنيف بنجاح');
    }

    public function update(Request $request, BlogCategory $blogCategory)
    {
        $data = $request->validate([
            'name' => 'required|array',
            'name.ar' => 'required|string|max:100',
            'name.en' => 'required|string|max:100',
            'icon' => 'nullable|string|max:100',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $data['sort_order'] = $request->input('sort_order', 0);
        $data['is_active'] = $request->boolean('is_active');

        if ($data['name']['en'] !== $blogCategory->getTranslation('name', 'en', false)) {
            $data['slug'] = Str::slug($data['name']['en']);
        }

        $blogCategory->update($data);

        return back()->with('success', 'تم تحديث التصنيف بنجاح');
    }

    public function destroy(BlogCategory $blogCategory)
    {
        $blogCategory->delete();

        return back()->with('success', 'تم حذف التصنيف بنجاح');
    }
}
