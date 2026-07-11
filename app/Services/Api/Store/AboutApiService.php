<?php

declare(strict_types=1);

namespace App\Services\Api\Store;

use App\Models\Partner;
use App\Models\Testimonial;
use App\Services\Cache\AboutCacheService;

final class AboutApiService
{
    public function __construct(
        private readonly AboutCacheService $cache,
    ) {}

    public function about(): array
    {
        $testimonials = Testimonial::where('is_visible', true)->get();
        $partners = Partner::orderBy('sort_order')->get();
        $mainGallery = $this->cache->rememberMainGallery();

        $locale = app()->getLocale();
        $rawSections = $this->cache->rememberAboutSections();
        $aboutStats = $this->cache->rememberAboutStats();
        $aboutBranches = $this->cache->rememberAboutBranches();

        $pageSections = [
            'hero' => [
                'badge' => $rawSections['hero']['badge'][$locale] ?? '',
                'title' => $rawSections['hero']['title'][$locale] ?? '',
                'subtitle' => $rawSections['hero']['subtitle'][$locale] ?? '',
            ],
            'story' => [
                'title' => $rawSections['story']['title'][$locale] ?? '',
                'content' => $rawSections['story']['content'][$locale] ?? '',
                'mission_title' => $rawSections['story']['mission_title'][$locale] ?? '',
                'mission_text' => $rawSections['story']['mission_text'][$locale] ?? '',
                'vision_title' => $rawSections['story']['vision_title'][$locale] ?? '',
                'vision_text' => $rawSections['story']['vision_text'][$locale] ?? '',
            ],
            'partners' => [
                'badge' => $rawSections['partners']['badge'][$locale] ?? '',
                'title' => $rawSections['partners']['title'][$locale] ?? '',
                'subtitle' => $rawSections['partners']['subtitle'][$locale] ?? '',
            ],
            'dealer' => [
                'title' => $rawSections['dealer']['title'][$locale] ?? '',
                'description' => $rawSections['dealer']['description'][$locale] ?? '',
                'partner_button_text' => $rawSections['dealer']['partner_button_text'][$locale] ?? '',
                'partner_button_link' => $rawSections['dealer']['partner_button_link'] ?? '',
                'contact_button_text' => $rawSections['dealer']['contact_button_text'][$locale] ?? '',
            ],
            'locations' => [
                'title' => $rawSections['locations']['title'][$locale] ?? '',
            ],
            'testimonials' => [
                'badge' => $rawSections['testimonials']['badge'][$locale] ?? '',
                'title' => $rawSections['testimonials']['title'][$locale] ?? '',
                'rating_text' => $rawSections['testimonials']['rating_text'][$locale] ?? '',
            ],
        ];

        return [
            'testimonials' => $testimonials,
            'partners' => $partners,
            'main_gallery' => $mainGallery,
            'about_stats' => $aboutStats,
            'about_branches' => $aboutBranches,
            'page_sections' => $pageSections,
        ];
    }
}
