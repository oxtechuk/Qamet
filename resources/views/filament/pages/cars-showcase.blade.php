<x-filament-panels::page>
<style>
    /* ===== CARS SHOWCASE ===== */
    .cs-wrap { direction: rtl; font-family: inherit; }

    /* -- Category pills -- */
    .cs-cats {
        display: flex;
        flex-wrap: wrap;
        gap: .45rem;
        margin-bottom: 1.25rem;
    }
    .cs-cat {
        padding: .4rem 1.1rem;
        border-radius: 999px;
        font-size: .84rem;
        font-weight: 600;
        border: 1.5px solid rgba(156,163,175,.3);
        background: transparent;
        color: rgb(107 114 128);
        cursor: pointer;
        transition: all .18s;
        line-height: 1.2;
    }
    .cs-cat:hover { border-color: #dfc674; color: #dfc674; }
    .cs-cat.active { background: #dfc674; border-color: #dfc674; color: #1f2937; font-weight: 700; box-shadow: 0 2px 8px rgba(223,198,116,.3); }

    /* -- Search -- */
    .cs-search {
        position: relative;
        margin-bottom: 1.5rem;
    }
    .cs-search input {
        width: 100%;
        padding: .7rem 2.6rem .7rem 1.2rem;
        border-radius: .75rem;
        border: 1.5px solid rgb(209 213 219);
        background: #fff;
        color: rgb(17 24 39);
        font-size: .95rem;
        outline: none;
        transition: border-color .18s, box-shadow .18s;
        direction: rtl;
    }
    .dark .cs-search input {
        background: rgb(31 41 55);
        border-color: rgb(55 65 81);
        color: rgb(243 244 246);
    }
    .cs-search input:focus {
        border-color: #dfc674;
        box-shadow: 0 0 0 3px rgba(223,198,116,.2);
    }
    .cs-search-icon {
        position: absolute;
        top: 50%; right: .85rem;
        transform: translateY(-50%);
        width: 1.15rem; height: 1.15rem;
        color: rgb(156 163 175);
        pointer-events: none;
    }

    /* -- Grid -- */
    .cs-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(210px, 1fr));
        gap: 1.1rem;
    }

    /* -- Card -- */
    .cs-card {
        border-radius: 1rem;
        overflow: hidden;
        border: 1.5px solid rgb(229 231 235);
        background: #fff;
        cursor: pointer;
        transition: transform .2s, box-shadow .2s, border-color .2s;
        display: flex;
        flex-direction: column;
    }
    .dark .cs-card { background: rgb(31 41 55); border-color: rgb(55 65 81); }
    .cs-card:hover { transform: translateY(-4px); box-shadow: 0 10px 25px rgba(0,0,0,.12); border-color: #dfc674; }

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

    .cs-card-body { padding: .85rem; flex: 1; display: flex; flex-direction: column; gap: .3rem; }

    .cs-card-name {
        font-size: .88rem; font-weight: 700; line-height: 1.35;
        color: rgb(17 24 39);
        display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;
    }
    .dark .cs-card-name { color: rgb(243 244 246); }

    .cs-card-meta { font-size: .74rem; color: rgb(107 114 128); }

    .cs-card-footer {
        margin-top: auto; padding-top: .65rem;
        display: flex; align-items: center; justify-content: space-between;
        gap: .4rem;
        border-top: 1px solid rgb(243 244 246);
    }
    .dark .cs-card-footer { border-top-color: rgb(55 65 81); }

    .cs-card-price { font-size: 1rem; font-weight: 800; color: #b89327; }
    .dark .cs-card-price { color: #dfc674; }
    .cs-card-install { font-size: .68rem; color: rgb(107 114 128); margin-top: 2px; }

    .cs-btn {
        padding: .35rem .85rem;
        background: #dfc674; color: #1f2937;
        font-size: .76rem; font-weight: 700;
        border-radius: .5rem; border: none; cursor: pointer;
        transition: all .15s; white-space: nowrap;
        flex-shrink: 0;
    }
    .cs-btn:hover { background: #caa946; color: #000; }

    /* -- Empty state -- */
    .cs-empty { text-align: center; padding: 4rem 1rem; color: rgb(156 163 175); }

    /* ============================================================
       POPUP MODAL (بوب أب التفاصيل)
    ============================================================ */
    .cs-modal-overlay {
        position: fixed;
        inset: 0;
        z-index: 99999;
        background: rgba(15, 23, 42, 0.7);
        backdrop-filter: blur(6px);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 1.25rem;
        overflow-y: auto;
    }

    .cs-modal-card {
        width: 100%;
        max-width: 960px;
        max-height: 92vh;
        background: #ffffff;
        border-radius: 1.25rem;
        box-shadow: 0 25px 60px -15px rgba(0, 0, 0, 0.4);
        display: flex;
        flex-direction: column;
        overflow: hidden;
        animation: csModalPop .24s cubic-bezier(0.16, 1, 0.3, 1);
        border: 1px solid rgba(229, 231, 235, 0.8);
    }
    .dark .cs-modal-card {
        background: rgb(31 41 55);
        border-color: rgb(55 65 81);
        box-shadow: 0 25px 60px -15px rgba(0, 0, 0, 0.7);
    }

    @keyframes csModalPop {
        from { opacity: 0; transform: scale(0.94) translateY(10px); }
        to { opacity: 1; transform: scale(1) translateY(0); }
    }

    /* Modal Header */
    .cs-modal-header {
        background: #0f172a;
        padding: 1.25rem 1.75rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        border-bottom: 1px solid rgba(223, 198, 116, 0.25);
    }
    .cs-modal-header h2 {
        font-size: 1.25rem;
        font-weight: 800;
        color: #ffffff;
        margin: 0;
        line-height: 1.3;
        letter-spacing: -0.01em;
    }
    .cs-modal-header .sub {
        display: flex;
        align-items: center;
        gap: .5rem;
        margin-top: .35rem;
    }
    .cs-modal-badge {
        font-size: .72rem;
        font-weight: 700;
        padding: .2rem .6rem;
        border-radius: 999px;
        background: rgba(223, 198, 116, 0.15);
        color: #dfc674;
        border: 1px solid rgba(223, 198, 116, 0.3);
    }
    .cs-modal-badge.muted {
        background: rgba(255, 255, 255, 0.08);
        color: #94a3b8;
        border-color: rgba(255, 255, 255, 0.12);
    }
    .cs-modal-close {
        width: 2.25rem;
        height: 2.25rem;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.08);
        border: 1px solid rgba(255, 255, 255, 0.12);
        color: #cbd5e1;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all .18s ease;
    }
    .cs-modal-close:hover {
        background: rgba(255, 255, 255, 0.18);
        color: #ffffff;
        transform: scale(1.05);
    }
    .cs-modal-close svg { width: 1.15rem; height: 1.15rem; }

    /* Modal Body */
    .cs-modal-body {
        padding: 1.5rem 1.75rem;
        overflow-y: auto;
        flex: 1;
        display: flex;
        flex-direction: column;
        gap: 1.25rem;
        background: #ffffff;
    }
    .dark .cs-modal-body {
        background: #111827;
    }

    /* Top bar inside modal: Actions + Prices */
    .cs-modal-topbar {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        padding: 1rem 1.25rem;
        border-radius: .85rem;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
    }
    .dark .cs-modal-topbar {
        background: #1e293b;
        border-color: #334155;
    }

    /* Action buttons */
    .cs-actions { display: flex; gap: .75rem; flex-wrap: wrap; }
    .cs-act-btn {
        display: inline-flex; align-items: center; gap: .5rem;
        padding: .6rem 1.15rem; border-radius: .65rem; font-size: .84rem; font-weight: 700;
        cursor: pointer; transition: all .18s; border: none;
    }
    .cs-act-btn svg { width: 1.1rem; height: 1.1rem; }
    .cs-act-btn.dl {
        background: linear-gradient(135deg, #dfc674 0%, #caa946 100%);
        color: #0f172a;
        box-shadow: 0 2px 8px rgba(223, 198, 116, 0.35);
    }
    .cs-act-btn.dl:hover {
        background: linear-gradient(135deg, #caa946 0%, #b89327 100%);
        box-shadow: 0 4px 12px rgba(223, 198, 116, 0.45);
        transform: translateY(-1px);
    }
    .cs-act-btn.cp {
        background: #ffffff;
        color: #334155;
        border: 1px solid #cbd5e1;
    }
    .dark .cs-act-btn.cp {
        background: #0f172a;
        color: #e2e8f0;
        border-color: #475569;
    }
    .cs-act-btn.cp:hover {
        background: #f1f5f9;
        border-color: #94a3b8;
    }
    .dark .cs-act-btn.cp:hover {
        background: #1e293b;
    }

    /* Prices boxes */
    .cs-prices { display: flex; flex-wrap: wrap; gap: .6rem; }
    .cs-price-box {
        background: #ffffff; border: 1px solid #e2e8f0;
        border-radius: .65rem; padding: .45rem .95rem; text-align: center; min-width: 100px;
    }
    .dark .cs-price-box {
        background: #0f172a; border-color: #334155;
    }
    .cs-price-box .lbl { font-size: .7rem; font-weight: 600; color: #64748b; margin-bottom: 2px; }
    .cs-price-box .val { font-size: 1.05rem; font-weight: 800; color: #0f172a; }
    .dark .cs-price-box .val { color: #f8fafc; }
    .cs-price-box.highlight {
        border-color: rgba(223, 198, 116, 0.4);
        background: rgba(223, 198, 116, 0.08);
    }
    .cs-price-box.highlight .val { color: #b89327; }
    .dark .cs-price-box.highlight .val { color: #dfc674; }

    /* Modal Main Content Grid */
    .cs-modal-grid {
        display: grid;
        grid-template-columns: 370px 1fr;
        gap: 1.5rem;
    }
    @media (max-width: 820px) {
        .cs-modal-grid { grid-template-columns: 1fr; }
    }

    /* Left Column (Visuals: Main image, Colors, Variants) */
    .cs-modal-visuals {
        display: flex;
        flex-direction: column;
        gap: 1.1rem;
    }
    .cs-modal-main-img {
        width: 100%; aspect-ratio: 16/11;
        border-radius: .85rem; object-fit: cover;
        background: #f1f5f9;
        border: 1px solid #e2e8f0;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
    }
    .dark .cs-modal-main-img {
        background: #1e293b; border-color: #334155;
    }

    /* Section Labels */
    .cs-sec-title {
        font-size: .8rem; font-weight: 800;
        color: #475569; margin: .35rem 0 .5rem;
        display: flex; align-items: center; gap: .45rem;
        text-transform: uppercase;
        letter-spacing: .02em;
    }
    .dark .cs-sec-title { color: #94a3b8; }
    .cs-sec-title svg {
        width: 1.05rem; height: 1.05rem;
        color: #dfc674;
        flex-shrink: 0;
    }

    /* Color Swatches list */
    .cs-colors-row {
        display: flex;
        flex-wrap: wrap;
        gap: .45rem;
        margin-bottom: .4rem;
    }
    .cs-color-chip {
        display: inline-flex;
        align-items: center;
        gap: .4rem;
        padding: .32rem .75rem;
        border-radius: 999px;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        font-size: .76rem;
        font-weight: 700;
        color: #334155;
    }
    .dark .cs-color-chip {
        background: #1e293b; border-color: #334155; color: #e2e8f0;
    }
    .cs-color-dot {
        width: 12px; height: 12px; border-radius: 50%;
        border: 1px solid rgba(0,0,0,.15);
        box-shadow: inset 0 1px 2px rgba(0,0,0,0.1);
        flex-shrink: 0;
    }

    /* Variants list */
    .cs-variant-item {
        display: flex;
        align-items: center;
        gap: .75rem;
        padding: .65rem .85rem;
        border-radius: .75rem;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        margin-bottom: .5rem;
    }
    .dark .cs-variant-item {
        background: #1e293b; border-color: #334155;
    }
    .cs-variant-img {
        width: 60px; height: 45px; object-fit: cover;
        border-radius: .45rem; flex-shrink: 0;
        border: 1px solid #e2e8f0;
    }
    .dark .cs-variant-img { border-color: #334155; }
    .cs-variant-noimg {
        width: 60px; height: 45px; background: #e2e8f0;
        border-radius: .45rem; flex-shrink: 0;
        display: flex; align-items: center; justify-content: center;
    }
    .dark .cs-variant-noimg { background: #334155; }
    .cs-variant-name { font-size: .84rem; font-weight: 800; color: #0f172a; }
    .dark .cs-variant-name { color: #f8fafc; }
    .cs-variant-sub { font-size: .74rem; color: #64748b; margin-top: 2px; }

    /* Right Column (Specifications, Features, Safety) */
    .cs-modal-details {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }
    .cs-specs-box {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: .85rem;
        padding: 1rem 1.15rem;
    }
    .dark .cs-specs-box {
        background: #1e293b; border-color: #334155;
    }

    .cs-list {
        list-style: none; padding: 0; margin: 0;
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(210px, 1fr));
        gap: .5rem .85rem;
    }
    .cs-list li {
        font-size: .82rem; color: #334155;
        display: flex; align-items: center; gap: .5rem;
        line-height: 1.4;
    }
    .dark .cs-list li { color: #cbd5e1; }
    .cs-bullet-dot {
        width: 5px; height: 5px; border-radius: 50%;
        background: #dfc674; flex-shrink: 0;
    }
    .cs-spec-val {
        font-weight: 700; color: #0f172a;
    }
    .dark .cs-spec-val { color: #dfc674; }

    /* Toast */
    .cs-toast {
        position: fixed; bottom: 1.5rem; left: 50%;
        transform: translateX(-50%);
        background: #0f172a; color: #ffffff;
        font-weight: 700; font-size: .88rem;
        padding: .65rem 1.5rem; border-radius: .75rem;
        z-index: 100000; pointer-events: none;
        opacity: 0; transition: opacity .2s, transform .2s;
        box-shadow: 0 10px 25px rgba(0,0,0,.35);
        border: 1px solid rgba(223, 198, 116, 0.4);
    }
    .cs-toast.show { opacity: 1; transform: translateX(-50%) translateY(-5px); }
</style>

<div
    class="cs-wrap"
    x-data="{
        toast: false,
        toastMsg: '',
        showToast(msg) {
            this.toastMsg = msg;
            this.toast = true;
            setTimeout(() => this.toast = false, 2500);
        },
        init() {
            $wire.on('copy-to-clipboard', ({ text }) => {
                navigator.clipboard.writeText(text).then(() => {
                    this.showToast('✓ تم نسخ المواصفات بنجاح');
                });
            });
            $wire.on('download-file', ({ url }) => {
                this.showToast('جاري بدء تحميل الملف المضغوط...');
                const a = document.createElement('a');
                a.href = url;
                a.download = '';
                document.body.appendChild(a);
                a.click();
                document.body.removeChild(a);
            });
            $wire.on('toast-message', ({ message }) => {
                this.showToast(message);
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
            placeholder="ابحث باسم السيارة أو الموديل أو الماركة..."
            wire:model.live.debounce.400ms="search"
            id="cs-search"
        />
    </div>

    {{-- ====== CARS GRID ====== --}}
    @php $cars = $this->getCars(); @endphp

    @if ($cars->isEmpty())
        <div class="cs-empty">
            <svg style="width:3rem;height:3rem;margin:0 auto .75rem;display:block;color:rgb(156 163 175)" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0z"/>
            </svg>
            <p style="font-size:1rem;font-weight:600">لا توجد سيارات مطابقة لبحثك</p>
        </div>
    @else
        <div class="cs-grid">
            @foreach ($cars as $car)
                <div
                    class="cs-card"
                    wire:click="selectCar({{ $car->id }})"
                    wire:key="car-{{ $car->id }}"
                    title="اضغط لعرض تفاصيل {{ $car->name }}"
                >
                    @if ($car->main_image)
                        <img src="{{ $car->main_image }}" alt="{{ $car->name }}" class="cs-card-img" loading="lazy"/>
                    @else
                        <div class="cs-card-noimg">
                            <svg style="width:2.2rem;height:2.2rem;color:rgb(209 213 219)" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
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
                                    <div class="cs-card-price">{{ number_format($car->cash_price) }} <small style="font-size:.65rem;font-weight:600">ريال</small></div>
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

    {{-- ============================================================
         POPUP MODAL (بوب أب التفاصيل)
    ============================================================ --}}
    @if ($this->selectedCarId)
        @php $sc = $this->getSelectedCar(); @endphp
        @if ($sc)
            <div
                class="cs-modal-overlay"
                x-data
                x-init="document.body.style.overflow = 'hidden'"
                x-destroy="document.body.style.overflow = ''"
                @keydown.escape.window="$wire.selectCar({{ $sc->id }})"
                wire:click.self="selectCar({{ $sc->id }})"
                wire:key="modal-{{ $sc->id }}"
            >
                <div class="cs-modal-card">

                    {{-- Modal Header --}}
                    <div class="cs-modal-header">
                        <div>
                            <h2>{{ str_contains($sc->name, (string) $sc->year) ? $sc->name : "{$sc->name} {$sc->year}" }}</h2>
                            <div class="sub">
                                <span class="cs-modal-badge">{{ $sc->brand?->name }}</span>
                                @if($sc->year)<span class="cs-modal-badge muted">{{ $sc->year }}</span>@endif
                                @if($sc->category)<span class="cs-modal-badge muted">{{ $sc->category->name }}</span>@endif
                            </div>
                        </div>
                        <button class="cs-modal-close" wire:click="selectCar({{ $sc->id }})" title="إغلاق (Esc)">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>

                    {{-- Modal Body --}}
                    <div class="cs-modal-body">

                        {{-- Top Bar: Action Buttons + Price Badges --}}
                        <div class="cs-modal-topbar">
                            <div class="cs-actions">
                                <button
                                    class="cs-act-btn dl"
                                    wire:click="downloadImages"
                                    wire:loading.attr="disabled"
                                    wire:target="downloadImages"
                                    title="تحميل مجلد مضغوط يحتوي على كافة الصور مجمعة بالألوان والفئات"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5 5 5-5M12 4v11"/>
                                    </svg>
                                    <span wire:loading.remove wire:target="downloadImages">تحميل كافة الصور (ZIP)</span>
                                    <span wire:loading wire:target="downloadImages">جاري التحضير والضغط...</span>
                                </button>
                                <button class="cs-act-btn cp" wire:click="copySpecs">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                    </svg>
                                    نسخ التفاصيل
                                </button>
                            </div>

                            @if ($sc->cash_price || $sc->min_installment || $sc->min_down_payment)
                                <div class="cs-prices">
                                    @if ($sc->cash_price)
                                        <div class="cs-price-box highlight">
                                            <div class="lbl">سعر الكاش</div>
                                            <div class="val">{{ number_format($sc->cash_price) }} <small style="font-size:.7rem;font-weight:700">ريال</small></div>
                                        </div>
                                    @endif
                                    @if ($sc->min_installment)
                                        <div class="cs-price-box">
                                            <div class="lbl">أقل قسط شهري</div>
                                            <div class="val">{{ number_format($sc->min_installment) }} <small style="font-size:.7rem;font-weight:700">ريال/شهر</small></div>
                                        </div>
                                    @endif
                                    @if ($sc->min_down_payment)
                                        <div class="cs-price-box">
                                            <div class="lbl">أقل دفعة أولى</div>
                                            <div class="val">{{ number_format($sc->min_down_payment) }} <small style="font-size:.7rem;font-weight:700">ريال</small></div>
                                        </div>
                                    @endif
                                </div>
                            @endif
                        </div>

                        {{-- Main Grid --}}
                        <div class="cs-modal-grid">

                            {{-- Left Column: Images & Variants --}}
                            <div class="cs-modal-visuals">
                                @if ($sc->main_image)
                                    <img src="{{ $sc->main_image }}" alt="{{ $sc->name }}" class="cs-modal-main-img"/>
                                @else
                                    <div class="cs-card-noimg" style="border-radius:.85rem">
                                        <svg style="width:3rem;height:3rem;color:rgb(209 213 219)" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M3 9l2-4h14l2 4M3 9v7a2 2 0 002 2h14a2 2 0 002-2V9M3 9h18"/>
                                        </svg>
                                    </div>
                                @endif

                                {{-- Exterior Colors --}}
                                @php $extColors = $sc->exterior_colors ?? $sc->colors ?? []; @endphp
                                @if (!empty($extColors) && is_array($extColors))
                                    <div>
                                        <div class="cs-sec-title">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4 4 4 0 014-4c.734 0 1.423.2 2.012.552A7.001 7.001 0 0115 5a7 7 0 017 7 0 017 7 7 7 0 01-7 7c-.734 0-1.423-.2-2.012-.552A4.001 4.001 0 017 21z"/>
                                            </svg>
                                            الألوان الخارجية المتاحة
                                        </div>
                                        <div class="cs-colors-row">
                                            @foreach ($extColors as $c)
                                                <span class="cs-color-chip">
                                                    @if (!empty($c['hex']))
                                                        <span class="cs-color-dot" style="background-color: {{ $c['hex'] }}"></span>
                                                    @endif
                                                    {{ $c['name'] ?? 'لون' }}
                                                </span>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif

                                {{-- Interior Colors --}}
                                @if (!empty($sc->interior_colors) && is_array($sc->interior_colors))
                                    <div>
                                        <div class="cs-sec-title">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                                            </svg>
                                            ألوان المقصورة والفرش الداخلي
                                        </div>
                                        <div class="cs-colors-row">
                                            @foreach ($sc->interior_colors as $c)
                                                <span class="cs-color-chip">
                                                    @if (!empty($c['hex']))
                                                        <span class="cs-color-dot" style="background-color: {{ $c['hex'] }}"></span>
                                                    @endif
                                                    {{ $c['name'] ?? 'لون داخلي' }}
                                                </span>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif

                                {{-- Variants (الفروقات والإضافات / الفئات) --}}
                                @if ($sc->variants->isNotEmpty())
                                    <div>
                                        <div class="cs-sec-title">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                                            </svg>
                                            الفئات والموديلات الإضافية
                                        </div>
                                        @foreach ($sc->variants as $v)
                                            <div class="cs-variant-item">
                                                @if ($v->image_url)
                                                    <img src="{{ $v->image_url }}" class="cs-variant-img" alt="{{ $v->name }}"/>
                                                @else
                                                    <div class="cs-variant-noimg">
                                                        <svg style="width:1.2rem;height:1.2rem;color:rgb(156 163 175)" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4-4 4 4 4-8 4 8"/>
                                                        </svg>
                                                    </div>
                                                @endif
                                                <div style="flex:1">
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
                                    </div>
                                @endif
                            </div>

                            {{-- Right Column: Specs & Features --}}
                            <div class="cs-modal-details">

                                {{-- Specifications --}}
                                @if ($sc->specifications->isNotEmpty())
                                    <div class="cs-specs-box">
                                        <div class="cs-sec-title">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                            </svg>
                                            المواصفات الأساسية
                                        </div>
                                        <ul class="cs-list">
                                            @foreach ($sc->specifications as $spec)
                                                <li>
                                                    <span class="cs-bullet-dot"></span>
                                                    <span>{{ $spec->name }}@if($spec->value): <strong class="cs-spec-val">{{ $spec->value }}</strong>@endif</span>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                {{-- Features --}}
                                @if ($sc->features_list->isNotEmpty())
                                    <div class="cs-specs-box">
                                        <div class="cs-sec-title">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                                            </svg>
                                            المميزات والتجهيزات
                                        </div>
                                        <ul class="cs-list">
                                            @foreach ($sc->features_list as $f)
                                                <li>
                                                    <span class="cs-bullet-dot"></span>
                                                    <span>{{ $f->name }}</span>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                {{-- Safety Features --}}
                                @if ($sc->safety_features->isNotEmpty())
                                    <div class="cs-specs-box">
                                        <div class="cs-sec-title">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                            </svg>
                                            أنظمة السلامة والأمان
                                        </div>
                                        <ul class="cs-list">
                                            @foreach ($sc->safety_features as $sf)
                                                <li>
                                                    <span class="cs-bullet-dot"></span>
                                                    <span>{{ $sf->name }}</span>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                @if ($sc->specifications->isEmpty() && $sc->features_list->isEmpty() && $sc->safety_features->isEmpty())
                                    <div class="cs-empty" style="padding:2rem">
                                        لا توجد مواصفات مدخلة لهذه السيارة
                                    </div>
                                @endif

                            </div>

                        </div>

                    </div>

                </div>
            </div>
        @endif
    @endif

    {{-- Toast notification --}}
    <div class="cs-toast" :class="{ show: toast }" x-text="toastMsg"></div>

</div>
</x-filament-panels::page>
