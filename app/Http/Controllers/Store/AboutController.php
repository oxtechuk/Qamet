<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\Partner;
use App\Models\Testimonial;
use App\Services\Cache\AboutCacheService;

class AboutController extends Controller
{
    public function __construct(
        private readonly AboutCacheService $cache,
    ) {}

    public function __invoke()
    {
        $testimonials = Testimonial::where('is_visible', true)->get();
        $partners = Partner::orderBy('sort_order')->get();

        $bentoCars = Car::where('is_active', true)
            ->where(function ($q) {
                $q->where('is_featured', true)->orWhereHas('offers');
            })
            ->with('brand')
            ->latest()
            ->take(5)
            ->get();

        $mainGallery = $this->cache->rememberMainGallery();

        return view('store.about', compact('testimonials', 'partners', 'bentoCars', 'mainGallery'));
    }
}
