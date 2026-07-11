@extends('store.layouts.app')
@section('title', __('نجاح الحجز') . ' | ' . (is_array($globalSettings['site_name'] ?? null) ? ($globalSettings['site_name'][App::getLocale()] ?? ($globalSettings['site_name']['ar'] ?? 'GR Motors')) : ($globalSettings['site_name'] ?? 'GR Motors')))

@section('content')
<div class="success-page-wrapper">
    <!-- Confetti Canvas -->
    <canvas id="confetti-canvas"></canvas>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
                <div class="success-card glass-panel" data-aos="zoom-in" data-aos-duration="800">
                    
                    <!-- Animated Checkmark -->
                    <div class="success-icon-wrapper mb-4">
                        <svg class="checkmark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
                            <circle class="checkmark__circle" cx="26" cy="26" r="25" fill="none"/>
                            <path class="checkmark__check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8"/>
                        </svg>
                    </div>
                    
                    <h1 class="fw-black text-dark mb-3 animate-slide-up">{{ __('شكراً لك') }} {{ $booking->client_name }}!</h1>
                    <p class="text-muted fs-5 mb-5 animate-slide-up delay-1">{{ __('لقد تم استلام طلبك بنجاح. سيقوم أحد مستشاري المبيعات لدينا بالتواصل معك في أقرب وقت.') }}</p>
                    
                    <!-- Receipt Design -->
                    <div class="receipt-box animate-slide-up delay-2 mb-5">
                        <div class="receipt-header">
                            <h6 class="fw-bold mb-0 text-dark"><i class="bi bi-receipt me-2"></i>{{ __('ملخص الطلب') }}</h6>
                            <span class="badge bg-dark rounded-pill">#{{ $booking->id }}</span>
                        </div>
                        <div class="receipt-body">
                            <div class="receipt-row">
                                <span class="receipt-label"><i class="bi bi-car-front text-muted me-2"></i>{{ __('السيارة') }}</span>
                                <span class="receipt-value fw-bold text-dark">{{ $booking->car->name ?? '---' }}</span>
                            </div>
                            <div class="receipt-row">
                                <span class="receipt-label"><i class="bi bi-cash-stack text-muted me-2"></i>{{ __('المقدم') }}</span>
                                <span class="receipt-value fw-bold text-dark">{{ number_format($booking->down_payment) }} <small>{!! __('ريال') !!}</small></span>
                            </div>
                            <div class="receipt-row highlight">
                                <span class="receipt-label text-dark fw-bold"><i class="bi bi-calendar2-month text-danger me-2"></i>{{ __('القسط الشهري') }}</span>
                                <span class="receipt-value fw-black text-danger fs-5">{{ number_format($booking->monthly_installment) }} <small>{!! __('ريال') !!}</small></span>
                            </div>
                        </div>
                    </div>

                    <!-- Next Steps Timeline -->
                    <div class="next-steps-wrapper animate-slide-up delay-3 mb-5">
                        <h6 class="fw-bold mb-4 text-{{ App::getLocale() == 'ar' ? 'end' : 'start' }}"><i class="bi bi-list-check me-2"></i>{{ __('ماذا سيحدث الآن؟') }}</h6>
                        <div class="timeline-horizontal">
                            <div class="timeline-step active">
                                <div class="step-icon"><i class="bi bi-check2"></i></div>
                                <div class="step-text">{{ __('تم الاستلام') }}</div>
                            </div>
                            <div class="timeline-line active"></div>
                            <div class="timeline-step">
                                <div class="step-icon"><i class="bi bi-search"></i></div>
                                <div class="step-text">{{ __('قيد المراجعة') }}</div>
                            </div>
                            <div class="timeline-line"></div>
                            <div class="timeline-step">
                                <div class="step-icon"><i class="bi bi-telephone"></i></div>
                                <div class="step-text">{{ __('تواصل المستشار') }}</div>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="actions-container animate-slide-up delay-4">
                        <div class="d-grid gap-3 d-sm-flex justify-content-center">
                            @if(session('whatsapp_text'))
                            <a href="https://wa.me/{{ $globalSettings['contact_whatsapp'] ?? '966500000000' }}?text={{ session('whatsapp_text') }}" target="_blank" class="btn btn-whatsapp rounded-pill px-5 py-3 d-inline-flex align-items-center justify-content-center gap-2 shadow-sm">
                                <i class="bi bi-whatsapp fs-5"></i>
                                <span class="fw-bold">{{ __('تواصل عبر واتساب الآن') }}</span>
                            </a>
                            @endif
                            <a href="{{ route('store.home') }}" class="btn btn-outline-dark rounded-pill px-5 py-3 fw-bold shadow-sm d-inline-flex align-items-center justify-content-center">
                                <i class="bi bi-house me-2"></i> {{ __('العودة للرئيسية') }}
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Wrapper & Background */
    .success-page-wrapper {
        min-height: 80vh;
        background: #f8f9fc;
        background-image: radial-gradient(circle at 50% 0%, #ffffff 0%, #f1f3f9 100%);
        position: relative;
        overflow: hidden;
        display: flex;
        align-items: center;
        padding: 40px 0;
    }
    #confetti-canvas {
        position: absolute;
        top: 0; left: 0; width: 100%; height: 100%;
        pointer-events: none; z-index: 1;
    }

    /* Glass Panel Card */
    .glass-panel {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.5);
        border-radius: 30px;
        padding: 60px 40px;
        box-shadow: 0 30px 60px rgba(0,0,0,0.08), 0 0 0 10px rgba(255,255,255,0.4);
        text-align: center;
        position: relative;
        z-index: 2;
    }

    /* Typography */
    .fw-black { font-weight: 900; }
    .text-dark { color: #1a1a2e !important; }

    /* Animated Checkmark */
    .success-icon-wrapper {
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .checkmark {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        display: block;
        stroke-width: 3;
        stroke: #12B76A;
        stroke-miterlimit: 10;
        box-shadow: inset 0px 0px 0px #12B76A;
        animation: fill .4s ease-in-out .4s forwards, scale .3s ease-in-out .9s both;
    }
    .checkmark__circle {
        stroke-dasharray: 166;
        stroke-dashoffset: 166;
        stroke-width: 3;
        stroke-miterlimit: 10;
        stroke: #12B76A;
        fill: none;
        animation: stroke 0.6s cubic-bezier(0.65, 0, 0.45, 1) forwards;
    }
    .checkmark__check {
        transform-origin: 50% 50%;
        stroke-dasharray: 48;
        stroke-dashoffset: 48;
        animation: stroke 0.3s cubic-bezier(0.65, 0, 0.45, 1) 0.8s forwards;
    }
    @keyframes stroke { 100% { stroke-dashoffset: 0; } }
    @keyframes scale { 0%, 100% { transform: none; } 50% { transform: scale3d(1.1, 1.1, 1); } }
    @keyframes fill { 100% { box-shadow: inset 0px 0px 0px 50px #e8f5e9; } }

    /* Receipt Box */
    .receipt-box {
        background: #fff;
        border-radius: 20px;
        border: 2px dashed #e2e8f0;
        overflow: hidden;
        text-align: {{ App::getLocale() == 'ar' ? 'right' : 'left' }};
    }
    .receipt-header {
        background: #f8fafc;
        padding: 20px 24px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 2px dashed #e2e8f0;
    }
    .receipt-body { padding: 24px; }
    .receipt-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px 0;
        border-bottom: 1px solid #f1f5f9;
    }
    .receipt-row:last-child { border-bottom: none; padding-bottom: 0; }
    .receipt-row.highlight {
        background: #fff5f5;
        margin: 10px -24px -24px;
        padding: 24px;
        border-top: 1px solid #fee2e2;
        border-radius: 0 0 18px 18px;
    }
    .receipt-label { font-size: 15px; color: #64748b; }
    .receipt-value { font-size: 16px; }

    /* Timeline */
    .timeline-horizontal {
        display: flex;
        align-items: center;
        justify-content: space-between;
        position: relative;
    }
    .timeline-step {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 10px;
        position: relative;
        z-index: 2;
        flex: 1;
    }
    .step-icon {
        width: 50px;
        height: 50px;
        background: #f1f5f9;
        color: #94a3b8;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        transition: 0.4s;
    }
    .step-text {
        font-size: 13px;
        font-weight: 700;
        color: #94a3b8;
    }
    .timeline-step.active .step-icon {
        background: #12B76A;
        color: #fff;
        box-shadow: 0 0 0 6px #e8f5e9;
    }
    .timeline-step.active .step-text { color: #12B76A; }
    
    .timeline-line {
        flex: 1;
        height: 4px;
        background: #f1f5f9;
        position: relative;
        top: -15px;
        border-radius: 4px;
        margin: 0 -20px;
        z-index: 1;
    }
    .timeline-line.active { background: #12B76A; }

    /* Buttons */
    .btn-whatsapp {
        background: #25D366;
        color: #fff;
        border: none;
        transition: 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .btn-whatsapp:hover {
        background: #128C7E;
        color: #fff;
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(37, 211, 102, 0.3) !important;
    }
    .btn-outline-dark {
        border-width: 2px;
        transition: 0.3s;
    }
    .btn-outline-dark:hover {
        background: #1a1a2e;
        color: #fff;
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(26, 26, 46, 0.15) !important;
    }

    /* Animations */
    .animate-slide-up {
        opacity: 0;
        transform: translateY(30px);
        animation: slideUpFade 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }
    .delay-1 { animation-delay: 0.2s; }
    .delay-2 { animation-delay: 0.4s; }
    .delay-3 { animation-delay: 0.6s; }
    .delay-4 { animation-delay: 0.8s; }
    @keyframes slideUpFade {
        to { opacity: 1; transform: translateY(0); }
    }

    @media (max-width: 768px) {
        .glass-panel { padding: 40px 20px; border-radius: 20px; }
        .receipt-row.highlight { padding: 20px; margin: 10px -20px -20px; }
        .timeline-horizontal { flex-direction: column; align-items: flex-start; gap: 20px; padding-right: 20px; }
        html[dir="ltr"] .timeline-horizontal { padding-right: 0; padding-left: 20px; }
        .timeline-step { flex-direction: row; flex: unset; width: 100%; }
        .timeline-line { width: 4px; height: 30px; margin: 0; position: absolute; right: 43px; top: 40px; }
        html[dir="ltr"] .timeline-line { right: auto; left: 43px; }
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Fire confetti after a slight delay to match checkmark animation
        setTimeout(() => {
            var myCanvas = document.getElementById('confetti-canvas');
            var myConfetti = confetti.create(myCanvas, {
                resize: true,
                useWorker: true
            });
            myConfetti({
                particleCount: 150,
                spread: 80,
                origin: { y: 0.6 },
                colors: ['#12B76A', '#25D366', '#E30613', '#ffffff']
            });
        }, 1200);

        trackEvent('Lead', {
            phone: '{{ $booking->client_phone }}',
            car_model: '{{ $booking->car->name ?? '' }}',
            location: '{{ $booking->location ?? '' }}',
            car_price: '{{ $booking->car->cash_price ?? 0 }}',
            installment: '{{ $booking->monthly_installment ?? 0 }}'
        });
    });
</script>
@endsection
