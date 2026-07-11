@extends('store.layouts.app')

@section('title', $car->name . ' | ' . (is_array($globalSettings['site_name'] ?? null) ? ($globalSettings['site_name'][App::getLocale()] ?? ($globalSettings['site_name']['ar'] ?? 'GR Motors')) : ($globalSettings['site_name'] ?? 'GR Motors')))

@section('css'){{-- product page styles are in store.css --}}@endsection
  @section('content')
<div class="container">

  <!-- ========== HERO / PRODUCT ========== -->
   <section class="product">
       <div class="product__header-desktop">
          <div class="product__rating">
            <span class="product__rating-stars">★★★★★</span>
            <span class="product__rating-count">4.9 ({{ $car->views }})</span>
            <span class="product__badge">{{ __('للبيع') }}</span>
          </div>
          <h1 class="product__title">{{ $car->name }} {{ $car->year }}</h1>
        </div>
    <div class="product__container">

      <!-- LEFT: Info -->
      <div class="product__info">
     

        {{-- NEW PRICE BAR (RED BLOCK) --}}
        <div class="product__price-bar-mobile">
          <div class="price-bar-top">
            <span class="price-bar-label">{{ __('السعر الكلي') }}</span>
            <div class="price-bar-value">
               @if($car->activeOffer)
                  <span class="price-bar-main">{{ number_format($car->activeOffer->special_price) }}</span>
                  <span class="price-bar-old">{{ number_format($car->cash_price) }}</span>
               @else
                  <span class="price-bar-main">{{ number_format($car->cash_price) }}</span>
               @endif
               <span class="price-bar-currency">{!! __('ريال') !!}</span>
            </div>
          </div>
          @if($car->min_installment)
          <div class="price-bar-bottom">
            <span>{{ __('أو') }} {{ number_format($car->min_installment) }} {!! __('ريال') !!} {{ __('شهرياً') }}</span>
          </div>
          @endif
        </div>

        <div class="product__price-box-desktop">
          <span class="product__price-label">{{ __('السعر الكلي') }}</span>
          @if($car->activeOffer)
            <div class="product__price">
              {{ number_format($car->activeOffer->special_price) }} <span class="product__currency">{!! __('ريال') !!}</span>
              <span class="product__price-old" style="font-size: 0.6em; text-decoration: line-through; color: #888; margin-right: 10px;">{{ number_format($car->cash_price) }}</span>
            </div>
          @else
            <div class="product__price">{{ number_format($car->cash_price) }} <span class="product__currency">{!! __('ريال') !!}</span></div>
          @endif
          
          @if($car->min_installment)
            <div class="product__installment">{{ __('أو') }} {{ number_format($car->min_installment) }} {!! __('ريال') !!} {{ __('شهرياً') }} <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg></div>
          @endif
        </div>

        @if($car->colors && count($car->colors) > 0)
        <div class="product__colors">
          <span class="product__colors-label">{{ __('الألوان المتاحة') }}</span>
          <div class="product__colors-list">
            @foreach($car->colors as $index => $color)
              @php
                $colorHex   = is_array($color) ? ($color['hex']   ?? '#ccc') : $color;
                $colorName  = is_array($color) ? ($color['name']  ?? '')     : '';
                $colorImage = is_array($color) && !empty($color['image'])
                               ? asset('storage/' . $color['image'])
                               : null;
              @endphp
              <button type="button"
                      class="product__color {{ $index == 0 ? 'product__color--active' : '' }}"
                      style="background-color: {{ $colorHex }}; "
                      title="{{ $colorName }}"
                      data-color-image="{{ $colorImage }}"
                      data-default-image="{{ $car->thumbnail ? asset('storage/' . $car->thumbnail) : asset('assets/images/placeholder-car.jpg') }}"
                      onclick="switchCarColor(this, '{{ $colorHex }}', '{{ $colorName }}')"
                      aria-label="{{ $colorName ?: 'Color ' . $index }}"
              ></button>
            @endforeach
          </div>
          <span id="selected-color-name" style="font-size:12px;color:#888;margin-top:4px;display:block;"></span>
        </div>
        @endif

        <div class="product__actions">
          <a href="{{ route('store.booking.create', ['car_id' => $car->id]) }}" class="btn-p btn-p--primary btn-p--lg" style="text-decoration:none;">{{ __('اطلب الآن') }}</a>
          <button class="btn-p btn-p--outline btn-p--lg" id="addToCompareBtn" onclick="addToCompare('{{ $car->slug }}')">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            {{ __('أضف للمقارنة') }}
          </button>
        </div>

        <div class="product__badges-mobile">
          <div class="badge-item">
            <div class="badge-icon"><i class="bi bi-gear-wide-connected"></i></div>
            <span>{{ $car->specs['gearbox'] ?? '---' }}</span>
          </div>
          <div class="badge-item">
            <div class="badge-icon"><i class="bi bi-calendar-event"></i></div>
            <span>{{ $car->year }}</span>
          </div>
          <div class="badge-item">
            <div class="badge-icon"><i class="bi bi-people"></i></div>
            <span>{{ $car->specs['seats'] ?? '---' }}</span>
          </div>
          <div class="badge-item">
            <div class="badge-icon"><i class="bi bi-speedometer2"></i></div>
            <span>{{ $car->specs['hp'] ?? '---' }}</span>
          </div>
        </div>

        <div class="product__badges-desktop">
          <div class="product__badge-item"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg><span>{{ __('توصيل مجاني') }}</span></div>
          <div class="product__badge-item"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg><span>{{ __('ضمانة مضمونة') }}</span></div>
          <div class="product__badge-item"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg><span>{{ __('فحص شامل') }}</span></div>
        </div>
      </div>

      <!-- RIGHT: Gallery -->
      <div class="product__gallery">
        <div class="product__gallery-main">
          <img src="{{ $car->thumbnail ? asset('storage/' . $car->thumbnail) : asset('assets/images/placeholder-car.jpg') }}" alt="{{ $car->name }}" class="product__gallery-img" id="mainGalleryImg" />
          <span class="product__gallery-counter" id="galleryCounter">1/{{ $car->images->count() + 1 }}</span>
          <button class="product__gallery-nav product__gallery-nav--prev" id="galleryPrev">‹</button>
          <button class="product__gallery-nav product__gallery-nav--next" id="galleryNext">›</button>
        </div>
        <div class="product__gallery-thumbs">
            <img src="{{ $car->thumbnail ? asset('storage/' . $car->thumbnail) : asset('assets/images/placeholder-car.jpg') }}" alt="" loading="lazy" class="product__gallery-thumb product__gallery-thumb--active" onclick="updateMainImg(this.src, 1)" />
            @foreach($car->images as $index => $img)
                <img src="{{ asset('storage/' . $img->image_path) }}" alt="" class="product__gallery-thumb" loading="lazy" onclick="updateMainImg(this.src, {{ $index + 2 }})" />
            @endforeach
        </div>
      </div>

    </div>
  </section>

  <!-- ========== EXTERIOR / INTERIOR PHOTOS ========== -->
  @php
    $exteriorImages = $car->images->where('type', 'exterior');
    $interiorImages = $car->images->where('type', 'interior');
  @endphp

  @if($exteriorImages->count() > 0 || $interiorImages->count() > 0)
  <section class="photos">
    <div class="photos__container">
      @if($exteriorImages->count() > 0)
      <div class="photos__group">
        <h2 class="photos__title">{{ __('صور للسيارة من الخارج') }}</h2>
        <div class="photos__grid">
          <div class="photos__main">
            <img src="{{ asset('storage/' . $exteriorImages->first()->image_path) }}" loading="lazy" alt="{{ __('خارج') }}" id="extMainImg" />
            <button class="photos__nav photos__nav--prev" onclick="prevExt()">‹</button>
            <button class="photos__nav photos__nav--next" onclick="nextExt()">›</button>
          </div>
          <div class="photos__thumbs">
            @foreach($exteriorImages as $index => $img)
              <img src="{{ asset('storage/' . $img->image_path) }}" alt="" loading="lazy" onclick="setExtImg({{ $index }})" />
            @endforeach
          </div>
        </div>
      </div>
      @endif

      @if($interiorImages->count() > 0)
      <div class="photos__group">
        <h2 class="photos__title">{{ __('صور للسيارة من الداخل') }}</h2>
        <div class="photos__grid">
          <div class="photos__main">
            <img src="{{ asset('storage/' . $interiorImages->first()->image_path) }}" loading="lazy" alt="{{ __('داخل') }}" id="intMainImg" />
            <button class="photos__nav photos__nav--prev" onclick="prevInt()">‹</button>
            <button class="photos__nav photos__nav--next" onclick="nextInt()">›</button>
          </div>
          <div class="photos__thumbs">
            @foreach($interiorImages as $index => $img)
              <img src="{{ asset('storage/' . $img->image_path) }}" alt="" loading="lazy" onclick="setIntImg({{ $index }})" />
            @endforeach
          </div>
        </div>
      </div>
      @endif
    </div>
  </section>
  @endif

  <!-- ========== SPECS ========== -->
  <section class="specs">
    <div class="specs__container">
      <div class="specs__visual">
        <img src="{{ $car->thumbnail ? asset('storage/' . $car->thumbnail) : asset('assets/images/placeholder-car.jpg') }}" loading="lazy" alt="{{ __('مواصفات') }}" class="specs__img" />
      </div>
    
      <div class="specs__data">
        <h2 class="specs__title">{{ __('المواصفات التقنية') }}</h2>
        <div class="specs__grid">
          @foreach($car->specifications as $spec)
            <div class="specs__item">
              <div class="specs__icon specs__icon--red">
                <i class="bi {{ $spec->icon ?? 'bi-gear-wide-connected' }}"></i>
              </div>
              <div class="specs__detail">
                <span class="specs__value">{{ $spec->name }}</span>
              </div>
            </div>
          @endforeach
        </div>
      </div>
    </div>
  </section>

  <section class="features">
    <div class="features__container">
      <h2 class="features__title">{{ __('المميزات والخصائص') }}</h2>
      <div class="features__grid">
        @foreach($car->features_list as $feat)
          <div class="features__item">
            <i class="bi {{ $feat->icon ?? 'bi-patch-check' }} fs-5"></i>
            {{ $feat->name }}
          </div>
        @endforeach
      </div>
    </div>
  </section>

  <!-- ========== SIMILAR CARS ========== -->
  @if($related->count() > 0)
  <section class="similar">
    <div class="similar__container">
      <div class="similar__header">
        <div>
          <h2 class="similar__title">{{ __('سيارات مشابهة') }}</h2>
          <p class="similar__subtitle">{{ __('اختر من أفضل السيارات المتشابهة للاختيار') }}</p>
        </div>
        <a href="{{ route('store.cars.index') }}" class="similar__more-desktop btn-p btn-p--outline">{{ __('اكتشف جميع السيارات') }} <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg></a>
      </div>
      <div class="similar__grid-wrapper">
        <div class="similar__grid">
            @foreach($related as $rCar)
            <div class="car-card-p">
              <div class="car-card-p__image-wrap">
                <img src="{{ $rCar->thumbnail ? asset('storage/' . $rCar->thumbnail) : asset('assets/images/placeholder-car.jpg') }}" alt="{{ $rCar->name }}" loading="lazy" class="car-card-p__image" />
                <span class="car-card-p__year">{{ $rCar->year }}</span>
                <span class="car-card-p__tag car-card-p__tag--available">{{ __('متاحة الآن') }}</span>
              </div>
              <div class="car-card-p__body">
                <h3 class="car-card-p__name">{{ $rCar->name }}</h3>
                <div class="car-card-p__meta">
                  <span><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg> {{ $rCar->specs['seats'] ?? '---' }} {{ __('مقاعد') }}</span>
                  <span><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg> {{ $rCar->specs['gearbox'] ?? '---' }}</span>
                </div>
                <div class="car-card-p__price">
                    @if($rCar->activeOffer)
                      <span style="color:#ED1C24;font-weight:900;">{{ number_format($rCar->activeOffer->special_price) }} <span class="gr-currency"></span></span>
                      <span style="text-decoration:line-through;color:#888;font-size:0.8em;margin-right:5px;">{{ number_format($rCar->cash_price) }}</span>
                    @else
                      {{ number_format($rCar->cash_price) }} <span class="gr-currency"></span>
                    @endif
                </div>
                <a href="{{ route('store.cars.show', $rCar->slug) }}" class="btn-p btn-p--primary btn-p--full" style="text-decoration:none;">{{ __('عرض التفاصيل') }}</a>
              </div>
            </div>
            @endforeach
        </div>
      </div>
      <div class="similar__more-mobile">
        <a href="{{ route('store.cars.index') }}" class="btn-p btn-p--primary-outline-light btn-p--full"><i class="bi bi-plus-lg me-2"></i> {{ __('اكتشف جميع السيارات') }}</a>
      </div>
    </div>
  </section>
  @endif
 </div>

 <style>
.product__badges-desktop {
        gap: 15px;
        display: flex;
    }
  @media (max-width: 1024px) {
    

        .product__price-box-desktop { 
        background: var(--primary);
    border-radius: var(--radius-md);
    padding: 18px 20px;
    margin-bottom: 22px;
    color: var(--color-white);
}
         }

  }
    /* MOBILE REFINEMENTS STYLES */
    @media (max-width: 991px) {
        .product__container { display: flex; flex-direction: column; }
        .product__header-mobile { display: block; margin-bottom: 20px; }
        .product__header-mobile .product__title { font-size: 24px; margin-top: 10px; }
        
        .product__gallery { order: 1; margin-bottom: 25px; }
        .product__info { order: 2; }
        
        /* NEW PRICE BAR RED BLOCK */
        .product__price-box-desktop 
        { }
        .product__price-bar-mobile {
            display: block;
            background: linear-gradient(90deg, #ED1C24 0%, #8A1217 100%);
            border-radius: 12px;
            padding: 15px 20px;
            color: #fff;
            margin-bottom: 20px;
            box-shadow: 0 4px 15px rgba(237, 28, 36, 0.2);
        }
        .price-bar-top { display: flex; justify-content: space-between; align-items: center; margin-bottom: 4px; }
        .price-bar-label { font-size: 13px; font-weight: 600; opacity: 0.9; }
        .price-bar-value { display: flex; align-items: baseline; gap: 8px; }
        .price-bar-main { font-size: 26px; font-weight: 800; }
        .price-bar-old { font-size: 14px; text-decoration: line-through; opacity: 0.6; }
        .price-bar-currency { font-size: 14px; font-weight: 700; margin-right: 4px; }
        .price-bar-bottom { font-size: 13px; font-weight: 600; padding-top: 8px; border-top: 1px solid rgba(255,255,255,0.1); }
        
        .product__colors { background: #fff; border: 1px solid #f0f0f0; padding: 15px; border-radius: 12px; margin-bottom: 20px; }
        .product__actions { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-bottom: 25px; }
        .product__actions .btn-p { height: 48px; display: flex; align-items: center; justify-content: center; font-size: 15px; }
        
        .product__badges-desktop { display: none; }
        .product__badges-mobile {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 10px;
            margin-bottom: 30px;
        }


        

        .product__badges-mobile .badge-item {
            background: #f8f9fa;
            border-radius: 12px;
            padding: 10px 5px;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
            border: 1px solid #eee;
        }
        .badge-icon { width: 32px; height: 32px; border-radius: 50%; background: #fff; display: flex; align-items: center; justify-content: center; color: #ED1C24; font-size: 14px; box-shadow: 0 2px 6px rgba(0,0,0,0.05); }
        .product__badges-mobile .badge-item span { font-size: 10px; font-weight: 700; color: #444; }

        /* Photos Sections */
        .photos__grid { display: flex; flex-direction: column; }
        .photos__thumbs { display: flex; overflow-x: auto; gap: 10px; padding: 10px 0; scrollbar-width: none; }
        .photos__thumbs::-webkit-scrollbar { display: none; }
        .photos__thumbs img { width: 80px; height: 60px; flex-shrink: 0; }

        /* Specs Grid */
        .specs__grid { grid-template-columns: repeat(2, 1fr) !important; gap: 10px; }
        .specs__item { background: #fff; border: 1px solid #f0f0f0; padding: 12px !important; border-radius: 12px !important; display: flex; align-items: center; gap: 12px; }
        .specs__icon--red { background: #ED1C24 !important; color: #fff !important; min-width: 36px; height: 36px; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 18px; }
        .specs__value { font-size: 13px !important; font-weight: 700 !important; color: #222; }
        .specs__visual { display: none; }

        /* Features List */
        .features__grid { display: flex; flex-direction: column; gap: 8px; }
        .features__item { 
            background: #fff; 
            border: 1px solid #f5f5f5; 
            padding: 12px 15px !important; 
            border-radius: 10px; 
            font-size: 14px !important; 
            display: flex; 
            flex-direction: row-reverse; 
            justify-content: space-between;
            align-items: center;
        }
        .features__item i { color: #ED1C24; font-size: 16px; }

        /* Similar Cars */
        .similar__grid-wrapper { overflow-x: auto; margin: 0 -20px; padding: 0 20px 20px; scrollbar-width: none; }
        .similar__grid-wrapper::-webkit-scrollbar { display: none; }
        .similar__grid { display: flex; flex-wrap: nowrap; gap: 15px; }
        .similar__grid .car-card-p { min-width: 260px; flex-shrink: 0; }
        .similar__more-desktop { display: none; }
        .similar__more-mobile { display: block; margin-top: 10px; }
        .btn-p--primary-outline-light { background: #fff; color: #ED1C24; border: 1.5px solid #ED1C24; border-radius: 12px; font-weight: 800; }
    }

    @media (min-width: 992px) {
        .product__header-mobile { display: none; }
        .product__price-bar-mobile { display: none; }
        
        /* Desktop Price Box Refinement */
        .product__price-box-desktop {
           background: var(--primary);
    border-radius: var(--radius-md);
    padding: 18px 20px;
    margin-bottom: 22px;
    color: var(--color-white);
        }
        .product__price { font-size: 36px !important; font-weight: 900 !important; color: #ffffffff !important; }
        .product__installment {  ; margin-top: 12px; font-weight: 700; font-size: 14px; }
        
        .product__badges-mobile { display: none; }
        .similar__more-mobile { display: none; }

        /* Desktop Features Grid */
        .features__grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
        }
        .features__item {
            padding: 16px 20px !important;
            background: #fff;
            border: 1px solid #f0f0f0;
            border-radius: 12px;
            font-weight: 700;
            color: #444;
            display: flex;
            align-items: center;
            gap: 12px;
            transition: all 0.3s;
        }
        .features__item:hover { border-color: #ED1C24; background: #fff8f8; }
        .features__item i { color: #ED1C24; font-size: 20px; }
    }
 </style>

@endsection

@section('js')
<script>
    function updateMainImg(src, index) {
        document.getElementById('mainGalleryImg').src = src;
        document.getElementById('galleryCounter').innerText = index + '/' + totalImages;
        const thumbs = document.querySelectorAll('.product__gallery-thumb');
        thumbs.forEach(t => t.classList.remove('product__gallery-thumb--active'));
        if (thumbs[index-1]) thumbs[index-1].classList.add('product__gallery-thumb--active');
        currentIdx = index;
    }

    // Color switcher
    function switchCarColor(btn, hex, name) {
        // Remove active from all
        document.querySelectorAll('.product__color').forEach(b => {
            b.classList.remove('product__color--active');
            b.style.border = '2px solid #ddd';
        });
        btn.classList.add('product__color--active');
        btn.style.border = '2px solid #333';

        // Show color name
        const label = document.getElementById('selected-color-name');
        if (label) label.textContent = name || '';

        // Switch main image if this color has an image
        const colorImg = btn.getAttribute('data-color-image');
        const defaultImg = btn.getAttribute('data-default-image');
        const target = document.getElementById('mainGalleryImg');
        if (colorImg && colorImg !== 'null' && colorImg !== '') {
            target.src = colorImg;
        } else {
            target.src = defaultImg;
        }
    }

    // Basic Gallery Nav
    let currentIdx = 1;
    const totalImages = {{ $car->images->count() + 1 }};
    const allImages = [
        "{{ $car->thumbnail ? asset('storage/' . $car->thumbnail) : asset('assets/images/placeholder-car.jpg') }}",
        @foreach($car->images as $img)
            "{{ asset('storage/' . $img->image_path) }}",
        @endforeach
    ];

    document.getElementById('galleryNext').addEventListener('click', () => {
        currentIdx = currentIdx >= totalImages ? 1 : currentIdx + 1;
        updateMainImg(allImages[currentIdx-1], currentIdx);
    });

    document.getElementById('galleryPrev').addEventListener('click', () => {
        currentIdx = currentIdx <= 1 ? totalImages : currentIdx - 1;
        updateMainImg(allImages[currentIdx-1], currentIdx);
    });

    // Exterior Photos logic
    @if($exteriorImages->count() > 0)
    const extArray = [
        @foreach($exteriorImages as $img)
            "{{ asset('storage/' . $img->image_path) }}",
        @endforeach
    ];
    let extIdx = 0;
    function setExtImg(idx) {
        extIdx = idx;
        document.getElementById('extMainImg').src = extArray[extIdx];
    }
    function nextExt() {
        extIdx = (extIdx + 1) % extArray.length;
        document.getElementById('extMainImg').src = extArray[extIdx];
    }
    function prevExt() {
        extIdx = (extIdx - 1 + extArray.length) % extArray.length;
        document.getElementById('extMainImg').src = extArray[extIdx];
    }
    @endif

    // Interior Photos logic
    @if($interiorImages->count() > 0)
    const intArray = [
        @foreach($interiorImages as $img)
            "{{ asset('storage/' . $img->image_path) }}",
        @endforeach
    ];
    let intIdx = 0;
    function setIntImg(idx) {
        intIdx = idx;
        document.getElementById('intMainImg').src = intArray[intIdx];
    }
    function nextInt() {
        intIdx = (intIdx + 1) % intArray.length;
        document.getElementById('intMainImg').src = intArray[intIdx];
    }
    function prevInt() {
        intIdx = (intIdx - 1 + intArray.length) % intArray.length;
        document.getElementById('intMainImg').src = intArray[intIdx];
    }
    @endif

    // ===== Compare Button =====
    function addToCompare(slug) {
        const stored = localStorage.getItem('compareSlug');
        let url = '{{ route("store.compare") }}';

        if (!stored || stored === slug) {
            // First car OR same car clicked again → go to compare page with just this car in slot 1
            localStorage.setItem('compareSlug', slug);
            url += '?cars[]=' + slug;
        } else {
            // Second car → go to compare with both
            url += '?cars[]=' + stored + '&cars[]=' + slug;
            localStorage.removeItem('compareSlug');
        }
        window.location.href = url;
    }

    // Show badge if another car is already stored
    window.addEventListener('DOMContentLoaded', () => {
        const stored = localStorage.getItem('compareSlug');
        const btn = document.getElementById('addToCompareBtn');
        if (stored && stored !== '{{ $car->slug }}' && btn) {
            btn.style.background = '#C0152A';
            btn.style.color = '#fff';
            btn.style.borderColor = '#C0152A';
            btn.innerHTML = btn.innerHTML.replace('{{ __("أضف للمقارنة") }}', '{{ __("قارن مع هذه السيارة") }}');
        }

        trackEvent('ViewContent', {
            car_model: '{{ $car->name }} {{ $car->year }}',
            car_price: '{{ $car->activeOffer ? $car->activeOffer->special_price : $car->cash_price }}'
        });
    });
</script>
@endsection
