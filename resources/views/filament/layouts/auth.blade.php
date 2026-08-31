<x-filament-panels::layout.base :livewire="$livewire ?? null">
    @push('styles')
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

        <style>
            :root {
                --auth-gold: #dfc674;
                --auth-gold-hover: #f3df95;
                --auth-gold-glow: rgba(223, 198, 116, 0.4);
                --auth-bg: #0b0c10;
                --auth-card-bg: #14151c;
                --auth-input-bg: #0f1015;
                --auth-border: rgba(223, 198, 116, 0.25);
            }

            * {
                font-family: 'Cairo', -apple-system, BlinkMacSystemFont, sans-serif !important;
                box-sizing: border-box;
            }

            /* Override Global Dashboard Backgrounds */
            html,
            body,
            .fi-body,
            .fi-main,
            .fi-simple-layout,
            .fi-simple-main-ctn,
            .fi-simple-main,
            .fi-panel {
                background-color: var(--auth-bg) !important;
                background: var(--auth-bg) !important;
                color: #f8fafc !important;
                min-height: 100vh !important;
                margin: 0 !important;
                padding: 0 !important;
                overflow-x: hidden !important;
            }

            .auth-full-screen {
                min-height: 100vh;
                width: 100vw;
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 24px;
                position: relative;
                z-index: 1;
                background: radial-gradient(circle at 50% 20%, rgba(223, 198, 116, 0.08) 0%, transparent 60%),
                            radial-gradient(circle at 80% 80%, rgba(184, 152, 59, 0.06) 0%, transparent 50%),
                            #0b0c10;
            }

            /* Ambient Glows */
            .auth-glow {
                position: absolute;
                border-radius: 50%;
                filter: blur(120px);
                pointer-events: none;
                z-index: 0;
            }
            .auth-glow-1 {
                width: 450px;
                height: 450px;
                background: rgba(223, 198, 116, 0.18);
                top: -100px;
                right: 10%;
            }
            .auth-glow-2 {
                width: 400px;
                height: 400px;
                background: rgba(142, 118, 49, 0.15);
                bottom: -100px;
                left: 10%;
            }

            /* Auth Card Container */
            .auth-card-container {
                position: relative;
                z-index: 10;
                width: 100%;
                max-width: 1150px;
                min-height: 640px;
                display: flex;
                border-radius: 28px;
                overflow: hidden;
                box-shadow: 0 25px 70px -15px rgba(0, 0, 0, 0.8),
                            0 0 0 1px rgba(223, 198, 116, 0.22),
                            0 0 40px rgba(223, 198, 116, 0.08);
                background: rgba(20, 21, 28, 0.95);
                backdrop-filter: blur(20px);
            }

            /* Left Hero Showcase */
            .auth-hero-panel {
                flex: 1.15;
                position: relative;
                background-image: url('{{ asset("images/home_hero.png") }}');
                background-size: cover;
                background-position: center;
                display: flex;
                flex-direction: column;
                justify-content: space-between;
                padding: 48px;
                overflow: hidden;
            }

            .auth-hero-panel::before {
                content: '';
                position: absolute;
                inset: 0;
                background: linear-gradient(180deg, 
                    rgba(11, 12, 16, 0.9) 0%, 
                    rgba(11, 12, 16, 0.75) 50%, 
                    rgba(11, 12, 16, 0.95) 100%);
                z-index: 1;
            }

            .hero-header {
                position: relative;
                z-index: 2;
                display: flex;
                align-items: center;
                justify-content: space-between;
            }

            .hero-badge {
                display: inline-flex;
                align-items: center;
                gap: 8px;
                background: rgba(223, 198, 116, 0.12);
                border: 1px solid rgba(223, 198, 116, 0.35);
                padding: 6px 16px;
                border-radius: 50px;
                font-size: 12.5px;
                font-weight: 700;
                color: var(--auth-gold) !important;
            }

            .hero-badge i {
                font-size: 15px;
                color: var(--auth-gold);
            }

            .hero-store-link {
                color: #cbd5e1 !important;
                text-decoration: none;
                font-size: 13px;
                font-weight: 700;
                display: inline-flex;
                align-items: center;
                gap: 6px;
                padding: 6px 14px;
                border-radius: 20px;
                background: rgba(255, 255, 255, 0.05);
                border: 1px solid rgba(255, 255, 255, 0.1);
                transition: all 0.25s ease;
            }

            .hero-store-link:hover {
                color: var(--auth-gold) !important;
                border-color: var(--auth-gold);
                background: rgba(223, 198, 116, 0.1);
            }

            .hero-content {
                position: relative;
                z-index: 2;
                max-width: 480px;
            }

            .hero-tag {
                display: inline-flex;
                align-items: center;
                gap: 6px;
                padding: 5px 12px;
                background: rgba(223, 198, 116, 0.15);
                border: 1px solid rgba(223, 198, 116, 0.4);
                border-radius: 20px;
                color: var(--auth-gold) !important;
                font-size: 11.5px;
                font-weight: 700;
                margin-bottom: 16px;
            }

            .hero-content h2 {
                font-size: 30px !important;
                font-weight: 900 !important;
                line-height: 1.4 !important;
                margin-bottom: 14px !important;
                color: #ffffff !important;
                background: linear-gradient(135deg, #ffffff 30%, var(--auth-gold) 100%) !important;
                -webkit-background-clip: text !important;
                -webkit-text-fill-color: transparent !important;
            }

            .hero-content p {
                font-size: 14.5px !important;
                color: #94a3b8 !important;
                line-height: 1.7 !important;
                margin-bottom: 24px !important;
            }

            .hero-features {
                display: grid;
                grid-template-columns: repeat(2, 1fr);
                gap: 12px;
            }

            .hero-feat-card {
                background: rgba(255, 255, 255, 0.04);
                border: 1px solid rgba(223, 198, 116, 0.2);
                border-radius: 14px;
                padding: 12px 14px;
                display: flex;
                align-items: center;
                gap: 10px;
            }

            .hero-feat-icon {
                width: 36px;
                height: 36px;
                border-radius: 10px;
                background: rgba(223, 198, 116, 0.15);
                border: 1px solid rgba(223, 198, 116, 0.3);
                display: flex;
                align-items: center;
                justify-content: center;
                color: var(--auth-gold);
                font-size: 16px;
                flex-shrink: 0;
            }

            .hero-feat-card h4 {
                font-size: 13px !important;
                font-weight: 700 !important;
                color: #ffffff !important;
                margin: 0 !important;
            }

            .hero-feat-card span {
                font-size: 11px !important;
                color: #64748b !important;
            }

            /* Right Form Panel */
            .auth-form-panel {
                width: 480px;
                background: var(--auth-card-bg);
                display: flex;
                flex-direction: column;
                justify-content: space-between;
                padding: 44px 40px;
                position: relative;
                border-right: 1px solid rgba(223, 198, 116, 0.15);
            }

            .auth-form-wrapper {
                margin: auto 0;
                width: 100%;
            }

            /* Logo Styling */
            .auth-logo-box {
                display: flex;
                flex-direction: column;
                align-items: center;
                margin-bottom: 24px;
                text-align: center;
            }

            .auth-logo-frame {
                padding: 12px 24px;
                background: rgba(11, 12, 16, 0.85);
                border-radius: 18px;
                border: 1px solid rgba(223, 198, 116, 0.35);
                box-shadow: 0 8px 25px rgba(0, 0, 0, 0.5), 0 0 20px rgba(223, 198, 116, 0.15);
                margin-bottom: 12px;
                display: inline-flex;
                align-items: center;
                justify-content: center;
            }

            .auth-role-tag {
                display: inline-flex;
                align-items: center;
                gap: 6px;
                padding: 4px 14px;
                background: rgba(223, 198, 116, 0.1);
                border: 1px solid rgba(223, 198, 116, 0.3);
                border-radius: 30px;
                font-size: 11.5px;
                color: var(--auth-gold) !important;
                font-weight: 700;
            }

            .auth-title-area {
                text-align: center;
                margin-bottom: 26px;
            }

            .auth-main-title {
                font-size: 24px !important;
                font-weight: 800 !important;
                color: #ffffff !important;
                margin-bottom: 6px !important;
                letter-spacing: -0.3px !important;
            }

            .auth-sub-title {
                color: #94a3b8 !important;
                font-size: 13.5px !important;
                font-weight: 500 !important;
                margin: 0 !important;
            }

            /* Form Elements Styling (High Specificity) */
            .auth-form-panel .fi-simple-page,
            .auth-form-panel .fi-simple-page-content,
            .auth-form-panel .fi-simple-layout,
            .auth-form-panel .fi-simple-main {
                all: unset !important;
                display: block !important;
                width: 100% !important;
                background: transparent !important;
            }

            .auth-form-panel .fi-simple-header {
                display: none !important;
            }

            .auth-form-panel .fi-fo-field {
                margin-bottom: 18px !important;
            }

            .auth-form-panel .fi-fo-field-label label,
            .auth-form-panel .fi-fo-field-label-content,
            .auth-form-panel label[for] {
                color: #e2e8f0 !important;
                font-size: 13px !important;
                font-weight: 700 !important;
                margin-bottom: 6px !important;
                display: flex !important;
                align-items: center !important;
                gap: 4px !important;
            }

            .auth-form-panel .fi-fo-field-label-required {
                color: #ef4444 !important;
            }

            .auth-form-panel .fi-input-wrp {
                background: var(--auth-input-bg) !important;
                border: 1.5px solid var(--auth-border) !important;
                border-radius: 12px !important;
                overflow: hidden !important;
                transition: all 0.25s ease !important;
                box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.4) !important;
            }

            .auth-form-panel .fi-input-wrp:hover {
                border-color: rgba(223, 198, 116, 0.5) !important;
                background: #121319 !important;
            }

            .auth-form-panel .fi-input-wrp:focus-within {
                border-color: var(--auth-gold) !important;
                background: #14151d !important;
                box-shadow: 0 0 0 3px rgba(223, 198, 116, 0.25), inset 0 2px 4px rgba(0, 0, 0, 0.4) !important;
            }

            .auth-form-panel .fi-input {
                background: transparent !important;
                border: none !important;
                color: #ffffff !important;
                font-size: 14.5px !important;
                font-weight: 600 !important;
                height: 48px !important;
                padding: 0 16px !important;
                outline: none !important;
            }

            .auth-form-panel input:-webkit-autofill,
            .auth-form-panel input:-webkit-autofill:hover, 
            .auth-form-panel input:-webkit-autofill:focus {
                -webkit-text-fill-color: #ffffff !important;
                -webkit-box-shadow: 0 0 0px 1000px #14151d inset !important;
                transition: background-color 5000s ease-in-out 0s !important;
            }

            .auth-form-panel .fi-input::placeholder {
                color: #475569 !important;
                font-weight: 500 !important;
            }

            .auth-form-panel .fi-fo-checkbox {
                accent-color: var(--auth-gold) !important;
                width: 17px !important;
                height: 17px !important;
                border-radius: 5px !important;
            }

            .auth-form-panel .fi-fo-checkbox-label,
            .auth-form-panel .fi-checkbox-label {
                color: #94a3b8 !important;
                font-size: 13px !important;
                font-weight: 600 !important;
            }

            /* Submit Action Button */
            .auth-form-panel button[type="submit"],
            .auth-form-panel .fi-btn {
                width: 100% !important;
                height: 50px !important;
                background: linear-gradient(135deg, #dfc674 0%, #c9ad54 50%, #b8983b 100%) !important;
                color: #0b0c10 !important;
                border: none !important;
                border-radius: 12px !important;
                font-size: 15.5px !important;
                font-weight: 800 !important;
                cursor: pointer !important;
                transition: all 0.3s ease !important;
                display: flex !important;
                align-items: center !important;
                justify-content: center !important;
                gap: 8px !important;
                box-shadow: 0 8px 24px -4px rgba(223, 198, 116, 0.45) !important;
                margin-top: 12px !important;
            }

            .auth-form-panel button[type="submit"]:hover,
            .auth-form-panel .fi-btn:hover {
                transform: translateY(-2px) !important;
                background: linear-gradient(135deg, #f3df95 0%, #dfc674 50%, #c9ad54 100%) !important;
                box-shadow: 0 12px 30px -4px rgba(223, 198, 116, 0.6) !important;
            }

            .auth-form-panel button[type="submit"]:active,
            .auth-form-panel .fi-btn:active {
                transform: translateY(0) !important;
            }

            .auth-footer {
                text-align: center;
                font-size: 12.5px;
                color: #64748b;
                margin-top: 20px;
                font-weight: 500;
            }

            .auth-footer a {
                color: var(--auth-gold) !important;
                text-decoration: none;
                font-weight: 700;
            }

            /* Responsive */
            @media (max-width: 900px) {
                .auth-full-screen {
                    padding: 12px;
                }
                .auth-card-container {
                    flex-direction: column;
                    max-width: 480px;
                    min-height: auto;
                    border-radius: 20px;
                }
                .auth-hero-panel {
                    display: none;
                }
                .auth-form-panel {
                    width: 100%;
                    padding: 32px 24px;
                    border-right: none;
                }
            }
        </style>
    @endpush

    <div class="auth-full-screen">
        <div class="auth-glow auth-glow-1"></div>
        <div class="auth-glow auth-glow-2"></div>

        {{ $slot }}
    </div>
</x-filament-panels::layout.base>
