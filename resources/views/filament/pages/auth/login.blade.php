<div class="login-wrapper" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">

    <div class="image-panel">
        <div class="image-panel-header">
            <div class="brand-pill">
                <i class="bi bi-shield-lock-fill"></i>
                {{ __('نظام الإدارة الآمن | قمة نجد') }}
            </div>
            <a href="{{ route('store.home') }}" style="color: #94a3b8; text-decoration: none; font-size: 13px; font-weight: 600; display: inline-flex; align-items: center; gap: 6px; transition: color 0.2s;" onmouseover="this.style.color='#ffffff'" onmouseout="this.style.color='#94a3b8'">
                <i class="bi bi-globe"></i>
                {{ __('المتجر') }}
            </a>
        </div>

        <div class="image-panel-content">
            <div class="badge-tag">
                <i class="bi bi-stars"></i>
                {{ __('الجيل الجديد من إدارة السيارات') }}
            </div>
            <h2>{{ __('منصة إدارة وتتبع السيارات الأكثر تميزاً') }}</h2>
            <p>{{ __('تحكم في أسطول سياراتك، تتبع الحجوزات والمبيعات، وقم بإدارة لوحة العمل الخاصة بك بكل سهولة وذكاء.') }}</p>

            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="bi bi-speedometer2"></i>
                    </div>
                    <div class="feature-info">
                        <h4>{{ __('لوحة تتبع مباشرة') }}</h4>
                        <span>{{ __('مراقبة الأداء والمبيعات') }}</span>
                    </div>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="bi bi-shield-check"></i>
                    </div>
                    <div class="feature-info">
                        <h4>{{ __('أمان وحماية عالية') }}</h4>
                        <span>{{ __('تشفير وصلاحيات متقدمة') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="form-panel">
        <div class="form-content-wrapper">
            <div class="logo-section">
                <div class="logo-img-wrapper">
                    <img src="{{ asset('images/logo_without_bg.png') }}" alt="قمة نجد Logo" style="max-height: 70px; width: auto; filter: drop-shadow(0 4px 12px rgba(41, 155, 224, 0.2));">
                </div>
                <div class="logo-badge">
                    <i class="bi bi-shield-fill-check"></i>
                    {{ __('لوحة تحكم المديرين') }}
                </div>
            </div>

            <div class="form-header">
                <h1>{{ __('مرحباً بعودتك 👋') }}</h1>
                <p>{{ __('قم بتسجيل الدخول للمتابعة إلى لوحة التحكم') }}</p>
            </div>

            {{ $this->content }}
            <x-filament-actions::modals />
        </div>

        <div class="footer-text">
            &copy; {{ date('Y') }} <a href="{{ route('store.home') }}">قمة نجد</a> Dashboard. All rights reserved.
        </div>
    </div>

</div>
