<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use App\Models\NewsletterSubscriber;
use Illuminate\Http\Request;

class NewsletterSubscriberController extends Controller
{
    public function index(Request $request)
    {
        $query = NewsletterSubscriber::latest('subscribed_at');

        // بحث بالإيميل
        if ($request->filled('search')) {
            $query->where('email', 'like', '%' . $request->search . '%');
        }

        // فلترة بالحالة
        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        $subscribers = $query->paginate(30)->withQueryString();

        // إحصائيات
        $stats = [
            'total'      => NewsletterSubscriber::count(),
            'active'     => NewsletterSubscriber::active()->count(),
            'this_month' => NewsletterSubscriber::thisMonth()->count(),
            'inactive'   => NewsletterSubscriber::where('is_active', false)->count(),
        ];

        return view('crm.newsletter.index', compact('subscribers', 'stats'));
    }

    public function toggle(NewsletterSubscriber $subscriber)
    {
        $subscriber->update([
            'is_active'       => ! $subscriber->is_active,
            'unsubscribed_at' => $subscriber->is_active ? now() : null,
        ]);

        return back()->with('success', $subscriber->is_active
            ? 'تم تعطيل المشترك بنجاح'
            : 'تم تفعيل المشترك بنجاح');
    }

    public function destroy(NewsletterSubscriber $subscriber)
    {
        $subscriber->delete();
        return back()->with('success', 'تم حذف المشترك بنجاح');
    }

    public function export()
    {
        $subscribers = NewsletterSubscriber::active()
            ->orderBy('subscribed_at', 'desc')
            ->get(['email', 'subscribed_at', 'ip_address']);

        $csv  = "\xEF\xBB\xBF"; // BOM for Excel Arabic support
        $csv .= "البريد الإلكتروني,تاريخ الاشتراك,عنوان IP\n";

        foreach ($subscribers as $sub) {
            $csv .= "\"{$sub->email}\",\"{$sub->subscribed_at?->format('Y-m-d H:i')}\",\"{$sub->ip_address}\"\n";
        }

        return response($csv, 200, [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="newsletter_subscribers_' . now()->format('Ymd') . '.csv"',
        ]);
    }
}
