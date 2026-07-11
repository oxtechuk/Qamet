@extends('partials.Layouts.crm-master')
@section('title', __('إدارة تصنيفات المقالات') . ' | AutoCRM')

@section('content')
    <div class="container-fluid" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">

        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h4 class="mb-1 fw-bold">{{ __('إدارة تصنيفات المقالات') }}</h4>
                <p class="text-muted mb-0 small">{{ __('إجمالي') }} {{ $categories->total() }} {{ __('تصنيف مسجل في النظام') }}</p>
            </div>
            @can('manage-blog')
            <button class="btn btn-primary rounded-pill px-4 shadow-sm fw-bold" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
                <i class="bi bi-plus-lg me-1"></i> {{ __('إضافة تصنيف جديد') }}
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
                            <th class="border-0 px-4 py-3" style="width: 60px;">#</th>
                            <th class="border-0 px-4 py-3">{{ __('الاسم') }}</th>
                            <th class="border-0 px-4 py-3">{{ __('المقالات') }}</th>
                            <th class="border-0 px-4 py-3">{{ __('الترتيب') }}</th>
                            <th class="border-0 px-4 py-3">{{ __('الحالة') }}</th>
                            <th class="border-0 px-4 py-3 text-end">{{ __('الإجراءات') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categories as $category)
                            <tr>
                                <td class="px-4 py-3 text-muted small">{{ $category->id }}</td>
                                <td class="px-4 py-3 fw-bold text-dark">
                                    @if($category->icon)
                                        <i class="bi bi-{{ $category->icon }} me-2 text-muted"></i>
                                    @endif
                                    {{ $category->name }}
                                </td>
                                <td class="px-4 py-3 text-muted">{{ $category->posts_count ?? 0 }} {{ __('مقال') }}</td>
                                <td class="px-4 py-3 text-muted">{{ $category->sort_order }}</td>
                                <td class="px-4 py-3">
                                    @if(!$category->is_active)
                                        <span class="badge bg-danger-subtle text-danger px-3 py-2 rounded-pill small fw-bold">{{ __('غير نشط') }}</span>
                                    @else
                                        <span class="badge bg-success-subtle text-success px-3 py-2 rounded-pill small fw-bold">{{ __('نشط') }}</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-end">
                                    @can('manage-blog')
                                    <button class="btn btn-sm btn-light rounded-3 me-2" data-bs-toggle="modal" data-bs-target="#editCategoryModal{{ $category->id }}" title="{{ __('تعديل') }}">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                    <form action="{{ route('crm.blog-categories.destroy', $category) }}" method="POST" class="d-inline-block"
                                        onsubmit="return confirm('{{ __("هل أنت متأكد من حذف هذا التصنيف بشكل نهائي؟") }}')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger rounded-3" title="{{ __('حذف') }}"><i class="bi bi-trash"></i></button>
                                    </form>
                                    @endcan
                                </td>
                            </tr>

                            {{-- Modal التعديل --}}
                            <div class="modal fade" id="editCategoryModal{{ $category->id }}" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                                        <div class="modal-header border-0 pt-4 px-4">
                                            <h5 class="modal-title fw-bold">{{ __('تعديل تصنيف') }}: {{ $category->name }}</h5>
                                            <button type="button" class="btn-close {{ app()->getLocale() == 'ar' ? 'ms-0 me-auto' : '' }}" data-bs-dismiss="modal"></button>
                                        </div>
                                        <form action="{{ route('crm.blog-categories.update', $category) }}" method="POST">
                                            @csrf @method('PUT')
                                            <div class="modal-body p-4 pt-2 text-start">
                                                <ul class="nav nav-pills nav-fill bg-light p-1 rounded-pill mb-4" role="tablist">
                                                    <li class="nav-item">
                                                        <button class="nav-link active rounded-pill py-1 fw-bold" data-bs-toggle="tab" data-bs-target="#edit-ar-{{ $category->id }}" type="button">{{ __('العربية') }}</button>
                                                    </li>
                                                    <li class="nav-item">
                                                        <button class="nav-link rounded-pill py-1 fw-bold" data-bs-toggle="tab" data-bs-target="#edit-en-{{ $category->id }}" type="button">{{ __('الإنجليزية') }}</button>
                                                    </li>
                                                </ul>

                                                <div class="tab-content mb-3">
                                                    <div class="tab-pane fade show active" id="edit-ar-{{ $category->id }}">
                                                        <label class="form-label fw-bold small">{{ __('اسم التصنيف (بالعربية)') }} <span class="text-danger">*</span></label>
                                                        <input type="text" name="name[ar]" class="form-control bg-light border-0 shadow-none"
                                                            value="{{ $category->getTranslation('name', 'ar', false) ?? '' }}" required>
                                                    </div>
                                                    <div class="tab-pane fade" id="edit-en-{{ $category->id }}">
                                                        <label class="form-label fw-bold small">{{ __('اسم التصنيف (بالإنجليزية)') }} <span class="text-danger">*</span></label>
                                                        <input type="text" name="name[en]" class="form-control bg-light border-0 shadow-none"
                                                            value="{{ $category->getTranslation('name', 'en', false) ?? '' }}" required>
                                                    </div>
                                                </div>

                                                <div class="row g-3 mb-3">
                                                    <div class="col-6">
                                                        <label class="form-label fw-bold small">{{ __('أيقونة Bootstrap') }}</label>
                                                        <input type="text" name="icon" class="form-control bg-light border-0 shadow-none"
                                                            value="{{ $category->icon }}" placeholder="car-front">
                                                        <small class="text-muted mt-1 d-block">{{ __('اسم أيقونة Bootstrap Icons') }}</small>
                                                    </div>
                                                    <div class="col-6">
                                                        <label class="form-label fw-bold small">{{ __('ترتيب العرض') }}</label>
                                                        <input type="number" name="sort_order" class="form-control bg-light border-0 shadow-none"
                                                            value="{{ $category->sort_order }}" min="0">
                                                    </div>
                                                </div>

                                                <div class="form-check form-switch p-3 bg-light rounded-3 border-0">
                                                    <input class="form-check-input {{ app()->getLocale() == 'ar' ? 'ms-0 me-2 float-none' : '' }}" type="checkbox" name="is_active" value="1"
                                                        id="active{{ $category->id }}" {{ $category->is_active ? 'checked' : '' }}>
                                                    <label class="form-check-label fw-bold ms-2" for="active{{ $category->id }}">{{ __('تفعيل التصنيف في الموقع') }}</label>
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
                                        <i class="bi bi-tags fs-1 d-block mb-3 opacity-25"></i>
                                        <h6 class="fw-bold">{{ __('لا توجد تصنيفات مسجلة حالياً') }}</h6>
                                        <p class="small mb-0">{{ __('أضف تصنيفات للمقالات مثل نصائح التمويل، أخبار السيارات، إلخ') }}</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-5 d-flex justify-content-center">{{ $categories->links() }}</div>

    </div>

    {{-- Modal الإضافة --}}
    <div class="modal fade" id="addCategoryModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="modal-header border-0 pt-4 px-4">
                    <h5 class="modal-title fw-bold">{{ __('إضافة تصنيف جديد') }}</h5>
                    <button type="button" class="btn-close {{ app()->getLocale() == 'ar' ? 'ms-0 me-auto' : '' }}" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('crm.blog-categories.store') }}" method="POST">
                    @csrf
                    <div class="modal-body p-4 pt-2">
                        <ul class="nav nav-pills nav-fill bg-light p-1 rounded-pill mb-4" role="tablist">
                            <li class="nav-item">
                                <button class="nav-link active rounded-pill py-1 fw-bold" data-bs-toggle="tab" data-bs-target="#add-ar" type="button">{{ __('العربية') }}</button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link rounded-pill py-1 fw-bold" data-bs-toggle="tab" data-bs-target="#add-en" type="button">{{ __('الإنجليزية') }}</button>
                            </li>
                        </ul>

                        <div class="tab-content mb-3">
                            <div class="tab-pane fade show active" id="add-ar">
                                <label class="form-label fw-bold small">{{ __('اسم التصنيف (بالعربية)') }} <span class="text-danger">*</span></label>
                                <input type="text" name="name[ar]" class="form-control bg-light border-0 shadow-none" placeholder="{{ __('مثال: نصائح التمويل') }}" required>
                            </div>
                            <div class="tab-pane fade" id="add-en">
                                <label class="form-label fw-bold small">{{ __('اسم التصنيف (بالإنجليزية)') }} <span class="text-danger">*</span></label>
                                <input type="text" name="name[en]" class="form-control bg-light border-0 shadow-none" placeholder="{{ __('e.g., Financing Tips') }}" required>
                            </div>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-6">
                                <label class="form-label fw-bold small">{{ __('أيقونة Bootstrap') }}</label>
                                <input type="text" name="icon" class="form-control bg-light border-0 shadow-none" placeholder="car-front">
                                <small class="text-muted mt-1 d-block">{{ __('اسم أيقونة Bootstrap Icons') }}</small>
                            </div>
                            <div class="col-6">
                                <label class="form-label fw-bold small">{{ __('ترتيب العرض') }}</label>
                                <input type="number" name="sort_order" class="form-control bg-light border-0 shadow-none" value="0" min="0">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-0 p-4 pt-0">
                        <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">{{ __('إلغاء') }}</button>
                        <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold">{{ __('إضافة التصنيف') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
