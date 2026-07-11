@extends('partials.Layouts.crm-master')
@section('title', __('إضافة توصية') . ' | AutoCRM')

@section('content')
    <div class="container-fluid" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
        <div class="mb-4 d-flex align-items-center">
            <a href="{{ route('crm.settings.testimonials.index') }}" class="btn btn-sm btn-white border shadow-xs rounded-2 {{ app()->getLocale() == 'ar' ? 'ms-3' : 'me-3' }}">
                <i class="bi bi-arrow-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }}"></i>
            </a>
            <div>
                <h4 class="mb-1 fw-bold">{{ __('إضافة توصية عميل جديدة') }}</h4>
                <p class="text-muted mb-0 small">{{ __('أدخل بيانات العميل وتوصيته بلغتين') }}</p>
            </div>
        </div>

        <form action="{{ route('crm.settings.testimonials.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
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
                                    <input type="text" name="name[ar]" class="form-control bg-light border-0 shadow-none" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold small text-muted">{{ __('اسم العميل (بالإنجليزية)') }} <span class="text-danger">*</span></label>
                                    <input type="text" name="name[en]" class="form-control bg-light border-0 shadow-none" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold small text-muted">{{ __('المسمى الوظيفي (بالعربية)') }}</label>
                                    <input type="text" name="title[ar]" class="form-control bg-light border-0 shadow-none" placeholder="{{ __('عميل سعيد، مدير شركة...') }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold small text-muted">{{ __('المسمى الوظيفي (بالإنجليزية)') }}</label>
                                    <input type="text" name="title[en]" class="form-control bg-light border-0 shadow-none" placeholder="Happy Client, CEO...">
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label fw-bold small text-muted">{{ __('محتوى التوصية (بالعربية)') }} <span class="text-danger">*</span></label>
                                    <textarea name="content[ar]" class="form-control bg-light border-0 shadow-none" rows="4" required></textarea>
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label fw-bold small text-muted">{{ __('محتوى التوصية (بالإنجليزية)') }} <span class="text-danger">*</span></label>
                                    <textarea name="content[en]" class="form-control bg-light border-0 shadow-none" rows="4" required></textarea>
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
                            <div class="mb-3">
                                <label class="form-label fw-bold small text-muted">{{ __('صورة العميل') }}</label>
                                <input type="file" name="image" class="form-control bg-light border-0 shadow-none" accept="image/*">
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold small text-muted">{{ __('صورة التقييم / المحادثة') }}</label>
                                <input type="file" name="review_image" class="form-control bg-light border-0 shadow-none" accept="image/*">
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold small text-muted">{{ __('التقييم (1-5 نجوم)') }}</label>
                                <select name="rating" class="form-select bg-light border-0 shadow-none">
                                    <option value="5">5 {{ __('نجوم') }}</option>
                                    <option value="4">4 {{ __('نجوم') }}</option>
                                    <option value="3">3 {{ __('نجوم') }}</option>
                                    <option value="2">2 {{ __('نجوم') }}</option>
                                    <option value="1">1 {{ __('نجمة') }}</option>
                                </select>
                            </div>
                            <div class="form-check form-switch p-3 bg-light rounded-3">
                                <input class="form-check-input {{ app()->getLocale() == 'ar' ? 'ms-0 me-2 float-none' : '' }}" type="checkbox" name="is_visible" value="1" id="isVisible" checked>
                                <label class="form-check-label fw-bold ms-2" for="isVisible">{{ __('تفعيل العرض') }}</label>
                            </div>
                        </div>
                    </div>

                    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                        <div class="card-body p-4">
                            <button type="submit" class="btn btn-primary w-100 py-3 fw-bold rounded-3 shadow-sm">
                                <i class="bi bi-plus-circle me-1"></i> {{ __('إضافة التوصية') }}
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
</style>
