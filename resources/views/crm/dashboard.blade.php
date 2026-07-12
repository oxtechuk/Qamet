@extends('partials.Layouts.crm-master')
@section('title', __('الرئيسية') . ' | GR Motors')

@section('content')
<div class="container-fluid" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">

    {{-- ===== Header Row ===== --}}
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
        <div>
            <h4 class="mb-0 fw-bold" style="color:var(--crm-text);">
                👋 {{ __('أهلاً بك') }} {{ auth()->guard('employee')->user()?->name }}
            </h4>
        </div>
        <div class="d-flex gap-2">
            @can('manage-bookings')
            <a href="{{ route('crm.bookings.index') }}" class="btn-crm-light">
                <i class="bi bi-plus-lg"></i> {{ __('إضافة حجز جديد') }}
            </a>
            @endcan
            @can('manage-leads')
            <a href="{{ route('crm.leads.index') }}" class="btn-crm-primary">
                <i class="bi bi-person-plus"></i> {{ __('إضافة عميل') }}
            </a>
            @endcan
        </div>
    </div>

    {{-- ===== Stat Cards ===== --}}
    <div class="row g-3 mb-4">
        {{-- الطلبات المعلقة --}}
        <div class="col-6 col-xl-3">
            <div class="crm-stat-new">
                <span class="stat-badge orange">{{ __('تنبيه') }}</span>
                <div class="stat-icon red"><i class="bi bi-clock"></i></div>
                <div class="stat-lbl">{{ __('الطلبات المعلقة') }}</div>
                <div class="stat-val">{{ number_format($stats['new']) }}</div>
            </div>
        </div>
        {{-- الطلبات المكتملة --}}
        <div class="col-6 col-xl-3">
            <div class="crm-stat-new">
                <span class="stat-badge green">65%</span>
                <div class="stat-icon green"><i class="bi bi-check-circle"></i></div>
                <div class="stat-lbl">{{ __('الطلبات المكتملة') }}</div>
                <div class="stat-val">{{ number_format($stats['sold']) }}</div>
            </div>
        </div>
        {{-- طلبات اليوم --}}
        <div class="col-6 col-xl-3">
            <div class="crm-stat-new">
                <span class="stat-badge blue">{{ __('نشط') }}</span>
                <div class="stat-icon blue"><i class="bi bi-calendar-day"></i></div>
                <div class="stat-lbl">{{ __('طلبات اليوم') }}</div>
                <div class="stat-val">{{ number_format($stats['in_progress']) }}</div>
            </div>
        </div>
        {{-- عدد العملاء --}}
        <div class="col-6 col-xl-3">
            <div class="crm-stat-new">
                <span class="stat-badge green">+12%</span>
                <div class="stat-icon purple"><i class="bi bi-people"></i></div>
                <div class="stat-lbl">{{ __('عدد العملاء') }}</div>
                <div class="stat-val">{{ number_format($stats['total']) }}</div>
            </div>
        </div>
    </div>

    {{-- ===== Tracking Status Widget ===== --}}
    @can('manage-settings')
    <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden" style="border:1px solid var(--crm-border)!important;">
        <div class="card-body px-4 py-3">
            <div class="d-flex align-items-center flex-wrap gap-4">
                <div class="d-flex align-items-center gap-2">
                    <i class="bi bi-graph-up" style="font-size:18px;color:var(--crm-text-muted);"></i>
                    <span class="fw-bold small text-muted">{{ __('حالة التتبع') }}</span>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-google" style="color:#1877F2;font-size:15px;"></i>
                        <span class="small fw-bold">{{ __('Google Analytics') }}</span>
                        @if($trackingGA)
                            <span class="badge rounded-pill" style="background:#EDFAF4;color:#12B76A;font-size:10px;">
                                <i class="bi bi-check-circle-fill me-1"></i>{{ $trackingGA }}
                            </span>
                        @else
                            <span class="badge rounded-pill" style="background:#F5F6FA;color:#8E92A4;font-size:10px;">
                                <i class="bi bi-dash-circle me-1"></i>{{ __('غير مفعل') }}
                            </span>
                        @endif
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-facebook" style="color:#1877F2;font-size:15px;"></i>
                        <span class="small fw-bold">{{ __('Meta Pixel') }}</span>
                        @if($trackingPixel)
                            <span class="badge rounded-pill" style="background:#EDFAF4;color:#12B76A;font-size:10px;">
                                <i class="bi bi-check-circle-fill me-1"></i>{{ $trackingPixel }}
                            </span>
                        @else
                            <span class="badge rounded-pill" style="background:#F5F6FA;color:#8E92A4;font-size:10px;">
                                <i class="bi bi-dash-circle me-1"></i>{{ __('غير مفعل') }}
                            </span>
                        @endif
                    </div>
                </div>
                <a href="{{ route('crm.settings.seo') }}" class="btn btn-sm rounded-3 ms-auto" style="background:var(--crm-red-light);color:var(--crm-red);font-weight:700;font-size:11px;text-decoration:none;">
                    <i class="bi bi-gear me-1"></i>{{ __('إعدادات التتبع') }}
                </a>
            </div>
        </div>
    </div>
    @endcan

    {{-- ===== Row 2: Orders Table + Income/Complaints ===== --}}
    <div class="row g-3 mb-4">

        {{-- نظرة عامة على الطلبات --}}
        <div class="col-12 col-xl-7">
            <div class="card border-0 shadow-sm rounded-4 h-100" style="border:1px solid var(--crm-border)!important;">
                <div class="card-header bg-white border-0 pt-4 px-4 pb-2 d-flex justify-content-between align-items-center" style="border-bottom:1px solid var(--crm-border)!important;">
                    <h6 class="mb-0 fw-bold">{{ __('نظرة عامة على الطلبات') }}</h6>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead style="background:#F8F9FC;">
                                <tr>
                                    <th class="px-4 py-3 text-muted fw-bold" style="font-size:12px;">{{ __('رقم الطلب') }}</th>
                                    <th class="py-3 text-muted fw-bold" style="font-size:12px;">{{ __('العميل') }}</th>
                                    <th class="py-3 text-muted fw-bold" style="font-size:12px;">{{ __('السيارة') }}</th>
                                    <th class="py-3 text-muted fw-bold" style="font-size:12px;">{{ __('الموعد') }}</th>
                                    <th class="py-3 text-muted fw-bold" style="font-size:12px;">{{ __('الحالة') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentBookings as $booking)
                                <tr>
                                    <td class="px-4 fw-bold" style="font-size:13px;">
                                        <a href="{{ route('crm.bookings.show', $booking) }}" class="text-decoration-none" style="color:var(--crm-text);">#{{ $booking->id }}</a>
                                    </td>
                                    <td>
                                        <div class="fw-bold" style="font-size:13px;color:var(--crm-text);">{{ $booking->client_name }}</div>
                                        <small class="text-muted">{{ $booking->client_phone }}</small>
                                    </td>
                                    <td>
                                        <div style="font-size:12px;color:var(--crm-text);">{{ $booking->car->name ?? '—' }}</div>
                                        <small class="text-muted">{{ $booking->car->brand->name ?? '' }}</small>
                                    </td>
                                    <td style="font-size:12px;color:var(--crm-text-muted);">
                                        {{ $booking->created_at->format('d/m/Y') }}
                                    </td>
                                    <td>
                                        @php
                                            $dotClass = match($booking->status) {
                                                'new','pending'  => 'planned',
                                                'in_progress'    => 'waiting',
                                                'sold','done'    => 'done',
                                                'rejected'       => 'late',
                                                default          => 'confirmed',
                                            };
                                        @endphp
                                        <span class="status-dot {{ $dotClass }}">{{ $booking->status_label }}</span>
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="5" class="text-center text-muted py-5">{{ __('لا توجد طلبات') }}</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="px-4 py-3" style="border-top:1px solid var(--crm-border);">
                        <a href="{{ route('crm.bookings.index') }}" class="text-decoration-none fw-bold" style="font-size:13px;color:var(--crm-red);">{{ __('عرض كل الطلبات') }}</a>
                    </div>
                </div>
            </div>
        </div>

        {{-- إجمالي الدخل + الشكاوي --}}
        <div class="col-12 col-xl-5">
            <div class="row g-3 h-100">
                {{-- إجمالي الدخل --}}
                <div class="col-12">
                    <div class="card border-0 shadow-sm rounded-4" style="border:1px solid var(--crm-border)!important;">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <h6 class="fw-bold mb-0">{{ __('إجمالي الدخل') }}</h6>
                                <div class="d-flex gap-2">
                                    <button class="btn btn-sm btn-light rounded-2" style="font-size:11px;">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                    <button class="btn btn-sm btn-light rounded-2" style="font-size:11px;">
                                        <i class="bi bi-arrow-up-right"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="fw-black mb-1" style="font-size:24px;color:var(--crm-text);">
                                {{ number_format($stats['total'] * 2000) }}
                                <small style="font-size:13px;font-weight:600;color:var(--crm-text-muted);">{{ __('ريال سعودي') }}</small>
                            </div>
                            <div style="font-size:12px;color:var(--crm-green);">
                                ↑ 18% {{ __('مقارنة بالشهر الماضي') }}
                            </div>
                            <div id="incomeSparkline" style="margin-top:12px;"></div>
                        </div>
                    </div>
                </div>
                {{-- الشكاوي --}}
                <div class="col-12">
                    <div class="card border-0 shadow-sm rounded-4" style="border:1px solid var(--crm-border)!important;">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h6 class="fw-bold mb-0">{{ __('الشكاوي') }}</h6>
                                <i class="bi bi-arrow-up-right text-muted" style="font-size:14px;"></i>
                            </div>
                            <div class="fw-black mb-1" style="font-size:24px;color:var(--crm-text);">
                                {{ $stats['rejected'] ?? 0 }}
                                <small style="font-size:13px;font-weight:600;color:var(--crm-text-muted);">{{ __('شكوى') }}</small>
                            </div>
                            <div style="font-size:12px;color:var(--crm-red);">
                                <i class="bi bi-clock me-1"></i>
                                {{ $stats['new'] ?? 0 }} {{ __('معلقة') }}
                            </div>
                            <div style="font-size:12px;color:var(--crm-text-muted);margin-top:4px;">
                                ↓ 16% {{ __('مقارنة بالشهر الماضي') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ===== Row 3: Orders Rate Chart + Notifications ===== --}}
    <div class="row g-3">

        {{-- معدل الطلبات --}}
        <div class="col-12 col-xl-7">
            <div class="card border-0 shadow-sm rounded-4" style="border:1px solid var(--crm-border)!important;">
                <div class="card-header bg-white border-0 pt-4 px-4 pb-2 d-flex justify-content-between align-items-center" style="border-bottom:1px solid var(--crm-border)!important;">
                    <h6 class="mb-0 fw-bold">{{ __('معدل الطلبات') }}</h6>
                    <div class="d-flex gap-2">
                        <button class="btn btn-sm btn-light rounded-2 fw-bold" style="font-size:12px;">{{ __('يوم') }}</button>
                        <button class="btn btn-sm btn-light rounded-2 fw-bold" style="font-size:12px;">{{ __('أسبوع') }}</button>
                        <button class="btn btn-sm rounded-2 fw-bold" style="font-size:12px;background:var(--crm-border);">{{ __('شهر') }}</button>
                        <button class="btn btn-sm btn-light rounded-2" style="font-size:12px;"><i class="bi bi-calendar3"></i></button>
                    </div>
                </div>
                <div class="card-body p-4">
                    <div id="weeklyChart"></div>
                </div>
            </div>
        </div>

        {{-- الإشعارات --}}
        <div class="col-12 col-xl-5">
            <div class="card border-0 shadow-sm rounded-4 h-100" style="border:1px solid var(--crm-border)!important;">
                <div class="card-header bg-white border-0 pt-4 px-4 pb-2 d-flex justify-content-between align-items-center" style="border-bottom:1px solid var(--crm-border)!important;">
                    <h6 class="mb-0 fw-bold">{{ __('الإشعارات') }}</h6>
                    <label class="d-flex align-items-center gap-2" style="font-size:12px;color:var(--crm-text-muted);cursor:pointer;">
                        <input type="checkbox" checked> {{ __('تحديد الكل كمقروء') }}
                    </label>
                </div>
                <div class="card-body p-3" style="overflow-y:auto;max-height:340px;">
                    <p class="text-muted fw-bold mb-2" style="font-size:11px;">{{ __('اليوم') }}</p>

                    {{-- إشعار 1 --}}
                    @foreach($recentBookings->take(2) as $notif)
                    <div class="p-3 rounded-3 mb-3" style="background:#FFF8EC;border:1px solid #FDEBC8;">
                        <div class="d-flex align-items-start gap-3">
                            <div style="width:36px;height:36px;background:#FFF0F0;border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                <i class="bi bi-bag" style="color:var(--crm-red);font-size:15px;"></i>
                            </div>
                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <strong style="font-size:13px;">{{ __('طلب قارب على الانتهاء') }}</strong>
                                    <span style="font-size:11px;color:var(--crm-orange);">● {{ __('منذ') }} 5 {{ __('دقائق') }}</span>
                                </div>
                                <p class="mb-2" style="font-size:12px;color:var(--crm-text-muted);">{{ __('طلب') }} #{{ $notif->id }} — {{ $notif->client_name }}</p>
                                <div class="d-flex gap-2">
                                    <button class="btn btn-sm btn-light rounded-2 fw-bold" style="font-size:12px;">{{ __('تجاهل') }}</button>
                                    <a href="{{ route('crm.bookings.show', $notif) }}" class="btn btn-sm rounded-2 fw-bold text-white" style="font-size:12px;background:var(--crm-red);">{{ __('عرض التفاصيل') }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach

                    @if($recentBookings->count() > 2)
                    <p class="text-muted fw-bold mb-2 mt-3" style="font-size:11px;">{{ __('أمس') }}</p>
                    <div class="p-3 rounded-3 mb-2" style="background:#FFF0F0;border:1px solid #FFCDD2;">
                        <div class="d-flex align-items-start gap-3">
                            <div style="width:36px;height:36px;background:#FFEBEE;border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                <i class="bi bi-list-task" style="color:var(--crm-red);font-size:15px;"></i>
                            </div>
                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <strong style="font-size:13px;">{{ __('مهمة متأخرة') }}</strong>
                                    <span style="font-size:11px;color:var(--crm-red);">● {{ __('منذ') }} 5 {{ __('دقائق') }}</span>
                                </div>
                                <p class="mb-2" style="font-size:12px;color:var(--crm-text-muted);">{{ __('مهمة إرسال عرض الأسعار لم يتم تنفيذها') }}</p>
                                <div class="d-flex gap-2">
                                    <button class="btn btn-sm btn-light rounded-2 fw-bold" style="font-size:12px;">{{ __('تجاهل') }}</button>
                                    <a href="{{ route('crm.tasks.index') }}" class="btn btn-sm rounded-2 fw-bold text-white" style="font-size:12px;background:var(--crm-red);">{{ __('فتح المهمة') }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
                <div class="card-footer bg-white border-0 text-center py-3" style="border-top:1px solid var(--crm-border)!important;">
                    <a href="#" class="fw-bold text-decoration-none" style="font-size:13px;color:var(--crm-text-muted);">{{ __('عرض الكل') }}</a>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection

@section('scripts')
<script>
// Chart معدل الطلبات
const weeklyData = @json($weeklyBookings);
const dates  = weeklyData.map(d => d.date);
const counts = weeklyData.map(d => d.count);

new ApexCharts(document.querySelector("#weeklyChart"), {
    series: [
        { name: '{{ __("الطلبات") }}', data: counts },
        { name: '{{ __("المكتملة") }}', data: counts.map(v => Math.max(0, v - Math.floor(Math.random()*3))) }
    ],
    chart: { type: 'area', height: 220, toolbar: { show: false }, fontFamily: 'inherit' },
    colors: ['#299BE0', '#12B76A'],
    fill: { type: 'gradient', gradient: { shadeIntensity: 1, opacityFrom: 0.3, opacityTo: 0.02 } },
    stroke: { curve: 'smooth', width: 2 },
    xaxis: { categories: dates, labels: { style: { fontSize: '11px', colors: '#8E92A4' } } },
    yaxis: { labels: { style: { fontSize: '11px', colors: '#8E92A4' } } },
    dataLabels: { enabled: false },
    grid: { borderColor: '#F5F6FA', strokeDashArray: 4 },
    legend: { show: true, position: 'top', horizontalAlign: '{{ app()->getLocale() == "ar" ? "right" : "left" }}' },
}).render();

// Sparkline للدخل
new ApexCharts(document.querySelector("#incomeSparkline"), {
    series: [{ data: [30,40,35,50,49,60,70,91,125] }],
    chart: { type: 'line', height: 50, sparkline: { enabled: true } },
    colors: ['#299BE0'],
    stroke: { curve: 'smooth', width: 2 },
    tooltip: { enabled: false },
}).render();

// Badge الطلبات الجديدة
const newCount = {{ $stats['new'] }};
if (newCount > 0) {
    document.querySelectorAll('.new-leads-badge').forEach(el => {
        el.textContent = newCount;
        el.style.display = 'inline-block';
    });
}
</script>
@endsection
