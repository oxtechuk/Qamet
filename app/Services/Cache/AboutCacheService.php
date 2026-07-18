<?php

namespace App\Services\Cache;

use App\Models\CoreValue;
use App\Models\GalleryItem;
use App\Models\Testimonial;
use App\Models\WhyChooseUsItem;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

class AboutCacheService extends BaseCacheService
{
    /**
     * @return array<string, mixed>
     */
    public function rememberHero(): array
    {
        $hero = $this->rememberSetting('about_hero', []);

        return is_array($hero) ? $hero : (json_decode((string) $hero, true) ?: []);
    }

    /**
     * @return array<string, mixed>
     */
    public function rememberCompanyStory(): array
    {
        $story = $this->rememberSetting('about_story', []);

        return is_array($story) ? $story : (json_decode((string) $story, true) ?: []);
    }

    /**
     * @return array<string, mixed>
     */
    public function rememberValuesSection(): array
    {
        $section = $this->rememberSetting('about_values_section', []);

        return is_array($section) ? $section : (json_decode((string) $section, true) ?: []);
    }

    /**
     * @return array<string, mixed>
     */
    public function rememberWhyChooseUsSection(): array
    {
        $section = $this->rememberSetting('about_why_choose_us_section', []);

        return is_array($section) ? $section : (json_decode((string) $section, true) ?: []);
    }

    public function rememberCoreValues(): Collection
    {
        return $this->remember('about.core_values', fn () => CoreValue::where('is_active', true)->orderBy('sort_order')->get());
    }

    public function rememberWhyChooseUs(): Collection
    {
        return $this->remember('about.why_choose_us', fn () => WhyChooseUsItem::where('is_active', true)->orderBy('sort_order')->get());
    }

    public function rememberGallery(): Collection
    {
        return $this->remember('about.gallery', fn () => GalleryItem::where('is_active', true)->orderBy('sort_order')->get());
    }

    public function rememberTestimonials(): Collection
    {
        return $this->remember('about.testimonials', fn () => Testimonial::where('is_visible', true)->get());
    }

    public function forgetCoreValues(): void
    {
        Cache::forget('about.core_values');
    }

    public function forgetWhyChooseUs(): void
    {
        Cache::forget('about.why_choose_us');
    }

    public function forgetGallery(): void
    {
        Cache::forget('about.gallery');
    }

    public function forgetTestimonials(): void
    {
        Cache::forget('about.testimonials');
    }
}
