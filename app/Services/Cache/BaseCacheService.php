<?php

namespace App\Services\Cache;

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class BaseCacheService
{
    protected const TTL_DEFAULT = 3600;

    protected const TTL_LONG = 86400;

    protected function remember(string $key, callable $callback, int $ttl = self::TTL_DEFAULT): mixed
    {
        return Cache::remember($key, $ttl, $callback);
    }

    public function rememberSettings(): mixed
    {
        return $this->remember('settings.all', function () {
            return Setting::all()->pluck('value', 'key');
        }, self::TTL_LONG);
    }

    public function rememberSetting(string $key, mixed $default = null): mixed
    {
        $settings = $this->rememberSettings();

        return $settings[$key] ?? $default;
    }

    public function rememberHeroSetting(string $key): array
    {
        $hero = $this->remember("settings.hero.{$key}", function () use ($key) {
            $heroSetting = Setting::where('key', $key)->first();

            return $heroSetting ? $heroSetting->value : [
                'title' => '',
                'subtitle' => '',
                'image' => null,
            ];
        }, self::TTL_LONG);

        $locale = app()->getLocale();

        return [
            'title' => $this->localizeHeroField($hero['title'] ?? '', $locale),
            'subtitle' => $this->localizeHeroField($hero['subtitle'] ?? '', $locale),
            'image' => $this->resolveHeroImage($hero['image'] ?? null),
        ];
    }

    private function localizeHeroField(mixed $value, string $locale): string
    {
        if (! is_array($value)) {
            return (string) $value;
        }

        return $value[$locale] ?? $value['en'] ?? $value['ar'] ?? '';
    }

    private function resolveHeroImage(?string $path): ?string
    {
        if (empty($path)) {
            return null;
        }

        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        return Storage::disk('public')->url($path);
    }

    public function rememberHeroSlides(): array
    {
        return $this->remember('settings.hero_slides', function () {
            $setting = Setting::where('key', 'hero_slides')->first();

            if (! $setting || empty($setting->value)) {
                return [];
            }

            return is_array($setting->value)
                ? $setting->value
                : (json_decode($setting->value, true) ?: []);
        }, self::TTL_LONG);
    }

    public function rememberCarHeroSlides(): array
    {
        return $this->remember('settings.car_hero_slides', function () {
            $setting = Setting::where('key', 'car_hero_slides')->first();

            if (! $setting || empty($setting->value)) {
                return [];
            }

            return is_array($setting->value)
                ? $setting->value
                : (json_decode($setting->value, true) ?: []);
        }, self::TTL_LONG);
    }

    public function forgetSettings(): void
    {
        Cache::forget('settings.all');
    }

    public function flushAll(): void
    {
        Cache::flush();
    }
}
