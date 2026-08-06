<x-filament-panels::layout.base :livewire="$livewire ?? null">
    @push('styles')
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

        <style>
            :root {
                --primary: #dfc674;
                --primary-hover: #f1db8b;
                --primary-gradient: linear-gradient(135deg, #dfc674 0%, #c9ad54 50%, #b8983b 100%);
                --primary-glow: rgba(223, 198, 116, 0.35);
                --bg-dark: #121318;
                --panel-bg: #181920;
                --form-bg: #181920;
                --input-bg: #121318;
                --text-light: #f8fafc;
                --text-muted: #94a3b8;
                --border-gold: rgba(223, 198, 116, 0.25);
                --border-glow: rgba(223, 198, 116, 0.4);
                --radius-lg: 24px;
                --radius-md: 14px;
            }

            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
                font-family: 'Cairo', sans-serif;
            }

            body {
                background-color: var(--bg-dark) !important;
                color: var(--text-light);
                min-height: 100vh;
                overflow-x: hidden;
                display: flex;
                align-items: center;
                justify-content: center;
                position: relative;
            }

            /* Dynamic Animated Background Blobs */
            .bg-blobs {
                position: absolute;
                inset: 0;
                overflow: hidden;
                z-index: 0;
                pointer-events: none;
            }

            .blob {
                position: absolute;
                border-radius: 50%;
                filter: blur(100px);
                opacity: 0.3;
                animation: floatBlob 22s infinite alternate ease-in-out;
            }

            .blob-1 {
                width: 500px;
                height: 500px;
                background: #dfc674;
                top: -120px;
                right: -100px;
                opacity: 0.22;
            }

            .blob-2 {
                width: 550px;
                height: 550px;
                background: #8e7631;
                bottom: -180px;
                left: -120px;
                animation-delay: -7s;
                opacity: 0.25;
            }

            .blob-3 {
                width: 400px;
                height: 400px;
                background: #dfc674;
                top: 40%;
                left: 30%;
                animation-delay: -12s;
                opacity: 0.12;
            }

            @keyframes floatBlob {
                0% { transform: translate(0, 0) scale(1); }
                50% { transform: translate(60px, 40px) scale(1.1); }
                100% { transform: translate(-40px, 80px) scale(0.95); }
            }

            /* Main Container Layout */
            .login-wrapper {
                position: relative;
                z-index: 10;
                width: 100%;
                max-width: 1280px;
                min-height: calc(100vh - 80px);
                margin: 40px 20px;
                display: flex;
                border-radius: var(--radius-lg);
                overflow: hidden;
                box-shadow: 0 30px 70px -15px rgba(0, 0, 0, 0.8), 0 0 0 1px rgba(223, 198, 116, 0.2);
                background: rgba(24, 25, 32, 0.85);
                backdrop-filter: blur(24px);
                -webkit-backdrop-filter: blur(24px);
                animation: fadeInUp 0.8s cubic-bezier(0.16, 1, 0.3, 1);
            }

            @keyframes fadeInUp {
                from {
                    opacity: 0;
                    transform: translateY(30px) scale(0.98);
                }
                to {
                    opacity: 1;
                    transform: translateY(0) scale(1);
                }
            }

            /* Left Showcase Hero Panel */
            .image-panel {
                flex: 1.3;
                position: relative;
                background-image: url('{{ asset("images/home_hero.png") }}');
                background-size: cover;
                background-position: center;
                display: flex;
                flex-direction: column;
                justify-content: space-between;
                padding: 50px;
                color: #ffffff;
                overflow: hidden;
            }

            .image-panel::before {
                content: '';
                position: absolute;
                inset: 0;
                background: linear-gradient(180deg, 
                    rgba(18, 19, 24, 0.88) 0%, 
                    rgba(18, 19, 24, 0.72) 50%, 
                    rgba(18, 19, 24, 0.95) 100%);
                z-index: 1;
            }

            .image-panel-header {
                position: relative;
                z-index: 2;
                display: flex;
                align-items: center;
                justify-content: space-between;
            }

            .brand-pill {
                display: inline-flex;
                align-items: center;
                gap: 10px;
                background: rgba(223, 198, 116, 0.1);
                backdrop-filter: blur(12px);
                border: 1px solid rgba(223, 198, 116, 0.3);
                padding: 8px 18px;
                border-radius: 50px;
                font-size: 13px;
                font-weight: 700;
                color: #dfc674;
                letter-spacing: 0.5px;
            }

            .brand-pill i {
                color: #dfc674;
                font-size: 16px;
            }

            .image-panel-content {
                position: relative;
                z-index: 2;
                max-width: 540px;
            }

            .image-panel-content .badge-tag {
                display: inline-flex;
                align-items: center;
                gap: 8px;
                padding: 6px 14px;
                background: rgba(223, 198, 116, 0.15);
                border: 1px solid rgba(223, 198, 116, 0.4);
                border-radius: 30px;
                color: #dfc674;
                font-size: 12px;
                font-weight: 700;
                margin-bottom: 20px;
            }

            .image-panel-content h2 {
                font-size: 36px;
                font-weight: 800;
                line-height: 1.35;
                margin-bottom: 16px;
                background: linear-gradient(135deg, #ffffff 0%, #dfc674 100%);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                text-shadow: 0 4px 12px rgba(0, 0, 0, 0.4);
            }

            .image-panel-content p {
                font-size: 16px;
                color: #cbd5e1;
                font-weight: 500;
                line-height: 1.7;
                margin-bottom: 30px;
            }

            /* Feature Cards Grid */
            .features-grid {
                display: grid;
                grid-template-columns: repeat(2, 1fr);
                gap: 16px;
                margin-top: 10px;
            }

            .feature-card {
                background: rgba(255, 255, 255, 0.04);
                backdrop-filter: blur(10px);
                border: 1px solid rgba(223, 198, 116, 0.2);
                border-radius: 14px;
                padding: 16px;
                display: flex;
                align-items: center;
                gap: 12px;
                transition: all 0.3s ease;
            }

            .feature-card:hover {
                background: rgba(223, 198, 116, 0.08);
                border-color: rgba(223, 198, 116, 0.5);
                transform: translateY(-3px);
            }

            .feature-icon {
                width: 42px;
                height: 42px;
                border-radius: 10px;
                background: linear-gradient(135deg, rgba(223, 198, 116, 0.25), rgba(18, 19, 24, 0.6));
                border: 1px solid rgba(223, 198, 116, 0.4);
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 18px;
                color: #dfc674;
                flex-shrink: 0;
            }

            .feature-info h4 {
                font-size: 14px;
                font-weight: 700;
                color: #ffffff;
                margin-bottom: 2px;
            }

            .feature-info span {
                font-size: 11px;
                color: #94a3b8;
            }

            /* Right Form Panel */
            .form-panel {
                width: 480px;
                background: var(--form-bg);
                display: flex;
                flex-direction: column;
                justify-content: space-between;
                padding: 50px 44px;
                overflow-y: auto;
                position: relative;
                box-shadow: -10px 0 40px rgba(0, 0, 0, 0.4);
                border-right: 1px solid rgba(223, 198, 116, 0.15);
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
                margin-bottom: 32px;
                text-align: center;
            }

            .logo-img-wrapper {
                position: relative;
                padding: 14px 28px;
                background: rgba(18, 19, 24, 0.7);
                border-radius: 20px;
                border: 1px solid rgba(223, 198, 116, 0.3);
                box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.5), 0 0 20px rgba(223, 198, 116, 0.12);
                margin-bottom: 16px;
                transition: transform 0.3s ease, border-color 0.3s ease;
            }

            .logo-img-wrapper:hover {
                transform: translateY(-3px);
                border-color: rgba(223, 198, 116, 0.6);
            }

            .logo-badge {
                display: inline-flex;
                align-items: center;
                gap: 8px;
                padding: 6px 16px;
                background: rgba(223, 198, 116, 0.1);
                border: 1px solid rgba(223, 198, 116, 0.3);
                border-radius: 50px;
                font-size: 12px;
                color: #dfc674;
                font-weight: 700;
            }

            .form-header {
                text-align: center;
                margin-bottom: 30px;
            }

            .form-header h1 {
                font-size: 26px;
                font-weight: 800;
                color: #ffffff;
                margin-bottom: 8px;
                letter-spacing: -0.3px;
            }

            .form-header p {
                color: #94a3b8;
                font-size: 14px;
                font-weight: 500;
            }

            /* ============ Filament Overrides ============ */
            .fi-simple-page,
            .fi-simple-page-content {
                all: unset !important;
                display: block !important;
            }

            .fi-simple-layout,
            .fi-simple-main-ctn,
            .fi-simple-main {
                all: unset !important;
                display: block !important;
                width: 100% !important;
                padding: 0 !important;
                margin: 0 !important;
                max-width: 100% !important;
                background: transparent !important;
                box-shadow: none !important;
            }

            .fi-simple-header {
                display: none !important;
            }

            /* Form Controls Styling */
            .fi-fo-field {
                margin-bottom: 22px;
            }

            .fi-fo-field-label label,
            .fi-fo-field-label-content {
                display: flex;
                align-items: center;
                gap: 6px;
                font-size: 13.5px;
                font-weight: 700;
                color: #e2e8f0;
                margin-bottom: 8px;
            }

            .fi-input-wrp {
                width: 100%;
                background: var(--input-bg);
                border: 1.5px solid rgba(223, 198, 116, 0.25);
                border-radius: var(--radius-md);
                overflow: hidden;
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                position: relative;
            }

            .fi-input-wrp:hover {
                border-color: rgba(223, 198, 116, 0.5);
                background: #14151b;
            }

            .fi-input-wrp:focus-within {
                border-color: #dfc674;
                background: #16171e;
                box-shadow: 0 0 0 4px rgba(223, 198, 116, 0.18), 0 8px 24px -6px rgba(223, 198, 116, 0.25);
            }

            .fi-input {
                width: 100%;
                height: 52px;
                padding: 0 18px;
                background: transparent;
                border: none;
                color: #ffffff !important;
                font-size: 15px;
                font-weight: 600;
                outline: none;
                font-family: 'Cairo', sans-serif;
            }

            .fi-input::placeholder {
                color: #64748b;
                font-weight: 500;
            }

            /* Checkbox & Options */
            .fi-fo-checkbox {
                accent-color: #dfc674;
                width: 18px;
                height: 18px;
                border-radius: 6px;
                cursor: pointer;
            }

            .fi-fo-checkbox-label {
                font-size: 13px;
                color: #94a3b8;
                font-weight: 600;
                cursor: pointer;
                user-select: none;
            }

            /* Validation Error */
            .fi-fo-field-wrp-error-message {
                color: #f87171;
                font-size: 12px;
                font-weight: 700;
                margin-top: 6px;
                display: flex;
                align-items: center;
                gap: 4px;
            }

            /* Submit Button */
            .fi-simple-page form {
                width: 100%;
            }

            .fi-simple-page form > button[type="submit"],
            .fi-simple-page form .fi-btn {
                width: 100% !important;
                height: 54px !important;
                background: var(--primary-gradient) !important;
                color: #121318 !important;
                border: none !important;
                border-radius: var(--radius-md) !important;
                font-size: 16px !important;
                font-weight: 800 !important;
                cursor: pointer !important;
                transition: all 0.3s ease !important;
                display: flex !important;
                align-items: center !important;
                justify-content: center !important;
                gap: 10px !important;
                box-shadow: 0 10px 25px -5px rgba(223, 198, 116, 0.4) !important;
                font-family: 'Cairo', sans-serif !important;
                margin-top: 14px !important;
                padding: 0 24px !important;
                position: relative !important;
                overflow: hidden !important;
            }

            .fi-simple-page form > button[type="submit"]::after,
            .fi-simple-page form .fi-btn::after {
                content: '';
                position: absolute;
                top: -50%;
                left: -50%;
                width: 200%;
                height: 200%;
                background: linear-gradient(60deg, transparent, rgba(255, 255, 255, 0.3), transparent);
                transform: rotate(30deg);
                transition: 0.8s;
            }

            .fi-simple-page form > button[type="submit"]:hover::after,
            .fi-simple-page form .fi-btn:hover::after {
                left: 100%;
            }

            .fi-simple-page form > button[type="submit"]:hover,
            .fi-simple-page form .fi-btn:hover {
                transform: translateY(-2px) !important;
                box-shadow: 0 15px 35px -5px rgba(223, 198, 116, 0.6) !important;
                background: linear-gradient(135deg, #f1db8b 0%, #dfc674 50%, #c9ad54 100%) !important;
            }

            .fi-simple-page form > button[type="submit"]:active,
            .fi-simple-page form .fi-btn:active {
                transform: translateY(0) !important;
            }

            .footer-text {
                text-align: center;
                font-size: 13px;
                color: #64748b;
                margin-top: 25px;
                font-weight: 500;
            }

            .footer-text a {
                color: #dfc674;
                text-decoration: none;
                font-weight: 700;
                transition: color 0.2s;
            }

            .footer-text a:hover {
                color: #f1db8b;
                text-decoration: underline;
            }

            /* Directional Tweaks */
            [dir="rtl"] .fi-input { text-align: right; }
            [dir="rtl"] .fi-fo-field-label label { text-align: right; }
            [dir="ltr"] .fi-input { text-align: left; }
            [dir="ltr"] .fi-fo-field-label label { text-align: left; }

            /* Responsive Breakpoints */
            @media (max-width: 1024px) {
                .login-wrapper {
                    margin: 20px;
                    min-height: auto;
                }
                .image-panel {
                    padding: 40px;
                }
                .features-grid {
                    grid-template-columns: 1fr;
                }
            }

            @media (max-width: 850px) {
                body {
                    background: #121318 !important;
                    padding: 0;
                }
                .bg-blobs {
                    display: none;
                }
                .login-wrapper {
                    margin: 0;
                    border-radius: 0;
                    min-height: 100vh;
                    box-shadow: none;
                    background: #181920;
                }
                .image-panel {
                    display: none;
                }
                .form-panel {
                    width: 100%;
                    max-width: 100%;
                    min-height: 100vh;
                    padding: 40px 24px;
                    box-shadow: none;
                    border-right: none;
                }
            }
        </style>
    @endpush

    <!-- Auth Container Wrapper for Livewire Single Root Element -->
    <div>
        <!-- Ambient Glowing Blobs -->
        <div class="bg-blobs">
            <div class="blob blob-1"></div>
            <div class="blob blob-2"></div>
            <div class="blob blob-3"></div>
        </div>

        <!-- Main Content Slot -->
        {{ $slot }}
    </div>
</x-filament-panels::layout.base>
