<!DOCTYPE html>
@php
    $globalSettings = app(\App\Services\Cache\BaseCacheService::class)->rememberSettings();
    $socialMedia = $globalSettings['social_media'] ?? [];
    if (!is_array($socialMedia) && is_string($socialMedia)) {
        $socialMedia = json_decode($socialMedia, true) ?: [];
    }
    $googleAnalyticsId = $globalSettings['google_analytics_id'] ?? '';
    $metaPixelId = $globalSettings['meta_pixel_id'] ?? '';
@endphp
<html lang="{{ App::getLocale() }}" dir="{{ App::getLocale() == 'ar' ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @php
        $siteName = $globalSettings['site_name'] ?? 'GR Motors';
        if (is_array($siteName)) {
            $siteName = $siteName[App::getLocale()] ?? ($siteName['ar'] ?? 'GR Motors');
        }
    @endphp
    <title>@yield('title', $siteName)</title>
    <meta name="description" content="@yield('meta_description', __('GR Motors - معرض سيارات فاخر'))">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('store.css') }}">

    @if($googleAnalyticsId)
    {{-- Google Analytics (GA4) --}}
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ $googleAnalyticsId }}"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', '{{ $googleAnalyticsId }}');
    </script>
    @endif

    @yield('css')


</head>

<body class="{{ App::getLocale() == 'en' ? 'ltr' : '' }}">

    @if($metaPixelId)
    {{-- Meta Pixel (Facebook) --}}
    <script>
        !function(f,b,e,v,n,t,s)
        {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
        n.callMethod.apply(n,arguments):n.queue.push(arguments)};
        if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
        n.queue=[];t=b.createElement(e);t.async=!0;
        t.src=v;s=b.getElementsByTagName(e)[0];
        s.parentNode.insertBefore(t,s)}(window, document,'script',
        'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '{{ $metaPixelId }}');
        fbq('track', 'PageView');
    </script>
    <noscript><img height="1" width="1" style="display:none"
        src="https://www.facebook.com/tr?id={{ $metaPixelId }}&ev=PageView&noscript=1"
    /></noscript>
    @endif

    {{-- Top Bar --}}
    <div class="top-bar">
        <div class="container top-bar-inner">
            <div class="top-bar-contact d-flex align-items-center gap-3">
                @if($contactPhone = $globalSettings['contact_phone'] ?? null)
                <a href="tel:{{ $contactPhone }}"><i class="bi bi-telephone"></i> {{ $contactPhone }}</a>
                @endif
                @if($contactEmail = $globalSettings['contact_email'] ?? null)
                <a href="mailto:{{ $contactEmail }}"><i class="bi bi-envelope"></i> {{ $contactEmail }}</a>
                @endif
                @php
                    $altLang = App::getLocale() === 'ar' ? 'en' : 'ar';
                    $altLangText = App::getLocale() === 'ar' ? 'English' : 'العربية';
                @endphp
                <a href="{{ route('lang.switch', $altLang) }}" class="lang-switch ms-3">
                    <i class="bi bi-globe"></i> {{ $altLangText }}
                </a>
            </div>
            @if($contactAddress = $globalSettings['contact_address'] ?? null)
            <div class="top-bar-location">
                <span><i class="bi bi-geo-alt"></i> {{ $contactAddress }}</span>
            </div>
            @endif
        </div>
    </div>

    {{-- Main Header --}}
    <header id="site-header">
        <div class="container header-inner">

            {{-- Call To Action --}}
            @if($contactPhone = $globalSettings['contact_phone'] ?? null)
            <div>
                <a href="tel:{{ $contactPhone }}" class="btn-call-now">
                    {{ __('اتصل الآن') }} <i class="bi bi-telephone"></i>
                </a>
            </div>
            @endif

            {{-- Main Navigation --}}
            <nav class="site-nav" id="siteNav">
                {{-- Sidebar Header: Logo & Close --}}
                <div class="sidebar-header d-lg-none">
                    <div class="sidebar-logo">
                        <img src="{{ asset('assets/images/logo.png') }}" alt="Logo">
                    </div>
                    <button class="close-nav-btn" onclick="closeNav()">&times;</button>
                </div>

                {{-- Navigation Links --}}
                <div class="sidebar-links">
                    <a href="{{ route('store.home') }}" class="{{ request()->routeIs('store.home') ? 'active' : '' }}">{{ __('الرئيسية') }}</a>
                    <a href="{{ route('store.cars.index') }}" class="{{ request()->routeIs('store.cars.index') ? 'active' : '' }}">{{ __('السيارات') }}</a>
                    <a href="{{ route('store.offers.index') }}" class="{{ request()->routeIs('store.offers.index') ? 'active' : '' }}">{{ __('الإعلانات') }}</a>
                    <a href="{{ route('store.about') }}" class="{{ request()->routeIs('store.about') ? 'active' : '' }}">{{ __('من نحن') }}</a>
                    <a href="{{ route('store.blog.index') }}" class="{{ request()->routeIs('store.blog.index') ? 'active' : '' }}">{{ __('المقالات') }}</a>
                    <a href="{{ route('store.calculator') }}" class="{{ request()->routeIs('store.calculator') ? 'active' : '' }} text-primary fw-bold">{{ __('الحاسبة') }}</a>
                </div>

                {{-- Sidebar Footer: Language & Social --}}
                <div class="sidebar-footer d-lg-none">
                    <div class="sidebar-section-title">{{ __('اللغة') }}</div>
                    <div class="lang-switch-wrapper">
                        <div class="lang-switch-pill">
                            <a href="{{ route('lang.switch', 'ar') }}" class="{{ App::getLocale() == 'ar' ? 'active' : '' }}">العربية</a>
                            <a href="{{ route('lang.switch', 'en') }}" class="{{ App::getLocale() == 'en' ? 'active' : '' }}">English</a>
                            <div class="lang-switch-bg {{ App::getLocale() == 'en' ? 'slide' : '' }}"></div>
                        </div>
                    </div>

                    <div class="sidebar-section-title">{{ __('تابعنا') }}</div>
                    <div class="sidebar-social">
                        @if(isset($socialMedia) && count($socialMedia) > 0)
                            @foreach($socialMedia as $social)
                                <a href="{{ $social['link'] ?? '#' }}" target="_blank" class="social-item" style="color: {{ $social['color'] ?? '#fff' }}">
                                    <i class="{{ $social['icon'] }}"></i>
                                </a>
                            @endforeach
                        @endif
                    </div>
                </div>
            </nav>

            {{-- Mobile Menu Toggle --}}
            <button class="mobile-menu-btn" id="mobileMenuBtn" aria-label="Menu">
                <span class="hamburger-line"></span>
                <span class="hamburger-line"></span>
                <span class="hamburger-line"></span>
            </button>

            {{-- Logo --}}
            <a href="{{ route('store.home') }}" class="site-logo">
                <img src="{{ asset('assets/images/logo.png') }}" alt="Logo">
            </a>

        </div>
    </header>

    {{-- Mobile Nav Overlay --}}
    <div class="mob-nav-overlay" id="mobNavOverlay"></div>

    {{-- Main Content --}}
    <main id="main-content">
        @yield('content')
    </main>

    {{-- Newsletter Section Redesigned --}}
    <section class="newsletter-premium-section">
        <div class="container">
            <div class="newsletter-inner-wrap">
                <div class="newsletter-text-side">
                    <h3 class="newsletter-title">
                        {{ __('اشترك في') }} <br>
                        <span class="text-primary" style="background: linear-gradient(0deg, rgba(0, 0, 0, 0), rgba(0, 0, 0, 0)),linear-gradient(270deg, #FD7277 0%, #EE1E26 100%);background-clip: text;-webkit-background-clip: text;-webkit-text-fill-color: transparent;">{{ __('نشرتنا الإخبارية') }}</span>
                    </h3>
                    <p class="newsletter-subtitle">{{ __('احصل على آخر العروض والتحديثات مباشرة في بريدك الإلكتروني') }}</p>
                </div>
                <div class="newsletter-form-side">
                    <form class="premium-newsletter-form" id="newsletterForm" novalidate>
                        @csrf
                        <input type="email" name="email" id="newsletterEmail" class="form-control" placeholder="{{ __('أدخل بريدك الإلكتروني') }}" required>
                        <button type="submit" class="btn-newsletter-submit" id="newsletterBtn">
                             {{ __('اشتراك') }} <i class="bi bi-send-fill ms-2"></i>
                        </button>
                    </form>
                    <div id="newsletterMsg" style="display:none; margin-top:10px; font-size:13px; font-weight:700; padding:8px 14px; border-radius:10px;"></div>
                </div>
            </div>
        </div>
        <div class="newsletter-glow"></div>
    </section>

    <script>
    (function() {
        const form    = document.getElementById('newsletterForm');
        const msgBox  = document.getElementById('newsletterMsg');
        const btn     = document.getElementById('newsletterBtn');
        if (!form) return;

        form.addEventListener('submit', async function(e) {
            e.preventDefault();
            const email = document.getElementById('newsletterEmail').value.trim();
            if (!email) return;

            btn.disabled = true;
            btn.innerHTML = '<span style="opacity:0.7">{{ __("جاري الإرسال...") }}</span>';

            try {
                const res = await fetch('{{ route("store.newsletter.subscribe") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({ email }),
                });

                const data = await res.json();

                msgBox.style.display = 'block';
                if (data.success) {
                    msgBox.style.background = 'rgba(0,201,80,0.12)';
                    msgBox.style.color = '#007a36';
                    msgBox.style.border = '1px solid rgba(0,201,80,0.25)';
                    msgBox.textContent = data.message;
                    form.reset();
                    btn.innerHTML = '<i class="bi bi-check-circle-fill"></i> {{ __("تم الاشتراك") }}';
                    btn.style.background = '#16a34a';
                    trackEvent('NewsletterSignup', { email: email });
                } else {
                    msgBox.style.background = 'rgba(237,28,36,0.08)';
                    msgBox.style.color = '#C0152A';
                    msgBox.style.border = '1px solid rgba(237,28,36,0.2)';
                    msgBox.textContent = data.message;
                    btn.disabled = false;
                    btn.innerHTML = '{{ __("اشتراك") }} <i class="bi bi-send-fill ms-2"></i>';
                }

                setTimeout(() => { msgBox.style.display = 'none'; }, 5000);
            } catch (err) {
                msgBox.style.display = 'block';
                msgBox.style.background = 'rgba(237,28,36,0.08)';
                msgBox.style.color = '#C0152A';
                msgBox.textContent = '{{ __("حدث خطأ، يرجى المحاولة مجدداً") }}';
                btn.disabled = false;
                btn.innerHTML = '{{ __("اشتراك") }} <i class="bi bi-send-fill ms-2"></i>';
            }
        });
    })();
    </script>


    {{-- Site Footer Redesigned --}}
    <footer id="site-footer-premium">
        <div class="container">
            <div class="footer-premium-grid">

                {{-- Column 1: Brand & Social --}}
                <div class="footer-premium-col brand-col">
                    <a href="{{ route('store.home') }}" class="footer-logo mb-24">
                        <img src="{{ asset('assets/images/logo.png') }}" alt="Logo">
                    </a>
                    <p class="footer-desc mb-32">
                        {{ __('وجهتك الأولى للحصول على أفخم وأرقى السيارات في العالم. نقدم لك تجربة استثنائية مع خدمة متميزة.') }}
                    </p>
                    @if(isset($socialMedia) && count($socialMedia) > 0)
                    <div class="social-premium-wrap">
                        @foreach($socialMedia as $social)
                            <a href="{{ $social['link'] ?? '#' }}" target="_blank" class="social-premium-item">
                                <i class="{{ $social['icon'] }}"></i>
                            </a>
                        @endforeach
                    </div>
                    @endif
                </div>

                {{-- Column 2: Quick Links --}}
                <div class="footer-premium-col">
                    <h4 class="footer-title-premium">{{ __('روابط سريعة') }}</h4>
                    <ul class="footer-links-premium">
                        <li><a href="{{ route('store.home') }}">{{ __('الرئيسية') }} <i class="bi bi-arrow-left"></i></a></li>
                        <li><a href="{{ route('store.cars.index') }}">{{ __('السيارات') }} <i class="bi bi-arrow-left"></i></a></li>
                        <li><a href="{{ route('store.offers.index') }}">{{ __('الإعلانات') }} <i class="bi bi-arrow-left"></i></a></li>
                        <li><a href="#">{{ __('آراء العملاء') }} <i class="bi bi-arrow-left"></i></a></li>
                    </ul>
                </div>

                {{-- Column 3: Services --}}
                <div class="footer-premium-col">
                    <h4 class="footer-title-premium">{{ __('خدماتنا') }}</h4>
                    <ul class="footer-services-premium">
                        <li><span class="dot"></span> {{ __('بيع السيارات الفاخرة') }}</li>
                        <li><span class="dot"></span> {{ __('استبدال السيارات') }}</li>
                        <li><span class="dot"></span> {{ __('تمويل سيارات') }}</li>
                        <li><span class="dot"></span> {{ __('صيانة دورية') }}</li>
                        <li><span class="dot"></span> {{ __('خدمة ما بعد البيع') }}</li>
                        <li><span class="dot"></span> {{ __('توصيل السيارة') }}</li>
                    </ul>
                </div>

                {{-- Column 4: Contact --}}
                <div class="footer-premium-col contact-col">
                    <h4 class="footer-title-premium">{{ __('تواصل معنا') }}</h4>
                    <div class="contact-premium-list">
                        @if($contactPhone = $globalSettings['contact_phone'] ?? null)
                        <a href="tel:{{ $contactPhone }}" class="contact-premium-item" style="text-decoration:none;color:inherit;">
                            <div class="cp-info">
                                <span class="cp-label">{{ __('اتصل بنا') }}</span>
                                <strong dir="ltr">{{ $contactPhone }}</strong>
                            </div>
                            <div class="cp-icon"><i class="bi bi-telephone"></i></div>
                        </a>
                        @endif
                        @if($contactWhatsApp = $globalSettings['contact_whatsapp'] ?? null)
                        <a href="https://wa.me/{{ $contactWhatsApp }}" target="_blank" class="contact-premium-item" style="text-decoration:none;color:inherit;">
                            <div class="cp-info">
                                <span class="cp-label">{{ __('واتساب') }}</span>
                                <strong dir="ltr">{{ $contactWhatsApp }}</strong>
                            </div>
                            <div class="cp-icon" style="color:#25D366;"><i class="bi bi-whatsapp"></i></div>
                        </a>
                        @endif
                        @if($contactEmail = $globalSettings['contact_email'] ?? null)
                        <a href="mailto:{{ $contactEmail }}" class="contact-premium-item" style="text-decoration:none;color:inherit;">
                            <div class="cp-info">
                                <span class="cp-label">{{ __('راسلنا') }}</span>
                                <strong>{{ $contactEmail }}</strong>
                            </div>
                            <div class="cp-icon"><i class="bi bi-envelope"></i></div>
                        </a>
                        @endif
                        @if($contactAddress = $globalSettings['contact_address'] ?? null)
                        <div class="contact-premium-item">
                            <div class="cp-info">
                                <span class="cp-label">{{ __('العنوان') }}</span>
                                <strong>{{ $contactAddress }}</strong>
                            </div>
                            <div class="cp-icon"><i class="bi bi-geo-alt"></i></div>
                        </div>
                        @endif
                    </div>
                </div>

            </div>

            <div class="footer-bottom-premium">
                <div class="fb-links">
                    <a href="#">{{ __('سياسة الخصوصية') }}</a>
                    <a href="#">{{ __('الشروط والأحكام') }}</a>
                </div>
                <div class="fb-copy">
                    &copy; {{ date('Y') }} GR Motors. {{ __('جميع الحقوق محفوظة.') }}
                </div>
            </div>
        </div>
    </footer>

    @if($whatsappNumber = $globalSettings['contact_whatsapp'] ?? null)
    {{-- WhatsApp Widget --}}
    <a href="https://wa.me/{{ $whatsappNumber }}" class="whatsapp-widget" target="_blank" rel="noopener noreferrer">
        <i class="bi bi-whatsapp"></i>
    </a>
    @endif

    <script>
        const menuBtn = document.getElementById('mobileMenuBtn');
        const nav = document.getElementById('siteNav');
        const overlay = document.getElementById('mobNavOverlay');

        function openNav() {
            nav.classList.add('open');
            overlay.classList.add('visible');
            document.body.style.overflow = 'hidden';
        }
        function closeNav() {
            nav.classList.remove('open');
            overlay.classList.remove('visible');
            document.body.style.overflow = '';
        }

        if (menuBtn) menuBtn.addEventListener('click', openNav);
        if (overlay) overlay.addEventListener('click', closeNav);
    </script>

    {{-- Global Tracking Helpers --}}
    <script>
        @if($googleAnalyticsId)
        function trackGA(action, params) {
            if (typeof gtag === 'function') {
                gtag('event', action, params || {});
            }
        }
        @endif
        @if($metaPixelId)
        function trackPixel(action, params) {
            if (typeof fbq === 'function') {
                fbq('track', action, params || {});
            }
        }
        @endif
        function trackEvent(action, params) {
            @if($googleAnalyticsId)trackGA(action, params);@endif
            @if($metaPixelId)trackPixel(action, params);@endif
        }
    </script>

    @yield('js')

</body>

</html>
