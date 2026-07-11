@extends('partials.Layouts.crm-master')
@section('title', __('التقرير الشهري') . ' | AutoCRM')

@section('content')
    <div class="container-fluid" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">

        <div class="mb-4">
            <h4 class="mb-1 fw-bold">{{ __('التقرير الشهري للنشاط') }}</h4>
            <p class="text-muted mb-0 small">{{ __('آخر 12 شهر — مقارنة بين طلبات التقسيط والعملاء المحتملين') }}</p>
        </div>

        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="px-4 py-3 text-muted fw-bold">{{ __('الشهر / السنة') }}</th>
                            <th class="py-3 text-muted fw-bold text-center">{{ __('طلبات التقسيط') }}</th>
                            <th class="py-3 text-muted fw-bold text-center">{{ __('عملاء محتملون') }}</th>
                            <th class="py-3 text-muted fw-bold" style="min-width:250px">{{ __('توزيع نسبي') }}</th>
                        </tr>
                    </thead>
                    <tbody class="border-top-0">
                        @php
                            $maxBar = 1;
                            foreach ($months as $m) {
                                $maxBar = max($maxBar, $m['bookings'], $m['leads']);
                            }
                        @endphp
                        @foreach ($months as $key => $row)
                            <tr>
                                <td class="px-4 fw-bold text-dark">{{ $row['label'] }}</td>
                                <td class="text-center">
                                    <span class="badge bg-primary-subtle text-primary rounded-pill px-3">{{ $row['bookings'] }}</span>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-info-subtle text-info rounded-pill px-3">{{ $row['leads'] }}</span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="flex-grow-1">
                                            <div class="d-flex gap-1 align-items-end" style="height:35px;">
                                                <div class="bg-primary rounded-top shadow-xs" 
                                                     style="width:14px; height: {{ max(10, ($row['bookings'] / $maxBar) * 100) }}%;" 
                                                     data-bs-toggle="tooltip" title="{{ __('طلبات') }}: {{ $row['bookings'] }}"></div>
                                                <div class="bg-info rounded-top shadow-xs" 
                                                     style="width:14px; height: {{ max(10, ($row['leads'] / $maxBar) * 100) }}%;" 
                                                     data-bs-toggle="tooltip" title="{{ __('عملاء') }}: {{ $row['leads'] }}"></div>
                                            </div>
                                        </div>
                                        <div class="small text-muted opacity-50">{{ $row['bookings'] + $row['leads'] }}</div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        
        <div class="mt-4 d-flex gap-4">
            <div class="d-flex align-items-center gap-2">
                <div class="bg-primary rounded-circle" style="width:12px;height:12px;"></div>
                <span class="small text-muted">{{ __('طلبات التقسيط') }}</span>
            </div>
            <div class="d-flex align-items-center gap-2">
                <div class="bg-info rounded-circle" style="width:12px;height:12px;"></div>
                <span class="small text-muted">{{ __('عملاء محتملون') }}</span>
            </div>
        </div>
    </div>

    <style>
        .bg-primary-subtle { background: #e7f1ff; }
        .bg-info-subtle { background: #e0f7fa; }
        .shadow-xs { box-shadow: 0 1px 2px rgba(0,0,0,0.1); }
    </style>
    
    <script>
        // Enable tooltips
        document.addEventListener('DOMContentLoaded', function () {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            })
        });
    </script>
@endsection
