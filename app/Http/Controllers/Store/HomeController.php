<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Services\Cache\HomeCacheService;

class HomeController extends Controller
{
    public function __construct(
        private readonly HomeCacheService $cache,
    ) {}

    public function index()
    {
        $data = $this->cache->rememberHomeData();

        extract($data);

        $heroSetting = $this->cache->rememberSetting('store_home_hero');
        $hero = $heroSetting ?: [
            'title' => 'قيادة الأحلام <span class="highlight">تبدأ من هنا</span>',
            'subtitle' => 'اكتشف مجموعتنا الحصرية من السيارات الفاخرة بأفضل الأسعار وخطط التقسيط.',
            'image' => null,
        ];

        $heroVideo = $this->cache->rememberSetting('hero_video');
        $heroAd1Image = $this->cache->rememberSetting('hero_ad_1_image');
        $heroAd2Image = $this->cache->rememberSetting('hero_ad_2_image');
        $heroAd1Link = $this->cache->rememberSetting('hero_ad_1_link');
        $heroAd2Link = $this->cache->rememberSetting('hero_ad_2_link');

        $heroAd1 = ['image' => $heroAd1Image, 'link' => $heroAd1Link];
        $heroAd2 = ['image' => $heroAd2Image, 'link' => $heroAd2Link];

        $promoPopup = $this->cache->rememberSetting('promo_popup');

        return view('store.home', compact(
            'featuredCars', 'activeOffers', 'brands', 'latestPosts', 'stats',
            'testimonials', 'partners', 'featuredDesign', 'socialDesigns', 'hero',
            'filterBrands', 'filterCategories', 'filterYears', 'bentoCars',
            'heroVideo', 'heroAd1', 'heroAd2', 'featuredOffers', 'highlightedCars',
            'heroSlides', 'promoPopup',
        ));
    }
}
