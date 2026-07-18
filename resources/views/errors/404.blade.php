@extends('store.layouts.app')

@section('title', __('الصفحة غير موجودة') . ' — GR Motors')

@section('css')
<style>
    /* ============================================================
       404 PAGE — GR MOTORS BRAND
    ============================================================ */

    /* Dark bg for the content area only */
    .err404-wrap {
        position: relative;
        background: #0a0a0a;
        overflow: hidden;
    }

    /* ---- Particles Canvas ---- */
    #particles-canvas {
        position: absolute;
        inset: 0;
        z-index: 0;
        pointer-events: none;
    }

    /* ---- Background Orbs ---- */
    .orb {
        position: absolute;
        border-radius: 50%;
        filter: blur(90px);
        opacity: 0.18;
        animation: orbFloat 10s ease-in-out infinite;
        pointer-events: none;
    }

    .orb--1 {
        width: 600px; height: 600px;
        background: radial-gradient(circle, #ED1C24, transparent);
        top: -200px; right: -100px;
        animation-delay: 0s;
    }

    .orb--2 {
        width: 400px; height: 400px;
        background: radial-gradient(circle, #8A1217, transparent);
        bottom: -100px; left: -50px;
        animation-delay: 5s;
    }

    @keyframes orbFloat {
        0%, 100% { transform: translate(0, 0) scale(1); }
        50%       { transform: translate(30px, -30px) scale(1.05); }
    }

    /* ---- Main Layout ---- */
    .err404-inner {
        background-color:#0000);
        position: relative;
        z-index: 1;
        min-height: 70vh;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 60px 24px 80px;
        text-align: center;
        color: #000;
    }

    /* ---- 404 Number ---- */
    .error-code {
        font-size: clamp(110px, 20vw, 220px);
        font-weight: 900;
        line-height: 1;
        letter-spacing: -8px;
        display: inline-block;
        margin-bottom: -10px;
    }

    .error-code__digit {
        display: inline-block;
        animation: digitBounce 2.5s ease-in-out infinite;
    }

    .error-code__digit:nth-child(1) { animation-delay: 0s; }
    .error-code__digit:nth-child(2) {
        background: linear-gradient(135deg, #ED1C24, #ff6b6b, #ED1C24);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        filter: drop-shadow(0 0 30px rgba(237,28,36,0.8));
        animation-delay: 0.2s;
    }
    .error-code__digit:nth-child(3) { animation-delay: 0.4s; }

    @keyframes digitBounce {
        0%, 100% { transform: translateY(0); }
        40%       { transform: translateY(-18px); }
        60%       { transform: translateY(-10px); }
    }

    /* ---- Car SVG ---- */
    .car-wrap {
        position: relative;
        width: 100%;
        max-width: 520px;
        margin: 0 auto 16px;
    }

    .car-svg {
        width: 100%;
        height: auto;
        animation: carRide 4s ease-in-out infinite;
        filter: drop-shadow(0 20px 40px rgba(237,28,36,0.25));
    }

    @keyframes carRide {
        0%, 100% { transform: translateY(0) rotate(-0.5deg); }
        50%       { transform: translateY(-14px) rotate(0.5deg); }
    }

    /* ---- Ground ---- */
    .ground {
        width: 100%;
        max-width: 520px;
        height: 3px;
        background: linear-gradient(90deg, transparent, rgba(237,28,36,0.65), transparent);
        border-radius: 50%;
        margin: 0 auto;
        animation: groundGlow 4s ease-in-out infinite;
        box-shadow: 0 0 20px rgba(237,28,36,0.4);
    }

    @keyframes groundGlow {
        0%, 100% { opacity: 0.6; transform: scaleX(0.8); }
        50%       { opacity: 1;   transform: scaleX(1); }
    }

    /* ---- Dust ---- */
    .dust {
        position: absolute;
        bottom: -4px;
        width: 80px; height: 20px;
        background: radial-gradient(ellipse at center, rgba(237,28,36,0.3), transparent);
        border-radius: 50%;
        animation: dustPuff 1.5s ease-out infinite;
    }
    .dust--left  { left: 70px;  animation-delay: 0s; }
    .dust--right { right: 70px; animation-delay: 0.75s; }

    @keyframes dustPuff {
        0%   { opacity: 0.8; transform: scale(0.5) translateY(0); }
        100% { opacity: 0;   transform: scale(2) translateY(-10px); }
    }

    /* ---- Divider ---- */
    .err-divider {
        width: 60px; height: 3px;
        background: linear-gradient(90deg, #ED1C24, #8A1217);
        border-radius: 2px;
        margin: 22px auto 26px;
    }

    /* ---- Text ---- */
    .error-title {
        font-size: clamp(22px, 4vw, 36px);
        font-weight: 900;
        color: #000;
        margin-bottom: 12px;
        line-height: 1.35;
    }

    .error-title span {
        background: linear-gradient(135deg, #ED1C24, #ff6b6b);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .error-subtitle {
        font-size: clamp(14px, 2vw, 16px);
        color: rgba(255,255,255,0.5);
        max-width: 460px;
        margin: 0 auto 36px;
        line-height: 1.8;
    }

    /* ---- Buttons ---- */
    .err-btn-group {
        display: flex;
        gap: 14px;
        justify-content: center;
        flex-wrap: wrap;
    }

    .btn-404 {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 14px 32px;
        border-radius: 50px;
        font-family: inherit;
        font-size: 15px;
        font-weight: 800;
        text-decoration: none;
        transition: all 0.3s ease;
        cursor: pointer;
        border: none;
    }

    .btn-404--primary {
        background: linear-gradient(135deg, #ED1C24, #8A1217);
        color: var(--color-red);
        box-shadow: 0 8px 28px rgba(237,28,36,0.35);
    }
    .btn-404--primary:hover {
        color: var(--color-red);
        transform: translateY(-3px);
        box-shadow: 0 14px 40px rgba(237,28,36,0.5);
    }

    .btn-404--ghost {
        background: rgba(255,255,255,0.07);
        color: rgba(255,255,255,0.85);
        border: 1.5px solid rgba(255,255,255,0.15);
        backdrop-filter: blur(8px);
    }
    .btn-404--ghost:hover {
        color: var(--color-red);
        background: rgba(255,255,255,0.13);
        border-color: rgba(255,255,255,0.3);
        transform: translateY(-3px);
    }

    /* ---- Quick Links ---- */
    .quick-links {
        display: flex;
        gap: 8px;
        justify-content: center;
        flex-wrap: wrap;
        margin-top: 32px;
    }

    .quick-link {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 20px;
        border-radius: 50px;
        font-size: 13px;
        font-weight: 700;
        background: rgba(255,255,255,0.06);
        border: 1px solid rgba(255,255,255,0.08);
        color: rgba(255,255,255,0.65);
        text-decoration: none;
        transition: all 0.25s ease;
    }
    .quick-link:hover {
        background: rgba(237,28,36,0.15);
        border-color: rgba(237,28,36,0.4);
        color: var(--color-red);
    }
    .quick-link i { font-size: 14px; color: #ED1C24; }

    /* ---- Responsive ---- */
    @media (max-width: 480px) {
        .error-code { letter-spacing: -4px; }
        .car-wrap   { max-width: 300px; }
        .err-btn-group { flex-direction: column; align-items: center; }
        .btn-404    { width: 100%; max-width: 280px; justify-content: center; }
        .quick-links { gap: 6px; }
        .quick-link { font-size: 12px; padding: 7px 14px; }
        .err404-inner { padding: 40px 16px 60px; }
    }
</style>
@endsection

@section('content')

<div class="err404-wrap">

    {{-- Background Orbs --}}
    <div class="orb orb--1"></div>
    <div class="orb orb--2"></div>

    {{-- Particles Canvas --}}
    <canvas id="particles-canvas"></canvas>

    <div class="err404-inner">

        {{-- 404 Number --}}
        <div class="error-code" aria-label="404">
            <span class="error-code__digit">4</span>
            <span class="error-code__digit">0</span>
            <span class="error-code__digit">4</span>
        </div>

        {{-- Car Illustration --}}
        <div class="car-wrap">
            <svg class="car-svg" viewBox="0 0 560 220" fill="none" xmlns="http://www.w3.org/2000/svg">
                <ellipse cx="280" cy="195" rx="220" ry="12" fill="rgba(237,28,36,0.15)"/>

                <path d="M60 150 L80 150 L100 100 L160 80 L220 68 L340 68 L420 82 L470 100 L500 150 L60 150Z"
                      fill="#1a1a1a" stroke="#333" stroke-width="1.5"/>
                <path d="M100 130 L460 130 L500 150 L60 150 Z" fill="url(#redStripe)"/>
                <path d="M170 68 L200 40 L260 30 L320 30 L380 40 L410 68 Z" fill="#222" stroke="#444" stroke-width="1"/>
                <path d="M185 67 L210 45 L260 35 L300 35 L340 45 L355 67 Z"
                      fill="rgba(100,180,255,0.15)" stroke="rgba(100,180,255,0.3)" stroke-width="1"/>
                <path d="M155 67 L185 67 L185 95 L145 95 Z"
                      fill="rgba(100,180,255,0.12)" stroke="rgba(100,180,255,0.25)" stroke-width="1"/>
                <path d="M355 67 L400 67 L415 95 L355 95 Z"
                      fill="rgba(100,180,255,0.12)" stroke="rgba(100,180,255,0.25)" stroke-width="1"/>
                <line x1="270" y1="70" x2="270" y2="145" stroke="#333" stroke-width="1.5"/>

                <ellipse cx="492" cy="120" rx="14" ry="10" fill="#ED1C24" opacity="0.9"/>
                <ellipse cx="492" cy="120" rx="8"  ry="6"  fill="#ff9999"/>
                <ellipse cx="510" cy="120" rx="20" ry="8"  fill="rgba(237,28,36,0.3)"/>
                <ellipse cx="68"  cy="122" rx="12" ry="9"  fill="#cc0000" opacity="0.9"/>
                <ellipse cx="68"  cy="122" rx="7"  ry="5"  fill="#ff6666"/>

                <path d="M488 140 L510 142 L514 152 L490 155 Z" fill="#222" stroke="#ED1C24" stroke-width="1.5"/>
                <path d="M72 140 L50 142 L46 152 L70 155 Z"    fill="#222" stroke="#555"    stroke-width="1"/>

                <path d="M100 150 Q140 110 180 150" fill="#0a0a0a" stroke="#333" stroke-width="2"/>
                <path d="M370 150 Q410 110 450 150" fill="#0a0a0a" stroke="#333" stroke-width="2"/>

                {{-- Front Wheel --}}
                <circle cx="410" cy="162" r="32" fill="#111" stroke="#ED1C24" stroke-width="3"/>
                <circle cx="410" cy="162" r="22" fill="#1a1a1a" stroke="#333" stroke-width="1"/>
                <circle cx="410" cy="162" r="10" fill="#ED1C24"/>
                <circle cx="410" cy="162" r="5"  fill="var(--color-red)"/>
                <line x1="410" y1="142" x2="410" y2="182" stroke="#555" stroke-width="2"/>
                <line x1="390" y1="162" x2="430" y2="162" stroke="#555" stroke-width="2"/>
                <line x1="396" y1="148" x2="424" y2="176" stroke="#555" stroke-width="1.5"/>
                <line x1="424" y1="148" x2="396" y2="176" stroke="#555" stroke-width="1.5"/>

                {{-- Rear Wheel --}}
                <circle cx="148" cy="162" r="32" fill="#111" stroke="#555" stroke-width="2.5"/>
                <circle cx="148" cy="162" r="22" fill="#1a1a1a" stroke="#333" stroke-width="1"/>
                <circle cx="148" cy="162" r="10" fill="#333"/>
                <circle cx="148" cy="162" r="5"  fill="#555"/>
                <line x1="148" y1="142" x2="148" y2="182" stroke="#444" stroke-width="2"/>
                <line x1="128" y1="162" x2="168" y2="162" stroke="#444" stroke-width="2"/>
                <line x1="134" y1="148" x2="162" y2="176" stroke="#444" stroke-width="1.5"/>
                <line x1="162" y1="148" x2="134" y2="176" stroke="#444" stroke-width="1.5"/>

                {{-- GR Badge --}}
                <rect x="250" y="100" width="60" height="26" rx="6" fill="url(#badgeGrad)" opacity="0.9"/>
                <text x="280" y="118" text-anchor="middle" font-family="Cairo,sans-serif" font-size="13" font-weight="900" fill="white">GR</text>

                {{-- Road markings --}}
                <rect x="90"  y="198" width="50" height="4" rx="2" fill="rgba(255,255,255,0.15)"/>
                <rect x="200" y="198" width="30" height="4" rx="2" fill="rgba(255,255,255,0.1)"/>
                <rect x="310" y="198" width="50" height="4" rx="2" fill="rgba(255,255,255,0.15)"/>
                <rect x="420" y="198" width="30" height="4" rx="2" fill="rgba(255,255,255,0.1)"/>

                <defs>
                    <linearGradient id="redStripe" x1="0%" y1="0%" x2="100%" y2="0%">
                        <stop offset="0%"   stop-color="#ED1C24" stop-opacity="0.7"/>
                        <stop offset="50%"  stop-color="#ED1C24" stop-opacity="0.9"/>
                        <stop offset="100%" stop-color="#5A0D10" stop-opacity="0.5"/>
                    </linearGradient>
                    <linearGradient id="badgeGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                        <stop offset="0%"   stop-color="#ED1C24"/>
                        <stop offset="100%" stop-color="#8A1217"/>
                    </linearGradient>
                </defs>
            </svg>

            <div class="dust dust--left"></div>
            <div class="dust dust--right"></div>
        </div>

        {{-- Ground --}}
        <div class="ground"></div>

        {{-- Divider --}}
        <div class="err-divider"></div>

        {{-- Text --}}
        <h1 class="error-title">
            {{ __('عُذراً! هذه الصفحة') }} <span>{{ __('غير موجودة') }}</span>
        </h1>

        <p class="error-subtitle">
            {{ __('يبدو أن هذه الصفحة انطلقت بسرعة كبيرة ولم نتمكن من اللحاق بها. دعنا نعود إلى الطريق الصحيح.') }}
        </p>

        {{-- Buttons --}}
        <div class="err-btn-group">
            <a href="{{ route('store.home') }}" class="btn-404 btn-404--primary">
                <i class="bi bi-house-door-fill"></i>
                {{ __('الصفحة الرئيسية') }}
            </a>
            <a href="{{ route('store.home') }}" class="btn-404 btn-404--ghost">
                <i class="bi bi-car-front-fill"></i>
                {{ __('تصفح السيارات') }}
            </a>
        </div>

        {{-- Quick Links --}}
        <div class="quick-links">
            <a href="{{ route('store.home') }}" class="quick-link">
                <i class="bi bi-house-door-fill"></i> {{ __('الصفحة الرئيسية') }}
            </a>
            <a href="{{ route('store.home') }}" class="quick-link">
                <i class="bi bi-info-circle-fill"></i> {{ __('من نحن') }}
            </a>
        </div>

    </div>{{-- /.err404-inner --}}
</div>{{-- /.err404-wrap --}}

@endsection

@section('js')
<script>
(function () {
    const canvas = document.getElementById('particles-canvas');
    if (!canvas) return;
    const ctx = canvas.getContext('2d');
    let W, H, particles = [];

    function resize() {
        const wrap = canvas.parentElement;
        W = canvas.width  = wrap.offsetWidth;
        H = canvas.height = wrap.offsetHeight;
    }

    function rand(a, b) { return a + Math.random() * (b - a); }

    function mk() {
        return {
            x: rand(0, W), y: rand(0, H),
            r: rand(1, 3),
            dx: rand(-0.4, 0.4), dy: rand(-0.8, -0.2),
            alpha: rand(0.1, 0.45),
            color: Math.random() > 0.6 ? '#ED1C24' : 'var(--color-red)fff',
        };
    }

    function init() {
        resize();
        particles = [];
        const n = Math.min(80, Math.floor(W * H / 14000));
        for (let i = 0; i < n; i++) particles.push(mk());
    }

    function tick() {
        ctx.clearRect(0, 0, W, H);
        for (const p of particles) {
            ctx.beginPath();
            ctx.arc(p.x, p.y, p.r, 0, Math.PI * 2);
            ctx.fillStyle  = p.color;
            ctx.globalAlpha = p.alpha;
            ctx.fill();
            p.x += p.dx; p.y += p.dy; p.alpha -= 0.0012;
            if (p.alpha <= 0 || p.y < -10) {
                Object.assign(p, mk());
                p.y = H + 5;
                p.alpha = rand(0.1, 0.45);
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
@endsection
