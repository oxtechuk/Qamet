<div class="auth-card-container" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">

    <!-- Left Brand Hero Showcase -->
    <div class="auth-hero-panel">
        <div class="hero-header">
            <div class="hero-badge">
                <i class="bi bi-shield-lock-fill"></i>
                {{ __('نظام الإدارة والتحكم') }}
            </div>
            <a href="{{ Route::has('store.home') ? route('store.home') : url('/') }}" class="hero-store-link">
                <i class="bi bi-globe"></i>
                {{ __('الموقع الإلكتروني') }}
            </a>
        </div>

        <div class="hero-content">
            <div class="hero-tag">
                <i class="bi bi-stars"></i>
                {{ __('قمة نجد للسيارات') }}
            </div>
            <h2>{{ __('منصة متكاملة لإدارة ومتابعة المبيعات والأسطول') }}</h2>
            <p>{{ __('تحكم ذكي في المخزون، متابعة فورية للحجوزات ومبيعات الكاش والتقسيط، وإدارة فرق العمل بكل احترافية.') }}</p>

            <div class="hero-features">
                <div class="hero-feat-card">
                    <div class="hero-feat-icon">
                        <i class="bi bi-speedometer2"></i>
                    </div>
                    <div>
                        <h4>{{ __('متابعة فورية') }}</h4>
                        <span>{{ __('أداء المبيعات والطلبات') }}</span>
                    </div>
                </div>

                <div class="hero-feat-card">
                    <div class="hero-feat-icon">
                        <i class="bi bi-shield-check"></i>
                    </div>
                    <div>
                        <h4>{{ __('أمان وصلاحيات') }}</h4>
                        <span>{{ __('مصفوفة وصول متطورة') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Login Form Panel -->
    <div class="auth-form-panel">
        <div class="auth-form-wrapper">
            <div class="auth-logo-box">
                <div class="auth-logo-frame">
                    @php
                        $siteLogo = \App\Models\Setting::where('key', 'site_logo')->value('value');
                        if ($siteLogo && file_exists(public_path('storage/' . $siteLogo))) {
                            $logoUrl = asset('storage/' . $siteLogo);
                        } elseif (file_exists(public_path('images/logo_without_bg_white.svg'))) {
                            $logoUrl = asset('images/logo_without_bg_white.svg');
                        } elseif (file_exists(public_path('images/logo_without_bg.svg'))) {
                            $logoUrl = asset('images/logo_without_bg.svg');
                        } else {
                            $logoUrl = asset('favicon.svg');
                        }
                    @endphp
                    <img src="{{ $logoUrl }}" alt="قمة نجد" style="max-height: 68px; width: auto; filter: drop-shadow(0 4px 14px rgba(223, 198, 116, 0.35));">
                </div>
                <div class="auth-role-tag">
                    <i class="bi bi-shield-fill-check"></i>
                    {{ __('لوحة تحكم الفريق والمديرين') }}
                </div>
            </div>

            <div class="auth-title-area">
                <h1 class="auth-main-title">{{ __('مرحباً بعودتك 👋') }}</h1>
                <p class="auth-sub-title">{{ __('أدخل بياناتك لتسجيل الدخول للوحة التحكم') }}</p>
            </div>

            {{ $this->content }}
            <x-filament-actions::modals />
        </div>

        <div class="auth-footer">
            &copy; {{ date('Y') }} <a href="{{ Route::has('store.home') ? route('store.home') : url('/') }}">قمة نجد</a>. جميع الحقوق محفوظة.
        </div>
    </div>

</div>
