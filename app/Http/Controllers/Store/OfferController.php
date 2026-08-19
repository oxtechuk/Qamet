<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Services\Cache\OfferCacheService;

class OfferController extends Controller
{
    public function __construct(
        private readonly OfferCacheService $cache,
    ) {}

    public function index()
    {
        $hero = $this->cache->rememberHeroSetting('store_offers_hero');

        $data = $this->cache->rememberOffersData();

        return view('store.offers.index', array_merge($data, compact('hero')));
    }
}
