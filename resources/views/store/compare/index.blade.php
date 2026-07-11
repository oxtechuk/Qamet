@extends('store.layouts.app')
@section('title', __('مقارنة السيارات') . ' | ' . (is_array($globalSettings['site_name'] ?? null) ? ($globalSettings['site_name'][App::getLocale()] ?? ($globalSettings['site_name']['ar'] ?? 'GR Motors')) : ($globalSettings['site_name'] ?? 'GR Motors')))

@section('css')
<style>
/* ===== COMPARE PAGE ===== */
.compare-wrap { max-width: 1100px; margin: 0 auto; padding: 40px 20px; }

/* Hero Selector */
.compare-hero { display: grid; grid-template-columns: 1fr auto 1fr; gap: 20px; align-items: center; margin-bottom: 40px; padding-top: 2rem; }
.compare-hero__vs { font-size: 32px; font-weight: 900; color: #C0152A; text-align: center; }
.compare-slot { background: #fff; border-radius: 20px; box-shadow: 0 4px 20px rgba(0,0,0,0.07); overflow: hidden; border: 2px solid #f0f0f0; transition: border-color 0.3s; }
.compare-slot:hover { border-color: #C0152A; }
.compare-slot__header { background: #1a1a1a; padding: 14px 20px; display: flex; align-items: center; justify-content: space-between; }
.compare-slot__header-title { color: #fff; font-weight: 800; font-size: 14px; }
.compare-slot__body { padding: 24px; }

/* Car Card in slot */
.compare-car-card { text-align: center; }
.compare-car-card img { width: 100%; height: 160px; object-fit: contain; margin-bottom: 12px; }
.compare-car-card__name { font-size: 16px; font-weight: 800; color: #1a1a1a; margin-bottom: 4px; }
.compare-car-card__brand { font-size: 12px; color: #C0152A; font-weight: 700; text-transform: uppercase; margin-bottom: 8px; }
.compare-car-card__price { font-size: 18px; font-weight: 900; color: #1a1a1a; margin-bottom: 14px; }
.compare-car-card__price small { font-size: 13px; font-weight: 600; color: #888; }
.compare-car-card__change { display: inline-flex; align-items: center; gap: 6px; font-size: 12px; color: #888; cursor: pointer; border: 1px solid #eee; padding: 6px 14px; border-radius: 50px; transition: 0.2s; background: #f8f8f8; }
.compare-car-card__change:hover { border-color: #C0152A; color: #C0152A; background: #fff5f5; }

/* Empty slot */
.compare-slot-empty { text-align: center; padding: 30px 20px; }
.compare-slot-empty__icon { width: 70px; height: 70px; background: #f8f8f8; border: 2px dashed #ddd; border-radius: 16px; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px; font-size: 30px; color: #ccc; }
.compare-slot-empty__title { font-size: 15px; font-weight: 700; color: #555; margin-bottom: 6px; }
.compare-slot-empty__sub { font-size: 12px; color: #aaa; margin-bottom: 16px; }

/* Search Box */
.compare-search-wrap { position: relative; }
.compare-search-input { width: 100%; border: 2px solid #eee; border-radius: 12px; padding: 10px 16px; font-size: 14px; outline: none; font-family: inherit; transition: border-color 0.2s; }
.compare-search-input:focus { border-color: #C0152A; }
.compare-search-results { position: absolute; top: calc(100% + 6px); left: 0; right: 0; background: #fff; border-radius: 12px; box-shadow: 0 8px 30px rgba(0,0,0,0.12); z-index: 200; overflow: hidden; display: none; }
.compare-search-item { display: flex; align-items: center; gap: 12px; padding: 10px 14px; cursor: pointer; transition: background 0.15s; }
.compare-search-item:hover { background: #fff5f5; }
.compare-search-item img { width: 50px; height: 38px; object-fit: contain; border-radius: 6px; background: #f5f5f5; }
.compare-search-item__name { font-size: 14px; font-weight: 700; color: #1a1a1a; }
.compare-search-item__meta { font-size: 12px; color: #888; }

/* Table */
.compare-table-wrap { background: #fff; border-radius: 20px; box-shadow: 0 4px 20px rgba(0,0,0,0.07); overflow: hidden; margin-bottom: 40px; }
.compare-table-section-title { display: flex; align-items: center; gap: 10px; background: rgba(255, 247, 237, 1);; color: #1a1a1a;font-size: 14px; font-weight: 800; padding: 14px 24px; }
.compare-table-section-title i { color: #C0152A; font-size: 18px; }
.compare-row { display: grid; grid-template-columns: 1fr 220px 220px; align-items: stretch; border-bottom: 1px solid #f5f5f5; }
.compare-row:last-child { border-bottom: none; }
.compare-row__label { padding: 14px 24px; font-size: 13px; font-weight: 700; color: #555; display: flex; align-items: center; background: #fafafa; border-left: 1px solid #f0f0f0; }
.compare-row__val { padding: 14px 20px; font-size: 14px; font-weight: 800; color: #1a1a1a; text-align: center; display: flex; align-items: center; justify-content: center; border-left: 1px solid #f0f0f0; }
.compare-row__val--win { background: #f0fdf4; color: #16a34a; }
.compare-row__val--lose { background: #fff5f5; color: #dc2626; }
.compare-row__val--check-yes { color: #16a34a; font-size: 18px; }
.compare-row__val--check-no  { color: #dc2626; font-size: 18px; opacity: 0.5; }
.compare-row-header__cell {
    background: var(--primary);
    color: white;
}
/* Header row inside table */
.compare-row-header { display: grid; grid-template-columns: 1fr 220px 220px; background: var(--primary); border-bottom: 2px solid #eee; }
.compare-row-header__cell { padding: 14px 20px; font-size: 13px; font-weight: 800; text-align: center; color: #fff; display: flex; align-items: center; justify-content: center; gap: 8px; border-left: 1px solid #eee; }
.compare-row-header__cell:first-child { justify-content: flex-start; }
.compare-row-header__car-img { width: 44px; height: 32px; object-fit: contain; border-radius: 4px; }

/* CTA */
.compare-cta { background: #1a1a1a; border-radius: 20px; padding: 50px 40px; text-align: center; color: #fff; margin-bottom: 40px; }
.compare-cta h2 { font-size: 26px; font-weight: 900; margin-bottom: 8px; }
.compare-cta p { color: rgba(255,255,255,0.6); font-size: 15px; margin-bottom: 28px; }
.compare-cta__btns { display: flex; justify-content: center; gap: 14px; flex-wrap: wrap; }

/* Empty state */
.compare-empty { text-align: center; padding: 60px 20px; color: #aaa; }
.compare-empty i { font-size: 60px; display: block; margin-bottom: 16px; }

@media (max-width: 768px) {
    .compare-wrap { padding: 24px 14px; }
    .compare-hero { grid-template-columns: 1fr; gap: 16px; }
    .compare-hero__vs { display: none; }
    .compare-table-wrap { overflow-x: auto; -webkit-overflow-scrolling: touch; }
    .compare-row, .compare-row-header { grid-template-columns: 140px 1fr 1fr; min-width: 480px; }
    .compare-row__label { font-size: 12px; padding: 12px 14px; }
    .compare-row__val { font-size: 13px; padding: 12px 12px; }
    .compare-row-header__cell { font-size: 12px; padding: 12px 10px; }
    .compare-cta { padding: 32px 20px; border-radius: 16px; }
    .compare-cta h2 { font-size: 20px; }
    .compare-cta__btns { flex-direction: column; align-items: center; gap: 12px; }
    .compare-cta__btns .btn-p { width: 100%; justify-content: center; }
    .compare-car-card img { height: 120px; }
}

@media (max-width: 480px) {
    .compare-row, .compare-row-header { grid-template-columns: 110px 1fr 1fr; }
    .compare-slot__body { padding: 16px; }
}
</style>
@endsection

@section('content')
<div class="compare-wrap">

    {{-- HERO SELECTOR --}}
    <div class="text-center mb-4">
        <h1 style="font-size:28px;font-weight:900;color:#1a1a1a;">{{ __('قارن بين السيارات') }}</h1>
        <p style="color:#888;font-size:15px;">{{ __('اختر حتى 2 سيارات لقياس المواصفات والأسعار بكل سيارة') }}</p>
    </div>

    <div class="compare-hero">
        {{-- SLOT 1 --}}
        <div class="compare-slot" id="slot1-card">
            <div class="compare-slot__header">
                <span class="compare-slot__header-title">{{ __('السيارة الأولى') }}</span>
                @if($car1)
                    <a href="{{ route('store.booking.create', ['car_id' => $car1->id]) }}" class="btn-p btn-p--primary" style="font-size:12px;padding:5px 14px;text-decoration:none;">{{ __('اطلب الآن') }}</a>
                @endif
            </div>
            <div class="compare-slot__body">
                @if($car1)
                    <div class="compare-car-card">
                        <img loading="lazy" src="{{ $car1->thumbnail ? asset('storage/'.$car1->thumbnail) : asset('assets/images/placeholder-car.jpg') }}" alt="{{ $car1->name }}">
                        <div class="compare-car-card__brand">{{ $car1->brand?->name }}</div>
                        <div class="compare-car-card__name">{{ $car1->name }} {{ $car1->year }}</div>
                        <div class="compare-car-card__price">{{ number_format($car1->cash_price) }} <small>{!! __('ريال') !!}</small></div>
                        <button class="compare-car-card__change" onclick="openSearch(1)">
                            <i class="bi bi-arrow-repeat"></i> {{ __('تغيير السيارة') }}
                        </button>
                    </div>
                @else
                    <div class="compare-slot-empty">
                        <div class="compare-slot-empty__icon"><i class="bi bi-plus-lg"></i></div>
                        <div class="compare-slot-empty__title">{{ __('أضف سيارة للمقارنة') }}</div>
                        <div class="compare-slot-empty__sub">{{ __('ابحث عن سيارة لإضافتها هنا') }}</div>
                        <div class="compare-search-wrap" id="search-wrap-1">
                            <input type="text" class="compare-search-input" id="search-input-1" placeholder="{{ __('ابحث باسم السيارة أو الماركة...') }}" oninput="doSearch(this.value, 1)" autocomplete="off">
                            <div class="compare-search-results" id="search-results-1"></div>
                        </div>
                    </div>
                @endif
                @if($car1)
                    <div class="compare-search-wrap mt-3" id="search-wrap-1" style="display:none;">
                        <input type="text" class="compare-search-input" id="search-input-1" placeholder="{{ __('ابحث عن سيارة أخرى...') }}" oninput="doSearch(this.value, 1)" autocomplete="off">
                        <div class="compare-search-results" id="search-results-1"></div>
                    </div>
                @endif
            </div>
        </div>

        <div class="compare-hero__vs">VS</div>

        {{-- SLOT 2 --}}
        <div class="compare-slot" id="slot2-card">
            <div class="compare-slot__header">
                <span class="compare-slot__header-title">{{ __('السيارة الثانية') }}</span>
                @if($car2)
                    <a href="{{ route('store.booking.create', ['car_id' => $car2->id]) }}" class="btn-p btn-p--primary" style="font-size:12px;padding:5px 14px;text-decoration:none;">{{ __('اطلب الآن') }}</a>
                @endif
            </div>
            <div class="compare-slot__body">
                @if($car2)
                    <div class="compare-car-card">
                        <img loading="lazy" src="{{ $car2->thumbnail ? asset('storage/'.$car2->thumbnail) : asset('assets/images/placeholder-car.jpg') }}" alt="{{ $car2->name }}">
                        <div class="compare-car-card__brand">{{ $car2->brand?->name }}</div>
                        <div class="compare-car-card__name">{{ $car2->name }} {{ $car2->year }}</div>
                        <div class="compare-car-card__price">{{ number_format($car2->cash_price) }} <small>{!! __('ريال') !!}</small></div>
                        <button class="compare-car-card__change" onclick="openSearch(2)">
                            <i class="bi bi-arrow-repeat"></i> {{ __('تغيير السيارة') }}
                        </button>
                    </div>
                @else
                    <div class="compare-slot-empty">
                        <div class="compare-slot-empty__icon"><i class="bi bi-plus-lg"></i></div>
                        <div class="compare-slot-empty__title">{{ __('أضف سيارة للمقارنة') }}</div>
                        <div class="compare-slot-empty__sub">{{ __('ابحث عن سيارة لإضافتها هنا') }}</div>
                        <div class="compare-search-wrap" id="search-wrap-2">
                            <input type="text" class="compare-search-input" id="search-input-2" placeholder="{{ __('ابحث باسم السيارة أو الماركة...') }}" oninput="doSearch(this.value, 2)" autocomplete="off">
                            <div class="compare-search-results" id="search-results-2"></div>
                        </div>
                    </div>
                @endif
                @if($car2)
                    <div class="compare-search-wrap mt-3" id="search-wrap-2" style="display:none;">
                        <input type="text" class="compare-search-input" id="search-input-2" placeholder="{{ __('ابحث عن سيارة أخرى...') }}" oninput="doSearch(this.value, 2)" autocomplete="off">
                        <div class="compare-search-results" id="search-results-2"></div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- COMPARISON TABLE --}}
    @if($car1 && $car2 && count($comparisonSections))
        <div class="compare-table-wrap">
            {{-- Header Row --}}
            <div class="compare-row-header">
                <div class="compare-row-header__cell" style="justify-content:flex-start; padding-right:24px;">
                    <i class="bi bi-list-columns" style="color:#fff;"></i> {{ __('جدول المقارنة') }}
                    <span style="font-size:11px;font-weight:400;color:#888;margin-right:8px;">{{ __('المفضل من') }} 2 {{ __('سيارة') }}</span>
                </div>
              
            </div>

            @foreach($comparisonSections as $section)
                <div class="compare-table-section-title">
                    <i class="bi {{ $section['icon'] }}"></i>
                    {{ __($section['title']) }}
                </div>
                @foreach($section['rows'] as $row)
                    @php
                        $cls1 = $row['winner'] === 1 ? 'compare-row__val--win' : ($row['winner'] === 2 ? 'compare-row__val--lose' : '');
                        $cls2 = $row['winner'] === 2 ? 'compare-row__val--win' : ($row['winner'] === 1 ? 'compare-row__val--lose' : '');
                        $isCheck = ($row['type'] ?? '') === 'check';
                        $v1Class = $isCheck ? ($row['val1'] === '✓' ? 'compare-row__val--check-yes' : 'compare-row__val--check-no') : $cls1;
                        $v2Class = $isCheck ? ($row['val2'] === '✓' ? 'compare-row__val--check-yes' : 'compare-row__val--check-no') : $cls2;
                    @endphp
                    <div class="compare-row">
                        <div class="compare-row__label">{{ __($row['label']) }}</div>
                        <div class="compare-row__val {{ $v1Class }}">{!! $row['val1'] !!}</div>
                        <div class="compare-row__val {{ $v2Class }}">{!! $row['val2'] !!}</div>
                    </div>
                @endforeach
            @endforeach
        </div>
    @elseif(!$car1 || !$car2)
        <div class="compare-empty">
            <i class="bi bi-car-front text-muted"></i>
            <p style="font-size:16px;font-weight:700;">{{ __('اختر سيارتين أعلاه لعرض جدول المقارنة') }}</p>
        </div>
    @endif

    {{-- CTA --}}
    @if($car1 || $car2)
    <div class="compare-cta">
        <h2>{{ __('اتخذت قرارك؟') }}</h2>
        <p>{{ __('تواصل معنا الآن لتحجز موعد تجربة القيادة') }}</p>
        <div class="compare-cta__btns">
            <a href="{{ route('store.booking.create') }}" class="btn-p btn-p--primary btn-p--lg" style="text-decoration:none;">{{ __('طلب تجربة قيادة') }}</a>
            <a href="https://wa.me/{{ $globalSettings['contact_whatsapp'] ?? '966500000000' }}" target="_blank" class="btn-p btn-p--outline btn-p--lg" style="text-decoration:none;color:black;border-color:rgba(0, 0, 0, 0.3); ">{{ __('تواصل معنا') }}</a>
        </div>
    </div>
    @endif

</div>
@endsection

@section('js')
<script>
const SEARCH_URL = "{{ route('store.compare.search') }}";
const COMPARE_URL = "{{ route('store.compare') }}";
let searchTimers = {};

function doSearch(term, slot) {
    const resultsEl = document.getElementById('search-results-' + slot);
    if (term.length < 1) { resultsEl.style.display = 'none'; return; }

    clearTimeout(searchTimers[slot]);
    searchTimers[slot] = setTimeout(async () => {
        const res = await fetch(SEARCH_URL + '?q=' + encodeURIComponent(term));
        const data = await res.json();
        if (!data.length) {
            resultsEl.innerHTML = '<div style="padding:16px;text-align:center;color:#aaa;font-size:13px;">{{ __("لا توجد نتائج") }}</div>';
        } else {
            resultsEl.innerHTML = data.map(car => `
                <div class="compare-search-item" onclick="selectCar('${car.slug}', ${slot})">
                    <img loading="lazy" src="${car.thumbnail}" alt="${car.name}">
                    <div>
                        <div class="compare-search-item__name">${car.name} ${car.year}</div>
                        <div class="compare-search-item__meta">${car.brand ?? ''} • ${car.price} ريال</div>
                    </div>
                </div>
            `).join('');
        }
        resultsEl.style.display = 'block';
    }, 300);
}

function selectCar(slug, slot) {
    // Read current slugs from URL
    const params = new URLSearchParams(window.location.search);
    const cars = params.getAll('cars[]');
    const car1 = slot === 1 ? slug : (cars[0] || '');
    const car2 = slot === 2 ? slug : (cars[1] || '');

    let newUrl = COMPARE_URL + '?';
    if (car1) newUrl += 'cars[]=' + car1 + '&';
    if (car2) newUrl += 'cars[]=' + car2;
    window.location.href = newUrl;
}

function openSearch(slot) {
    const wrap = document.getElementById('search-wrap-' + slot);
    if (wrap) {
        wrap.style.display = 'block';
        document.getElementById('search-input-' + slot).focus();
    }
}

// Close dropdowns when clicking outside
document.addEventListener('click', (e) => {
    [1, 2].forEach(slot => {
        const wrap = document.getElementById('search-wrap-' + slot);
        if (wrap && !wrap.contains(e.target)) {
            const results = document.getElementById('search-results-' + slot);
            if (results) results.style.display = 'none';
        }
    });
});
</script>
@endsection
