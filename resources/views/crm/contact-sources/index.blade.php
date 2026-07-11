@extends('partials.Layouts.crm-master')
@section('title', __('مصادر التواصل') . ' | AutoCRM')

@section('content')
    <div class="container-fluid" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h4 class="mb-1 fw-bold">{{ __('مصادر التواصل') }}</h4>
                <p class="text-muted mb-0 small">{{ __('تستخدم عند إضافة عميل جديد') }}</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('crm.leads.index') }}" class="btn btn-light btn-sm rounded-pill px-3">{{ __('العملاء المحتملون') }}</a>
                @can('manage-contact-sources')
                <button class="btn btn-primary btn-sm rounded-pill px-3 shadow-sm" data-bs-toggle="modal" data-bs-target="#addSourceModal">
                    <i class="bi bi-plus-lg"></i> {{ __('إضافة') }}
                </button>
                @endcan
            </div>
        </div>

        
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-4 mb-4">
                <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="px-4 py-3 text-muted fw-bold small">#</th>
                            <th class="py-3 text-muted fw-bold small">{{ __('الاسم') }}</th>
                            <th class="py-3 text-muted fw-bold small">{{ __('الترتيب') }}</th>
                            <th class="py-3 text-muted fw-bold small text-center">{{ __('الحالة') }}</th>
                            <th class="px-4 py-3 text-muted fw-bold small text-end">{{ __('إجراءات') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($sources as $src)
                            <tr>
                                <td class="px-4 text-muted small">{{ $src->id }}</td>
                                <td class="fw-bold text-dark">{{ $src->name }}</td>
                                <td class="text-muted">{{ $src->sort_order }}</td>
                                <td class="text-center">
                                    @if ($src->is_active)
                                        <span class="badge bg-success-subtle text-success rounded-pill px-3 py-2 small">{{ __('نشط') }}</span>
                                    @else
                                        <span class="badge bg-secondary-subtle text-secondary rounded-pill px-3 py-2 small">{{ __('متوقف') }}</span>
                                    @endif
                                </td>
                                <td class="px-4 text-end">
                                    <div class="d-flex gap-1 justify-content-end">
                                        @can('manage-contact-sources')
                                        <button class="btn btn-sm btn-white border shadow-xs rounded-2" data-bs-toggle="modal" data-bs-target="#editModal{{ $src->id }}">
                                            <i class="bi bi-pencil text-muted"></i>
                                        </button>
                                        @endcan
                                        @can('manage-contact-sources')
                                        <form action="{{ route('crm.contact-sources.destroy', $src) }}" method="POST" onsubmit="return confirm('{{ __('تأكيد الحذف؟') }}')">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger border shadow-xs rounded-2"><i class="bi bi-trash"></i></button>
                                        </form>
                                        @endcan
                                    </div>
                                </td>
                            </tr>

                            {{-- Edit Modal --}}
                            <div class="modal fade" id="editModal{{ $src->id }}" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content border-0 shadow rounded-4 overflow-hidden">
                                        <div class="modal-header border-0 pt-4 px-4">
                                            <h5 class="modal-title fw-bold">{{ __('تعديل') }}</h5>
                                            <button type="button" class="btn-close {{ app()->getLocale() == 'ar' ? 'ms-0 me-auto' : '' }}" data-bs-dismiss="modal"></button>
                                        </div>
                                        <form action="{{ route('crm.contact-sources.update', $src) }}" method="POST">
                                            @csrf @method('PUT')
                                            <div class="modal-body p-4 pt-2">
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold small text-muted">{{ __('الاسم') }}</label>
                                                    <input type="text" name="name" class="form-control bg-light border-0 shadow-none" value="{{ $src->name }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold small text-muted">{{ __('ترتيب') }}</label>
                                                    <input type="number" name="sort_order" class="form-control bg-light border-0 shadow-none" value="{{ $src->sort_order }}">
                                                </div>
                                                <div class="form-check form-switch p-3 bg-light rounded-3">
                                                    <input class="form-check-input {{ app()->getLocale() == 'ar' ? 'ms-0 me-2 float-none' : '' }}" type="checkbox" name="is_active" value="1" id="act{{ $src->id }}" {{ $src->is_active ? 'checked' : '' }}>
                                                    <label class="form-check-label fw-bold ms-2" for="act{{ $src->id }}">{{ __('نشط') }}</label>
                                                </div>
                                            </div>
                                            <div class="modal-footer border-0 p-4 pt-0">
                                                <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">{{ __('إلغاء') }}</button>
                                                <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold">{{ __('حفظ') }}</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-5">
                                    <i class="bi bi-inbox fs-1 d-block mb-2 opacity-25"></i>
                                    {{ __('لا توجد مصادر') }}
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($sources->hasPages())
                <div class="card-footer bg-white py-3 border-0">
                    {{ $sources->links() }}
                </div>
            @endif
        </div>

        {{-- Add Modal --}}
        <div class="modal fade" id="addSourceModal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 shadow rounded-4 overflow-hidden">
                    <div class="modal-header border-0 pt-4 px-4">
                        <h5 class="modal-title fw-bold">{{ __('مصدر جديد') }}</h5>
                        <button type="button" class="btn-close {{ app()->getLocale() == 'ar' ? 'ms-0 me-auto' : '' }}" data-bs-dismiss="modal"></button>
                    </div>
                    <form action="{{ route('crm.contact-sources.store') }}" method="POST">
                        @csrf
                        <div class="modal-body p-4 pt-2">
                            <div class="mb-3">
                                <label class="form-label fw-bold small text-muted">{{ __('الاسم') }}</label>
                                <input type="text" name="name" class="form-control bg-light border-0 shadow-none" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold small text-muted">{{ __('ترتيب') }}</label>
                                <input type="number" name="sort_order" class="form-control bg-light border-0 shadow-none" value="0">
                            </div>
                            <div class="form-check form-switch p-3 bg-light rounded-3">
                                <input class="form-check-input {{ app()->getLocale() == 'ar' ? 'ms-0 me-2 float-none' : '' }}" type="checkbox" name="is_active" value="1" id="nact" checked>
                                <label class="form-check-label fw-bold ms-2" for="nact">{{ __('نشط') }}</label>
                            </div>
                        </div>
                        <div class="modal-footer border-0 p-4 pt-0">
                            <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">{{ __('إلغاء') }}</button>
                            <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold">{{ __('حفظ') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

<style>
    .btn-white { background: #fff; }
    .shadow-xs { box-shadow: 0 1px 2px rgba(0,0,0,0.05); }
</style>
