@extends('partials.Layouts.crm-master')
@section('title', __('شركاء النجاح') . ' | AutoCRM')

@section('content')
    <div class="container-fluid" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h4 class="mb-1 fw-bold">{{ __('شركاء النجاح (Partners)') }}</h4>
                <p class="text-muted mb-0 small">{{ __('إدارة شعارات الشركاء والروابط') }}</p>
            </div>
            @can('manage-partners')
            <button class="btn btn-primary rounded-pill px-4 shadow-sm fw-bold" data-bs-toggle="modal" data-bs-target="#addPartnerModal">
                <i class="bi bi-plus-circle me-1"></i> {{ __('إضافة شريك') }}
            </button>
            @endcan
        </div>

      

        <div class="row g-4">
            @forelse($partners as $partner)
                <div class="col-6 col-md-4 col-xl-3">
                    <div class="card border-0 shadow-sm text-center h-100 rounded-4 overflow-hidden">
                        <div class="card-body p-4">
                            <div class="mb-3 d-flex justify-content-center align-items-center bg-light rounded-4 p-3" style="height: 100px;">
                                <img src="{{ asset('storage/' . $partner->logo) }}" alt="{{ $partner->name }}" class="img-fluid object-fit-contain" style="max-height: 80px;">
                            </div>
                            <h6 class="mb-1 fw-bold text-dark">{{ $partner->name ?? __('بدون اسم') }}</h6>
                            <p class="text-muted small text-truncate mb-0" dir="ltr">{{ $partner->link ? $partner->link : __('لا يوجد رابط') }}</p>
                        </div>
                        <div class="card-footer bg-light border-0 d-flex gap-2 p-2">
                            @can('manage-partners')
                            <button class="btn btn-sm btn-white border shadow-xs rounded-2 flex-grow-1" data-bs-toggle="modal" data-bs-target="#editPartnerModal{{ $partner->id }}">
                                <i class="bi bi-pencil"></i> {{ __('تعديل') }}
                            </button>
                            @endcan
                            @can('manage-partners')
                            <form action="{{ route('crm.settings.partners.destroy', $partner) }}" method="POST" onsubmit="return confirm('{{ __('هل أنت متأكد من حذف هذا الشريك؟') }}')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger border shadow-xs rounded-2 px-3"><i class="bi bi-trash"></i></button>
                            </form>
                            @endcan
                        </div>
                    </div>
                </div>

                {{-- Edit Modal --}}
                <div class="modal fade" id="editPartnerModal{{ $partner->id }}" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content border-0 shadow rounded-4 overflow-hidden">
                            <div class="modal-header border-0 pt-4 px-4">
                                <h5 class="modal-title fw-bold">{{ __('تعديل شريك') }}</h5>
                                <button type="button" class="btn-close {{ app()->getLocale() == 'ar' ? 'ms-0 me-auto' : '' }}" data-bs-dismiss="modal"></button>
                            </div>
                            <form action="{{ route('crm.settings.partners.update', $partner) }}" method="POST" enctype="multipart/form-data">
                                @csrf @method('PUT')
                                <div class="modal-body p-4 pt-2">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold small text-muted">{{ __('اسم الشريك') }}</label>
                                        <input type="text" name="name" class="form-control bg-light border-0 shadow-none" value="{{ $partner->name }}">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold small text-muted">{{ __('الشعار (Logo)') }}</label>
                                        <input type="file" name="logo" class="form-control bg-light border-0 shadow-none" accept="image/*">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold small text-muted">{{ __('الرابط (اختياري)') }}</label>
                                        <input type="url" name="link" class="form-control bg-light border-0 shadow-none" value="{{ $partner->link }}" placeholder="https://..." dir="ltr">
                                    </div>
                                    <div class="mb-0">
                                        <label class="form-label fw-bold small text-muted">{{ __('الترتيب') }}</label>
                                        <input type="number" name="sort_order" class="form-control bg-light border-0 shadow-none" value="{{ $partner->sort_order }}">
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
                <div class="col-12 text-center py-5">
                    <div class="card border-0 shadow-sm rounded-4 p-5">
                        <i class="bi bi-hand-thumbs-up fs-1 d-block mb-3 opacity-25"></i>
                        <h6 class="fw-bold">{{ __('لا يوجد شركاء مسجلين حالياً') }}</h6>
                    </div>
                </div>
            @endforelse
        </div>
    </div>

    {{-- Add Modal --}}
    <div class="modal fade" id="addPartnerModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow rounded-4 overflow-hidden">
                <div class="modal-header border-0 pt-4 px-4">
                    <h5 class="modal-title fw-bold">{{ __('إضافة شريك جديد') }}</h5>
                    <button type="button" class="btn-close {{ app()->getLocale() == 'ar' ? 'ms-0 me-auto' : '' }}" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('crm.settings.partners.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body p-4 pt-2">
                        <div class="mb-3">
                            <label class="form-label fw-bold small text-muted">{{ __('اسم الشريك') }}</label>
                            <input type="text" name="name" class="form-control bg-light border-0 shadow-none" placeholder="{{ __('اسم الشركة...') }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold small text-muted">{{ __('الشعار (Logo)') }} <span class="text-danger">*</span></label>
                            <input type="file" name="logo" class="form-control bg-light border-0 shadow-none" accept="image/*" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold small text-muted">{{ __('الرابط (اختياري)') }}</label>
                            <input type="url" name="link" class="form-control bg-light border-0 shadow-none" placeholder="https://..." dir="ltr">
                        </div>
                        <div class="mb-0">
                            <label class="form-label fw-bold small text-muted">{{ __('الترتيب') }}</label>
                            <input type="number" name="sort_order" class="form-control bg-light border-0 shadow-none" value="0">
                        </div>
                    </div>
                    <div class="modal-footer border-0 p-4 pt-0">
                        <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">{{ __('إلغاء') }}</button>
                        <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold">{{ __('إضافة شريك') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

<style>
    .btn-white { background: #fff; }
    .shadow-xs { box-shadow: 0 1px 2px rgba(0,0,0,0.05); }
    .object-fit-contain { object-fit: contain; }
</style>
