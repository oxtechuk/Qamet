@extends('partials.Layouts.crm-master')
@section('title', __('العملاء') . ' | GR Motors')

@section('content')
<div class="container-fluid" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">

    {{-- Breadcrumb --}}
    <nav class="crm-breadcrumb">
        <a href="{{ route('crm.dashboard') }}">{{ __('الرئيسية') }}</a>
        <span class="sep">›</span>
        <span>{{ __('إدارة العملاء') }}</span>
        <span class="sep">›</span>
        <span class="current">{{ __('العملاء') }}</span>
    </nav>

    {{-- Header --}}
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h5 class="fw-bold mb-0">{{ __('العملاء') }}</h5>
        @can('manage-leads')
        <a href="{{ route('crm.leads.create') }}" class="btn-crm-primary">
            <i class="bi bi-person-plus"></i> {{ __('إضافة عميل') }}
        </a>
        @endcan
    </div>

    {{-- Stat Cards --}}
    <div class="row g-3 mb-4">
        <div class="col-6 col-xl-4">
            <div class="crm-stat-new">
                <span class="stat-badge orange">65%</span>
                <div class="stat-icon green"><i class="bi bi-person-check"></i></div>
                <div class="stat-lbl">{{ __('العملاء النشطون') }}</div>
                <div class="stat-val">76%</div>
            </div>
        </div>
        <div class="col-6 col-xl-4">
            <div class="crm-stat-new">
                <span class="stat-badge green">+3%</span>
                <div class="stat-icon blue"><i class="bi bi-people"></i></div>
                <div class="stat-lbl">{{ __('العملاء الجدد') }}</div>
                <div class="stat-val">{{ number_format($leads->total()) }}</div>
            </div>
        </div>
        <div class="col-6 col-xl-4">
            <div class="crm-stat-new">
                <span class="stat-badge green">+12%</span>
                <div class="stat-icon purple"><i class="bi bi-person-lines-fill"></i></div>
                <div class="stat-lbl">{{ __('عدد العملاء') }}</div>
                <div class="stat-val">{{ number_format($leads->total()) }}</div>
            </div>
        </div>
    </div>

    {{-- Filter Tabs + Search --}}
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-3">
        <div class="crm-filter-tabs mb-0">
            <a href="{{ route('crm.leads.index') }}"
               class="crm-filter-tab {{ !request('status') ? 'active' : '' }}">{{ __('الكل') }}</a>
            @foreach($statuses as $key => $s)
            <a href="{{ route('crm.leads.index', ['status' => $key]) }}"
               class="crm-filter-tab {{ request('status') === $key ? 'active' : '' }}">{{ $s['label'] }}</a>
            @endforeach
        </div>
        <form method="GET" class="d-flex gap-2 align-items-center">
            <div style="position:relative;">
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="{{ __('بحث ببيانات العميل') }}"
                    style="border:1px solid var(--crm-border);border-radius:8px;padding:8px 36px 8px 14px;font-size:13px;outline:none;font-family:'Cairo',sans-serif;width:220px;">
                <i class="bi bi-search" style="position:absolute;{{ app()->getLocale()=='ar'?'left':'right' }}:12px;top:50%;transform:translateY(-50%);color:var(--crm-text-muted);"></i>
            </div>
            <button type="submit" class="btn-crm-primary" style="padding:8px 16px;">{{ __('بحث') }}</button>
        </form>
    </div>

   

    {{-- Table --}}
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden" style="border:1px solid var(--crm-border)!important;">
        <div class="card-header bg-white border-0 px-4 py-3" style="border-bottom:1px solid var(--crm-border)!important;">
            <h6 class="fw-bold mb-0">{{ __('العملاء') }}</h6>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead style="background:#F8F9FC;">
                    <tr>
                        <th class="px-4 py-3 text-muted fw-bold" style="font-size:12px;">{{ __('رقم العميل') }}</th>
                        <th class="py-3 text-muted fw-bold" style="font-size:12px;">{{ __('اسم العميل') }}</th>
                        <th class="py-3 text-muted fw-bold" style="font-size:12px;">{{ __('الهاتف') }}</th>
                        <th class="py-3 text-muted fw-bold text-center" style="font-size:12px;">{{ __('عدد الطلبات') }}</th>
                        <th class="py-3 text-muted fw-bold" style="font-size:12px;">{{ __('نوع السيارات') }}</th>
                        <th class="py-3 text-muted fw-bold" style="font-size:12px;">{{ __('فئة الديون') }}</th>
                        <th class="py-3 text-muted fw-bold" style="font-size:12px;">{{ __('ميعاد طلب') }}</th>
                        <th class="py-3 text-muted fw-bold" style="font-size:12px;">{{ __('الحالة') }}</th>
                        <th class="py-3 text-muted fw-bold" style="font-size:12px;">{{ __('الإجراءات') }}</th>
                    </tr>
                </thead>
                <tbody class="border-top-0">
                    @forelse($leads as $lead)
                    <tr>
                        <td class="px-4 fw-bold" style="font-size:13px;">#{{ $lead->id }}</td>
                        <td>
                            <div class="fw-bold" style="font-size:13px;color:var(--crm-text);">{{ $lead->client_name }}</div>
                        </td>
                        <td style="font-size:13px;" dir="ltr">{{ $lead->client_phone ?? '—' }}</td>
                        <td class="text-center fw-bold" style="font-size:13px;">1</td>
                        <td style="font-size:12px;color:var(--crm-text-muted);">
                            {{ $lead->car?->name ?? '—' }}
                            @if($lead->car)
                            <br><small>{{ $lead->car->brand?->name }}</small>
                            @endif
                        </td>
                        <td>
                            <span class="status-dot planned">{{ __('اقتصادية') }}</span>
                        </td>
                        <td style="font-size:12px;color:var(--crm-text-muted);">
                            {{ $lead->started_at?->format('d/m/Y') ?? '—' }}
                        </td>
                        <td>
                            @php
                                $dotClass = match($lead->status) {
                                    'new'         => 'confirmed',
                                    'in_progress' => 'planned',
                                    'waiting'     => 'waiting',
                                    'sold'        => 'done',
                                    'rejected'    => 'late',
                                    default       => 'cancelled',
                                };
                            @endphp
                            <span class="status-dot {{ $dotClass }}">{{ $lead->status_label }}</span>
                        </td>
                        <td>
                            <div class="d-flex gap-2 align-items-center">
                                <a href="{{ route('crm.leads.show', $lead) }}" class="btn btn-sm btn-light rounded-2" title="{{ __('عرض') }}">
                                    <i class="bi bi-eye" style="font-size:14px;"></i>
                                </a>
                                @can('manage-leads')
                                <a href="{{ route('crm.leads.edit', $lead) }}" class="btn btn-sm btn-light rounded-2" title="{{ __('تعديل') }}">
                                    <i class="bi bi-pencil" style="font-size:14px;"></i>
                                </a>
                                @endcan
                                @can('manage-leads')
                                <form action="{{ route('crm.leads.destroy', $lead) }}" method="POST"
                                      onsubmit="return confirm('{{ __('هل أنت متأكد؟') }}')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-light rounded-2" title="{{ __('حذف') }}"
                                            style="color:var(--crm-red);">
                                        <i class="bi bi-trash" style="font-size:14px;"></i>
                                    </button>
                                </form>
                                @endcan
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center text-muted py-5">
                            <i class="bi bi-person-x fs-1 d-block mb-2 opacity-25"></i>
                            {{ __('لا يوجد عملاء حالياً') }}
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($leads->hasPages())
        <div class="card-footer bg-white border-0 py-3" style="border-top:1px solid var(--crm-border)!important;">
            {{ $leads->links() }}
        </div>
        @endif
    </div>

</div>
@endsection
