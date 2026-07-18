<div class="login-container" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">

    <div class="image-panel">
        <div class="image-panel-content">
            <h2>{{ __('منصة إدارة وتتبع السيارات الأكثر تميزاً') }}</h2>
            <p>{{ __('تحكم في أسطول سياراتك، تتبع الحجوزات والمبيعات، وقم بإدارة لوحة العمل الخاصة بك بكل سهولة وذكاء.') }}</p>
        </div>
    </div>

    <div class="form-panel">
        <div class="form-content-wrapper">
            <div class="logo-section">
                <img src="{{ asset('images/logo_without_bg.png') }}" alt="Konz Logo" style="max-height: 75px; width: auto; filter: drop-shadow(0 4px 10px rgba(41, 155, 224, 0.15));">
                <div class="logo-badge">
                    <i class="bi bi-shield-check"></i>
                    {{ __('لوحة تحكم المديرين') }}
                </div>
            </div>

            <div class="form-header">
                <h1>{{ __('مرحباً بعودتك') }}</h1>
                <p>{{ __('قم بتسجيل الدخول للمتابعة إلى لوحة التحكم') }}</p>
            </div>

            {{ $this->content }}
        </div>

        <div class="footer-text">
            &copy; {{ date('Y') }} <a href="{{ route('store.home') }}">Konz</a> Dashboard. All rights reserved.
        </div>
    </div>

</div>
