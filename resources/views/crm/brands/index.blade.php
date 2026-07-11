@extends('partials.Layouts.crm-master')
@section('title', __('إدارة الماركات') . ' | AutoCRM')

@section('content')
    <div class="container-fluid" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">

        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h4 class="mb-1 fw-bold"> {{ __('إدارة ماركات السيارات') }}</h4>
                <p class="text-muted mb-0 small">{{ __('إجمالي') }} {{ $brands->total() }} {{ __('ماركة مسجلة في النظام') }}</p>
            </div>
            @can('manage-brands')
            <button class="btn btn-primary rounded-pill px-4 shadow-sm fw-bold" data-bs-toggle="modal" data-bs-target="#addBrandModal">
                <i class="bi bi-plus-lg me-1"></i> {{ __('إضافة ماركة جديدة') }}
            </button>
            @endcan
        </div>

     
        @error('name')
            <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-4 mb-4">
                <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ $message }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @enderror

        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="border-0 px-4 py-3" style="width: 80px;">{{ __('الشعار') }}</th>
                            <th class="border-0 px-4 py-3">{{ __('الاسم') }}</th>
                            <th class="border-0 px-4 py-3">{{ __('نوع الماركة') }}</th>
                            <th class="border-0 px-4 py-3">{{ __('عدد السيارات') }}</th>
                            <th class="border-0 px-4 py-3">{{ __('الحالة') }}</th>
                            <th class="border-0 px-4 py-3 text-end">{{ __('الإجراءات') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($brands as $brand)
                            <tr>
                                <td class="px-4 py-3">
                                    @if($brand->logo)
                                        <div class="brand-logo-container p-1 border rounded bg-white shadow-xs" style="width: 50px; height: 50px;">
                                            <img src="{{ asset('storage/' . $brand->logo) }}" alt="{{ $brand->name }}" width="40" height="40" class="object-fit-contain">
                                        </div>
                                    @else
                                        <div class="bg-light rounded d-flex align-items-center justify-content-center border" style="width: 50px; height: 50px;">
                                            <i class="bi bi-bookmark-star fs-4 text-muted opacity-25"></i>
                                        </div>
                                    @endif
                                </td>
                                <td class="px-4 py-3 fw-bold text-dark">{{ $brand->name }}</td>
                                <td class="px-4 py-3">
                                    @if($brand->brandType)
                                        <span class="badge bg-info-subtle text-info px-3 py-2 rounded-pill small fw-bold">{{ $brand->brandType->name }}</span>
                                    @else
                                        <span class="text-muted small">—</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-muted">{{ $brand->cars_count }} {{ __('سيارة') }}</td>
                                <td class="px-4 py-3">
                                    @if(!$brand->is_active)
                                        <span class="badge bg-danger-subtle text-danger px-3 py-2 rounded-pill small fw-bold">{{ __('متوقفة') }}</span>
                                    @else
                                        <span class="badge bg-success-subtle text-success px-3 py-2 rounded-pill small fw-bold">{{ __('نشطة') }}</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-end">
                                    @can('manage-brands')
                                    <button class="btn btn-sm btn-light rounded-3 me-2" data-bs-toggle="modal" data-bs-target="#editBrandModal{{ $brand->id }}" title="{{ __('تعديل') }}">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                    <form action="{{ route('crm.brands.destroy', $brand) }}" method="POST" class="d-inline-block"
                                        onsubmit="return confirm('{{ __("هل أنت متأكد من حذف هذه الماركة بشكل نهائي؟") }}')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger rounded-3" title="{{ __('حذف') }}"><i class="bi bi-trash"></i></button>
                                    </form>
                                    @endcan
                                </td>
                            </tr>

                            {{-- Modal التعديل --}}
                            <div class="modal fade" id="editBrandModal{{ $brand->id }}" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                                        <div class="modal-header border-0 pt-4 px-4">
                                            <h5 class="modal-title fw-bold">{{ __('تعديل ماركة') }}: {{ $brand->name }}</h5>
                                            <button type="button" class="btn-close {{ app()->getLocale() == 'ar' ? 'ms-0 me-auto' : '' }}" data-bs-dismiss="modal"></button>
                                        </div>
                                        <form action="{{ route('crm.brands.update', $brand) }}" method="POST" enctype="multipart/form-data">
                                            @csrf @method('PUT')
                                            <div class="modal-body p-4 pt-2 text-start">
                                                {{-- Tabs for Translation --}}
                                                <ul class="nav nav-pills nav-fill bg-light p-1 rounded-pill mb-4" role="tablist">
                                                    <li class="nav-item">
                                                        <button class="nav-link active rounded-pill py-1 fw-bold" data-bs-toggle="tab" data-bs-target="#edit-ar-{{ $brand->id }}" type="button">{{ __('العربية') }}</button>
                                                    </li>
                                                    <li class="nav-item">
                                                        <button class="nav-link rounded-pill py-1 fw-bold" data-bs-toggle="tab" data-bs-target="#edit-en-{{ $brand->id }}" type="button">{{ __('الإنجليزية') }}</button>
                                                    </li>
                                                </ul>

                                                <div class="tab-content mb-4">
                                                    <div class="tab-pane fade show active" id="edit-ar-{{ $brand->id }}">
                                                        <label class="form-label fw-bold small">{{ __('اسم الماركة (بالعربية)') }} <span class="text-danger">*</span></label>
                                                        <input type="text" name="name[ar]" class="form-control bg-light border-0 shadow-none"
                                                            value="{{ $brand->getTranslation('name', 'ar', false) ?? '' }}" required>
                                                    </div>
                                                    <div class="tab-pane fade" id="edit-en-{{ $brand->id }}">
                                                        <label class="form-label fw-bold small">{{ __('اسم الماركة (بالإنجليزية)') }} <span class="text-danger">*</span></label>
                                                        <input type="text" name="name[en]" class="form-control bg-light border-0 shadow-none"
                                                            value="{{ $brand->getTranslation('name', 'en', false) ?? '' }}" required>
                                                    </div>
                                                </div>

                                                <div class="mb-4">
                                                    <label class="form-label fw-bold small">{{ __('الشعار (Logo)') }}</label>
                                                    <div class="input-group">
                                                        <input type="file" name="logo" class="form-control bg-light border-0 shadow-none" accept="image/*,.svg">
                                                    </div>
                                                    <small class="text-muted mt-1 d-block">{{ __('اتركه فارغاً للاحتفاظ بالشعار الحالي') }}</small>
                                                </div>
                                                <div class="mb-4">
                                                    <label class="form-label fw-bold small">{{ __('نوع الماركة') }}</label>
                                                    <select name="brand_type_id" class="form-select bg-light border-0 shadow-none">
                                                        <option value="">{{ __('بدون تصنيف') }}</option>
                                                        @foreach($brandTypes as $type)
                                                            <option value="{{ $type->id }}" {{ $brand->brand_type_id == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-check form-switch p-3 bg-light rounded-3 border-0">
                                                    <input class="form-check-input {{ app()->getLocale() == 'ar' ? 'ms-0 me-2 float-none' : '' }}" type="checkbox" name="is_active" value="1"
                                                        id="active{{ $brand->id }}" {{ $brand->is_active ? 'checked' : '' }}>
                                                    <label class="form-check-label fw-bold ms-2" for="active{{ $brand->id }}">{{ __('تفعيل الماركة في الموقع') }}</label>
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
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <div class="py-4 opacity-50">
                                        <i class="bi bi-bookmark-star fs-1 d-block mb-3 opacity-25"></i>
                                        <h6 class="fw-bold">{{ __('لا توجد ماركات مسجلة حالياً') }}</h6>
                                        <p class="small mb-0">{{ __('ابدأ بإضافة الماركات التي تتعامل معها') }}</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-5 d-flex justify-content-center">{{ $brands->links() }}</div>

    </div>

    {{-- Modal الإضافة --}}
    <div class="modal fade" id="addBrandModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="modal-header border-0 pt-4 px-4">
                    <h5 class="modal-title fw-bold">{{ __('إضافة ماركة جديدة') }}</h5>
                    <button type="button" class="btn-close {{ app()->getLocale() == 'ar' ? 'ms-0 me-auto' : '' }}" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('crm.brands.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body p-4 pt-2">
                        {{-- Tabs for Translation --}}
                        <ul class="nav nav-pills nav-fill bg-light p-1 rounded-pill mb-4" role="tablist">
                            <li class="nav-item">
                                <button class="nav-link active rounded-pill py-1 fw-bold" data-bs-toggle="tab" data-bs-target="#add-ar" type="button">{{ __('العربية') }}</button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link rounded-pill py-1 fw-bold" data-bs-toggle="tab" data-bs-target="#add-en" type="button">{{ __('الإنجليزية') }}</button>
                            </li>
                        </ul>

                        <div class="tab-content mb-4">
                            <div class="tab-pane fade show active" id="add-ar">
                                <label class="form-label fw-bold small">{{ __('اسم الماركة (بالعربية)') }} <span class="text-danger">*</span></label>
                                <input type="text" name="name[ar]" class="form-control bg-light border-0 shadow-none" placeholder="{{ __('مثال: تويوتا') }}" required>
                            </div>
                            <div class="tab-pane fade" id="add-en">
                                <label class="form-label fw-bold small">{{ __('اسم الماركة (بالإنجليزية)') }} <span class="text-danger">*</span></label>
                                <input type="text" name="name[en]" class="form-control bg-light border-0 shadow-none" placeholder="{{ __('e.g., Toyota') }}" required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold small">{{ __('الشعار (Logo)') }} <span class="text-danger">*</span></label>
                            <input type="file" name="logo" class="form-control bg-light border-0 shadow-none" accept="image/*,.svg" required>
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-bold small">{{ __('نوع الماركة') }}</label>
                            <select name="brand_type_id" class="form-select bg-light border-0 shadow-none">
                                <option value="">{{ __('بدون تصنيف') }}</option>
                                @foreach($brandTypes as $type)
                                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer border-0 p-4 pt-0">
                        <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">{{ __('إلغاء') }}</button>
                        <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold">{{ __('إضافة الماركة الآن') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        .brand-logo-container { width: 75px; height: 75px; display: flex; align-items: center; justify-content: center; }
        .transition-hover { transition: transform 0.3s ease-in-out; }
        .transition-hover:hover { transform: translateY(-8px); }
        .btn-white { background: #fff; }
        .btn-danger-subtle { background: #ffebee; border: none; }
        .shadow-xs { box-shadow: 0 1px 2px rgba(0,0,0,0.05); }
    </style>
@endsection
