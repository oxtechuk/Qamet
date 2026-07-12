@extends('partials.Layouts.crm-master')
@section('title', __('المشتركون في النشرة الإخبارية') . ' | AutoCRM')

@section('content')
<div class="container-fluid" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">

    {{-- Header --}}
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
        <div>
            <h4 class="mb-1 fw-bold">
                <i class="bi bi-envelope-heart-fill text-danger me-2"></i>
                {{ __('المشتركون في النشرة الإخبارية') }}
            </h4>
            <p class="text-muted mb-0">{{ __('إدارة بريد المشتركين وتصدير القوائم البريدية') }}</p>
        </div>
        @can('manage-newsletter')
        <a href="{{ route('crm.newsletter.export') }}"
           class="btn btn-success fw-bold px-4 rounded-3">
            <i class="bi bi-file-earmark-spreadsheet-fill me-2"></i>
            {{ __('تصدير CSV') }}
        </a>
        @endcan
    </div>

 

    {{-- Stats Cards --}}
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-4 text-center">
                    <div class="stat-icon bg-primary bg-opacity-10 text-primary rounded-3 mb-3 mx-auto">
                        <i class="bi bi-people-fill fs-4"></i>
                    </div>
                    <h3 class="fw-black mb-0">{{ number_format($stats['total']) }}</h3>
                    <p class="text-muted small mb-0">{{ __('إجمالي المشتركين') }}</p>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-4 text-center">
                    <div class="stat-icon bg-success bg-opacity-10 text-success rounded-3 mb-3 mx-auto">
                        <i class="bi bi-person-check-fill fs-4"></i>
                    </div>
                    <h3 class="fw-black mb-0">{{ number_format($stats['active']) }}</h3>
                    <p class="text-muted small mb-0">{{ __('مشتركون فعّالون') }}</p>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-4 text-center">
                    <div class="stat-icon bg-warning bg-opacity-10 text-warning rounded-3 mb-3 mx-auto">
                        <i class="bi bi-calendar-plus-fill fs-4"></i>
                    </div>
                    <h3 class="fw-black mb-0">{{ number_format($stats['this_month']) }}</h3>
                    <p class="text-muted small mb-0">{{ __('هذا الشهر') }}</p>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-4 text-center">
                    <div class="stat-icon bg-danger bg-opacity-10 text-danger rounded-3 mb-3 mx-auto">
                        <i class="bi bi-person-x-fill fs-4"></i>
                    </div>
                    <h3 class="fw-black mb-0">{{ number_format($stats['inactive']) }}</h3>
                    <p class="text-muted small mb-0">{{ __('غير فعّالين') }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Filters --}}
    <div class="card border-0 shadow-sm mb-4 rounded-4">
        <div class="card-body p-4">
            <form method="GET" class="row g-3 align-items-end">
                <div class="col-md-5">
                    <label class="form-label fw-bold">{{ __('بحث بالبريد الإلكتروني') }}</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-0"><i class="bi bi-search"></i></span>
                        <input type="text" name="search" class="form-control bg-light border-0 shadow-none"
                               value="{{ request('search') }}"
                               placeholder="{{ __('example@email.com') }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold">{{ __('الحالة') }}</label>
                    <select name="status" class="form-select bg-light border-0 shadow-none">
                        <option value="">{{ __('الكل') }}</option>
                        <option value="active"   {{ request('status') === 'active'   ? 'selected' : '' }}>{{ __('فعّال') }}</option>
                        <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>{{ __('غير فعّال') }}</option>
                    </select>
                </div>
                <div class="col-md-3 d-flex gap-2">
                    <button type="submit" class="btn btn-primary px-4 rounded-3 w-100 fw-bold">
                        <i class="bi bi-filter me-1"></i> {{ __('تصفية') }}
                    </button>
                    <a href="{{ route('crm.newsletter.index') }}" class="btn btn-light px-3 rounded-3">
                        <i class="bi bi-arrow-counterclockwise"></i>
                    </a>
                </div>
            </form>
        </div>
    </div>

    {{-- Table --}}
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="px-4 py-3 text-muted fw-bold">#</th>
                        <th class="py-3 text-muted fw-bold">{{ __('البريد الإلكتروني') }}</th>
                        <th class="py-3 text-muted fw-bold">{{ __('تاريخ الاشتراك') }}</th>
                        <th class="py-3 text-muted fw-bold">{{ __('عنوان IP') }}</th>
                        <th class="py-3 text-muted fw-bold text-center">{{ __('الحالة') }}</th>
                        <th class="py-3"></th>
                    </tr>
                </thead>
                <tbody class="border-top-0">
                    @forelse ($subscribers as $sub)
                        <tr>
                            <td class="px-4 text-muted small">{{ $sub->id }}</td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="subscriber-avatar">
                                        {{ strtoupper(substr($sub->email, 0, 1)) }}
                                    </div>
                                    <span class="fw-bold text-dark">{{ $sub->email }}</span>
                                </div>
                            </td>
                            <td class="text-muted small">
                                <i class="bi bi-calendar3 me-1"></i>
                                {{ $sub->subscribed_at?->format('Y-m-d') ?? $sub->created_at->format('Y-m-d') }}
                                <br>
                                <span class="text-muted" style="font-size:11px;">
                                    {{ $sub->subscribed_at?->diffForHumans() ?? $sub->created_at->diffForHumans() }}
                                </span>
                            </td>
                            <td class="text-muted small">
                                <i class="bi bi-globe me-1"></i>
                                {{ $sub->ip_address ?? '—' }}
                            </td>
                            <td class="text-center">
                                @if($sub->is_active)
                                    <span class="badge bg-success-subtle text-success rounded-pill px-3 py-2 fw-bold">
                                        <i class="bi bi-check-circle-fill me-1"></i>{{ __('فعّال') }}
                                    </span>
                                @else
                                    <span class="badge bg-danger-subtle text-danger rounded-pill px-3 py-2 fw-bold">
                                        <i class="bi bi-x-circle-fill me-1"></i>{{ __('غير فعّال') }}
                                    </span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex gap-2 justify-content-end px-3">
                                    @can('manage-newsletter')
                                    {{-- تفعيل / تعطيل --}}
                                    <form action="{{ route('crm.newsletter.toggle', $sub) }}" method="POST">
                                        @csrf @method('PATCH')
                                        <button class="btn btn-sm rounded-2 fw-bold
                                            {{ $sub->is_active ? 'btn-warning-subtle text-warning' : 'btn-success-subtle text-success' }}"
                                            title="{{ $sub->is_active ? __('تعطيل') : __('تفعيل') }}">
                                            <i class="bi {{ $sub->is_active ? 'bi-pause-fill' : 'bi-play-fill' }}"></i>
                                        </button>
                                    </form>
                                    @endcan
                                    @can('manage-newsletter')
                                    {{-- حذف --}}
                                    <form action="{{ route('crm.newsletter.destroy', $sub) }}" method="POST"
                                          onsubmit="return confirm('{{ __('هل أنت متأكد من حذف هذا المشترك؟') }}')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-danger-subtle text-danger rounded-2"
                                                title="{{ __('حذف') }}">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-5">
                                <div class="py-4">
                                    <i class="bi bi-envelope-slash fs-1 d-block mb-3 opacity-25"></i>
                                    <h6 class="fw-bold">{{ __('لا يوجد مشتركون حالياً') }}</h6>
                                    <p class="text-muted small">{{ __('سيظهر المشتركون هنا عند ملء نموذج النشرة الإخبارية') }}</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($subscribers->hasPages())
            <div class="card-footer bg-white py-3 border-0">
                {{ $subscribers->links() }}
            </div>
        @endif
    </div>

</div>

<style>
.stat-icon {
    width: 52px; height: 52px;
    display: flex; align-items: center; justify-content: center;
}
.subscriber-avatar {
    width: 34px; height: 34px;
    background: linear-gradient(135deg, #EB5E281A, #ff6b6b);
    color: #fff;
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: 13px; font-weight: 800;
    flex-shrink: 0;
}
.btn-danger-subtle  { background: #ffebee; }
.btn-warning-subtle { background: #fff8e1; }
.btn-success-subtle { background: #e8f5e9; }
.bg-success-subtle  { background: #e8f5e9 !important; }
.bg-danger-subtle   { background: #ffebee !important; }
</style>
@endsection
