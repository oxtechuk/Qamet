<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use App\Models\BlogPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    public function index()
    {
        $posts = BlogPost::with('employee')->latest()->paginate(15);

        return view('crm.blog.index', compact('posts'));
    }

    public function create()
    {
        $categories = BlogCategory::activeOrdered()->get();

        return view('crm.blog.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|array',
            'title.ar' => 'required|string|max:255',
            'title.en' => 'required|string|max:255',
            'excerpt' => 'nullable|array',
            'excerpt.ar' => 'nullable|string|max:500',
            'excerpt.en' => 'nullable|string|max:500',
            'content' => 'required|array',
            'content.ar' => 'required|string',
            'content.en' => 'required|string',
            'thumbnail' => 'nullable|image|max:5120',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:255',
            'categories' => 'nullable|array',
            'categories.*' => 'exists:blog_categories,id',
            'is_published' => 'boolean',
            'is_featured' => 'boolean',
        ]);

        $data['slug'] = Str::slug($data['title']['en']).'-'.uniqid();
        $data['employee_id'] = auth('employee')->id();
        $data['is_published'] = $request->boolean('is_published');
        $data['is_featured'] = $request->boolean('is_featured');
        $data['published_at'] = $data['is_published'] ? now() : null;

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('blog', 'public');
        }

        $post = BlogPost::create($data);
        $post->categories()->sync($request->input('categories', []));

        return redirect()->route('crm.blog.index')->with('success', 'تم نشر المقالة');
    }

    public function edit(BlogPost $blog)
    {
        $categories = BlogCategory::activeOrdered()->get();

        return view('crm.blog.edit', compact('blog', 'categories'));
    }

    public function update(Request $request, BlogPost $blog)
    {
        $data = $request->validate([
            'title' => 'required|array',
            'title.ar' => 'required|string|max:255',
            'title.en' => 'required|string|max:255',
            'excerpt' => 'nullable|array',
            'excerpt.ar' => 'nullable|string|max:500',
            'excerpt.en' => 'nullable|string|max:500',
            'content' => 'required|array',
            'content.ar' => 'required|string',
            'content.en' => 'required|string',
            'thumbnail' => 'nullable|image|max:5120',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:255',
            'categories' => 'nullable|array',
            'categories.*' => 'exists:blog_categories,id',
            'is_published' => 'boolean',
            'is_featured' => 'boolean',
        ]);

        $data['is_published'] = $request->boolean('is_published');
        $data['is_featured'] = $request->boolean('is_featured');
        if ($data['is_published'] && ! $blog->published_at) {
            $data['published_at'] = now();
        }

        if ($request->hasFile('thumbnail')) {
            if ($blog->thumbnail) {
                Storage::disk('public')->delete($blog->thumbnail);
            }
            $data['thumbnail'] = $request->file('thumbnail')->store('blog', 'public');
        }

        $blog->update($data);
        $blog->categories()->sync($request->input('categories', []));

        return redirect()->route('crm.blog.index')->with('success', 'تم تحديث المقالة');
    }

    public function destroy(BlogPost $blog)
    {
        if ($blog->thumbnail) {
            Storage::disk('public')->delete($blog->thumbnail);
        }
        $blog->delete();

        return redirect()->route('crm.blog.index')->with('success', 'تم حذف المقالة');
    }

    public function toggleFeatured(BlogPost $blog)
    {
        $blog->update(['is_featured' => ! $blog->is_featured]);

        return redirect()->back()->with('success', 'تم تعديل حالة تمييز المقالة بنجاح');
    }
}
