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
        $coreValues = $this->localizeItems($this->cache->rememberAboutCoreValues(), $locale);
        $whyChooseUs = $this->localizeItems($this->cache->rememberAboutWhyChooseUs(), $locale);

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
            'values' => [
                'badge' => $rawSections['values']['badge'][$locale] ?? '',
                'title' => $rawSections['values']['title'][$locale] ?? '',
            ],
            'partners' => [
                'badge' => $rawSections['partners']['badge'][$locale] ?? '',
                'title' => $rawSections['partners']['title'][$locale] ?? '',
                'subtitle' => $rawSections['partners']['subtitle'][$locale] ?? '',
            ],
            'why_choose_us' => [
                'title' => $rawSections['why_choose_us']['title'][$locale] ?? '',
                'subtitle' => $rawSections['why_choose_us']['subtitle'][$locale] ?? '',
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
            'about_core_values' => $coreValues,
            'about_why_choose_us' => $whyChooseUs,
            'page_sections' => $pageSections,
        ];
    }

    /**
     * @param  array<int, array{icon?: string, title?: array<string, string>, description?: array<string, string>}>  $items
     * @return array<int, array{icon: string, title: string, description: string}>
     */
    private function localizeItems(array $items, string $locale): array
    {
        return array_map(fn (array $item): array => [
            'icon' => $item['icon'] ?? '',
            'title' => $item['title'][$locale] ?? ($item['title']['en'] ?? ''),
            'description' => $item['description'][$locale] ?? ($item['description']['en'] ?? ''),
        ], $items);
    }
}
