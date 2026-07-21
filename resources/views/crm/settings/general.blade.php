@extends('partials.Layouts.crm-master')
@section('title', __('إعدادات الموقع') . ' | GR Motors')

@section('content')
<div class="container-fluid" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">

    <div class="mb-4">
        <h4 class="mb-1 fw-bold">{{ __('إعدادات الموقع') }}</h4>
        <p class="text-muted mb-0 small">{{ __('تحكم في محتوى وإعدادات جميع صفحات الموقع من مكان واحد') }}</p>
    </div>

    @include('partials.settings-subnav')

    <form action="{{ route('crm.settings.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="hero_slides_submitted" value="1">

        <div class="row g-4 align-items-start">

            {{-- ===== LEFT NAV ===== --}}
            <div class="col-lg-3">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden sticky-top" style="top:80px;">
                    <div class="card-body p-2">

                        <p class="nav-group-label">{{ __('عام') }}</p>
                        <nav class="nav flex-column gap-1 mb-1">
                            <button type="button" class="settings-nav-btn active" data-tab="basic"><i class="bi bi-info-circle"></i> {{ __('المعلومات الأساسية') }}</button>
                            <button type="button" class="settings-nav-btn" data-tab="appearance"><i class="bi bi-palette"></i> {{ __('الشعار والمظهر') }}</button>
                            <button type="button" class="settings-nav-btn" data-tab="contact"><i class="bi bi-telephone"></i> {{ __('التواصل والشبكات') }}</button>
                            <button type="button" class="settings-nav-btn" data-tab="loader"><i class="bi bi-hourglass-split"></i> {{ __('شاشة التحميل') }}</button>
                            <button type="button" class="settings-nav-btn" data-tab="popup"><i class="bi bi-megaphone"></i> {{ __('Popup ترويجي') }}</button>
                        </nav>

                        <p class="nav-group-label">{{ __('الصفحة الرئيسية') }}</p>
                        <nav class="nav flex-column gap-1 mb-1">
                            <button type="button" class="settings-nav-btn" data-tab="home-hero"><i class="bi bi-image"></i> {{ __('هيرو الرئيسية') }}</button>
                            <button type="button" class="settings-nav-btn" data-tab="hero-slides"><i class="bi bi-images"></i> {{ __('شرائح الهيرو') }}</button>
                            <button type="button" class="settings-nav-btn" data-tab="homepage-featured"><i class="bi bi-star"></i> {{ __('القسم المميز') }}</button>
                            <button type="button" class="settings-nav-btn" data-tab="homepage-sections"><i class="bi bi-layout-text-window"></i> {{ __('نصوص الأقسام') }}</button>
                            <button type="button" class="settings-nav-btn" data-tab="homepage-stats"><i class="bi bi-bar-chart-line"></i> {{ __('الإحصائيات') }}</button>
                            <button type="button" class="settings-nav-btn" data-tab="finance-stats"><i class="bi bi-bar-chart-line"></i> {{ __('إحصائيات التمويل') }}</button>
                            <button type="button" class="settings-nav-btn" data-tab="bento"><i class="bi bi-grid-3x3-gap"></i> {{ __('معرض Bento') }}</button>
                        </nav>

                        <p class="nav-group-label">{{ __('صفحة السيارات') }}</p>
                        <nav class="nav flex-column gap-1 mb-1">
                            <button type="button" class="settings-nav-btn" data-tab="cars-hero"><i class="bi bi-image"></i> {{ __('هيرو صفحة السيارات') }}</button>
                            <button type="button" class="settings-nav-btn" data-tab="car-hero-ads"><i class="bi bi-car-front"></i> {{ __('إعلانات الهيرو') }}</button>
                        </nav>

                        <p class="nav-group-label">{{ __('صفحة العروض') }}</p>
                        <nav class="nav flex-column gap-1 mb-1">
                            <button type="button" class="settings-nav-btn" data-tab="offers-hero"><i class="bi bi-image"></i> {{ __('هيرو صفحة العروض') }}</button>
                        </nav>

                        <p class="nav-group-label">{{ __('صفحة من نحن') }}</p>
                        <nav class="nav flex-column gap-1 mb-1">
                            <button type="button" class="settings-nav-btn" data-tab="about-sections"><i class="bi bi-file-text"></i> {{ __('نصوص الأقسام') }}</button>
                            <button type="button" class="settings-nav-btn" data-tab="about-stats"><i class="bi bi-bar-chart-line"></i> {{ __('الإحصائيات') }}</button>
                            <button type="button" class="settings-nav-btn" data-tab="about-branches"><i class="bi bi-geo-alt"></i> {{ __('فروع التواجد') }}</button>
                        </nav>

                        <p class="nav-group-label">{{ __('صفحة الحجز') }}</p>
                        <nav class="nav flex-column gap-1">
                            <button type="button" class="settings-nav-btn" data-tab="booking-hero"><i class="bi bi-image"></i> {{ __('هيرو الحجز') }}</button>
                            <button type="button" class="settings-nav-btn" data-tab="booking-steps"><i class="bi bi-list-ol"></i> {{ __('خطوات الحجز') }}</button>
                            <button type="button" class="settings-nav-btn" data-tab="booking-sections"><i class="bi bi-layout-text-window"></i> {{ __('نصوص الأقسام') }}</button>
                        </nav>

                    </div>
                </div>
            </div>

            {{-- ===== CONTENT ===== --}}
            <div class="col-lg-6">
                <div id="settingsTabContent">

                    {{-- =============================== --}}
                    {{-- TAB: المعلومات الأساسية        --}}
                    {{-- =============================== --}}
                    <div class="settings-pane active" id="tab-basic">
                        <div class="card border-0 shadow-sm rounded-4">
                            <div class="card-header bg-transparent border-0 p-4 pb-0">
                                <h6 class="fw-bold mb-0">{{ __('المعلومات الأساسية') }}</h6>
                                <p class="text-muted small mb-0">{{ __('اسم الموقع ونص التذييل') }}</p>
                            </div>
                            <div class="card-body p-4">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold small text-muted">{{ __('اسم الموقع — عربي') }}</label>
                                        <input type="text" name="site_name[ar]" class="form-control bg-light border-0" value="{{ $settings['site_name']['ar'] ?? '' }}" placeholder="مثال: كنوز كار">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold small text-muted">{{ __('اسم الموقع — إنجليزي') }}</label>
                                        <input type="text" name="site_name[en]" class="form-control bg-light border-0" value="{{ $settings['site_name']['en'] ?? '' }}" placeholder="e.g.: Knooz Car">
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label fw-semibold small text-muted">{{ __('نص التذييل (Footer Text)') }}</label>
                                        <textarea name="footer_text" class="form-control bg-light border-0" rows="3" placeholder="{{ __('النص الذي يظهر في أسفل جميع الصفحات...') }}">{{ $settings['footer_text'] ?? '' }}</textarea>
                                    </div>
                                    <div class="col-12">
                                        <div class="d-flex align-items-center justify-content-between p-3 bg-light rounded-3">
                                            <div>
                                                <p class="fw-semibold mb-0 small">{{ __('التوزيع التلقائي للطلبات') }}</p>
                                                <p class="text-muted small mb-0">{{ __('توزيع طلبات الحجز تلقائياً (Round-Robin) على موظفي المبيعات') }}</p>
                                            </div>
                                            <div class="form-check form-switch fs-5 mb-0">
                                                <input type="hidden" name="auto_assign_bookings" value="0">
                                                <input class="form-check-input" type="checkbox" name="auto_assign_bookings" value="1" {{ ($settings['auto_assign_bookings'] ?? '0') == '1' ? 'checked' : '' }}>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- =============================== --}}
                    {{-- TAB: الشعار والمظهر            --}}
                    {{-- =============================== --}}
                    <div class="settings-pane d-none" id="tab-appearance">
                        <div class="card border-0 shadow-sm rounded-4">
                            <div class="card-header bg-transparent border-0 p-4 pb-0">
                                <h6 class="fw-bold mb-0">{{ __('الشعار والمظهر') }}</h6>
                                <p class="text-muted small mb-0">{{ __('اللوجو والأيقونة وخلفية الصفحات الداخلية') }}</p>
                            </div>
                            <div class="card-body p-4">
                                <div class="row g-4">
                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold small text-muted d-block mb-2">{{ __('شعار الموقع (Logo)') }}</label>
                                        <div class="upload-preview rounded-3 mb-2">
                                            @if(isset($settings['site_logo']))
                                                <img src="{{ asset('storage/' . $settings['site_logo']) }}" alt="Logo" class="img-fluid" style="max-height:60px;">
                                            @else
                                                <i class="bi bi-image fs-2 opacity-25"></i>
                                            @endif
                                        </div>
                                        <input type="file" name="site_logo" class="form-control bg-light border-0" accept="image/*">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold small text-muted d-block mb-2">{{ __('أيقونة (Favicon)') }}</label>
                                        <div class="upload-preview rounded-3 mb-2">
                                            @if(isset($settings['site_favicon']))
                                                <img src="{{ asset('storage/' . $settings['site_favicon']) }}" alt="Favicon" width="32">
                                            @else
                                                <i class="bi bi-app-indicator fs-2 opacity-25"></i>
                                            @endif
                                        </div>
                                        <input type="file" name="site_favicon" class="form-control bg-light border-0" accept="image/*">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold small text-muted d-block mb-2">{{ __('خلفية الصفحات (Breadcrumb)') }}</label>
                                        <div class="upload-preview rounded-3 mb-2 bg-dark">
                                            @if(isset($settings['breadcrumb_bg']))
                                                <img src="{{ asset('storage/' . $settings['breadcrumb_bg']) }}" class="img-fluid w-100 object-fit-cover rounded-3" style="max-height:80px;">
                                            @else
                                                <i class="bi bi-layout-text-window-reverse fs-2 text-white opacity-25"></i>
                                            @endif
                                        </div>
                                        <input type="file" name="breadcrumb_bg" class="form-control bg-light border-0" accept="image/*">
                                    </div>
                                    <div class="col-12">
                                        <div class="p-3 bg-info-subtle rounded-3 small text-info">
                                            <i class="bi bi-info-circle-fill me-1"></i>
                                            {{ __('خلفية الصفحات تظهر في صفحات: من نحن، العروض، المدونة، وغيرها.') }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- =============================== --}}
                    {{-- TAB: التواصل والشبكات          --}}
                    {{-- =============================== --}}
                    <div class="settings-pane d-none" id="tab-contact">
                        <div class="card border-0 shadow-sm rounded-4">
                            <div class="card-header bg-transparent border-0 p-4 pb-0">
                                <h6 class="fw-bold mb-0">{{ __('بيانات التواصل') }}</h6>
                            </div>
                            <div class="card-body p-4">
                                <div class="row g-3 mb-4">
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold small text-muted">{{ __('البريد الإلكتروني') }}</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-0"><i class="bi bi-envelope"></i></span>
                                            <input type="email" name="contact_email" class="form-control bg-light border-0" value="{{ $settings['contact_email'] ?? '' }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold small text-muted">{{ __('رقم الهاتف') }}</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-0"><i class="bi bi-telephone"></i></span>
                                            <input type="text" name="contact_phone" class="form-control bg-light border-0" value="{{ $settings['contact_phone'] ?? '' }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold small text-muted">{{ __('رقم الواتساب') }}</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-0"><i class="bi bi-whatsapp"></i></span>
                                            <input type="text" name="contact_whatsapp" class="form-control bg-light border-0" value="{{ $settings['contact_whatsapp'] ?? '' }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold small text-muted">{{ __('العنوان') }}</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-0"><i class="bi bi-geo-alt"></i></span>
                                            <input type="text" name="contact_address" class="form-control bg-light border-0" value="{{ $settings['contact_address'] ?? '' }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex align-items-center justify-content-between mb-3 border-top pt-3">
                                    <h6 class="fw-bold mb-0 small text-dark"><i class="bi bi-share me-2"></i>{{ __('روابط التواصل الاجتماعي') }}</h6>
                                    <button type="button" class="btn btn-sm btn-outline-primary rounded-pill px-3" onclick="addSocialRow()">
                                        <i class="bi bi-plus-lg me-1"></i> {{ __('إضافة') }}
                                    </button>
                                </div>

                                <div id="social-container" class="d-flex flex-column gap-2">
                                    @foreach($socialMedia as $idx => $social)
                                    <div class="social-row d-flex align-items-center gap-2 p-3 bg-light rounded-3" id="social-row-{{ $idx }}">
                                        <input type="text" name="social_icon[]" class="form-control border-0 bg-white shadow-none" placeholder="{{ __('bi-facebook') }}" value="{{ $social['icon'] ?? '' }}" style="max-width:150px;">
                                        <input type="color" name="social_color[]" class="form-control form-control-color border-0 bg-white shadow-none p-1" value="{{ $social['color'] ?? '#333333' }}" style="width:40px;height:38px;">
                                        <input type="url" name="social_link[]" class="form-control border-0 bg-white shadow-none text-start flex-grow-1" dir="ltr" placeholder="https://..." value="{{ $social['link'] ?? '' }}">
                                        <button type="button" class="btn btn-sm btn-light text-danger rounded-circle p-1 lh-1" onclick="removeSocialRow({{ $idx }})"><i class="bi bi-x-lg"></i></button>
                                    </div>
                                    @endforeach
                                </div>
                                <div id="no-social-msg" class="text-center py-4 bg-light rounded-3 {{ count($socialMedia) > 0 ? 'd-none' : '' }}">
                                    <span class="text-muted small">{{ __('لا توجد حسابات بعد') }}</span>
                                </div>
                                <p class="text-muted small mt-2 mb-0"><i class="bi bi-info-circle me-1"></i>{{ __('أيقونات Bootstrap Icons:') }} <code>bi-facebook</code>, <code>bi-instagram</code>, <code>bi-tiktok</code>…</p>
                            </div>
                        </div>
                    </div>

                    {{-- =============================== --}}
                    {{-- TAB: شاشة التحميل              --}}
                    {{-- =============================== --}}
                    <div class="settings-pane d-none" id="tab-loader">
                        <div class="card border-0 shadow-sm rounded-4">
                            <div class="card-header bg-transparent border-0 p-4 pb-0">
                                <h6 class="fw-bold mb-0">{{ __('شاشة التحميل') }}</h6>
                                <p class="text-muted small mb-0">{{ __('الشاشة التي تظهر أثناء تحميل الصفحة') }}</p>
                            </div>
                            <div class="card-body p-4">
                                <div class="d-flex align-items-center justify-content-between p-3 bg-light rounded-3 mb-4">
                                    <div>
                                        <p class="fw-semibold mb-0 small">{{ __('تفعيل شاشة التحميل') }}</p>
                                        <p class="text-muted small mb-0">{{ __('تظهر قبل اكتمال تحميل الصفحة') }}</p>
                                    </div>
                                    <div class="form-check form-switch fs-5 mb-0">
                                        <input class="form-check-input" type="checkbox" name="page_loader_enabled" value="1" {{ ($settings['page_loader_enabled'] ?? '1') == '1' ? 'checked' : '' }}>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold small text-muted d-block mb-2">{{ __('صورة / GIF التحميل') }}</label>
                                    <div class="upload-preview rounded-3 mb-2" style="background:#0f0f11;">
                                        @if(!empty($settings['page_loader_image']))
                                            <img src="{{ asset('storage/' . $settings['page_loader_image']) }}" style="max-height:80px;object-fit:contain;">
                                        @else
                                            <i class="bi bi-image fs-2 text-white opacity-25"></i>
                                        @endif
                                    </div>
                                    <input type="file" name="page_loader_image" class="form-control bg-light border-0" accept="image/*">
                                    <p class="text-muted small mt-1 mb-0">{{ __('PNG أو GIF متحرك') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- =============================== --}}
                    {{-- TAB: Popup ترويجي              --}}
                    {{-- =============================== --}}
                    <div class="settings-pane d-none" id="tab-popup">
                        @php
                            $promoPopup = isset($settings['promo_popup'])
                                ? (is_array($settings['promo_popup']) ? $settings['promo_popup'] : (json_decode($settings['promo_popup'], true) ?: []))
                                : [];
                        @endphp
                        <div class="card border-0 shadow-sm rounded-4">
                            <div class="card-header bg-transparent border-0 p-4 pb-0">
                                <h6 class="fw-bold mb-0">{{ __('Popup ترويجي') }}</h6>
                                <p class="text-muted small mb-0">{{ __('يظهر للزوار بعد 5 دقائق من التصفح') }}</p>
                            </div>
                            <div class="card-body p-4">
                                <div class="d-flex align-items-center justify-content-between p-3 bg-light rounded-3 mb-4">
                                    <p class="fw-semibold mb-0 small">{{ __('تفعيل الـ Popup') }}</p>
                                    <div class="form-check form-switch fs-5 mb-0">
                                        <input type="hidden" name="popup_enabled" value="0">
                                        <input class="form-check-input" type="checkbox" name="popup_enabled" value="1" {{ ($promoPopup['enabled'] ?? false) ? 'checked' : '' }}>
                                    </div>
                                </div>
                                <div class="row g-4">
                                    <div class="col-md-5">
                                        <label class="form-label fw-semibold small text-muted d-block mb-2">{{ __('صورة الـ Popup') }}</label>
                                        <div class="upload-preview rounded-3 mb-2" style="min-height:140px;">
                                            @if(!empty($promoPopup['image']))
                                                <img src="{{ asset('storage/' . $promoPopup['image']) }}" class="w-100 object-fit-cover rounded-3" style="max-height:140px;">
                                            @else
                                                <i class="bi bi-image fs-2 opacity-25"></i>
                                            @endif
                                        </div>
                                        <input type="file" name="popup_image" class="form-control bg-light border-0" accept="image/*">
                                    </div>
                                    <div class="col-md-7">
                                        <div class="row g-3">
                                            <div class="col-12">
                                                <label class="form-label fw-semibold small text-muted">{{ __('العنوان') }}</label>
                                                <input type="text" name="popup_title" class="form-control bg-light border-0" value="{{ $promoPopup['title'] ?? '' }}" placeholder="{{ __('عروض مميزة لهذا الشهر!') }}">
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label fw-semibold small text-muted">{{ __('نص الوصف') }}</label>
                                                <textarea name="popup_text" class="form-control bg-light border-0" rows="3" placeholder="{{ __('نص قصير جذاب...') }}">{{ $promoPopup['text'] ?? '' }}</textarea>
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label fw-semibold small text-muted">{{ __('رابط الزر') }}</label>
                                                <input type="text" name="popup_link" class="form-control bg-light border-0 text-start" dir="ltr" value="{{ $promoPopup['link'] ?? '' }}" placeholder="https://...">
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label fw-semibold small text-muted">{{ __('نص الزر') }}</label>
                                                <input type="text" name="popup_button_text" class="form-control bg-light border-0" value="{{ $promoPopup['button_text'] ?? __('تصفح العروض') }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- =============================== --}}
                    {{-- TAB: هيرو الرئيسية              --}}
                    {{-- =============================== --}}
                    <div class="settings-pane d-none" id="tab-home-hero">
                        <div class="card border-0 shadow-sm rounded-4">
                            <div class="card-header bg-transparent border-0 p-4 pb-0">
                                <h6 class="fw-bold mb-0">{{ __('هيرو الصفحة الرئيسية') }}</h6>
                                <p class="text-muted small mb-0">{{ __('العنوان والصورة التي تظهر في أعلى الصفحة الرئيسية') }}</p>
                            </div>
                            <div class="card-body p-4">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold small text-muted">{{ __('العنوان — عربي') }}</label>
                                        <input type="text" name="store_home_hero[title][ar]" class="form-control bg-light border-0" value="{{ $homeHero['title']['ar'] ?? '' }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold small text-muted">{{ __('العنوان — إنجليزي') }}</label>
                                        <input type="text" name="store_home_hero[title][en]" class="form-control bg-light border-0" value="{{ $homeHero['title']['en'] ?? '' }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold small text-muted">{{ __('الوصف — عربي') }}</label>
                                        <textarea name="store_home_hero[subtitle][ar]" rows="3" class="form-control bg-light border-0">{{ $homeHero['subtitle']['ar'] ?? '' }}</textarea>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold small text-muted">{{ __('الوصف — إنجليزي') }}</label>
                                        <textarea name="store_home_hero[subtitle][en]" rows="3" class="form-control bg-light border-0">{{ $homeHero['subtitle']['en'] ?? '' }}</textarea>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label fw-semibold small text-muted d-block mb-2">{{ __('صورة الهيرو') }}</label>
                                        @if(!empty($homeHero['image']))
                                            <div class="mb-2 rounded-3 overflow-hidden bg-light" style="max-height:120px;">
                                                <img src="{{ asset('storage/' . $homeHero['image']) }}" class="img-fluid w-100 object-fit-cover" style="max-height:120px;">
                                            </div>
                                            <input type="hidden" name="store_home_hero[image]" value="{{ $homeHero['image'] }}">
                                        @endif
                                        <input type="file" name="home_hero_image" class="form-control bg-light border-0" accept="image/*">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- =============================== --}}
                    {{-- TAB: شرائح الهيرو              --}}
                    {{-- =============================== --}}
                    <div class="settings-pane d-none" id="tab-hero-slides">
                        <div class="card border-0 shadow-sm rounded-4">
                            <div class="card-header bg-transparent border-0 p-4 pb-0 d-flex justify-content-between align-items-start">
                                <div>
                                    <h6 class="fw-bold mb-0">{{ __('شرائح الهيرو') }}</h6>
                                    <p class="text-muted small mb-0">{{ __('الصور الإعلانية في الصفحة الرئيسية') }}</p>
                                </div>
                                <button type="button" class="btn btn-sm btn-outline-primary rounded-pill px-3" onclick="addHeroSlide()">
                                    <i class="bi bi-plus-lg me-1"></i> {{ __('إضافة شريحة') }}
                                </button>
                            </div>
                            <div class="card-body p-4">
                                @php
                                    $heroSlides = isset($settings['hero_slides'])
                                        ? (is_array($settings['hero_slides']) ? $settings['hero_slides'] : (json_decode($settings['hero_slides'], true) ?: []))
                                        : [];
                                @endphp
                                <div id="hero-slides-container" class="d-flex flex-column gap-3">
                                    @foreach($heroSlides as $idx => $slide)
                                    <div class="hero-slide-item card border border-light-subtle rounded-3 shadow-sm" id="hero-slide-{{ $idx }}">
                                        <div class="card-body p-3">
                                            <div class="d-flex justify-content-between align-items-center mb-3">
                                                <span class="small fw-semibold text-muted">{{ __('شريحة') }} {{ $idx + 1 }}</span>
                                                <button type="button" class="btn btn-sm btn-light text-danger rounded-circle lh-1 p-1" onclick="removeHeroSlide({{ $idx }})"><i class="bi bi-x-lg"></i></button>
                                            </div>
                                            <div class="row g-3">
                                                <div class="col-md-4">
                                                    <input type="hidden" name="hero_slides[{{ $idx }}][image_path]" value="{{ $slide['image'] ?? '' }}">
                                                    @if(isset($slide['image']))
                                                    <div class="rounded-3 overflow-hidden mb-2" style="height:90px;"><img src="{{ asset('storage/' . $slide['image']) }}" class="w-100 h-100 object-fit-cover"></div>
                                                    @endif
                                                    <input type="file" name="hero_slides[{{ $idx }}][image]" class="form-control bg-light border-0 form-control-sm" accept="image/*">
                                                </div>
                                                <div class="col-md-8">
                                                    <div class="row g-2">
                                                        <div class="col-12">
                                                            <label class="form-label fw-semibold small text-muted mb-1">{{ __('الرابط') }}</label>
                                                            <input type="url" name="hero_slides[{{ $idx }}][link]" class="form-control bg-light border-0 text-start form-control-sm" dir="ltr" value="{{ $slide['link'] ?? '' }}" placeholder="https://...">
                                                        </div>
                                                        <div class="col-12">
                                                            <label class="form-label fw-semibold small text-muted mb-1">{{ __('نص الزر') }}</label>
                                                            <input type="text" name="hero_slides[{{ $idx }}][button_text]" class="form-control bg-light border-0 form-control-sm" value="{{ $slide['button_text'] ?? __('اكتشف السيارات') }}">
                                                        </div>
                                                        <div class="col-12">
                                                            <label class="form-label fw-semibold small text-muted mb-1">{{ __('نص الزر 2') }}</label>
                                                            <input type="text" name="hero_slides[{{ $idx }}][button_2_text]" class="form-control bg-light border-0 form-control-sm" value="{{ $slide['button_2_text'] ?? '' }}">
                                                        </div>
                                                        <div class="col-12">
                                                            <label class="form-label fw-semibold small text-muted mb-1">{{ __('رابط الزر 2') }}</label>
                                                            <input type="url" name="hero_slides[{{ $idx }}][link_2]" class="form-control bg-light border-0 text-start form-control-sm" dir="ltr" value="{{ $slide['link_2'] ?? '' }}" placeholder="https://...">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                <div id="no-slides-msg" class="text-center py-5 bg-light rounded-3 {{ count($heroSlides) > 0 ? 'd-none' : '' }}">
                                    <i class="bi bi-images fs-1 text-muted opacity-25 d-block mb-1"></i>
                                    <span class="text-muted small">{{ __('لا توجد شرائح. اضغط "إضافة شريحة" للبدء.') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- =============================== --}}
                    {{-- TAB: القسم المميز              --}}
                    {{-- =============================== --}}
                    <div class="settings-pane d-none" id="tab-homepage-featured">
                        @php $featured = $settings['homepage_featured'] ?? []; @endphp
                        <div class="card border-0 shadow-sm rounded-4">
                            <div class="card-header bg-transparent border-0 p-4 pb-0">
                                <h6 class="fw-bold mb-0">{{ __('القسم المميز') }}</h6>
                                <p class="text-muted small mb-0">{{ __('البطل الرئيسي في الصفحة الرئيسية') }}</p>
                            </div>
                            <div class="card-body p-4">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold small text-muted">{{ __('العنوان') }} — {{ __('عربي') }}</label>
                                        <input type="text" name="homepage_featured[title][ar]" class="form-control bg-light border-0" value="{{ $featured['title']['ar'] ?? '' }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold small text-muted">{{ __('العنوان') }} — {{ __('إنجليزي') }}</label>
                                        <input type="text" name="homepage_featured[title][en]" class="form-control bg-light border-0" value="{{ $featured['title']['en'] ?? '' }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold small text-muted">{{ __('الوصف') }} — {{ __('عربي') }}</label>
                                        <textarea name="homepage_featured[description][ar]" class="form-control bg-light border-0" rows="3">{{ $featured['description']['ar'] ?? '' }}</textarea>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold small text-muted">{{ __('الوصف') }} — {{ __('إنجليزي') }}</label>
                                        <textarea name="homepage_featured[description][en]" class="form-control bg-light border-0" rows="3">{{ $featured['description']['en'] ?? '' }}</textarea>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold small text-muted">{{ __('السيارة المميزة') }}</label>
                                        <select name="homepage_featured[car_id]" class="form-select bg-light border-0">
                                            <option value="">{{ __('-- اختر سيارة --') }}</option>
                                            @foreach($cars as $car)
                                                <option value="{{ $car->id }}" {{ ($featured['car_id'] ?? '') == $car->id ? 'selected' : '' }}>{{ $car->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold small text-muted">{{ __('العرض المميز') }}</label>
                                        <select name="homepage_featured[offer_id]" class="form-select bg-light border-0">
                                            <option value="">{{ __('-- اختر عرض --') }}</option>
                                            @foreach($offers as $offer)
                                                <option value="{{ $offer->id }}" {{ ($featured['offer_id'] ?? '') == $offer->id ? 'selected' : '' }}>{{ $offer->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- =============================== --}}
                    {{-- TAB: نصوص أقسام الرئيسية       --}}
                    {{-- =============================== --}}
                    <div class="settings-pane d-none" id="tab-homepage-sections">
                        @php $sec = $homepageSections; @endphp
                        <div class="d-flex flex-column gap-3">

                            @php
                                $hSections = [
                                    ['id' => 'filter',           'icon' => 'bi-search',          'label' => __('قسم البحث والتصفية'),          'fields' => ['title']],
                                    ['id' => 'featured_cars',    'icon' => 'bi-star',             'label' => __('السيارات المميزة'),             'fields' => ['badge','title','subtitle','button_text']],
                                    ['id' => 'offers',           'icon' => 'bi-tag',              'label' => __('العروض'),                      'fields' => ['badge','title','button_text']],
                                    ['id' => 'highlighted_cars', 'icon' => 'bi-car-front',        'label' => __('السيارات البارزة'),            'fields' => ['badge','title','subtitle','button_text']],
                                    ['id' => 'finance',          'icon' => 'bi-currency-dollar',  'label' => __('قسم التمويل'),                 'fields' => ['badge','title','subtitle','features','button_text']],
                                    ['id' => 'brands',           'icon' => 'bi-award',            'label' => __('الماركات'),                    'fields' => ['title','subtitle']],
                                    ['id' => 'budget',           'icon' => 'bi-wallet2',          'label' => __('قسم الميزانية'),               'fields' => ['badge','title','description','button_text']],
                                ];
                                $hFieldLabels = [
                                    'badge'       => __('الشارة (Badge)'),
                                    'title'       => __('العنوان'),
                                    'subtitle'    => __('الوصف'),
                                    'description' => __('الوصف'),
                                    'button_text' => __('نص الزر'),
                                    'features'    => __('النقاط (سطر لكل نقطة)'),
                                ];
                                $isTextarea = ['subtitle', 'description', 'features'];
                            @endphp

                            @foreach($hSections as $hIdx => $hSec)
                            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                                <button type="button" class="btn text-start p-4 d-flex align-items-center gap-3 collapsed-section-toggle border-0 bg-white rounded-4" onclick="toggleSection('h-{{ $hSec['id'] }}', this)">
                                    <i class="bi {{ $hSec['icon'] }} text-danger"></i>
                                    <span class="fw-semibold">{{ $hSec['label'] }}</span>
                                    <i class="bi bi-chevron-down ms-auto text-muted small toggle-chevron"></i>
                                </button>
                                <div class="section-body {{ $hIdx === 0 ? '' : 'd-none' }} border-top" id="h-{{ $hSec['id'] }}">
                                    <div class="p-4">
                                        <div class="row g-3">
                                            @foreach($hSec['fields'] as $field)
                                            @php $isTA = in_array($field, $isTextarea); @endphp
                                            <div class="col-md-6">
                                                <label class="form-label fw-semibold small text-muted">{{ $hFieldLabels[$field] }} — {{ __('عربي') }}</label>
                                                @if($isTA)
                                                    <textarea name="homepage_sections[{{ $hSec['id'] }}][{{ $field }}][ar]" class="form-control bg-light border-0" rows="3">{{ $sec[$hSec['id']][$field]['ar'] ?? '' }}</textarea>
                                                @else
                                                    <input type="text" name="homepage_sections[{{ $hSec['id'] }}][{{ $field }}][ar]" class="form-control bg-light border-0" value="{{ $sec[$hSec['id']][$field]['ar'] ?? '' }}">
                                                @endif
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label fw-semibold small text-muted">{{ $hFieldLabels[$field] }} — {{ __('إنجليزي') }}</label>
                                                @if($isTA)
                                                    <textarea name="homepage_sections[{{ $hSec['id'] }}][{{ $field }}][en]" class="form-control bg-light border-0" rows="3">{{ $sec[$hSec['id']][$field]['en'] ?? '' }}</textarea>
                                                @else
                                                    <input type="text" name="homepage_sections[{{ $hSec['id'] }}][{{ $field }}][en]" class="form-control bg-light border-0" value="{{ $sec[$hSec['id']][$field]['en'] ?? '' }}">
                                                @endif
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach

                        </div>
                    </div>

                    {{-- =============================== --}}
                    {{-- TAB: إحصائيات الرئيسية         --}}
                    {{-- =============================== --}}
                    <div class="settings-pane d-none" id="tab-homepage-stats">
                        <div class="card border-0 shadow-sm rounded-4">
                            <div class="card-header bg-transparent border-0 p-4 pb-0 d-flex justify-content-between align-items-start">
                                <div>
                                    <h6 class="fw-bold mb-0">{{ __('إحصائيات الصفحة الرئيسية') }}</h6>
                                    <p class="text-muted small mb-0">{{ __('الأرقام التي تظهر في قسم الإنجازات') }}</p>
                                </div>
                                <button type="button" class="btn btn-sm btn-outline-primary rounded-pill px-3" onclick="addStatRow('stats', 'stat_value', 'stat_label')">
                                    <i class="bi bi-plus-lg me-1"></i> {{ __('إضافة') }}
                                </button>
                            </div>
                            <div class="card-body p-4">
                                <div id="stats-container" class="d-flex flex-column gap-2">
                                    @foreach($homepageStats as $idx => $stat)
                                    <div class="stat-row d-flex align-items-center gap-2 p-3 bg-light rounded-3" id="stat-row-{{ $idx }}">
                                        <input type="text" name="stat_value[]" class="form-control border-0 bg-white fw-bold text-center" value="{{ $stat['value'] ?? '' }}" placeholder="+500" style="max-width:90px;">
                                        <input type="text" name="stat_label[]" class="form-control border-0 bg-white flex-grow-1" value="{{ $stat['label'] ?? '' }}" placeholder="{{ __('التسمية') }}">
                                        <button type="button" class="btn btn-sm btn-light text-danger rounded-circle lh-1 p-1" onclick="removeStatRow({{ $idx }}, 'stat-row')"><i class="bi bi-x-lg"></i></button>
                                    </div>
                                    @endforeach
                                </div>
                                <div id="no-stats-msg" class="text-center py-4 bg-light rounded-3 {{ count($homepageStats) > 0 ? 'd-none' : '' }}">
                                    <span class="text-muted small">{{ __('لا توجد إحصائيات بعد') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- =============================== --}}
                    {{-- TAB: إحصائيات التمويل           --}}
                    {{-- =============================== --}}
                    <div class="settings-pane d-none" id="tab-finance-stats">
                        <div class="card border-0 shadow-sm rounded-4">
                            <div class="card-header bg-transparent border-0 p-4 pb-0 d-flex justify-content-between align-items-start">
                                <div>
                                    <h6 class="fw-bold mb-0">{{ __('إحصائيات قسم التمويل') }}</h6>
                                    <p class="text-muted small mb-0">{{ __('الأرقام التي تظهر في قسم حلول التمويل') }}</p>
                                </div>
                                <button type="button" class="btn btn-sm btn-outline-primary rounded-pill px-3" onclick="addFinanceStatRow()">
                                    <i class="bi bi-plus-lg me-1"></i> {{ __('إضافة') }}
                                </button>
                            </div>
                            <div class="card-body p-4">
                                <div id="finance-stats-container" class="d-flex flex-column gap-2">
                                    @foreach($financeStats as $idx => $stat)
                                    <div class="finance-stat-row d-flex align-items-center gap-2 p-3 bg-light rounded-3" id="finance-stat-row-{{ $idx }}">
                                        <input type="text" name="finance_stat_value[]" class="form-control border-0 bg-white fw-bold text-center" value="{{ $stat['value'] ?? '' }}" placeholder="500" style="max-width:90px;">
                                        <input type="text" name="finance_stat_label[]" class="form-control border-0 bg-white flex-grow-1" value="{{ $stat['label'] ?? '' }}" placeholder="{{ __('التسمية') }}">
                                        <button type="button" class="btn btn-sm btn-light text-danger rounded-circle lh-1 p-1" onclick="removeFinanceStatRow({{ $idx }})"><i class="bi bi-x-lg"></i></button>
                                    </div>
                                    @endforeach
                                </div>
                                <div id="no-finance-stats-msg" class="text-center py-4 bg-light rounded-3 {{ count($financeStats) > 0 ? 'd-none' : '' }}">
                                    <span class="text-muted small">{{ __('لا توجد إحصائيات بعد') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- =============================== --}}
                    {{-- TAB: معرض Bento                 --}}
                    {{-- =============================== --}}
                    <div class="settings-pane d-none" id="tab-bento">
                        <div class="d-flex flex-column gap-4">
                            <div class="card border-0 shadow-sm rounded-4">
                                <div class="card-header bg-transparent border-0 p-4 pb-0">
                                    <h6 class="fw-bold mb-0">{{ __('سيارات Bento') }}</h6>
                                    <p class="text-muted small mb-0">{{ __('اختر 3-5 سيارات مميزة لعرضها في الرئيسية') }}</p>
                                </div>
                                <div class="card-body p-4">
                                    <select name="bento_cars[]" class="form-select bg-light border-0" multiple style="min-height:220px;">
                                        @foreach($cars as $car)
                                            <option value="{{ $car->id }}" {{ in_array($car->id, $bentoCars) ? 'selected' : '' }}>{{ $car->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="card border-0 shadow-sm rounded-4">
                                <div class="card-header bg-transparent border-0 p-4 pb-0 d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="fw-bold mb-0">{{ __('المعرض الرئيسي') }}</h6>
                                        <p class="text-muted small mb-0">{{ __('صور صفحة من نحن') }}</p>
                                    </div>
                                    <span class="badge bg-light text-muted rounded-pill px-3">{{ count($settings['main_gallery'] ?? []) }} {{ __('صورة') }}</span>
                                </div>
                                <div class="card-body p-4">
                                    <input type="file" name="main_gallery[]" class="form-control bg-light border-0 mb-4" multiple accept="image/*">
                                    @if(!empty($settings['main_gallery']))
                                        @php $gallery = is_array($settings['main_gallery']) ? $settings['main_gallery'] : (json_decode($settings['main_gallery'], true) ?: []); @endphp
                                        <div class="row g-2">
                                            @foreach($gallery as $img)
                                            <div class="col-4 col-md-3 position-relative">
                                                <div class="rounded-3 overflow-hidden" style="height:100px;">
                                                    <img src="{{ asset('storage/' . $img) }}" class="w-100 h-100 object-fit-cover">
                                                </div>
                                                <button type="submit" name="delete_gallery_image" value="{{ $img }}" class="btn btn-danger btn-sm rounded-circle position-absolute top-0 end-0 m-1 lh-1 p-1" onclick="return confirm('{{ __('حذف هذه الصورة؟') }}')" style="width:24px;height:24px;font-size:11px;"><i class="bi bi-x"></i></button>
                                            </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <div class="text-center py-4 bg-light rounded-3">
                                            <span class="text-muted small">{{ __('لا توجد صور بعد') }}</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- =============================== --}}
                    {{-- TAB: هيرو صفحة السيارات         --}}
                    {{-- =============================== --}}
                    <div class="settings-pane d-none" id="tab-cars-hero">
                        <div class="card border-0 shadow-sm rounded-4">
                            <div class="card-header bg-transparent border-0 p-4 pb-0">
                                <h6 class="fw-bold mb-0">{{ __('هيرو صفحة السيارات') }}</h6>
                                <p class="text-muted small mb-0">{{ __('العنوان والصورة التي تظهر في أعلى صفحة كل السيارات') }}</p>
                            </div>
                            <div class="card-body p-4">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold small text-muted">{{ __('العنوان — عربي') }}</label>
                                        <input type="text" name="store_hero[title][ar]" class="form-control bg-light border-0" value="{{ $carsHero['title']['ar'] ?? '' }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold small text-muted">{{ __('العنوان — إنجليزي') }}</label>
                                        <input type="text" name="store_hero[title][en]" class="form-control bg-light border-0" value="{{ $carsHero['title']['en'] ?? '' }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold small text-muted">{{ __('الوصف — عربي') }}</label>
                                        <textarea name="store_hero[subtitle][ar]" rows="3" class="form-control bg-light border-0">{{ $carsHero['subtitle']['ar'] ?? '' }}</textarea>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold small text-muted">{{ __('الوصف — إنجليزي') }}</label>
                                        <textarea name="store_hero[subtitle][en]" rows="3" class="form-control bg-light border-0">{{ $carsHero['subtitle']['en'] ?? '' }}</textarea>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label fw-semibold small text-muted d-block mb-2">{{ __('صورة الهيرو') }}</label>
                                        @if(!empty($carsHero['image']))
                                            <div class="mb-2 rounded-3 overflow-hidden bg-light" style="max-height:120px;">
                                                <img src="{{ asset('storage/' . $carsHero['image']) }}" class="img-fluid w-100 object-fit-cover" style="max-height:120px;">
                                            </div>
                                            <input type="hidden" name="store_hero[image]" value="{{ $carsHero['image'] }}">
                                        @endif
                                        <input type="file" name="cars_hero_image" class="form-control bg-light border-0" accept="image/*">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- =============================== --}}
                    {{-- TAB: إعلانات هيرو السيارات      --}}
                    {{-- =============================== --}}
                    <div class="settings-pane d-none" id="tab-car-hero-ads">
                        <div class="card border-0 shadow-sm rounded-4">
                            <div class="card-header bg-transparent border-0 p-4 pb-0">
                                <h6 class="fw-bold mb-0">{{ __('إعلانات هيرو صفحة السيارات') }}</h6>
                                <p class="text-muted small mb-0">{{ __('البانرات الإعلانية التي تظهر في أعلى صفحة السيارات') }}</p>
                            </div>
                            <div class="card-body p-4">
                                <div class="row g-4">
                                    @foreach([1, 2] as $adNum)
                                    <div class="col-md-6">
                                        <div class="p-3 bg-light rounded-3">
                                            <p class="fw-semibold small mb-3">{{ __('إعلان') }} {{ $adNum }}</p>
                                            <label class="form-label fw-semibold small text-muted d-block mb-2">{{ __('الصورة') }}</label>
                                            <div class="upload-preview rounded-3 mb-2" style="min-height:100px;">
                                                @if(!empty($settings['hero_ad_' . $adNum . '_image']))
                                                    <img src="{{ asset('storage/' . $settings['hero_ad_' . $adNum . '_image']) }}" class="w-100 object-fit-cover rounded-3" style="max-height:100px;">
                                                @else
                                                    <i class="bi bi-image fs-2 opacity-25"></i>
                                                @endif
                                            </div>
                                            <input type="file" name="hero_ad_{{ $adNum }}_image" class="form-control bg-white border-0 mb-2 form-control-sm" accept="image/*">
                                            <label class="form-label fw-semibold small text-muted">{{ __('الرابط') }}</label>
                                            <input type="url" name="hero_ad_{{ $adNum }}_link" class="form-control bg-white border-0 text-start form-control-sm" dir="ltr" value="{{ $settings['hero_ad_' . $adNum . '_link'] ?? '' }}" placeholder="https://...">
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- =============================== --}}
                    {{-- TAB: هيرو صفحة العروض           --}}
                    {{-- =============================== --}}
                    <div class="settings-pane d-none" id="tab-offers-hero">
                        <div class="card border-0 shadow-sm rounded-4">
                            <div class="card-header bg-transparent border-0 p-4 pb-0">
                                <h6 class="fw-bold mb-0">{{ __('هيرو صفحة العروض') }}</h6>
                                <p class="text-muted small mb-0">{{ __('العنوان والصورة التي تظهر في أعلى صفحة العروض') }}</p>
                            </div>
                            <div class="card-body p-4">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold small text-muted">{{ __('العنوان — عربي') }}</label>
                                        <input type="text" name="store_offers_hero[title][ar]" class="form-control bg-light border-0" value="{{ $offersHero['title']['ar'] ?? '' }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold small text-muted">{{ __('العنوان — إنجليزي') }}</label>
                                        <input type="text" name="store_offers_hero[title][en]" class="form-control bg-light border-0" value="{{ $offersHero['title']['en'] ?? '' }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold small text-muted">{{ __('الوصف — عربي') }}</label>
                                        <textarea name="store_offers_hero[subtitle][ar]" rows="3" class="form-control bg-light border-0">{{ $offersHero['subtitle']['ar'] ?? '' }}</textarea>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold small text-muted">{{ __('الوصف — إنجليزي') }}</label>
                                        <textarea name="store_offers_hero[subtitle][en]" rows="3" class="form-control bg-light border-0">{{ $offersHero['subtitle']['en'] ?? '' }}</textarea>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label fw-semibold small text-muted d-block mb-2">{{ __('صورة الهيرو') }}</label>
                                        @if(!empty($offersHero['image']))
                                            <div class="mb-2 rounded-3 overflow-hidden bg-light" style="max-height:120px;">
                                                <img src="{{ asset('storage/' . $offersHero['image']) }}" class="img-fluid w-100 object-fit-cover" style="max-height:120px;">
                                            </div>
                                            <input type="hidden" name="store_offers_hero[image]" value="{{ $offersHero['image'] }}">
                                        @endif
                                        <input type="file" name="offers_hero_image" class="form-control bg-light border-0" accept="image/*">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- =============================== --}}
                    {{-- TAB: أقسام صفحة من نحن         --}}
                    {{-- =============================== --}}
                    <div class="settings-pane d-none" id="tab-about-sections">
                        @php $asec = $aboutSections; @endphp
                        <div class="d-flex flex-column gap-3">

                            @php
                                $aboutSectionsDef = [
                                    [
                                        'id' => 'hero', 'icon' => 'bi-house', 'label' => __('قسم الهيرو'),
                                        'fields' => ['badge','title','subtitle'],
                                        'fieldLabels' => ['badge' => __('الشارة'), 'title' => __('العنوان'), 'subtitle' => __('الوصف')],
                                        'textarea' => ['subtitle'],
                                    ],
                                    [
                                        'id' => 'story', 'icon' => 'bi-book', 'label' => __('قصة الشركة'),
                                        'fields' => ['title','content','mission_title','mission_text','vision_title','vision_text'],
                                        'fieldLabels' => ['title' => __('عنوان القسم'), 'content' => __('النص'), 'mission_title' => __('عنوان الرسالة'), 'mission_text' => __('نص الرسالة'), 'vision_title' => __('عنوان الرؤية'), 'vision_text' => __('نص الرؤية')],
                                        'textarea' => ['content','mission_text','vision_text'],
                                    ],
                                    [
                                        'id' => 'partners', 'icon' => 'bi-briefcase', 'label' => __('قسم الشركاء'),
                                        'fields' => ['badge','title','subtitle'],
                                        'fieldLabels' => ['badge' => __('الشارة'), 'title' => __('العنوان'), 'subtitle' => __('الوصف')],
                                        'textarea' => ['subtitle'],
                                    ],
                                    [
                                        'id' => 'dealer', 'icon' => 'bi-handshake', 'label' => __('قسم الموزعين'),
                                        'fields' => ['title','description','partner_button_text','contact_button_text'],
                                        'fieldLabels' => ['title' => __('العنوان'), 'description' => __('الوصف'), 'partner_button_text' => __('نص زر الشراكة'), 'contact_button_text' => __('نص زر التواصل')],
                                        'textarea' => ['description'],
                                        'plain_fields' => ['partner_button_link' => __('رابط زر الشراكة')],
                                    ],
                                    [
                                        'id' => 'locations', 'icon' => 'bi-geo-alt', 'label' => __('قسم المواقع'),
                                        'fields' => ['title'],
                                        'fieldLabels' => ['title' => __('العنوان')],
                                        'textarea' => [],
                                    ],
                                    [
                                        'id' => 'testimonials', 'icon' => 'bi-chat-quote', 'label' => __('قسم التقييمات'),
                                        'fields' => ['badge','title','rating_text'],
                                        'fieldLabels' => ['badge' => __('الشارة'), 'title' => __('العنوان'), 'rating_text' => __('نص التقييم')],
                                        'textarea' => [],
                                    ],
                                ];
                            @endphp

                            @foreach($aboutSectionsDef as $aIdx => $aDef)
                            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                                <button type="button" class="btn text-start p-4 d-flex align-items-center gap-3 collapsed-section-toggle border-0 bg-white rounded-4" onclick="toggleSection('a-{{ $aDef['id'] }}', this)">
                                    <i class="bi {{ $aDef['icon'] }} text-danger"></i>
                                    <span class="fw-semibold">{{ $aDef['label'] }}</span>
                                    <i class="bi bi-chevron-down ms-auto text-muted small toggle-chevron"></i>
                                </button>
                                <div class="section-body {{ $aIdx === 0 ? '' : 'd-none' }} border-top" id="a-{{ $aDef['id'] }}">
                                    <div class="p-4">
                                        <div class="row g-3">
                                            @foreach($aDef['fields'] as $aField)
                                            @php $isTA = in_array($aField, $aDef['textarea']); @endphp
                                            <div class="col-md-6">
                                                <label class="form-label fw-semibold small text-muted">{{ $aDef['fieldLabels'][$aField] }} — {{ __('عربي') }}</label>
                                                @if($isTA)
                                                    <textarea name="about_sections[{{ $aDef['id'] }}][{{ $aField }}][ar]" class="form-control bg-light border-0" rows="3">{{ $asec[$aDef['id']][$aField]['ar'] ?? '' }}</textarea>
                                                @else
                                                    <input type="text" name="about_sections[{{ $aDef['id'] }}][{{ $aField }}][ar]" class="form-control bg-light border-0" value="{{ $asec[$aDef['id']][$aField]['ar'] ?? '' }}">
                                                @endif
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label fw-semibold small text-muted">{{ $aDef['fieldLabels'][$aField] }} — {{ __('إنجليزي') }}</label>
                                                @if($isTA)
                                                    <textarea name="about_sections[{{ $aDef['id'] }}][{{ $aField }}][en]" class="form-control bg-light border-0" rows="3">{{ $asec[$aDef['id']][$aField]['en'] ?? '' }}</textarea>
                                                @else
                                                    <input type="text" name="about_sections[{{ $aDef['id'] }}][{{ $aField }}][en]" class="form-control bg-light border-0" value="{{ $asec[$aDef['id']][$aField]['en'] ?? '' }}">
                                                @endif
                                            </div>
                                            @endforeach

                                            @if(!empty($aDef['plain_fields']))
                                                @foreach($aDef['plain_fields'] as $pKey => $pLabel)
                                                <div class="col-12">
                                                    <label class="form-label fw-semibold small text-muted">{{ $pLabel }}</label>
                                                    <input type="text" name="about_sections[{{ $aDef['id'] }}][{{ $pKey }}]" class="form-control bg-light border-0 text-start" dir="ltr" value="{{ $asec[$aDef['id']][$pKey] ?? '' }}" placeholder="https://...">
                                                </div>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach

                        </div>
                    </div>

                    {{-- =============================== --}}
                    {{-- TAB: إحصائيات من نحن           --}}
                    {{-- =============================== --}}
                    <div class="settings-pane d-none" id="tab-about-stats">
                        <div class="card border-0 shadow-sm rounded-4">
                            <div class="card-header bg-transparent border-0 p-4 pb-0 d-flex justify-content-between align-items-start">
                                <div>
                                    <h6 class="fw-bold mb-0">{{ __('إحصائيات صفحة من نحن') }}</h6>
                                    <p class="text-muted small mb-0">{{ __('الأرقام التي تظهر في هيرو صفحة من نحن') }}</p>
                                </div>
                                <button type="button" class="btn btn-sm btn-outline-primary rounded-pill px-3" onclick="addAboutStatRow()">
                                    <i class="bi bi-plus-lg me-1"></i> {{ __('إضافة') }}
                                </button>
                            </div>
                            <div class="card-body p-4">
                                <div id="about-stats-container" class="d-flex flex-column gap-2">
                                    @foreach($aboutStats as $idx => $stat)
                                    <div class="about-stat-row d-flex align-items-center gap-2 p-3 bg-light rounded-3" id="about-stat-row-{{ $idx }}">
                                        <input type="text" name="about_stat_value[]" class="form-control border-0 bg-white fw-bold text-center" value="{{ $stat['value'] ?? '' }}" placeholder="+500" style="max-width:90px;">
                                        <input type="text" name="about_stat_label[]" class="form-control border-0 bg-white flex-grow-1" value="{{ $stat['label'] ?? '' }}" placeholder="{{ __('التسمية') }}">
                                        <button type="button" class="btn btn-sm btn-light text-danger rounded-circle lh-1 p-1" onclick="removeAboutStatRow({{ $idx }})"><i class="bi bi-x-lg"></i></button>
                                    </div>
                                    @endforeach
                                </div>
                                <div id="no-about-stats-msg" class="text-center py-4 bg-light rounded-3 {{ count($aboutStats) > 0 ? 'd-none' : '' }}">
                                    <span class="text-muted small">{{ __('لا توجد إحصائيات بعد') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- =============================== --}}
                    {{-- TAB: فروع التواجد               --}}
                    {{-- =============================== --}}
                    <div class="settings-pane d-none" id="tab-about-branches">
                        <div class="card border-0 shadow-sm rounded-4">
                            <div class="card-header bg-transparent border-0 p-4 pb-0 d-flex justify-content-between align-items-start">
                                <div>
                                    <h6 class="fw-bold mb-0">{{ __('فروع التواجد') }}</h6>
                                    <p class="text-muted small mb-0">{{ __('مواقع الفروع التي تظهر في صفحة من نحن') }}</p>
                                </div>
                                <button type="button" class="btn btn-sm btn-outline-primary rounded-pill px-3" onclick="addBranchRow()">
                                    <i class="bi bi-plus-lg me-1"></i> {{ __('إضافة فرع') }}
                                </button>
                            </div>
                            <div class="card-body p-4">
                                <div id="branches-container" class="d-flex flex-column gap-3">
                                    @foreach($aboutBranches as $idx => $branch)
                                    <div class="branch-row card border border-light-subtle rounded-3" id="branch-row-{{ $idx }}">
                                        <div class="card-body p-3">
                                            <div class="d-flex justify-content-between align-items-center mb-3">
                                                <span class="fw-semibold small text-muted">{{ __('فرع') }} {{ $idx + 1 }}</span>
                                                <button type="button" class="btn btn-sm btn-light text-danger rounded-circle lh-1 p-1" onclick="removeBranchRow({{ $idx }})"><i class="bi bi-x-lg"></i></button>
                                            </div>
                                            <div class="row g-2">
                                                <div class="col-md-6">
                                                    <label class="form-label fw-semibold small text-muted mb-1">{{ __('المدينة') }}</label>
                                                    <input type="text" name="branch_city[]" class="form-control bg-light border-0 form-control-sm" value="{{ $branch['city'] ?? '' }}" placeholder="{{ __('الرياض') }}">
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label fw-semibold small text-muted mb-1">{{ __('اسم الفرع') }}</label>
                                                    <input type="text" name="branch_name[]" class="form-control bg-light border-0 form-control-sm" value="{{ $branch['name'] ?? '' }}" placeholder="{{ __('فرع الرياض') }}">
                                                </div>
                                                <div class="col-12">
                                                    <label class="form-label fw-semibold small text-muted mb-1">{{ __('العنوان التفصيلي') }}</label>
                                                    <input type="text" name="branch_address[]" class="form-control bg-light border-0 form-control-sm" value="{{ $branch['address'] ?? '' }}" placeholder="{{ __('طريق الملك فهد، مجمع...') }}">
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label fw-semibold small text-muted mb-1">{{ __('رقم الهاتف') }}</label>
                                                    <input type="text" name="branch_phone[]" class="form-control bg-light border-0 form-control-sm" value="{{ $branch['phone'] ?? '' }}" placeholder="+966 5X XXX XXXX">
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label fw-semibold small text-muted mb-1">{{ __('أوقات العمل') }}</label>
                                                    <input type="text" name="branch_hours[]" class="form-control bg-light border-0 form-control-sm" value="{{ $branch['working_hours'] ?? '' }}" placeholder="{{ __('السبت - الخميس، 9 صباحاً - 8 مساءً') }}">
                                                </div>
                                                <div class="col-12">
                                                    <label class="form-label fw-semibold small text-muted mb-1">{{ __('رابط الخريطة') }}</label>
                                                    <input type="url" name="branch_map_link[]" class="form-control bg-light border-0 form-control-sm text-start" dir="ltr" value="{{ $branch['map_link'] ?? '' }}" placeholder="https://maps.google.com/...">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                <div id="no-branches-msg" class="text-center py-5 bg-light rounded-3 {{ count($aboutBranches) > 0 ? 'd-none' : '' }}">
                                    <i class="bi bi-geo-alt fs-1 text-muted opacity-25 d-block mb-1"></i>
                                    <span class="text-muted small">{{ __('لا توجد فروع. اضغط "إضافة فرع" للبدء.') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- =============================== --}}
                    {{-- TAB: هيرو صفحة الحجز           --}}
                    {{-- =============================== --}}
                    <div class="settings-pane d-none" id="tab-booking-hero">
                        <div class="card border-0 shadow-sm rounded-4">
                            <div class="card-header bg-transparent border-0 p-4 pb-0">
                                <h6 class="fw-bold mb-0">{{ __('هيرو صفحة الحجز') }}</h6>
                                <p class="text-muted small mb-0">{{ __('العنوان والصورة التي تظهر في أعلى صفحة الحجز') }}</p>
                            </div>
                            <div class="card-body p-4">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold small text-muted">{{ __('العنوان — عربي') }}</label>
                                        <input type="text" name="store_booking_hero[title][ar]" class="form-control bg-light border-0" value="{{ $bookingHero['title']['ar'] ?? '' }}" placeholder="{{ __('احجز سيارتك الآن') }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold small text-muted">{{ __('العنوان — إنجليزي') }}</label>
                                        <input type="text" name="store_booking_hero[title][en]" class="form-control bg-light border-0" value="{{ $bookingHero['title']['en'] ?? '' }}" placeholder="Book Your Car Now">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold small text-muted">{{ __('الوصف — عربي') }}</label>
                                        <textarea name="store_booking_hero[subtitle][ar]" rows="3" class="form-control bg-light border-0">{{ $bookingHero['subtitle']['ar'] ?? '' }}</textarea>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold small text-muted">{{ __('الوصف — إنجليزي') }}</label>
                                        <textarea name="store_booking_hero[subtitle][en]" rows="3" class="form-control bg-light border-0">{{ $bookingHero['subtitle']['en'] ?? '' }}</textarea>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label fw-semibold small text-muted d-block mb-2">{{ __('صورة الهيرو') }}</label>
                                        @if(!empty($bookingHero['image']))
                                            <div class="mb-2 rounded-3 overflow-hidden bg-light" style="max-height:120px;">
                                                <img src="{{ asset('storage/' . $bookingHero['image']) }}" class="img-fluid w-100 object-fit-cover" style="max-height:120px;">
                                            </div>
                                            <input type="hidden" name="store_booking_hero[image]" value="{{ $bookingHero['image'] }}">
                                        @endif
                                        <input type="file" name="booking_hero_image" class="form-control bg-light border-0" accept="image/*">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- =============================== --}}
                    {{-- TAB: خطوات الحجز               --}}
                    {{-- =============================== --}}
                    <div class="settings-pane d-none" id="tab-booking-steps">
                        <div class="card border-0 shadow-sm rounded-4">
                            <div class="card-header bg-transparent border-0 p-4 pb-0 d-flex justify-content-between align-items-start">
                                <div>
                                    <h6 class="fw-bold mb-0">{{ __('خطوات الحجز') }}</h6>
                                    <p class="text-muted small mb-0">{{ __('الخطوات التي تظهر في صفحة الحجز') }}</p>
                                </div>
                                <button type="button" class="btn btn-sm btn-outline-primary rounded-pill px-3" onclick="addBookingStepRow()">
                                    <i class="bi bi-plus-lg me-1"></i> {{ __('إضافة خطوة') }}
                                </button>
                            </div>
                            <div class="card-body p-4">
                                <div id="booking-steps-container" class="d-flex flex-column gap-3">
                                    @foreach($bookingSteps as $idx => $step)
                                    <div class="booking-step-row card border border-light-subtle rounded-3" id="booking-step-row-{{ $idx }}">
                                        <div class="card-body p-3">
                                            <div class="d-flex justify-content-between align-items-center mb-3">
                                                <span class="fw-semibold small text-muted">{{ __('خطوة') }} {{ $idx + 1 }}</span>
                                                <button type="button" class="btn btn-sm btn-light text-danger rounded-circle lh-1 p-1" onclick="removeBookingStepRow({{ $idx }})"><i class="bi bi-x-lg"></i></button>
                                            </div>
                                            <div class="row g-2">
                                                <div class="col-12">
                                                    <label class="form-label fw-semibold small text-muted mb-1">{{ __('أيقونة (Bootstrap Icon)') }}</label>
                                                    <input type="text" name="booking_step_icon[]" class="form-control bg-light border-0 form-control-sm" value="{{ $step['icon'] ?? '' }}" placeholder="bi-calendar-check" dir="ltr">
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label fw-semibold small text-muted mb-1">{{ __('العنوان — عربي') }}</label>
                                                    <input type="text" name="booking_step_title_ar[]" class="form-control bg-light border-0 form-control-sm" value="{{ $step['title']['ar'] ?? '' }}">
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label fw-semibold small text-muted mb-1">{{ __('العنوان — إنجليزي') }}</label>
                                                    <input type="text" name="booking_step_title_en[]" class="form-control bg-light border-0 form-control-sm" dir="ltr" value="{{ $step['title']['en'] ?? '' }}">
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label fw-semibold small text-muted mb-1">{{ __('الوصف — عربي') }}</label>
                                                    <textarea name="booking_step_desc_ar[]" rows="2" class="form-control bg-light border-0 form-control-sm">{{ $step['description']['ar'] ?? '' }}</textarea>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label fw-semibold small text-muted mb-1">{{ __('الوصف — إنجليزي') }}</label>
                                                    <textarea name="booking_step_desc_en[]" rows="2" class="form-control bg-light border-0 form-control-sm" dir="ltr">{{ $step['description']['en'] ?? '' }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                <div id="no-booking-steps-msg" class="text-center py-5 bg-light rounded-3 {{ count($bookingSteps) > 0 ? 'd-none' : '' }}">
                                    <i class="bi bi-list-ol fs-1 text-muted opacity-25 d-block mb-1"></i>
                                    <span class="text-muted small">{{ __('لا توجد خطوات. اضغط "إضافة خطوة" للبدء.') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- =============================== --}}
                    {{-- TAB: أقسام صفحة الحجز          --}}
                    {{-- =============================== --}}
                    <div class="settings-pane d-none" id="tab-booking-sections">
                        @php $bsec = $bookingSections; @endphp
                        <div class="d-flex flex-column gap-3">
                            @php
                                $bookingSectionsDef = [
                                    [
                                        'id' => 'hero', 'icon' => 'bi-house', 'label' => __('قسم الهيرو'),
                                        'fields' => ['badge', 'title', 'subtitle'],
                                        'fieldLabels' => ['badge' => __('الشارة (Badge)'), 'title' => __('العنوان'), 'subtitle' => __('الوصف')],
                                        'textarea' => ['subtitle'],
                                    ],
                                    [
                                        'id' => 'form', 'icon' => 'bi-card-checklist', 'label' => __('نموذج الحجز'),
                                        'fields' => ['title', 'subtitle'],
                                        'fieldLabels' => ['title' => __('عنوان النموذج'), 'subtitle' => __('وصف النموذج')],
                                        'textarea' => ['subtitle'],
                                    ],
                                    [
                                        'id' => 'success', 'icon' => 'bi-check-circle', 'label' => __('صفحة النجاح'),
                                        'fields' => ['title', 'subtitle', 'description'],
                                        'fieldLabels' => ['title' => __('العنوان'), 'subtitle' => __('الوصف'), 'description' => __('النص التفصيلي')],
                                        'textarea' => ['subtitle', 'description'],
                                    ],
                                ];
                            @endphp

                            @foreach($bookingSectionsDef as $bIdx => $bDef)
                            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                                <button type="button" class="btn text-start p-4 d-flex align-items-center gap-3 collapsed-section-toggle border-0 bg-white rounded-4" onclick="toggleSection('b-{{ $bDef['id'] }}', this)">
                                    <i class="bi {{ $bDef['icon'] }} text-danger"></i>
                                    <span class="fw-semibold">{{ $bDef['label'] }}</span>
                                    <i class="bi bi-chevron-down ms-auto text-muted small toggle-chevron"></i>
                                </button>
                                <div class="section-body {{ $bIdx === 0 ? '' : 'd-none' }} border-top" id="b-{{ $bDef['id'] }}">
                                    <div class="p-4">
                                        <div class="row g-3">
                                            @foreach($bDef['fields'] as $bField)
                                            @php $isTA = in_array($bField, $bDef['textarea']); @endphp
                                            <div class="col-md-6">
                                                <label class="form-label fw-semibold small text-muted">{{ $bDef['fieldLabels'][$bField] }} — {{ __('عربي') }}</label>
                                                @if($isTA)
                                                    <textarea name="store_booking_sections[{{ $bDef['id'] }}][{{ $bField }}][ar]" class="form-control bg-light border-0" rows="3">{{ $bsec[$bDef['id']][$bField]['ar'] ?? '' }}</textarea>
                                                @else
                                                    <input type="text" name="store_booking_sections[{{ $bDef['id'] }}][{{ $bField }}][ar]" class="form-control bg-light border-0" value="{{ $bsec[$bDef['id']][$bField]['ar'] ?? '' }}">
                                                @endif
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label fw-semibold small text-muted">{{ $bDef['fieldLabels'][$bField] }} — {{ __('إنجليزي') }}</label>
                                                @if($isTA)
                                                    <textarea name="store_booking_sections[{{ $bDef['id'] }}][{{ $bField }}][en]" class="form-control bg-light border-0" rows="3">{{ $bsec[$bDef['id']][$bField]['en'] ?? '' }}</textarea>
                                                @else
                                                    <input type="text" name="store_booking_sections[{{ $bDef['id'] }}][{{ $bField }}][en]" class="form-control bg-light border-0" value="{{ $bsec[$bDef['id']][$bField]['en'] ?? '' }}">
                                                @endif
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                </div>{{-- /settingsTabContent --}}
            </div>

            {{-- ===== SAVE SIDEBAR ===== --}}
            <div class="col-lg-3">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden sticky-top" style="top:80px; background:#0a0a0a;">
                    <div class="card-body p-4 position-relative">
                        <i class="bi bi-save position-absolute text-white opacity-10" style="font-size:80px;right:-10px;bottom:-20px;"></i>
                        <h5 class="fw-bold mb-2 text-white">{{ __('حفظ التغييرات') }}</h5>
                        <p class="small text-white opacity-50 mb-4">{{ __('تأكد من مراجعة جميع الأقسام قبل الحفظ.') }}</p>
                        @can('manage-settings')
                        <button type="submit" class="btn w-100 py-3 fw-bold rounded-3" style="background:#EB5E281A;color:#fff;">
                            <i class="bi bi-check2-circle me-2"></i> {{ __('تحديث الإعدادات') }}
                        </button>
                        @endcan
                        <div class="mt-3 pt-3 border-top border-secondary">
                            <p class="text-white opacity-50 small mb-0 text-center" id="active-tab-label">{{ __('المعلومات الأساسية') }}</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </form>
</div>
@endsection

@section('css')
<style>
    .nav-group-label {
        font-size: 10px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .08em;
        color: #94a3b8;
        padding: 12px 12px 4px;
        margin: 0;
    }
    .settings-nav-btn {
        display: flex;
        align-items: center;
        gap: 10px;
        width: 100%;
        border: none;
        background: transparent;
        text-align: start;
        padding: 9px 12px;
        border-radius: 8px;
        font-size: 13.5px;
        color: #4b5563;
        transition: background .15s, color .15s;
        cursor: pointer;
    }
    .settings-nav-btn:hover  { background: #f1f5f9; color: #111; }
    .settings-nav-btn.active { background: #fff0f0; color: rgba(235, 94, 40, 1); font-weight: 600; }
    .settings-nav-btn i { font-size: 15px; flex-shrink: 0; }

    .settings-pane { display: block; }
    .settings-pane.d-none { display: none !important; }

    .upload-preview {
        min-height: 100px;
        background: #f8fafc;
        border: 1.5px dashed #e2e8f0;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }
    .object-fit-cover { object-fit: cover; }
    .bg-info-subtle  { background: #e0f2fe; }

    .collapsed-section-toggle { width: 100%; cursor: pointer; }
    .collapsed-section-toggle:hover { background: #f8fafc !important; }
    .toggle-chevron { transition: transform .2s; }
    .collapsed-section-toggle.open .toggle-chevron { transform: rotate(180deg); }
</style>
@endsection

@section('scripts')
<script>
// ===== Tab Navigation =====
document.querySelectorAll('.settings-nav-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        document.querySelectorAll('.settings-nav-btn').forEach(b => b.classList.remove('active'));
        document.querySelectorAll('.settings-pane').forEach(p => p.classList.add('d-none'));
        this.classList.add('active');
        const target = document.getElementById('tab-' + this.dataset.tab);
        if (target) { target.classList.remove('d-none'); }
        const label = document.getElementById('active-tab-label');
        if (label) { label.textContent = this.textContent.trim(); }
    });
});

// ===== Collapsible Sections =====
function toggleSection(id, btn) {
    const body = document.getElementById(id);
    if (!body) return;
    const isOpen = !body.classList.contains('d-none');
    body.classList.toggle('d-none', isOpen);
    btn.classList.toggle('open', !isOpen);
}

// ===== Hero Slides =====
function addHeroSlide() {
    const container = document.getElementById('hero-slides-container');
    const items = container.querySelectorAll('.hero-slide-item');
    const idx = items.length > 0 ? parseInt(items[items.length - 1].id.split('-').pop()) + 1 : 0;
    document.getElementById('no-slides-msg').classList.add('d-none');
    const div = document.createElement('div');
    div.className = 'hero-slide-item card border border-light-subtle rounded-3 shadow-sm';
    div.id = 'hero-slide-' + idx;
    div.innerHTML = `
        <div class="card-body p-3">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <span class="small fw-semibold text-muted">{{ __('شريحة جديدة') }}</span>
                <button type="button" class="btn btn-sm btn-light text-danger rounded-circle lh-1 p-1" onclick="removeHeroSlide(${idx})"><i class="bi bi-x-lg"></i></button>
            </div>
            <div class="row g-3">
                <div class="col-md-4">
                    <input type="file" name="hero_slides[${idx}][image]" class="form-control bg-light border-0 form-control-sm" accept="image/*" required>
                </div>
                <div class="col-md-8">
                    <div class="row g-2">
                        <div class="col-12">
                            <label class="form-label fw-semibold small text-muted mb-1">{{ __('الرابط') }}</label>
                            <input type="url" name="hero_slides[${idx}][link]" class="form-control bg-light border-0 text-start form-control-sm" dir="ltr" placeholder="https://...">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold small text-muted mb-1">{{ __('نص الزر') }}</label>
                            <input type="text" name="hero_slides[${idx}][button_text]" class="form-control bg-light border-0 form-control-sm" value="{{ __('اكتشف السيارات') }}">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold small text-muted mb-1">{{ __('نص الزر 2') }}</label>
                            <input type="text" name="hero_slides[${idx}][button_2_text]" class="form-control bg-light border-0 form-control-sm">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold small text-muted mb-1">{{ __('رابط الزر 2') }}</label>
                            <input type="url" name="hero_slides[${idx}][link_2]" class="form-control bg-light border-0 text-start form-control-sm" dir="ltr" placeholder="https://...">
                        </div>
                    </div>
                </div>
            </div>
        </div>`;
    container.appendChild(div);
}
function removeHeroSlide(idx) {
    document.getElementById('hero-slide-' + idx)?.remove();
    if (!document.querySelector('.hero-slide-item')) document.getElementById('no-slides-msg').classList.remove('d-none');
}

// ===== Social Media =====
let socialCount = {{ count($socialMedia) }};
function addSocialRow() {
    const idx = socialCount++;
    document.getElementById('no-social-msg').classList.add('d-none');
    const div = document.createElement('div');
    div.className = 'social-row d-flex align-items-center gap-2 p-3 bg-light rounded-3';
    div.id = 'social-row-' + idx;
    div.innerHTML = `
        <input type="text" name="social_icon[]" class="form-control border-0 bg-white" placeholder="bi-facebook" style="max-width:150px;">
        <input type="color" name="social_color[]" class="form-control form-control-color border-0 bg-white p-1" value="#333333" style="width:40px;height:38px;">
        <input type="url" name="social_link[]" class="form-control border-0 bg-white text-start flex-grow-1" dir="ltr" placeholder="https://...">
        <button type="button" class="btn btn-sm btn-light text-danger rounded-circle lh-1 p-1" onclick="removeSocialRow(${idx})"><i class="bi bi-x-lg"></i></button>`;
    document.getElementById('social-container').appendChild(div);
}
function removeSocialRow(idx) {
    document.getElementById('social-row-' + idx)?.remove();
    if (!document.querySelector('.social-row')) document.getElementById('no-social-msg').classList.remove('d-none');
}

// ===== Homepage Stats =====
let statCount = {{ count($homepageStats) }};
function addStatRow() {
    const idx = statCount++;
    document.getElementById('no-stats-msg').classList.add('d-none');
    const div = document.createElement('div');
    div.className = 'stat-row d-flex align-items-center gap-2 p-3 bg-light rounded-3';
    div.id = 'stat-row-' + idx;
    div.innerHTML = `
        <input type="text" name="stat_value[]" class="form-control border-0 bg-white fw-bold text-center" placeholder="+500" style="max-width:90px;">
        <input type="text" name="stat_label[]" class="form-control border-0 bg-white flex-grow-1" placeholder="{{ __('التسمية') }}">
        <button type="button" class="btn btn-sm btn-light text-danger rounded-circle lh-1 p-1" onclick="removeStatRow(${idx}, 'stat-row')"><i class="bi bi-x-lg"></i></button>`;
    document.getElementById('stats-container').appendChild(div);
}
function removeStatRow(idx, prefix) {
    document.getElementById((prefix || 'stat-row') + '-' + idx)?.remove();
    if (!document.querySelector('.stat-row')) document.getElementById('no-stats-msg').classList.remove('d-none');
}

// ===== About Stats =====
let aboutStatCount = {{ count($aboutStats) }};
function addAboutStatRow() {
    const idx = aboutStatCount++;
    document.getElementById('no-about-stats-msg').classList.add('d-none');
    const div = document.createElement('div');
    div.className = 'about-stat-row d-flex align-items-center gap-2 p-3 bg-light rounded-3';
    div.id = 'about-stat-row-' + idx;
    div.innerHTML = `
        <input type="text" name="about_stat_value[]" class="form-control border-0 bg-white fw-bold text-center" placeholder="+500" style="max-width:90px;">
        <input type="text" name="about_stat_label[]" class="form-control border-0 bg-white flex-grow-1" placeholder="{{ __('التسمية') }}">
        <button type="button" class="btn btn-sm btn-light text-danger rounded-circle lh-1 p-1" onclick="removeAboutStatRow(${idx})"><i class="bi bi-x-lg"></i></button>`;
    document.getElementById('about-stats-container').appendChild(div);
}
function removeAboutStatRow(idx) {
    document.getElementById('about-stat-row-' + idx)?.remove();
    if (!document.querySelector('.about-stat-row')) document.getElementById('no-about-stats-msg').classList.remove('d-none');
}

// ===== Finance Stats =====
let financeStatCount = {{ count($financeStats) }};
function addFinanceStatRow() {
    const idx = financeStatCount++;
    document.getElementById('no-finance-stats-msg').classList.add('d-none');
    const div = document.createElement('div');
    div.className = 'finance-stat-row d-flex align-items-center gap-2 p-3 bg-light rounded-3';
    div.id = 'finance-stat-row-' + idx;
    div.innerHTML = `
        <input type="text" name="finance_stat_value[]" class="form-control border-0 bg-white fw-bold text-center" placeholder="500" style="max-width:90px;">
        <input type="text" name="finance_stat_label[]" class="form-control border-0 bg-white flex-grow-1" placeholder="{{ __('التسمية') }}">
        <button type="button" class="btn btn-sm btn-light text-danger rounded-circle lh-1 p-1" onclick="removeFinanceStatRow(${idx})"><i class="bi bi-x-lg"></i></button>`;
    document.getElementById('finance-stats-container').appendChild(div);
}
function removeFinanceStatRow(idx) {
    document.getElementById('finance-stat-row-' + idx)?.remove();
    if (!document.querySelector('.finance-stat-row')) document.getElementById('no-finance-stats-msg').classList.remove('d-none');
}

// ===== Branches =====
let branchCount = {{ count($aboutBranches) }};
function addBranchRow() {
    const idx = branchCount++;
    document.getElementById('no-branches-msg').classList.add('d-none');
    const div = document.createElement('div');
    div.className = 'branch-row card border border-light-subtle rounded-3';
    div.id = 'branch-row-' + idx;
    div.innerHTML = `
        <div class="card-body p-3">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <span class="fw-semibold small text-muted">{{ __('فرع جديد') }}</span>
                <button type="button" class="btn btn-sm btn-light text-danger rounded-circle lh-1 p-1" onclick="removeBranchRow(${idx})"><i class="bi bi-x-lg"></i></button>
            </div>
            <div class="row g-2">
                <div class="col-md-6"><label class="form-label fw-semibold small text-muted mb-1">{{ __('المدينة') }}</label><input type="text" name="branch_city[]" class="form-control bg-light border-0 form-control-sm" placeholder="{{ __('الرياض') }}"></div>
                <div class="col-md-6"><label class="form-label fw-semibold small text-muted mb-1">{{ __('اسم الفرع') }}</label><input type="text" name="branch_name[]" class="form-control bg-light border-0 form-control-sm" placeholder="{{ __('فرع الرياض') }}"></div>
                <div class="col-12"><label class="form-label fw-semibold small text-muted mb-1">{{ __('العنوان') }}</label><input type="text" name="branch_address[]" class="form-control bg-light border-0 form-control-sm"></div>
                <div class="col-md-6"><label class="form-label fw-semibold small text-muted mb-1">{{ __('الهاتف') }}</label><input type="text" name="branch_phone[]" class="form-control bg-light border-0 form-control-sm"></div>
                <div class="col-md-6"><label class="form-label fw-semibold small text-muted mb-1">{{ __('أوقات العمل') }}</label><input type="text" name="branch_hours[]" class="form-control bg-light border-0 form-control-sm"></div>
                <div class="col-12"><label class="form-label fw-semibold small text-muted mb-1">{{ __('رابط الخريطة') }}</label><input type="url" name="branch_map_link[]" class="form-control bg-light border-0 form-control-sm text-start" dir="ltr" placeholder="https://maps.google.com/..."></div>
            </div>
        </div>`;
    document.getElementById('branches-container').appendChild(div);
}
function removeBranchRow(idx) {
    document.getElementById('branch-row-' + idx)?.remove();
    if (!document.querySelector('.branch-row')) document.getElementById('no-branches-msg').classList.remove('d-none');
}

let bookingStepCount = {{ count($bookingSteps) }};
function addBookingStepRow() {
    const idx = bookingStepCount++;
    document.getElementById('no-booking-steps-msg').classList.add('d-none');
    const div = document.createElement('div');
    div.className = 'booking-step-row card border border-light-subtle rounded-3';
    div.id = 'booking-step-row-' + idx;
    div.innerHTML = `
        <div class="card-body p-3">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <span class="fw-semibold small text-muted">{{ __('خطوة جديدة') }}</span>
                <button type="button" class="btn btn-sm btn-light text-danger rounded-circle lh-1 p-1" onclick="removeBookingStepRow(${idx})"><i class="bi bi-x-lg"></i></button>
            </div>
            <div class="row g-2">
                <div class="col-12"><label class="form-label fw-semibold small text-muted mb-1">{{ __('أيقونة (Bootstrap Icon)') }}</label><input type="text" name="booking_step_icon[]" class="form-control bg-light border-0 form-control-sm" placeholder="bi-calendar-check" dir="ltr"></div>
                <div class="col-md-6"><label class="form-label fw-semibold small text-muted mb-1">{{ __('العنوان — عربي') }}</label><input type="text" name="booking_step_title_ar[]" class="form-control bg-light border-0 form-control-sm"></div>
                <div class="col-md-6"><label class="form-label fw-semibold small text-muted mb-1">{{ __('العنوان — إنجليزي') }}</label><input type="text" name="booking_step_title_en[]" class="form-control bg-light border-0 form-control-sm" dir="ltr"></div>
                <div class="col-md-6"><label class="form-label fw-semibold small text-muted mb-1">{{ __('الوصف — عربي') }}</label><textarea name="booking_step_desc_ar[]" rows="2" class="form-control bg-light border-0 form-control-sm"></textarea></div>
                <div class="col-md-6"><label class="form-label fw-semibold small text-muted mb-1">{{ __('الوصف — إنجليزي') }}</label><textarea name="booking_step_desc_en[]" rows="2" class="form-control bg-light border-0 form-control-sm" dir="ltr"></textarea></div>
            </div>
        </div>`;
    document.getElementById('booking-steps-container').appendChild(div);
}
function removeBookingStepRow(idx) {
    document.getElementById('booking-step-row-' + idx)?.remove();
    if (!document.querySelector('.booking-step-row')) document.getElementById('no-booking-steps-msg').classList.remove('d-none');
}

// Open first section in each accordion on load
document.querySelectorAll('.collapsed-section-toggle').forEach((btn, i) => {
    if (i === 0 || (i > 0 && btn.closest('.settings-pane') !== document.querySelectorAll('.collapsed-section-toggle')[i-1].closest('.settings-pane'))) {
        btn.classList.add('open');
    }
});
</script>
@endsection
