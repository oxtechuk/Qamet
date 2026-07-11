@extends('partials.Layouts.crm-master')
@section('title', __('معرض التصاميم') . ' | AutoCRM')

@section('content')
    <div class="container-fluid" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h4 class="mb-1 fw-bold">{{ __('معرض التصاميم والإعلانات') }}</h4>
                <p class="text-muted mb-0 small">{{ __('إدارة صور السوشيال ميديا والعروض المميزة في الصفحة الرئيسية') }}</p>
            </div>
            @can('manage-designs')
            <button class="btn btn-primary rounded-pill px-4 shadow-sm fw-bold" data-bs-toggle="modal" data-bs-target="#addDesignModal">
                <i class="bi bi-plus-circle me-1"></i> {{ __('إضافة جديد') }}
            </button>
            @endcan
        </div>

        

        <div class="row g-4">
            @forelse($designs as $design)
                <div class="col-6 col-md-4 col-xl-3">
                    <div class="card border-0 shadow-sm h-100 rounded-4 overflow-hidden">
                        <div class="position-relative">
                            <img src="{{ asset('storage/' . $design->image) }}" class="card-img-top object-fit-cover" alt="Design" style="height: 200px;">
                            <span class="position-absolute top-0 start-0 m-2 badge {{ $design->type == 'featured_offer' ? 'bg-danger' : 'bg-info' }} shadow-sm">
                                {{ $design->type == 'featured_offer' ? __('عرض مميز') : __('سوشيال ميديا') }}
                            </span>
                            @if($design->is_featured)
                                <span class="position-absolute top-0 end-0 m-2 badge bg-warning text-dark shadow-sm">
                                    <i class="bi bi-star-fill"></i>
                                </span>
                            @endif
                        </div>
                        <div class="card-body py-3">
                            <h6 class="mb-0 fw-bold text-dark text-truncate">{{ $design->getTranslation('name', app()->getLocale()) }}</h6>
                        </div>
                        <div class="card-footer bg-light border-0 d-flex gap-2 p-2">
                            @can('manage-designs')
                            <button class="btn btn-sm btn-white border shadow-xs rounded-2 flex-grow-1" data-bs-toggle="modal" data-bs-target="#editDesignModal{{ $design->id }}">
                                <i class="bi bi-pencil me-1"></i> {{ __('تعديل') }}
                            </button>
                            @endcan
                            @can('manage-designs')
                            <form action="{{ route('crm.settings.designs.destroy', $design) }}" method="POST" onsubmit="return confirm('{{ __('هل أنت متأكد؟') }}')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger border shadow-xs rounded-2"><i class="bi bi-trash"></i></button>
                            </form>
                            @endcan
                        </div>
                    </div>
                </div>

                {{-- Edit Modal --}}
                <div class="modal fade" id="editDesignModal{{ $design->id }}" tabindex="-1">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content border-0 shadow rounded-4 overflow-hidden">
                            <div class="modal-header border-0 pt-4 px-4">
                                <h5 class="modal-title fw-bold">{{ __('تعديل') }}</h5>
                                <button type="button" class="btn-close {{ app()->getLocale() == 'ar' ? 'ms-0 me-auto' : '' }}" data-bs-dismiss="modal"></button>
                            </div>
                            <form action="{{ route('crm.settings.designs.update', $design) }}" method="POST" enctype="multipart/form-data">
                                @csrf @method('PUT')
                                <div class="modal-body p-4 pt-2">
                                    <div class="row g-3 mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold small text-muted">{{ __('النوع (مكان الظهور)') }}</label>
                                            <select name="type" class="form-select bg-light border-0 type-selector" data-target="editSpecs{{ $design->id }}" required>
                                                <option value="social" {{ $design->type == 'social' ? 'selected' : '' }}>{{ __('سوشيال ميديا (Social Media)') }}</option>
                                                <option value="featured_offer" {{ $design->type == 'featured_offer' ? 'selected' : '' }}>{{ __('عرض مميز (Featured Section Cars)') }}</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold small text-muted">{{ __('الرابط (URL)') }}</label>
                                            <input type="text" name="link" class="form-control bg-light border-0" value="{{ $design->link }}" placeholder="https://...">
                                        </div>
                                    </div>
                                    <div class="row g-3 mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold small text-muted">{{ __('الاسم (بالعربية)') }}</label>
                                            <input type="text" name="name[ar]" class="form-control bg-light border-0" value="{{ $design->getTranslation('name', 'ar', false) }}" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold small text-muted">{{ __('الاسم (بالإنجليزية)') }}</label>
                                            <input type="text" name="name[en]" class="form-control bg-light border-0" value="{{ $design->getTranslation('name', 'en', false) }}" required>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold small text-muted">{{ __('الصورة') }}</label>
                                        <input type="file" name="image" class="form-control bg-light border-0" accept="image/*">
                                    </div>

                                    <div id="editSpecs{{ $design->id }}" class="spec-fields {{ $design->type == 'featured_offer' ? '' : 'd-none' }}">
                                        <hr>
                                        <h6 class="fw-bold mb-3 text-primary">{{ __('تفاصيل العرض (تظهر فقط في قسم السيارات المميزة)') }}</h6>
                                        <div class="row g-3">
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label fw-bold small text-muted">{{ __('السعر') }}</label>
                                                <input type="text" name="price" class="form-control bg-light border-0" value="{{ $design->price }}" placeholder="920,000">
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label fw-bold small text-muted">{{ __('السرعة القصوى') }}</label>
                                                <input type="text" name="top_speed" class="form-control bg-light border-0" value="{{ $design->top_speed }}" placeholder="300 كم/س">
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label fw-bold small text-muted">{{ __('القوة (حصان)') }}</label>
                                                <input type="text" name="power" class="form-control bg-light border-0" value="{{ $design->power }}" placeholder="600 حصان">
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label fw-bold small text-muted">{{ __('الموديل (السنة)') }}</label>
                                                <input type="text" name="year" class="form-control bg-light border-0" value="{{ $design->year }}" placeholder="2024">
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label fw-bold small text-muted">{{ __('نص الشارة (Badge)') }}</label>
                                                <input type="text" name="badge_text" class="form-control bg-light border-0" value="{{ $design->badge_text }}" placeholder="جديد / عرض خاص">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row g-3">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-bold small text-muted">{{ __('الترتيب') }}</label>
                                            <input type="number" name="sort_order" class="form-control bg-light border-0" value="{{ $design->sort_order }}">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <div class="form-check form-switch p-3 bg-light rounded-3 mt-4">
                                                <input class="form-check-input {{ app()->getLocale() == 'ar' ? 'ms-0 me-2 float-none' : '' }}" type="checkbox" name="is_featured" value="1" id="editFeatured{{ $design->id }}" {{ $design->is_featured ? 'checked' : '' }}>
                                                <label class="form-check-label fw-bold ms-2" for="editFeatured{{ $design->id }}">{{ __('تصميم مميز') }}</label>
                                            </div>
                                        </div>
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
                        <i class="bi bi-palette fs-1 d-block mb-3 opacity-25"></i>
                        <h6 class="fw-bold">{{ __('لا توجد بيانات حالياً') }}</h6>
                    </div>
                </div>
            @endforelse
        </div>
    </div>

    {{-- Add Modal --}}
    <div class="modal fade" id="addDesignModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow rounded-4 overflow-hidden">
                <div class="modal-header border-0 pt-4 px-4">
                    <h5 class="modal-title fw-bold">{{ __('إضافة جديد') }}</h5>
                    <button type="button" class="btn-close {{ app()->getLocale() == 'ar' ? 'ms-0 me-auto' : '' }}" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('crm.settings.designs.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body p-4 pt-2">
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-muted">{{ __('النوع (مكان الظهور)') }}</label>
                                <select name="type" class="form-select bg-light border-0 type-selector" data-target="addSpecs" required>
                                    <option value="social">{{ __('سوشيال ميديا (Social Media)') }}</option>
                                    <option value="featured_offer">{{ __('عرض مميز (Featured Section Cars)') }}</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-muted">{{ __('الرابط (URL)') }}</label>
                                <input type="text" name="link" class="form-control bg-light border-0" placeholder="https://...">
                            </div>
                        </div>
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-muted">{{ __('الاسم (بالعربية)') }}</label>
                                <input type="text" name="name[ar]" class="form-control bg-light border-0" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-muted">{{ __('الاسم (بالإنجليزية)') }}</label>
                                <input type="text" name="name[en]" class="form-control bg-light border-0" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold small text-muted">{{ __('الصورة') }} <span class="text-danger">*</span></label>
                            <input type="file" name="image" class="form-control bg-light border-0" accept="image/*" required>
                        </div>

                        <div id="addSpecs" class="spec-fields d-none">
                            <hr>
                            <h6 class="fw-bold mb-3 text-primary">{{ __('تفاصيل العرض (تظهر فقط في قسم السيارات المميزة)') }}</h6>
                            <div class="row g-3">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-bold small text-muted">{{ __('السعر') }}</label>
                                    <input type="text" name="price" class="form-control bg-light border-0" placeholder="920,000">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-bold small text-muted">{{ __('السرعة القصوى') }}</label>
                                    <input type="text" name="top_speed" class="form-control bg-light border-0" placeholder="300 كم/س">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-bold small text-muted">{{ __('القوة (حصان)') }}</label>
                                    <input type="text" name="power" class="form-control bg-light border-0" placeholder="600 حصان">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-bold small text-muted">{{ __('الموديل (السنة)') }}</label>
                                    <input type="text" name="year" class="form-control bg-light border-0" placeholder="2024">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-bold small text-muted">{{ __('نص الشارة (Badge)') }}</label>
                                    <input type="text" name="badge_text" class="form-control bg-light border-0" placeholder="جديد / عرض خاص">
                                </div>
                            </div>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold small text-muted">{{ __('الترتيب') }}</label>
                                <input type="number" name="sort_order" class="form-control bg-light border-0" value="0">
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-check form-switch p-3 bg-light rounded-3 mt-4">
                                    <input class="form-check-input {{ app()->getLocale() == 'ar' ? 'ms-0 me-2 float-none' : '' }}" type="checkbox" name="is_featured" value="1" id="addFeatured">
                                    <label class="form-check-label fw-bold ms-2" for="addFeatured">{{ __('تصميم مميز') }}</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-0 p-4 pt-0">
                        <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">{{ __('إلغاء') }}</button>
                        <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold">{{ __('إضافة') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('js')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const selectors = document.querySelectorAll('.type-selector');
        selectors.forEach(select => {
            select.addEventListener('change', function() {
                const targetId = this.getAttribute('data-target');
                const targetDiv = document.getElementById(targetId);
                if (this.value === 'featured_offer') {
                    targetDiv.classList.remove('d-none');
                } else {
                    targetDiv.classList.add('d-none');
                }
            });
        });
    });
</script>
@endpush

<style>
    .btn-white { background: #fff; }
    .shadow-xs { box-shadow: 0 1px 2px rgba(0,0,0,0.05); }
    .object-fit-cover { object-fit: cover; }
    .spec-fields { transition: all 0.3s ease; }
</style>
