@extends('store.layouts.app')
@section('title', __('عروض السيارات') . ' | ' . (is_array($globalSettings['site_name'] ?? null) ? ($globalSettings['site_name'][App::getLocale()] ?? ($globalSettings['site_name']['ar'] ?? 'Qemt Najd')) : ($globalSettings['site_name'] ?? 'Qemt Najd')))

@section('breadcrumb-title', __('أقوى عروض السيارات'))

@section('content')
@include('partials.Store.breadcrumb')

<div class="container py-60">
    <div class="bg-white rounded-4 shadow-sm overflow-hidden" style="border: 1px solid rgba(0,0,0,0.05); padding: 40px 0;">
        
        <div id="offers-grid"></div>

        {{-- Best Offers Grid --}}
        <section>
            <div class="container-fluid">
        <div class="text-center mb-48">
            <h2 style="font-weight: 800; font-size: 32px; margin-bottom: 8px;">
                {{ __('أفضل') }} <span style="color: var(--color-red);">{{ __('العروض') }}</span>
            </h2>
            <p style="color: var(--color-text-muted); font-size: 16px; margin-bottom: 24px;">{{ __('إطلع على أفضل العروض لدينا واستفد الآن') }}</p>
        </div>

        @if($offers->count() > 0)
            <div class="grid-3 mb-48">
                @foreach($offers as $offer)
                <div class="offer-new-card">
                    <div class="offer-img-wrapper">
                        @if($offer->image)
                            <img loading="lazy" src="{{ asset('storage/' . $offer->image) }}" alt="{{ $offer->title }}" class="offer-img">
                        @elseif($offer->cars->count() > 0)
                            <img loading="lazy" src="{{ asset('storage/' . $offer->cars->first()->thumbnail) }}" alt="{{ $offer->title }}" class="offer-img">
                        @else
                            <div class="offer-img bg-placeholder" style="background-image: url('https://images.unsplash.com/photo-1555215695-30049fa5a4fd?q=80&w=600&auto=format&fit=crop');"></div>
                        @endif
                    </div>
                    <div class="offer-body text-center">
                        <h3 class="offer-title">{{ $offer->title }}</h3>
                        <p class="offer-subtitle text-muted">{{ $offer->description ?: __('باقة من السيارات المشمولة') }}</p>
                        
                        <div class="offer-tags d-flex justify-content-center gap-12 flex-wrap mb-24">
                            @if($offer->cars->count() == 1)
                                <span class="offer-tag">{{ $offer->cars->first()->name }}</span>
                            @elseif($offer->cars->count() > 1)
                                <span class="offer-tag">{{ $offer->cars->count() }} {{ __('سيارات مشمولة') }}</span>
                            @else
                                <span class="offer-tag">{{ __('باقة مختارة') }}</span>
                            @endif
                        </div>

                        @php
                            $offerUrl = '#';
                            if ($offer->cars->count() == 1) {
                                $offerUrl = route('store.cars.show', $offer->cars->first()->slug);
                            } elseif ($offer->cars->count() > 1) {
                                $offerUrl = route('store.cars.index', ['offer_id' => $offer->id]);
                            }
                        @endphp
                        <a href="{{ $offerUrl }}" class="btn-read-post">
                            {{ __('عرض المزيد') }}
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
            
            <div class="d-flex justify-content-center">
                {{ $offers->links() }}
            </div>
        @else
            <div class="empty-state text-center" style="padding: 80px 0;">
                <i class="bi bi-tag" style="font-size: 64px; color: var(--color-border); margin-bottom: 24px; display: block;"></i>
                <h2>{{ __('لا توجد عروض حالياً') }}</h2>
            </div>
        @endif
    </div>
</section>

  <!-- GALLERY -->
  <section class="gallery">
    <div class="gallery__container">
      <div class="section-title text-center" >
        <h2>{{ __('صور من') }} <span class="section-title--highlight" style="color: var(--color-red);">{{ __('معرضنا') }}</span></h2>
        <p style="color: var(--color-text-muted); font-size: 16px;">{{ __('إطلع على أفضل العروض لدينا واستفد الآن') }}</p>
      </div>
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
                <img src="{{ asset('assets/images/logo.png') }}" alt="Qemt Najd" class="gallery__logo" />
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
                <img src="{{ asset('assets/images/logo.png') }}" alt="Qemt Najd" class="gallery__logo" />
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
              <img src="{{ asset('assets/images/logo.png') }}" alt="Qemt Najd" class="gallery__logo" />
            </div>
        @endif
      </div>
    </div>
  </section>

{{-- Decision CTA Section --}}
<section style="padding: 0 0 60px; background: var(--color-bg);">
    <div class="container">
        <div class="decision-card-premium">
            <h2 class="decision-title-v2">{{ __('اتخذت قرارك؟') }}</h2>
            <p class="decision-subtitle-v2">{{ __('تواصل معنا الآن لحجز موعد تجربة القيادة') }}</p>
            
            <div class="decision-cta-group-v2">
                <a href="https://wa.me/{{ $globalSettings['contact_whatsapp'] ?? '966500000000' }}" target="_blank" class="btn-decision-v2 btn-red-grad">
                    {{ __('تواصل معنا لنساعدك') }}
                </a>
                <a href="{{ route('store.booking.create') }}" class="btn-decision-v2 btn-white-v2">
                    {{ __('طلب تجربة قيادة') }}
                </a>
            </div>
        </div>
    </div>
</section>

@endsection

@section('css')
<style>

/* --- Decision CTA Buttons --- */
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

@media (max-width: 600px) {
    .decision-cta-btns {
        flex-direction: column;
        gap: 12px;
    }
    .decision-btn {
        width: 100%;
        min-width: unset;
        padding: 14px 20px;
    }
}

    /* Premium Design Style Reset & Variables */
    :root {
        --gr-red: #EE1E26;
        --gr-dark: #000000;
        --gr-bg-gray: #F8F9FA;
        --gr-border: #EBEBEB;
        --gr-text-gray: #757575;
        --gr-shadow: 0 10px 30px rgba(0,0,0,0.06);
    }
    
    /* 1. Hero Styling */
    .d-flex.align-items-center.justify-content-center.gap-16 {
        display: flex;
        justify-content: space-evenly;
}
    .hero-inner { position: relative; z-index: 5; display: flex; align-items: center; justify-content: space-between; }
    .hero-title { font-size: 64px; font-weight: 900; color: #fff; margin-bottom: 24px; text-align: right; }
    .hero-title .highlight { color: var(--gr-red); }
    .hero-subtitle { font-size: 20px; color: rgba(255,255,255,0.7); max-width: 600px; margin-bottom: 0px; text-align: right; }
    .hero-image img { width: 1000px; height: auto; filter: drop-shadow(0 20px 50px rgba(0,0,0,0.8)); transform: scale(1.1); margin-left: -150px; }
    .wave-shape { position: absolute; bottom: -1px; left: 0; width: 100%; height: 80px; z-index: 6; }
    .wave-shape svg { height: 100%; width: 100%; }

    .mt-32 { margin-top: 32px; }
    .px-40 { padding-left: 40px; padding-right: 40px; }
    .py-12 { padding-top: 12px; padding-bottom: 12px; }

    .btn-primary { background: var(--gr-red); border: none; font-weight: 800; transition: 0.3s; }
    .btn-primary:hover { transform: scale(1.05); background: var(--primary-gradiant); }

/* Offer Card */
.offer-new-card {
    background: #fff;
    border: 1px solid var(--color-border);
    border-radius: var(--radius-lg);
    overflow: hidden;
    box-shadow: 0 4px 15px rgba(0,0,0,0.03);
    transition: 0.3s;
}
.offer-new-card:hover { transform: translateY(-5px); box-shadow: 0 12px 30px rgba(0,0,0,0.08); }
.offer-img-wrapper {
    width: 100%;
    height: 240px;
}
.offer-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}
.offer-body {
    padding: 24px;
}
.offer-title {
    font-size: 20px;
    font-weight: 800;
    color: var(--color-text);
    margin-bottom: 6px;
}
.offer-subtitle {
    font-size: 14px;
    margin-bottom: 20px;
}
.offer-tag {
    background: #f4f6fd;
    border: 1px solid #e5e7eb;
    padding: 6px 14px;
    border-radius: 6px;
    font-size: 13px;
    color: var(--color-text-muted);
}
.btn-read-post {
    display: block;
    width: 100%;
    text-align: center;
    background: var(--primary);
    color: #fff;
    padding: 14px;
    border-radius: var(--radius-md);
    font-weight: 800;
    font-size: 15px;
    transition: 0.3s;
    border: none;
}
.btn-read-post:hover {
    background: linear-gradient(180deg, #b00000 0%, #800000 100%);
    color: #fff;
}

    .bento-gallery { display: grid; grid-template-columns: 1fr 2fr 1fr; gap: 16px; height: 500px; }
    .bento-col { display: flex; flex-direction: column; gap: 16px; }
    .bento-img { flex: 1; border-radius: 20px; background-size: cover; background-position: center; position: relative; overflow: hidden; display: block; border: 1px solid #eee; }
    .bento-img-large { flex: 2; }

    .bento-overlay { 
        position: absolute; bottom: 0; left: 0; right: 0; 
        padding: 30px; background: linear-gradient(to top, rgba(0,0,0,0.8) 0%, transparent 100%); 
        color: #fff; text-align: center; opacity: 0; transition: 0.4s; transform: translateY(10px);
    }
    .bento-img:hover .bento-overlay { opacity: 1; transform: translateY(0); }
    .bento-img:hover { transform: scale(1.02); z-index: 5; box-shadow: 0 15px 30px rgba(0,0,0,0.15); }
    .bento-link { color: inherit; text-decoration: none; transition: 0.4s; }
    
    .bento-overlay h6 { font-weight: 800; font-size: 18px; margin-bottom: 4px; color: #fff; }
    .bento-overlay p { font-weight: 700; font-size: 14px; color: rgba(255,255,255,0.8); margin: 0; }
    .price-tag { background: #fff; color: #000; padding: 8px 20px; border-radius: 40px; font-weight: 900; font-size: 18px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }

.decision-card-premium {
    background: #111;
    background: radial-gradient(circle at 0% 50%, rgba(238, 30, 38, 0.15) 0%, transparent 40%),
                radial-gradient(circle at 100% 50%, rgba(238, 30, 38, 0.15) 0%, transparent 40%),
                #111;
    border-radius: 32px;
    padding: 80px 40px;
    text-align: center;
    color: #fff;
    position: relative;
    overflow: hidden;
    margin-bottom: 60px;
}

.decision-title-v2 {
    font-size: 42px;
    font-weight: 900;
    margin-bottom: 12px;
    letter-spacing: -1px;
}

.decision-subtitle-v2 {
    font-size: 18px;
    color: rgba(255, 255, 255, 0.7);
    margin-bottom: 40px;
    font-weight: 500;
}

.decision-cta-group-v2 {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 20px;
}

.btn-decision-v2 {
    padding: 18px 45px;
    border-radius: 18px;
    font-weight: 800;
    font-size: 18px;
    text-decoration: none;
    transition: 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    display: inline-block;
    min-width: 240px;
}

.btn-red-grad {
    background: linear-gradient(180deg, #ED1C24 0%, #8A1217 100%);
    color: #fff;
    box-shadow: 0 10px 20px rgba(237, 28, 36, 0.2);
    border: none;
}

.btn-white-v2 {
    background: #fff;
    color: #111;
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    border: none;
}

.btn-decision-v2:hover {
    transform: translateY(-5px);
    opacity: 0.95;
    color: inherit;
}

.btn-white-v2:hover {
    background: #f8f8f8;
    color: #000;
}

@media (max-width: 768px) {
    .decision-card-premium {
        padding: 50px 20px;
        margin: 0 15px 40px;
    }
    .decision-title-v2 { font-size: 30px; }
    .decision-cta-group-v2 { flex-direction: column; width: 100%; }
    .btn-decision-v2 { width: 100%; min-width: unset; }
}

@media(max-width: 900px) {
    .offers-hero-container {
        flex-direction: column;
        align-items: center;
        gap: 40px;
    }
    .hero-car { margin-bottom: 24px; text-align: center; }
    .hero-car-text { text-align: center; }
    .bento-gallery { grid-template-columns: 1fr; height: auto; }
    .bento-img { min-height: 200px; }
}
</style>
@endsection
