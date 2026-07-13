<?php

use App\Http\Controllers\LanguageController;
// =============================================
//  Language Switcher
// =============================================
use Illuminate\Support\Facades\Route;

Route::get('/lang/{lang}', [LanguageController::class, 'switchLang'])->name('lang.switch');

// =============================================
//  React Single Page Application (SPA)
// =============================================
Route::get('/', function () {
    return response()->file(public_path('index.html'));
})->name('store.home')->middleware('maintenance');

Route::get('/{any}', function () {
    return response()->file(public_path('index.html'));
})->where('any', '^(?!crm|manager-login|api|store-api|storage).*$')->middleware('maintenance');

// =============================================
//  CRM (Admin Dashboard)
// =============================================
use App\Http\Controllers\CRM\AuthController;
use App\Http\Controllers\CRM\BlogCategoryController;
use App\Http\Controllers\CRM\BlogController;
use App\Http\Controllers\CRM\BookingController;
use App\Http\Controllers\CRM\BrandController;
use App\Http\Controllers\CRM\BrandTypeController;
use App\Http\Controllers\CRM\CalculatorSettingsController;
use App\Http\Controllers\CRM\CarCategoryController;
use App\Http\Controllers\CRM\CarController;
use App\Http\Controllers\CRM\CarTypeController;
use App\Http\Controllers\CRM\ContactSourceController;
use App\Http\Controllers\CRM\DashboardController;
use App\Http\Controllers\CRM\EmployeeController;
use App\Http\Controllers\CRM\FaqController;
use App\Http\Controllers\CRM\FeatureController;
use App\Http\Controllers\CRM\GeneralSettingController;
use App\Http\Controllers\CRM\LeadController;
use App\Http\Controllers\CRM\NewsletterSubscriberController;
use App\Http\Controllers\CRM\NotificationController;
use App\Http\Controllers\CRM\OfferController;
use App\Http\Controllers\CRM\PartnerController;
use App\Http\Controllers\CRM\ProfileController;
use App\Http\Controllers\CRM\ProjectDesignController;
use App\Http\Controllers\CRM\ReportController;
use App\Http\Controllers\CRM\RoleController;
use App\Http\Controllers\CRM\SafetyFeatureController;
use App\Http\Controllers\CRM\SearchController;
use App\Http\Controllers\CRM\SpecificationController;
use App\Http\Controllers\CRM\TaskController;
use App\Http\Controllers\CRM\TestimonialController;
use App\Http\Controllers\CRM\TrackingController;

// Unique Secure Login
Route::get('/manager-login', [AuthController::class, 'showLoginForm'])->name('crm.login');
Route::post('/manager-login', [AuthController::class, 'login'])->name('crm.login.post');

Route::prefix('crm')->name('crm.')->middleware(['auth:employee', 'guard.employee'])->group(function () {

    // === Open routes (accessible to all authenticated employees) ===
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/global-search', [SearchController::class, 'globalSearch'])->name('global-search');
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.read-all');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // === المهام ===
    Route::middleware('permission:manage-tasks')->group(function () {
        Route::get('tasks', [TaskController::class, 'index'])->name('tasks.index');
        Route::post('tasks', [TaskController::class, 'store'])->name('tasks.store');
        Route::patch('tasks/{task}/toggle', [TaskController::class, 'toggle'])->name('tasks.toggle');
        Route::delete('tasks/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');
    });

    // === تتبع الحالات (Kanban) ===
    Route::middleware('permission:manage-tracking')->group(function () {
        Route::get('tracking', [TrackingController::class, 'index'])->name('tracking.index');
    });

    // === السيارات ===
    Route::middleware('permission:manage-cars')->group(function () {
        Route::resource('cars', CarController::class);
        Route::get('cars/images/{image}/delete', [CarController::class, 'deleteImage'])->name('cars.delete-image');
    });

    // === المواصفات والمميزات ===
    Route::middleware('permission:manage-specifications')->group(function () {
        Route::resource('specifications', SpecificationController::class);
    });
    Route::middleware('permission:manage-features')->group(function () {
        Route::resource('features', FeatureController::class);
    });
    Route::middleware('permission:manage-safety-features')->group(function () {
        Route::resource('safety-features', SafetyFeatureController::class);
    });

    // === الماركات ===
    Route::middleware('permission:manage-brands')->group(function () {
        Route::get('brands', [BrandController::class, 'index'])->name('brands.index');
        Route::post('brands', [BrandController::class, 'store'])->name('brands.store');
        Route::put('brands/{brand}', [BrandController::class, 'update'])->name('brands.update');
        Route::delete('brands/{brand}', [BrandController::class, 'destroy'])->name('brands.destroy');
    });

    // === أنواع الماركات ===
    Route::middleware('permission:manage-brand-types')->group(function () {
        Route::get('brand-types', [BrandTypeController::class, 'index'])->name('brand-types.index');
        Route::post('brand-types', [BrandTypeController::class, 'store'])->name('brand-types.store');
        Route::put('brand-types/{brandType}', [BrandTypeController::class, 'update'])->name('brand-types.update');
        Route::delete('brand-types/{brandType}', [BrandTypeController::class, 'destroy'])->name('brand-types.destroy');
    });

    // === تصنيفات السيارات ===
    Route::middleware('permission:manage-car-categories')->group(function () {
        Route::get('car-categories', [CarCategoryController::class, 'index'])->name('car-categories.index');
        Route::post('car-categories', [CarCategoryController::class, 'store'])->name('car-categories.store');
        Route::put('car-categories/{carCategory}', [CarCategoryController::class, 'update'])->name('car-categories.update');
        Route::delete('car-categories/{carCategory}', [CarCategoryController::class, 'destroy'])->name('car-categories.destroy');
    });

    // === أنواع السيارات ===
    Route::middleware('permission:manage-car-types')->group(function () {
        Route::get('car-types', [CarTypeController::class, 'index'])->name('car-types.index');
        Route::post('car-types', [CarTypeController::class, 'store'])->name('car-types.store');
        Route::put('car-types/{carType}', [CarTypeController::class, 'update'])->name('car-types.update');
        Route::delete('car-types/{carType}', [CarTypeController::class, 'destroy'])->name('car-types.destroy');
    });

    // === العملاء المحتملون + مصادر التواصل ===
    Route::middleware('permission:manage-leads')->group(function () {
        Route::resource('leads', LeadController::class);
        Route::post('leads/whatsapp-campaign', [LeadController::class, 'whatsappCampaign'])->name('leads.whatsapp-campaign');
    });
    Route::middleware('permission:manage-contact-sources')->group(function () {
        Route::get('contact-sources', [ContactSourceController::class, 'index'])->name('contact-sources.index');
        Route::post('contact-sources', [ContactSourceController::class, 'store'])->name('contact-sources.store');
        Route::put('contact-sources/{contactSource}', [ContactSourceController::class, 'update'])->name('contact-sources.update');
        Route::delete('contact-sources/{contactSource}', [ContactSourceController::class, 'destroy'])->name('contact-sources.destroy');
    });

    // === تقارير منصة الحجز ===
    Route::middleware('permission:manage-reports')->group(function () {
        Route::get('reports/bookings', [ReportController::class, 'bookings'])->name('reports.bookings');
        Route::get('reports/sources', [ReportController::class, 'sources'])->name('reports.sources');
        Route::get('reports/monthly', [ReportController::class, 'monthly'])->name('reports.monthly');
    });

    // === حاسبة التقسيط (إعدادات) ===
    Route::middleware('permission:manage-calculator-settings')->group(function () {
        Route::get('calculator', [CalculatorSettingsController::class, 'index'])->name('calculator.index');
        Route::post('calculator/banks', [CalculatorSettingsController::class, 'storeBank'])->name('calculator.banks.store');
        Route::put('calculator/banks/{calculatorBank}', [CalculatorSettingsController::class, 'updateBank'])->name('calculator.banks.update');
        Route::delete('calculator/banks/{calculatorBank}', [CalculatorSettingsController::class, 'destroyBank'])->name('calculator.banks.destroy');
        Route::post('calculator/factors', [CalculatorSettingsController::class, 'storeFactor'])->name('calculator.factors.store');
        Route::put('calculator/factors/{calculatorFactor}', [CalculatorSettingsController::class, 'updateFactor'])->name('calculator.factors.update');
        Route::delete('calculator/factors/{calculatorFactor}', [CalculatorSettingsController::class, 'destroyFactor'])->name('calculator.factors.destroy');
    });

    // === عملاء الحاسبة ===
    Route::middleware('permission:manage-calculator-leads')->group(function () {
        Route::get('calculator-leads', [\App\Http\Controllers\CRM\CalculatorLeadController::class, 'index'])->name('calculator-leads.index');
        Route::delete('calculator-leads/{calculatorLead}', [\App\Http\Controllers\CRM\CalculatorLeadController::class, 'destroy'])->name('calculator-leads.destroy');
    });

    // === الطلبات (Leads) ===
    Route::middleware('permission:manage-bookings')->group(function () {
        Route::get('bookings', [BookingController::class, 'index'])->name('bookings.index');
        Route::get('bookings/new', [BookingController::class, 'index'])->name('bookings.new')->defaults('status', 'new');
        Route::get('bookings/inprogress', [BookingController::class, 'index'])->name('bookings.inprogress');
        Route::get('bookings/completed', [BookingController::class, 'index'])->name('bookings.completed');
        Route::post('bookings', [BookingController::class, 'store'])->name('bookings.store');
        Route::get('bookings/{booking}', [BookingController::class, 'show'])->name('bookings.show');
        Route::patch('bookings/{booking}/status', [BookingController::class, 'updateStatus'])->name('bookings.status');
        Route::patch('bookings/{booking}/assign', [BookingController::class, 'assign'])->name('bookings.assign');
        Route::post('bookings/{booking}/note', [BookingController::class, 'addNote'])->name('bookings.note');
        Route::post('bookings/{booking}/documents', [BookingController::class, 'uploadDocument'])->name('bookings.documents.store');
        Route::delete('booking-documents/{document}', [BookingController::class, 'deleteDocument'])->name('bookings.documents.destroy');
        Route::delete('bookings/{booking}', [BookingController::class, 'destroy'])->name('bookings.destroy');
    });

    // === الموظفين ===
    Route::middleware('permission:manage-employees')->group(function () {
        Route::get('employees', [EmployeeController::class, 'index'])->name('employees.index');
        Route::post('employees', [EmployeeController::class, 'store'])->name('employees.store');
        Route::put('employees/{employee}', [EmployeeController::class, 'update'])->name('employees.update');
        Route::delete('employees/{employee}', [EmployeeController::class, 'destroy'])->name('employees.destroy');
    });

    // === الصلاحيات والأدوار ===
    Route::middleware('permission:manage-roles')->group(function () {
        Route::resource('roles', RoleController::class);
    });

    // === العروض ===
    Route::middleware('permission:manage-offers')->group(function () {
        Route::get('offers', [OfferController::class, 'index'])->name('offers.index');
        Route::post('offers', [OfferController::class, 'store'])->name('offers.store');
        Route::put('offers/{offer}', [OfferController::class, 'update'])->name('offers.update');
        Route::delete('offers/{offer}', [OfferController::class, 'destroy'])->name('offers.destroy');
    });

    // === المدونة ===
    Route::middleware('permission:manage-blog')->group(function () {
        Route::get('blog', [BlogController::class, 'index'])->name('blog.index');
        Route::get('blog/create', [BlogController::class, 'create'])->name('blog.create');
        Route::post('blog', [BlogController::class, 'store'])->name('blog.store');
        Route::get('blog/{blog}/edit', [BlogController::class, 'edit'])->name('blog.edit');
        Route::put('blog/{blog}', [BlogController::class, 'update'])->name('blog.update');
        Route::delete('blog/{blog}', [BlogController::class, 'destroy'])->name('blog.destroy');
        Route::post('blog/{blog}/toggle-featured', [BlogController::class, 'toggleFeatured'])->name('blog.toggle-featured');

        // Blog Categories
        Route::get('blog-categories', [BlogCategoryController::class, 'index'])->name('blog-categories.index');
        Route::post('blog-categories', [BlogCategoryController::class, 'store'])->name('blog-categories.store');
        Route::put('blog-categories/{blogCategory}', [BlogCategoryController::class, 'update'])->name('blog-categories.update');
        Route::delete('blog-categories/{blogCategory}', [BlogCategoryController::class, 'destroy'])->name('blog-categories.destroy');
    });

    // === إدارة الترجمة ===
    Route::middleware('permission:manage-translations')->group(function () {
        Route::get('translations', [\App\Http\Controllers\CRM\TranslationController::class, 'index'])->name('translations.index');
        Route::post('translations', [\App\Http\Controllers\CRM\TranslationController::class, 'update'])->name('translations.update');
    });

    // === الإعدادات ===
    Route::prefix('settings')->name('settings.')->group(function () {
        Route::middleware('permission:manage-settings')->group(function () {
            Route::get('general', [GeneralSettingController::class, 'index'])->name('general');
            Route::get('seo', [GeneralSettingController::class, 'seo'])->name('seo');
            Route::get('maintenance', [GeneralSettingController::class, 'maintenance'])->name('maintenance');
            Route::post('update', [GeneralSettingController::class, 'update'])->name('update');
        });
        Route::middleware('permission:manage-settings-integrations')->group(function () {
            Route::get('integrations', [GeneralSettingController::class, 'integrations'])->name('integrations');
        });

        // الأسئلة الشائعة
        Route::middleware('permission:manage-faqs')->group(function () {
            Route::get('faqs', [FaqController::class, 'index'])->name('faqs.index');
            Route::post('faqs', [FaqController::class, 'store'])->name('faqs.store');
            Route::put('faqs/{faq}', [FaqController::class, 'update'])->name('faqs.update');
            Route::delete('faqs/{faq}', [FaqController::class, 'destroy'])->name('faqs.destroy');
        });

        // التوصيات
        Route::middleware('permission:manage-testimonials')->group(function () {
            Route::resource('testimonials', TestimonialController::class);
        });

        // الشركاء
        Route::middleware('permission:manage-partners')->group(function () {
            Route::resource('partners', PartnerController::class);
        });

        // التصميمات
        Route::middleware('permission:manage-designs')->group(function () {
            Route::resource('designs', ProjectDesignController::class);
            Route::post('designs/{projectDesign}/toggle-featured', [ProjectDesignController::class, 'toggleFeatured'])->name('designs.toggle-featured');
        });
    });

    // === المشتركون في النشرة الإخبارية ===
    Route::middleware('permission:manage-newsletter')->group(function () {
        Route::get('newsletter-subscribers', [NewsletterSubscriberController::class, 'index'])->name('newsletter.index');
        Route::delete('newsletter-subscribers/{subscriber}', [NewsletterSubscriberController::class, 'destroy'])->name('newsletter.destroy');
        Route::patch('newsletter-subscribers/{subscriber}/toggle', [NewsletterSubscriberController::class, 'toggle'])->name('newsletter.toggle');
        Route::get('newsletter-subscribers/export', [NewsletterSubscriberController::class, 'export'])->name('newsletter.export');
    });
});

// =============================================
//  Redirects & Fallback
// =============================================
// إعادة توجيه /erp إلى /crm لأي روابط قديمة
Route::get('/erp/{any?}', function () {
    return redirect('/gr-manager-login', 301);
})->where('any', '.*');

// Fallback 404
Route::fallback(function () {
    abort(404);
});
