<x-filament-panels::page>
<style>
    .ad-kpi-bar {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 1rem;
        margin-bottom: 1.5rem;
    }
    @media (max-width: 1200px) { .ad-kpi-bar { grid-template-columns: repeat(3, 1fr); } }
    @media (max-width: 640px)  { .ad-kpi-bar { grid-template-columns: repeat(2, 1fr); } }

    .ad-platform-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1.25rem;
        margin-bottom: 1.5rem;
    }
    @media (max-width: 1100px) { .ad-platform-grid { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 600px)  { .ad-platform-grid { grid-template-columns: 1fr; } }

    .ad-card {
        border-radius: 1rem;
        padding: 1.25rem;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        border: 1px solid rgba(100,116,139,0.15);
        background: #ffffff;
        box-shadow: 0 2px 8px -2px rgba(0,0,0,0.05);
        position: relative;
        overflow: hidden;
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .ad-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px -4px rgba(0,0,0,0.08);
    }
    .dark .ad-card {
        background: rgb(var(--fi-color-gray-900) / 0.7);
        border-color: rgb(var(--fi-color-gray-800) / 1);
    }

    .ad-card-accent-strip {
        position: absolute;
        top: 0;
        right: 0;
        left: 0;
        height: 4px;
    }

    .ad-section {
        background: #ffffff;
        border: 1px solid rgb(var(--fi-color-gray-200) / 1);
        border-radius: 1rem;
        padding: 1.25rem;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.05);
    }
    .dark .ad-section {
        background: rgb(var(--fi-color-gray-900) / 0.5);
        border-color: rgb(var(--fi-color-gray-800) / 1);
    }

    .ad-quick-btn {
        padding: 0.35rem 0.85rem;
        border-radius: 0.5rem;
        font-size: 0.75rem;
        font-weight: 600;
        background: rgba(100,116,139,0.08);
        color: #475569;
        cursor: pointer;
        border: 1px solid transparent;
        transition: all 0.15s;
    }
    .ad-quick-btn:hover {
        background: rgba(var(--primary-500), 0.15);
        color: rgb(var(--primary-600));
    }
    .dark .ad-quick-btn {
        color: #cbd5e1;
        background: rgba(255,255,255,0.05);
    }

    .ad-tab-btn {
        padding: 0.6rem 1.25rem;
        font-size: 0.85rem;
        font-weight: 700;
        border-bottom: 2px solid transparent;
        color: #64748b;
        transition: all 0.2s;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .ad-tab-btn.active {
        color: rgb(var(--primary-600));
        border-bottom-color: rgb(var(--primary-600));
    }
    .dark .ad-tab-btn.active {
        color: rgb(var(--primary-400));
        border-bottom-color: rgb(var(--primary-400));
    }

    .ad-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        padding: 0.2rem 0.65rem;
        border-radius: 999px;
        font-size: 0.72rem;
        font-weight: 700;
        white-space: nowrap;
    }

    .ad-table {
        width: 100%;
        font-size: 0.82rem;
        border-collapse: collapse;
    }
    .ad-table th {
        padding: 0.75rem 1rem;
        text-align: right;
        font-size: 0.72rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        color: #64748b;
        border-bottom: 1px solid rgba(100,116,139,0.15);
        white-space: nowrap;
        background: rgba(100,116,139,0.03);
    }
    .ad-table td {
        padding: 0.85rem 1rem;
        vertical-align: middle;
        border-bottom: 1px solid rgba(100,116,139,0.08);
    }
    .ad-table tr:last-child td { border-bottom: none; }
    .ad-table tbody tr:hover { background: rgba(100,116,139,0.04); }

    .ad-progress-track {
        width: 100%;
        background: rgba(100,116,139,0.15);
        border-radius: 999px;
        overflow: hidden;
        height: 6px;
    }
    .ad-progress-fill {
        height: 6px;
        border-radius: 999px;
        transition: width 0.6s ease;
    }
</style>

@php
    $kpis = $this->getOverviewKpis();
    $platforms = $this->getPlatformBreakdown();
    $campaigns = $this->getCampaignBreakdown();
    $topCars = $this->getTopCars();
    $timeline = $this->getTimelineChartData();
@endphp

@if (! ($kpis['schema_ready'] ?? true))
    <div class="p-4 mb-6 rounded-xl border border-amber-300 bg-amber-50 dark:bg-amber-950/40 dark:border-amber-700 text-amber-900 dark:text-amber-200 shadow-sm">
        <div class="flex items-start gap-3">
            <x-filament::icon icon="heroicon-o-exclamation-triangle" class="w-6 h-6 text-amber-600 flex-shrink-0 mt-0.5" />
            <div class="space-y-2 text-xs flex-1">
                <h3 class="font-bold text-sm text-amber-800 dark:text-amber-100">تنبيه: قاعدة البيانات الحالية بحاجة لتشغيل أمر التحديث (Migration)</h3>
                <p>قاعدة البيانات المتصلة لا تحتوي بعد على أعمدة التتبع الإعلاني (<code class="font-mono bg-amber-100 dark:bg-amber-900 px-1 py-0.5 rounded text-amber-950 dark:text-amber-100 font-bold">ad_platform</code>). لتفعيل الإحصائيات بالكامل، يرجى تنفيذ أحد الخيارين:</p>
                <div class="space-y-1">
                    <p class="font-semibold text-gray-800 dark:text-gray-200">الخيار 1 (عبر سطر الأوامر Terminal على السيرفر):</p>
                    <pre class="bg-gray-900 text-emerald-400 p-2.5 rounded-lg text-[11px] font-mono select-all">php artisan migrate --force</pre>
                </div>
                <div class="space-y-1 pt-1">
                    <p class="font-semibold text-gray-800 dark:text-gray-200">الخيار 2 (تنفيذ استعلام SQL مباشرة في phpMyAdmin أو استضافة السيرفر):</p>
                    <pre class="bg-gray-900 text-slate-200 p-2.5 rounded-lg text-[11px] font-mono overflow-x-auto select-all">ALTER TABLE `bookings` ADD COLUMN `ad_platform` VARCHAR(50) NULL AFTER `source`, ADD COLUMN `utm_source` VARCHAR(255) NULL AFTER `ad_platform`, ADD COLUMN `utm_medium` VARCHAR(255) NULL AFTER `utm_source`, ADD COLUMN `utm_campaign` VARCHAR(255) NULL AFTER `utm_medium`, ADD COLUMN `utm_content` VARCHAR(255) NULL AFTER `utm_campaign`, ADD COLUMN `utm_term` VARCHAR(255) NULL AFTER `utm_content`, ADD COLUMN `click_id` VARCHAR(255) NULL AFTER `utm_term`, ADD COLUMN `referrer_url` TEXT NULL AFTER `click_id`, ADD INDEX `bookings_ad_platform_index` (`ad_platform`), ADD INDEX `bookings_attribution_perf_idx` (`ad_platform`, `status`, `created_at`);

ALTER TABLE `leads` ADD COLUMN `ad_platform` VARCHAR(50) NULL AFTER `status`, ADD COLUMN `utm_source` VARCHAR(255) NULL AFTER `ad_platform`, ADD COLUMN `utm_medium` VARCHAR(255) NULL AFTER `utm_source`, ADD COLUMN `utm_campaign` VARCHAR(255) NULL AFTER `utm_medium`, ADD COLUMN `utm_content` VARCHAR(255) NULL AFTER `utm_campaign`, ADD COLUMN `utm_term` VARCHAR(255) NULL AFTER `utm_content`, ADD COLUMN `click_id` VARCHAR(255) NULL AFTER `utm_term`, ADD COLUMN `referrer_url` TEXT NULL AFTER `click_id`, ADD INDEX `leads_ad_platform_index` (`ad_platform`), ADD INDEX `leads_attribution_perf_idx` (`ad_platform`, `status`, `created_at`);</pre>
                </div>
            </div>
        </div>
    </div>
@endif

{{-- ==================== 1. FILTER BAR ==================== --}}
<div class="ad-section mb-5">
    <div class="flex flex-wrap items-center justify-between gap-3 mb-4 pb-3 border-b border-gray-100 dark:border-gray-800">
        <div class="flex items-center gap-2">
            <x-filament::icon icon="heroicon-m-funnel" class="h-5 w-5 text-primary-500" />
            <h2 class="text-sm font-bold text-gray-800 dark:text-gray-200">فلاتر نطاق التحليل والحملات</h2>
        </div>

        {{-- Quick Date Presets --}}
        <div class="flex flex-wrap items-center gap-1.5">
            <button type="button" wire:click="setQuickFilter('today')" class="ad-quick-btn">اليوم</button>
            <button type="button" wire:click="setQuickFilter('yesterday')" class="ad-quick-btn">أمس</button>
            <button type="button" wire:click="setQuickFilter('last7')" class="ad-quick-btn">آخر 7 أيام</button>
            <button type="button" wire:click="setQuickFilter('month')" class="ad-quick-btn font-bold text-primary-600">هذا الشهر</button>
            <button type="button" wire:click="setQuickFilter('last_month')" class="ad-quick-btn">الشهر الماضي</button>
            <button type="button" wire:click="setQuickFilter('quarter')" class="ad-quick-btn">هذا الربع</button>
            <button type="button" wire:click="setQuickFilter('year')" class="ad-quick-btn">هذه السنة</button>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div>
            <label class="block text-xs font-semibold mb-1 text-gray-600 dark:text-gray-400">من تاريخ</label>
            <x-filament::input.wrapper>
                <x-filament::input type="date" wire:model.live="filters.date_from" />
            </x-filament::input.wrapper>
        </div>
        <div>
            <label class="block text-xs font-semibold mb-1 text-gray-600 dark:text-gray-400">إلى تاريخ</label>
            <x-filament::input.wrapper>
                <x-filament::input type="date" wire:model.live="filters.date_to" />
            </x-filament::input.wrapper>
        </div>
        <div>
            <label class="block text-xs font-semibold mb-1 text-gray-600 dark:text-gray-400">المنصة الإعلانية</label>
            <x-filament::input.wrapper>
                <x-filament::input.select wire:model.live="filters.platform">
                    <option value="">جميع المنصات الإعلانية</option>
                    <option value="google">Google Ads & Analytics</option>
                    <option value="meta">Meta (Facebook & Instagram)</option>
                    <option value="snapchat">Snapchat Ads</option>
                    <option value="tiktok">TikTok Ads</option>
                </x-filament::input.select>
            </x-filament::input.wrapper>
        </div>
    </div>
</div>

{{-- ==================== 2. OVERVIEW KPI CARDS ==================== --}}
<div class="ad-kpi-bar">
    {{-- KPI 1: Ad Leads --}}
    <div class="ad-card">
        <div class="ad-card-accent-strip" style="background: #3b82f6;"></div>
        <div class="flex items-center justify-between text-xs text-gray-500 font-semibold mb-1">
            <span>عملاء الإعلانات (Leads)</span>
            <x-filament::icon icon="heroicon-o-user-plus" class="w-4 h-4 text-blue-500" />
        </div>
        <div class="text-2xl font-extrabold text-gray-900 dark:text-white">
            {{ number_format($kpis['total_ad_leads']) }}
        </div>
        <div class="text-xs text-gray-500 mt-2">
            من إجمالي {{ number_format($kpis['total_ad_bookings']) }} طلب حجز مبدئي
        </div>
    </div>

    {{-- KPI 2: Sold Ad Bookings --}}
    <div class="ad-card">
        <div class="ad-card-accent-strip" style="background: #10b981;"></div>
        <div class="flex items-center justify-between text-xs text-gray-500 font-semibold mb-1">
            <span>مبيعات الإعلانات المؤكدة</span>
            <x-filament::icon icon="heroicon-o-check-badge" class="w-4 h-4 text-emerald-500" />
        </div>
        <div class="text-2xl font-extrabold text-emerald-600 dark:text-emerald-400">
            {{ number_format($kpis['sold_ad_bookings']) }}
        </div>
        <div class="text-xs text-emerald-600 font-medium mt-2">
            معدل التحويل: {{ $kpis['conversion_rate'] }}%
        </div>
    </div>

    {{-- KPI 3: Ad Revenue --}}
    <div class="ad-card">
        <div class="ad-card-accent-strip" style="background: #8b5cf6;"></div>
        <div class="flex items-center justify-between text-xs text-gray-500 font-semibold mb-1">
            <span>إيرادات مبيعات الإعلانات</span>
            <x-filament::icon icon="heroicon-o-banknotes" class="w-4 h-4 text-purple-500" />
        </div>
        <div class="text-2xl font-extrabold text-purple-600 dark:text-purple-400">
            {{ number_format($kpis['total_ad_revenue']) }} <span class="text-xs font-normal">ر.س</span>
        </div>
        <div class="text-xs text-gray-500 mt-2">
            متوسط الصفقة: {{ number_format($kpis['avg_deal_size']) }} ر.س
        </div>
    </div>

    {{-- KPI 4: Top Platform --}}
    <div class="ad-card">
        <div class="ad-card-accent-strip" style="background: #f59e0b;"></div>
        <div class="flex items-center justify-between text-xs text-gray-500 font-semibold mb-1">
            <span>المنصة الأكثر ربحية</span>
            <x-filament::icon icon="heroicon-o-trophy" class="w-4 h-4 text-amber-500" />
        </div>
        <div class="text-lg font-bold text-gray-900 dark:text-white truncate" title="{{ $kpis['top_platform_name'] }}">
            {{ $kpis['top_platform_name'] }}
        </div>
        <div class="text-xs text-amber-600 font-medium mt-2">
            الأعلى مساهمة في مبيعات الفترة
        </div>
    </div>

    {{-- KPI 5: Organic / Direct Comparison --}}
    <div class="ad-card">
        <div class="ad-card-accent-strip" style="background: #64748b;"></div>
        <div class="flex items-center justify-between text-xs text-gray-500 font-semibold mb-1">
            <span>المبيعات المباشرة (Organic)</span>
            <x-filament::icon icon="heroicon-o-arrow-trending-up" class="w-4 h-4 text-slate-500" />
        </div>
        <div class="text-2xl font-extrabold text-slate-700 dark:text-slate-300">
            {{ number_format($kpis['organic_sold']) }}
        </div>
        <div class="text-xs text-gray-500 mt-2">
            إيراد: {{ number_format($kpis['organic_revenue']) }} ر.س
        </div>
    </div>
</div>

{{-- ==================== 3. 4-PLATFORMS COMPARISON GRID ==================== --}}
<div class="flex items-center justify-between mb-3">
    <h3 class="text-sm font-bold text-gray-800 dark:text-gray-200 flex items-center gap-2">
        <x-filament::icon icon="heroicon-m-squares-2x2" class="w-4 h-4 text-primary-500" />
        مقارنة أداء المنصات الإعلانية الأربعة (Google, Meta, Snapchat, TikTok)
    </h3>
</div>

<div class="ad-platform-grid">
    @foreach ($platforms as $key => $p)
        <div class="ad-card relative group" style="border-top: 4px solid {{ $p['color'] }};">
            {{-- Platform Header --}}
            <div class="flex items-center justify-between mb-3">
                <div class="flex items-center gap-2">
                    <span class="w-3 h-3 rounded-full" style="background-color: {{ $p['color'] }};"></span>
                    <span class="font-extrabold text-sm text-gray-900 dark:text-white">
                        {{ $p['name_ar'] }}
                    </span>
                </div>
                <span class="ad-badge" style="background: {{ $p['color'] }}20; color: {{ $p['color'] }};">
                    {{ $p['conversion_rate'] }}% تحويل
                </span>
            </div>

            {{-- Metrics Breakdown --}}
            <div class="space-y-2.5 my-2">
                <div class="flex items-center justify-between text-xs">
                    <span class="text-gray-500">عملاء محتملون (Leads):</span>
                    <span class="font-bold text-gray-900 dark:text-gray-100">{{ number_format($p['total_leads']) }}</span>
                </div>

                <div class="flex items-center justify-between text-xs">
                    <span class="text-gray-500">مبيعات مكتملة (Sold):</span>
                    <span class="font-bold text-emerald-600 dark:text-emerald-400">{{ number_format($p['sold_bookings']) }}</span>
                </div>

                <div class="flex items-center justify-between text-xs">
                    <span class="text-gray-500">قيد التفاوض والعروض:</span>
                    <span class="font-semibold text-amber-600">{{ number_format($p['negotiation_bookings']) }}</span>
                </div>

                <div class="flex items-center justify-between text-xs pt-2 border-t border-gray-100 dark:border-gray-800">
                    <span class="text-gray-600 dark:text-gray-400 font-semibold">إجمالي المبيعات:</span>
                    <span class="font-extrabold text-gray-900 dark:text-white">
                        {{ number_format($p['total_revenue']) }} <span class="text-[10px] font-normal">ر.س</span>
                    </span>
                </div>
            </div>

            {{-- Visual Progress --}}
            <div class="mt-3 pt-2">
                <div class="flex justify-between text-[11px] text-gray-400 mb-1">
                    <span>نسبة المبيعات من الطلبات</span>
                    <span>{{ $p['total_bookings'] > 0 ? round(($p['sold_bookings'] / max(1, $p['total_bookings'])) * 100) : 0 }}%</span>
                </div>
                <div class="ad-progress-track">
                    <div class="ad-progress-fill" style="background-color: {{ $p['color'] }}; width: {{ min(100, $p['total_bookings'] > 0 ? round(($p['sold_bookings'] / max(1, $p['total_bookings'])) * 100) : 0) }}%;"></div>
                </div>
            </div>
        </div>
    @endforeach
</div>

{{-- ==================== 4. TABS: CAMPAIGNS, TOP CARS & TIMELINE ==================== --}}
<div class="ad-section">
    <div class="flex border-b border-gray-200 dark:border-gray-800 mb-4">
        <button
            type="button"
            wire:click="changeTab('overview')"
            class="ad-tab-btn {{ $activeTab === 'overview' ? 'active' : '' }}"
        >
            <x-filament::icon icon="heroicon-o-chart-bar" class="w-4 h-4" />
            جدول أداء الحملات الإعلانية (Campaigns)
        </button>

        <button
            type="button"
            wire:click="changeTab('cars')"
            class="ad-tab-btn {{ $activeTab === 'cars' ? 'active' : '' }}"
        >
            <x-filament::icon icon="heroicon-o-truck" class="w-4 h-4" />
            السيارات الأكثر مبيعاً من الإعلانات
        </button>

        <button
            type="button"
            wire:click="changeTab('timeline')"
            class="ad-tab-btn {{ $activeTab === 'timeline' ? 'active' : '' }}"
        >
            <x-filament::icon icon="heroicon-o-calendar-days" class="w-4 h-4" />
            التوزيع الزمني للمبيعات
        </button>
    </div>

    {{-- TAB 1: CAMPAIGNS TABLE --}}
    @if ($activeTab === 'overview')
        <div class="overflow-x-auto">
            @if (empty($campaigns))
                <div class="py-12 text-center text-gray-400">
                    <x-filament::icon icon="heroicon-o-megaphone" class="w-12 h-12 mx-auto mb-2 text-gray-300" />
                    <p class="text-sm font-semibold">لم يتم تسجيل حملات إعلانية مطابقة للفترة المحددة حتى الآن.</p>
                    <p class="text-xs text-gray-400 mt-1">ستظهر هنا تفاصيل أي زيارات قادمة تحمل وسوم UTM (مثل ?utm_source=meta&utm_campaign=...).</p>
                </div>
            @else
                <table class="ad-table">
                    <thead>
                        <tr>
                            <th>المنصة</th>
                            <th>اسم الحملة (UTM Campaign)</th>
                            <th>نوع الإعلان (Medium)</th>
                            <th>عدد الطلبات</th>
                            <th>المبيعات المؤكدة</th>
                            <th>إجمالي الإيرادات</th>
                            <th>معدل التحويل</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($campaigns as $camp)
                            <tr>
                                <td>
                                    <span class="ad-badge" style="background: {{ $camp['platform_info']['color'] ?? '#64748B' }}15; color: {{ $camp['platform_info']['color'] ?? '#64748B' }};">
                                        {{ $camp['platform_info']['name_ar'] ?? ucfirst($camp['platform']) }}
                                    </span>
                                </td>
                                <td class="font-bold text-gray-900 dark:text-gray-100">
                                    {{ $camp['campaign_name'] }}
                                </td>
                                <td class="text-gray-500 font-mono text-xs">
                                    {{ $camp['campaign_medium'] }}
                                </td>
                                <td class="font-semibold text-gray-800 dark:text-gray-200">
                                    {{ number_format($camp['total_bookings']) }}
                                </td>
                                <td>
                                    <span class="text-emerald-600 font-bold">
                                        {{ number_format($camp['sold_count']) }}
                                    </span>
                                </td>
                                <td class="font-extrabold text-gray-900 dark:text-white">
                                    {{ number_format($camp['total_revenue']) }} <span class="text-[10px] font-normal">ر.س</span>
                                </td>
                                <td>
                                    <div class="flex items-center gap-2">
                                        <div class="w-16 ad-progress-track">
                                            <div class="ad-progress-fill" style="background: #10b981; width: {{ min(100, $camp['conversion_rate']) }}%;"></div>
                                        </div>
                                        <span class="text-xs font-semibold text-gray-600 dark:text-gray-400">
                                            {{ $camp['conversion_rate'] }}%
                                        </span>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    @endif

    {{-- TAB 2: TOP CARS SOLD FROM ADS --}}
    @if ($activeTab === 'cars')
        <div class="overflow-x-auto">
            @if (empty($topCars))
                <div class="py-12 text-center text-gray-400">
                    <x-filament::icon icon="heroicon-o-truck" class="w-12 h-12 mx-auto mb-2 text-gray-300" />
                    <p class="text-sm font-semibold">لا توجد مبيعات سيارات مسجلة من الإعلانات في هذه الفترة.</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach ($topCars as $car)
                        <div class="ad-card flex-row items-center gap-4">
                            @if ($car['car_image'])
                                <img src="{{ asset('storage/' . $car['car_image']) }}" alt="{{ $car['car_name'] }}" class="w-20 h-16 object-cover rounded-lg flex-shrink-0" />
                            @else
                                <div class="w-20 h-16 bg-gray-100 dark:bg-gray-800 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <x-filament::icon icon="heroicon-o-truck" class="w-8 h-8 text-gray-400" />
                                </div>
                            @endif

                            <div class="flex-1 min-w-0">
                                <div class="text-xs text-gray-400 truncate">{{ $car['brand_name'] }}</div>
                                <h4 class="font-bold text-sm text-gray-900 dark:text-white truncate">{{ $car['car_name'] }}</h4>
                                <div class="flex items-center gap-2 mt-2">
                                    <span class="ad-badge" style="background: {{ $car['platform_info']['color'] ?? '#64748B' }}15; color: {{ $car['platform_info']['color'] ?? '#64748B' }};">
                                        {{ $car['platform_info']['name_ar'] ?? ucfirst($car['platform']) }}
                                    </span>
                                    <span class="text-xs font-bold text-emerald-600">
                                        {{ $car['sold_orders'] }} مبيعات
                                    </span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    @endif

    {{-- TAB 3: TIMELINE CHART --}}
    @if ($activeTab === 'timeline')
        <div class="space-y-4">
            <div class="flex items-center justify-between">
                <span class="text-xs text-gray-500 font-semibold">مبيعات المنصات اليومية خلال الفترة المختارة</span>
            </div>

            <div class="overflow-x-auto">
                <table class="ad-table text-center">
                    <thead>
                        <tr>
                            <th class="text-right">التاريخ / الفترة</th>
                            <th>Google Ads</th>
                            <th>Meta Ads</th>
                            <th>Snapchat Ads</th>
                            <th>TikTok Ads</th>
                            <th>الإجمالي</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($timeline['labels'] as $idx => $label)
                            @php
                                $gSold = $timeline['datasets']['google']['sold_data'][$idx] ?? 0;
                                $mSold = $timeline['datasets']['meta']['sold_data'][$idx] ?? 0;
                                $sSold = $timeline['datasets']['snapchat']['sold_data'][$idx] ?? 0;
                                $tSold = $timeline['datasets']['tiktok']['sold_data'][$idx] ?? 0;
                                $rowTotal = $gSold + $mSold + $sSold + $tSold;
                            @endphp
                            <tr>
                                <td class="text-right font-semibold text-gray-700 dark:text-gray-300">{{ $label }}</td>
                                <td class="{{ $gSold > 0 ? 'font-bold text-red-600' : 'text-gray-400' }}">{{ $gSold }}</td>
                                <td class="{{ $mSold > 0 ? 'font-bold text-blue-600' : 'text-gray-400' }}">{{ $mSold }}</td>
                                <td class="{{ $sSold > 0 ? 'font-bold text-amber-600' : 'text-gray-400' }}">{{ $sSold }}</td>
                                <td class="{{ $tSold > 0 ? 'font-bold text-cyan-600' : 'text-gray-400' }}">{{ $tSold }}</td>
                                <td class="font-extrabold text-gray-900 dark:text-white">{{ $rowTotal }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>
</x-filament-panels::page>
