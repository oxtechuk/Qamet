<!DOCTYPE html>
<html lang="{{ App::getLocale() }}" dir="{{ App::getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('الصفحة غير موجودة') }} — Qemt Najd</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Cairo', sans-serif;
            background: #0a0a0a; color: #fff;
            min-height: 100vh; display: flex;
            align-items: center; justify-content: center;
            overflow: hidden; position: relative;
        }
        #particles-canvas { position: fixed; inset: 0; z-index: 0; pointer-events: none; }
        .orb {
            position: fixed; border-radius: 50%; filter: blur(90px); opacity: 0.18; pointer-events: none;
            animation: orbFloat 10s ease-in-out infinite;
        }
        .orb--1 {
            width: 600px; height: 600px;
            background: radial-gradient(circle, #dfc674, transparent);
            top: -200px; {{ App::getLocale() == 'ar' ? 'left' : 'right' }}: -100px;
            animation-delay: 0s;
        }
        .orb--2 {
            width: 400px; height: 400px;
            background: radial-gradient(circle, #9a7d32, transparent);
            bottom: -100px; {{ App::getLocale() == 'ar' ? 'right' : 'left' }}: -50px;
            animation-delay: 5s;
        }
        @keyframes orbFloat {
            0%, 100% { transform: translate(0, 0) scale(1); }
            50% { transform: translate(30px, -30px) scale(1.05); }
        }
        .err-wrap {
            position: relative; z-index: 1;
            text-align: center; padding: 40px 24px;
            max-width: 560px; width: 100%;
            animation: fadeUp 0.8s ease-out;
        }
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .error-code {
            font-size: clamp(90px, 18vw, 160px);
            font-weight: 900;
            line-height: 1;
            letter-spacing: -4px;
            display: inline-block;
            margin-bottom: 8px;
            background: linear-gradient(135deg, #dfc674, #fff, #dfc674);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            filter: drop-shadow(0 0 25px rgba(223, 198, 116, 0.4));
        }
        .error-title {
            font-size: 26px; font-weight: 800; margin-bottom: 12px; color: #fff;
        }
        .error-subtitle {
            font-size: 15px; color: #9ca3af; line-height: 1.6; margin-bottom: 28px;
        }
        .err-btn-group {
            display: flex; gap: 12px; justify-content: center; flex-wrap: wrap;
        }
        .btn-404 {
            padding: 12px 24px; border-radius: 12px; font-weight: 700;
            font-size: 14px; text-decoration: none; display: inline-flex;
            align-items: center; gap: 8px; transition: all 0.25s ease;
        }
        .btn-404--primary {
            background: #dfc674; color: #0a0a0a;
            box-shadow: 0 4px 15px rgba(223, 198, 116, 0.3);
        }
        .btn-404--primary:hover {
            background: #eddcb0; transform: translateY(-2px);
        }
        .btn-404--ghost {
            background: rgba(255, 255, 255, 0.06); color: #e5e7eb;
            border: 1px solid rgba(255, 255, 255, 0.12);
        }
        .btn-404--ghost:hover {
            background: rgba(255, 255, 255, 0.12); color: #fff; transform: translateY(-2px);
        }
    </style>
</head>
<body>
    <canvas id="particles-canvas"></canvas>
    <div class="orb orb--1"></div>
    <div class="orb orb--2"></div>

    <div class="err-wrap">
        <div class="error-code">404</div>
        <h1 class="error-title">{{ __('الصفحة غير موجودة') }}</h1>
        <p class="error-subtitle">
            {{ __('يبدو أن الرابط الذي تبحث عنه غير متاح أو تم نقله.') }}
        </p>

        <div class="err-btn-group">
            <a href="{{ Route::has('store.home') ? route('store.home') : url('/') }}" class="btn-404 btn-404--primary">
                <i class="bi bi-house-door-fill"></i>
                {{ __('الرئيسية') }}
            </a>
            <a href="{{ Route::has('store.home') ? route('store.home') : url('/') }}/cars" class="btn-404 btn-404--ghost">
                <i class="bi bi-car-front-fill"></i>
                {{ __('تصفح السيارات') }}
            </a>
        </div>
    </div>

    <script>
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
                x: rand(0, W), y: rand(0, H),
                r: rand(1, 3),
                dx: rand(-0.3, 0.3), dy: rand(-0.6, -0.1),
                alpha: rand(0.1, 0.4),
                color: Math.random() > 0.6 ? '#dfc674' : '#ffffff',
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
                p.x += p.dx; p.y += p.dy; p.alpha -= 0.001;
                if (p.alpha <= 0 || p.y < -10) {
                    Object.assign(p, mk());
                    p.y = H + 5;
                    p.alpha = rand(0.1, 0.4);
                }
            }
            ctx.globalAlpha = 1;
            requestAnimationFrame(tick);
        }

        window.addEventListener('resize', init);
        init();
        tick();
    })();
    </script>
</body>
</html>
