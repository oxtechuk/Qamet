<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use App\Models\ContactSource;
use Illuminate\Http\Request;

class ContactSourceController extends Controller
{
    public function index()
    {
        $sources = ContactSource::query()->orderBy('sort_order')->orderBy('id')->paginate(30);

        return view('crm.contact-sources.index', compact('sources'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:120',
            'sort_order' => 'nullable|integer|min:0|max:65535',
            'is_active' => 'boolean',
        ]);
        $data['is_active'] = $request->boolean('is_active', true);
        $data['sort_order'] = $data['sort_order'] ?? 0;
        ContactSource::create($data);

        return back()->with('success', __('تمت إضافة مصدر التواصل'));
    }

    public function update(Request $request, ContactSource $contactSource)
    {
        $data = $request->validate([
            'name' => 'required|string|max:120',
            'sort_order' => 'nullable|integer|min:0|max:65535',
            'is_active' => 'boolean',
        ]);
        $data['is_active'] = $request->boolean('is_active');
        $data['sort_order'] = $data['sort_order'] ?? 0;
        $contactSource->update($data);

        return back()->with('success', __('تم التحديث'));
    }

    public function destroy(ContactSource $contactSource)
    {
        if ($contactSource->leads()->exists()) {
            return back()->with('error', __('لا يمكن الحذف: يوجد عملاء مرتبطون بهذا المصدر'));
        }
        $contactSource->delete();

        return back()->with('success', __('تم الحذف'));
    }
}
