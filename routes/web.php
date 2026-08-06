<?php

use App\Http\Controllers\LanguageController;
// =============================================
//  Language Switcher
// =============================================
use Illuminate\Support\Facades\Route;

Route::get('/lang/{lang}', [LanguageController::class, 'switchLang'])->name('lang.switch');

// Newsletter subscription endpoint
Route::post('/newsletter/subscribe', function (\Illuminate\Http\Request $request) {
    $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
        'email' => 'required|email|max:255',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'success' => false,
            'message' => __('يرجى إدخال بريد إلكتروني صحيح'),
        ], 422);
    }

    \App\Models\NewsletterSubscriber::firstOrCreate(['email' => $request->email]);

    return response()->json([
        'success' => true,
        'message' => __('تم الاشتراك بنجاح في النشرة البريدية!'),
    ]);
})->name('store.newsletter.subscribe');

// =============================================
//  React Single Page Application (SPA)
// =============================================
Route::get('/', function () {
    return response()->file(public_path('index.html'));
})->name('store.home')->middleware('maintenance');

Route::get('/{any}', function () {
    return response()->file(public_path('index.html'));
})->where('any', '^(?!.*(admin|api|store-api|storage)).*$')->middleware('maintenance');

// =============================================
//  Redirects & Fallback
// =============================================
// إعادة توجيه /erp إلى لوحة التحكم الجديدة
Route::get('/erp/{any?}', function () {
    return redirect('/admin/login', 301);
})->where('any', '.*');

// إعادة توجيه /crm و /manager-login القديمة إلى Filament
Route::get('/crm/{any?}', function () {
    return redirect('/admin', 301);
})->where('any', '.*');

Route::get('/manager-login', function () {
    return redirect('/admin/login', 301);
});

// Fallback 404
Route::fallback(function () {
    abort(404);
});
