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
    @media (max-width: 480px)  { .ad-kpi-bar { grid-template-columns: 1fr; } }

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
        border: 1px solid rgba(148, 163, 184, 0.2);
        background: #ffffff;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.05);
        position: relative;
        overflow: hidden;
        transition: all 0.2s ease-in-out;
    }
    .ad-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.08);
    }
    .dark .ad-card {
        background: rgb(var(--fi-color-gray-900) / 0.85);
        border-color: rgb(var(--fi-color-gray-800) / 1);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.2);
    }

    .ad-icon-badge {
        width: 2.75rem;
        height: 2.75rem;
        border-radius: 0.75rem;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .ad-section {
        background: #ffffff;
        border: 1px solid rgb(var(--fi-color-gray-200) / 1);
        border-radius: 1rem;
        padding: 1.25rem;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.04);
    }
    .dark .ad-section {
        background: rgb(var(--fi-color-gray-900) / 0.6);
        border-color: rgb(var(--fi-color-gray-800) / 1);
    }

    .ad-quick-btn {
        padding: 0.4rem 0.85rem;
        border-radius: 0.5rem;
        font-size: 0.75rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.15s ease-in-out;
        border: 1px solid transparent;
    }
    .ad-quick-btn.active {
        background: rgb(var(--primary-600));
        color: #ffffff;
        box-shadow: 0 2px 8px -1px rgba(var(--primary-600), 0.35);
    }
    .ad-quick-btn:not(.active) {
        background: rgba(148, 163, 184, 0.12);
        color: #475569;
    }
    .ad-quick-btn:not(.active):hover {
        background: rgba(var(--primary-500), 0.15);
        color: rgb(var(--primary-700));
    }
    .dark .ad-quick-btn:not(.active) {
        color: #cbd5e1;
        background: rgba(255, 255, 255, 0.06);
    }
    .dark .ad-quick-btn:not(.active):hover {
        background: rgba(255, 255, 255, 0.12);
        color: #ffffff;
    }

    .ad-tab-btn {
        padding: 0.75rem 1.25rem;
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
        padding: 0.25rem 0.75rem;
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

{{-- ==================== 0. SMART ONE-CLICK MIGRATION ALERT ==================== --}}
@if (! ($kpis['schema_ready'] ?? true))
    <div class="mb-6 rounded-2xl border border-amber-300 dark:border-amber-700/60 bg-gradient-to-r from-amber-50 to-orange-50 dark:from-amber-950/40 dark:to-orange-950/30 p-5 shadow-md">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="flex items-start gap-3.5">
                <div class="w-10 h-10 rounded-xl bg-amber-500/20 text-amber-600 dark:text-amber-400 flex items-center justify-center flex-shrink-0 mt-0.5">
                    <x-filament::icon icon="heroicon-o-exclamation-triangle" class="w-6 h-6" />
                </div>
                <div>
                    <h3 class="font-bold text-base text-gray-900 dark:text-white">
                        تنبيه: قاعدة البيانات الحالية بحاجة للتحديث لتفعيل أعمدة الإعلانات
                    </h3>
                    <p class="text-xs text-gray-600 dark:text-gray-300 mt-1 leading-relaxed">
                        قاعدة البيانات لا تحتوي بعد على أعمدة الإسناد التسويقي (<code class="font-mono bg-amber-100 dark:bg-amber-900/60 text-amber-900 dark:text-amber-200 px-1.5 py-0.5 rounded text-[11px] font-bold">ad_platform</code>). يمكنك تحديثها فوراً بنقرة زر واحدة بالأسفل:
                    </p>
                </div>
            </div>

            {{-- One-Click Action Button --}}
            <div class="flex-shrink-0">
                <button
                    type="button"
                    wire:click="applyDatabaseMigration"
                    wire:loading.attr="disabled"
                    class="inline-flex items-center gap-2 px-5 py-2.5 bg-amber-600 hover:bg-amber-700 active:scale-95 text-white font-bold text-xs rounded-xl shadow-lg shadow-amber-600/20 transition-all duration-150 cursor-pointer disabled:opacity-50"
                >
                    <x-filament::loading-indicator wire:loading class="w-4 h-4 text-white" />
                    <x-filament::icon icon="heroicon-m-bolt" wire:loading.remove class="w-4 h-4" />
                    <span>تحديث وتثبيت الجداول تلقائياً الآن</span>
                </button>
            </div>
        </div>

        {{-- Collapsible Manual SQL Box --}}
        <details class="mt-4 pt-3 border-t border-amber-200/60 dark:border-amber-800/40 text-xs text-gray-600 dark:text-gray-400">
            <summary class="cursor-pointer font-semibold text-amber-700 dark:text-amber-300 hover:underline select-none">
                أو اضغط هنا لعرض كود استعلام SQL للتنفيذ اليدوي في phpMyAdmin
            </summary>
            <div class="mt-2.5">
                <pre class="bg-gray-950 text-slate-200 p-3 rounded-xl text-[11px] font-mono overflow-x-auto select-all leading-relaxed border border-gray-800">ALTER TABLE `bookings` ADD COLUMN `ad_platform` VARCHAR(50) NULL AFTER `source`, ADD COLUMN `utm_source` VARCHAR(255) NULL AFTER `ad_platform`, ADD COLUMN `utm_medium` VARCHAR(255) NULL AFTER `utm_source`, ADD COLUMN `utm_campaign` VARCHAR(255) NULL AFTER `utm_medium`, ADD COLUMN `utm_content` VARCHAR(255) NULL AFTER `utm_campaign`, ADD COLUMN `utm_term` VARCHAR(255) NULL AFTER `utm_content`, ADD COLUMN `click_id` VARCHAR(255) NULL AFTER `utm_term`, ADD COLUMN `referrer_url` TEXT NULL AFTER `click_id`, ADD INDEX `bookings_ad_platform_index` (`ad_platform`), ADD INDEX `bookings_attribution_perf_idx` (`ad_platform`, `status`, `created_at`);

ALTER TABLE `leads` ADD COLUMN `ad_platform` VARCHAR(50) NULL AFTER `status`, ADD COLUMN `utm_source` VARCHAR(255) NULL AFTER `ad_platform`, ADD COLUMN `utm_medium` VARCHAR(255) NULL AFTER `utm_source`, ADD COLUMN `utm_campaign` VARCHAR(255) NULL AFTER `utm_medium`, ADD COLUMN `utm_content` VARCHAR(255) NULL AFTER `utm_campaign`, ADD COLUMN `utm_term` VARCHAR(255) NULL AFTER `utm_content`, ADD COLUMN `click_id` VARCHAR(255) NULL AFTER `utm_term`, ADD COLUMN `referrer_url` TEXT NULL AFTER `click_id`, ADD INDEX `leads_ad_platform_index` (`ad_platform`), ADD INDEX `leads_attribution_perf_idx` (`ad_platform`, `status`, `created_at`);</pre>
            </div>
        </details>
    </div>
@endif

{{-- ==================== 1. FILTER TOOLBAR ==================== --}}
<div class="ad-section mb-6">
    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 mb-4 pb-3 border-b border-gray-100 dark:border-gray-800">
        <div class="flex items-center gap-2.5">
            <div class="w-8 h-8 rounded-lg bg-primary-50 dark:bg-primary-950/40 text-primary-600 flex items-center justify-center flex-shrink-0">
                <x-filament::icon icon="heroicon-m-funnel" class="h-4 w-4" />
            </div>
            <div>
                <h2 class="text-sm font-bold text-gray-900 dark:text-white">نطاق الفحص والتحليل الإعلاني</h2>
                <p class="text-[11px] text-gray-400">تصفية نتائج الإعلانات والمبيعات بحسب التواريخ والمنصة</p>
            </div>
        </div>

        {{-- Action: Retroactive Client Scan + Quick Date Presets --}}
        <div class="flex flex-wrap items-center gap-2">
            <button
                type="button"
                wire:click="scanPastClients"
                wire:loading.attr="disabled"
                class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-emerald-600 hover:bg-emerald-700 active:scale-95 text-white font-bold text-xs rounded-lg shadow-sm transition-all duration-150 cursor-pointer disabled:opacity-50"
                title="فحص واستيراد الروابط والعملاء القدامى من الشهر الماضي وربطهم بحملات الإعلانات"
            >
                <x-filament::loading-indicator wire:loading wire:target="scanPastClients" class="w-3.5 h-3.5 text-white" />
                <x-filament::icon icon="heroicon-m-arrow-path" wire:loading.remove wire:target="scanPastClients" class="w-3.5 h-3.5 text-white" />
                <span>فحص وربط بيانات الشهر الماضي</span>
            </button>

            <span class="text-gray-300 dark:text-gray-700">|</span>

            <button type="button" wire:click="setQuickFilter('today')" class="ad-quick-btn {{ $activeQuickFilter === 'today' ? 'active' : '' }}">اليوم</button>
            <button type="button" wire:click="setQuickFilter('yesterday')" class="ad-quick-btn {{ $activeQuickFilter === 'yesterday' ? 'active' : '' }}">أمس</button>
            <button type="button" wire:click="setQuickFilter('last7')" class="ad-quick-btn {{ $activeQuickFilter === 'last7' ? 'active' : '' }}">آخر 7 أيام</button>
            <button type="button" wire:click="setQuickFilter('month')" class="ad-quick-btn {{ $activeQuickFilter === 'month' ? 'active' : '' }}">هذا الشهر</button>
            <button type="button" wire:click="setQuickFilter('last_month')" class="ad-quick-btn {{ $activeQuickFilter === 'last_month' ? 'active' : '' }}">الشهر الماضي</button>
            <button type="button" wire:click="setQuickFilter('quarter')" class="ad-quick-btn {{ $activeQuickFilter === 'quarter' ? 'active' : '' }}">هذا الربع</button>
            <button type="button" wire:click="setQuickFilter('year')" class="ad-quick-btn {{ $activeQuickFilter === 'year' ? 'active' : '' }}">هذه السنة</button>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div>
            <label class="block text-xs font-semibold mb-1.5 text-gray-700 dark:text-gray-300">من تاريخ</label>
            <x-filament::input.wrapper>
                <x-filament::input type="date" wire:model.live="filters.date_from" />
            </x-filament::input.wrapper>
        </div>
        <div>
            <label class="block text-xs font-semibold mb-1.5 text-gray-700 dark:text-gray-300">إلى تاريخ</label>
            <x-filament::input.wrapper>
                <x-filament::input type="date" wire:model.live="filters.date_to" />
            </x-filament::input.wrapper>
        </div>
        <div>
            <label class="block text-xs font-semibold mb-1.5 text-gray-700 dark:text-gray-300">المنصة الإعلانية</label>
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
    <div class="ad-card" style="border-top: 3px solid #3b82f6;">
        <div class="flex items-center justify-between mb-2">
            <span class="text-xs text-gray-500 dark:text-gray-400 font-semibold">عملاء الإعلانات (Leads)</span>
            <div class="ad-icon-badge" style="background: rgba(59, 130, 246, 0.12); color: #2563eb;">
                <x-filament::icon icon="heroicon-o-user-plus" class="w-5 h-5" />
            </div>
        </div>
        <div class="text-2xl font-black text-gray-900 dark:text-white tracking-tight">
            {{ number_format($kpis['total_ad_leads']) }}
        </div>
        <div class="text-[11px] text-gray-500 dark:text-gray-400 mt-2.5 pt-2 border-t border-gray-100 dark:border-gray-800/80 flex items-center justify-between">
            <span>إجمالي الطلبات المبدئية:</span>
            <span class="font-bold text-gray-800 dark:text-gray-200">{{ number_format($kpis['total_ad_bookings']) }}</span>
        </div>
    </div>

    {{-- KPI 2: Sold Ad Bookings --}}
    <div class="ad-card" style="border-top: 3px solid #10b981;">
        <div class="flex items-center justify-between mb-2">
            <span class="text-xs text-gray-500 dark:text-gray-400 font-semibold">مبيعات الإعلانات المؤكدة</span>
            <div class="ad-icon-badge" style="background: rgba(16, 185, 129, 0.12); color: #059669;">
                <x-filament::icon icon="heroicon-o-check-badge" class="w-5 h-5" />
            </div>
        </div>
        <div class="text-2xl font-black text-emerald-600 dark:text-emerald-400 tracking-tight">
            {{ number_format($kpis['sold_ad_bookings']) }}
        </div>
        <div class="text-[11px] text-emerald-700 dark:text-emerald-400 font-semibold mt-2.5 pt-2 border-t border-gray-100 dark:border-gray-800/80 flex items-center justify-between">
            <span>معدل تحويل الإعلانات:</span>
            <span class="ad-badge" style="background: rgba(16, 185, 129, 0.15); color: #059669;">{{ $kpis['conversion_rate'] }}%</span>
        </div>
    </div>

    {{-- KPI 3: Ad Revenue --}}
    <div class="ad-card" style="border-top: 3px solid #8b5cf6;">
        <div class="flex items-center justify-between mb-2">
            <span class="text-xs text-gray-500 dark:text-gray-400 font-semibold">إيرادات مبيعات الإعلانات</span>
            <div class="ad-icon-badge" style="background: rgba(139, 92, 246, 0.12); color: #7c3aed;">
                <x-filament::icon icon="heroicon-o-banknotes" class="w-5 h-5" />
            </div>
        </div>
        <div class="text-2xl font-black text-purple-600 dark:text-purple-400 tracking-tight">
            {{ number_format($kpis['total_ad_revenue']) }} <span class="text-xs font-semibold text-gray-400">ر.س</span>
        </div>
        <div class="text-[11px] text-gray-500 dark:text-gray-400 mt-2.5 pt-2 border-t border-gray-100 dark:border-gray-800/80 flex items-center justify-between">
            <span>متوسط قيمة الصفقة:</span>
            <span class="font-bold text-gray-800 dark:text-gray-200">{{ number_format($kpis['avg_deal_size']) }} ر.س</span>
        </div>
    </div>

    {{-- KPI 4: Top Platform --}}
    <div class="ad-card" style="border-top: 3px solid #f59e0b;">
        <div class="flex items-center justify-between mb-2">
            <span class="text-xs text-gray-500 dark:text-gray-400 font-semibold">المنصة الأعلى مبيعاً</span>
            <div class="ad-icon-badge" style="background: rgba(245, 158, 11, 0.12); color: #d97706;">
                <x-filament::icon icon="heroicon-o-trophy" class="w-5 h-5" />
            </div>
        </div>
        <div class="text-lg font-black text-gray-900 dark:text-white truncate" title="{{ $kpis['top_platform_name'] }}">
            {{ $kpis['top_platform_name'] }}
        </div>
        <div class="text-[11px] text-amber-700 dark:text-amber-400 font-semibold mt-2.5 pt-2 border-t border-gray-100 dark:border-gray-800/80">
            الأعلى مساهمة في مبيعات الفترة
        </div>
    </div>

    {{-- KPI 5: Organic / Direct Comparison --}}
    <div class="ad-card" style="border-top: 3px solid #64748b;">
        <div class="flex items-center justify-between mb-2">
            <span class="text-xs text-gray-500 dark:text-gray-400 font-semibold">المبيعات المباشرة (Organic)</span>
            <div class="ad-icon-badge" style="background: rgba(100, 116, 139, 0.12); color: #475569;">
                <x-filament::icon icon="heroicon-o-arrow-trending-up" class="w-5 h-5" />
            </div>
        </div>
        <div class="text-2xl font-black text-slate-700 dark:text-slate-300 tracking-tight">
            {{ number_format($kpis['organic_sold']) }}
        </div>
        <div class="text-[11px] text-gray-500 dark:text-gray-400 mt-2.5 pt-2 border-t border-gray-100 dark:border-gray-800/80 flex items-center justify-between">
            <span>إيراد:</span>
            <span class="font-bold text-gray-800 dark:text-gray-200">{{ number_format($kpis['organic_revenue']) }} ر.س</span>
        </div>
    </div>
</div>

{{-- ==================== 3. 4-PLATFORMS COMPARISON GRID WITH SVG LOGOS ==================== --}}
<div class="flex items-center justify-between mb-3.5">
    <h3 class="text-sm font-bold text-gray-800 dark:text-gray-200 flex items-center gap-2">
        <x-filament::icon icon="heroicon-m-squares-2x2" class="w-4 h-4 text-primary-500" />
        مقارنة أداء المنصات الإعلانية الأربعة (Google, Meta, Snapchat, TikTok)
    </h3>
</div>

<div class="ad-platform-grid">
    {{-- PLATFORM 1: GOOGLE ADS --}}
    @php $g = $platforms['google'] ?? []; @endphp
    <div class="ad-card relative group" style="border-top: 4px solid #EA4335;">
        <div class="flex items-center justify-between mb-3">
            <div class="flex items-center gap-2.5">
                {{-- Official Google G Logo SVG --}}
                <svg class="w-6 h-6 flex-shrink-0" viewBox="0 0 24 24">
                    <path fill="#4285F4" d="M23.745 12.27c0-.7-.06-1.4-.19-2.07H12v4.51h6.6c-.29 1.52-1.14 2.82-2.4 3.68v3.05h3.88c2.27-2.09 3.665-5.17 3.665-9.17z"/>
                    <path fill="#34A853" d="M12 24c3.24 0 5.95-1.08 7.93-2.91l-3.88-3.05c-1.08.72-2.45 1.16-4.05 1.16-3.12 0-5.77-2.1-6.72-4.93H1.24v3.15C3.26 21.36 7.33 24 12 24z"/>
                    <path fill="#FBBC05" d="M5.28 14.27c-.25-.72-.38-1.49-.38-2.27s.13-1.55.38-2.27V6.58H1.24C.45 8.15 0 9.92 0 12s.45 3.85 1.24 5.42l4.04-3.15z"/>
                    <path fill="#EA4335" d="M12 4.75c1.77 0 3.35.61 4.6 1.8l3.42-3.42C17.95 1.19 15.24 0 12 0 7.33 0 3.26 2.64 1.24 6.58l4.04 3.15c.95-2.83 3.6-4.98 6.72-4.98z"/>
                </svg>
                <span class="font-extrabold text-sm text-gray-900 dark:text-white">Google Ads</span>
            </div>
            <span class="ad-badge" style="background: rgba(234, 67, 53, 0.12); color: #EA4335;">
                {{ $g['conversion_rate'] ?? 0 }}% تحويل
            </span>
        </div>

        <div class="space-y-2.5 my-2">
            <div class="flex items-center justify-between text-xs">
                <span class="text-gray-500 dark:text-gray-400">عملاء محتملون (Leads):</span>
                <span class="font-bold text-gray-900 dark:text-gray-100">{{ number_format($g['total_leads'] ?? 0) }}</span>
            </div>
            <div class="flex items-center justify-between text-xs">
                <span class="text-gray-500 dark:text-gray-400">مبيعات مكتملة (Sold):</span>
                <span class="font-black text-emerald-600 dark:text-emerald-400">{{ number_format($g['sold_bookings'] ?? 0) }}</span>
            </div>
            <div class="flex items-center justify-between text-xs">
                <span class="text-gray-500 dark:text-gray-400">قيد التفاوض:</span>
                <span class="font-semibold text-amber-600">{{ number_format($g['negotiation_bookings'] ?? 0) }}</span>
            </div>
            <div class="flex items-center justify-between text-xs pt-2 border-t border-gray-100 dark:border-gray-800">
                <span class="text-gray-600 dark:text-gray-400 font-semibold">إجمالي المبيعات:</span>
                <span class="font-black text-gray-900 dark:text-white">
                    {{ number_format($g['total_revenue'] ?? 0) }} <span class="text-[10px] font-normal">ر.س</span>
                </span>
            </div>
        </div>

        <div class="mt-3 pt-2">
            <div class="flex justify-between text-[11px] text-gray-400 mb-1">
                <span>نسبة المبيعات من الطلبات</span>
                <span>{{ ($g['total_bookings'] ?? 0) > 0 ? round((($g['sold_bookings'] ?? 0) / max(1, $g['total_bookings'])) * 100) : 0 }}%</span>
            </div>
            <div class="ad-progress-track">
                <div class="ad-progress-fill" style="background-color: #EA4335; width: {{ min(100, ($g['total_bookings'] ?? 0) > 0 ? round((($g['sold_bookings'] ?? 0) / max(1, $g['total_bookings'])) * 100) : 0) }}%;"></div>
            </div>
        </div>
    </div>

    {{-- PLATFORM 2: META (FB & IG) --}}
    @php $m = $platforms['meta'] ?? []; @endphp
    <div class="ad-card relative group" style="border-top: 4px solid #1877F2;">
        <div class="flex items-center justify-between mb-3">
            <div class="flex items-center gap-2.5">
                {{-- Official Meta Infinity Logo SVG --}}
                <svg class="w-6 h-6 flex-shrink-0" viewBox="0 0 24 24" fill="#1877F2">
                    <path d="M12 2C6.477 2 2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.879V14.89h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.989C18.343 21.129 22 16.99 22 12c0-5.523-4.477-10-10-10z"/>
                </svg>
                <span class="font-extrabold text-sm text-gray-900 dark:text-white">Meta (FB / IG)</span>
            </div>
            <span class="ad-badge" style="background: rgba(24, 119, 242, 0.12); color: #1877F2;">
                {{ $m['conversion_rate'] ?? 0 }}% تحويل
            </span>
        </div>

        <div class="space-y-2.5 my-2">
            <div class="flex items-center justify-between text-xs">
                <span class="text-gray-500 dark:text-gray-400">عملاء محتملون (Leads):</span>
                <span class="font-bold text-gray-900 dark:text-gray-100">{{ number_format($m['total_leads'] ?? 0) }}</span>
            </div>
            <div class="flex items-center justify-between text-xs">
                <span class="text-gray-500 dark:text-gray-400">مبيعات مكتملة (Sold):</span>
                <span class="font-black text-emerald-600 dark:text-emerald-400">{{ number_format($m['sold_bookings'] ?? 0) }}</span>
            </div>
            <div class="flex items-center justify-between text-xs">
                <span class="text-gray-500 dark:text-gray-400">قيد التفاوض:</span>
                <span class="font-semibold text-amber-600">{{ number_format($m['negotiation_bookings'] ?? 0) }}</span>
            </div>
            <div class="flex items-center justify-between text-xs pt-2 border-t border-gray-100 dark:border-gray-800">
                <span class="text-gray-600 dark:text-gray-400 font-semibold">إجمالي المبيعات:</span>
                <span class="font-black text-gray-900 dark:text-white">
                    {{ number_format($m['total_revenue'] ?? 0) }} <span class="text-[10px] font-normal">ر.س</span>
                </span>
            </div>
        </div>

        <div class="mt-3 pt-2">
            <div class="flex justify-between text-[11px] text-gray-400 mb-1">
                <span>نسبة المبيعات من الطلبات</span>
                <span>{{ ($m['total_bookings'] ?? 0) > 0 ? round((($m['sold_bookings'] ?? 0) / max(1, $m['total_bookings'])) * 100) : 0 }}%</span>
            </div>
            <div class="ad-progress-track">
                <div class="ad-progress-fill" style="background-color: #1877F2; width: {{ min(100, ($m['total_bookings'] ?? 0) > 0 ? round((($m['sold_bookings'] ?? 0) / max(1, $m['total_bookings'])) * 100) : 0) }}%;"></div>
            </div>
        </div>
    </div>

    {{-- PLATFORM 3: SNAPCHAT ADS --}}
    @php $s = $platforms['snapchat'] ?? []; @endphp
    <div class="ad-card relative group" style="border-top: 4px solid #EAB308;">
        <div class="flex items-center justify-between mb-3">
            <div class="flex items-center gap-2.5">
                {{-- Official Snapchat Ghost Logo SVG --}}
                <div class="w-6 h-6 rounded-md bg-yellow-400 flex items-center justify-center p-0.5 flex-shrink-0">
                    <svg class="w-5 h-5 text-white" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12.003 2c-3.79 0-6.24 2.92-6.24 5.92 0 .84.21 2.05.69 2.87.16.27.18.42.06.66-.23.47-.84.87-1.46.99-.34.06-.51.27-.51.52 0 .5.68.86 1.48.97.23.03.37.15.42.34.22.78.89 1.49 1.94 1.76.21.05.3.18.23.37-.34.87-.71 1.72-1.07 2.58-.1.25-.01.47.25.55.77.24 1.58.4 2.4.49.25.03.38.16.4.4.07.72.33 1.08 1.81 1.08s1.74-.36 1.81-1.08c.02-.24.15-.37.4-.4.82-.09 1.63-.25 2.4-.49.26-.08.35-.3.25-.55-.36-.86-.73-1.71-1.07-2.58-.07-.19.02-.32.23-.37 1.05-.27 1.72-.98 1.94-1.76.05-.19.19-.31.42-.34.8-.11 1.48-.47 1.48-.97 0-.25-.17-.46-.51-.52-.62-.12-1.23-.52-1.46-.99-.12-.24-.1-.39.06-.66.48-.82.69-2.03.69-2.87 0-3-2.45-5.92-6.24-5.92z"/>
                    </svg>
                </div>
                <span class="font-extrabold text-sm text-gray-900 dark:text-white">Snapchat Ads</span>
            </div>
            <span class="ad-badge" style="background: rgba(234, 179, 8, 0.15); color: #B45309;">
                {{ $s['conversion_rate'] ?? 0 }}% تحويل
            </span>
        </div>

        <div class="space-y-2.5 my-2">
            <div class="flex items-center justify-between text-xs">
                <span class="text-gray-500 dark:text-gray-400">عملاء محتملون (Leads):</span>
                <span class="font-bold text-gray-900 dark:text-gray-100">{{ number_format($s['total_leads'] ?? 0) }}</span>
            </div>
            <div class="flex items-center justify-between text-xs">
                <span class="text-gray-500 dark:text-gray-400">مبيعات مكتملة (Sold):</span>
                <span class="font-black text-emerald-600 dark:text-emerald-400">{{ number_format($s['sold_bookings'] ?? 0) }}</span>
            </div>
            <div class="flex items-center justify-between text-xs">
                <span class="text-gray-500 dark:text-gray-400">قيد التفاوض:</span>
                <span class="font-semibold text-amber-600">{{ number_format($s['negotiation_bookings'] ?? 0) }}</span>
            </div>
            <div class="flex items-center justify-between text-xs pt-2 border-t border-gray-100 dark:border-gray-800">
                <span class="text-gray-600 dark:text-gray-400 font-semibold">إجمالي المبيعات:</span>
                <span class="font-black text-gray-900 dark:text-white">
                    {{ number_format($s['total_revenue'] ?? 0) }} <span class="text-[10px] font-normal">ر.س</span>
                </span>
            </div>
        </div>

        <div class="mt-3 pt-2">
            <div class="flex justify-between text-[11px] text-gray-400 mb-1">
                <span>نسبة المبيعات من الطلبات</span>
                <span>{{ ($s['total_bookings'] ?? 0) > 0 ? round((($s['sold_bookings'] ?? 0) / max(1, $s['total_bookings'])) * 100) : 0 }}%</span>
            </div>
            <div class="ad-progress-track">
                <div class="ad-progress-fill" style="background-color: #EAB308; width: {{ min(100, ($s['total_bookings'] ?? 0) > 0 ? round((($s['sold_bookings'] ?? 0) / max(1, $s['total_bookings'])) * 100) : 0) }}%;"></div>
            </div>
        </div>
    </div>

    {{-- PLATFORM 4: TIKTOK ADS --}}
    @php $t = $platforms['tiktok'] ?? []; @endphp
    <div class="ad-card relative group" style="border-top: 4px solid #06B6D4;">
        <div class="flex items-center justify-between mb-3">
            <div class="flex items-center gap-2.5">
                {{-- Official TikTok Logo SVG --}}
                <div class="w-6 h-6 rounded-md bg-black dark:bg-gray-800 flex items-center justify-center p-0.5 flex-shrink-0">
                    <svg class="w-4 h-4 text-white" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-5.2 1.74 2.89 2.89 0 0 1 2.31-4.64c.298-.002.595.042.88.13V9.4a6.33 6.33 0 0 0-1-.08A6.34 6.34 0 0 0 3 15.66a6.34 6.34 0 0 0 10.86 4.43c.36-.36.67-.77.93-1.22V10.8a8.28 8.28 0 0 0 4.8 1.52V8.87a4.86 4.86 0 0 1-3.77-2.18z"/>
                    </svg>
                </div>
                <span class="font-extrabold text-sm text-gray-900 dark:text-white">TikTok Ads</span>
            </div>
            <span class="ad-badge" style="background: rgba(6, 182, 212, 0.12); color: #0891B2;">
                {{ $t['conversion_rate'] ?? 0 }}% تحويل
            </span>
        </div>

        <div class="space-y-2.5 my-2">
            <div class="flex items-center justify-between text-xs">
                <span class="text-gray-500 dark:text-gray-400">عملاء محتملون (Leads):</span>
                <span class="font-bold text-gray-900 dark:text-gray-100">{{ number_format($t['total_leads'] ?? 0) }}</span>
            </div>
            <div class="flex items-center justify-between text-xs">
                <span class="text-gray-500 dark:text-gray-400">مبيعات مكتملة (Sold):</span>
                <span class="font-black text-emerald-600 dark:text-emerald-400">{{ number_format($t['sold_bookings'] ?? 0) }}</span>
            </div>
            <div class="flex items-center justify-between text-xs">
                <span class="text-gray-500 dark:text-gray-400">قيد التفاوض:</span>
                <span class="font-semibold text-amber-600">{{ number_format($t['negotiation_bookings'] ?? 0) }}</span>
            </div>
            <div class="flex items-center justify-between text-xs pt-2 border-t border-gray-100 dark:border-gray-800">
                <span class="text-gray-600 dark:text-gray-400 font-semibold">إجمالي المبيعات:</span>
                <span class="font-black text-gray-900 dark:text-white">
                    {{ number_format($t['total_revenue'] ?? 0) }} <span class="text-[10px] font-normal">ر.س</span>
                </span>
            </div>
        </div>

        <div class="mt-3 pt-2">
            <div class="flex justify-between text-[11px] text-gray-400 mb-1">
                <span>نسبة المبيعات من الطلبات</span>
                <span>{{ ($t['total_bookings'] ?? 0) > 0 ? round((($t['sold_bookings'] ?? 0) / max(1, $t['total_bookings'])) * 100) : 0 }}%</span>
            </div>
            <div class="ad-progress-track">
                <div class="ad-progress-fill" style="background-color: #06B6D4; width: {{ min(100, ($t['total_bookings'] ?? 0) > 0 ? round((($t['sold_bookings'] ?? 0) / max(1, $t['total_bookings'])) * 100) : 0) }}%;"></div>
            </div>
        </div>
    </div>
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
