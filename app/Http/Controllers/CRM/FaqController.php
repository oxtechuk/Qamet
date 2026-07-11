<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function index()
    {
        $faqs = Faq::orderBy('sort_order')->orderBy('id')->get();

        return view('crm.settings.faqs.index', compact('faqs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'question' => ['required', 'array'],
            'answer' => ['required', 'array'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);

        $data = $request->only(['question', 'answer', 'sort_order']);
        $data['is_visible'] = $request->has('is_visible');

        Faq::create($data);

        return back()->with('success', __('تم إضافة السؤال بنجاح'));
    }

    public function update(Request $request, Faq $faq)
    {
        $request->validate([
            'question' => ['required', 'array'],
            'answer' => ['required', 'array'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);

        $data = $request->only(['question', 'answer', 'sort_order']);
        $data['is_visible'] = $request->has('is_visible');

        $faq->update($data);

        return back()->with('success', __('تم تعديل السؤال بنجاح'));
    }

    public function destroy(Faq $faq)
    {
        $faq->delete();

        return back()->with('success', __('تم حذف السؤال بنجاح'));
    }
}
