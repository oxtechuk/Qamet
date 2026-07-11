<?php

namespace App\Providers;

use App\Models\BlogPost;
use App\Models\Brand;
use App\Models\CalculatorBank;
use App\Models\CalculatorFactor;
use App\Models\Car;
use App\Models\CarCategory;
use App\Models\Feature;
use App\Models\Offer;
use App\Models\Partner;
use App\Models\Setting;
use App\Models\Specification;
use App\Models\Testimonial;
use App\Observers\BlogPostObserver;
use App\Observers\BrandObserver;
use App\Observers\CalculatorBankObserver;
use App\Observers\CalculatorFactorObserver;
use App\Observers\CarCategoryObserver;
use App\Observers\CarObserver;
use App\Observers\FeatureObserver;
use App\Observers\OfferObserver;
use App\Observers\PartnerObserver;
use App\Observers\SettingObserver;
use App\Observers\SpecificationObserver;
use App\Observers\TestimonialObserver;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        try {
            View::share([
                'globalSettings' => app(\App\Services\Cache\BaseCacheService::class)->rememberSettings(),
            ]);
        } catch (\Throwable $e) {
            View::share([
                'globalSettings' => [],
            ]);
        }

        $this->registerObservers();

        // Fix for MySQL older versions (index key length)
        Schema::defaultStringLength(191);

        // Force HTTPS if APP_URL starts with https
        if (str_contains(config('app.url'), 'https')) {
            URL::forceScheme('https');
        }
    }

    private function registerObservers(): void
    {
        Car::observe(CarObserver::class);
        Brand::observe(BrandObserver::class);
        BlogPost::observe(BlogPostObserver::class);
        Setting::observe(SettingObserver::class);
        Offer::observe(OfferObserver::class);
        CarCategory::observe(CarCategoryObserver::class);
        Feature::observe(FeatureObserver::class);
        Specification::observe(SpecificationObserver::class);
        Testimonial::observe(TestimonialObserver::class);
        Partner::observe(PartnerObserver::class);
        CalculatorBank::observe(CalculatorBankObserver::class);
        CalculatorFactor::observe(CalculatorFactorObserver::class);
    }
}
