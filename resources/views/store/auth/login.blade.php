<!DOCTYPE html>
<html lang="{{ App::getLocale() }}" dir="{{ App::getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Language" content="{{ App::getLocale() }}">
    <title>{{ __('تسجيل الدخول | GR Motors') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        :root {
            --primary: #ED1C24;
            --primary-dark: #B1161C;
            --primary-glow: rgba(237,28,36,0.25);
            --dark-bg: #0a0a0a;
            --card-bg: #111111;
            --input-bg: #1a1a1a;
            --text-white: #ffffff;
            --text-muted: #8a8f98;
            --border-color: #222222;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Cairo', sans-serif; }

        body {
            background-color: var(--dark-bg);
            color: var(--text-white);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            position: relative;
        }

        #particles-canvas {
            position: fixed; inset: 0; z-index: 0; pointer-events: none;
        }

        .orb {
            position: fixed; border-radius: 50%; filter: blur(120px); opacity: 0.10; pointer-events: none;
            animation: orbFloat 12s ease-in-out infinite;
        }
        .orb--1 {
            width: 650px; height: 650px;
            background: radial-gradient(circle, var(--primary), transparent);
            top: -250px; {{ App::getLocale() == 'ar' ? 'right' : 'left' }}: -100px;
            animation-delay: 0s;
        }
        .orb--2 {
            width: 450px; height: 450px;
            background: radial-gradient(circle, var(--primary-dark), transparent);
            bottom: -150px; {{ App::getLocale() == 'ar' ? 'left' : 'right' }}: -80px;
            animation-delay: 6s;
        }
        @keyframes orbFloat {
            0%, 100% { transform: translate(0, 0) scale(1); }
            50% { transform: translate(40px, -40px) scale(1.08); }
        }

        .login-wrapper {
            width: 100%;
            max-width: 430px;
            padding: 20px;
            position: relative;
            z-index: 1;
            animation: fadeIn 0.8s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(24px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .login-card {
            background: var(--card-bg);
            padding: 44px;
            border-radius: 24px;
            box-shadow: 0 40px 100px rgba(0,0,0,0.5);
            border: 1px solid var(--border-color);
            position: relative;
            overflow: hidden;
        }

        .login-card::before {
            content: "";
            position: absolute;
            top: -2px;
            left: -2px;
            right: -2px;
            height: 3px;
            background: linear-gradient(90deg, transparent, var(--primary), var(--primary-dark), var(--primary), transparent);
            background-size: 300% 100%;
            animation: borderGlow 4s linear infinite;
            border-radius: 24px 24px 0 0;
        }

        @keyframes borderGlow {
            0% { background-position: 0% 0%; }
            100% { background-position: 300% 0%; }
        }

        .brand {
            text-align: center;
            margin-bottom: 32px;
        }

        .brand-logo {
            display: inline-flex;
            align-items: baseline;
            gap: 2px;
            text-decoration: none;
            font-size: 36px;
            font-weight: 900;
            font-style: italic;
        }
        .brand-logo .gr {
            color: #fff;
            letter-spacing: -2px;
            text-shadow: 0 0 30px rgba(237,28,36,0.3);
        }
        .brand-logo .motors {
            color: var(--primary);
            font-style: normal;
            font-size: 15px;
            font-weight: 700;
            transform: translateY(8px);
        }

        .brand-desc {
            margin-top: 12px;
            font-size: 14px;
            color: var(--text-muted);
        }

        .form-header {
            text-align: center;
            margin-bottom: 32px;
        }
        .form-header h1 {
            font-size: 22px;
            font-weight: 800;
            margin-bottom: 6px;
        }
        .form-header p {
            color: var(--text-muted);
            font-size: 13px;
        }

        .form-group {
            margin-bottom: 22px;
        }

        .form-label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: var(--text-muted);
            margin-bottom: 8px;
            text-align: {{ App::getLocale() == 'ar' ? 'right' : 'left' }};
        }

        .input-wrapper {
            position: relative;
        }

        .input-wrapper i {
            position: absolute;
            {{ App::getLocale() == 'ar' ? 'right' : 'left' }}: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            font-size: 18px;
            transition: color 0.3s;
            z-index: 1;
        }

        .form-control {
            width: 100%;
            background: var(--input-bg);
            border: 1.5px solid var(--border-color);
            padding: 14px {{ App::getLocale() == 'ar' ? '48px 14px 16px' : '16px 14px 48px' }};
            border-radius: 12px;
            color: #fff;
            font-size: 15px;
            transition: all 0.3s ease;
            outline: none;
            direction: {{ App::getLocale() == 'ar' ? 'rtl' : 'ltr' }};
        }

        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(237,28,36,0.08), 0 0 20px rgba(237,28,36,0.03);
            background: #1e1e1e;
        }

        .form-control:focus ~ i,
        .input-wrapper:focus-within i {
            color: var(--primary);
        }

        .form-control::placeholder {
            color: rgba(138,143,152,0.4);
        }

        .form-control:-webkit-autofill,
        .form-control:-webkit-autofill:hover,
        .form-control:-webkit-autofill:focus {
            -webkit-text-fill-color: #fff;
            -webkit-box-shadow: 0 0 0px 1000px var(--input-bg) inset;
            transition: background-color 5000s ease-in-out 0s;
        }

        .field-hint {
            display: block;
            font-size: 12px;
            color: rgba(138,143,152,0.6);
            margin-top: 6px;
            text-align: {{ App::getLocale() == 'ar' ? 'right' : 'left' }};
        }

        .btn-submit {
            width: 100%;
            padding: 16px;
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
            box-shadow: 0 10px 30px rgba(237,28,36,0.25);
            position: relative;
            overflow: hidden;
        }

        .btn-submit::before {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, transparent, rgba(255,255,255,0.1), transparent);
            transform: translateX(-100%);
            transition: transform 0.5s ease;
        }
        .btn-submit:hover::before { transform: translateX(100%); }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 40px rgba(237,28,36,0.4);
        }

        .btn-submit:active {
            transform: translateY(0);
            box-shadow: 0 5px 15px rgba(237,28,36,0.3);
        }

        .btn-submit.loading {
            pointer-events: none;
            opacity: 0.85;
        }
        .btn-submit .spinner {
            display: none;
            width: 20px; height: 20px;
            border: 2.5px solid rgba(255,255,255,0.3);
            border-top-color: #fff;
            border-radius: 50%;
            animation: spin 0.6s linear infinite;
        }
        .btn-submit.loading .spinner { display: inline-block; }
        .btn-submit.loading .btn-text { display: none; }
        .btn-submit.loading .btn-arrow { display: none; }

        .btn-submit.loading.btn--success {
            background: linear-gradient(135deg, #16a34a, #15803d);
            box-shadow: 0 10px 30px rgba(22,163,74,0.25);
        }

        @keyframes spin { to { transform: rotate(360deg); } }

        .footer-links {
            text-align: center;
            margin-top: 24px;
        }

        .footer-links a {
            color: var(--text-muted);
            text-decoration: none;
            font-size: 13px;
            transition: color 0.3s;
        }
        .footer-links a:hover { color: var(--primary); }
        .footer-links .sep {
            color: var(--border-color);
            margin: 0 10px;
        }

        .footer-copy {
            text-align: center;
            margin-top: 28px;
            font-size: 12px;
            color: var(--text-muted);
            opacity: 0.5;
        }

        .error-msg {
            background: rgba(237,28,36,0.08);
            color: var(--primary);
            padding: 14px 16px;
            border-radius: 12px;
            font-size: 13px;
            margin-bottom: 24px;
            text-align: center;
            border: 1px solid rgba(237,28,36,0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            animation: shakeX 0.5s ease;
        }

        @keyframes shakeX {
            0%, 100% { transform: translateX(0); }
            20% { transform: translateX(-8px); }
            40% { transform: translateX(8px); }
            60% { transform: translateX(-6px); }
            80% { transform: translateX(6px); }
        }

        @media (max-width: 480px) {
            .login-card { padding: 32px 20px; }
            .login-wrapper { padding: 12px; }
            .brand-logo { font-size: 30px; }
            .form-header h1 { font-size: 19px; }
        }
    </style>
</head>
<body>

    <div class="orb orb--1"></div>
    <div class="orb orb--2"></div>
    <canvas id="particles-canvas"></canvas>

    <div class="login-wrapper">
        <div class="login-card">

            <div class="brand">
                <a href="{{ route('store.home') }}" class="brand-logo">
                    <span class="gr">GR</span>
                    <span class="motors">MOTORS</span>
                </a>
                <p class="brand-desc">{{ __('وجهتك الأولى للسيارات الفاخرة') }}</p>
            </div>

            <div class="form-header">
                <h1>{{ __('مرحباً بك مجدداً') }}</h1>
                <p>{{ __('سجل الدخول لمتابعة حجوزاتك وطلباتك') }}</p>
            </div>

            @if($errors->any())
                <div class="error-msg">
                    <i class="bi bi-exclamation-circle"></i>
                    <span>{{ $errors->first() }}</span>
                </div>
            @endif

            <form action="{{ route('store.auth.login.post') }}" method="POST" id="loginForm">
                @csrf

                <div class="form-group">
                    <label class="form-label">{{ __('رقم الموبايل') }}</label>
                    <div class="input-wrapper">
                        <i class="bi bi-phone"></i>
                        <input type="tel" name="phone" class="form-control" placeholder="05XXXXXXXX" required dir="ltr" inputmode="numeric" pattern="[0-9]{10,}">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">{{ __('كلمة المرور') }} <span style="color:rgba(138,143,152,0.5);font-weight:400;">({{ __('اختياري') }})</span></label>
                    <div class="input-wrapper">
                        <i class="bi bi-lock"></i>
                        <input type="password" name="password" class="form-control" placeholder="****" dir="{{ App::getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
                    </div>
                    <span class="field-hint">
                        <i class="bi bi-info-circle"></i>
                        {{ __('إذا كان هذا أول دخول لك، سيتم إنشاء حسابك تلقائياً') }}
                    </span>
                </div>

                <button type="submit" class="btn-submit" id="loginBtn">
                    <span class="btn-arrow"><i class="bi bi-arrow-{{ App::getLocale() == 'ar' ? 'left' : 'right' }}-short" style="font-size: 24px;"></i></span>
                    <span class="btn-text">{{ __('دخول / تسجيل') }}</span>
                    <span class="spinner"></span>
                </button>
            </form>

            <div class="footer-links">
                <a href="{{ route('store.home') }}">
                    <i class="bi bi-house-door"></i> {{ __('العودة للرئيسية') }}
                </a>
                <span class="sep">|</span>
                <a href="{{ route('store.cars.index') }}">
                    <i class="bi bi-car-front"></i> {{ __('تصفح السيارات') }}
                </a>
            </div>
        </div>

        <div class="footer-copy">
            &copy; {{ date('Y') }} GR Motors. {{ __('جميع الحقوق محفوظة') }}
        </div>
    </div>

    <script>
    (function () {
        // ====== Particles ======
        (function () {
            const canvas = document.getElementById('particles-canvas');
            if (!canvas) return;
            const ctx = canvas.getContext('2d');
            let W, H, particles = [];

            function resize() {
                W = canvas.width = window.innerWidth;
                H = canvas.height = window.innerHeight;
            }
            function rand(a, b) { return a + Math.random() * (b - a); }
            function mk() {
                return {
                    x: rand(0, W), y: rand(0, H), r: rand(1.5, 4),
                    dx: rand(-0.3, 0.3), dy: rand(-0.6, -0.15),
                    alpha: rand(0.08, 0.35),
                    color: Math.random() > 0.5 ? '#ED1C24' : '#ffffff',
                };
            }
            function init() {
                resize(); particles = [];
                const n = Math.min(60, Math.floor(W * H / 18000));
                for (let i = 0; i < n; i++) particles.push(mk());
            }
            function tick() {
                ctx.clearRect(0, 0, W, H);
                for (const p of particles) {
                    ctx.beginPath(); ctx.arc(p.x, p.y, p.r, 0, Math.PI * 2);
                    ctx.fillStyle = p.color; ctx.globalAlpha = p.alpha; ctx.fill();
                    p.x += p.dx; p.y += p.dy; p.alpha -= 0.0008;
                    if (p.alpha <= 0 || p.y < -10) {
                        Object.assign(p, mk()); p.y = H + 5; p.alpha = rand(0.08, 0.35);
                    }
                }
                ctx.globalAlpha = 1;
                requestAnimationFrame(tick);
            }
            window.addEventListener('resize', init);
            init(); tick();
        })();

        // ====== Loading State ======
        const form = document.getElementById('loginForm');
        const btn = document.getElementById('loginBtn');

        if (form && btn) {
            form.addEventListener('submit', function () {
                btn.classList.add('loading');
            });
        }
    })();
    </script>

</body>
</html>