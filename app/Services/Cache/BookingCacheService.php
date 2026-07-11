<?php

namespace App\Services\Cache;

class BookingCacheService extends BaseCacheService
{
    public function rememberBookingHero(): array
    {
        return $this->rememberHeroSetting('store_booking_hero');
    }

    public function rememberBookingSteps(): array
    {
        $raw = $this->rememberSetting('store_booking_steps', []);

        return is_array($raw) ? $raw : (json_decode((string) $raw, true) ?: []);
    }

    public function rememberBookingSections(): array
    {
        $raw = $this->rememberSetting('store_booking_sections', []);

        return is_array($raw) ? $raw : (json_decode((string) $raw, true) ?: []);
    }
}
