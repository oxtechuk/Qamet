@extends('partials.Layouts.crm-master')
@section('title', __('تصنيفات السيارات') . ' | AutoCRM')

@section('content')
    <div class="container-fluid" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">

        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h4 class="mb-1 fw-bold"> {{ __('تصنيفات السيارات') }}</h4>
                <p class="text-muted mb-0 small">{{ __('إجمالي') }} {{ $categories->total() }} {{ __('تصنيف متاح في النظام') }}</p>
            </div>
            @can('manage-car-categories')
            <button class="btn btn-primary rounded-pill px-4 shadow-sm fw-bold" data-bs-toggle="modal" data-bs-target="#addCatModal">
                <i class="bi bi-plus-lg me-1"></i> {{ __('إضافة تصنيف جديد') }}
            </button>
            @endcan
        </div>

        

        <div class="row g-4">
            @forelse ($categories as $cat)
                <div class="col-6 col-md-4 col-xl-3">
                    <div class="card border-0 shadow-sm text-center h-100 rounded-4 overflow-hidden transition-hover">
                        <div class="card-body p-4">
                            <div class="bg-primary-subtle rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3 border border-white shadow-xs"
                                style="width:65px;height:65px;">
                                <i class="bi bi-folder2-open fs-2 text-primary"></i>
                            </div>
                            <h5 class="mb-1 fw-bold text-dark">{{ $cat->name }}</h5>
                            <p class="text-muted small mb-3 fw-medium">{{ $cat->cars_count }} {{ __('سيارة') }}</p>
                            
                            @if (!$cat->is_active)
                                <span class="badge bg-danger-subtle text-danger px-3 py-2 rounded-pill small fw-bold">{{ __('متوقف') }}</span>
                            @else
                                <span class="badge bg-success-subtle text-success px-3 py-2 rounded-pill small fw-bold">{{ __('نشط') }}</span>
                            @endif
                        </div>
                        <div class="card-footer bg-light border-0 d-flex gap-2 p-3">
                            @can('manage-car-categories')
                            <button class="btn btn-sm btn-white border shadow-xs flex-grow-1 rounded-3 fw-bold" data-bs-toggle="modal"
                                data-bs-target="#editCat{{ $cat->id }}"><i class="bi bi-pencil-square me-1"></i> {{ __('تعديل') }}</button>
                            @endcan
                            @can('manage-car-categories')
                            <form action="{{ route('crm.car-categories.destroy', $cat) }}" method="POST"
                                onsubmit="return confirm('{{ __("هل أنت متأكد من حذف هذا التصنيف؟") }}')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger-subtle text-danger rounded-3 px-3 shadow-xs"><i class="bi bi-trash"></i></button>
                            </form>
                            @endcan
                        </div>
                    </div>
                </div>

                {{-- Modal التعديل --}}
                <div class="modal fade" id="editCat{{ $cat->id }}" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                            <div class="modal-header border-0 pt-4 px-4">
                                <h5 class="modal-title fw-bold">{{ __('تعديل التصنيف') }}</h5>
                                <button type="button" class="btn-close {{ app()->getLocale() == 'ar' ? 'ms-0 me-auto' : '' }}" data-bs-dismiss="modal"></button>
                            </div>
                            <form action="{{ route('crm.car-categories.update', $cat) }}" method="POST">
                                @csrf @method('PUT')
                                <div class="modal-body p-4 pt-2">
                                    {{-- Tabs for Translation --}}
                                    <ul class="nav nav-pills nav-fill bg-light p-1 rounded-pill mb-4" role="tablist">
                                        <li class="nav-item">
                                            <button class="nav-link active rounded-pill py-1 fw-bold" data-bs-toggle="tab" data-bs-target="#edit-ar-cat-{{ $cat->id }}" type="button">{{ __('العربية') }}</button>
                                        </li>
                                        <li class="nav-item">
                                            <button class="nav-link rounded-pill py-1 fw-bold" data-bs-toggle="tab" data-bs-target="#edit-en-cat-{{ $cat->id }}" type="button">{{ __('الإنجليزية') }}</button>
                                        </li>
                                    </ul>

                                    <div class="tab-content mb-4">
                                        <div class="tab-pane fade show active" id="edit-ar-cat-{{ $cat->id }}">
                                            <label class="form-label fw-bold small">{{ __('اسم التصنيف (بالعربية)') }} <span class="text-danger">*</span></label>
                                            <input type="text" name="name[ar]" class="form-control bg-light border-0 shadow-none"
                                                value="{{ $cat->getTranslation('name', 'ar', false) ?? '' }}" required>
                                        </div>
                                        <div class="tab-pane fade" id="edit-en-cat-{{ $cat->id }}">
                                            <label class="form-label fw-bold small">{{ __('اسم التصنيف (بالإنجليزية)') }} <span class="text-danger">*</span></label>
                                            <input type="text" name="name[en]" class="form-control bg-light border-0 shadow-none"
                                                value="{{ $cat->getTranslation('name', 'en', false) ?? '' }}" required>
                                        </div>
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label fw-bold small">{{ __('ترتيب العرض') }}</label>
                                        <input type="number" name="sort_order" class="form-control bg-light border-0 shadow-none"
                                            value="{{ $cat->sort_order }}">
                                    </div>
                                    <div class="form-check form-switch p-3 bg-light rounded-3 border-0">
                                        <input class="form-check-input {{ app()->getLocale() == 'ar' ? 'ms-0 me-2 float-none' : '' }}" type="checkbox" name="is_active" value="1"
                                            id="cact{{ $cat->id }}" {{ $cat->is_active ? 'checked' : '' }}>
                                        <label class="form-check-label fw-bold ms-2" for="cact{{ $cat->id }}">{{ __('تفعيل التصنيف في الموقع') }}</label>
                                    </div>
                                </div>
                                <div class="modal-footer border-0 p-4 pt-0">
                                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">{{ __('إلغاء') }}</button>
                                    <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold">{{ __('حفظ التغييرات') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <div class="text-center py-5 bg-white rounded-4 shadow-sm opacity-50">
                        <i class="bi bi-folder-x fs-1 d-block mb-3 opacity-25"></i>
                        <h6 class="fw-bold">{{ __('لا توجد تصنيفات مسجلة حالياً') }}</h6>
                        <p class="small">{{ __('قم بإضافة تصنيفات مثل (سيدان، SUV، هاتشباك) لتنظيم سياراتك') }}</p>
                    </div>
                </div>
            @endforelse
        </div>

        <div class="mt-5 d-flex justify-content-center">{{ $categories->links() }}</div>

        {{-- Modal الإضافة --}}
        <div class="modal fade" id="addCatModal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                    <div class="modal-header border-0 pt-4 px-4">
                        <h5 class="modal-title fw-bold">{{ __('إضافة تصنيف جديد') }}</h5>
                        <button type="button" class="btn-close {{ app()->getLocale() == 'ar' ? 'ms-0 me-auto' : '' }}" data-bs-dismiss="modal"></button>
                    </div>
                    <form action="{{ route('crm.car-categories.store') }}" method="POST">
                        @csrf
                        <div class="modal-body p-4 pt-2">
                            {{-- Tabs for Translation --}}
                            <ul class="nav nav-pills nav-fill bg-light p-1 rounded-pill mb-4" role="tablist">
                                <li class="nav-item">
                                    <button class="nav-link active rounded-pill py-1 fw-bold" data-bs-toggle="tab" data-bs-target="#add-ar-cat" type="button">{{ __('العربية') }}</button>
                                </li>
                                <li class="nav-item">
                                    <button class="nav-link rounded-pill py-1 fw-bold" data-bs-toggle="tab" data-bs-target="#add-en-cat" type="button">{{ __('الإنجليزية') }}</button>
                                </li>
                            </ul>

                            <div class="tab-content mb-4">
                                <div class="tab-pane fade show active" id="add-ar-cat">
                                    <label class="form-label fw-bold small">{{ __('اسم التصنيف (بالعربية)') }} <span class="text-danger">*</span></label>
                                    <input type="text" name="name[ar]" class="form-control bg-light border-0 shadow-none" placeholder="{{ __('مثال: سيدان') }}" required>
                                </div>
                                <div class="tab-pane fade" id="add-en-cat">
                                    <label class="form-label fw-bold small">{{ __('اسم التصنيف (بالإنجليزية)') }} <span class="text-danger">*</span></label>
                                    <input type="text" name="name[en]" class="form-control bg-light border-0 shadow-none" placeholder="{{ __('e.g., Sedan') }}" required>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold small">{{ __('ترتيب العرض') }}</label>
                                <input type="number" name="sort_order" class="form-control bg-light border-0 shadow-none" value="0">
                            </div>
                            <div class="form-check form-switch p-3 bg-light rounded-3 border-0">
                                <input class="form-check-input {{ app()->getLocale() == 'ar' ? 'ms-0 me-2 float-none' : '' }}" type="checkbox" name="is_active" value="1" id="ncact" checked>
                                <label class="form-check-label fw-bold ms-2" for="ncact">{{ __('تفعيل التصنيف فوراً') }}</label>
                            </div>
                        </div>
                        <div class="modal-footer border-0 p-4 pt-0">
                            <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">{{ __('إلغاء') }}</button>
                            <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold">{{ __('إضافة التصنيف الآن') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <style>
        .transition-hover { transition: transform 0.3s ease-in-out; }
        .transition-hover:hover { transform: translateY(-8px); }
        .bg-primary-subtle { background: #e7f1ff; }
        .btn-white { background: #fff; }
        .btn-danger-subtle { background: #ffebee; border: none; }
        .shadow-xs { box-shadow: 0 1px 2px rgba(0,0,0,0.05); }
    </style>
@endsection
