@extends('store.layouts.app')

@section('title', __('معرض السيارات') . ' | ' . (is_array($globalSettings['site_name'] ?? null) ? ($globalSettings['site_name'][App::getLocale()] ?? ($globalSettings['site_name']['ar'] ?? 'Qemt Najd')) : ($globalSettings['site_name'] ?? 'Qemt Najd')))

@section('css')
<style>
/* ============================================================
   CSS VARIABLES & RESET (Overriding or adding to app layout)
   ============================================================ */
:root {
  --primary: linear-gradient(180deg, #ED1C24 0%, #B1161C 32.21%, #8A1217 55.77%, #5A0D10 100%);
;
  --primary-dark:   linear-gradient(180deg, #ED1C24 0%, #B1161C 32.21%, #8A1217 55.77%, #5A0D10 100%);
  --color-black:      #111111;
  --color-dark:       #1a1a1a;
  --color-gray-900:   #222222;
  --color-gray-700:   #444444;
  --color-gray-500:   #777777;
  --color-gray-300:   #cccccc;
  --color-gray-100:   #f4f4f4;
  --color-white:      #ffffff;
  --color-border:     #e8e8e8;
  --color-badge-bg:   rgba(0,0,0,0.55);
  --color-price-old:  #aaaaaa;
  --color-available:  #1a9e55;

  --radius-sm:        6px;
  --radius-md:        10px;
  --radius-lg:        14px;
  --radius-pill:      999px;

  --shadow-card:      0 2px 14px rgba(0,0,0,0.08);
  --shadow-card-hover:0 8px 32px rgba(0,0,0,0.14);

  --transition:       0.22s ease;

  --container-max:    1280px;
  --container-pad:    clamp(16px, 4vw, 48px);
}

/* ============================================================
   REUSABLE BUTTONS
   ============================================================ */
.btn-custom {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  padding: 11px 26px;
  border-radius: var(--radius-pill);
  font-family: var(--font-family);
  font-size: 14px;
  font-weight: 700;
  transition: background var(--transition), color var(--transition), border-color var(--transition), transform var(--transition);
  white-space: nowrap;
}

.btn--red {
  background: var(--primary);
  color: var(--color-white);
  border: 2px solid var(--primary);
}
.btn--red:hover {
  background: var(--primary-dark);
  border-color: var(--primary-dark);
  transform: translateY(-1px);
}

.btn--outline-white {
  background: transparent;
  color: var(--color-white);
  border: 2px solid var(--color-white);
}
.btn--outline-white:hover {
  background: var(--color-white);
  color: var(--color-black);
  transform: translateY(-1px);
}

/* ============================================================
   EXPLORE SECTION
   ============================================================ */
.explore {
  padding: 56px 0 64px;
  background: var(--color-white);
}

.explore__container {
  max-width: var(--container-max);
  margin: 0 auto;
  padding: 0 var(--container-pad);
}

.explore__title {
  font-size: clamp(26px, 3.5vw, 36px);
  font-weight: 900;
  color: var(--color-black);
  text-align: center;
  margin-bottom: 28px;
}

.explore__title--highlight {
  color: var(--primary);
}

/* ============================================================
   SEARCH BAR
   ============================================================ */
.search {
  display: flex;
  align-items: center;
  gap: 0;
  background: var(--color-white);
  border: 1.5px solid var(--color-border);
  border-radius: var(--radius-pill);
  overflow: hidden;
  max-width: 780px;
  margin: 0 auto 20px;
  box-shadow: 0 2px 8px rgba(0,0,0,0.05);
}
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
.search__input {
  flex: 1;
  border: none !important;
  outline: none !important;
  padding: 13px 20px;
  font-family: var(--font-family);
  font-size: 14px;
  color: var(--color-black);
  background: transparent;
  text-align: {{ App::getLocale() == 'ar' ? 'right' : 'left' }};
  box-shadow: none !important;
}

.search__input::placeholder {
  color: var(--color-gray-300);
}

.search__btn {
  display: flex;
  align-items: center;
  gap: 8px;
  background: var(--primary);
  color: var(--color-white);
  padding: 13px 24px;
  font-family: var(--font-family);
  font-size: 14px;
  font-weight: 700;
  transition: background var(--transition);
  flex-shrink: 0;
  border: none;
}

.search__btn:hover {
  background: var(--primary-dark);
}

/* ============================================================
   FILTER TABS
   ============================================================ */
.filter-tabs {
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
  gap: 10px;
  margin-bottom: 16px;
}

.filter-tabs__btn {
  padding: 8px 20px;
  border-radius: var(--radius-pill);
  font-family: var(--font-family);
  font-size: 14px;
  font-weight: 600;
  border: 1.5px solid var(--color-border);
  color: var(--color-gray-700);
  background: var(--color-white);
  transition: all var(--transition);
  text-decoration: none;
}

.filter-tabs__btn:hover {
  border-color: var(--primary);
  color: var(--primary);
}

.filter-tabs__btn--active {
  background: var(--primary);
  color: var(--color-white);
  border-color: var(--primary);
}

.explore__count {
  font-size: 14px;
  color: var(--color-gray-500);
  margin-bottom: 28px;
  text-align: {{ App::getLocale() == 'ar' ? 'right' : 'left' }};
}

.explore__count strong {
  color: var(--color-black);
}

/* ============================================================
   EXPLORE LAYOUT (grid + sidebar)
   ============================================================ */
.explore__layout {
  padding-bottom: 24px;
  display: grid;
  grid-template-columns: 280px 1fr;
  gap: 28px;
  align-items: start;
}

/* ============================================================
   CARS GRID
   ============================================================ */
.cars-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 20px;
}

/* ============================================================
   CAR CARD
   ============================================================ */
.car-card {
  background: var(--color-white);
  border: 1px solid var(--color-border);
  border-radius: 40px;
  overflow: hidden;
  display: flex;
  flex-direction: column;
  transition: all 0.3s ease;
  height: 100%;
  box-shadow: 0 4px 20px rgba(0,0,0,0.03);
}

.car-card:hover {
  box-shadow: 0 12px 30px rgba(0,0,0,0.08);
  transform: translateY(-5px);
}

.car-card__image-wrap {
  position: relative;
  background: var(--color-gray-100);
  overflow: hidden;
  aspect-ratio: 16/12;
}

.car-card__image {
  width: 100%;
  height: 100%;
  object-fit: cover;
  transition: transform 0.6s cubic-bezier(0.2, 0.8, 0.2, 1);
}

.car-card:hover .car-card__image {
  transform: scale(1.08);
}

.car-card__badge {
  position: absolute;
  top: 15px;
  {{ App::getLocale() == 'ar' ? 'right' : 'left' }}: 15px;
  background: rgba(255, 255, 255, 0.6);
  color: #1a1a1a;
  font-size: 13px;
  font-weight: 800;
  padding: 8px 16px;
  border-radius: 20px;
  backdrop-filter: blur(8px);
  z-index: 5;
  display: flex;
  align-items: center;
  gap: 6px;
  border: 1px solid rgba(0,0,0,0.05);
  cursor: pointer;
  transition: all 0.2s ease;
}

.car-card__badge:hover {
  background: #ED1C24;
  color: #fff;
  transform: scale(1.05);
  box-shadow: 0 4px 12px rgba(237, 28, 36, 0.2);
}

.car-card__offer-badge {
  position: absolute;
  top: 15px;
  {{ App::getLocale() == 'ar' ? 'left' : 'right' }}: 15px;
  background: #ED1C24;
  color: #fff;
  font-size: 12px;
  font-weight: 800;
  padding: 6px 12px;
  border-radius: 12px;
  z-index: 3;
  display: flex;
  align-items: center;
  gap: 5px;
  box-shadow: 0 4px 10px rgba(237, 28, 36, 0.3);
}

.car-card__year {
  position: absolute;
  bottom: 15px;
  {{ App::getLocale() == 'ar' ? 'left' : 'right' }}: 15px;
  background: rgba(0, 0, 0, 0.6);
  color: #fff;
  font-size: 14px;
  font-weight: 800;
  padding: 6px 14px;
  border-radius: 12px;
  backdrop-filter: blur(4px);
  z-index: 2;
}

.car-card__body {
  padding: 24px 20px;
  display: flex;
  flex-direction: column;
  gap: 15px;
  flex: 1;
  text-align: {{ App::getLocale() == 'ar' ? 'right' : 'left' }};
}

.car-card__title {
  font-size: 22px;
  font-weight: 900;
  color: #1a202c;
  margin-bottom: 0;
}

.car-card__price-box {
  display: flex;
  align-items: center;
  gap: 12px;
  margin: 5px 0 5px;
}

.car-card__price {
  font-size: 20px;
  font-weight: 900;
  color: #ED1C24;
}

.car-card__price--old {
  font-size: 14px;
  color: #a0aec0;
  text-decoration: line-through;
  font-weight: 700;
}

.car-card__specs {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 12px;
  margin: 0;
  padding: 0;
  list-style: none;
}

.car-card__spec {
        display: flex;
    align-items: center;
    gap: 10px;
    font-size: 14px;
    color: rgba(74, 85, 101, 1);
    font-weight: 400;
    justify-content: flex-end;
    flex-direction: row-reverse !important;
    justify-content: flex-end;
}

.car-card__spec i {
  font-size: 18px;
  color: #EE1E26;
}

.car-card__cta {
  display: block;
  width: 100%;
  padding: 16px;
  border-radius: 20px;
  font-size: 18px;
  font-weight: 900;
  text-align: center;
  transition: all 0.3s ease;
  margin-top: auto;
  text-decoration: none;
}

.car-card__cta--order {
  background: var(--primary);
  color: #fff;
}

.car-card__cta--order-now {
  background: var(--primary);
  color: #fff;
}

.car-card__cta--on-request {
  background: #fff;
  color: #EE1E26;
  border: 2px solid rgba(238, 30, 38, 0.4);
}

.car-card__cta--on-request:hover {
  background: #fff;
  border-color: #EE1E26;
  color: #EE1E26;
}

/* ============================================================
   SIDEBAR
   ============================================================ */
.sidebar {
  display: flex;
  flex-direction: column;
  gap: 20px;
  position: sticky;
  top: 100px;
}

.sidebar__widget {
  background: var(--color-white);
  border: 1px solid rgba(0, 0, 0, 0.05);
  border-radius: 28px;
  padding: 24px;
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.03);
}

.sidebar__widget-title {
  font-size: 18px;
  font-weight: 800;
  color: #1e293b;
  margin-bottom: 20px;
  display: flex;
  align-items: center;
  gap: 10px;
}

.sidebar__widget-title svg {
  color: #ED1C24;
}

/* ============================================================
   BRAND LIST (Card Design)
   ============================================================ */
.brand-list-premium {
  display: flex;
  flex-direction: column;
  gap: 12px;
}

.brand-card-item {
  position: relative;
  cursor: pointer;
  display: block;
}

.brand-card-input {
  position: absolute;
  opacity: 0;
  width: 0;
  height: 0;
}

.brand-card-content {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 12px 16px;
  background: var(--color-white);
  border: 1px solid var(--color-border);
  border-radius: 20px;
  transition: all var(--transition);
  box-shadow: 0 2px 6px rgba(0,0,0,0.02);
}

.brand-card-info {
  display: flex;
  align-items: center;
  gap: 12px;
  flex: 1;
  justify-content: flex-{{ App::getLocale() == 'ar' ? 'end' : 'start' }};
}

.brand-card-name {
  font-size: 15px;
  font-weight: 800;
  color: var(--color-black);
}

.brand-card-logo {
  width: 32px;
  height: 32px;
  display: flex;
  align-items: center;
  justify-content: center;
}

.brand-card-logo img {
  max-width: 100%;
  max-height: 100%;
  object-fit: contain;
}

.brand-card-count {
  background: #f1f3f7;
  color: #666;
  font-size: 13px;
  font-weight: 800;
  padding: 4px 14px;
  border-radius: 20px;
  min-width: 45px;
  text-align: center;
}

/* Checked State */
.brand-card-input:checked + .brand-card-content {
  border-color: var(--primary);
  background: #fffcfc;
  box-shadow: 0 4px 15px rgba(237, 28, 36, 0.08);
}

.brand-card-input:checked + .brand-card-content .brand-card-count {
  background: var(--primary);
  color: #fff;
}

.brand-card-item:hover .brand-card-content {
  border-color: var(--primary);
  transform: translateX(-5px);
}

/* ============================================================
   PRICE RANGE (Premium Design)
   ============================================================ */
.price-filter-premium {
  display: flex;
  flex-direction: column;
  gap: 20px;
}

.price-row {
  display: flex;
  flex-direction: column;
  gap: 8px;
}

.price-row__header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  width: 100%;
}

.price-row__label {
  font-size: 15px;
  font-weight: 700;
  color: #475569 !important;
}

.price-row__value-wrap {
  display: flex;
  align-items: center;
  gap: 6px;
  color: #ED1C24 !important;
  font-weight: 800;
  font-size: 16px;
}

.price-row__icon-edit {
  color: #ED1C24 !important;
  display: flex;
  align-items: center;
}

/* Custom Range Slider Styling */
.price-slider {
  -webkit-appearance: none;
  width: 100%;
  height: 6px;
  background: #e2e8f0;
  border-radius: 999px;
  outline: none;
  margin: 8px 0;
}

.price-slider::-webkit-slider-thumb {
  -webkit-appearance: none;
  appearance: none;
  width: 14px;
  height: 14px;
  background: #ffffff;
  border: 2px solid #ED1C24;
  border-radius: 50%;
  cursor: pointer;
  box-shadow: 0 1px 3px rgba(0,0,0,0.1);
  transition: transform 0.1s ease;
  margin-top: -4px; /* to center it vertically on 6px track */
}

.price-slider::-webkit-slider-thumb:hover {
  transform: scale(1.2);
}

.price-slider::-moz-range-thumb {
  width: 14px;
  height: 14px;
  background: #ffffff;
  border: 2px solid #ED1C24;
  border-radius: 50%;
  cursor: pointer;
  box-shadow: 0 1px 3px rgba(0,0,0,0.1);
  transition: transform 0.1s ease;
}

.price-slider::-moz-range-thumb:hover {
  transform: scale(1.2);
}

/* Active part of the slider */
[dir="rtl"] .price-slider {
  background: linear-gradient(to left, #ED1C24 0%, #ED1C24 var(--percent, 0%), #e2e8f0 var(--percent, 0%), #e2e8f0 100%);
}

[dir="ltr"] .price-slider {
  background: linear-gradient(to right, #ED1C24 0%, #ED1C24 var(--percent, 0%), #e2e8f0 var(--percent, 0%), #e2e8f0 100%);
}

.price-slider::-webkit-slider-runnable-track {
  height: 6px;
  border-radius: 999px;
  background: transparent;
}

.price-slider::-moz-range-progress {
  height: 6px;
  border-radius: 999px;
  background: #ED1C24;
}

/* ============================================================
   RESPONSIVE
   ============================================================ */
@media (max-width: 1024px) {
  .explore__layout {
    grid-template-columns: 220px 1fr;
  }
  .cars-grid {
    grid-template-columns: repeat(2, 1fr);
  }
}

@media (max-width: 768px) {
  .explore__layout {
    grid-template-columns: 1fr;
  }
  .d-md-none {
    display: block !important;
  }
  .d-flex.d-md-none {
    display: flex !important;
  }
  
  /* Mobile Sidebar Drawer */
  .sidebar-overlay {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.6);
    z-index: 1040;
    backdrop-filter: blur(3px);
  }
  .sidebar-overlay.active {
    display: block;
  }
  
  .sidebar {
    position: fixed;
    top: 0;
    right: -320px;
    width: 300px;
    height: 100vh;
    background: #fff;
    z-index: 1050;
    overflow-y: auto;
    padding: 20px;
    transition: right 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: -5px 0 20px rgba(0,0,0,0.15);
    margin: 0;
  }
  .sidebar.open {
    right: 0;
  }
  
  html[dir="ltr"] .sidebar {
    right: auto;
    left: -320px;
    transition: left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: 5px 0 20px rgba(0,0,0,0.15);
  }
  html[dir="ltr"] .sidebar.open {
    left: 0;
  }

  .cars-grid {
    grid-template-columns: repeat(2, 1fr);
    gap: 14px;
  }
}

@media (max-width: 480px) {
  .cars-grid {
    grid-template-columns: 1fr;
  }
}

/* Pagination Styling */
.pagination {
    display: flex;
    justify-content: center;
    gap: 8px;
    margin-top: 40px;
}

.pagination .page-item {
    list-style: none;
}

.pagination .page-link {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    border: 1.5px solid var(--color-border);
    color: var(--color-black);
    text-decoration: none;
    font-weight: 700;
    transition: all var(--transition);
}

.pagination .page-item.active .page-link {
    background: var(--primary);
    color: var(--color-white);
    border-color: var(--primary);
}

.pagination .page-link:hover:not(.active) {
    border-color: var(--primary);
    color: var(--primary);
}

.d-md-none {
  display: none !important;
}
</style>
@endsection

@section('breadcrumb-title', __('استكشف السيارات'))

@section('content')
@include('partials.Store.breadcrumb')

  <!-- ===================== EXPLORE SECTION ===================== -->
  <section class="explore">
    <div class="explore__container">
      <h2 class="explore__title">{!! $hero['title'] !!}</h2>

      <!-- Search Bar -->
      <form action="{{ route('store.cars.index') }}" method="GET" id="filterForm">
        <div class="search">
          <input class="search__input" type="text" name="search" value="{{ request('search') }}" placeholder="{{ __('إبحث عن سيارة بالإسم، العلامة التجارية، الموديل أو المواصفات...') }}" />
          <button type="submit" class="search__btn">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
            {{ __('بحث') }}
          </button>
        </div>

        <!-- Filter Tabs (Types) -->
        <div class="filter-tabs">
          <a href="{{ route('store.cars.index', array_merge(request()->except('type', 'page'))) }}" class="filter-tabs__btn {{ !request('type') ? 'filter-tabs__btn--active' : '' }}">{{ __('الكل') }}</a>
          @foreach($types as $key => $label)
            <a href="{{ route('store.cars.index', array_merge(request()->except('page'), ['type' => $key])) }}"
               class="filter-tabs__btn {{ request('type') == $key ? 'filter-tabs__btn--active' : '' }}">
               {{ $label }}
            </a>
          @endforeach
        </div>

        <p class="explore__count"><strong>{{ $cars->total() }}</strong> {{ __('سيارة متاحة') }}</p>

          {{-- Overlay for mobile sidebar --}}
          <div class="sidebar-overlay" id="sidebarOverlay"></div>

          <div class="explore__layout">
          
          {{-- Mobile Filter Button (visible only on mobile) --}}
          <div class="d-block d-md-none mb-3" style="grid-column: 1 / -1;">
              <button type="button" class="btn btn-outline-danger w-100 py-3 fw-bold" id="mobileFilterBtn" style="border-radius: 12px; border-width: 2px;">
                  <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" class="me-2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" /></svg>
                  {{ __('تصفية النتائج') }}
              </button>
          </div>

          <!-- ========== Sidebar ========== -->
          <aside class="sidebar" id="filterSidebar">
            {{-- Mobile Close Header --}}
            <div class="d-flex d-md-none justify-content-between align-items-center mb-4 pb-3 border-bottom">
                <h4 class="m-0 fw-bold text-dark">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" class="me-2 text-danger"><path stroke-linecap="round" stroke-linejoin="round" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" /></svg>
                    {{ __('الفلاتر') }}
                </h4>
                <button type="button" class="btn-close" id="closeFilterBtn"></button>
            </div>

            <!-- Brands Widget -->
            <div class="sidebar__widget">
              <h4 class="sidebar__widget-title">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color: var(--primary);"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>
                {{ __('الماركات') }}
              </h4>
              <div class="brand-list-premium">
                @foreach($brands as $brand)
                  <label class="brand-card-item">
                    <input type="checkbox" name="brands[]" value="{{ $brand->id }}"
                           class="brand-card-input"
                           {{ is_array(request('brands')) && in_array($brand->id, request('brands')) ? 'checked' : '' }}
                           onchange="document.getElementById('filterForm').submit()">
                    <div class="brand-card-content">
                        <div class="brand-card-count">{{ $brand->cars_count }}</div>
                        <div class="brand-card-info">
                            <span class="brand-card-name">{{ $brand->name }}</span>
                            <div class="brand-card-logo">
                                <img loading="lazy" src="{{ $brand->logo ? asset('storage/' . $brand->logo) : asset('assets/images/placeholder-brand.png') }}"
                                     alt="{{ $brand->name }}">
                            </div>
                        </div>
                    </div>
                  </label>
                @endforeach
              </div>
            </div>

            <!-- Price Range Widget -->
            <div class="sidebar__widget">
              <h4 class="sidebar__widget-title" style="justify-content: flex-start;">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#ED1C24" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                  <line x1="4" y1="6" x2="20" y2="6"></line>
                  <line x1="4" y1="12" x2="20" y2="12"></line>
                  <line x1="4" y1="18" x2="20" y2="18"></line>
                  <circle cx="8" cy="6" r="2.5" fill="#ED1C24"></circle>
                  <circle cx="16" cy="12" r="2.5" fill="#ED1C24"></circle>
                  <circle cx="12" cy="18" r="2.5" fill="#ED1C24"></circle>
                </svg>
                <span style="font-size: 20px; font-weight: 800; color: #111;">{{ __('نطاق السعر') }}</span>
              </h4>
              <div class="price-filter-premium">
                {{-- Min Price --}}
                <div class="price-row">
                    <div class="price-row__header">
                        <div class="price-row__value-wrap">
                            <span id="minPriceDisplay">{{ number_format(request('min_price', 0)) }}</span>
                            <span style="font-size: 14px; font-weight: 800; margin-right: 4px;">{!! __('ر.س') !!}</span>
                            <span class="price-row__icon-edit">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#ED1C24" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                  <path d="M12 20h9"></path>
                                  <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path>
                                </svg>
                            </span>
                        </div>
                        <span class="price-row__label">{{ __('من') }}</span>
                    </div>
                    <input type="range" name="min_price" id="minPriceSlider"
                           min="0" max="500000" step="1000"
                           value="{{ request('min_price', 0) }}"
                           class="price-slider"
                           oninput="updatePriceDisplay('min')"
                           onchange="document.getElementById('filterForm').submit()">
                </div>

                {{-- Max Price --}}
                <div class="price-row">
                    <div class="price-row__header">
                        <div class="price-row__value-wrap">
                            <span id="maxPriceDisplay">{{ number_format(request('max_price', 1000000)) }}</span>
                            <span style="font-size: 14px; font-weight: 800; margin-right: 4px;">{!! __('ر.س') !!}</span>
                            <span class="price-row__icon-edit">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#ED1C24" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                  <path d="M12 20h9"></path>
                                  <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path>
                                </svg>
                            </span>
                        </div>
                        <span class="price-row__label">{{ __('إلى') }}</span>
                    </div>
                    <input type="range" name="max_price" id="maxPriceSlider"
                           min="0" max="1000000" step="5000"
                           value="{{ request('max_price', 1000000) }}"
                           class="price-slider"
                           oninput="updatePriceDisplay('max')"
                           onchange="document.getElementById('filterForm').submit()">
                </div>
              </div>
            </div>
          </aside>
  <!-- ========== Car Grid ========== -->
          <div class="cars-grid">
            @forelse($cars as $car)
              <article class="car-card">
                <div class="car-card__image-wrap">
                  <div class="car-card__badge" onclick="addToCompare('{{ $car->slug }}')" data-slug="{{ $car->slug }}">
                    <i class="bi bi-arrow-left-right"></i>
                    {{ __('أضف للمقارنة') }}
                  </div>
                  
                  @if($car->activeOffer)
                    <div class="car-card__offer-badge">
                      <i class="bi bi-tag-fill"></i>
                      @if($car->activeOffer->discount_percent)
                        {{ $car->activeOffer->discount_percent }}% {{ __('خصم') }}
                      @else
                        {{ __('عرض خاص') }}
                      @endif
                    </div>
                  @endif

                  @if($car->year)
                    <span class="car-card__year">{{ $car->year }}</span>
                  @endif
                  <img loading="lazy" class="car-card__image" src="{{ $car->thumbnail ?: asset('assets/images/placeholder-car.jpg') }}" alt="{{ $car->name }}" />
                </div>
                <div class="car-card__body">
                  <h3 class="car-card__title">{{ $car->name }}</h3>

                  <div class="car-card__price-box">
                    @if($car->activeOffer)
                      <span class="car-card__price">{{ number_format($car->activeOffer->special_price) }} {!! __('ر.س') !!}</span>
                      <span class="car-card__price--old">{{ number_format($car->cash_price) }} {!! __('ر.س') !!}</span>
                    @else
                      <span class="car-card__price">{{ number_format($car->cash_price) }} {!! __('ر.س') !!}</span>
                    @endif
                  </div>

                  <ul class="car-card__specs">
                    @if(isset($car->specs['seats']))
                    <li class="car-card__spec">
                      <span>{{ $car->specs['seats'] }} {{ __('مقاعد') }}</span>
                      <i class="bi bi-people"></i>
                    </li>
                    @endif
                    
                    @if(isset($car->specs['fuel']))
                    <li class="car-card__spec">
                      <span>{{ $car->specs['fuel'] }}</span>
                      <i class="bi bi-fuel-pump"></i>
                    </li>
                    @endif

                    @if(isset($car->specs['hp']))
                    <li class="car-card__spec">
                      <span>{{ $car->specs['hp'] }} {{ __('حصان') }}</span>
                      <i class="bi bi-speedometer2"></i>
                    </li>
                    @elseif(isset($car->specs['max_speed']))
                    <li class="car-card__spec">
                      <span>{{ $car->specs['max_speed'] }} {{ __('كم/س') }}</span>
                      <i class="bi bi-speedometer2"></i>
                    </li>
                    @endif

                    @if(isset($car->specs['gearbox']))
                    <li class="car-card__spec">
                      <span>{{ $car->specs['gearbox'] }}</span>
                      <i class="bi bi-gear-wide-connected"></i>
                    </li>
                    @endif
                  </ul>

                  @if($car->availability_status == 'order_now')
                     <a href="{{ route('store.cars.show', $car->slug) }}" class="car-card__cta car-card__cta--order-now">{{ __('اطلب الآن') }}</a>
                  @elseif($car->availability_status == 'on_request' || !$car->is_active)
                     <button type="button" class="car-card__cta car-card__cta--on-request">{{ __('متوفر عند الطلب') }}</button>
                  @else
                    <a href="{{ route('store.cars.show', $car->slug) }}" class="car-card__cta car-card__cta--order">{{ __('إختر') }}</a>
                  @endif
                </div>
              </article>
            @empty
              <div style="grid-column: 1 / -1; text-align: center; padding: 40px;">
                <p>{{ __('لا توجد سيارات تطابق بحثك حالياً.') }}</p>
                <a href="{{ route('store.cars.index') }}" class="btn btn--red" style="margin-top: 15px; text-decoration: none;">{{ __('إعادة تعيين الفلاتر') }}</a>
              </div>
            @endforelse
          </div>
        

          
        </div>

        <!-- Pagination -->
        <div class="pagination-wrap">
            {{ $cars->links() }}
        </div>

          
  
      </form>
    </div>
  </section>

    {{-- CTA --}}
  {{-- Decision CTA Section --}}
<section style="padding: 0 0 60px; background: var(--color-bg);">
    <div class="container">
        <div class="decision-card-premium">
            <h2 class="decision-title-v2">{{ __('هل وجدت السيارة المناسبة؟') }}</h2>
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

@section('js')
<script>
    function updatePriceDisplay(type) {
        const slider = document.getElementById(type + 'PriceSlider');
        const display = document.getElementById(type + 'PriceDisplay');
        const val = parseInt(slider.value);
        display.innerText = val.toLocaleString();

        // Optional: Update slider background progress
        const min = slider.min;
        const max = slider.max;
        const percent = ((val - min) / (max - min)) * 100;
        slider.style.setProperty('--percent', percent + '%');
    }

    // ===== Compare Logic =====
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

    // Initialize display on load
    window.addEventListener('DOMContentLoaded', () => {
        updatePriceDisplay('min');
        updatePriceDisplay('max');

        // Highlight already stored car for comparison
        const stored = localStorage.getItem('compareSlug');
        if (stored) {
            const badges = document.querySelectorAll('.car-card__badge');
            badges.forEach(b => {
                if (b.getAttribute('data-slug') === stored) {
                   b.style.background = '#ED1C24';
                   b.style.color = '#fff';
                   b.innerHTML = '<i class="bi bi-check-lg"></i> {{ __("مضاف للمقارنة") }}';
                }
            });
        }
    });

    // Mobile Sidebar Logic
    const mobileFilterBtn = document.getElementById('mobileFilterBtn');
    const filterSidebar = document.getElementById('filterSidebar');
    const closeFilterBtn = document.getElementById('closeFilterBtn');
    const sidebarOverlay = document.getElementById('sidebarOverlay');

    function openSidebar() {
        filterSidebar.classList.add('open');
        sidebarOverlay.classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    function closeSidebar() {
        filterSidebar.classList.remove('open');
        sidebarOverlay.classList.remove('active');
        document.body.style.overflow = '';
    }

    if (mobileFilterBtn) mobileFilterBtn.addEventListener('click', openSidebar);
    if (closeFilterBtn) closeFilterBtn.addEventListener('click', closeSidebar);
    if (sidebarOverlay) sidebarOverlay.addEventListener('click', closeSidebar);
</script>
@endsection
