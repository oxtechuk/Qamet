<!DOCTYPE html>
<html lang="{{ App::getLocale() }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('تسجيل دخول المديرين | Konz') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        :root {
            --primary: #299BE0;
            --primary-dark: #1a7cb5;
            --primary-glow: rgba(41, 155, 224, 0.15);
            --bg-light: #ffffff;
            --bg-gray: #f8fafc;
            --text-dark: #0f172a;
            --text-muted: #64748b;
            --border-color: #cbd5e1;
            --success: #10b981;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Cairo', sans-serif; }

        body {
            background-color: var(--bg-light);
            color: var(--text-dark);
            height: 100vh;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-container {
            display: flex;
            width: 100vw;
            height: 100vh;
            flex-direction: row; /* Always left: Image, right: Form */
        }

        /* Image Panel (Left) */
        .image-panel {
            flex: 1.4;
            position: relative;
            background-image: url('{{ asset("images/home_hero.png") }}');
            background-size: cover;
            background-position: center;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            padding: 60px;
            color: #ffffff;
        }

        .image-panel::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(to top, rgba(13, 16, 24, 0.85) 0%, rgba(41, 155, 224, 0.2) 100%);
            z-index: 1;
        }

        .image-panel-content {
            position: relative;
            z-index: 2;
            max-width: 550px;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        }

        .image-panel-content h2 {
            font-size: 34px;
            font-weight: 800;
            margin-bottom: 12px;
            line-height: 1.3;
        }

        .image-panel-content p {
            font-size: 16px;
            opacity: 0.9;
            font-weight: 500;
            line-height: 1.6;
        }

        /* Form Panel (Right) */
        .form-panel {
            width: 480px;
            background-color: var(--bg-light);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 60px 48px;
            overflow-y: auto;
            position: relative;
            box-shadow: -10px 0 30px rgba(0,0,0,0.02);
            border-left: 1px solid #f1f5f9;
        }

        .form-content-wrapper {
            margin-top: auto;
            margin-bottom: auto;
            width: 100%;
        }

        .logo-section {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 40px;
        }

        .logo-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            margin-top: 12px;
            padding: 6px 16px;
            background: rgba(41, 155, 224, 0.08);
            border: 1px solid rgba(41, 155, 224, 0.15);
            border-radius: 50px;
            font-size: 12px;
            color: var(--primary);
            font-weight: 700;
        }

        .form-header {
            text-align: center;
            margin-bottom: 32px;
        }

        .form-header h1 {
            font-size: 24px;
            font-weight: 800;
            color: var(--text-dark);
            margin-bottom: 8px;
        }

        .form-header p {
            color: var(--text-muted);
            font-size: 14px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            font-size: 13px;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 8px;
        }

        .input-wrapper {
            position: relative;
        }

        .input-wrapper i {
            position: absolute;
            color: var(--text-muted);
            font-size: 18px;
            top: 50%;
            transform: translateY(-50%);
            transition: color 0.3s;
            z-index: 1;
        }

        .form-control {
            width: 100%;
            background: var(--bg-gray);
            border: 1.5px solid #e2e8f0;
            border-radius: 12px;
            color: var(--text-dark);
            font-size: 15px;
            transition: all 0.3s ease;
            outline: none;
            height: 50px;
        }

        .form-control:focus {
            border-color: var(--primary);
            background: #ffffff;
            box-shadow: 0 0 0 4px rgba(41, 155, 224, 0.15);
        }

        .form-control:focus ~ i,
        .input-wrapper:focus-within i {
            color: var(--primary);
        }

        .remember-row {
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .remember-row input[type="checkbox"] {
            width: 18px; height: 18px;
            accent-color: var(--primary);
            cursor: pointer;
            border-radius: 4px;
        }

        .remember-row label {
            font-size: 13px;
            color: var(--text-muted);
            cursor: pointer;
            user-select: none;
        }

        .btn-login {
            width: 100%;
            height: 52px;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: #fff;
            border: none;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 800;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            box-shadow: 0 10px 25px rgba(41, 155, 224, 0.25);
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 30px rgba(41, 155, 224, 0.35);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .btn-login.loading .spinner { display: inline-block; }
        .btn-login.loading .btn-text { display: none; }
        .btn-login.loading .btn-icon { display: none; }

        .error-message {
            background: rgba(239, 68, 68, 0.08);
            color: #ef4444;
            padding: 14px 16px;
            border-radius: 12px;
            font-size: 13px;
            margin-bottom: 24px;
            text-align: center;
            border: 1px solid rgba(239, 68, 68, 0.15);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .footer-text {
            text-align: center;
            font-size: 12px;
            color: var(--text-muted);
            margin-top: 30px;
        }

        .footer-text a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 700;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* Direction-based styles */
        [dir="rtl"] .input-wrapper i { right: 16px; left: auto; }
        [dir="rtl"] .form-control { padding: 0 48px 0 16px; text-align: right; }
        [dir="rtl"] .form-label { text-align: right; }

        [dir="ltr"] .input-wrapper i { left: 16px; right: auto; }
        [dir="ltr"] .form-control { padding: 0 16px 0 48px; text-align: left; }
        [dir="ltr"] .form-label { text-align: left; }

        /* Responsive */
        @media (max-width: 900px) {
            .image-panel { display: none; }
            .form-panel { 
                width: 100%; 
                max-width: 500px; 
                margin: auto; 
                height: 100vh; 
                box-shadow: none; 
                border: none; 
                padding: 40px 24px;
            }
        }
    </style>
</head>
<body>

    <div class="login-container">
        
        <!-- Left Panel: Image (Hidden on Mobile) -->
        <div class="image-panel">
            <div class="image-panel-content" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
                <h2>{{ __('منصة إدارة وتتبع السيارات الأكثر تميزاً') }}</h2>
                <p>{{ __('تحكم في أسطول سياراتك، تتبع الحجوزات والمبيعات، وقم بإدارة لوحة العمل الخاصة بك بكل سهولة وذكاء.') }}</p>
            </div>
        </div>

        <!-- Right Panel: Form Card -->
        <div class="form-panel" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
            
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

                @if($errors->any())
                    <div class="error-message" id="errorMsg">
                        <i class="bi bi-exclamation-circle"></i>
                        <span>{{ $errors->first() }}</span>
                    </div>
                @endif

                <form action="{{ route('crm.login.post') }}" method="POST" id="loginForm">
                    @csrf

                    <div class="form-group">
                        <label class="form-label">{{ __('اسم المستخدم') }}</label>
                        <div class="input-wrapper">
                            <i class="bi bi-person"></i>
                            <input type="text" name="username" class="form-control" placeholder="admin" required autofocus>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">{{ __('كلمة المرور') }}</label>
                        <div class="input-wrapper">
                            <i class="bi bi-lock"></i>
                            <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                        </div>
                    </div>

                    <div class="remember-row">
                        <input type="checkbox" name="remember" id="remember">
                        <label for="remember">{{ __('تذكرني') }}</label>
                    </div>

                    <button type="submit" class="btn-login" id="loginBtn">
                        <span class="btn-icon"><i class="bi bi-arrow-{{ app()->getLocale() == 'ar' ? 'left' : 'right' }}-short" style="font-size: 24px;"></i></span>
                        <span class="btn-text">{{ __('تسجيل الدخول') }}</span>
                        <span class="spinner" style="display: none; width: 20px; height: 20px; border: 2.5px solid rgba(255,255,255,0.3); border-top-color: #fff; border-radius: 50%; animation: spin 0.6s linear infinite;"></span>
                    </button>
                </form>
            </div>

            <div class="footer-text">
                &copy; {{ date('Y') }} <a href="{{ route('store.home') }}">Konz</a> Dashboard. All rights reserved.
            </div>

        </div>

    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('loginForm');
        const btn = document.getElementById('loginBtn');
        const spinner = btn ? btn.querySelector('.spinner') : null;
        const btnIcon = btn ? btn.querySelector('.btn-icon') : null;
        const btnText = btn ? btn.querySelector('.btn-text') : null;

        if (form && btn) {
            form.addEventListener('submit', function () {
                btn.classList.add('loading');
                btn.disabled = true;
                if (spinner) spinner.style.display = 'inline-block';
                if (btnIcon) btnIcon.style.display = 'none';
                if (btnText) btnText.style.display = 'none';
            });
        }

        // Hide error on input focus
        const errorMsg = document.getElementById('errorMsg');
        if (errorMsg) {
            const inputs = document.querySelectorAll('.form-control');
            inputs.forEach(function (input) {
                input.addEventListener('focus', function () {
                    errorMsg.style.opacity = '0';
                    errorMsg.style.transform = 'translateY(-10px)';
                    errorMsg.style.transition = 'all 0.3s ease';
                    setTimeout(function () {
                        errorMsg.style.display = 'none';
                    }, 300);
                });
            });
        }
    });
    </script>

</body>
</html>