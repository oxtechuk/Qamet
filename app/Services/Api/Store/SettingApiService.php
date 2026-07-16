<?php

declare(strict_types=1);

namespace App\Services\Api\Store;

use App\Services\Cache\AboutCacheService;
use App\Services\Cache\BaseCacheService;
use App\Services\Cache\BlogCacheService;
use App\Services\Cache\BookingCacheService;
use App\Services\Cache\CarCacheService;
use App\Services\Cache\ContactCacheService;
use App\Services\Cache\HomeCacheService;
use App\Services\Cache\OfferCacheService;
use Illuminate\Support\Facades\Storage;

final class SettingApiService
{
    private const SECRET_KEYS = [
        'twilio_sid',
        'twilio_auth_token',
        'twilio_whatsapp_number',
        'twilio_sms_number',
        'whatsapp_template_new_lead',
        'whatsapp_template_status_update',
        'gemini_api_key',
    ];

    private const IMAGE_KEYS = [
        'site_logo', 'site_favicon', 'breadcrumb_bg', 'hero_video',
        'hero_ad_1_image', 'hero_ad_2_image', 'page_loader_image',
        'store_img_hero_mask', 'store_img_hero_card_1', 'store_img_hero_card_3',
        'store_img_business_1', 'store_img_offer_banner_left',
    ];

    private const ARRAY_IMAGE_KEYS = [
        'main_gallery',
    ];

    private const NESTED_IMAGE_KEYS = [
        'hero_slides',
        'promo_popup',
        'offer_hero_slides',
    ];

    public function __construct(
        private readonly BaseCacheService $cache,
        private readonly HomeCacheService $homeCache,
        private readonly AboutCacheService $aboutCache,
        private readonly BookingCacheService $bookingCache,
        private readonly OfferCacheService $offerCache,
        private readonly BlogCacheService $blogCache,
        private readonly ContactCacheService $contactCache,
        private readonly CarCacheService $carCache,
    ) {}

    public function footer(): array
    {
        $settings = $this->cache->rememberSettings();

        $locale = app()->getLocale();

        $siteName = $settings->get('site_name', '');
        if (is_array($siteName)) {
            $siteName = $siteName[$locale] ?? ($siteName['ar'] ?? '');
        }

        $footerText = $settings->get('footer_text', '');

        $socialMedia = $settings->get('social_media', []);
        if (is_string($socialMedia)) {
            $socialMedia = json_decode($socialMedia, true) ?: [];
        }

        return [
            'logo' => $this->resolveUrl($settings->get('site_logo')),
            'favicon' => $this->resolveUrl($settings->get('site_favicon')),
            'site_name' => $siteName,
            'footer_text' => $footerText,
            'contact' => [
                'email' => $settings->get('contact_email', ''),
                'phone' => $settings->get('contact_phone', ''),
                'whatsapp' => $settings->get('contact_whatsapp', ''),
                'address' => $settings->get('contact_address', ''),
                'sales_phone' => $settings->get('sales_phone', ''),
                'finance_phone' => $settings->get('finance_phone', ''),
                'aftersales_phone' => $settings->get('aftersales_phone', ''),
            ],
            'working_hours' => [
                'from' => $settings->get('working_hours_from', '09:00'),
                'to' => $settings->get('working_hours_to', '21:00'),
                'days' => $settings->get('working_days', ['sat', 'sun', 'mon', 'tue', 'wed', 'thu']),
            ],
            'social_media' => $socialMedia,
        ];
    }

    public function structured(): array
    {
        $settings = $this->cache->rememberSettings();
        $locale = app()->getLocale();

        return [
            'site' => [
                'name' => $this->resolveBilingual($settings->get('site_name', []), $locale),
                'description' => $this->resolveBilingual($settings->get('site_description', []), $locale),
                'logo' => $this->resolveUrl($settings->get('site_logo')),
                'favicon' => $this->resolveUrl($settings->get('site_favicon')),
                'currency' => $settings->get('currency', 'SAR'),
                'locale' => $settings->get('locale', 'ar'),
                'footer_text' => $settings->get('footer_text', ''),
                'breadcrumb_bg' => $this->resolveUrl($settings->get('breadcrumb_bg')),
                'hero_video' => $this->resolveUrl($settings->get('hero_video')),
                'page_loader' => [
                    'enabled' => (bool) $settings->get('page_loader_enabled', false),
                    'image' => $this->resolveUrl($settings->get('page_loader_image')),
                ],
            ],
            'contact' => [
                'email' => $settings->get('support_email', ''),
                'phone' => $settings->get('support_phone', ''),
                'whatsapp' => $settings->get('whatsapp_number', ''),
                'address' => $this->resolveBilingual($settings->get('address', []), $locale),
                'sales_phone' => $settings->get('sales_phone', ''),
                'finance_phone' => $settings->get('finance_phone', ''),
                'aftersales_phone' => $settings->get('aftersales_phone', ''),
            ],
            'working_hours' => [
                'from' => $settings->get('working_hours_from', '09:00'),
                'to' => $settings->get('working_hours_to', '21:00'),
                'days' => $settings->get('working_days', ['sat', 'sun', 'mon', 'tue', 'wed', 'thu']),
            ],
            'social_links' => $this->resolveSocialLinks($settings->get('social_links', [])),
            'seo' => [
                'meta_title' => $this->resolveBilingual($settings->get('meta_title', []), $locale),
                'meta_description' => $this->resolveBilingual($settings->get('meta_description', []), $locale),
                'google_analytics_id' => $settings->get('google_analytics_id', ''),
                'facebook_pixel_id' => $settings->get('facebook_pixel_id', ''),
            ],
            'calculator' => [
                'max_car_price' => (int) ($settings->get('max_car_price', 2500000)),
                'max_down_payment' => (int) ($settings->get('max_down_payment', 80)),
            ],
            'offers_slider' => $this->resolveOfferSlides($settings->get('offer_hero_slides', [])),
            'maintenance' => [
                'enabled' => (bool) $settings->get('maintenance_mode', false),
                'message' => $this->resolveBilingual($settings->get('maintenance_message', []), $locale),
            ],
            'promo_popup' => $this->resolvePromoPopup($settings->get('promo_popup', [])),
            'pages' => [
                'home' => $this->resolveHomePage($settings, $locale),
                'about' => $this->resolveAboutPage($settings, $locale),
                'booking' => $this->resolveBookingPage($settings, $locale),
                'cars' => $this->resolveCarsPage($settings, $locale),
                'offers' => $this->resolveOffersPage($settings, $locale),
                'contact' => $this->resolveContactPage($settings, $locale),
                'blog' => $this->resolveBlogPage($settings, $locale),
            ],
            'gallery' => $this->resolveGallery($settings->get('main_gallery', [])),
        ];
    }

    public function financeSolution(): array
    {
        $settings = $this->cache->rememberSettings();
        $locale = app()->getLocale();

        $rawSections = $settings->get('homepage_sections', []);
        if (is_string($rawSections)) {
            $rawSections = json_decode($rawSections, true) ?: [];
        }

        $finance = $rawSections['finance'] ?? [];

        $financeStats = $settings->get('finance_stats', []);
        if (is_string($financeStats)) {
            $financeStats = json_decode($financeStats, true) ?: [];
        }

        return [
            'finance' => [
                'badge' => $finance['badge'][$locale] ?? '',
                'title' => $finance['title'][$locale] ?? '',
                'subtitle' => $finance['subtitle'][$locale] ?? '',
                'features' => array_values(array_filter(array_map('trim', explode("\n", $finance['features'][$locale] ?? '')))),
                'button_text' => $finance['button_text'][$locale] ?? '',
            ],
            'stats' => array_map(fn (array $stat): array => [
                'label' => $stat['label'] ?? '',
                'value' => $stat['value'] ?? '',
            ], $financeStats),
        ];
    }

    public function list(?array $keys = null): array
    {
        $settings = $this->cache->rememberSettings();

        if ($keys) {
            $keys = array_map(fn ($key) => trim((string) $key), $keys);
            $result = [];

            foreach ($keys as $key) {
                if ($settings->has($key)) {
                    $result[$key] = $settings->get($key);
                }
            }

            return $this->resolveImages($this->stripSecrets($result));
        }

        return $this->resolveImages($this->stripSecrets($settings->toArray()));
    }

    private function stripSecrets(array $data): array
    {
        foreach (self::SECRET_KEYS as $key) {
            unset($data[$key]);
        }

        return $data;
    }

    private function resolveImages(array $data): array
    {
        foreach (self::IMAGE_KEYS as $key) {
            if (isset($data[$key]) && is_string($data[$key])) {
                $data[$key] = $this->resolveUrl($data[$key]);
            }
        }

        foreach (self::ARRAY_IMAGE_KEYS as $key) {
            if (isset($data[$key]) && is_array($data[$key])) {
                $data[$key] = array_map(fn ($path) => $this->resolveUrl($path), $data[$key]);
            }
        }

        foreach (self::NESTED_IMAGE_KEYS as $key) {
            if (isset($data[$key]) && is_array($data[$key])) {
                $data[$key] = $this->resolveNestedImages($data[$key]);
            }
        }

        return $data;
    }

    private function resolveNestedImages(array $items): array
    {
        // promo_popup is a single object
        if (array_is_list($items)) {
            return array_map(fn (array $item) => $this->resolveItemImage($item), $items);
        }

        return $this->resolveItemImage($items);
    }

    private function resolveItemImage(array $item): array
    {
        if (isset($item['image']) && is_string($item['image'])) {
            $item['image'] = $this->resolveUrl($item['image']);
        }

        return $item;
    }

    private function resolveUrl(?string $path): ?string
    {
        if ($path === null) {
            return null;
        }

        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        return Storage::disk('public')->url($path);
    }

    private function resolveBilingual(mixed $value, string $locale): mixed
    {
        if (is_array($value) && isset($value[$locale])) {
            return $value[$locale];
        }

        return $value;
    }

    private function resolveSocialLinks(mixed $value): array
    {
        if (is_string($value)) {
            $value = json_decode($value, true) ?: [];
        }

        if (! is_array($value)) {
            return [];
        }

        return array_map(fn (array $item): array => [
            'platform' => $item['platform'] ?? $item['icon'] ?? '',
            'url' => $item['url'] ?? $item['link'] ?? '',
            'color' => $item['color'] ?? null,
        ], $value);
    }

    private function resolveOfferSlides(mixed $value): array
    {
        if (is_string($value)) {
            $value = json_decode($value, true) ?: [];
        }

        if (! is_array($value)) {
            return [];
        }

        return array_map(fn (array $item): array => [
            'image' => $this->resolveUrl($item['image'] ?? null),
            'link' => $item['link'] ?? null,
            'title' => $item['title'] ?? null,
            'button_text' => $item['button_text'] ?? null,
        ], $value);
    }

    private function resolveHero(mixed $value, string $locale): array
    {
        if (is_string($value)) {
            $value = json_decode($value, true) ?: [];
        }

        if (! is_array($value)) {
            return ['title' => '', 'subtitle' => '', 'image' => null];
        }

        return [
            'title' => $this->resolveBilingual($value['title'] ?? '', $locale),
            'subtitle' => $this->resolveBilingual($value['subtitle'] ?? '', $locale),
            'image' => $this->resolveUrl($value['image'] ?? null),
        ];
    }

    private function resolvePromoPopup(mixed $value): array
    {
        if (is_string($value)) {
            $value = json_decode($value, true) ?: [];
        }

        if (! is_array($value)) {
            return ['enabled' => false];
        }

        return [
            'enabled' => (bool) ($value['enabled'] ?? false),
            'image' => $this->resolveUrl($value['image'] ?? null),
            'title' => $value['title'] ?? null,
            'text' => $value['text'] ?? null,
            'link' => $value['link'] ?? null,
            'button_text' => $value['button_text'] ?? null,
        ];
    }

    private function resolveGallery(mixed $value): array
    {
        if (is_string($value)) {
            $value = json_decode($value, true) ?: [];
        }

        if (! is_array($value)) {
            return [];
        }

        return array_map(fn ($path) => $this->resolveUrl($path), $value);
    }

    private function resolveBilingualArray(mixed $value, string $locale): array
    {
        if (is_string($value)) {
            $value = json_decode($value, true) ?: [];
        }

        if (! is_array($value)) {
            return [];
        }

        $result = [];
        foreach ($value as $key => $item) {
            if (is_array($item) && isset($item[$locale])) {
                $result[$key] = $item[$locale];
            } elseif (is_array($item)) {
                $result[$key] = $this->resolveBilingualArray($item, $locale);
            } else {
                $result[$key] = $item;
            }
        }

        return $result;
    }

    private function resolveStats(mixed $value): array
    {
        if (is_string($value)) {
            $value = json_decode($value, true) ?: [];
        }

        if (! is_array($value)) {
            return [];
        }

        return array_map(fn (array $stat): array => [
            'value' => $stat['value'] ?? '',
            'label' => $stat['label'] ?? '',
        ], $value);
    }

    private function resolveSteps(mixed $value, string $locale): array
    {
        if (is_string($value)) {
            $value = json_decode($value, true) ?: [];
        }

        if (! is_array($value)) {
            return [];
        }

        return array_map(fn (array $step): array => [
            'icon' => $step['icon'] ?? null,
            'title' => $this->resolveBilingual($step['title'] ?? '', $locale),
            'description' => $this->resolveBilingual($step['description'] ?? '', $locale),
        ], $value);
    }

    private function resolveBranches(mixed $value): array
    {
        if (is_string($value)) {
            $value = json_decode($value, true) ?: [];
        }

        if (! is_array($value)) {
            return [];
        }

        return array_map(fn (array $branch): array => [
            'city' => $branch['city'] ?? '',
            'name' => $branch['name'] ?? '',
            'address' => $branch['address'] ?? '',
            'phone' => $branch['phone'] ?? '',
            'working_hours' => $branch['working_hours'] ?? '',
            'map_link' => $branch['map_link'] ?? null,
        ], $value);
    }

    private function resolveItems(mixed $value, string $locale): array
    {
        if (is_string($value)) {
            $value = json_decode($value, true) ?: [];
        }

        if (! is_array($value)) {
            return [];
        }

        return array_map(fn (array $item): array => [
            'icon' => $item['icon'] ?? null,
            'title' => $this->resolveBilingual($item['title'] ?? '', $locale),
            'description' => $this->resolveBilingual($item['description'] ?? '', $locale),
        ], $value);
    }

    private function resolveHomePage(mixed $settings, string $locale): array
    {
        $heroSlides = $this->resolveNestedImages($this->toarray($settings->get('hero_slides', [])));
        $homeHero = $this->resolveHero($settings->get('store_home_hero', []), $locale);
        $stats = $this->resolveStats($settings->get('homepage_stats', []));
        $featured = $this->resolveBilingualArray($settings->get('homepage_featured', []), $locale);
        $sections = $this->resolveBilingualArray($settings->get('homepage_sections', []), $locale);

        return [
            'hero' => $homeHero,
            'hero_slides' => array_map(fn (array $slide): array => [
                'image' => $this->resolveUrl($slide['image'] ?? null),
                'link' => $slide['link'] ?? null,
                'button_text' => $slide['button_text'] ?? null,
            ], $heroSlides),
            'sections' => $sections,
            'stats' => $stats,
            'featured' => $featured,
            'bento_cars' => $settings->get('bento_cars', []),
        ];
    }

    private function resolveAboutPage(mixed $settings, string $locale): array
    {
        return [
            'hero' => $this->resolveHero($settings->get('store_about_hero', []), $locale),
            'sections' => $this->resolveBilingualArray($settings->get('about_sections', []), $locale),
            'stats' => $this->resolveStats($settings->get('about_stats', [])),
            'branches' => $this->resolveBranches($settings->get('about_branches', [])),
            'core_values' => $this->resolveItems($settings->get('about_core_values', []), $locale),
            'why_choose_us' => $this->resolveItems($settings->get('about_why_choose_us', []), $locale),
        ];
    }

    private function resolveBookingPage(mixed $settings, string $locale): array
    {
        return [
            'hero' => $this->resolveHero($settings->get('store_booking_hero', []), $locale),
            'steps' => $this->resolveSteps($settings->get('store_booking_steps', []), $locale),
            'sections' => $this->resolveBilingualArray($settings->get('store_booking_sections', []), $locale),
        ];
    }

    private function resolveCarsPage(mixed $settings, string $locale): array
    {
        return [
            'hero' => $this->resolveHero($settings->get('store_hero', []), $locale),
            'hero_ad_1' => [
                'image' => $this->resolveUrl($settings->get('hero_ad_1_image')),
                'link' => $settings->get('hero_ad_1_link', ''),
            ],
            'hero_ad_2' => [
                'image' => $this->resolveUrl($settings->get('hero_ad_2_image')),
                'link' => $settings->get('hero_ad_2_link', ''),
            ],
        ];
    }

    private function resolveOffersPage(mixed $settings, string $locale): array
    {
        return [
            'hero' => $this->resolveHero($settings->get('store_offers_hero', []), $locale),
            'hero_slides' => $this->resolveOfferSlides($settings->get('offer_hero_slides', [])),
        ];
    }

    private function resolveContactPage(mixed $settings, string $locale): array
    {
        return [
            'hero' => $this->resolveHero($settings->get('store_contact_hero', []), $locale),
        ];
    }

    private function resolveBlogPage(mixed $settings, string $locale): array
    {
        return [
            'hero' => $this->resolveHero($settings->get('store_blog_hero', []), $locale),
        ];
    }
}
