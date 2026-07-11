@extends('partials.Layouts.crm-master')
@section('title', __('تقرير مصادر التواصل') . ' | AutoCRM')

@section('content')
    <div class="container-fluid" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">

        <div class="mb-4">
            <h4 class="mb-1 fw-bold">{{ __('تقرير مصادر التواصل') }}</h4>
            <p class="text-muted mb-0 small">{{ __('تحليل توزيع العملاء المحتملين وطلبات الموقع حسب مصدر الوصول') }}</p>
        </div>

        <div class="row g-4 mb-5">
            <div class="col-md-6">
                <div class="card border-0 shadow-sm rounded-4 bg-primary text-white">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="opacity-75 small fw-bold text-uppercase mb-1">{{ __('إجمالي العملاء المحتملين') }}</div>
                                <div class="fs-1 fw-black">{{ $leadsTotal }}</div>
                            </div>
                            <i class="bi bi-people fs-1 opacity-25"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card border-0 shadow-sm rounded-4 bg-dark text-white">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="opacity-75 small fw-bold text-uppercase mb-1">{{ __('إجمالي طلبات التقسيط (الموقع)') }}</div>
                                <div class="fs-1 fw-black">{{ $bookingsTotal }}</div>
                            </div>
                            <i class="bi bi-laptop fs-1 opacity-25"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            {{-- Leads by Source --}}
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm h-100 rounded-4 overflow-hidden">
                    <div class="card-header bg-transparent border-0 pt-4 px-4">
                        <h6 class="mb-0 fw-bold"><i class="bi bi-person-lines-fill me-2 text-primary"></i> {{ __('عملاء محتملون — حسب مصدر التواصل') }}</h6>
                    </div>
                    <div class="card-body p-4">
                        @php $maxL = max($leadBySource->max() ?: 0, 1); @endphp
                        @forelse ($contactSources as $src)
                            @php $n = $leadBySource[$src->id] ?? 0; @endphp
                            <div class="mb-4">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="fw-bold text-dark fs-14">{{ $src->name }}</span>
                                    <span class="badge bg-primary-subtle text-primary rounded-pill px-3">{{ $n }}</span>
                                </div>
                                <div class="progress rounded-pill shadow-xs" style="height:10px;">
                                    <div class="progress-bar bg-primary progress-bar-striped progress-bar-animated" role="progressbar" style="width: {{ min(100, ($n / $maxL) * 100) }}%"></div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-5 opacity-50">
                                <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                {{ __('لا توجد مصادر مسجلة') }}
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            {{-- Bookings by Source Field --}}
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm h-100 rounded-4 overflow-hidden">
                    <div class="card-header bg-transparent border-0 pt-4 px-4">
                        <h6 class="mb-0 fw-bold"><i class="bi bi-graph-up-arrow me-2 text-success"></i> {{ __('طلبات التقسيط — حسب حقل المصدر') }}</h6>
                    </div>
                    <div class="card-body p-4">
                        @php $maxB = max($bookingBySource->max() ?: 0, 1); @endphp
                        @forelse ($bookingBySource as $label => $n)
                            <div class="mb-4">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="fw-bold text-dark fs-14 text-capitalize">{{ $label }}</span>
                                    <span class="badge bg-success-subtle text-success rounded-pill px-3">{{ $n }}</span>
                                </div>
                                <div class="progress rounded-pill shadow-xs" style="height:10px;">
                                    <div class="progress-bar bg-success progress-bar-striped progress-bar-animated" role="progressbar" style="width: {{ min(100, ($n / $maxB) * 100) }}%"></div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-5 opacity-50">
                                <i class="bi bi-journal-x fs-1 d-block mb-2"></i>
                                {{ __('لا توجد بيانات متاحة حالياً') }}
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .fw-black { font-weight: 900; }
        .fs-14 { font-size: 14px; }
        .shadow-xs { box-shadow: 0 1px 2px rgba(0,0,0,0.05); }
        .bg-primary-subtle { background: #e7f1ff; }
        .bg-success-subtle { background: #e1f7e3; }
    </style>
@endsection
