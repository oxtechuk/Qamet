@extends('store.layouts.app')

@section('title', __('من نحن') . ' | ' . (is_array($globalSettings['site_name'] ?? null) ? ($globalSettings['site_name'][App::getLocale()] ?? ($globalSettings['site_name']['ar'] ?? 'GR Motors')) : ($globalSettings['site_name'] ?? 'GR Motors')))

@section('breadcrumb-title', __('من نحن'))

@section('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
<style>
  .about-page {
    border: 1px solid rgba(0,0,0,0.05);
  }

  .swiper-wrapper {
    display: flex !important;
    align-items: stretch !important;
  }
  
  /* Remove section backgrounds to allow the main container background to shine */
  .hero, .gallery, .partners, .contact {
    background: transparent !important;
  }
  /* Add subtle borders between sections for clarity */
  .about-page section:not(:last-child) {
    border-bottom: 1px solid rgba(0,0,0,0.03);
  }

  /* Responsive container margin */
  .about-wrap {
    margin: 3rem auto;
  }

  @media (max-width: 768px) {
    .about-wrap {
      margin: 1rem auto;
    }
  }
</style>
@endsection

@section('content')
@include('partials.Store.breadcrumb')

<div class="container about-wrap">
  <div class="about-page bg-white rounded-4 shadow-sm overflow-hidden">
  <!-- HERO -->
  <section class="hero">
    <div class="hero__container">
      <h1 class="hero__title">{{ __('نحن لسنا مجرد') }} <span class="hero__title--highlight">{{ __('معرض سيارات') }}</span></h1>
      <p class="hero__subtitle">{{ __('نحن شركاؤك نجاحك في رحلة اختيار سيارة أحلامك.') }}</p>
      <div class="hero__stats">
        <div class="hero__stat">
          <div class="hero__stat-icon">
            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
          </div>
          <div class="hero__stat-value">10+</div>
          <div class="hero__stat-label">{{ __('سنة خبرة') }}</div>
        </div>
        <div class="hero__stat">
          <div class="hero__stat-icon">
            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M14 9V5a3 3 0 00-3-3l-4 9v11h11.28a2 2 0 002-1.7l1.38-9a2 2 0 00-2-2.3H14z"/><path d="M7 22H4a2 2 0 01-2-2v-7a2 2 0 012-2h3"/></svg>
          </div>
          <div class="hero__stat-value">98%</div>
          <div class="hero__stat-label">{{ __('رضا العملاء') }}</div>
        </div>
        <div class="hero__stat">
          <div class="hero__stat-icon">
            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"/><path d="M16 21V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v16"/></svg>
          </div>
          <div class="hero__stat-value">200+</div>
          <div class="hero__stat-label">{{ __('علامة تجارية') }}</div>
        </div>
        <div class="hero__stat">
          <div class="hero__stat-icon">
            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/></svg>
          </div>
          <div class="hero__stat-value">50K+</div>
          <div class="hero__stat-label">{{ __('عميل سعيد') }}</div>
        </div>
      </div>
    </div>
  </section>

  <!-- GALLERY -->
  <section class="gallery">
    <div class="gallery__container">
      <h2 class="section-title">{{ __('صور من') }} <span class="section-title--highlight" style="color: var(--color-red);">{{ __('معرضنا') }}</span></h2>
      <div class="gallery__grid">
        @if(isset($mainGallery) && count($mainGallery) > 0)
          @foreach($mainGallery as $index => $imgPath)
            @php
              $class = '';
              if($index == 0) $class = 'gallery__item--wide';
              elseif($index == 1) $class = 'gallery__item--tall';
            @endphp
            
            @if($index == 4)
              <div class="gallery__item gallery__item--logo">
                <img src="{{ asset('assets/images/logo.png') }}" alt="GR Motors" class="gallery__logo" />
              </div>
            @endif

            <div class="gallery__item {{ $class }}">
              <img loading="lazy" src="{{ asset('storage/' . $imgPath) }}" alt="Gallery Image" class="gallery__img" />
            </div>
          @endforeach
        @else
          @foreach($bentoCars as $index => $car)
            @php
              $class = '';
              if($index == 0) $class = 'gallery__item--wide';
              elseif($index == 1) $class = 'gallery__item--tall';
            @endphp
            
            @if($index == 4)
              <div class="gallery__item gallery__item--logo">
                <img src="{{ asset('assets/images/logo.png') }}" alt="GR Motors" class="gallery__logo" />
              </div>
            @endif

            <div class="gallery__item {{ $class }}">
              <img loading="lazy" src="{{ asset('storage/' . $car->thumbnail) }}" alt="{{ $car->name }}" class="gallery__img" />
              <div class="gallery__overlay">
                <span class="gallery__tag">{{ optional($car->brand)->name }} {{ $car->name }}</span>
                <span class="gallery__price">{{ __('بـ') }} {{ number_format($car->cash_price) }} {!! __('ريال') !!}</span>
              </div>
            </div>
          @endforeach
        @endif

        {{-- Fallback if less than 5 cars --}}
        @if($bentoCars->count() < 4)
           <div class="gallery__item gallery__item--logo">
              <img src="{{ asset('assets/images/logo.png') }}" alt="GR Motors" class="gallery__logo" />
            </div>
        @endif
      </div>
    </div>
  </section>

  <!-- PARTNERS -->
  <section class="partners">
    <div class="partners__container">
      <h2 class="section-title">{{ __('شركاؤنا من') }} <span class="section-title--highlight" style="color: var(--color-red);">{{ __('الشركات والبنوك') }}</span></h2>
      <div class="partners__grid">
        @foreach($partners as $partner)
          <div class="partners__logo-wrap">
            <img loading="lazy" src="{{ asset('storage/' . $partner->logo) }}" alt="{{ $partner->name }}" class="partners__logo" />
          </div>
        @endforeach
      </div>
    </div>
  </section>

  <!-- CONTACT -->
  <section class="contact">
    <div class="contact__container">
      <h2 class="section-title">{{ __('أين يمكن أن') }} <span class="section-title--highlight" style="color: var(--color-red);">{{ __('تجدنا') }}</span></h2>
      <div class="contact__cards">
        @if($contactAddress = $globalSettings['contact_address'] ?? null)
        <div class="contact__card">
          <div class="contact__card-icon contact__card-icon--location">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg>
          </div>
          <h3 class="contact__card-title">{{ __('قم بزيارتنا') }}</h3>
          <p class="contact__card-info">{{ $contactAddress }}</p>
        </div>
        @endif
        @if($contactPhone = $globalSettings['contact_phone'] ?? null)
        <div class="contact__card">
          <div class="contact__card-icon contact__card-icon--phone">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.07 9.81 19.79 19.79 0 01.02 1.18C.02.6.44.02 1.02 0h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L5.09 7.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 14.92z"/></svg>
          </div>
          <h3 class="contact__card-title">{{ __('تواصل معنا') }}</h3>
          <a href="tel:{{ $contactPhone }}" class="contact__card-info" dir="ltr" style="text-decoration:none;color:inherit;display:block;">{{ $contactPhone }}</a>
        </div>
        @endif
        @if($contactEmail = $globalSettings['contact_email'] ?? null)
        <div class="contact__card">
          <div class="contact__card-icon contact__card-icon--email">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
          </div>
          <h3 class="contact__card-title">{{ __('البريد الإلكتروني') }}</h3>
          <a href="mailto:{{ $contactEmail }}" class="contact__card-info" style="text-decoration:none;color:inherit;display:block;">{{ $contactEmail }}</a>
        </div>
        @endif
      </div>
      <div class="contact__map">
        <iframe
          src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3710.0!2d39.19!3d21.49!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMjHCsDI5JzI0LjAiTiAzOcKwMTEnMjQuMCJF!5e0!3m2!1sar!2ssa!4v1700000000000!5m2!1sar!2ssa"
          width="100%"
          height="300"
          style=""
          allowfullscreen=""
          loading="lazy"
          referrerpolicy="no-referrer-when-downgrade"
          title="{{ __('موقع GR Motors') }}"
          class="contact__map-iframe"
        ></iframe>
      </div>
    </div>
  </section>

  <!-- TESTIMONIALS REDESIGNED -->
  <section class="testimonials-premium-section py-100 bg-white overflow-hidden">
    <div class="testimonials__container">
      <div class="text-center mb-60" style="padding-bottom: 2rem;">
        <span class="premium-badge mb-16">{{ __('آراء عملاؤنا') }}</span>
        <h2 class="section-title-premium mb-16">{{ __('ماذا يقول') }} <span>{{ __('عملاؤنا السعداء') }}</span></h2>
        <p class="text-muted fs-18 fw-700 max-w-600 mx-auto">{{ __('اكتشف تجارب عملاؤنا المميزة وآراءهم حول خدماتنا وسياراتنا الفاخرة') }}</p>
      </div>

      <div class="position-relative px-lg-60">
        <div class="swiper testimonialsSwiper">
          <div class="swiper-wrapper">
            @foreach($testimonials as $testimonial)
              <div class="swiper-slide h-auto">
                <div class="testimonial-premium-card-v2 h-100">
                  @if($testimonial->review_image)
                    <div class="testimonial-review-img-wrap">
                      <img loading="lazy" src="{{ asset('storage/' . $testimonial->review_image) }}" alt="Review Screenshot" class="testimonial-review-img">
                    </div>
                  @endif
                  
                  <div class="testimonial-footer-v2">
                    <div class="author-avatar-v2">
                      @if($testimonial->image)
                        <img loading="lazy" src="{{ asset('storage/' . $testimonial->image) }}" alt="{{ $testimonial->name }}">
                      @else
                        <img loading="lazy" src="{{ asset('assets/images/default-avatar.jpg') }}" alt="{{ $testimonial->name }}">
                      @endif
                    </div>

                    <div class="author-info-v2">
                      <div class="author-name-wrap">
                        <h4 class="author-name-v2">{{ $testimonial->name }}</h4>
                        <span class="status-dot"></span>
                      </div>
                      <div class="testimonial-meta-v2">
                        <span>{{ number_format($testimonial->rating ?? 5.0, 1) }}</span>
                        <i class="bi bi-star-fill"></i>
                        <span class="ms-2">{{ $testimonial->title }}</span>
                      </div>
                      <p class="testimonial-car-model-v2">{{ $testimonial->content }}</p>
                    </div>
                  </div>
                </div>
              </div>
            @endforeach
          </div>
        </div>
        
        {{-- Custom Navigation --}}
        <div class="swiper-button-next-testimonials swiper-nav-custom d-none d-lg-flex">
          <i class="bi bi-chevron-{{ App::getLocale() == 'ar' ? 'left' : 'right' }}"></i>
        </div>
        <div class="swiper-button-prev-testimonials swiper-nav-custom d-none d-lg-flex">
          <i class="bi bi-chevron-{{ App::getLocale() == 'ar' ? 'right' : 'left' }}"></i>
        </div>
        
        {{-- Pagination --}}
        <div class="swiper-pagination-testimonials mt-40 d-flex justify-content-center gap-2"></div>
      </div>
    </div>
  </section>
  </div>
</div>
@endsection

@section('js')
  <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
        const testimonialsSwiper = new Swiper('.testimonialsSwiper', {
            slidesPerView: 1,
            spaceBetween: 30,
            loop: true,
            autoplay: {
                delay: 5000,
                disableOnInteraction: false,
            },
            navigation: {
                nextEl: '.swiper-button-next-testimonials',
                prevEl: '.swiper-button-prev-testimonials',
            },
            pagination: {
                el: '.swiper-pagination-testimonials',
                clickable: true,
                bulletClass: 'swiper-pagination-bullet-custom',
                bulletActiveClass: 'swiper-pagination-bullet-custom-active',
            },
            breakpoints: {
                768: {
                    slidesPerView: 2,
                },
                1200: {
                    slidesPerView: 3,
                },
            },
        });
    });
  </script>

@endsection