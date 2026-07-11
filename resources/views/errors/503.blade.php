<!DOCTYPE html>
<html lang="{{ App::getLocale() }}" dir="{{ App::getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
@php
    $settings = app(\App\Services\Cache\BaseCacheService::class)->rememberSettings();
    $contactEmail = $settings['contact_email'] ?? null;
@endphp
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('تحت الصيانة') }} — GR Motors</title>
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
            background: radial-gradient(circle, #ED1C24, transparent);
            top: -200px; {{ App::getLocale() == 'ar' ? 'left' : 'right' }}: -100px;
            animation-delay: 0s;
        }
        .orb--2 {
            width: 400px; height: 400px;
            background: radial-gradient(circle, #8A1217, transparent);
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
            max-width: 520px; width: 100%;
            animation: fadeUp 0.8s ease-out;
        }
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .icon-wrap {
            width: 120px; height: 120px;
            margin: 0 auto 24px;
            background: rgba(237,28,36,0.08);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            border: 2px solid rgba(237,28,36,0.2);
            animation: pulseGlow 3s ease-in-out infinite;
        }
        .icon-wrap i { font-size: 56px; color: #ED1C24; }
        @keyframes pulseGlow {
            0%, 100% { box-shadow: 0 0 20px rgba(237,28,36,0.2); border-color: rgba(237,28,36,0.2); }
            50% { box-shadow: 0 0 40px rgba(237,28,36,0.35); border-color: rgba(237,28,36,0.4); }
        }
        .error-code {
            font-size: clamp(80px, 16vw, 140px);
            font-weight: 900; line-height: 1;
            background: linear-gradient(135deg, #ED1C24, #ff6b6b, #ED1C24);
            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
            background-clip: text;
            filter: drop-shadow(0 0 30px rgba(237,28,36,0.4));
            margin-bottom: 8px;
        }
        .err-divider {
            width: 60px; height: 3px;
            background: linear-gradient(90deg, #ED1C24, #8A1217);
            border-radius: 2px; margin: 16px auto 20px;
        }
        .error-title {
            font-size: clamp(20px, 3.5vw, 28px);
            font-weight: 800; margin-bottom: 12px; line-height: 1.4;
        }
        .error-title span {
            background: linear-gradient(135deg, #ED1C24, #ff6b6b);
            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .error-subtitle {
            font-size: clamp(13px, 1.8vw, 15px);
            color: rgba(255,255,255,0.5);
            line-height: 1.8; margin-bottom: 36px;
        }
        .err-btn-group {
            display: flex; gap: 14px; justify-content: center; flex-wrap: wrap;
        }
        .btn-err {
            display: inline-flex; align-items: center; gap: 8px;
            padding: 14px 32px; border-radius: 50px;
            font-family: inherit; font-size: 15px; font-weight: 800;
            text-decoration: none; transition: all 0.3s ease; cursor: pointer; border: none;
        }
        .btn-err--primary {
            background: linear-gradient(135deg, #ED1C24, #8A1217);
            color: #fff; box-shadow: 0 8px 28px rgba(237,28,36,0.35);
        }
        .btn-err--primary:hover {
            color: #fff; transform: translateY(-3px);
            box-shadow: 0 14px 40px rgba(237,28,36,0.5);
        }
        .btn-err--ghost {
            background: rgba(255,255,255,0.07); color: rgba(255,255,255,0.85);
            border: 1.5px solid rgba(255,255,255,0.15); backdrop-filter: blur(8px);
        }
        .btn-err--ghost:hover {
            color: #fff; background: rgba(255,255,255,0.13);
            border-color: rgba(255,255,255,0.3); transform: translateY(-3px);
        }
        .tools-icon {
            animation: toolSpin 3s ease-in-out infinite;
        }
        @keyframes toolSpin {
            0%, 100% { transform: rotate(0deg) scale(1); }
            50% { transform: rotate(180deg) scale(0.9); }
        }
        .maintenance-badge {
            display: inline-block;
            padding: 6px 20px;
            border-radius: 50px;
            background: rgba(237,28,36,0.1);
            border: 1px solid rgba(237,28,36,0.2);
            color: #ff6b6b;
            font-size: 12px; font-weight: 700;
            margin-top: 24px;
        }
        @media (max-width: 480px) {
            .icon-wrap { width: 90px; height: 90px; }
            .icon-wrap i { font-size: 42px; }
            .err-btn-group { flex-direction: column; align-items: center; }
            .btn-err { width: 100%; max-width: 280px; justify-content: center; }
            .err-wrap { padding: 30px 16px; }
        }
    </style>
</head>
<body>
    <div class="orb orb--1"></div>
    <div class="orb orb--2"></div>
    <canvas id="particles-canvas"></canvas>

    <div class="err-wrap">
        <div class="icon-wrap">
            <i class="bi bi-tools tools-icon"></i>
        </div>
        <div class="error-code">503</div>
        <div class="err-divider"></div>
        <h1 class="error-title">{{ __('الموقع') }} <span>{{ __('تحت الصيانة') }}</span></h1>
        <p class="error-subtitle">{{ __('نقوم حالياً بإجراء بعض التحسينات على الموقع. سنعود قريباً بشكل أفضل. شكراً لتفهمك!') }}</p>
        <div class="err-btn-group">
            @if($contactEmail)
            <a href="mailto:{{ $contactEmail }}" class="btn-err btn-err--primary">
                <i class="bi bi-envelope-fill"></i>
                {{ __('تواصل معنا') }}
            </a>
            @endif
            <a href="{{ route('store.home') }}" class="btn-err btn-err--ghost">
                <i class="bi bi-arrow-clockwise"></i>
                {{ __('حاول مجدداً') }}
            </a>
        </div>
        <div class="maintenance-badge">
            <i class="bi bi-clock-history"></i>
            {{ __('سنعود قريباً') }}
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
                x: rand(0, W), y: rand(0, H), r: rand(1, 3),
                dx: rand(-0.4, 0.4), dy: rand(-0.8, -0.2),
                alpha: rand(0.1, 0.45),
                color: Math.random() > 0.6 ? '#ED1C24' : '#fff',
            };
        }
        function init() {
            resize(); particles = [];
            const n = Math.min(80, Math.floor(W * H / 14000));
            for (let i = 0; i < n; i++) particles.push(mk());
        }
        function tick() {
            ctx.clearRect(0, 0, W, H);
            for (const p of particles) {
                ctx.beginPath(); ctx.arc(p.x, p.y, p.r, 0, Math.PI * 2);
                ctx.fillStyle = p.color; ctx.globalAlpha = p.alpha; ctx.fill();
                p.x += p.dx; p.y += p.dy; p.alpha -= 0.0012;
                if (p.alpha <= 0 || p.y < -10) {
                    Object.assign(p, mk()); p.y = H + 5; p.alpha = rand(0.1, 0.45);
                }
            }
            ctx.globalAlpha = 1;
            requestAnimationFrame(tick);
        }
        window.addEventListener('resize', init);
        init(); tick();
    })();
    </script>
</body>
</html>