<!DOCTYPE html>
<html lang="{{ App::getLocale() }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('تسجيل دخول المديرين | GR Motors') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        :root {
            --primary: #ee1e26;
            --primary-dark: #b0000a;
            --primary-glow: rgba(238, 30, 38, 0.3);
            --dark-bg: #0d121c;
            --card-bg: #161c28;
            --input-bg: #1e2634;
            --text-white: #ffffff;
            --text-muted: #99a1af;
            --border-color: #2a3441;
            --success: #12b76a;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Cairo', sans-serif; }

        body {
            background-color: var(--dark-bg);
            color: var(--text-white);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            position: relative;
        }

        #particles-canvas {
            position: fixed; inset: 0; z-index: 0; pointer-events: none;
        }

        .orb {
            position: fixed; border-radius: 50%; filter: blur(120px); opacity: 0.12; pointer-events: none;
            animation: orbFloat 12s ease-in-out infinite;
        }
        .orb--1 {
            width: 700px; height: 700px;
            background: radial-gradient(circle, var(--primary), transparent);
            top: -300px; {{ app()->getLocale() == 'ar' ? 'left' : 'right' }}: -150px;
            animation-delay: 0s;
        }
        .orb--2 {
            width: 500px; height: 500px;
            background: radial-gradient(circle, var(--primary-dark), transparent);
            bottom: -200px; {{ app()->getLocale() == 'ar' ? 'right' : 'left' }}: -100px;
            animation-delay: 6s;
        }
        @keyframes orbFloat {
            0%, 100% { transform: translate(0, 0) scale(1); }
            50% { transform: translate(40px, -40px) scale(1.08); }
        }

        .login-wrapper {
            width: 100%;
            max-width: 440px;
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
            padding: 48px;
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
            height: 4px;
            background: linear-gradient(90deg, transparent, var(--primary), var(--primary-dark), var(--primary), transparent);
            background-size: 300% 100%;
            animation: borderGlow 4s linear infinite;
            border-radius: 24px 24px 0 0;
        }

        @keyframes borderGlow {
            0% { background-position: 0% 0%; }
            100% { background-position: 300% 0%; }
        }

        .login-card::after {
            content: "";
            position: absolute;
            inset: -1px;
            border-radius: 24px;
            padding: 1px;
            background: linear-gradient(135deg, transparent 40%, rgba(238,30,38,0.15), transparent 60%);
            -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
            -webkit-mask-composite: xor;
            mask-composite: exclude;
            pointer-events: none;
        }

        .logo-section {
            text-align: center;
            margin-bottom: 36px;
        }

        .logo-text {
            font-size: 34px;
            font-weight: 900;
            font-style: italic;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 4px;
            position: relative;
        }

        .logo-gr {
            color: #fff;
            letter-spacing: -2px;
            text-shadow: 0 0 30px rgba(238,30,38,0.3);
        }
        .logo-motors {
            color: var(--primary);
            font-style: normal;
            font-size: 15px;
            font-weight: 700;
            transform: translateY(8px);
            letter-spacing: 1px;
        }

        .logo-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            margin-top: 8px;
            padding: 5px 16px;
            background: rgba(238,30,38,0.08);
            border: 1px solid rgba(238,30,38,0.15);
            border-radius: 50px;
            font-size: 11px;
            color: var(--text-muted);
            font-weight: 600;
        }
        .logo-badge i { font-size: 10px; color: var(--primary); }

        .form-header {
            text-align: center;
            margin-bottom: 32px;
        }

        .form-header h1 {
            font-size: 24px;
            font-weight: 800;
            margin-bottom: 8px;
        }

        .form-header p {
            color: var(--text-muted);
            font-size: 14px;
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
            text-align: {{ app()->getLocale() == 'ar' ? 'right' : 'left' }};
            transition: color 0.3s;
        }

        .input-wrapper {
            position: relative;
        }

        .input-wrapper i {
            position: absolute;
            {{ app()->getLocale() == 'ar' ? 'right' : 'left' }}: 16px;
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
            padding: 14px {{ app()->getLocale() == 'ar' ? '48px 14px 16px' : '16px 14px 48px' }};
            border-radius: 12px;
            color: #fff;
            font-size: 15px;
            transition: all 0.3s ease;
            outline: none;
            direction: {{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }};
            position: relative;
        }

        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(238, 30, 38, 0.1), 0 0 20px rgba(238,30,38,0.05);
            background: #202a3a;
        }

        .form-control:focus ~ i,
        .input-wrapper:focus-within i {
            color: var(--primary);
        }

        .form-control::placeholder {
            color: rgba(153,161,175,0.4);
            font-weight: 400;
        }

        .form-control:-webkit-autofill,
        .form-control:-webkit-autofill:hover,
        .form-control:-webkit-autofill:focus {
            -webkit-text-fill-color: #fff;
            -webkit-box-shadow: 0 0 0px 1000px var(--input-bg) inset;
            transition: background-color 5000s ease-in-out 0s;
        }

        .remember-row {
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 10px;
            direction: {{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }};
        }

        .remember-row input[type="checkbox"] {
            width: 18px; height: 18px;
            accent-color: var(--primary);
            cursor: pointer;
            border-radius: 4px;
            flex-shrink: 0;
        }

        .remember-row label {
            font-size: 13px;
            color: var(--text-muted);
            cursor: pointer;
            user-select: none;
            transition: color 0.3s;
        }
        .remember-row label:hover { color: rgba(255,255,255,0.7); }

        .btn-login {
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
            box-shadow: 0 10px 30px rgba(238, 30, 38, 0.25);
            position: relative;
            overflow: hidden;
        }

        .btn-login::before {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, transparent, rgba(255,255,255,0.08), transparent);
            transform: translateX(-100%);
            transition: transform 0.5s ease;
        }
        .btn-login:hover::before { transform: translateX(100%); }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 40px rgba(238, 30, 38, 0.4);
        }

        .btn-login:active {
            transform: translateY(0);
            box-shadow: 0 5px 15px rgba(238, 30, 38, 0.3);
        }

        .btn-login.loading {
            pointer-events: none;
            opacity: 0.85;
        }

        .btn-login .spinner {
            display: none;
            width: 20px; height: 20px;
            border: 2.5px solid rgba(255,255,255,0.3);
            border-top-color: #fff;
            border-radius: 50%;
            animation: spin 0.6s linear infinite;
        }

        .btn-login.loading .spinner { display: inline-block; }
        .btn-login.loading .btn-text { display: none; }
        .btn-login.loading .btn-icon { display: none; }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        .error-message {
            background: rgba(238, 30, 38, 0.08);
            color: var(--primary);
            padding: 14px 16px;
            border-radius: 12px;
            font-size: 13px;
            margin-bottom: 24px;
            text-align: center;
            border: 1px solid rgba(238, 30, 38, 0.2);
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

        .error-message i { font-size: 16px; flex-shrink: 0; }

        .footer-text {
            text-align: center;
            margin-top: 28px;
            font-size: 12px;
            color: var(--text-muted);
            opacity: 0.6;
        }

        .footer-text a {
            color: var(--text-muted);
            text-decoration: none;
            transition: color 0.3s;
        }
        .footer-text a:hover { color: var(--primary); }

        /* Floating particles */
        .float-particle {
            position: fixed;
            border-radius: 50%;
            pointer-events: none;
            z-index: 0;
            opacity: 0;
            animation: floatUp linear infinite;
        }

        @keyframes floatUp {
            0% { opacity: 0; transform: translateY(0) scale(0); }
            10% { opacity: 0.5; }
            90% { opacity: 0.5; }
            100% { opacity: 0; transform: translateY(-100vh) scale(1); }
        }

        @media (max-width: 480px) {
            .login-card { padding: 32px 24px; }
            .login-wrapper { padding: 12px; }
            .logo-text { font-size: 28px; }
            .form-header h1 { font-size: 20px; }
        }
    </style>
</head>
<body>

    <div class="orb orb--1"></div>
    <div class="orb orb--2"></div>
    <canvas id="particles-canvas"></canvas>

    <div class="login-wrapper">
        <div class="login-card">

            <div class="logo-section">
                <div class="logo-text">
                    <span class="logo-gr">GR</span>
                    <span class="logo-motors">MOTORS</span>
                </div>
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
                    <span class="spinner"></span>
                </button>
            </form>

        </div>

        <div class="footer-text">
            &copy; {{ date('Y') }} <a href="{{ route('store.home') }}">GR Motors</a> Dashboard. All rights reserved.
        </div>
    </div>

    <script>
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
                color: Math.random() > 0.5 ? '#ee1e26' : '#ffffff',
            };
        }

        function init() {
            resize();
            particles = [];
            const n = Math.min(60, Math.floor(W * H / 18000));
            for (let i = 0; i < n; i++) particles.push(mk());
        }

        function tick() {
            ctx.clearRect(0, 0, W, H);
            for (const p of particles) {
                ctx.beginPath();
                ctx.arc(p.x, p.y, p.r, 0, Math.PI * 2);
                ctx.fillStyle = p.color;
                ctx.globalAlpha = p.alpha;
                ctx.fill();
                p.x += p.dx;
                p.y += p.dy;
                p.alpha -= 0.0008;
                if (p.alpha <= 0 || p.y < -10) {
                    Object.assign(p, mk());
                    p.y = H + 5;
                    p.alpha = rand(0.08, 0.35);
                }
            }
            ctx.globalAlpha = 1;
            requestAnimationFrame(tick);
        }

        window.addEventListener('resize', init);
        init();
        tick();
    })();

    // ====== Loading State ======
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('loginForm');
        const btn = document.getElementById('loginBtn');

        if (form && btn) {
            form.addEventListener('submit', function () {
                btn.classList.add('loading');
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