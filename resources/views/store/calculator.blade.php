@extends('store.layouts.app')
@section('title', __('حاسبة الأقساط') . ' | ' . (is_array($globalSettings['site_name'] ?? null) ? ($globalSettings['site_name'][App::getLocale()] ?? ($globalSettings['site_name']['ar'] ?? 'Qemt Najd')) : ($globalSettings['site_name'] ?? 'Qemt Najd')))

@section('breadcrumb-title', __('حاسبة الأقساط'))

@section('content')
@include('partials.Store.breadcrumb')

    {{-- Hero Section --}}
    <div style="padding: 40px 0 20px; text-align: center;">
        <div class="container">
            <h1 style="font-weight: 800; font-size: 36px; margin-bottom: 8px;">
                {{ __('احصل على ') }} <span style="color: var(--primary);">{{ __('سيارة') }}</span> {{ __('أحلامك') }}
            </h1>
            <p style="color: var(--color-text-muted); font-size: 16px; margin-bottom: 40px;">
                {{ __('املأ البيانات واحسب أقساطك بكل سهولة') }}
            </p>

            {{-- Features Cards --}}
            <div class="features-grid">
                <div class="feature-card">
                    <i class="bi bi-shield-check feature-icon text-primary"></i>
                    <h4 style="font-weight: 800; margin-bottom: 4px;">{{ __('آمن ومضمون') }}</h4>
                    <p style="color: var(--color-text-muted); font-size: 14px; margin: 0;">{{ __('بياناتك محمية ١٠٠٪') }}
                    </p>
                </div>
                <div class="feature-card">
                    <i class="bi bi-clock-history feature-icon text-primary"></i>
                    <h4 style="font-weight: 800; margin-bottom: 4px;">{{ __('سريع وسهل') }}</h4>
                    <p style="color: var(--color-text-muted); font-size: 14px; margin: 0;">{{ __('رد فوري خلال ٢٤ ساعة') }}
                    </p>
                </div>
                <div class="feature-card">
                    <i class="bi bi-currency-dollar feature-icon text-primary"></i>
                    <h4 style="font-weight: 800; margin-bottom: 4px;">{{ __('أفضل الأسعار') }}</h4>
                    <p style="color: var(--color-text-muted); font-size: 14px; margin: 0;">{{ __('عروض وتمويل مميز') }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Calculator & Booking Container --}}
    <section style="padding: 20px 0 60px;">
        <div class="container">
            <div class="calc-booking-wrapper">

                {{-- Right: Booking Form --}}
                <div class="booking-section">
                    <div style="text-align: center; margin-bottom: 32px;">
                        <h2 style="font-weight: 800; font-size: 24px; margin-bottom: 4px;">{{ __('طلب سيارة') }}</h2>
                        <p style="color: var(--color-text-muted); font-size: 14px;">{{ __('املأ البيانات أدناه') }}</p>
                    </div>

                 
                    <form action="{{ route('store.booking.store') }}" method="POST">
                        @csrf
                        <div class="form-group mb-20">
                            <label class="req-label">{{ __('الاسم الكامل') }} <span>*</span></label>
                            <div class="input-with-icon">
                                <i class="bi bi-person text-muted"></i>
                                <input type="text" name="client_name" id="bookingName" class="form-control" placeholder="{{ __('أدخل الاسم الكامل') }}"
                                    required>
                            </div>
                        </div>

                        <div class="form-group mb-20">
                            <label class="req-label">{{ __('رقم الجوال') }} <span>*</span></label>
                            <div class="input-with-icon">
                                <i class="bi bi-phone text-muted" style="transform: scaleX(-1);"></i>
                                <input type="tel" name="client_phone" id="bookingPhone" class="form-control" placeholder="01xxxxxxxxx" style="text-align: right;"
                                    required>
                            </div>
                        </div>

                        <div class="form-group mb-20">
                            <label class="req-label">{{ __('موديل السيارة المطلوب') }} <span>*</span></label>
                            <select class="form-control form-select-icon" name="car_id" required>
                                <option value="">{{ __('اختر الموديل') }}</option>
                                @foreach ($cars as $car)
                                    <option value="{{ $car->id }}">{{ $car->name }}
                                        @if ($car->year)
                                            — {{ $car->year }}
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group mb-20">
                            <label class="req-label">{{ __('المدينة') }} <span>*</span></label>
                            <select class="form-control form-select-icon" name="city">
                                <option value="القاهرة">{{ __('القاهرة') }}</option>
                                <option value="جدة">{{ __('جدة') }}</option>
                                <option value="الرياض">{{ __('الرياض') }}</option>
                            </select>
                        </div>

                        {{-- Hidden inputs to capture calculator values if needed --}}
                        <input type="hidden" name="down_payment" id="hidden_down_payment" value="0">
                        <input type="hidden" name="monthly_installment" id="hidden_monthly" value="0">
                        <input type="hidden" name="duration_years" id="hidden_duration" value="1">
                        <input type="hidden" name="total_price" id="hidden_total" value="0">
                        <input type="hidden" name="interest_rate" id="hidden_rate" value="0">

                        <div class="form-group mb-20">
                            <label
                                style="font-size: 13px; font-weight: 600; display: block; margin-bottom: 6px;">{{ __('ملاحظات إضافية') }}</label>
                            <textarea name="notes" class="form-control" rows="3" placeholder="{{ __('أي تفاصيل أو طلبات خاصة...') }}"
                                style="resize:none;"></textarea>
                        </div>

                        <button type="submit" class="btn-submit-booking">
                            {{ __('إرسال طلب السيارة') }}
                        </button>
                    </form>
                </div>

                {{-- Left: Calculator --}}
                <div class="calculator-section">
                    {{-- Calculator Lock Overlay (3 Steps) --}}
                    <div class="calculator-lock" id="calculatorLock">
                        <div class="lock-content">

                            {{-- ===== Step 1: Name + Phone ===== --}}
                            <div id="otpStep1">
                                <i class="bi bi-shield-lock lock-icon"></i>
                                <h3>{{ __('احسب أقساطك الآن') }}</h3>
                                <p>{{ __('يرجى تزويدنا بالاسم ورقم الجوال لإرسال رمز التحقق') }}</p>

                                <form id="calculatorLeadForm">
                                    <div class="form-group mb-16">
                                        <input type="text" id="leadName" class="form-control calc-dark-field text-center"
                                            placeholder="{{ __('الاسم الكامل') }}" required autocomplete="name">
                                    </div>
                                    <div class="form-group mb-24">
                                        <input type="tel" id="leadPhone" class="form-control calc-dark-field text-center"
                                            placeholder="{{ __('رقم الجوال — مثال: 0512345678') }}" required autocomplete="tel">
                                    </div>
                                    <div id="step1Error" class="otp-error-msg" style="display:none;"></div>
                                    <button type="submit" class="btn-submit-booking" id="sendOtpBtn">
                                        {{ __('إرسال رمز التحقق') }}
                                    </button>
                                </form>
                            </div>

                            {{-- ===== Step 2: OTP Code ===== --}}
                            <div id="otpStep2" style="display:none;">
                                <i class="bi bi-phone-vibrate lock-icon" style="color:#22c55e;"></i>
                                <h3>{{ __('أدخل رمز التحقق') }}</h3>
                                <p id="otpSentMsg">{{ __('تم إرسال رمز مكون من 6 أرقام إلى جوالك') }}</p>

                                <form id="otpVerifyForm">
                                    <div class="form-group mb-16">
                                        <input type="text" id="otpCode" class="form-control calc-dark-field text-center"
                                            placeholder="● ● ● ● ● ●"
                                            maxlength="6" inputmode="numeric" pattern="[0-9]{6}"
                                            autocomplete="one-time-code" required
                                            style="font-size: 26px; font-weight: 800; letter-spacing: 10px;">
                                    </div>

                                    {{-- Countdown Timer --}}
                                    <div class="otp-timer-wrap mb-16">
                                        <span class="otp-timer-label">{{ __('ينتهي خلال') }}</span>
                                        <span class="otp-timer-badge" id="otpCountdown">05:00</span>
                                    </div>

                                    <div id="step2Error" class="otp-error-msg" style="display:none;"></div>

                                    <button type="submit" class="btn-submit-booking" id="verifyOtpBtn">
                                        {{ __('تحقق وافتح الحاسبة') }}
                                    </button>
                                </form>

                                <div style="margin-top:16px;">
                                    <button type="button" id="resendOtpBtn" class="otp-resend-btn" disabled>
                                        {{ __('إعادة إرسال الرمز') }}
                                        <span id="resendCountdown"></span>
                                    </button>
                                    <br>
                                    <button type="button" id="backToStep1Btn" class="otp-back-btn">
                                        ← {{ __('تعديل الرقم') }}
                                    </button>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div style="text-align: center; margin-bottom: 32px;">
                        <h2 style="font-weight: 800; font-size: 24px; color: #fff; margin-bottom: 4px;">
                            {{ __('حاسبة الأقساط') }}</h2>
                        <p style="color: rgba(255,255,255,0.6); font-size: 14px;">{{ __('احسب قيمة القسط الشهري') }}</p>
                    </div>

                    @if ($calculatorBanks->isEmpty())
                        <div class="alert alert-warning text-dark mb-24" style="border-radius: var(--radius-md);">
                            {{ __('لم تُضف بنوك بعد. أضف البنوك من لوحة التحكم: إعدادات الحاسبة.') }}
                        </div>
                    @endif

                    {{-- ربط سعر سيارة من المخزون --}}
                    @if ($cars->isNotEmpty())
                        <div class="range-group">
                            <label
                                style="color: #fff; font-size: 14px; margin-bottom: 8px; display: block;">{{ __('تحميل سعر من موديل') }}</label>
                            <select class="form-control calc-dark-field" id="calcCarPick">
                                <option value="">{{ __('— اختياري —') }}</option>
                                @foreach ($cars as $car)
                                    <option value="{{ (int) $car->cash_price }}">{{ $car->name }}
                                        @if ($car->year)
                                            ({{ $car->year }})
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    @endif

                    {{-- Price Slider --}}
                    <div class="range-group">
                        <div class="range-header">
                            <label>{{ __('سعر السيارة') }}</label>
                            <span class="val text-primary"><span id="valPrice">500,000</span>
                                <small>{!! __('ريال') !!}</small></span>
                        </div>
                        <input type="range" class="custom-range" id="carPrice" min="50000" max="2500000" step="10000"
                            value="500000">
                        <div class="range-min-max">
                            <span>2,500,000</span>
                            <span>50,000</span>
                        </div>
                    </div>

                    {{-- Down Payment Slider --}}
                    <div class="range-group">
                        <div class="range-header">
                            <label>{{ __('الدفعة المقدمة') }}</label>
                            <div class="d-flex align-items-center gap-12">
                                <span class="dp-percent" id="valDpPercent">30%</span>
                                <span class="val text-primary"><span id="valDpAmount">150,000</span>
                                    <small>{!! __('ريال') !!}</small></span>
                            </div>
                        </div>
                        <input type="range" class="custom-range" id="carDp" min="0" max="80" step="5" value="30">
                        <div class="range-min-max">
                            <span id="maxDpDisplay">400,000</span>
                            <span>0</span>
                        </div>
                    </div>

                    {{-- مدة التمويل: 6 أو 12 شهر --}}
                    <div class="range-group">
                        <div class="range-header">
                            <label>{{ __('مدة التمويل') }}</label>
                            <span class="val text-primary"><span id="valTerm">12</span>
                                <small>{{ __('شهر') }}</small></span>
                        </div>
                        <div class="term-toggle" id="termToggle">
                            <button type="button" class="term-btn" data-months="6">{{ __('6 شهور') }}</button>
                            <button type="button" class="term-btn active" data-months="12">{{ __('سنة (12 شهر)') }}</button>
                        </div>
                        <input type="hidden" id="carTerm" value="12">
                    </div>

                    {{-- عوامل تعديل النسبة (من لوحة التحكم) --}}
                    <div class="calc-profile-grid mt-24">
                        <div class="range-group mb-16">
                            <label class="calc-label-dark">{{ __('الجنس') }}</label>
                            <select class="form-control calc-dark-field" id="calcGender">
                                <option value="">{{ __('— اختر —') }}</option>
                                @foreach ($calculatorConfig['genders'] ?? [] as $g)
                                    <option value="{{ $g['id'] }}" data-adj="{{ $g['adj'] }}">{{ $g['label'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="range-group mb-16">
                            <label class="calc-label-dark">{{ __('العمر') }}</label>
                            <input type="number" class="form-control calc-dark-field" id="calcAge" min="15" max="100"
                                placeholder="{{ __('مثال: 28') }}">
                        </div>
                        <div class="range-group mb-16">
                            <label class="calc-label-dark">{{ __('شريحة الراتب') }}</label>
                            <select class="form-control calc-dark-field" id="calcSalary">
                                <option value="">{{ __('— اختر —') }}</option>
                                @foreach ($calculatorConfig['salaries'] ?? [] as $s)
                                    <option value="{{ $s['id'] }}" data-adj="{{ $s['adj'] }}">{{ $s['label'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="range-group mb-16">
                            <label class="calc-label-dark">{{ __('نوع العمل') }}</label>
                            <select class="form-control calc-dark-field" id="calcEmployment">
                                <option value="">{{ __('— اختر —') }}</option>
                                @foreach ($calculatorConfig['employments'] ?? [] as $e)
                                    <option value="{{ $e['id'] }}" data-adj="{{ $e['adj'] }}">{{ $e['label'] }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- Banks --}}
                    <div class="banks-section mt-32">
                        <label
                            style="color: #fff; font-size: 14px; margin-bottom: 12px; display: block; text-align: right;">{{ __('اختر البنك') }}</label>
                        <div class="banks-grid">
                            @forelse ($calculatorBanks as $idx => $bank)
                                <div class="bank-card {{ $idx === 0 ? 'active' : '' }}"
                                    onclick="selectBank(this)"
                                    data-rate="{{ $bank->annual_rate }}"
                                    role="button"
                                    tabindex="0">
                                    <div class="d-flex align-items-center justify-content-center gap-8 mb-4">
                                        <i class="bi bi-bank2 text-warning"></i>
                                        <span style="font-weight: 700; color: #fff;">{{ $bank->name }}</span>
                                    </div>
                                    <div style="font-size: 11px; color: rgba(255,255,255,0.6);">
                                        {{ __('نسبة:') }} {{ number_format($bank->annual_rate, 2) }}%</div>
                                </div>
                            @empty
                                <p class="text-white-50 small mb-0">{{ __('لا توجد بنوك مفعّلة.') }}</p>
                            @endforelse
                        </div>
                    </div>

                    {{-- Result --}}
                    <div class="result-box mt-32">
                        <div style="font-size: 14px; margin-bottom: 2px;">{{ __('القسط الشهري') }}</div>
                        <div class="d-flex align-items-baseline justify-content-center gap-8">
                            <span style="font-size: 40px; font-weight: 800; font-family: sans-serif;"
                                id="resMonthly">6,367</span>
                            <span style="font-size: 18px;">{!! __('ريال') !!}</span>
                        </div>
                    </div>

                    {{-- Details Grid --}}
                    <div class="details-grid mt-16">
                        <div class="detail-box">
                            <div class="det-title">{{ __('إجمالي التمويل المستحق') }}</div>
                            <div class="det-val"><span id="resTotal">382,027</span> <small>{!! __('ريال') !!}</small></div>
                        </div>
                        <div class="detail-box">
                            <div class="det-title">{{ __('مبلغ التمويل') }}</div>
                            <div class="det-val"><span id="resLoan">350,000</span> <small>{!! __('ريال') !!}</small></div>
                        </div>
                        <div class="detail-box">
                            <div class="det-title">{{ __('نسبة الفائدة الفعلية') }}</div>
                            <div class="det-val"><span id="resRate">0%</span> <small>{{ __('سنوياً') }}</small></div>
                        </div>
                        <div class="detail-box">
                            <div class="det-title">{{ __('الدفعة الأولى') }}</div>
                            <div class="det-val"><span id="resDownPay">150,000</span> <small>{!! __('ريال') !!}</small></div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

        {{-- Decision CTA --}}
    <section style="padding: 0 0 60px;">
        <div class="container">
            <div class="decision-card">
                <h2 style="font-weight: 800; font-size: 28px; margin-bottom: 8px;">{{ __('اتخذت قرارك؟') }}</h2>
                <p style="opacity: 0.9; margin-bottom: 32px;">{{ __('تواصل معنا الآن لحجز موعد تجربة القيادة') }}</p>

                <div class="decision-cta-btns">
                    <a href="https://wa.me/{{ $globalSettings['contact_whatsapp'] ?? '966500000000' }}" target="_blank" class="btn btn-primary decision-btn">
                        {{ __('تواصل معنا لمساعدتك') }}
                    </a>
                    <a href="{{ route('store.booking.create') }}" class="btn decision-btn decision-btn--light">
                        {{ __('طلب تجربة قيادة') }}
                    </a>
                </div>
            </div>
        </div>
    </section>

    <style>
        /* ---- Layout CSS ---- */
        .features-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 24px;
            max-width: 900px;
            margin: 0 auto;
        }

        .feature-card {
            background: #fff;
            border: 1px solid var(--color-border);
            border-radius: var(--radius-md);
            padding: 24px;
            text-align: center;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.02);
        }

        .feature-icon {
            color: #ee1e26;
            font-size: 32px;
            margin-bottom: 12px;
            display: inline-block;
        }

        .calc-booking-wrapper {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 32px;
            align-items: stretch;
        }

        /* --- Right side (Booking) --- */
        .booking-section {
            background: #fff;
            border: 1px solid var(--color-border);
            border-radius: var(--radius-lg);
            padding: 40px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        }

        .type-tabs {
            display: flex;
            justify-content: center;
            gap: 16px;
            margin-bottom: 32px;
        }

        .type-tab {
            padding: 12px 24px;
            border: 1px solid var(--color-border);
            border-radius: var(--radius-md);
            font-size: 15px;
            font-weight: 700;
            color: var(--color-text-muted);
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: 0.3s;
        }

        .type-tab.active {
            border-color: var(--primary);
            color: var(--primary);
            background: rgba(238, 30, 38, 0.05);
        }

        .form-group label.req-label {
            font-size: 13px;
            font-weight: 600;
            display: block;
            margin-bottom: 6px;
            text-align: right;
        }

        .form-group label.req-label span {
            color: var(--primary);
        }

        .input-with-icon {
            position: relative;
        }

        .input-with-icon i {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
        }

        .input-with-icon .form-control {
            padding-right: 44px;
        }

        .form-select-icon {
            background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23343a40' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: left 16px center;
            background-size: 16px 12px;
        }

        .btn-submit-booking {
            width: 100%;
            background: #900000;
            color: #fff;
            border: none;
            padding: 18px;
            border-radius: var(--radius-md);
            font-weight: 800;
            font-size: 16px;
            cursor: pointer;
            transition: 0.3s;
        }

        .btn-submit-booking:hover {
            background: #700000;
        }

        /* --- Left side (Calculator) --- */
        .calculator-section {
            background: #0d121c;
            /* Dark navy styling */
            border-radius: var(--radius-lg);
            padding: 40px;
            position: relative;
            overflow: hidden;
        }

        .calculator-lock {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(13, 18, 28, 0.96);
            z-index: 1000;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px;
            text-align: center;
            backdrop-filter: blur(8px);
            transition: 0.5s;
        }

        .calculator-lock.unlocked {
            opacity: 0;
            pointer-events: none;
            visibility: hidden;
        }

        .lock-content {
            max-width: 350px;
            width: 100%;
        }

        .lock-icon {
            font-size: 50px;
            color: var(--primary);
            margin-bottom: 20px;
            display: block;
        }

        .lock-content h3 {
            color: #fff;
            font-weight: 800;
            margin-bottom: 12px;
        }

        .lock-content p {
            color: rgba(255, 255, 255, 0.6);
            font-size: 14px;
            margin-bottom: 30px;
        }

        /* ---- OTP UI Styles ---- */
        .otp-error-msg {
            background: rgba(220, 38, 38, 0.15);
            border: 1px solid rgba(220, 38, 38, 0.4);
            color: #fca5a5;
            border-radius: 8px;
            padding: 10px 14px;
            font-size: 13px;
            margin-bottom: 14px;
            text-align: center;
        }

        .otp-timer-wrap {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            color: rgba(255,255,255,0.6);
            font-size: 13px;
        }

        .otp-timer-badge {
            background: rgba(255,255,255,0.1);
            color: #fff;
            font-weight: 800;
            font-size: 15px;
            padding: 4px 12px;
            border-radius: 6px;
            font-variant-numeric: tabular-nums;
            min-width: 58px;
            text-align: center;
            transition: color 0.3s;
        }

        .otp-timer-badge.danger {
            color: #f87171;
            background: rgba(220, 38, 38, 0.2);
        }

        .otp-resend-btn {
            background: none;
            border: 1px solid rgba(255,255,255,0.2);
            color: rgba(255,255,255,0.7);
            border-radius: 8px;
            padding: 8px 20px;
            font-size: 13px;
            cursor: pointer;
            transition: 0.2s;
            width: 100%;
            margin-bottom: 8px;
        }

        .otp-resend-btn:not(:disabled):hover {
            background: rgba(255,255,255,0.08);
            color: #fff;
        }

        .otp-resend-btn:disabled {
            opacity: 0.4;
            cursor: not-allowed;
        }

        .otp-back-btn {
            background: none;
            border: none;
            color: rgba(255,255,255,0.45);
            font-size: 13px;
            cursor: pointer;
            text-decoration: underline;
            padding: 4px 0;
        }

        .otp-back-btn:hover {
            color: rgba(255,255,255,0.75);
        }

        .range-group {
            margin-bottom: 24px;
            text-align: right;
        }

        .range-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 12px;
        }

        .range-header label {
            color: #fff;
            font-size: 14px;
            margin: 0;
        }

        .dp-percent {
            background: rgba(255, 255, 255, 0.1);
            color: #fff;
            padding: 4px 10px;
            border-radius: 6px;
            font-size: 12px;
        }

        .range-min-max {
            display: flex;
            justify-content: space-between;
            margin-top: 8px;
            color: rgba(255, 255, 255, 0.4);
            font-size: 11px;
        }

        .val {
            font-weight: 800;
            font-size: 18px;
        }

        /* Custom slider style */
        .custom-range {
            -webkit-appearance: none;
            width: 100%;
            height: 6px;
            border-radius: 4px;
            background: #2a3441;
            outline: none;
        }

        .custom-range::-webkit-slider-thumb {
            -webkit-appearance: none;
            appearance: none;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background: #fff;
            border: 4px solid var(--primary);
            cursor: pointer;
        }

        .custom-range::-moz-range-thumb {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background: #fff;
            border: 4px solid var(--primary);
            cursor: pointer;
        }

        .calc-dark-field {
            background: #2a3441 !important;
            border-color: #3d4a5c !important;
            color: #fff !important;
        }

        .calc-dark-field:focus {
            box-shadow: 0 0 0 0.2rem rgba(238, 30, 38, 0.25);
            border-color: var(--primary) !important;
        }

        .calc-label-dark {
            color: #fff;
            font-size: 13px;
            margin-bottom: 6px;
            display: block;
            text-align: right;
        }

        .calc-profile-grid {
            padding-top: 8px;
            border-top: 1px solid #2a3441;
        }

        .term-toggle {
            display: flex;
            gap: 10px;
        }

        .term-btn {
            flex: 1;
            padding: 12px 16px;
            border-radius: var(--radius-sm);
            border: 1px solid #2a3441;
            background: transparent;
            color: rgba(255, 255, 255, 0.75);
            font-weight: 700;
            cursor: pointer;
            transition: 0.2s;
        }

        .term-btn:hover {
            background: rgba(255, 255, 255, 0.06);
        }

        .term-btn.active {
            border-color: var(--primary);
            color: #fff;
            background: rgba(238, 30, 38, 0.15);
        }

        /* Banks Grid */
        .banks-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }

        .bank-card {
            border: 1px solid #2a3441;
            background: transparent;
            border-radius: var(--radius-sm);
            padding: 16px;
            text-align: center;
            cursor: pointer;
            transition: 0.2s;
        }

        .bank-card:hover {
            background: rgba(255, 255, 255, 0.05);
        }

        .bank-card.active {
            border-color: rgba(255, 255, 255, 0.5);
            background: rgba(255, 255, 255, 0.1);
        }

        .result-box {
            background: linear-gradient(180deg, #900000 0%, #4a0000 100%);
            color: #fff;
            border-radius: var(--radius-md);
            padding: 24px;
            text-align: center;
        }

        .details-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }

        .detail-box {
            background: rgba(255, 255, 255, 0.05);
            border-radius: var(--radius-md);
            padding: 16px;
            text-align: center;
        }

        .det-title {
            font-size: 12px;
            color: rgba(255, 255, 255, 0.6);
            margin-bottom: 6px;
        }

        .det-val {
            color: #fff;
            font-weight: 700;
            font-size: 16px;
        }

        /* Decision CTA Buttons */
        .decision-cta-btns {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 16px;
            flex-wrap: wrap;
        }

        .decision-btn {
            padding: 14px 36px;
            border-radius: 30px;
            font-weight: 800;
            font-size: 15px;
            text-decoration: none;
            transition: 0.3s;
            display: inline-block;
            min-width: 180px;
            text-align: center;
        }

        .decision-btn:hover { opacity: 0.9; transform: translateY(-1px); }

        .decision-btn--light {
            background: #fff;
            color: #000;
        }

        /* Decision Card */
        .decision-card {
            background: linear-gradient(135deg, #101010, #1e1e1e);
            border-radius: var(--radius-md);
            padding: 50px;
            text-align: center;
            color: #fff;
        }


        @media(max-width: 900px) {
            .features-grid {
                
    grid-template-columns: repeat(2, 1fr)
            }

            .calc-booking-wrapper {
                grid-template-columns: 1fr;
            }
        }

        @media(max-width: 640px) {
            .booking-section {
                padding: 24px 18px;
            }

            .calculator-section {
                padding: 24px 18px;
            }

            .features-grid {
                grid-template-columns: 1fr;
                gap: 14px;
            }

            .feature-card {
                padding: 16px;
            }

            .banks-grid {
                grid-template-columns: 1fr 1fr;
                gap: 8px;
            }

            .bank-card {
                padding: 10px 8px;
            }

            .details-grid {
                grid-template-columns: 1fr 1fr;
                gap: 8px;
            }

            .detail-box {
                padding: 12px;
            }

            .det-val {
                font-size: 14px;
            }

            .result-box {
                padding: 18px;
            }

            #resMonthly {
                font-size: 30px !important;
            }

            .decision-card {
                padding: 28px 16px !important;
            }

            .decision-cta-btns {
                flex-direction: column;
                gap: 12px;
            }

            .decision-btn {
                width: 100%;
                padding: 14px 20px;
            }
        }
    </style>
@endsection

@section('js')
    <script>
        window.CALCULATOR_CONFIG = @json($calculatorConfig);

        let baseBankRate = 0;

        const carPrice = document.getElementById('carPrice');
        const valPrice = document.getElementById('valPrice');
        const carDp = document.getElementById('carDp');
        const valDpPercent = document.getElementById('valDpPercent');
        const valDpAmount = document.getElementById('valDpAmount');
        const carTerm = document.getElementById('carTerm');
        const valTerm = document.getElementById('valTerm');
        const resMonthly = document.getElementById('resMonthly');
        const resTotal = document.getElementById('resTotal');
        const resLoan = document.getElementById('resLoan');
        const resRate = document.getElementById('resRate');
        const resDownPay = document.getElementById('resDownPay');

        const calcGender = document.getElementById('calcGender');
        const calcAge = document.getElementById('calcAge');
        const calcSalary = document.getElementById('calcSalary');
        const calcEmployment = document.getElementById('calcEmployment');
        const calcCarPick = document.getElementById('calcCarPick');

        function formatNumber(num) {
            return Math.round(num).toLocaleString('en-US');
        }

        function clampRate(r) {
            return Math.max(0, Math.min(100, r));
        }

        function selectAdjustment(sel) {
            if (!sel || !sel.value) return 0;
            const opt = sel.options[sel.selectedIndex];
            const v = parseFloat(opt.getAttribute('data-adj') || '0');
            return isNaN(v) ? 0 : v;
        }

        function ageBandAdjustment(ageVal) {
            const cfg = window.CALCULATOR_CONFIG || {};
            const bands = cfg.ageBands || [];
            const n = parseInt(ageVal, 10);
            if (!n || isNaN(n)) return 0;
            const band = bands.find(b => b.min != null && b.max != null && n >= b.min && n <= b.max);
            return band ? (parseFloat(band.adj) || 0) : 0;
        }

        function effectiveAnnualRate() {
            let r = baseBankRate + selectAdjustment(calcGender) + ageBandAdjustment(calcAge ? calcAge.value :
                '') +
                selectAdjustment(calcSalary) + selectAdjustment(calcEmployment);
            return clampRate(r);
        }

        /** نفس منطق Car::calculateInstallment (قسط متساوٍ) */
        function installmentBreakdown(price, dpPercent, months, annualPct) {
            const down = Math.round(price * (dpPercent / 100));
            const principal = Math.max(0, price - down);
            const m = Math.max(1, parseInt(months, 10) || 1);
            const monthlyRate = annualPct / 100 / 12;
            let monthly;
            if (monthlyRate <= 0) {
                monthly = principal / m;
            } else {
                monthly = principal * (monthlyRate * Math.pow(1 + monthlyRate, m)) / (Math.pow(1 + monthlyRate, m) -
                    1);
            }
            const total = monthly * m + down;
            return {
                monthly,
                total,
                principal,
                down
            };
        }

        function calculate() {
            const price = parseInt(carPrice.value, 10) || 0;
            valPrice.innerText = formatNumber(price);

            const dpPercent = parseInt(carDp.value, 10);
            valDpPercent.innerText = dpPercent + '%';

            const dpAmount = (dpPercent / 100) * price;
            valDpAmount.innerText = formatNumber(dpAmount);

            const term = parseInt(carTerm.value, 10) || 12;
            valTerm.innerText = term;

            const maxDp = document.getElementById('maxDpDisplay');
            if (maxDp) maxDp.innerText = formatNumber(price * 0.8);

            const annual = effectiveAnnualRate();
            const {
                monthly,
                total,
                principal,
                down
            } = installmentBreakdown(price, dpPercent, term, annual);

            resMonthly.innerText = formatNumber(monthly);
            resTotal.innerText = formatNumber(total);
            resLoan.innerText = formatNumber(principal);
            resRate.innerText = annual.toFixed(2) + '%';
            resDownPay.innerText = formatNumber(down);

            updateSliderTrack(carPrice);
            updateSliderTrack(carDp);
        }

        function updateSliderTrack(el) {
            if (!el || el.type !== 'range') return;
            const value = (el.value - el.min) / (el.max - el.min) * 100;
            el.style.background = `linear-gradient(to left, #ee1e26 ${value}%, #2a3441 ${value}%)`;
        }

        const firstBank = document.querySelector('.bank-card[data-rate]');
        if (firstBank) {
            baseBankRate = parseFloat(firstBank.getAttribute('data-rate')) || 0;
        }

        window.selectBank = function(el) {
            document.querySelectorAll('.bank-card').forEach(c => c.classList.remove('active'));
            el.classList.add('active');
            baseBankRate = parseFloat(el.getAttribute('data-rate')) || 0;
            calculate();
        };

        document.querySelectorAll('#termToggle .term-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                document.querySelectorAll('#termToggle .term-btn').forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
                carTerm.value = btn.getAttribute('data-months');
                calculate();
            });
        });

        carPrice.addEventListener('input', calculate);
        carDp.addEventListener('input', calculate);
        [calcGender, calcSalary, calcEmployment].forEach(el => {
            if (el) el.addEventListener('change', calculate);
        });
        if (calcAge) calcAge.addEventListener('input', calculate);

        if (calcCarPick) {
            calcCarPick.addEventListener('change', () => {
                const v = calcCarPick.value;
                if (v) {
                    const p = parseInt(v, 10);
                    if (!isNaN(p)) {
                        carPrice.value = Math.min(parseInt(carPrice.max, 10), Math.max(parseInt(carPrice.min, 10), p));
                    }
                }
                calculate();
            });
        }

        // Sync hidden inputs for booking form
        function syncHiddenInputs() {
            document.getElementById('hidden_down_payment').value = document.getElementById('resDownPay').innerText.replace(/,/g, '');
            document.getElementById('hidden_monthly').value = document.getElementById('resMonthly').innerText.replace(/,/g, '');
            const termVal = document.getElementById('carTerm').value;
            document.getElementById('hidden_duration').value = Math.max(1, Math.ceil(termVal / 12));
            document.getElementById('hidden_total').value = document.getElementById('resTotal').innerText.replace(/,/g, '');
            document.getElementById('hidden_rate').value = document.getElementById('resRate').innerText.replace('%', '');
        }

        // Listen for changes and sync
        [carPrice, carDp, carTerm].forEach(el => {
            el.addEventListener('input', syncHiddenInputs);
        });
        document.getElementById('calcCarPick')?.addEventListener('change', syncHiddenInputs);
        document.querySelectorAll('.bank-card').forEach(b => b.addEventListener('click', syncHiddenInputs));

        calculate();
        syncHiddenInputs();

        // ===== Tracking Events =====

        // Form View
        trackEvent('FormView', { form_type: 'calculator_lead' });
        trackEvent('FormView', { form_type: 'calculator_booking' });

        // Form Started - Calculator Lead Form (one-time)
        let leadFormStartedFired = false;
        if (leadForm) {
            leadForm.addEventListener('focusin', function() {
                if (!leadFormStartedFired) {
                    leadFormStartedFired = true;
                    trackEvent('FormStarted', { form_type: 'calculator_lead' });
                }
            });
        }

        // Form Started - Booking Form on calculator page (one-time)
        const calcBookingForm = document.querySelector('.booking-section form');
        let calcBookingFormStartedFired = false;
        if (calcBookingForm) {
            calcBookingForm.addEventListener('focusin', function() {
                if (!calcBookingFormStartedFired) {
                    calcBookingFormStartedFired = true;
                    trackEvent('FormStarted', { form_type: 'calculator_booking' });
                }
            });
        }

        // ===== Calculator OTP Lock Logic =====
        const lockOverlay  = document.getElementById('calculatorLock');
        const step1        = document.getElementById('otpStep1');
        const step2        = document.getElementById('otpStep2');
        const leadForm     = document.getElementById('calculatorLeadForm');
        const otpVerifyForm= document.getElementById('otpVerifyForm');
        const sendOtpBtn   = document.getElementById('sendOtpBtn');
        const verifyOtpBtn = document.getElementById('verifyOtpBtn');
        const resendBtn    = document.getElementById('resendOtpBtn');
        const backBtn      = document.getElementById('backToStep1Btn');
        const step1Error   = document.getElementById('step1Error');
        const step2Error   = document.getElementById('step2Error');
        const otpCountdown = document.getElementById('otpCountdown');
        const resendCountdown = document.getElementById('resendCountdown');

        const OTP_TTL_SECONDS = 300; // 5 دقائق
        const RESEND_COOLDOWN = 60;  // 60 ثانية قبل إعادة الإرسال

        let countdownInterval = null;
        let resendInterval    = null;
        let currentPhone      = '';
        let currentName       = '';

        // ---------- Helpers ----------
        function showError(el, msg) {
            el.textContent = msg;
            el.style.display = 'block';
        }
        function hideError(el) {
            el.style.display = 'none';
        }

        function formatTime(sec) {
            const m = String(Math.floor(sec / 60)).padStart(2, '0');
            const s = String(sec % 60).padStart(2, '0');
            return `${m}:${s}`;
        }

        function startOtpCountdown() {
            clearInterval(countdownInterval);
            let remaining = OTP_TTL_SECONDS;
            otpCountdown.classList.remove('danger');
            otpCountdown.textContent = formatTime(remaining);

            countdownInterval = setInterval(() => {
                remaining--;
                otpCountdown.textContent = formatTime(remaining);
                if (remaining <= 60) otpCountdown.classList.add('danger');
                if (remaining <= 0) {
                    clearInterval(countdownInterval);
                    otpCountdown.textContent = '00:00';
                    showError(step2Error, '{{ __("انتهت صلاحية الرمز، اضغط إعادة الإرسال") }}');
                    verifyOtpBtn.disabled = true;
                }
            }, 1000);
        }

        function startResendCooldown() {
            resendBtn.disabled = true;
            let sec = RESEND_COOLDOWN;
            resendCountdown.textContent = ` (${sec})`;
            clearInterval(resendInterval);
            resendInterval = setInterval(() => {
                sec--;
                resendCountdown.textContent = sec > 0 ? ` (${sec})` : '';
                if (sec <= 0) {
                    clearInterval(resendInterval);
                    resendBtn.disabled = false;
                }
            }, 1000);
        }

        function unlockCalculator() {
            localStorage.setItem('calculator_unlocked', 'true');
            localStorage.setItem('lead_name',  currentName);
            localStorage.setItem('lead_phone', currentPhone);

            // ملء نموذج الحجز
            const bookingName  = document.getElementById('bookingName');
            const bookingPhone = document.getElementById('bookingPhone');
            if (bookingName)  bookingName.value  = currentName;
            if (bookingPhone) bookingPhone.value = currentPhone;

            clearInterval(countdownInterval);
            clearInterval(resendInterval);

            if (lockOverlay) lockOverlay.classList.add('unlocked');
        }

        // ---------- Check if already unlocked ----------
        if (localStorage.getItem('calculator_unlocked')) {
            if (lockOverlay) lockOverlay.classList.add('unlocked');
            const storedName  = localStorage.getItem('lead_name');
            const storedPhone = localStorage.getItem('lead_phone');
            if (storedName)  document.getElementById('bookingName').value  = storedName;
            if (storedPhone) document.getElementById('bookingPhone').value = storedPhone;
        }

        // ---------- Step 1: Send OTP ----------
        if (leadForm) {
            leadForm.addEventListener('submit', async (e) => {
                e.preventDefault();
                hideError(step1Error);
                sendOtpBtn.disabled = true;
                sendOtpBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>{{ __("جاري الإرسال...") }}';

                currentName  = document.getElementById('leadName').value.trim();
                currentPhone = document.getElementById('leadPhone').value.trim();

                try {
                    const resp = await fetch('{{ route("store.calculator.otp.send") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ name: currentName, phone: currentPhone })
                    });
                    const data = await resp.json();

                    if (data.success) {
                        // الانتقال للمرحلة الثانية
                        step1.style.display = 'none';
                        step2.style.display = 'block';
                        document.getElementById('otpSentMsg').textContent =
                            '{{ __("تم إرسال الرمز إلى") }} ' + currentPhone;
                        document.getElementById('otpCode').value = '';
                        verifyOtpBtn.disabled = false;
                        hideError(step2Error);
                        startOtpCountdown();
                        startResendCooldown();
                    } else {
                        showError(step1Error, data.message || '{{ __("حدث خطأ، حاول مرة أخرى") }}');
                        sendOtpBtn.disabled = false;
                        sendOtpBtn.textContent = '{{ __("إرسال رمز التحقق") }}';
                    }
                } catch (err) {
                    console.error('OTP send error:', err);
                    showError(step1Error, '{{ __("حدث خطأ في الاتصال") }}');
                    sendOtpBtn.disabled = false;
                    sendOtpBtn.textContent = '{{ __("إرسال رمز التحقق") }}';
                }
            });
        }

        // ---------- Step 2: Verify OTP ----------
        if (otpVerifyForm) {
            otpVerifyForm.addEventListener('submit', async (e) => {
                e.preventDefault();
                hideError(step2Error);
                verifyOtpBtn.disabled = true;
                verifyOtpBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>{{ __("جاري التحقق...") }}';

                const code = document.getElementById('otpCode').value.trim();

                try {
                    const resp = await fetch('{{ route("store.calculator.otp.verify") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ phone: currentPhone, code: code })
                    });
                    const data = await resp.json();

                    if (data.success) {
                        unlockCalculator();

                        trackEvent('CalculatorLeadVerified', { phone: currentPhone });

                        const carSelect = calcBookingForm?.querySelector('[name="car_id"]');
                        const carModel = carSelect && carSelect.selectedIndex > 0
                            ? carSelect.options[carSelect.selectedIndex].text?.trim()
                            : '';
                        const salaryEl = document.getElementById('calcSalary');

                        trackEvent('Lead', {
                            phone: currentPhone,
                            car_model: carModel,
                            location: document.querySelector('[name="city"]')?.value || '',
                            salary: salaryEl?.options?.[salaryEl.selectedIndex]?.text || '',
                            car_price: document.getElementById('carPrice')?.value || 0,
                            installment: document.getElementById('resMonthly')?.textContent?.replace(/,/g, '') || 0
                        });
                    } else {
                        showError(step2Error, data.message || '{{ __("الرمز غير صحيح") }}');
                        verifyOtpBtn.disabled = false;
                        verifyOtpBtn.textContent = '{{ __("تحقق وافتح الحاسبة") }}';
                        // إذا انتهت الصلاحية، أعد تفعيل زر الإرسال
                        if (data.expired) {
                            clearInterval(countdownInterval);
                            resendBtn.disabled = false;
                            resendCountdown.textContent = '';
                        }
                    }
                } catch (err) {
                    console.error('OTP verify error:', err);
                    showError(step2Error, '{{ __("حدث خطأ في الاتصال") }}');
                    verifyOtpBtn.disabled = false;
                    verifyOtpBtn.textContent = '{{ __("تحقق وافتح الحاسبة") }}';
                }
            });
        }

        // ---------- Resend OTP ----------
        if (resendBtn) {
            resendBtn.addEventListener('click', async () => {
                hideError(step2Error);
                resendBtn.disabled = true;
                resendBtn.textContent = '{{ __("جاري إعادة الإرسال...") }}';

                try {
                    const resp = await fetch('{{ route("store.calculator.otp.send") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ name: currentName, phone: currentPhone })
                    });
                    const data = await resp.json();

                    if (data.success) {
                        document.getElementById('otpCode').value = '';
                        verifyOtpBtn.disabled = false;
                        hideError(step2Error);
                        startOtpCountdown();
                        startResendCooldown();
                        resendBtn.textContent = '{{ __("إعادة إرسال الرمز") }}';
                    } else {
                        showError(step2Error, data.message || '{{ __("فشل إعادة الإرسال") }}');
                        resendBtn.disabled = false;
                        resendBtn.textContent = '{{ __("إعادة إرسال الرمز") }}';
                    }
                } catch (err) {
                    showError(step2Error, '{{ __("حدث خطأ في الاتصال") }}');
                    resendBtn.disabled = false;
                    resendBtn.textContent = '{{ __("إعادة إرسال الرمز") }}';
                }
            });
        }

        // ---------- Back to Step 1 ----------
        if (backBtn) {
            backBtn.addEventListener('click', () => {
                clearInterval(countdownInterval);
                clearInterval(resendInterval);
                step2.style.display = 'none';
                step1.style.display = 'block';
                hideError(step1Error);
                sendOtpBtn.disabled = false;
                sendOtpBtn.textContent = '{{ __("إرسال رمز التحقق") }}';
            });
        }

        // فلتر: قبول أرقام فقط في حقل OTP
        const otpCodeInput = document.getElementById('otpCode');
        if (otpCodeInput) {
            otpCodeInput.addEventListener('input', () => {
                otpCodeInput.value = otpCodeInput.value.replace(/\D/g, '').slice(0, 6);
            });
        }
    </script>
@endsection