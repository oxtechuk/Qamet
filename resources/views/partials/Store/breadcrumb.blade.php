@php
    $breadcrumbBg = \App\Models\Setting::where('key', 'breadcrumb_bg')->first()?->value;
    $defaultBg = 'https://images.unsplash.com/photo-1492144534655-ae79c964c9d7?q=80&w=1920&auto=format&fit=crop';
    $bgUrl = $breadcrumbBg ? asset('storage/' . $breadcrumbBg) : $defaultBg;
    $bgStyle = "background-image: url('" . $bgUrl . "');";
@endphp

<section class="breadcrumb__section" style="{{ $bgStyle }}">
    <div class="container breadcrumb__container">
        @yield('breadcrumb-content')
    </div>
    
    {{-- Wave Decoration --}}
    <div class="breadcrumb__wave">
        <svg viewBox="0 0 1440 320" preserveAspectRatio="none">
            <path fill="#ffffff" d="M0,192L48,197.3C96,203,192,213,288,229.3C384,245,480,267,576,250.7C672,235,768,181,864,181.3C960,181,1056,235,1152,234.7C1248,235,1344,181,1392,154.7L1440,128L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
        </svg>
    </div>
</section>

<style>
    .breadcrumb__section {
        height: 500px;
        width: 100%;
        max-width: auto;
        margin: 0 auto;
        position: relative;
        padding: 40px 0;
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        color: #fff;
        overflow: hidden;
    }
    .breadcrumb__section::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        z-index: 1;
    }
    .breadcrumb__container {
        position: relative;
        z-index: 2;
    }
    .breadcrumb__title {
        font-size: clamp(32px, 5vw, 56px);
        font-weight: 900;
        margin-bottom: 15px;
        text-shadow: 0 4px 20px rgba(0,0,0,0.5);
        letter-spacing: -1px;
    }
    .breadcrumb__links {
        display: flex;
        gap: 12px;
        justify-content: center;
        align-items: center;
        font-weight: 700;
        font-size: 15px;
        background: rgba(255,255,255,0.1);
        padding: 10px 28px;
        border-radius: 50px;
        backdrop-filter: blur(10px);
        width: fit-content;
        margin: 0 auto;
        border: 1px solid rgba(255,255,255,0.1);
    }
    .breadcrumb__links a {
        color: rgba(255,255,255,0.8);
        transition: 0.3s;
    }
    .breadcrumb__links a:hover {
        color: #fff;
        transform: scale(1.05);
    }
    .breadcrumb__separator {
        font-size: 12px;
        opacity: 0.6;
    }
    .breadcrumb__link--active {
        color: #fff;
        opacity: 0.9;
    }
    .breadcrumb__wave {
        position: absolute;
        bottom: -1px;
        left: 0;
        width: 100%;
        height: 120px;
        z-index: 3;
        line-height: 0;
    }
    .breadcrumb__wave svg {
        width: 100%;
        height: 100%;
    }

    @media (max-width: 768px) {
        .breadcrumb__section {
            height: 260px;
            padding: 20px 0;
        }
        .breadcrumb__wave {
            height: 60px;
        }
        .breadcrumb__title {
            font-size: 28px !important;
        }
    }

    @media (max-width: 480px) {
        .breadcrumb__section {
            height: 200px;
            padding: 16px 0;
        }
        .breadcrumb__wave {
            height: 40px;
        }
        .breadcrumb__title {
            font-size: 22px !important;
            letter-spacing: 0 !important;
        }
        .breadcrumb__links {
            font-size: 13px;
            padding: 8px 18px;
        }
    }

</style>
