<x-filament-panels::page>
<style>
    /* ===== CARS SHOWCASE ===== */
    .cs-wrap { direction: rtl; }

    /* -- Category pills -- */
    .cs-cats {
        display: flex;
        flex-wrap: wrap;
        gap: .45rem;
        margin-bottom: 1rem;
    }
    .cs-cat {
        padding: .35rem 1rem;
        border-radius: 999px;
        font-size: .82rem;
        font-weight: 600;
        border: 1.5px solid rgba(156,163,175,.3);
        background: transparent;
        color: rgb(107 114 128);
        cursor: pointer;
        transition: all .18s;
        line-height: 1;
    }
    .cs-cat:hover { border-color: #dfc674; color: #dfc674; }
    .cs-cat.active { background: #dfc674; border-color: #dfc674; color: #fff; }

    /* -- Search -- */
    .cs-search {
        position: relative;
        margin-bottom: 1.25rem;
    }
    .cs-search input {
        width: 100%;
        padding: .6rem 2.4rem .6rem 1rem;
        border-radius: .65rem;
        border: 1.5px solid rgb(209 213 219);
        background: #fff;
        color: rgb(17 24 39);
        font-size: .9rem;
        outline: none;
        transition: border-color .18s;
        direction: rtl;
    }
    .dark .cs-search input {
        background: rgb(31 41 55);
        border-color: rgb(55 65 81);
        color: rgb(243 244 246);
    }
    .cs-search input:focus { border-color: #dfc674; }
    .cs-search-icon {
        position: absolute;
        top: 50%; right: .75rem;
        transform: translateY(-50%);
        width: 1rem; height: 1rem;
        color: rgb(156 163 175);
        pointer-events: none;
    }

    /* -- Grid -- */
    .cs-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(190px, 1fr));
        gap: 1rem;
    }

    /* -- Card -- */
    .cs-card {
        border-radius: .9rem;
        overflow: hidden;
        border: 1.5px solid rgb(229 231 235);
        background: #fff;
        cursor: pointer;
        transition: transform .18s, box-shadow .18s, border-color .18s;
        display: flex;
        flex-direction: column;
    }
    .dark .cs-card { background: rgb(31 41 55); border-color: rgb(55 65 81); }
    .cs-card:hover { transform: translateY(-3px); box-shadow: 0 6px 24px rgba(0,0,0,.12); border-color: #dfc674; }
    .cs-card.selected { border-color: #dfc674; box-shadow: 0 0 0 3px rgba(217,119,6,.2); }

    .cs-card-img {
        width: 100%; aspect-ratio: 4/3;
        object-fit: cover;
        background: rgb(243 244 246);
        display: block;
    }
    .dark .cs-card-img { background: rgb(17 24 39); }
    .cs-card-noimg {
        width: 100%; aspect-ratio: 4/3;
        background: rgb(243 244 246);
        display: flex; align-items: center; justify-content: center;
    }
    .dark .cs-card-noimg { background: rgb(17 24 39); }

    .cs-card-body { padding: .7rem; flex: 1; display: flex; flex-direction: column; gap: .25rem; }

    .cs-card-name {
        font-size: .83rem; font-weight: 700; line-height: 1.3;
        color: rgb(17 24 39);
        display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;
    }
    .dark .cs-card-name { color: rgb(243 244 246); }

    .cs-card-meta { font-size: .72rem; color: rgb(107 114 128); }

    .cs-card-footer {
        margin-top: auto; padding-top: .5rem;
        display: flex; align-items: center; justify-content: space-between;
        gap: .3rem;
    }
    .cs-card-price { font-size: .95rem; font-weight: 800; color: #dfc674; }
    .cs-card-install { font-size: .65rem; color: rgb(107 114 128); margin-top: 1px; }

    .cs-btn {
        padding: .3rem .7rem;
        background: #dfc674; color: #fff;
        font-size: .72rem; font-weight: 700;
        border-radius: .4rem; border: none; cursor: pointer;
        transition: background .15s; white-space: nowrap;
        flex-shrink: 0;
    }
    .cs-btn:hover { background: #b45309; }

    /* -- Empty state -- */
    .cs-empty { text-align: center; padding: 3rem 1rem; color: rgb(156 163 175); }

    /* -- Detail Panel -- */
    .cs-detail {
        margin-top: 1.5rem;
        border: 1.5px solid #dfc674;
        border-radius: 1rem;
        background: #fff;
        overflow: hidden;
        animation: csSlideIn .25s ease;
    }
    .dark .cs-detail { background: rgb(31 41 55); }
    @keyframes csSlideIn { from { opacity:0; transform:translateY(10px); } to { opacity:1; transform:translateY(0); } }

    .cs-detail-header {
        background: linear-gradient(135deg, #dfc674, #f59e0b);
        padding: 1rem 1.25rem;
        display: flex; align-items: center; justify-content: space-between;
    }
    .cs-detail-header h2 { font-size: 1.1rem; font-weight: 800; color: #fff; margin: 0; }
    .cs-close {
        background: rgba(255,255,255,.2); border: none; border-radius: .4rem;
        color: #fff; padding: .3rem .6rem; cursor: pointer; font-size: .8rem; font-weight: 700;
        transition: background .15s;
    }
    .cs-close:hover { background: rgba(255,255,255,.35); }

    .cs-detail-body {
        display: grid;
        grid-template-columns: 280px 1fr;
        gap: 0;
    }
    @media (max-width: 700px) { .cs-detail-body { grid-template-columns: 1fr; } }

    .cs-detail-img-col { padding: 1rem; border-left: 1px solid rgb(229 231 235); }
    .dark .cs-detail-img-col { border-left-color: rgb(55 65 81); }
    .cs-detail-img { width: 100%; border-radius: .65rem; object-fit: cover; aspect-ratio: 4/3; }
    .cs-detail-noimg {
        width: 100%; aspect-ratio: 4/3; border-radius: .65rem;
        background: rgb(243 244 246);
        display: flex; align-items: center; justify-content: center;
    }
    .dark .cs-detail-noimg { background: rgb(17 24 39); }

    .cs-detail-info { padding: 1rem 1.25rem; overflow-y: auto; max-height: 480px; }

    /* Prices */
    .cs-prices { display: flex; flex-wrap: wrap; gap: .65rem; margin-bottom: 1rem; }
    .cs-price-box {
        background: rgb(254 252 232); border: 1px solid rgb(253 230 138);
        border-radius: .6rem; padding: .45rem .8rem; text-align: center; min-width: 90px;
    }
    .dark .cs-price-box { background: rgba(217,119,6,.1); border-color: rgba(217,119,6,.3); }
    .cs-price-box .lbl { font-size: .65rem; color: rgb(107 114 128); margin-bottom: 2px; }
    .cs-price-box .val { font-size: .95rem; font-weight: 800; color: #dfc674; }

    /* Action buttons */
    .cs-actions { display: flex; gap: .6rem; flex-wrap: wrap; margin-bottom: 1rem; }
    .cs-act-btn {
        display: inline-flex; align-items: center; gap: .35rem;
        padding: .45rem .9rem; border-radius: .55rem; font-size: .8rem; font-weight: 600;
        cursor: pointer; border: 1.5px solid; transition: all .18s;
    }
    .cs-act-btn svg { width: .9rem; height: .9rem; }
    .cs-act-btn.dl { border-color: #dfc674; color: #dfc674; background: rgb(254 252 232); }
    .cs-act-btn.dl:hover { background: #dfc674; color: #fff; }
    .dark .cs-act-btn.dl { background: rgba(217,119,6,.1); }
    .cs-act-btn.cp { border-color: rgb(99 102 241); color: rgb(99 102 241); background: rgb(238 242 255); }
    .cs-act-btn.cp:hover { background: rgb(99 102 241); color: #fff; }
    .dark .cs-act-btn.cp { background: rgba(99,102,241,.1); }

    /* Specs list */
    .cs-section-lbl { font-size: .72rem; font-weight: 700; letter-spacing: .06em; text-transform: uppercase; color: rgb(156 163 175); margin: .75rem 0 .35rem; }
    .cs-list { list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: .22rem; }
    .cs-list li { font-size: .8rem; color: rgb(55 65 81); display: flex; align-items: flex-start; gap: .4rem; }
    .dark .cs-list li { color: rgb(209 213 219); }
    .cs-list li::before { content:''; display:inline-block; width:6px; height:6px; border-radius:50%; background:#dfc674; margin-top:.35em; flex-shrink:0; }

    /* Variants */
    .cs-variant { display:flex; align-items:center; gap:.65rem; padding:.5rem .65rem; border-radius:.6rem; background:rgb(249 250 251); border:1px solid rgb(229 231 235); margin-bottom:.45rem; }
    .dark .cs-variant { background:rgb(17 24 39); border-color:rgb(55 65 81); }
    .cs-variant-img { width:60px; height:45px; object-fit:cover; border-radius:.35rem; flex-shrink:0; }
    .cs-variant-noimg { width:60px; height:45px; background:rgb(229 231 235); border-radius:.35rem; flex-shrink:0; display:flex; align-items:center; justify-content:center; }
    .dark .cs-variant-noimg { background:rgb(55 65 81); }
    .cs-variant-name { font-size:.8rem; font-weight:700; color:rgb(17 24 39); }
    .dark .cs-variant-name { color:rgb(243 244 246); }
    .cs-variant-sub { font-size:.7rem; color:rgb(107 114 128); margin-top:1px; }

    /* Toast */
    .cs-toast {
        position: fixed; bottom: 1.5rem; left: 50%;
        transform: translateX(-50%);
        background: #dfc674; color: #fff;
        font-weight: 700; font-size: .85rem;
        padding: .5rem 1.25rem; border-radius: .65rem;
        z-index: 9999; pointer-events: none;
        opacity: 0; transition: opacity .2s;
    }
    .cs-toast.show { opacity: 1; }
</style>

<div
    class="cs-wrap"
    x-data="{
        toast: false, toastMsg: '',
        init() {
            $wire.on('copy-to-clipboard', ({ text }) => {
                navigator.clipboard.writeText(text).then(() => {
                    this.toastMsg = '✓ تم نسخ التفاصيل';
                    this.toast = true;
                    setTimeout(() => this.toast = false, 2200);
                });
            });
            $wire.on('download-file', ({ url }) => {
                const a = document.createElement('a');
                a.href = url; a.download = '';
                document.body.appendChild(a); a.click();
                document.body.removeChild(a);
            });
            $wire.on('scroll-to-detail', () => {
                setTimeout(() => {
                    document.getElementById('cs-detail-panel')?.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }, 80);
            });
        }
    }"
>

    {{-- ====== CATEGORY PILLS ====== --}}
    <div class="cs-cats">
        <button
            class="cs-cat {{ $this->selectedCategory === null ? 'active' : '' }}"
            wire:click="selectCategory(null)"
        >الكل</button>
        @foreach ($this->getCategories() as $cat)
            <button
                class="cs-cat {{ $this->selectedCategory === $cat->id ? 'active' : '' }}"
                wire:click="selectCategory({{ $cat->id }})"
            >{{ $cat->name }}</button>
        @endforeach
    </div>

    {{-- ====== SEARCH ====== --}}
    <div class="cs-search">
        <svg class="cs-search-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z"/>
        </svg>
        <input
            type="text"
            placeholder="ابحث بالاسم أو الموديل..."
            wire:model.live.debounce.400ms="search"
            id="cs-search"
        />
    </div>

    {{-- ====== CARS GRID ====== --}}
    @php $cars = $this->getCars(); @endphp

    @if ($cars->isEmpty())
        <div class="cs-empty">
            <svg style="width:2.5rem;height:2.5rem;margin:0 auto .5rem;display:block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0z"/>
            </svg>
            <p style="font-size:.9rem">لا توجد سيارات مطابقة</p>
        </div>
    @else
        <div class="cs-grid">
            @foreach ($cars as $car)
                <div
                    class="cs-card {{ $this->selectedCarId === $car->id ? 'selected' : '' }}"
                    wire:click="selectCar({{ $car->id }})"
                    wire:key="car-{{ $car->id }}"
                    title="{{ $car->name }}"
                >
                    @if ($car->main_image)
                        <img src="{{ $car->main_image }}" alt="{{ $car->name }}" class="cs-card-img" loading="lazy"/>
                    @else
                        <div class="cs-card-noimg">
                            <svg style="width:2rem;height:2rem;color:rgb(209 213 219)" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M3 9l2-4h14l2 4M3 9v7a2 2 0 002 2h14a2 2 0 002-2V9M3 9h18"/>
                            </svg>
                        </div>
                    @endif

                    <div class="cs-card-body">
                        <div class="cs-card-name">{{ $car->name }}</div>
                        <div class="cs-card-meta">
                            {{ $car->brand?->name }}@if($car->year) · {{ $car->year }}@endif@if($car->category) · {{ $car->category->name }}@endif
                        </div>
                        <div class="cs-card-footer">
                            <div>
                                @if ($car->cash_price)
                                    <div class="cs-card-price">{{ number_format($car->cash_price) }} <small style="font-size:.6rem;font-weight:500">ريال</small></div>
                                @endif
                                @if ($car->min_installment)
                                    <div class="cs-card-install">تبدأ من {{ number_format($car->min_installment) }} ريال/شهر</div>
                                @endif
                            </div>
                            <button class="cs-btn" wire:click.stop="selectCar({{ $car->id }})">التفاصيل</button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    {{-- ====== DETAIL PANEL ====== --}}
    @if ($this->selectedCarId)
        @php $sc = $this->getSelectedCar(); @endphp
        @if ($sc)
            <div class="cs-detail" id="cs-detail-panel" wire:key="detail-{{ $sc->id }}">

                {{-- Header --}}
                <div class="cs-detail-header">
                    <h2>{{ $sc->name }} {{ $sc->year }}</h2>
                    <button class="cs-close" wire:click="selectCar({{ $sc->id }})">✕ إغلاق</button>
                </div>

                {{-- Body --}}
                <div class="cs-detail-body">

                    {{-- LEFT: Image + Variants --}}
                    <div class="cs-detail-img-col">
                        @if ($sc->main_image)
                            <img src="{{ $sc->main_image }}" alt="{{ $sc->name }}" class="cs-detail-img"/>
                        @else
                            <div class="cs-detail-noimg">
                                <svg style="width:3rem;height:3rem;color:rgb(209 213 219)" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M3 9l2-4h14l2 4M3 9v7a2 2 0 002 2h14a2 2 0 002-2V9M3 9h18"/>
                                </svg>
                            </div>
                        @endif

                        @if ($sc->variants->isNotEmpty())
                            <p class="cs-section-lbl" style="margin-top:.9rem">الفروقات والإضافات</p>
                            @foreach ($sc->variants as $v)
                                <div class="cs-variant">
                                    @if ($v->image_url)
                                        <img src="{{ $v->image_url }}" class="cs-variant-img" alt="{{ $v->name }}"/>
                                    @else
                                        <div class="cs-variant-noimg">
                                            <svg style="width:1.2rem;height:1.2rem;color:rgb(156 163 175)" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4-4 4 4 4-8 4 8"/>
                                            </svg>
                                        </div>
                                    @endif
                                    <div>
                                        <div class="cs-variant-name">{{ $v->name }}</div>
                                        <div class="cs-variant-sub">
                                            @if ($v->cash_price) كاش: {{ number_format($v->cash_price) }} ريال @endif
                                            @if ($v->min_installment) · قسط: {{ number_format($v->min_installment) }} ريال @endif
                                        </div>
                                        @if (!empty($v->specs))
                                            <div class="cs-variant-sub">
                                                @foreach ($v->specs as $sp)
                                                    @if(!empty($sp['key'])) {{ $sp['key'] }}: {{ $sp['value'] ?? '' }}{{ !$loop->last ? ' · ' : '' }} @endif
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>

                    {{-- RIGHT: Info --}}
                    <div class="cs-detail-info">
                        <p style="font-size:.8rem;color:rgb(107 114 128);margin:0 0 .75rem">
                            {{ $sc->brand?->name }}@if($sc->category) · {{ $sc->category->name }}@endif
                        </p>

                        {{-- Action buttons --}}
                        <div class="cs-actions">
                            <button
                                class="cs-act-btn dl"
                                wire:click="downloadImages"
                                wire:loading.attr="disabled"
                                wire:target="downloadImages"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5 5 5-5M12 4v11"/>
                                </svg>
                                <span wire:loading.remove wire:target="downloadImages">تحميل الصور</span>
                                <span wire:loading wire:target="downloadImages">جاري...</span>
                            </button>
                            <button class="cs-act-btn cp" wire:click="copySpecs">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                </svg>
                                نسخ التفاصيل
                            </button>
                        </div>

                        {{-- Prices --}}
                        @if ($sc->cash_price || $sc->min_installment || $sc->min_down_payment)
                            <div class="cs-prices">
                                @if ($sc->cash_price)
                                    <div class="cs-price-box">
                                        <div class="lbl">سعر الكاش</div>
                                        <div class="val">{{ number_format($sc->cash_price) }} <small style="font-size:.6rem">ريال</small></div>
                                    </div>
                                @endif
                                @if ($sc->min_installment)
                                    <div class="cs-price-box">
                                        <div class="lbl">أقل قسط</div>
                                        <div class="val">{{ number_format($sc->min_installment) }} <small style="font-size:.6rem">ريال/شهر</small></div>
                                    </div>
                                @endif
                                @if ($sc->min_down_payment)
                                    <div class="cs-price-box">
                                        <div class="lbl">أقل دفعة</div>
                                        <div class="val">{{ number_format($sc->min_down_payment) }} <small style="font-size:.6rem">ريال</small></div>
                                    </div>
                                @endif
                            </div>
                        @endif

                        {{-- Specifications --}}
                        @if ($sc->specifications->isNotEmpty())
                            <p class="cs-section-lbl">المواصفات</p>
                            <ul class="cs-list">
                                @foreach ($sc->specifications as $spec)
                                    <li>{{ $spec->name }}@if($spec->value): <span style="color:rgb(107 114 128)">{{ $spec->value }}</span>@endif</li>
                                @endforeach
                            </ul>
                        @endif

                        {{-- Features --}}
                        @if ($sc->features_list->isNotEmpty())
                            <p class="cs-section-lbl">المميزات</p>
                            <ul class="cs-list">
                                @foreach ($sc->features_list as $f)
                                    <li>{{ $f->name }}</li>
                                @endforeach
                            </ul>
                        @endif

                        {{-- Safety --}}
                        @if ($sc->safety_features->isNotEmpty())
                            <p class="cs-section-lbl">مميزات السلامة</p>
                            <ul class="cs-list">
                                @foreach ($sc->safety_features as $sf)
                                    <li>{{ $sf->name }}</li>
                                @endforeach
                            </ul>
                        @endif

                        @if ($sc->specifications->isEmpty() && $sc->features_list->isEmpty() && $sc->safety_features->isEmpty())
                            <p style="font-size:.8rem;color:rgb(156 163 175);margin-top:.5rem">لا توجد مواصفات مضافة لهذه السيارة</p>
                        @endif
                    </div>

                </div>
            </div>
        @endif
    @endif

    {{-- Toast --}}
    <div class="cs-toast" :class="{ show: toast }" x-text="toastMsg"></div>

</div>
</x-filament-panels::page>
