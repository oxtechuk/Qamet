@extends('partials.Layouts.crm-master')
@section('title', __('تقرير الأداء والمبيعات الشامل') . ' | AutoCRM')

@section('content')
    <div class="container-fluid" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">

        <div class="d-flex align-items-center justify-content-between mb-4 d-print-none bg-white p-3 rounded-4 shadow-sm border">
            <div>
                <h4 class="mb-1 fw-bold text-dark"> {{ __('تقرير الأداء والمبيعات الشامل') }}</h4>
                <p class="text-muted mb-0 small">{{ __('تحليل بيانات الحجوزات والمبيعات وموظفي المبيعات ومصادر العملاء') }}</p>
            </div>
            <button class="btn btn-danger btn-lg shadow px-5 d-flex align-items-center gap-2 fw-bold" onclick="printAllReports()" style="border-radius: 12px; background: var(--crm-red); border: none;">
                <i class="bi bi-printer-fill fs-5"></i> {{ __('طباعة التقرير الشامل') }}
            </button>
        </div>

        {{-- Print-Only Header --}}
        <div class="d-none d-print-block mb-4 overflow-visible">
            <div class="d-flex justify-content-between align-items-end border-bottom pb-3 mb-4" style="border-width: 2px !important; border-color: var(--crm-red) !important;">
                <div class="flex-grow-1">
                    <div class="d-flex align-items-center gap-3 mb-2">
                        @if(isset($settings['site_logo']))
                            <img src="{{ asset('storage/' . $settings['site_logo']) }}" style="height: 50px; width: auto;" alt="Logo">
                        @endif
                        <h3 class="fw-bold mb-0" style="color: var(--crm-red);">
                            @if(isset($settings['site_name']))
                                {{ is_array($settings['site_name']) ? ($settings['site_name'][app()->getLocale()] ?? $settings['site_name']['ar'] ?? array_values($settings['site_name'])[0] ?? 'AutoCRM Reports') : $settings['site_name'] }}
                            @else
                                AutoCRM Reports
                            @endif
                        </h3>
                    </div>
                    <h5 class="text-dark fw-bold mb-1" id="current-print-title">{{ __('تقرير الأداء والمبيعات الشامل') }}</h5>
                    <p class="text-muted small mb-0">{{ __('الفترة من') }} {{ $from }} {{ __('إلى') }} {{ $to }}</p>
                </div>
                <div class="text-start" style="min-width: 150px;">
                    <small class="text-muted d-block fw-bold">{{ __('تاريخ الطباعة') }}: {{ date('Y-m-d') }}</small>
                    <small class="text-muted d-block">{{ __('بواسطة') }}: {{ auth('employee')->user()->name ?? __('مدير النظام') }}</small>
                    <small class="text-muted d-block">{{ __('عدد الصفحات') }}: {{ __('تلقائي') }}</small>
                </div>
            </div>
        </div>

        {{-- Filters --}}
        <div class="card border-0 shadow-sm mb-4 rounded-4 overflow-hidden d-print-none">
            <div class="card-body p-4 bg-light-subtle">
                <form method="GET" class="row g-3 align-items-end">
                    <div class="col-md-4">
                        <label class="form-label fw-bold small text-muted">{{ __('من تاريخ') }}</label>
                        <input type="date" name="from" class="form-control border-0 shadow-xs" value="{{ $from }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold small text-muted">{{ __('إلى تاريخ') }}</label>
                        <input type="date" name="to" class="form-control border-0 shadow-xs" value="{{ $to }}">
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-primary w-100 fw-bold rounded-3 py-2">
                            <i class="bi bi-funnel me-1"></i> {{ __('تحديث التقرير') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div id="all-reports-container">
            <!-- 1. تقرير الأداء المالي والمبيعات الشامل -->
            <div id="report-financial" class="report-section mb-5 bg-white p-4 rounded-4 shadow-sm">
                <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-3">
                    <h5 class="fw-bold mb-0 text-primary"><i class="bi bi-wallet2 me-2"></i> {{ __('1. الأداء المالي والمبيعات') }}</h5>
                    <button class="btn btn-sm btn-light border d-print-none print-btn-trigger" onclick="printReport('report-financial', 'تقرير الأداء المالي والمبيعات')"><i class="bi bi-printer"></i> طباعة A4</button>
                </div>
                <div class="row g-3">
                    <div class="col-md-8">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="card border-0 shadow-xs rounded-4 h-100 border-bottom border-4 border-primary bg-light-subtle">
                                    <div class="card-body p-4 text-center">
                                        <div class="text-muted small fw-bold mb-2 text-uppercase">{{ __('إجمالي الحجوزات') }}</div>
                                        <div class="fs-2 fw-black text-dark">{{ number_format($financial['total_bookings']) }}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card border-0 shadow-xs rounded-4 h-100 border-bottom border-4 border-success bg-light-subtle">
                                    <div class="card-body p-4 text-center">
                                        <div class="text-muted small fw-bold mb-2 text-uppercase">{{ __('السيارات المباعة فعلياً') }}</div>
                                        <div class="fs-2 fw-black text-success">{{ number_format($financial['total_sold']) }}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card border-0 shadow-xs rounded-4 h-100 border-bottom border-4 border-info bg-light-subtle">
                                    <div class="card-body p-4 text-center">
                                        <div class="text-muted small fw-bold mb-2 text-uppercase">{{ __('المقدمات المحصلة') }}</div>
                                        <div class="fs-3 fw-bold text-dark">{{ number_format($financial['total_down_payment']) }} <span class="fs-6 text-muted">ج.م</span></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card border-0 shadow-xs rounded-4 h-100 border-bottom border-4 border-warning bg-light-subtle">
                                    <div class="card-body p-4 text-center">
                                        <div class="text-muted small fw-bold mb-2 text-uppercase">{{ __('قيمة الأقساط المستقبلية') }}</div>
                                        <div class="fs-3 fw-bold text-dark">{{ number_format($financial['total_remaining']) }} <span class="fs-6 text-muted">ج.م</span></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div id="financialChart"></div>
                    </div>
                </div>
            </div>

            <!-- 2. تقرير تحليل خطط التقسيط والتمويل -->
            <div id="report-installments" class="report-section mb-5 bg-white p-4 rounded-4 shadow-sm">
                <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-3">
                    <h5 class="fw-bold mb-0 text-primary"><i class="bi bi-calculator me-2"></i> {{ __('2. تحليل خطط التقسيط المفضلة') }}</h5>
                    <button class="btn btn-sm btn-light border d-print-none print-btn-trigger" onclick="printReport('report-installments', 'تحليل خطط التقسيط والتمويل')"><i class="bi bi-printer"></i> طباعة A4</button>
                </div>
                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="card border-0 bg-light-subtle shadow-xs rounded-4 h-100">
                            <div class="card-body p-4 d-flex align-items-center gap-3">
                                <div class="avatar-md bg-white text-primary rounded-circle d-flex align-items-center justify-content-center shadow-xs" style="width:50px;height:50px;">
                                    <i class="bi bi-cash-stack fs-4"></i>
                                </div>
                                <div>
                                    <div class="text-muted small fw-bold mb-1">{{ __('متوسط الدفعة المقدمة') }}</div>
                                    <div class="fs-4 fw-bold text-dark">{{ number_format($installments['avg_down_payment']) }} <span class="fs-6 text-muted">ج.م</span></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card border-0 bg-light-subtle shadow-xs rounded-4 h-100">
                            <div class="card-body p-4 d-flex align-items-center gap-3">
                                <div class="avatar-md bg-white text-info rounded-circle d-flex align-items-center justify-content-center shadow-xs" style="width:50px;height:50px;">
                                    <i class="bi bi-calendar3 fs-4"></i>
                                </div>
                                <div>
                                    <div class="text-muted small fw-bold mb-1">{{ __('متوسط مدة التقسيط المفتوحة') }}</div>
                                    <div class="fs-4 fw-bold text-dark">{{ round($installments['avg_duration'], 1) }} <span class="fs-6 text-muted">{{ __('سنوات') }}</span></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card border-0 bg-light-subtle shadow-xs rounded-4 h-100">
                            <div class="card-body p-4 d-flex align-items-center gap-3">
                                <div class="avatar-md bg-white text-success rounded-circle d-flex align-items-center justify-content-center shadow-xs" style="width:50px;height:50px;">
                                    <i class="bi bi-calendar-event fs-4"></i>
                                </div>
                                <div>
                                    <div class="text-muted small fw-bold mb-1">{{ __('متوسط القسط الشهري') }}</div>
                                    <div class="fs-4 fw-bold text-dark">{{ number_format($installments['avg_monthly']) }} <span class="fs-6 text-muted">ج.م</span></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-4 mb-5">
                <!-- 3. تقرير أداء فريق المبيعات -->
                <div class="col-md-7">
                    <div id="report-employees" class="report-section bg-white p-4 rounded-4 shadow-sm h-100">
                        <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-3">
                            <h5 class="fw-bold mb-0 text-primary"><i class="bi bi-people me-2"></i> {{ __('3. أداء فريق المبيعات') }}</h5>
                            <button class="btn btn-sm btn-light border d-print-none print-btn-trigger" onclick="printReport('report-employees', 'أداء فريق المبيعات')"><i class="bi bi-printer"></i> طباعة A4</button>
                        </div>
                        <div id="employeesChart" class="mb-4"></div>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="px-3 py-2 text-muted fw-bold">{{ __('الموظف') }}</th>
                                        <th class="py-2 text-muted fw-bold text-center">{{ __('الحجوزات المسندة') }}</th>
                                        <th class="py-2 text-muted fw-bold text-center">{{ __('المبيعات المغلقة') }}</th>
                                        <th class="py-2 text-muted fw-bold text-center">{{ __('نسبة الإغلاق') }}</th>
                                    </tr>
                                </thead>
                                <tbody class="border-top-0">
                                    @forelse ($employees as $emp)
                                        @php $rate = $emp->total_bookings > 0 ? round(($emp->total_sold / $emp->total_bookings) * 100, 1) : 0; @endphp
                                        <tr>
                                            <td class="px-3 fw-bold text-dark">{{ $emp->employee->name ?? __('غير محدد') }}</td>
                                            <td class="text-center"><span class="badge bg-light text-dark border px-3 py-2 rounded-pill">{{ $emp->total_bookings }}</span></td>
                                            <td class="text-center"><span class="badge bg-success-subtle text-success px-3 py-2 rounded-pill">{{ $emp->total_sold }}</span></td>
                                            <td class="text-center">
                                                <div class="d-flex align-items-center justify-content-center gap-2">
                                                    <div class="progress flex-grow-1" style="height: 6px; max-width: 80px;">
                                                        <div class="progress-bar bg-{{ $rate > 50 ? 'success' : ($rate > 20 ? 'warning' : 'danger') }}" style="width: {{ $rate }}%"></div>
                                                    </div>
                                                    <span class="small fw-bold text-muted">{{ $rate }}%</span>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="4" class="text-center text-muted py-4">{{ __('لا توجد بيانات') }}</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- 4. تقرير السيارات الأكثر طلباً ومبيعاً -->
                <div class="col-md-5">
                    <div id="report-cars" class="report-section bg-white p-4 rounded-4 shadow-sm h-100">
                        <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-3">
                            <h5 class="fw-bold mb-0 text-primary"><i class="bi bi-car-front me-2"></i> {{ __('4. أكثر السيارات طلباً') }}</h5>
                            <button class="btn btn-sm btn-light border d-print-none print-btn-trigger" onclick="printReport('report-cars', 'أكثر السيارات طلباً ومبيعاً')"><i class="bi bi-printer"></i> طباعة A4</button>
                        </div>
                        <div id="carsChart" class="mb-4"></div>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="px-3 py-2 text-muted fw-bold">{{ __('السيارة') }}</th>
                                        <th class="py-2 text-muted fw-bold text-center">{{ __('الطلبات') }}</th>
                                        <th class="py-2 text-muted fw-bold text-center">{{ __('المبيعات') }}</th>
                                    </tr>
                                </thead>
                                <tbody class="border-top-0">
                                    @forelse ($topCars as $carStat)
                                        <tr>
                                            <td class="px-3">
                                                <div class="fw-bold text-dark">{{ $carStat->car->name ?? __('غير محدد') }}</div>
                                                <div class="small text-muted">{{ $carStat->car->brand->name ?? '' }}</div>
                                            </td>
                                            <td class="text-center fw-bold text-primary">{{ $carStat->total_bookings }}</td>
                                            <td class="text-center fw-bold text-success">{{ $carStat->total_sold }}</td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="3" class="text-center text-muted py-4">{{ __('لا توجد بيانات') }}</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 5. تقرير مصادر العملاء ومعدل الخسارة -->
            <div id="report-sources" class="report-section mb-4 bg-white p-4 rounded-4 shadow-sm">
                <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-3">
                    <h5 class="fw-bold mb-0 text-primary"><i class="bi bi-funnel me-2"></i> {{ __('5. مصادر العملاء ومسار المبيعات') }}</h5>
                    <button class="btn btn-sm btn-light border d-print-none print-btn-trigger" onclick="printReport('report-sources', 'مصادر العملاء ومسار المبيعات')"><i class="bi bi-printer"></i> طباعة A4</button>
                </div>
                
                <div class="row">
                    <div class="col-md-12 mb-4">
                        <div id="sourcesChart"></div>
                    </div>
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="px-4 py-3 text-muted fw-bold">{{ __('مصدر العميل (Source)') }}</th>
                                        <th class="py-3 text-muted fw-bold text-center">{{ __('إجمالي الحجوزات') }}</th>
                                        <th class="py-3 text-muted fw-bold text-center">{{ __('الطلبات المرفوضة') }}</th>
                                        <th class="py-3 text-muted fw-bold text-center">{{ __('مبيعات ناجحة') }}</th>
                                        <th class="py-3 text-muted fw-bold text-center">{{ __('نسبة النجاح') }}</th>
                                    </tr>
                                </thead>
                                <tbody class="border-top-0">
                                    @forelse ($sourcesReport as $src)
                                        @php $successRate = $src->total_bookings > 0 ? round(($src->total_sold / $src->total_bookings) * 100, 1) : 0; @endphp
                                        <tr>
                                            <td class="px-4 fw-bold text-dark">{{ $src->source }}</td>
                                            <td class="text-center fw-bold text-primary">{{ $src->total_bookings }}</td>
                                            <td class="text-center fw-bold text-danger">{{ $src->total_rejected }}</td>
                                            <td class="text-center fw-bold text-success">{{ $src->total_sold }}</td>
                                            <td class="text-center">
                                                <span class="badge bg-{{ $successRate > 50 ? 'success' : 'secondary' }}-subtle text-{{ $successRate > 50 ? 'success' : 'secondary' }} px-3 py-2 rounded-pill small">
                                                    {{ $successRate }}%
                                                </span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="5" class="text-center text-muted py-4">{{ __('لا توجد بيانات') }}</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    </div>

    {{-- Print-Only Footer --}}
    <div class="d-none d-print-block print-footer">
        <div class="d-flex justify-content-between align-items-center w-100 px-4">
            <div class="small text-muted">
                @if(isset($settings['footer_text']))
                    {{ is_array($settings['footer_text']) ? ($settings['footer_text'][app()->getLocale()] ?? $settings['footer_text']['ar'] ?? array_values($settings['footer_text'])[0] ?? '') : $settings['footer_text'] }}
                @else
                    {{ __('جميع الحقوق محفوظة © AutoCRM') }}
                @endif
            </div>
            <div class="small text-muted fw-bold">
                @if(isset($settings['site_name']))
                    {{ is_array($settings['site_name']) ? ($settings['site_name'][app()->getLocale()] ?? $settings['site_name']['ar'] ?? array_values($settings['site_name'])[0] ?? 'AutoCRM') : $settings['site_name'] }}
                @else
                    AutoCRM
                @endif
                 - {{ __('نظام إدارة علاقات العملاء') }}
            </div>
        </div>
    </div>

    <style>
        /* Override primary colors with CRM Red */
        .text-primary { color: var(--crm-red) !important; }
        .btn-primary { background-color: var(--crm-red) !important; border-color: var(--crm-red) !important; color: #fff !important; }
        .btn-primary:hover { background-color: #c40510 !important; border-color: #c40510 !important; }
        .border-primary { border-color: var(--crm-red) !important; }
        .bg-primary { background-color: var(--crm-red) !important; }
        
        .shadow-xs { box-shadow: 0 1px 2px rgba(0,0,0,0.05); }
        .fw-black { font-weight: 900; }
        
        @media print {
            @page { 
                size: A4 portrait; 
                margin: 25mm 20mm 25mm 20mm; 
            }

            /* Prevent cutting on the edges */
            * {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            .print-footer {
                position: fixed;
                bottom: 0;
                left: 0;
                right: 0;
                background: #fff !important;
                padding: 10px 0;
                border-top: 1px solid #eee !important;
                z-index: 9999;
            }

            /* Adjust body padding for footer */
            body { 
                padding-bottom: 50px !important; 
            }

            /* Hard reset for all possible containers */
            html, body, .crm-shell, .crm-main, .crm-content, .container-fluid, #all-reports-container {
                margin: 0 !important;
                padding: 0 !important;
                width: 100% !important;
                max-width: 100% !important;
                min-width: 100% !important;
                background: #fff !important;
                overflow: visible !important;
            }

            /* Hide everything that is not the report */
            .crm-sidebar, .crm-topbar, .crm-mob-overlay, .crm-mob-toggle, .d-print-none, .print-btn-trigger, .crm-breadcrumb {
                display: none !important;
            }

            /* Ensure content is not cut and breaks properly */
            .card, .report-section {
                border: 1px solid #eee !important;
                border-radius: 16px !important;
                padding: 30px !important;
                margin-bottom: 40px !important;
                page-break-inside: avoid !important;
                break-inside: avoid !important;
                display: block !important;
                width: 100% !important;
                background: #fff !important;
            }

            /* Header adjustments to prevent cutting */
            .d-print-block { 
                display: block !important; 
                width: 100% !important;
                margin-bottom: 30px !important;
            }
            
            /* Specific section printing logic */
            body.print-single-section .report-section { display: none !important; }
            body.print-single-section .report-section.print-this { display: block !important; }

            /* Grid fixes - Force side-by-side columns in print */
            .row { 
                display: flex !important; 
                flex-wrap: wrap !important; 
                margin-right: -10px !important; 
                margin-left: -10px !important; 
                flex-direction: row !important;
            }
            .row > [class*="col-"] {
                padding-right: 10px !important;
                padding-left: 10px !important;
                flex-shrink: 0 !important;
            }
            
            .col-md-1, .col-1 { width: 8.3333% !important; }
            .col-md-2, .col-2 { width: 16.6666% !important; }
            .col-md-3, .col-3 { width: 25% !important; }
            .col-md-4, .col-4 { width: 33.3333% !important; }
            .col-md-5, .col-5 { width: 41.6666% !important; }
            .col-md-6, .col-6 { width: 50% !important; }
            .col-md-7, .col-7 { width: 58.3333% !important; }
            .col-md-8, .col-8 { width: 66.6666% !important; }
            .col-md-9, .col-9 { width: 75% !important; }
            .col-md-10, .col-10 { width: 83.3333% !important; }
            .col-md-11, .col-11 { width: 91.6666% !important; }
            .col-md-12, .col-12 { width: 100% !important; }

            /* Fix nested grids specifically for the stats cards */
            .col-md-8 .row .col-md-6 {
                width: 50% !important;
                margin-bottom: 15px !important;
            }

            /* Small adjustments for very narrow sections */
            @media (max-width: 1000px) {
                .col-md-4, .col-md-5, .col-md-6, .col-md-7, .col-md-8 { width: 100% !important; }
            }

            /* Typography & UI */
            body { 
                font-family: 'Cairo', sans-serif !important; 
                color: #000 !important; 
                font-size: 13px !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
            .text-primary { color: var(--crm-red) !important; }
            .bg-light-subtle { background-color: #f5f6f8 !important; }
            
            /* Table formatting */
            .table { width: 100% !important; border-collapse: collapse !important; }
            .table th { background-color: #f1f1f1 !important; color: #000 !important; border: 1px solid #ddd !important; }
            .table td { border: 1px solid #eee !important; }
            
            /* ApexCharts adjustments */
            .apexcharts-canvas { 
                max-width: 100% !important; 
                margin: 20px auto !important;
            }
            .apexcharts-legend { 
                position: relative !important; 
                top: 10px !important; 
                padding: 10px 0 !important;
            }
        }
    </style>
@endsection

@section('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        
        const isRtl = document.dir === 'rtl';

        // 1. Financial Chart (Pie: Sold vs Not Sold)
        const totalSold = {{ $financial['total_sold'] ?? 0 }};
        const totalNotSold = {{ ($financial['total_bookings'] ?? 0) - ($financial['total_sold'] ?? 0) }};
        
        window.financialChart = new ApexCharts(document.querySelector("#financialChart"), {
            series: [totalSold, totalNotSold],
            labels: ['المبيعات الناجحة', 'الحجوزات المعلقة أو المرفوضة'],
            chart: { type: 'donut', height: 250, fontFamily: isRtl ? 'Cairo' : 'Inter', animations: { enabled: false } },
            colors: ['#12B76A', '#8E92A4'],
            legend: { position: 'bottom' },
            plotOptions: { pie: { donut: { size: '70%' } } }
        });
        window.financialChart.render();

        // 2. Employees Performance Chart (Bar)
        const employeeNames = {!! json_encode($employees->map(function($e){ return $e->employee->name ?? 'غير محدد'; })->toArray()) !!};
        const employeeBookings = {!! json_encode($employees->pluck('total_bookings')->toArray()) !!};
        const employeeSold = {!! json_encode($employees->pluck('total_sold')->toArray()) !!};

        window.employeesChart = new ApexCharts(document.querySelector("#employeesChart"), {
            series: [
                { name: 'إجمالي الحجوزات', data: employeeBookings },
                { name: 'مبيعات مغلقة', data: employeeSold }
            ],
            chart: { type: 'bar', height: 280, fontFamily: isRtl ? 'Cairo' : 'Inter', toolbar: { show: false }, animations: { enabled: false } },
            colors: ['#2E90FA', '#12B76A'],
            plotOptions: { bar: { borderRadius: 4, horizontal: false, columnWidth: '50%' } },
            dataLabels: { enabled: false },
            stroke: { show: true, width: 2, colors: ['transparent'] },
            xaxis: { categories: employeeNames },
            fill: { opacity: 1 }
        });
        window.employeesChart.render();

        // 3. Top Cars Chart (Donut)
        const carNames = {!! json_encode($topCars->map(function($c){ return $c->car->name ?? 'غير محدد'; })->toArray()) !!};
        const carBookings = {!! json_encode($topCars->pluck('total_bookings')->toArray()) !!};

        window.carsChart = new ApexCharts(document.querySelector("#carsChart"), {
            series: carBookings.length ? carBookings : [0],
            labels: carNames.length ? carNames : ['لا توجد سيارات'],
            chart: { type: 'pie', height: 280, fontFamily: isRtl ? 'Cairo' : 'Inter', animations: { enabled: false } },
            legend: { position: 'bottom' },
        });
        window.carsChart.render();

        // 4. Sources Chart (Bar)
        const sourceNames = {!! json_encode($sourcesReport->pluck('source')->toArray()) !!};
        const sourceBookings = {!! json_encode($sourcesReport->pluck('total_bookings')->toArray()) !!};
        const sourceSold = {!! json_encode($sourcesReport->pluck('total_sold')->toArray()) !!};
        const sourceRejected = {!! json_encode($sourcesReport->pluck('total_rejected')->toArray()) !!};

        window.sourcesChart = new ApexCharts(document.querySelector("#sourcesChart"), {
            series: [
                { name: 'حجوزات', data: sourceBookings },
                { name: 'مبيعات ناجحة', data: sourceSold },
                { name: 'طلبات مرفوضة', data: sourceRejected }
            ],
            chart: { type: 'bar', height: 300, stacked: false, fontFamily: isRtl ? 'Cairo' : 'Inter', toolbar: { show: false }, animations: { enabled: false } },
            colors: ['#2E90FA', '#12B76A', '#E30613'],
            plotOptions: { bar: { borderRadius: 3, columnWidth: '60%' } },
            xaxis: { categories: sourceNames },
            dataLabels: { enabled: false }
        });
        window.sourcesChart.render();
    });

    // دالة طباعة تقرير مخصص
    function printReport(sectionId, title) {
        document.getElementById('current-print-title').innerText = title;
        
        // إضافة كلاسات للطباعة المخصصة
        document.body.classList.add('print-single-section');
        const section = document.getElementById(sectionId);
        section.classList.add('print-this');

        window.print();

        // إزالة الكلاسات بعد الطباعة
        window.setTimeout(() => {
            document.body.classList.remove('print-single-section');
            section.classList.remove('print-this');
        }, 500);
    }

    // دالة لطباعة كامل التقرير
    function printAllReports() {
        document.getElementById('current-print-title').innerText = "{{ __('تقرير الأداء والمبيعات الشامل') }}";
        window.print();
    }
</script>
@endsection
