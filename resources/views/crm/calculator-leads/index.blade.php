@extends('partials.Layouts.crm-master')
@section('title', __('مستخدمي الحاسبة') . ' | AutoCRM')

@section('content')
    <div class="container-fluid" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">

        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
            <div>
                <h4 class="mb-1 fw-bold">{{ __('سجلات استخدام الحاسبة') }}</h4>
                <p class="text-muted mb-0">{{ __('إجمالي') }} {{ $leads->total() }} {{ __('سجل استخدام') }}</p>
            </div>
        </div>

        <div class="card border-0 shadow-sm mb-4 rounded-4">
            <div class="card-body p-4">
                <form method="GET" class="row g-3 align-items-end">
                    <div class="col-md-4">
                        <label class="form-label fw-bold">{{ __('بحث بالاسم أو الجوال') }}</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0"><i class="bi bi-search"></i></span>
                            <input type="text" name="search" class="form-control bg-light border-0 shadow-none" value="{{ request('search') }}"
                                placeholder="{{ __('الاسم أو الجوال...') }}">
                        </div>
                    </div>
                    <div class="col-md-3 d-flex gap-2">
                        <button type="submit" class="btn btn-primary px-4 rounded-3 w-100 fw-bold">{{ __('تصفية') }}</button>
                        <a href="{{ route('crm.calculator-leads.index') }}" class="btn btn-light px-3 rounded-3"><i class="bi bi-arrow-counterclockwise"></i></a>
                    </div>
                </form>
            </div>
        </div>

        

        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="px-4 py-3 text-muted fw-bold">#</th>
                            <th class="py-3 text-muted fw-bold">{{ __('الاسم') }}</th>
                            <th class="py-3 text-muted fw-bold">{{ __('الجوال') }}</th>
                            <th class="py-3 text-muted fw-bold">{{ __('السيارة المهتم بها') }}</th>
                            <th class="py-3 text-muted fw-bold">{{ __('تاريخ الاستخدام') }}</th>
                            <th class="py-3"></th>
                        </tr>
                    </thead>
                    <tbody class="border-top-0">
                        @forelse ($leads as $lead)
                            <tr>
                                <td class="px-4 text-muted small">{{ $lead->id }}</td>
                                <td class="fw-bold text-dark">{{ $lead->name }}</td>
                                <td class="text-muted"><i class="bi bi-telephone me-1 small"></i> {{ $lead->phone }}</td>
                                <td>
                                    @if ($lead->car)
                                        <div class="text-primary fw-bold small">{{ $lead->car->name }}</div>
                                    @else
                                        <span class="text-muted small">—</span>
                                    @endif
                                </td>
                                <td class="text-muted small">{{ $lead->created_at->format('Y-m-d H:i') }}</td>
                                <td>
                                    <div class="d-flex gap-2 justify-content-end px-3">
                                        @can('manage-calculator-leads')
                                        <form action="{{ route('crm.calculator-leads.destroy', $lead) }}" method="POST" onsubmit="return confirm('{{ __('هل أنت متأكد من حذف هذا السجل؟') }}')">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-sm btn-danger-subtle text-danger rounded-2" title="{{ __('حذف') }}"><i class="bi bi-trash"></i></button>
                                        </form>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-5">
                                    <div class="py-4">
                                        <i class="bi bi-calculator fs-1 d-block mb-3 opacity-25"></i>
                                        <h6 class="fw-bold">{{ __('لا يوجد سجلات حالياً') }}</h6>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($leads->hasPages())
                <div class="card-footer bg-white py-3 border-0">
                    {{ $leads->links() }}
                </div>
            @endif
        </div>
    </div>

    <style>
        .btn-danger-subtle { background: #ffebee; }
    </style>
@endsection
