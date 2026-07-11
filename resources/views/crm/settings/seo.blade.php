@extends('partials.Layouts.crm-master')
@section('title', __('إعدادات SEO') . ' | AutoCRM')

@section('content')
    <div class="container-fluid" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
        <div class="mb-2">
            <h4 class="mb-1 fw-bold">{{ __('إعدادات تحسين محركات البحث (SEO)') }}</h4>
            <p class="text-muted mb-0 small">{{ __('إدارة الكلمات المفتاحية والأوصاف لمحركات البحث وأدوات التتبع') }}</p>
        </div>

        @include('partials.settings-subnav')

        <form action="{{ route('crm.settings.update') }}" method="POST">
            @csrf
            <div class="row g-4">
                <div class="col-lg-8">
                    <div class="card border-0 shadow-sm mb-4 rounded-4">
                        <div class="card-header bg-transparent border-0 pt-4 px-4">
                            <h5 class="card-title mb-0 fw-bold">{{ __('بيانات الميتا (Meta Tags)') }}</h5>
                        </div>
                        <div class="card-body p-4">
                            <div class="mb-3">
                                <label class="form-label fw-bold small text-muted">{{ __('العنوان الافتراضي للموقع (Meta Title)') }}</label>
                                <input type="text" name="meta_title" class="form-control bg-light border-0 shadow-none py-2" value="{{ $settings['meta_title'] ?? '' }}">
                                <small class="text-muted">{{ __('يظهر في عناوين صفحات المتصفح ومحركات البحث') }}</small>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold small text-muted">{{ __('الوصف الافتراضي (Meta Description)') }}</label>
                                <textarea name="meta_description" class="form-control bg-light border-0 shadow-none" rows="4">{{ $settings['meta_description'] ?? '' }}</textarea>
                                <small class="text-muted">{{ __('وصف مختصر يظهر في نتائج البحث (يفضل ألا يتجاوز 160 حرفاً)') }}</small>
                            </div>
                            <div class="mb-0">
                                <label class="form-label fw-bold small text-muted">{{ __('الكلمات المفتاحية (Keywords)') }}</label>
                                <textarea name="meta_keywords" class="form-control bg-light border-0 shadow-none" rows="3" placeholder="{{ __('سيارات، بيع سيارات، تقسيط...') }}">{{ $settings['meta_keywords'] ?? '' }}</textarea>
                                <small class="text-muted">{{ __('افصل بين الكلمات بفاصلة (,) ') }}</small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm mb-4 rounded-4">
                        <div class="card-header bg-transparent border-0 pt-4 px-4">
                            <h5 class="card-title mb-0 fw-bold">{{ __('تحليلات وأدوات التتبع') }}</h5>
                        </div>
                        <div class="card-body p-4">
                            @php
                                $gaId = $settings['google_analytics_id'] ?? '';
                                $pixelId = $settings['meta_pixel_id'] ?? '';
                            @endphp

                            <div class="mb-4">
                                <label class="form-label fw-bold small text-muted d-flex align-items-center gap-2">
                                    <i class="bi bi-google text-primary"></i>
                                    {{ __('معرف Google Analytics (GA4)') }}
                                    @if($gaId)
                                        <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-2 py-1 ms-auto" style="font-size:10px;">
                                            <i class="bi bi-check-circle-fill me-1"></i>{{ __('مفعل') }}
                                        </span>
                                    @else
                                        <span class="badge bg-secondary bg-opacity-10 text-secondary rounded-pill px-2 py-1 ms-auto" style="font-size:10px;">
                                            <i class="bi bi-dash-circle me-1"></i>{{ __('غير مفعل') }}
                                        </span>
                                    @endif
                                </label>
                                <input type="text" name="google_analytics_id"
                                    class="form-control bg-light border-0 shadow-none py-2"
                                    placeholder="G-XXXXXXXXXX"
                                    value="{{ $gaId }}" dir="ltr">
                                <small class="text-muted">{{ __('مثال: G-1234567890') }}</small>
                            </div>

                            <div class="mb-0">
                                <label class="form-label fw-bold small text-muted d-flex align-items-center gap-2">
                                    <i class="bi bi-facebook text-primary" style="color:#1877F2 !important;"></i>
                                    {{ __('معرف Meta Pixel (Facebook)') }}
                                    @if($pixelId)
                                        <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-2 py-1 ms-auto" style="font-size:10px;">
                                            <i class="bi bi-check-circle-fill me-1"></i>{{ __('مفعل') }}
                                        </span>
                                    @else
                                        <span class="badge bg-secondary bg-opacity-10 text-secondary rounded-pill px-2 py-1 ms-auto" style="font-size:10px;">
                                            <i class="bi bi-dash-circle me-1"></i>{{ __('غير مفعل') }}
                                        </span>
                                    @endif
                                </label>
                                <input type="text" name="meta_pixel_id"
                                    class="form-control bg-light border-0 shadow-none py-2"
                                    placeholder="1234567890"
                                    value="{{ $pixelId }}" dir="ltr">
                                <small class="text-muted">{{ __('مثال: 1234567890') }}</small>
                            </div>
                        </div>
                    </div>

                    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                        <div class="card-body p-4">
                            <button type="submit" class="btn btn-primary w-100 py-3 fw-bold rounded-3 shadow-sm">
                                <i class="bi bi-save me-1"></i> {{ __('حفظ الإعدادات') }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
