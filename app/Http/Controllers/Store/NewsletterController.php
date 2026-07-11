<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\NewsletterSubscriber;
use Illuminate\Http\Request;

class NewsletterController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email|max:191',
        ]);

        $email = strtolower(trim($request->email));

        // تحقق إذا كان الإيميل موجود مسبقاً
        $existing = NewsletterSubscriber::where('email', $email)->first();

        if ($existing) {
            if ($existing->is_active) {
                return response()->json([
                    'success' => false,
                    'message' => __('أنت مشترك بالفعل في النشرة الإخبارية!'),
                ], 409);
            }

            // إعادة تفعيل الاشتراك إذا كان ملغياً
            $existing->update([
                'is_active'       => true,
                'subscribed_at'   => now(),
                'unsubscribed_at' => null,
                'ip_address'      => $request->ip(),
            ]);

            return response()->json([
                'success' => true,
                'message' => __('تم تجديد اشتراكك بنجاح!'),
            ]);
        }

        // إنشاء مشترك جديد
        NewsletterSubscriber::create([
            'email'         => $email,
            'is_active'     => true,
            'ip_address'    => $request->ip(),
            'subscribed_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => __('تم الاشتراك في النشرة الإخبارية بنجاح!'),
        ]);
    }
}
