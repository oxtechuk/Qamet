<?php

use App\Http\Controllers\Api\Store\AboutController;
use App\Http\Controllers\Api\Store\BlogController;
use App\Http\Controllers\Api\Store\BookingController;
use App\Http\Controllers\Api\Store\CalculatorController;
use App\Http\Controllers\Api\Store\CarCategoryController;
use App\Http\Controllers\Api\Store\CarController;
use App\Http\Controllers\Api\Store\CarTypeController;
use App\Http\Controllers\Api\Store\GalleryController;
use App\Http\Controllers\Api\Store\HomeController;
use App\Http\Controllers\Api\Store\NewsletterController;
use App\Http\Controllers\Api\Store\OfferController;
use App\Http\Controllers\Api\Store\PartnerController;
use App\Http\Controllers\Api\Store\SettingsController;
use App\Http\Controllers\Api\Store\TestimonialController;
use Illuminate\Support\Facades\Route;

Route::prefix('store')->name('store.api.')->group(function () {
    // Car Catalog (US1)
    Route::get('/cars', [CarController::class, 'index'])->name('cars.index');
    Route::get('/cars/meta', [CarController::class, 'listMeta'])->name('cars.meta');
    Route::get('/cars/search', [CarController::class, 'search'])->name('cars.search');
    Route::get('/cars/compare', [CarController::class, 'compare'])->name('cars.compare');
    Route::get('/cars/{slug}', [CarController::class, 'show'])->name('cars.show');
    Route::get('/brands', [CarController::class, 'brands'])->name('brands.index');
    Route::get('/car-categories', [CarCategoryController::class, 'index'])->name('car-categories.index');
    Route::get('/car-types', [CarTypeController::class, 'index'])->name('car-types.index');

    // Booking & Calculator (US2)
    Route::get('/booking/meta', [BookingController::class, 'meta'])->name('booking.meta');
    Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');
    Route::get('/calculator/banks', [CalculatorController::class, 'banks'])->name('calculator.banks');
    Route::post('/calculator/calculate', [CalculatorController::class, 'calculate'])->name('calculator.calculate');
    Route::post('/calculator/lead', [CalculatorController::class, 'saveLead'])->name('calculator.lead');
    Route::post('/calculator/otp/send', [CalculatorController::class, 'sendOtp'])->name('calculator.otp.send');
    Route::post('/calculator/otp/verify', [CalculatorController::class, 'verifyOtp'])->name('calculator.otp.verify');

    // Content & Engagement (US3)
    Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
    Route::get('/blog/categories', [BlogController::class, 'categories'])->name('blog.categories');
    Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');
    Route::get('/offers', [OfferController::class, 'index'])->name('offers.index');
    Route::post('/newsletter', [NewsletterController::class, 'store'])->name('newsletter.store');

    // FAQs
    Route::get('/faqs', \App\Http\Controllers\Api\Store\FaqController::class)->name('faqs');

    // Home & Static (US4)
    Route::get('/home', [HomeController::class, '__invoke'])->name('home');
    Route::get('/about', [AboutController::class, '__invoke'])->name('about');
    Route::get('/contact', [\App\Http\Controllers\Api\Store\ContactController::class, 'meta'])->name('contact.meta');
    Route::post('/contact', [\App\Http\Controllers\Api\Store\ContactController::class, 'store'])->name('contact.store');
    Route::get('/testimonials', [TestimonialController::class, '__invoke'])->name('testimonials');
    Route::get('/partners', [PartnerController::class, '__invoke'])->name('partners');

    // Settings & Gallery (US5)
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::get('/settings/structured', [SettingsController::class, 'structured'])->name('settings.structured');
    Route::get('/settings/footer', [SettingsController::class, 'footer'])->name('settings.footer');
    Route::get('/settings/finance-solution', [SettingsController::class, 'getFinanceSolution'])->name('settings.finance-solution');
    Route::get('/gallery', [GalleryController::class, '__invoke'])->name('gallery');
});
