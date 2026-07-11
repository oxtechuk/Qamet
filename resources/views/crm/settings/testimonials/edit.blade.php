@extends('partials.Layouts.crm-master')
@section('title', __('تعديل توصية') . ' | AutoCRM')

@section('content')
    <div class="container-fluid" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
        <div class="mb-4 d-flex align-items-center">
            <a href="{{ route('crm.settings.testimonials.index') }}" class="btn btn-sm btn-white border shadow-xs rounded-2 {{ app()->getLocale() == 'ar' ? 'ms-3' : 'me-3' }}">
                <i class="bi bi-arrow-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }}"></i>
            </a>
            <div>
                <h4 class="mb-1 fw-bold">{{ __('تعديل توصية العميل') }}</h4>
                <p class="text-muted mb-0 small">{{ __('تحديث بيانات العميل وتوصيته') }}</p>
            </div>
        </div>

        <form action="{{ route('crm.settings.testimonials.update', $testimonial) }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="row g-4">
                <div class="col-lg-8">
                    <div class="card border-0 shadow-sm mb-4 rounded-4">
                        <div class="card-header bg-transparent border-0 pt-4 px-4">
                            <h5 class="card-title mb-0 fw-bold">{{ __('بيانات التوصية') }}</h5>
                        </div>
                        <div class="card-body p-4 pt-2">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold small text-muted">{{ __('اسم العميل (بالعربية)') }} <span class="text-danger">*</span></label>
                                    <input type="text" name="name[ar]" class="form-control bg-light border-0 shadow-none" value="{{ $testimonial->getTranslation('name', 'ar', false) }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold small text-muted">{{ __('اسم العميل (بالإنجليزية)') }} <span class="text-danger">*</span></label>
                                    <input type="text" name="name[en]" class="form-control bg-light border-0 shadow-none" value="{{ $testimonial->getTranslation('name', 'en', false) }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold small text-muted">{{ __('المسمى الوظيفي (بالعربية)') }}</label>
                                    <input type="text" name="title[ar]" class="form-control bg-light border-0 shadow-none" value="{{ $testimonial->getTranslation('title', 'ar', false) }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold small text-muted">{{ __('المسمى الوظيفي (بالإنجليزية)') }}</label>
                                    <input type="text" name="title[en]" class="form-control bg-light border-0 shadow-none" value="{{ $testimonial->getTranslation('title', 'en', false) }}">
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label fw-bold small text-muted">{{ __('محتوى التوصية (بالعربية)') }} <span class="text-danger">*</span></label>
                                    <textarea name="content[ar]" class="form-control bg-light border-0 shadow-none" rows="4" required>{{ $testimonial->getTranslation('content', 'ar', false) }}</textarea>
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label fw-bold small text-muted">{{ __('محتوى التوصية (بالإنجليزية)') }} <span class="text-danger">*</span></label>
                                    <textarea name="content[en]" class="form-control bg-light border-0 shadow-none" rows="4" required>{{ $testimonial->getTranslation('content', 'en', false) }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm mb-4 rounded-4">
                        <div class="card-header bg-transparent border-0 pt-4 px-4">
                            <h5 class="card-title mb-0 fw-bold">{{ __('إعدادات إضافية') }}</h5>
                        </div>
                        <div class="card-body p-4 pt-2">
                            <div class="mb-4 text-center">
                                @if($testimonial->image)
                                    <div class="mb-2 p-2 bg-light rounded-4 d-inline-block border border-dashed">
                                        <img src="{{ asset('storage/' . $testimonial->image) }}" alt="User" class="rounded-circle object-fit-cover shadow-sm" width="80" height="80">
                                    </div>
                                    <label class="form-label fw-bold small text-muted d-block">{{ __('صورة العميل الحالية') }}</label>
                                @endif
                                <label class="form-label fw-bold small text-muted d-block text-start">{{ __('تغيير صورة العميل') }}</label>
                                <input type="file" name="image" class="form-control bg-light border-0 shadow-none" accept="image/*">
                            </div>

                            <div class="mb-4 text-center">
                                @if($testimonial->review_image)
                                    <div class="mb-2 p-2 bg-light rounded-4 d-block border border-dashed">
                                        <img src="{{ asset('storage/' . $testimonial->review_image) }}" alt="Review" class="rounded-3 object-fit-contain shadow-sm" style="max-width: 100%; max-height: 150px;">
                                    </div>
                                    <label class="form-label fw-bold small text-muted d-block">{{ __('صورة التقييم الحالية') }}</label>
                                @endif
                                <label class="form-label fw-bold small text-muted d-block text-start">{{ __('تغيير صورة التقييم / المحادثة') }}</label>
                                <input type="file" name="review_image" class="form-control bg-light border-0 shadow-none" accept="image/*">
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold small text-muted">{{ __('التقييم (1-5 نجوم)') }}</label>
                                <select name="rating" class="form-select bg-light border-0 shadow-none">
                                    @for($i=5; $i>=1; $i--)
                                        <option value="{{ $i }}" {{ $testimonial->rating == $i ? 'selected' : '' }}>{{ $i }} {{ __('نجوم') }}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="form-check form-switch p-3 bg-light rounded-3">
                                <input class="form-check-input {{ app()->getLocale() == 'ar' ? 'ms-0 me-2 float-none' : '' }}" type="checkbox" name="is_visible" value="1" id="isVisible" {{ $testimonial->is_visible ? 'checked' : '' }}>
                                <label class="form-check-label fw-bold ms-2" for="isVisible">{{ __('تفعيل العرض') }}</label>
                            </div>
                        </div>
                    </div>

                    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                        <div class="card-body p-4">
                            <button type="submit" class="btn btn-primary w-100 py-3 fw-bold rounded-3 shadow-sm">
                                <i class="bi bi-save me-1"></i> {{ __('حفظ التغييرات') }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

<style>
    .btn-white { background: #fff; }
    .shadow-xs { box-shadow: 0 1px 2px rgba(0,0,0,0.05); }
    .object-fit-cover { object-fit: cover; }
    .object-fit-contain { object-fit: contain; }
</style>
