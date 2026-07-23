<?php

declare(strict_types=1);

namespace App\Services\Api\Store;

use App\Http\Resources\Store\CoreValueResource;
use App\Http\Resources\Store\GalleryItemResource;
use App\Http\Resources\Store\TestimonialCardResource;
use App\Http\Resources\Store\WhyChooseUsResource;
use App\Services\Cache\AboutCacheService;
use Illuminate\Support\Facades\Storage;

final class AboutApiService
{
    public function __construct(
        private readonly AboutCacheService $cache,
    ) {}

    public function about(): array
    {
        $locale = app()->getLocale();

        return [
            'hero' => $this->buildHero($locale),
            'core_values' => [
                'section' => $this->sectionCopy($this->cache->rememberValuesSection(), $locale),
                'items' => CoreValueResource::collection($this->cache->rememberCoreValues())->resolve(),
            ],
            'company_story' => $this->buildCompanyStory($locale),
            'why_choose_us' => [
                'section' => $this->sectionCopy($this->cache->rememberWhyChooseUsSection(), $locale),
                'items' => WhyChooseUsResource::collection($this->cache->rememberWhyChooseUs())->resolve(),
            ],
            'gallery' => GalleryItemResource::collection($this->cache->rememberGallery())->resolve(),
            'testimonials' => TestimonialCardResource::collection($this->cache->rememberTestimonials())->resolve(),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    private function buildHero(string $locale): array
    {
        $hero = $this->cache->rememberHero();

        return [
            'badge' => $hero['badge'][$locale] ?? $hero['badge']['en'] ?? '',
            'title' => $hero['title'][$locale] ?? $hero['title']['en'] ?? '',
            'subtitle' => $hero['subtitle'][$locale] ?? $hero['subtitle']['en'] ?? '',
            'image' => $this->resolveImage($hero['image'] ?? null),
            'mobile_image' => $this->resolveImage($hero['mobile_image'] ?? null),
            'cta_text' => $hero['cta_text'][$locale] ?? $hero['cta_text']['en'] ?? '',
            'cta_url' => $hero['cta_url'] ?? null,
        ];
    }

    /**
     * @return array<string, mixed>
     */
    private function buildCompanyStory(string $locale): array
    {
        $story = $this->cache->rememberCompanyStory();

        return [
            'title' => $story['title'][$locale] ?? $story['title']['en'] ?? '',
            'description' => $story['description'][$locale] ?? $story['description']['en'] ?? '',
            'mission_title' => $story['mission_title'][$locale] ?? $story['mission_title']['en'] ?? '',
            'mission_text' => $story['mission_text'][$locale] ?? $story['mission_text']['en'] ?? '',
            'vision_title' => $story['vision_title'][$locale] ?? $story['vision_title']['en'] ?? '',
            'vision_text' => $story['vision_text'][$locale] ?? $story['vision_text']['en'] ?? '',
            'image' => $this->resolveImage($story['image'] ?? null),
        ];
    }

    /**
     * @param  array<string, mixed>  $section
     * @return array<string, string>
     */
    private function sectionCopy(array $section, string $locale): array
    {
        return [
            'title' => $section['title'][$locale] ?? $section['title']['en'] ?? '',
            'subtitle' => $section['subtitle'][$locale] ?? $section['subtitle']['en'] ?? '',
        ];
    }

    private function resolveImage(?string $path): ?string
    {
        if ($path === null) {
            return null;
        }

        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        return Storage::disk('public')->url($path);
    }
}
