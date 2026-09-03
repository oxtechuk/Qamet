<x-filament-panels::page>
    {{-- ============================================================
         INLINE STYLES
    ============================================================ --}}
    <style>
        /* ---- Listbox Categories ---- */
        .cs-categories {
            display: flex;
            flex-wrap: wrap;
            gap: .5rem;
            padding-bottom: 1rem;
        }

        .cs-cat-btn {
            padding: .4rem 1.1rem;
            border-radius: 999px;
            font-size: .85rem;
            font-weight: 600;
            border: 2px solid transparent;
            cursor: pointer;
            transition: all .2s;
            background: var(--cs-chip-bg, rgba(255,255,255,.07));
            color: var(--cs-chip-color, #94a3b8);
        }

        .dark .cs-cat-btn {
            --cs-chip-bg: rgba(255,255,255,.07);
            --cs-chip-color: #94a3b8;
        }

        .cs-cat-btn:hover {
            background: rgba(234,179,8,.12);
            color: #eab308;
            border-color: #eab308;
        }

        .cs-cat-btn.active {
            background: #eab308;
            color: #0f172a;
            border-color: #eab308;
        }

        /* ---- Search bar ---- */
        .cs-search-wrap {
            position: relative;
            margin-bottom: 1.25rem;
        }

        .cs-search-wrap svg.cs-search-icon {
            position: absolute;
            top: 50%;
            right: .9rem;
            transform: translateY(-50%);
            width: 1.1rem;
            height: 1.1rem;
            color: #64748b;
            pointer-events: none;
        }

        .cs-search-input {
            width: 100%;
            padding: .65rem 2.5rem .65rem 1rem;
            border-radius: .75rem;
            border: 1.5px solid rgba(255,255,255,.1);
            background: rgba(255,255,255,.06);
            color: inherit;
            font-size: .95rem;
            outline: none;
            transition: border-color .2s;
            direction: rtl;
        }

        .cs-search-input:focus {
            border-color: #eab308;
        }

        /* ---- Grid ---- */
        .cs-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 1.25rem;
        }

        /* ---- Car Card ---- */
        .cs-card {
            background: rgba(255,255,255,.04);
            border: 1.5px solid rgba(255,255,255,.08);
            border-radius: 1.1rem;
            overflow: hidden;
            cursor: pointer;
            transition: transform .2s, box-shadow .2s, border-color .2s;
            display: flex;
            flex-direction: column;
        }

        .cs-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 30px rgba(0,0,0,.3);
            border-color: rgba(234,179,8,.4);
        }

        .cs-card.selected {
            border-color: #eab308;
            box-shadow: 0 0 0 3px rgba(234,179,8,.25);
        }

        .cs-card-img {
            width: 100%;
            aspect-ratio: 4/3;
            object-fit: cover;
            background: #0f172a;
        }

        .cs-card-img-placeholder {
            width: 100%;
            aspect-ratio: 4/3;
            background: rgba(255,255,255,.04);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .cs-card-body {
            padding: .85rem;
            display: flex;
            flex-direction: column;
            gap: .35rem;
            flex: 1;
        }

        .cs-card-name {
            font-size: .9rem;
            font-weight: 700;
            line-height: 1.3;
            color: #f1f5f9;
        }

        .cs-card-meta {
            font-size: .75rem;
            color: #64748b;
        }

        .cs-card-price {
            margin-top: auto;
            padding-top: .5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .cs-price-num {
            font-size: 1rem;
            font-weight: 800;
            color: #eab308;
        }

        .cs-price-install {
            font-size: .7rem;
            color: #64748b;
        }

        .cs-btn-detail {
            padding: .35rem .8rem;
            background: #eab308;
            color: #0f172a;
            font-weight: 700;
            font-size: .78rem;
            border-radius: .5rem;
            border: none;
            cursor: pointer;
            transition: background .2s;
        }

        .cs-btn-detail:hover {
            background: #ca9d00;
        }

        /* ---- Detail Panel ---- */
        .cs-detail {
            margin-top: 2rem;
            background: rgba(255,255,255,.04);
            border: 1.5px solid rgba(234,179,8,.3);
            border-radius: 1.25rem;
            padding: 1.75rem;
            display: grid;
            grid-template-columns: 1fr 1.4fr;
            gap: 2rem;
            animation: fadeInUp .3s ease;
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(12px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        @media (max-width: 768px) {
            .cs-detail { grid-template-columns: 1fr; }
        }

        .cs-detail-img {
            width: 100%;
            border-radius: .75rem;
            object-fit: cover;
            aspect-ratio: 4/3;
            background: rgba(255,255,255,.03);
        }

        .cs-detail-img-placeholder {
            width: 100%;
            aspect-ratio: 4/3;
            background: rgba(255,255,255,.04);
            border-radius: .75rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .cs-detail-info h2 {
            font-size: 1.35rem;
            font-weight: 800;
            color: #f1f5f9;
            margin-bottom: .25rem;
        }

        .cs-detail-actions {
            display: flex;
            gap: .75rem;
            flex-wrap: wrap;
            margin: 1rem 0;
        }

        .cs-action-btn {
            display: inline-flex;
            align-items: center;
            gap: .4rem;
            padding: .5rem 1rem;
            border-radius: .65rem;
            font-size: .85rem;
            font-weight: 600;
            cursor: pointer;
            border: 1.5px solid;
            transition: all .2s;
        }

        .cs-action-btn.download {
            background: rgba(234,179,8,.12);
            border-color: #eab308;
            color: #eab308;
        }

        .cs-action-btn.download:hover {
            background: #eab308;
            color: #0f172a;
        }

        .cs-action-btn.copy {
            background: rgba(99,102,241,.12);
            border-color: #6366f1;
            color: #818cf8;
        }

        .cs-action-btn.copy:hover {
            background: #6366f1;
            color: #fff;
        }

        /* ---- Prices Row ---- */
        .cs-prices {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .cs-price-item {
            background: rgba(255,255,255,.06);
            border-radius: .65rem;
            padding: .5rem .9rem;
            text-align: center;
        }

        .cs-price-item .label {
            font-size: .7rem;
            color: #64748b;
            margin-bottom: .15rem;
        }

        .cs-price-item .val {
            font-size: 1rem;
            font-weight: 800;
            color: #eab308;
        }

        /* ---- Specs List ---- */
        .cs-specs-list {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            flex-direction: column;
            gap: .3rem;
            max-height: 200px;
            overflow-y: auto;
        }

        .cs-specs-list li {
            font-size: .82rem;
            color: #cbd5e1;
            display: flex;
            align-items: center;
            gap: .4rem;
        }

        .cs-specs-list li::before {
            content: '';
            display: inline-block;
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: #eab308;
            flex-shrink: 0;
        }

        /* ---- Variants ---- */
        .cs-variants {
            margin-top: 1.25rem;
        }

        .cs-variants h4 {
            font-size: .9rem;
            font-weight: 700;
            color: #94a3b8;
            margin-bottom: .6rem;
        }

        .cs-variants-list {
            display: flex;
            flex-direction: column;
            gap: .6rem;
        }

        .cs-variant-item {
            background: rgba(255,255,255,.05);
            border: 1px solid rgba(255,255,255,.08);
            border-radius: .65rem;
            padding: .65rem .9rem;
            display: flex;
            align-items: center;
            gap: .9rem;
        }

        .cs-variant-img {
            width: 64px;
            height: 48px;
            object-fit: cover;
            border-radius: .4rem;
            flex-shrink: 0;
        }

        .cs-variant-img-placeholder {
            width: 64px;
            height: 48px;
            background: rgba(255,255,255,.06);
            border-radius: .4rem;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .cs-variant-name {
            font-size: .85rem;
            font-weight: 700;
            color: #f1f5f9;
        }

        .cs-variant-prices {
            margin-top: .15rem;
            font-size: .72rem;
            color: #64748b;
        }

        /* ---- Section header ---- */
        .cs-section-title {
            font-size: .78rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .08em;
            color: #64748b;
            margin-bottom: .5rem;
        }

        .cs-empty {
            text-align: center;
            padding: 3rem 1rem;
            color: #475569;
        }

        /* copied toast */
        .cs-toast {
            position: fixed;
            bottom: 1.5rem;
            left: 50%;
            transform: translateX(-50%) translateY(0);
            background: #eab308;
            color: #0f172a;
            font-weight: 700;
            padding: .55rem 1.4rem;
            border-radius: .75rem;
            font-size: .88rem;
            z-index: 9999;
            pointer-events: none;
            opacity: 0;
            transition: opacity .2s;
        }

        .cs-toast.show {
            opacity: 1;
        }
    </style>

    {{-- CLIPBOARD + DOWNLOAD EVENTS --}}
    <div
        x-data="{
            toastMsg: '',
            showToast: false,
            init() {
                $wire.on('copy-to-clipboard', ({ text }) => {
                    navigator.clipboard.writeText(text).then(() => {
                        this.toastMsg = 'تم نسخ التفاصيل ✓';
                        this.showToast = true;
                        setTimeout(() => this.showToast = false, 2200);
                    });
                });
                $wire.on('download-file', ({ url }) => {
                    const a = document.createElement('a');
                    a.href = url;
                    a.download = '';
                    document.body.appendChild(a);
                    a.click();
                    document.body.removeChild(a);
                });
            }
        }"
    >
        {{-- ============================================================
             CATEGORY LISTBOX (Tabs)
        ============================================================ --}}
        <div class="cs-categories">
            <button
                class="cs-cat-btn {{ $this->selectedCategory === null ? 'active' : '' }}"
                wire:click="selectCategory(null)"
            >
                الكل
            </button>
            @foreach ($this->getCategories() as $cat)
                <button
                    class="cs-cat-btn {{ $this->selectedCategory === $cat->id ? 'active' : '' }}"
                    wire:click="selectCategory({{ $cat->id }})"
                >
                    {{ $cat->name }}
                </button>
            @endforeach
        </div>

        {{-- ============================================================
             SEARCH
        ============================================================ --}}
        <div class="cs-search-wrap">
            <svg class="cs-search-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z"/>
            </svg>
            <input
                type="text"
                class="cs-search-input"
                placeholder="ابحث بالاسم أو الموديل..."
                wire:model.live.debounce.400ms="search"
                id="cs-search-input"
            />
        </div>

        {{-- ============================================================
             CARS GRID
        ============================================================ --}}
        @php $cars = $this->getCars(); @endphp

        @if ($cars->isEmpty())
            <div class="cs-empty">
                <svg style="width:3rem;height:3rem;margin:0 auto .75rem;display:block;color:#475569" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                          d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0z"/>
                </svg>
                <p>لا توجد سيارات مطابقة</p>
            </div>
        @else
            <div class="cs-grid" wire:key="cars-grid-{{ $this->selectedCategory }}-{{ $this->search }}">
                @foreach ($cars as $car)
                    <div
                        class="cs-card {{ $this->selectedCarId === $car->id ? 'selected' : '' }}"
                        wire:click="selectCar({{ $car->id }})"
                        wire:key="car-{{ $car->id }}"
                    >
                        @if ($car->main_image)
                            <img
                                src="{{ $car->main_image }}"
                                alt="{{ $car->name }}"
                                class="cs-card-img"
                                loading="lazy"
                            />
                        @else
                            <div class="cs-card-img-placeholder">
                                <svg style="width:2.5rem;height:2.5rem;color:#334155" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.2"
                                          d="M3 9l2-4h14l2 4M3 9v7a2 2 0 002 2h14a2 2 0 002-2V9M3 9h18"/>
                                </svg>
                            </div>
                        @endif

                        <div class="cs-card-body">
                            <div class="cs-card-name">{{ $car->name }}</div>
                            <div class="cs-card-meta">
                                {{ $car->brand?->name }}
                                @if ($car->year) · {{ $car->year }} @endif
                                @if ($car->category) · {{ $car->category->name }} @endif
                            </div>

                            <div class="cs-card-price">
                                <div>
                                    @if ($car->cash_price)
                                        <div class="cs-price-num">{{ number_format($car->cash_price) }} <small style="font-size:.65rem;font-weight:500">ريال</small></div>
                                    @endif
                                    @if ($car->min_installment)
                                        <div class="cs-price-install">تبدأ من {{ number_format($car->min_installment) }} ريال/شهر</div>
                                    @endif
                                </div>
                                <button class="cs-btn-detail" wire:click.stop="selectCar({{ $car->id }})">
                                    التفاصيل
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        {{-- ============================================================
             DETAIL PANEL
        ============================================================ --}}
        @if ($this->selectedCarId)
            @php $selectedCar = $this->getSelectedCar(); @endphp
            @if ($selectedCar)
                <div class="cs-detail" wire:key="detail-{{ $selectedCar->id }}">
                    {{-- Left: Image --}}
                    <div>
                        @if ($selectedCar->main_image)
                            <img
                                src="{{ $selectedCar->main_image }}"
                                alt="{{ $selectedCar->name }}"
                                class="cs-detail-img"
                            />
                        @else
                            <div class="cs-detail-img-placeholder">
                                <svg style="width:4rem;height:4rem;color:#334155" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.2"
                                          d="M3 9l2-4h14l2 4M3 9v7a2 2 0 002 2h14a2 2 0 002-2V9M3 9h18"/>
                                </svg>
                            </div>
                        @endif

                        {{-- Variants images row --}}
                        @if ($selectedCar->variants->isNotEmpty())
                            <div class="cs-variants" style="margin-top:1rem">
                                <div class="cs-section-title">الفروقات والإضافات</div>
                                <div class="cs-variants-list">
                                    @foreach ($selectedCar->variants as $variant)
                                        <div class="cs-variant-item">
                                            @if ($variant->image_url)
                                                <img src="{{ $variant->image_url }}" class="cs-variant-img" alt="{{ $variant->name }}" />
                                            @else
                                                <div class="cs-variant-img-placeholder">
                                                    <svg style="width:1.5rem;height:1.5rem;color:#475569" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4-4 4 4 4-8 4 8"/>
                                                    </svg>
                                                </div>
                                            @endif
                                            <div>
                                                <div class="cs-variant-name">{{ $variant->name }}</div>
                                                <div class="cs-variant-prices">
                                                    @if ($variant->cash_price)
                                                        كاش: {{ number_format($variant->cash_price) }} ريال
                                                    @endif
                                                    @if ($variant->min_installment)
                                                        · قسط: {{ number_format($variant->min_installment) }} ريال/شهر
                                                    @endif
                                                </div>
                                                @if (!empty($variant->specs))
                                                    <div style="margin-top:.25rem">
                                                        @foreach ($variant->specs as $spec)
                                                            @if (!empty($spec['key']))
                                                                <span style="font-size:.7rem;color:#94a3b8">{{ $spec['key'] }}: {{ $spec['value'] ?? '' }}</span>
                                                                @if (!$loop->last)<span style="color:#334155"> · </span>@endif
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>

                    {{-- Right: Info --}}
                    <div class="cs-detail-info">
                        <h2>{{ $selectedCar->name }} {{ $selectedCar->year }}</h2>
                        <div style="font-size:.82rem;color:#64748b;margin-bottom:.75rem">
                            {{ $selectedCar->brand?->name }}
                            @if ($selectedCar->category) · {{ $selectedCar->category->name }} @endif
                        </div>

                        {{-- Action Buttons --}}
                        <div class="cs-detail-actions">
                            <button
                                class="cs-action-btn download"
                                wire:click="downloadImages"
                                wire:loading.attr="disabled"
                                id="btn-download-images"
                            >
                                <svg style="width:1rem;height:1rem" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5 5 5-5M12 4v11"/>
                                </svg>
                                <span wire:loading.remove wire:target="downloadImages">تحميل الصور</span>
                                <span wire:loading wire:target="downloadImages">جاري التحضير...</span>
                            </button>

                            <button
                                class="cs-action-btn copy"
                                wire:click="copySpecs"
                                id="btn-copy-specs"
                            >
                                <svg style="width:1rem;height:1rem" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                </svg>
                                نسخ التفاصيل
                            </button>
                        </div>

                        {{-- Prices --}}
                        <div class="cs-prices">
                            @if ($selectedCar->cash_price)
                                <div class="cs-price-item">
                                    <div class="label">سعر الكاش</div>
                                    <div class="val">{{ number_format($selectedCar->cash_price) }} <small style="font-size:.65rem">ريال</small></div>
                                </div>
                            @endif
                            @if ($selectedCar->min_installment)
                                <div class="cs-price-item">
                                    <div class="label">أقل قسط شهري</div>
                                    <div class="val">{{ number_format($selectedCar->min_installment) }} <small style="font-size:.65rem">ريال</small></div>
                                </div>
                            @endif
                            @if ($selectedCar->min_down_payment)
                                <div class="cs-price-item">
                                    <div class="label">أقل دفعة أولى</div>
                                    <div class="val">{{ number_format($selectedCar->min_down_payment) }} <small style="font-size:.65rem">ريال</small></div>
                                </div>
                            @endif
                        </div>

                        {{-- Specs --}}
                        @if ($selectedCar->specifications->isNotEmpty())
                            <div class="cs-section-title">المواصفات</div>
                            <ul class="cs-specs-list" style="margin-bottom:.9rem">
                                @foreach ($selectedCar->specifications as $spec)
                                    <li>{{ $spec->name }}@if($spec->value): <span style="color:#94a3b8">{{ $spec->value }}</span>@endif</li>
                                @endforeach
                            </ul>
                        @endif

                        {{-- Features --}}
                        @if ($selectedCar->features_list->isNotEmpty())
                            <div class="cs-section-title" style="margin-top:.75rem">المميزات</div>
                            <ul class="cs-specs-list" style="margin-bottom:.9rem">
                                @foreach ($selectedCar->features_list as $feature)
                                    <li>{{ $feature->name }}</li>
                                @endforeach
                            </ul>
                        @endif

                        {{-- Safety Features --}}
                        @if ($selectedCar->safety_features->isNotEmpty())
                            <div class="cs-section-title" style="margin-top:.75rem">مميزات السلامة</div>
                            <ul class="cs-specs-list">
                                @foreach ($selectedCar->safety_features as $sf)
                                    <li>{{ $sf->name }}</li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>
            @endif
        @endif

        {{-- Toast Notification --}}
        <div class="cs-toast" :class="{ show: showToast }" x-text="toastMsg"></div>
    </div>
</x-filament-panels::page>
