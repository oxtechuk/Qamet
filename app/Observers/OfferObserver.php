<?php

namespace App\Observers;

use App\Models\Offer;
use App\Services\Cache\HomeCacheService;
use App\Services\Cache\OfferCacheService;

class OfferObserver
{
    public function __construct(
        private HomeCacheService $homeCache,
        private OfferCacheService $offerCache,
    ) {}

    public function saved(Offer $offer): void
    {
        $this->homeCache->forgetOffers();
        $this->offerCache->forgetOffers();
    }

    public function deleted(Offer $offer): void
    {
        $this->homeCache->forgetOffers();
        $this->offerCache->forgetOffers();
    }

    public function forceDeleted(Offer $offer): void
    {
        $this->homeCache->forgetOffers();
        $this->offerCache->forgetOffers();
    }
}
