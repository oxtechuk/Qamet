<x-filament-panels::page>
<style>
    .rpt-kpi-bar { display: grid; grid-template-columns: repeat(5, 1fr); gap: 1rem; margin-bottom: 1.5rem; }
    @media (max-width: 1024px) { .rpt-kpi-bar { grid-template-columns: repeat(3, 1fr); } }
    @media (max-width: 640px)  { .rpt-kpi-bar { grid-template-columns: repeat(2, 1fr); } }

    .rpt-stats-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 1rem; margin-bottom: 1.5rem; }
    @media (max-width: 1024px) { .rpt-stats-grid { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 640px)  { .rpt-stats-grid { grid-template-columns: 1fr; } }

    .rpt-two-col { display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem; }
    @media (max-width: 900px)  { .rpt-two-col { grid-template-columns: 1fr; } }

    .rpt-three-col { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.5rem; }
    @media (max-width: 1024px) { .rpt-three-col { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 640px)  { .rpt-three-col { grid-template-columns: 1fr; } }

    .rpt-emp-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.25rem; }
    @media (max-width: 1024px) { .rpt-emp-grid { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 640px)  { .rpt-emp-grid { grid-template-columns: 1fr; } }

    .rpt-source-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1rem; }
    @media (max-width: 1024px) { .rpt-source-grid { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 640px)  { .rpt-source-grid { grid-template-columns: 1fr; } }

    .rpt-kpi-card {
        border-radius: 0.875rem;
        padding: 0.875rem 1rem;
        display: flex; flex-direction: column; gap: 0.25rem;
        border: 1px solid;
    }
    .rpt-stat-card {
        border-radius: 1rem;
        padding: 1.25rem;
        display: flex; flex-direction: column; gap: 0.375rem;
        border: 1px solid;
    }
    .rpt-trend-up   { color: #10b981; font-size: 0.72rem; font-weight: 600; }
    .rpt-trend-down { color: #ef4444; font-size: 0.72rem; font-weight: 600; }
    .rpt-trend-flat { color: #6b7280; font-size: 0.72rem; font-weight: 600; }

    .rpt-badge {
        display: inline-flex; align-items: center;
        padding: 2px 10px; border-radius: 999px;
        font-size: 0.7rem; font-weight: 700; white-space: nowrap;
    }
    .rpt-progress-track {
        width: 100%; background: rgba(100,116,139,0.18);
        border-radius: 999px; overflow: hidden; height: 7px;
    }
    .rpt-progress-fill { height: 7px; border-radius: 999px; transition: width 0.9s cubic-bezier(.4,0,.2,1); }

    .rpt-section {
        background: rgb(var(--fi-color-gray-50) / 1);
        border: 1px solid rgb(var(--fi-color-gray-200) / 1);
        border-radius: 1rem;
        padding: 1.25rem;
    }
    .dark .rpt-section {
        background: rgb(var(--fi-color-gray-900) / 0.5);
        border-color: rgb(var(--fi-color-gray-800) / 1);
    }
    .rpt-section-title {
        font-size: 0.8rem; font-weight: 700; letter-spacing: 0.04em;
        text-transform: uppercase; color: #6b7280;
        display: flex; align-items: center; gap: 0.5rem;
        margin-bottom: 1rem;
        padding-bottom: 0.75rem;
        border-bottom: 1px solid rgba(100,116,139,0.15);
    }
    .rpt-table { width: 100%; font-size: 0.82rem; border-collapse: collapse; }
    .rpt-table th {
        padding: 0.6rem 0.875rem; text-align: right;
        font-size: 0.7rem; font-weight: 700; text-transform: uppercase;
        letter-spacing: 0.04em; color: #9ca3af;
        border-bottom: 1px solid rgba(100,116,139,0.15);
        white-space: nowrap;
    }
    .rpt-table td {
        padding: 0.75rem 0.875rem; vertical-align: middle;
        border-bottom: 1px solid rgba(100,116,139,0.08);
    }
    .rpt-table tr:last-child td { border-bottom: none; }
    .rpt-table tbody tr:hover { background: rgba(100,116,139,0.05); }
    .rpt-avatar {
        width: 2rem; height: 2rem; border-radius: 50%;
        display: flex; align-items: center; justify-center: center;
        font-size: 0.7rem; font-weight: 800;
        flex-shrink: 0;
    }
    .rpt-pipeline-bar {
        display: grid; grid-template-columns: repeat(5, 1fr); gap: 0.75rem;
        margin-bottom: 1.5rem;
    }
    @media (max-width: 768px) { .rpt-pipeline-bar { grid-template-columns: repeat(3, 1fr); } }
    @media (max-width: 480px) { .rpt-pipeline-bar { grid-template-columns: repeat(2, 1fr); } }

    .rpt-quick-btns { display: flex; gap: 0.4rem; flex-wrap: wrap; }
    .rpt-quick-btn {
        padding: 0.3rem 0.75rem; border-radius: 0.5rem; font-size: 0.72rem; font-weight: 600;
        background: rgba(100,116,139,0.1); color: #6b7280; cursor: pointer;
        border: 1px solid transparent; transition: all 0.15s;
    }
    .rpt-quick-btn:hover { background: rgba(var(--primary-500), 0.12); color: rgb(var(--primary-600)); }
    .rpt-rank-gold   { background: #fef3c7; color: #92400e; }
    .rpt-rank-silver { background: #f1f5f9; color: #475569; }
    .rpt-rank-bronze { background: #fef3c7; color: #78350f; }
    .dark .rpt-rank-gold   { background: rgba(245,158,11,0.15); color: #fbbf24; }
    .dark .rpt-rank-silver { background: rgba(100,116,139,0.15); color: #94a3b8; }
    .dark .rpt-rank-bronze { background: rgba(180,83,9,0.15); color: #f97316; }
</style>

@php
    $kpi        = $this->getKpiBar();
    $prevStats  = null;
@endphp

{{-- ===== FILTER BAR ===== --}}
<div class="rpt-section mb-4">
    <div class="flex flex-wrap items-center justify-between gap-3 mb-3">
        <div class="rpt-section-title" style="margin-bottom:0; border-bottom:none; padding-bottom:0;">
            <x-filament::icon icon="heroicon-m-funnel" class="h-4 w-4" />
            {{ __('فلاتر التقرير') }}
        </div>
        {{-- Quick filters --}}
        <div class="rpt-quick-btns">
            <button type="button" wire:click="setQuickFilter('today')"   class="rpt-quick-btn">اليوم</button>
            <button type="button" wire:click="setQuickFilter('week')"    class="rpt-quick-btn">هذا الأسبوع</button>
            <button type="button" wire:click="setQuickFilter('month')"   class="rpt-quick-btn">هذا الشهر</button>
            <button type="button" wire:click="setQuickFilter('quarter')" class="rpt-quick-btn">هذا الربع</button>
            <button type="button" wire:click="setQuickFilter('year')"    class="rpt-quick-btn">هذه السنة</button>
        </div>
    </div>
    <div style="display:grid; grid-template-columns: repeat(4,1fr); gap: 1rem;">
        <div>
            <label class="block text-xs font-semibold mb-1 text-gray-500">{{ __('من تاريخ') }}</label>
            <x-filament::input.wrapper>
                <x-filament::input type="date" wire:model.live="filters.date_from" />
            </x-filament::input.wrapper>
        </div>
        <div>
            <label class="block text-xs font-semibold mb-1 text-gray-500">{{ __('إلى تاريخ') }}</label>
            <x-filament::input.wrapper>
                <x-filament::input type="date" wire:model.live="filters.date_to" />
            </x-filament::input.wrapper>
        </div>
        <div>
            <label class="block text-xs font-semibold mb-1 text-gray-500">{{ __('الموظف') }}</label>
            <x-filament::input.wrapper>
                <x-filament::input.select wire:model.live="filters.employee_id">
                    <option value="">{{ __('جميع الموظفين') }}</option>
                    @foreach($this->getFilterEmployees() as $id => $name)
                        <option value="{{ $id }}">{{ $name }}</option>
                    @endforeach
                </x-filament::input.select>
            </x-filament::input.wrapper>
        </div>
        <div>
            <label class="block text-xs font-semibold mb-1 text-gray-500">{{ __('السيارة') }}</label>
            <x-filament::input.wrapper>
                <x-filament::input.select wire:model.live="filters.car_id">
                    <option value="">{{ __('جميع السيارات') }}</option>
                    @foreach($this->getFilterCars() as $id => $name)
                        <option value="{{ $id }}">{{ $name }}</option>
                    @endforeach
                </x-filament::input.select>
            </x-filament::input.wrapper>
        </div>
    </div>
</div>

{{-- ===== KPI BAR ===== --}}
<div class="rpt-kpi-bar">
    {{-- Total Bookings --}}
    <div class="rpt-kpi-card" style="background:rgba(99,102,241,0.06); border-color:rgba(99,102,241,0.18);">
        <span style="font-size:0.7rem;font-weight:700;color:#6366f1;text-transform:uppercase;letter-spacing:0.04em;">إجمالي الحجوزات</span>
        <span style="font-size:1.6rem;font-weight:900;color:#4f46e5;line-height:1.1;">{{ number_format($kpi['total_bookings']) }}</span>
        <span style="font-size:0.7rem;color:#a5b4fc;">طلب في الفترة المحددة</span>
    </div>
    {{-- Sold --}}
    <div class="rpt-kpi-card" style="background:rgba(16,185,129,0.06); border-color:rgba(16,185,129,0.18);">
        <span style="font-size:0.7rem;font-weight:700;color:#059669;text-transform:uppercase;letter-spacing:0.04em;">مبيعات ناجحة</span>
        <span style="font-size:1.6rem;font-weight:900;color:#10b981;line-height:1.1;">{{ number_format($kpi['sold_count']) }}</span>
        <span style="font-size:0.7rem;color:#6ee7b7;">صفقة مكتملة بنجاح</span>
    </div>
    {{-- Revenue --}}
    <div class="rpt-kpi-card" style="background:rgba(245,158,11,0.06); border-color:rgba(245,158,11,0.2);">
        <span style="font-size:0.7rem;font-weight:700;color:#d97706;text-transform:uppercase;letter-spacing:0.04em;">إجمالي الإيرادات</span>
        <span style="font-size:1.25rem;font-weight:900;color:#f59e0b;line-height:1.1;">{{ number_format($kpi['total_revenue'], 0) }} <span style="font-size:0.7rem">ريال</span></span>
        <span style="font-size:0.7rem;color:#fcd34d;">من المبيعات المنجزة</span>
    </div>
    {{-- Total Leads --}}
    <div class="rpt-kpi-card" style="background:rgba(168,85,247,0.06); border-color:rgba(168,85,247,0.18);">
        <span style="font-size:0.7rem;font-weight:700;color:#9333ea;text-transform:uppercase;letter-spacing:0.04em;">العملاء المحتملون</span>
        <span style="font-size:1.6rem;font-weight:900;color:#a855f7;line-height:1.1;">{{ number_format($kpi['total_leads']) }}</span>
        <span style="font-size:0.7rem;color:#d8b4fe;">{{ $kpi['new_leads'] }} جديد غير معالج</span>
    </div>
    {{-- Conversion --}}
    <div class="rpt-kpi-card" style="background:rgba(20,184,166,0.06); border-color:rgba(20,184,166,0.18);">
        <span style="font-size:0.7rem;font-weight:700;color:#0d9488;text-transform:uppercase;letter-spacing:0.04em;">معدل التحويل</span>
        <span style="font-size:1.6rem;font-weight:900;color:#14b8a6;line-height:1.1;">{{ $kpi['conv_rate'] }}%</span>
        <span style="font-size:0.7rem;color:#5eead4;">من Lead إلى بيعة ناجحة</span>
    </div>
</div>

{{-- ===== TABS ===== --}}
<x-filament::tabs class="mb-5">
    <x-filament::tabs.item wire:click="changeTab('overview')"      :active="$activeTab==='overview'"      icon="heroicon-m-presentation-chart-bar">نظرة عامة</x-filament::tabs.item>
    <x-filament::tabs.item wire:click="changeTab('sales_details')" :active="$activeTab==='sales_details'" icon="heroicon-m-document-text">تفاصيل المبيعات</x-filament::tabs.item>
    <x-filament::tabs.item wire:click="changeTab('leads')"         :active="$activeTab==='leads'"         icon="heroicon-m-user-plus">العملاء المحتملون</x-filament::tabs.item>
    <x-filament::tabs.item wire:click="changeTab('employees')"     :active="$activeTab==='employees'"     icon="heroicon-m-user-group">أداء فريق العمل</x-filament::tabs.item>
    <x-filament::tabs.item wire:click="changeTab('sources')"       :active="$activeTab==='sources'"       icon="heroicon-m-arrow-trending-up">مصادر العملاء</x-filament::tabs.item>
</x-filament::tabs>

{{-- ===================== OVERVIEW TAB ===================== --}}
@if($activeTab === 'overview')
    @php
        $stats = $this->getFinancialStats();
        $totalB  = $stats['total_bookings'];
        $soldB   = $stats['sold_count'];
        $convB   = $totalB > 0 ? round(($soldB / $totalB) * 100, 1) : 0;
        $prevT   = $stats['prev_total'];
        $prevS   = $stats['prev_sold'];
        $prevR   = $stats['prev_revenue'];
        function trendIcon($curr, $prev) {
            if ($prev == 0 && $curr > 0) return ['↑', 'up', '+100%'];
            if ($prev == 0) return ['–', 'flat', '0%'];
            $pct = round((($curr - $prev) / $prev) * 100, 1);
            return $pct > 0 ? ['↑', 'up', "+{$pct}%"] : ($pct < 0 ? ['↓', 'down', "{$pct}%"] : ['–', 'flat', '0%']);
        }
        [$iconT, $dirT, $pctT] = trendIcon($totalB, $prevT);
        [$iconS, $dirS, $pctS] = trendIcon($soldB,  $prevS);
        [$iconR, $dirR, $pctR] = trendIcon($stats['total_revenue'], $prevR);
        $statusBreak = $this->getBookingStatusBreakdown();
    @endphp

    {{-- Stat Cards --}}
    <div class="rpt-stats-grid">
        {{-- Total Bookings --}}
        <div class="rpt-stat-card" style="background:rgba(99,102,241,0.05);border-color:rgba(99,102,241,0.15);">
            <div style="display:flex;align-items:center;justify-content:space-between;">
                <span style="font-size:0.75rem;font-weight:700;color:#6b7280;">إجمالي الحجوزات</span>
                <div style="padding:0.4rem;background:rgba(99,102,241,0.12);border-radius:0.5rem;">
                    <x-filament::icon icon="heroicon-m-list-bullet" class="h-4 w-4" style="color:#6366f1" />
                </div>
            </div>
            <div style="font-size:2.25rem;font-weight:900;color:#4f46e5;line-height:1.1;margin-top:0.25rem;">{{ number_format($totalB) }}</div>
            <div class="rpt-trend-{{ $dirT }}">{{ $iconT }} {{ $pctT }} عن الفترة السابقة</div>
            <div style="font-size:0.7rem;color:#9ca3af;margin-top:0.125rem;">جميع الطلبات والحجوزات</div>
        </div>

        {{-- Sold --}}
        <div class="rpt-stat-card" style="background:rgba(16,185,129,0.05);border-color:rgba(16,185,129,0.15);">
            <div style="display:flex;align-items:center;justify-content:space-between;">
                <span style="font-size:0.75rem;font-weight:700;color:#6b7280;">المبيعات الناجحة</span>
                <div style="padding:0.4rem;background:rgba(16,185,129,0.12);border-radius:0.5rem;">
                    <x-filament::icon icon="heroicon-m-check-badge" class="h-4 w-4" style="color:#10b981" />
                </div>
            </div>
            <div style="font-size:2.25rem;font-weight:900;color:#10b981;line-height:1.1;margin-top:0.25rem;">{{ number_format($soldB) }}</div>
            <div class="rpt-trend-{{ $dirS }}">{{ $iconS }} {{ $pctS }} عن الفترة السابقة</div>
            <div style="font-size:0.7rem;color:#10b981;margin-top:0.125rem;font-weight:600;">معدل نجاح {{ $convB }}%</div>
        </div>

        {{-- Revenue --}}
        <div class="rpt-stat-card" style="background:rgba(245,158,11,0.05);border-color:rgba(245,158,11,0.15);">
            <div style="display:flex;align-items:center;justify-content:space-between;">
                <span style="font-size:0.75rem;font-weight:700;color:#6b7280;">إجمالي قيمة المبيعات</span>
                <div style="padding:0.4rem;background:rgba(245,158,11,0.12);border-radius:0.5rem;">
                    <x-filament::icon icon="heroicon-m-banknotes" class="h-4 w-4" style="color:#f59e0b" />
                </div>
            </div>
            <div style="font-size:1.6rem;font-weight:900;color:#f59e0b;line-height:1.1;margin-top:0.25rem;">{{ number_format($stats['total_revenue'], 0) }} <span style="font-size:0.75rem;font-weight:700;">ريال</span></div>
            <div class="rpt-trend-{{ $dirR }}">{{ $iconR }} {{ $pctR }} عن الفترة السابقة</div>
            <div style="font-size:0.7rem;color:#9ca3af;margin-top:0.125rem;">السيارات المباعة واستلام قيمتها</div>
        </div>

        {{-- Down Payments --}}
        <div class="rpt-stat-card" style="background:rgba(59,130,246,0.05);border-color:rgba(59,130,246,0.15);">
            <div style="display:flex;align-items:center;justify-content:space-between;">
                <span style="font-size:0.75rem;font-weight:700;color:#6b7280;">إجمالي الدفعات المقدمة</span>
                <div style="padding:0.4rem;background:rgba(59,130,246,0.12);border-radius:0.5rem;">
                    <x-filament::icon icon="heroicon-m-credit-card" class="h-4 w-4" style="color:#3b82f6" />
                </div>
            </div>
            <div style="font-size:1.6rem;font-weight:900;color:#3b82f6;line-height:1.1;margin-top:0.25rem;">{{ number_format($stats['total_down_payments'], 0) }} <span style="font-size:0.75rem;font-weight:700;">ريال</span></div>
            <div style="font-size:0.7rem;color:#9ca3af;margin-top:0.5rem;">الدفعات المقدمة المحصلة</div>
        </div>
    </div>

    {{-- Booking Status Breakdown --}}
    <div class="rpt-section mb-6">
        <div class="rpt-section-title">
            <x-filament::icon icon="heroicon-m-chart-pie" class="h-4 w-4" />
            توزيع الطلبات حسب الحالة
        </div>
        @php
            $statusColors = [
                'new'       => ['bg'=>'rgba(99,102,241,0.1)','text'=>'#6366f1','bar'=>'#6366f1'],
                'contacted' => ['bg'=>'rgba(6,182,212,0.1)', 'text'=>'#06b6d4','bar'=>'#06b6d4'],
                'interested'=> ['bg'=>'rgba(245,158,11,0.1)','text'=>'#f59e0b','bar'=>'#f59e0b'],
                'rejected'  => ['bg'=>'rgba(239,68,68,0.1)', 'text'=>'#ef4444','bar'=>'#ef4444'],
                'sold'      => ['bg'=>'rgba(16,185,129,0.1)','text'=>'#10b981','bar'=>'#10b981'],
            ];
            $maxStatus = max(array_values($statusBreak) ?: [1]);
        @endphp
        <div style="display:grid;grid-template-columns:repeat(5,1fr);gap:0.75rem;">
            @foreach(\App\Models\Booking::STATUSES as $key => $cfg)
                @php $count = $statusBreak[$key] ?? 0; $pct = $maxStatus > 0 ? round($count/$maxStatus*100) : 0; $c = $statusColors[$key] ?? ['bg'=>'rgba(100,116,139,0.1)','text'=>'#6b7280','bar'=>'#6b7280']; @endphp
                <div style="background:{{ $c['bg'] }};border-radius:0.75rem;padding:0.875rem;text-align:center;">
                    <div style="font-size:1.6rem;font-weight:900;color:{{ $c['text'] }};line-height:1.1;">{{ $count }}</div>
                    <div style="font-size:0.7rem;font-weight:700;color:{{ $c['text'] }};margin:0.25rem 0;">{{ $cfg['label'] }}</div>
                    <div class="rpt-progress-track" style="margin-top:0.5rem;">
                        <div class="rpt-progress-fill" style="width:{{ $pct }}%;background:{{ $c['bar'] }};"></div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- Bottom 2 cols --}}
    <div class="rpt-two-col">
        {{-- Installment Analytics --}}
        <div class="rpt-section">
            <div class="rpt-section-title">
                <x-filament::icon icon="heroicon-m-calculator" class="h-4 w-4" />
                تحليل التقسيط والتمويل
            </div>
            @php
                $maxAvg = max($stats['avg_down_payment'], $stats['avg_monthly'], 1);
            @endphp
            <div style="display:flex;flex-direction:column;gap:1rem;">
                <div>
                    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:0.4rem;">
                        <span style="font-size:0.82rem;color:#6b7280;">متوسط الدفعة الأولى</span>
                        <span style="font-size:0.9rem;font-weight:800;color:var(--fi-color-gray-900, #111);">{{ number_format($stats['avg_down_payment'],0) }} <small>ريال</small></span>
                    </div>
                    <div class="rpt-progress-track"><div class="rpt-progress-fill" style="width:{{ min(100,round($stats['avg_down_payment']/$maxAvg*100)) }}%;background:#6366f1;"></div></div>
                </div>
                <div>
                    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:0.4rem;">
                        <span style="font-size:0.82rem;color:#6b7280;">متوسط القسط الشهري</span>
                        <span style="font-size:0.9rem;font-weight:800;">{{ number_format($stats['avg_monthly'],0) }} <small>ريال</small></span>
                    </div>
                    <div class="rpt-progress-track"><div class="rpt-progress-fill" style="width:{{ min(100,round($stats['avg_monthly']/$maxAvg*100)) }}%;background:#10b981;"></div></div>
                </div>
                <div style="display:flex;justify-content:space-between;align-items:center;padding:0.75rem;background:rgba(100,116,139,0.07);border-radius:0.625rem;">
                    <span style="font-size:0.82rem;color:#6b7280;">متوسط فترة التمويل</span>
                    <span style="font-size:1rem;font-weight:800;color:#f59e0b;">{{ number_format($stats['avg_duration'],1) }} <small>سنوات</small></span>
                </div>
            </div>
        </div>

        {{-- Top Cars --}}
        <div class="rpt-section">
            <div class="rpt-section-title">
                <x-filament::icon icon="heroicon-m-truck" class="h-4 w-4" />
                السيارات الأكثر مبيعاً
            </div>
            @php $topCars = $this->getTopCars(); $maxCar = collect($topCars)->max('total') ?: 1; @endphp
            <div style="display:flex;flex-direction:column;gap:0.75rem;">
                @forelse($topCars as $i => $car)
                    @php $barPct = round($car['total']/$maxCar*100); @endphp
                    <div style="display:flex;align-items:center;gap:0.75rem;">
                        <span style="font-size:0.65rem;font-weight:800;min-width:1.5rem;text-align:center;padding:0.2rem 0.4rem;border-radius:0.4rem;background:{{ $i===0?'rgba(245,158,11,0.15)':($i===1?'rgba(148,163,184,0.15)':($i===2?'rgba(180,83,9,0.12)':'rgba(100,116,139,0.08)')) }};color:{{ $i===0?'#d97706':($i===1?'#64748b':($i===2?'#c2410c':'#9ca3af')) }};">#{{ $i+1 }}</span>
                        <div style="flex:1;min-width:0;">
                            <div style="font-size:0.78rem;font-weight:700;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $car['car']['name'] ?? 'N/A' }}</div>
                            <div class="rpt-progress-track" style="margin-top:0.3rem;height:5px;">
                                <div class="rpt-progress-fill" style="width:{{ $barPct }}%;height:5px;background:{{ $i===0?'#f59e0b':($i===1?'#94a3b8':'#6366f1') }};"></div>
                            </div>
                        </div>
                        <span style="font-size:0.75rem;font-weight:800;color:#6366f1;white-space:nowrap;">{{ $car['total'] }} بيعة</span>
                    </div>
                @empty
                    <div style="text-align:center;padding:2rem;color:#9ca3af;font-size:0.82rem;">لا توجد بيانات كافية</div>
                @endforelse
            </div>
        </div>
    </div>

{{-- ===================== SALES DETAILS TAB ===================== --}}
@elseif($activeTab === 'sales_details')
    <div class="rpt-section">
        <div class="rpt-section-title">
            <x-filament::icon icon="heroicon-m-table-cells" class="h-4 w-4" />
            جدول تفاصيل المبيعات والحجوزات
        </div>
        <div style="overflow-x:auto;">
            <table class="rpt-table">
                <thead>
                    <tr>
                        <th>العميل</th>
                        <th>السيارة</th>
                        <th>السعر الإجمالي</th>
                        <th>المسؤول</th>
                        <th>طريقة الدفع</th>
                        <th>الدفعة / القسط</th>
                        <th style="text-align:center;">الحالة</th>
                        <th>التاريخ</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($this->getDetailedBookings() as $booking)
                        @php
                            $statusCfg = \App\Models\Booking::STATUSES[$booking['status']] ?? ['label'=>$booking['status'],'color'=>'gray'];
                            $badgeCls = match($statusCfg['color']) {
                                'success' => 'background:rgba(16,185,129,0.12);color:#059669;',
                                'primary' => 'background:rgba(99,102,241,0.12);color:#4f46e5;',
                                'info'    => 'background:rgba(6,182,212,0.12);color:#0891b2;',
                                'warning' => 'background:rgba(245,158,11,0.12);color:#d97706;',
                                'danger'  => 'background:rgba(239,68,68,0.12);color:#dc2626;',
                                default   => 'background:rgba(100,116,139,0.12);color:#6b7280;',
                            };
                            $initials = mb_substr($booking['client_name'] ?? '?', 0, 2);
                        @endphp
                        <tr>
                            <td>
                                <div style="display:flex;align-items:center;gap:0.625rem;">
                                    <div class="rpt-avatar" style="background:rgba(99,102,241,0.1);color:#4f46e5;">{{ $initials }}</div>
                                    <div>
                                        <div style="font-weight:700;font-size:0.82rem;">{{ $booking['client_name'] }}</div>
                                        <div style="font-size:0.7rem;color:#9ca3af;">{{ $booking['client_phone'] }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div style="font-weight:600;font-size:0.82rem;">{{ $booking['car']['name'] ?? 'N/A' }}</div>
                                <div style="font-size:0.7rem;color:#9ca3af;">{{ $booking['car']['brand']['name'] ?? '' }}</div>
                            </td>
                            <td style="font-weight:800;white-space:nowrap;">{{ number_format($booking['total_price'],0) }} <span style="font-size:0.7rem;font-weight:600;">ريال</span></td>
                            <td style="font-size:0.8rem;color:#6b7280;">{{ $booking['employee']['name'] ?? 'غير معين' }}</td>
                            <td>
                                <span class="rpt-badge" style="{{ $booking['payment_method']==='cash'?'background:rgba(16,185,129,0.1);color:#059669;':'background:rgba(99,102,241,0.1);color:#4f46e5;' }}">
                                    {{ $booking['payment_method']==='cash' ? 'كاش' : 'تقسيط' }}
                                </span>
                            </td>
                            <td>
                                @if($booking['payment_method']==='finance' || ($booking['down_payment']??0) > 0)
                                    <div style="font-size:0.72rem;color:#6b7280;">مقدم: <strong>{{ number_format($booking['down_payment'],0) }}</strong> ريال</div>
                                    @if(($booking['monthly_installment']??0) > 0)
                                        <div style="font-size:0.72rem;color:#6366f1;font-weight:700;">قسط: {{ number_format($booking['monthly_installment'],0) }} / {{ $booking['duration_years'] }} سنة</div>
                                    @endif
                                @else
                                    <span style="font-size:0.72rem;color:#9ca3af;">سداد كامل</span>
                                @endif
                            </td>
                            <td style="text-align:center;">
                                <span class="rpt-badge" style="{{ $badgeCls }}">{{ $statusCfg['label'] }}</span>
                            </td>
                            <td style="font-size:0.72rem;color:#9ca3af;white-space:nowrap;">{{ \Carbon\Carbon::parse($booking['created_at'])->format('Y-m-d') }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="8" style="text-align:center;padding:3rem;color:#9ca3af;">لا توجد حجوزات تطابق الفلاتر المحددة</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

{{-- ===================== LEADS PIPELINE TAB ===================== --}}
@elseif($activeTab === 'leads')
    @php
        $leadsStats = $this->getLeadsStats();
        $leadsStatuses = \App\Models\Lead::STATUSES;
        $leadsColors = [
            'new'        => ['bg'=>'rgba(99,102,241,0.1)', 'text'=>'#4f46e5', 'bar'=>'#6366f1'],
            'contacted'  => ['bg'=>'rgba(6,182,212,0.1)',  'text'=>'#0891b2', 'bar'=>'#06b6d4'],
            'interested' => ['bg'=>'rgba(245,158,11,0.1)', 'text'=>'#d97706', 'bar'=>'#f59e0b'],
            'negotiation'=> ['bg'=>'rgba(168,85,247,0.1)', 'text'=>'#7c3aed', 'bar'=>'#a855f7'],
            'converted'  => ['bg'=>'rgba(16,185,129,0.1)', 'text'=>'#059669', 'bar'=>'#10b981'],
            'lost'       => ['bg'=>'rgba(239,68,68,0.1)',  'text'=>'#dc2626', 'bar'=>'#ef4444'],
        ];
        $totalLeads = $leadsStats['total'] ?? 0;
    @endphp

    {{-- Pipeline Status Cards --}}
    <div style="display:grid;grid-template-columns:repeat(6,1fr);gap:0.75rem;margin-bottom:1.5rem;">
        @foreach($leadsStatuses as $key => $cfg)
            @php $count = $leadsStats[$key] ?? 0; $pct = $totalLeads > 0 ? round($count/$totalLeads*100,1) : 0; $c = $leadsColors[$key]; @endphp
            <div style="background:{{ $c['bg'] }};border-radius:0.875rem;padding:1rem;text-align:center;border:1px solid {{ $c['bar'] }}22;">
                <div style="font-size:1.8rem;font-weight:900;color:{{ $c['text'] }};line-height:1.1;">{{ $count }}</div>
                <div style="font-size:0.7rem;font-weight:700;color:{{ $c['text'] }};margin-top:0.2rem;">{{ $cfg['label'] }}</div>
                <div style="font-size:0.65rem;color:#9ca3af;margin-top:0.2rem;">{{ $pct }}%</div>
                <div class="rpt-progress-track" style="margin-top:0.5rem;">
                    <div class="rpt-progress-fill" style="width:{{ $pct }}%;background:{{ $c['bar'] }};"></div>
                </div>
            </div>
        @endforeach
    </div>

    {{-- Leads Table --}}
    <div class="rpt-section">
        <div class="rpt-section-title">
            <x-filament::icon icon="heroicon-m-users" class="h-4 w-4" />
            آخر العملاء المحتملين ({{ $totalLeads }} إجمالاً)
        </div>
        <div style="overflow-x:auto;">
            <table class="rpt-table">
                <thead>
                    <tr>
                        <th>العميل</th>
                        <th>مصدر التواصل</th>
                        <th>السيارة المهتم بها</th>
                        <th>الموظف المسؤول</th>
                        <th style="text-align:center;">الحالة</th>
                        <th>تاريخ البداية</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($this->getLeadsPipeline() as $lead)
                        @php
                            $lCfg = \App\Models\Lead::STATUSES[$lead['status']] ?? ['label'=>$lead['status'],'color'=>'gray'];
                            $lBadge = match($lCfg['color']) {
                                'success'   => 'background:rgba(16,185,129,0.12);color:#059669;',
                                'primary'   => 'background:rgba(99,102,241,0.12);color:#4f46e5;',
                                'info'      => 'background:rgba(6,182,212,0.12);color:#0891b2;',
                                'warning'   => 'background:rgba(245,158,11,0.12);color:#d97706;',
                                'secondary' => 'background:rgba(168,85,247,0.12);color:#7c3aed;',
                                'danger'    => 'background:rgba(239,68,68,0.12);color:#dc2626;',
                                default     => 'background:rgba(100,116,139,0.12);color:#6b7280;',
                            };
                            $lInit = mb_substr($lead['client_name'] ?? '?', 0, 2);
                        @endphp
                        <tr>
                            <td>
                                <div style="display:flex;align-items:center;gap:0.625rem;">
                                    <div class="rpt-avatar" style="background:rgba(168,85,247,0.1);color:#7c3aed;">{{ $lInit }}</div>
                                    <div>
                                        <div style="font-weight:700;font-size:0.82rem;">{{ $lead['client_name'] }}</div>
                                        <div style="font-size:0.7rem;color:#9ca3af;">{{ $lead['client_phone'] }}</div>
                                    </div>
                                </div>
                            </td>
                            <td style="font-size:0.78rem;color:#6b7280;">{{ $lead['contact_source']['name'] ?? '—' }}</td>
                            <td>
                                @if($lead['car'])
                                    <div style="font-size:0.78rem;font-weight:600;">{{ $lead['car']['name'] ?? '—' }}</div>
                                    <div style="font-size:0.7rem;color:#9ca3af;">{{ $lead['car']['brand']['name'] ?? '' }}</div>
                                @else
                                    <span style="color:#9ca3af;font-size:0.78rem;">غير محدد</span>
                                @endif
                            </td>
                            <td style="font-size:0.78rem;color:#6b7280;">{{ $lead['employee']['name'] ?? 'غير معين' }}</td>
                            <td style="text-align:center;">
                                <span class="rpt-badge" style="{{ $lBadge }}">{{ $lCfg['label'] }}</span>
                            </td>
                            <td style="font-size:0.72rem;color:#9ca3af;white-space:nowrap;">{{ $lead['started_at'] ?? '—' }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="6" style="text-align:center;padding:3rem;color:#9ca3af;">لا توجد بيانات عملاء محتملين</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

{{-- ===================== EMPLOYEES TAB ===================== --}}
@elseif($activeTab === 'employees')
    @php $employees = $this->getEmployeePerformance(); @endphp
    <div class="rpt-emp-grid">
        @forelse($employees as $rank => $emp)
            @php
                $rate = ($emp['total_bookings'] ?? 0) > 0 ? round(($emp['sold_bookings'] ?? 0) / $emp['total_bookings'] * 100) : 0;
                $barColor = $rate >= 60 ? '#10b981' : ($rate >= 30 ? '#f59e0b' : '#ef4444');
                $rankStyle = $rank===0 ? 'rpt-rank-gold' : ($rank===1 ? 'rpt-rank-silver' : ($rank===2 ? 'rpt-rank-bronze' : ''));
            @endphp
            <div class="rpt-section" style="position:relative;">
                {{-- Rank Badge --}}
                <div style="position:absolute;top:0.875rem;left:0.875rem;">
                    <span class="rpt-badge {{ $rankStyle }}" style="{{ !$rankStyle?'background:rgba(100,116,139,0.08);color:#9ca3af;':'' }}">
                        {{ $rank===0?'🥇 الأول':($rank===1?'🥈 الثاني':($rank===2?'🥉 الثالث':'#'.($rank+1))) }}
                    </span>
                </div>

                {{-- Employee Info --}}
                <div style="display:flex;align-items:center;gap:0.75rem;margin-bottom:1rem;padding-top:1.5rem;">
                    <div style="width:2.5rem;height:2.5rem;border-radius:50%;background:rgba(99,102,241,0.12);color:#4f46e5;display:flex;align-items:center;justify-content:center;font-size:0.8rem;font-weight:800;flex-shrink:0;">
                        {{ mb_substr($emp['name'],0,2) }}
                    </div>
                    <div>
                        <div style="font-weight:800;font-size:0.9rem;">{{ $emp['name'] }}</div>
                        <div style="font-size:0.7rem;color:#9ca3af;">{{ $emp['email'] }}</div>
                    </div>
                </div>

                {{-- Stats --}}
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:0.75rem;margin-bottom:1rem;">
                    <div style="background:rgba(100,116,139,0.07);border-radius:0.625rem;padding:0.75rem;text-align:center;">
                        <div style="font-size:1.4rem;font-weight:900;">{{ $emp['total_bookings'] }}</div>
                        <div style="font-size:0.68rem;color:#9ca3af;margin-top:0.1rem;">إجمالي الحالات</div>
                    </div>
                    <div style="background:rgba(16,185,129,0.07);border-radius:0.625rem;padding:0.75rem;text-align:center;">
                        <div style="font-size:1.4rem;font-weight:900;color:#10b981;">{{ $emp['sold_bookings'] }}</div>
                        <div style="font-size:0.68rem;color:#6ee7b7;margin-top:0.1rem;">مبيعات ناجحة</div>
                    </div>
                </div>

                {{-- Progress --}}
                <div>
                    <div style="display:flex;justify-content:space-between;font-size:0.72rem;font-weight:700;margin-bottom:0.375rem;">
                        <span style="color:#6b7280;">معدل الإغلاق</span>
                        <span style="color:{{ $barColor }};">{{ $rate }}%</span>
                    </div>
                    <div class="rpt-progress-track">
                        <div class="rpt-progress-fill" style="width:{{ $rate }}%;background:{{ $barColor }};"></div>
                    </div>
                </div>
            </div>
        @empty
            <div class="rpt-section" style="grid-column:1/-1;text-align:center;padding:3rem;color:#9ca3af;">لا يوجد موظفون</div>
        @endforelse
    </div>

{{-- ===================== SOURCES TAB ===================== --}}
@elseif($activeTab === 'sources')
    @php
        $sources = $this->getSourcePerformance();
        $grandTotal = collect($sources)->sum('total_leads');
        $sourceIcons = ['واتساب'=>'💬','إنستقرام'=>'📸','تويتر'=>'🐦','يوتيوب'=>'▶️','جوجل'=>'🔍','فيسبوك'=>'👍','سناب شات'=>'👻'];
    @endphp

    <div style="display:grid;grid-template-columns:1fr 2fr;gap:1.5rem;align-items:start;">
        {{-- Summary Card --}}
        <div class="rpt-section">
            <div class="rpt-section-title">
                <x-filament::icon icon="heroicon-m-globe-alt" class="h-4 w-4" />
                ملخص المصادر
            </div>
            <div style="text-align:center;padding:1rem 0;">
                <div style="font-size:3rem;font-weight:900;color:#6366f1;">{{ number_format($grandTotal) }}</div>
                <div style="font-size:0.82rem;color:#9ca3af;margin-top:0.25rem;">إجمالي العملاء المحتملين</div>
            </div>
            <div style="font-size:0.75rem;color:#6b7280;text-align:center;padding:0.75rem;background:rgba(100,116,139,0.07);border-radius:0.625rem;">
                {{ count($sources) }} قناة استقطاب مختلفة
            </div>
        </div>

        {{-- Sources Breakdown --}}
        <div class="rpt-section">
            <div class="rpt-section-title">
                <x-filament::icon icon="heroicon-m-bars-3-bottom-right" class="h-4 w-4" />
                توزيع العملاء حسب القناة
            </div>
            <div style="display:flex;flex-direction:column;gap:1rem;">
                @forelse($sources as $i => $source)
                    @php
                        $pct = $grandTotal > 0 ? round($source['total_leads']/$grandTotal*100,1) : 0;
                        $srcName = $source['contact_source']['name'] ?? 'طلب من المتجر';
                        $emoji = '';
                        foreach($sourceIcons as $k=>$v) { if(str_contains($srcName,$k)){$emoji=$v;break;} }
                        $barColors = ['#6366f1','#10b981','#f59e0b','#06b6d4','#a855f7','#ef4444','#f97316','#84cc16'];
                        $barColor = $barColors[$i % count($barColors)];
                    @endphp
                    <div>
                        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:0.375rem;">
                            <span style="font-size:0.82rem;font-weight:600;">{{ $emoji }} {{ $srcName }}</span>
                            <div style="display:flex;align-items:center;gap:0.5rem;">
                                <span style="font-size:0.82rem;font-weight:800;color:{{ $barColor }};">{{ $source['total_leads'] }}</span>
                                <span style="font-size:0.7rem;color:#9ca3af;">({{ $pct }}%)</span>
                            </div>
                        </div>
                        <div class="rpt-progress-track" style="height:9px;">
                            <div class="rpt-progress-fill" style="width:{{ $pct }}%;background:{{ $barColor }};height:9px;"></div>
                        </div>
                    </div>
                @empty
                    <div style="text-align:center;padding:2rem;color:#9ca3af;">لا توجد بيانات مصادر</div>
                @endforelse
            </div>
        </div>
    </div>
@endif

</x-filament-panels::page>
