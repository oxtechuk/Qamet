<?php

namespace App\Services\Cache;

use App\Models\Branch;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

class ContactCacheService extends BaseCacheService
{
    public function rememberContactHero(): array
    {
        return $this->rememberHeroSetting('store_contact_hero');
    }

    public function rememberBranches(): Collection
    {
        return $this->remember('contact.branches', function () {
            return Branch::where('is_active', true)->orderBy('sort_order')->get();
        }, self::TTL_LONG);
    }

    public function forgetContact(): void
    {
        Cache::forget('contact.branches');
    }
}
