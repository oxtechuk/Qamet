<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Services\Cache\CarCacheService;
use Illuminate\Http\Request;

class CarController extends Controller
{
    public function __construct(
        private readonly CarCacheService $cache,
    ) {}

    public function index(Request $request)
    {
        $hero = $this->cache->rememberHeroSetting('store_hero');

        $query = Car::with(['brand', 'activeOffers'])->where('is_active', true);

        if ($request->filled('brands') && is_array($request->brands)) {
            $query->whereIn('brand_id', $request->brands);
        }
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }
        if ($request->filled('year')) {
            $query->where('year', $request->year);
        }
        if ($request->filled('min_price')) {
            $query->where('cash_price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('cash_price', '<=', $request->max_price);
        }
        if ($request->filled('search') || $request->filled('q')) {
            $s = $request->search ?: $request->q;
            $query->where(function ($q) use ($s) {
                $q->where('name', 'like', "%{$s}%")
                    ->orWhere('model', 'like', "%{$s}%")
                    ->orWhereHas('brand', fn ($b) => $b->where('name', 'like', "%{$s}%"));
            });
        }
        if ($request->filled('offer_id')) {
            $query->whereHas('offers', function ($q) use ($request) {
                $q->where('offers.id', $request->offer_id);
            });
        }

        match ($request->sort ?? 'latest') {
            'price_asc' => $query->orderBy('cash_price'),
            'price_desc' => $query->orderByDesc('cash_price'),
            'year_desc' => $query->orderByDesc('year'),
            default => $query->latest('id'),
        };

        $cars = $query->paginate(12)->withQueryString();

        $filterData = $this->cache->rememberCarFilters();
        $brands = $filterData['brands'];
        $years = $filterData['years'];

        $types = ['sedan' => 'سيدان', 'suv' => 'SUV', 'coupe' => 'كوبيه', 'hatchback' => 'هاتشباك', 'pickup' => 'بيك آب', 'van' => 'فان', 'other' => 'أخرى'];

        return view('store.cars.index', compact('cars', 'brands', 'years', 'types', 'hero'));
    }

    public function show($slug)
    {
        $car = Car::with(['brand', 'images', 'offers' => fn ($q) => $q->active()])
            ->where(function ($q) use ($slug) {
                $q->where('slug->en', $slug)
                    ->orWhere('slug->ar', $slug);
            })
            ->where('is_active', true)
            ->firstOrFail();

        $car->increment('views');

        $related = Car::with(['brand', 'activeOffers'])
            ->where('brand_id', $car->brand_id)
            ->where('id', '!=', $car->id)
            ->where('is_active', true)
            ->limit(4)
            ->get();

        return view('store.cars.show', compact('car', 'related'));
    }
}
