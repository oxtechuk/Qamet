@extends('store.layouts.app')
@section('title', __('الرئيسية') . ' | ' . (is_array($globalSettings['site_name'] ?? null) ? ($globalSettings['site_name'][App::getLocale()] ?? ($globalSettings['site_name']['ar'] ?? 'GR Motors')) : ($globalSettings['site_name'] ?? 'GR Motors')))
@section('meta_description', __('اكتشف مجموعتنا الحصرية من أفخم السيارات في العالم. نقدم لك تجربة قيادة لا تُنسى مع أرقى الموديلات والخدمات المتميزة.  '))

@section('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
<style>
  .swiper-wrapper {
    display: flex !important;
    align-items: stretch !important;
  }
:root {
            --gradient-primary: linear-gradient(180deg, #ED1C24 0%, #B1161C 32.21%, #8A1217 55.77%, #5A0D10 100%) ;
            --gr-dark-red: rgba(238, 30, 38, 1);
            --gr-dark: linear-gradient(180deg, #ED1C24 0%, #B1161C 32.21%, #8A1217 55.77%, #5A0D10 100%)  ;
            --gr-white: #FFFFFF;
            --gr-light: #F8F9FA;
            --gr-gray: #757575;
            --gr-shadow: 0 15px 40px rgba(0,0,0,0.08);
            --gr-radius: 24px;
            --gr-gradient: linear-gradient(135deg, #EE1E26 0%, #a8151b 100%);
        }


        /* ====================================================
           2. HERO SECTION & CONTROLS
        ==================================================== */
        .hero-slider-section {
            height: 85vh;
            min-height: 500px;
            width: 100%;
            overflow: hidden;
            border-radius: 0;

        }

        .heroMainSwiper {
            width: 100%;
            height: 100%;
        }

        .hero-slide-bg {
            width: 100%;
            height: 100%;
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            position: relative;
        }

        .hero-gradient-overlay {
            position: absolute;
            inset: 0;
        }

        /* Hero Bottom Controls */
        .hero-bottom-controls {
            position: absolute;
            bottom: 5%;
            left: 0;
            right: 0;
            z-index: 10;
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            padding: 0 5%;
            pointer-events: none;
        }

        .hero-bottom-controls > div {
            pointer-events: auto;
        }

        /* Glass Capsule Navigation */
        .hero-nav-capsule {
            direction: ltr;
            display: flex;
            align-items: center;
            background: rgba(0, 0, 0, 0.4) !important;
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            padding: 8px 16px;
            border-radius: 100px;
            border: 1px solid rgba(255,255,255,0.15);
            gap: 16px;
            width: auto !important;
            margin: 0;
        }
.testimonial-premium-card-v2 {
    background: #fff;
    border: 1px solid #f0f0f0;
    border-radius: 40px;
    padding: 24px;
    transition: all 0.4s ease;
    display: flex;
    flex-direction: column;
    gap: 24px;
}
        .hero-nav-btn {
            color: #fff;
            font-size: 18px;
            cursor: pointer;
            transition: 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background:  linear-gradient(180deg, #ED1C24 0%, #B1161C 32.21%, #8A1217 55.77%, #5A0D10 100%) ;
        }

        .hero-nav-btn:hover {
            background: #ffffff !important;
            color: #EE1E26 !important;
            transform: scale(1.1);
        }

        .swiper-pagination-hero {
            position: relative !important;
            bottom: auto !important;
            width: auto !important;
            display: flex;
            gap: 8px;
            align-items: center;
        }

        .swiper-pagination-hero .swiper-pagination-bullet {
            width: 8px;
            height: 8px;
            background: rgba(255,255,255,0.6) !important;
            opacity: 1;
            transition: 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            margin: 0 !important;
        }

        .swiper-pagination-hero .swiper-pagination-bullet-active {
            width: 28px !important;
            border-radius: 100px !important;
            background: #EE1E26 !important;
            box-shadow: 0 0 10px rgba(238, 30, 38, 0.6) !important;
        }

        /* CTA Button container */
        .hero-cta-container {
            margin: 0;
            display: flex;
            justify-content: flex-end;
        }
.premium-badge {
    display: inline-block;
    background: #f3e8ff;
    color: #a855f7;
    padding: 8px 24px;
    border-radius: 40px;
    font-weight: 800;
    font-size: 14px;
    border: 1px solid rgba(168, 85, 247, 0.2);
}
        .hero-cta-btn {
            background: linear-gradient(180deg, #ED1C24 0%, #B1161C 32.21%, #8A1217 55.77%, #5A0D10 100%) ;
            color: #fff !important;
            padding: 16px 40px;
            border-radius: 16px !important;
            font-weight: 800;
            font-size: 16px;
            text-decoration: none;
            box-shadow: 0 10px 30px rgba(238, 30, 38, 0.4);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            display: none;
            align-items: center;
            gap: 12px;
        }

        .hero-cta-btn::after {
            content: '\F128';
            font-family: bootstrap-icons;
            font-size: 18px;
            transition: 0.3s;
        }

        .hero-cta-btn.active {
            display: flex;
            animation: fadeInUp 0.6s ease forwards;
        }

        .hero-cta-btn:hover {
            transform: translateY(-4px) scale(1.02);
            box-shadow: 0 15px 40px rgba(238, 30, 38, 0.5);
        }

        .hero-cta-btn:hover::after {
            transform: translateX(-6px);
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @media (max-width: 991px) {
            .hero-slider-section {
                height: 60vh;
                min-height: 400px;
            }
            .hero-bottom-controls {
                flex-direction: column-reverse;
                align-items: center;
                justify-content: center;
                gap: 20px;
                bottom: 30px;
                padding: 0 20px;
                width: 100%;
            }
            .hero-cta-container {
                justify-content: center;
                width: 100%;
                margin: 0;
                position: relative !important;
                bottom: auto !important;
                left: auto !important;
                transform: none !important;
            }
            .hero-cta-btn {
                padding: 12px 30px;
                font-size: 15px;
                justify-content: center;
                width: auto;
            }
        }

        /* ====================================================
           3. ADVANCED SEARCH FILTER SECTION
        ==================================================== */
        .main-search-section {
            padding: 60px 0 !important;
            background: transparent;
        }

        .search-card-container {

        }

        .search-title {
            font-size: 28px !important;
            font-weight: 800 !important;
            color: #1a1a1a !important;
        }

        .search-form-new {
            display: flex;
            flex-direction: column;
            gap: 20px;
            max-width: 1100px;
            margin: 0 auto;
        }

        .search-top-row {
            display: flex;
            gap: 16px;
            align-items: center;
            width: 100%;
        }

        .search-top-row .search-input-wrap {
            flex-grow: 1;
        }

        .search-top-row .search-btn-wrap,
        .search-top-row .reset-btn-wrap {
            width: 150px;
            flex-shrink: 0;
        }

        .search-input-wrap {
            position: relative;
            width: 100%;
        }

        .search-input-wrap input {
            width: 100%;
            height: 56px;
            background: #F8F9FA;
            border: 1px solid #E5E7EB;
            border-radius: 16px;
            font-size: 15px;
            font-weight: 600;
            color: #1A1A1A;
            outline: none;
            transition: all 0.3s ease;
        }

        html[dir="rtl"] .search-input-wrap input {
            padding: 0 54px 0 24px;
        }
        html[dir="ltr"] .search-input-wrap input {
            padding: 0 24px 0 54px;
        }

        .search-icon-input {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            font-size: 18px;
            color: #9CA3AF;
            pointer-events: none;
        }

        html[dir="rtl"] .search-icon-input {
            right: 22px;
        }
        html[dir="ltr"] .search-icon-input {
            left: 22px;
        }

        .search-input-wrap input:focus {
            border-color: #EE1E26;
            background: #ffffff;
            box-shadow: 0 0 0 4px rgba(238, 30, 38, 0.1);
        }

        .btn-search-main {
            width: 100%;
            height: 56px;
            background  : linear-gradient(180deg, #ED1C24 0%, #B1161C 32.21%, #8A1217 55.77%, #5A0D10 100%);

            color: #ffffff !important;
            border: none;
            border-radius: 16px;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(238, 30, 38, 0.25);
        }

        .btn-search-main:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(238, 30, 38, 0.35);
        }

        .btn-reset-main {
            width: 100%;
            height: 56px;
            background: #ffffff;
            color: #EE1E26 !important;
            border: 1.5px solid #EE1E26;
            border-radius: 16px;
            font-size: 16px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-reset-main:hover {
            background: #FDF2F2;
        }

        /* Filters Grid */
        .search-filters-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
        }

        .filter-label {
            font-size: 14px;
            font-weight: 700;
            color: #4B5563;
            margin-bottom: 8px;
            display: block;
        }

        .search-select-box {
            position: relative;
            background: #ffffff;
            border: 1px solid #E5E7EB;
            border-radius: 16px;
            height: 54px;
            transition: all 0.3s ease;
        }

        .search-select-box:hover {
            border-color: #D1D5DB;
        }

        .search-select-box select {
            width: 100%;
            height: 100%;
            background: transparent;
            border: none;
            outline: none;
            appearance: none;
            -webkit-appearance: none;
            padding: 0 20px;
            font-size: 14px;
            font-weight: 600;
            color: #374151;
            cursor: pointer;
        }

        html[dir="rtl"] .search-select-box select {
            padding: 0 20px 0 40px;
        }
        html[dir="ltr"] .search-select-box select {
            padding: 0 40px 0 20px;
        }

        .select-arrow {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            font-size: 12px;
            color: #9CA3AF;
            pointer-events: none;
        }

        html[dir="rtl"] .select-arrow {
            left: 20px;
        }
        html[dir="ltr"] .select-arrow {
            right: 20px;
        }

        @media (max-width: 991px) {
            .search-card-container {
                padding: 24px;
                border-radius: 24px;
            }
            .search-title {
                font-size: 22px !important;
            }
            .search-filters-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 16px;
            }
            .search-actions-mobile {
                display: flex;
                gap: 12px;
                margin-top: 20px;
            }
            .btn-search-mobile {
                flex: 1;
                height: 52px;
                background: linear-gradient(90deg, #EE1E26 0%, #B1161C 100%);
                color: #ffffff !important;
                border: none;
                border-radius: 16px;
                font-size: 15px;
                font-weight: 700;
                cursor: pointer;
                box-shadow: 0 4px 12px rgba(238, 30, 38, 0.2);
                transition: all 0.3s ease;
            }
            .btn-search-mobile:hover {
                transform: translateY(-1px);
            }
            .btn-booking-mobile {
                padding: 12px 24px;
                height: 52px;
                background: #ffffff;
                color: #EE1E26 !important;
                border: 1.5px solid #EE1E26;
                border-radius: 16px;
                font-size: 15px;
                font-weight: 700;
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 8px;
                text-decoration: none;
                transition: all 0.3s ease;
            }
            .btn-booking-mobile:hover {
                background: #FDF2F2;
            }

            /* Stats Row */
            .search-stats-container {
                display: flex;
                align-items: center;
                justify-content: space-around;
                margin-top: 24px;
                padding-top: 20px;
                border-top: 1px solid #F3F4F6;
            }
            .stat-box {
                text-align: center;
                flex: 1;
            }
            .stat-number {
                display: block;
                font-size: 22px;
                font-weight: 800;
                color: #EE1E26;
            }
            .stat-text {
                display: block;
                font-size: 12px;
                font-weight: 700;
                color: #6B7280;
                margin-top: 2px;
            }
            .stat-divider {
                width: 1px;
                height: 30px;
                background: #E5E7EB;
            }
        }

        /* ====================================================
           4. AUTHORIZED BRANDS SECTION
        ==================================================== */
        .brands-carousel-section .brand-premium-card {
            background: #ffffff !important;
            border: 1.5px solid #F3F4F6 !important;
            border-radius: 28px !important;
            padding: 30px 20px !important;
            display: flex !important;
            flex-direction: column !important;
            align-items: center !important;
            justify-content: center !important;
            text-align: center !important;
            height: 220px !important;
            transition: all 0.3s ease !important;
            position: relative !important;
            text-decoration: none !important;
        }

        .brands-carousel-section .brand-premium-card:hover {
            border-color: #EE1E26 !important;
            transform: translateY(-5px) !important;
            box-shadow: 0 12px 30px rgba(238, 30, 38, 0.08) !important;
        }

        .brands-carousel-section .brand-card-logo {
            height: 80px !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            margin-bottom: 16px !important;
            width: 100% !important;
        }

        .brands-carousel-section .brand-card-logo img {
            max-width: 120px !important;
            max-height: 60px !important;
            object-fit: contain !important;
            transition: transform 0.3s ease !important;
        }

        .brands-carousel-section .brand-premium-card:hover .brand-card-logo img {
            transform: scale(1.08) !important;
        }

        .brands-carousel-section .brand-name {
            font-size: 18px !important;
            font-weight: 800 !important;
            color: #111111 !important;
            margin-bottom: 8px !important;
        }

        .brand-status-badge {
            display: inline-block !important;
            background: #F3F4F6 !important;
            color: #6B7280 !important;
            font-size: 11px !important;
            font-weight: 700 !important;
            padding: 4px 12px !important;
            border-radius: 16px !important;
            transition: all 0.3s ease !important;
        }

        .brands-carousel-section .brand-premium-card:hover .brand-status-badge {
            background: #FDE2E4 !important;
            color: #EE1E26 !important;
        }

        /* Navigation arrows */
        .swiper-nav-custom-brands {
            width: 48px !important;
            height: 48px !important;
            background: #ffffff !important;
            color: #EE1E26 !important;
            border: 1.5px solid #F3F4F6 !important;
            border-radius: 50% !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            position: absolute !important;
            top: 50% !important;
            transform: translateY(-50%) !important;
            z-index: 100 !important;
            cursor: pointer !important;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05) !important;
            transition: all 0.3s ease !important;
        }

        .swiper-nav-custom-brands:hover {
            background: #EE1E26 !important;
            color: #ffffff !important;
            border-color: #EE1E26 !important;
            box-shadow: 0 6px 15px rgba(238, 30, 38, 0.3) !important;
        }

        .swiper-button-prev-brands {
            right: -24px !important;
        }

        .swiper-button-next-brands {
            left: -24px !important;
        }

        .swiper-nav-custom-brands i {
            font-size: 20px !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
        }

        /* Pagination */
        .swiper-pagination-brands {
            margin-top: 30px !important;
            display: flex !important;
            justify-content: center !important;
            gap: 8px !important;
            position: relative !important;
            bottom: auto !important;
        }

        .swiper-pagination-brands .swiper-pagination-bullet {
            width: 8px !important;
            height: 8px !important;
            background: #D1D5DB !important;
            opacity: 1 !important;
            transition: all 0.3s ease !important;
            margin: 0 !important;
        }

        .swiper-pagination-brands .swiper-pagination-bullet-active {
            background: #EE1E26 !important;
            width: 24px !important;
            border-radius: 100px !important;
        }

        /* ====================================================
           5. CAR LIST & CARD GRID
        ==================================================== */
        .grid-4 {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 24px;
        }

        @media (max-width: 1024px) {
            .grid-4 { grid-template-columns: repeat(2, 1fr); }
        }

        @media (max-width: 640px) {
            .grid-4 { grid-template-columns: 1fr; }
        }

        .btn-discover-all {
            background: #EE1E26;
            color: #fff;
            padding: 14px 28px;
            border-radius: 12px;
            font-weight: 800;
            text-decoration: none;
            transition: 0.3s;
            display: inline-flex;
            align-items: center;
        }
        .btn-discover-all:hover {
            background: #b1161c;
            color: #fff;
        }

        /* Filter Tabs */
        .tabs-container-premium {
            display: flex !important;
            justify-content: center !important;
            margin-bottom: 40px !important;
            width: 100% !important;
        }

        .tabs-scroll-wrapper {
            display: flex !important;
            gap: 12px !important;
            padding: 4px !important;
            background: #F3F4F6 !important;
            border-radius: 100px !important;
        }

        .tab-pill {
            background: transparent !important;
            border: none !important;
            padding: 10px 24px !important;
            border-radius: 100px !important;
            font-size: 14px !important;
            font-weight: 700 !important;
            color: #4B5563 !important;
            cursor: pointer !important;
            transition: all 0.3s ease !important;
            display: flex !important;
            align-items: center !important;
            gap: 8px !important;
        }

        .tab-pill i {
            font-size: 16px !important;
            color: #9CA3AF !important;
            transition: all 0.3s ease !important;
        }

        .tab-pill:hover {
            color: #1F2937 !important;
        }

        .tab-pill.active {
            background: #EE1E26 !important;
            color: #ffffff !important;
            box-shadow: 0 4px 12px rgba(238, 30, 38, 0.25) !important;
        }

        .tab-pill.active i {
            color: #ffffff !important;
        }

        @media (max-width: 991px) {
            .tabs-container-premium {
                justify-content: flex-start !important;
                overflow-x: auto !important;
                padding-bottom: 8px !important;
                -webkit-overflow-scrolling: touch !important;
            }
            .tabs-scroll-wrapper {
                background: transparent !important;
                border-radius: 0 !important;
            }
            .tab-pill {
                background: #ffffff !important;
                border: 1px solid #E5E7EB !important;
                flex-shrink: 0 !important;
            }
            .tab-pill.active {
                background: #EE1E26 !important;
                border-color: #EE1E26 !important;
            }
        }

        /* Car Premium Card v2 */
        .car-premium-card-v2 {
            background: #ffffff !important;
            border-radius: 30px !important;
            overflow: hidden !important;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1) !important;
            border: 1px solid #F3F4F6 !important;
            padding: 0 !important;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.03) !important;
            position: relative;
        }

        .car-premium-card-v2:hover {
            transform: translateY(-8px) !important;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08) !important;
            border-color: #EE1E26 !important;
        }

        .card-media {
            position: relative !important;
            height: 200px !important;
            overflow: hidden !important;
            margin: 12px !important;
            border-radius: 20px !important;
        }

        .car-img-v2 {
            width: 100% !important;
            height: 100% !important;
            object-fit: cover !important;
            transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1) !important;
        }

        .car-premium-card-v2:hover .car-img-v2 {
            transform: scale(1.08) !important;
        }

        .card-overlay-top {
            position: absolute;
            inset: 0;
            padding: 15px;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }

        .btn-compare-mini {
            background: rgba(255,255,255,0.9);
            border: none;
            padding: 6px 14px;
            border-radius: 10px;
            font-size: 12px;
            font-weight: 800;
        }

        .year-badge {
            background: #000;
            color: #fff;
            padding: 4px 12px;
            border-radius: 8px;
            font-size: 11px;
            font-weight: 900;
        }

        .card-content-v2 {
            padding: 24px !important;
        }

        .car-name-v2 {
            font-size: 20px !important;
            font-weight: 800 !important;
            color: #111111 !important;
            margin-bottom: 16px !important;
            line-height: 1.4 !important;
        }

        .car-specs-mini-grid {
            display: grid !important;
            grid-template-columns: repeat(2, 1fr) !important;
            gap: 12px !important;
            margin-bottom: 20px !important;
        }

        .spec-mini-item {
            display: flex !important;
            align-items: center !important;
            gap: 8px !important;
            font-size: 13px !important;
            font-weight: 600 !important;
            color: #4B5563 !important;
        }

        .spec-mini-item i {
            font-size: 16px !important;
            color: #EE1E26 !important;
        }

        .car-pricing-v2 {
            margin-bottom: 20px !important;
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .car-pricing-v2 .old-price {
            font-size: 14px;
            color: #9CA3AF;
            text-decoration: line-through;
        }

        .car-pricing-v2 .current-price {
            font-size: 22px !important;
            font-weight: 800 !important;
            color: #EE1E26 !important;
        }

        .car-pricing-v2 .current-price small {
            font-size: 13px !important;
            font-weight: 700 !important;
            color: #6B7280 !important;
        }

        /* Action Buttons */
        .car-premium-card-v2 .btn {
            height: 48px !important;
            border-radius: 16px !important;
            font-size: 14px !important;
            font-weight: 800 !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            transition: all 0.3s ease !important;
        }

        .btn-order-now {
            background: linear-gradient(90deg, #EE1E26 0%, #B1161C 100%) !important;
            color: #ffffff !important;
            border: none !important;
            box-shadow: 0 4px 12px rgba(238, 30, 38, 0.2) !important;
        }

        .btn-order-now:hover {
            box-shadow: 0 6px 16px rgba(238, 30, 38, 0.3) !important;
            transform: translateY(-1px) !important;
        }

        .btn-request-outline {
            background: #ffffff !important;
            color: #EE1E26 !important;
            border: 1.5px solid #EE1E26 !important;
        }

        .btn-request-outline:hover {
            background: #FDF2F2 !important;
        }

        .btn-select-premium {
            background: #EE1E26 !important;
            color: #ffffff !important;
            border: none !important;
        }

        .btn-select-premium:hover {
            background: #D0141C !important;
        }

        .btn-see-more-premium {
            background: #EE1E26;
            color: #fff;
            padding: 16px 48px;
            border-radius: 20px;
            font-weight: 900;
            text-decoration: none;
            transition: 0.3s;
            display: inline-flex;
            align-items: center;
        }
        .btn-see-more-premium:hover {
            background: #000;
            transform: scale(1.05);
        }

        /* ====================================================


        /* Generic Swiper custom bullets */
        .swiper-pagination-bullet-custom {
            width: 8px !important;
            height: 8px !important;
            background: #D1D5DB !important;
            border-radius: 50% !important;
            cursor: pointer !important;
            transition: all 0.3s ease !important;
            opacity: 1 !important;
            margin: 0 !important;
        }

        .swiper-pagination-bullet-custom-active {
            background: #EE1E26 !important;
            width: 24px !important;
            border-radius: 100px !important;
        }

        .testimonials-premium-section .swiper-pagination-testimonials {
            margin-top: 30px !important;
            display: flex !important;
            justify-content: center !important;
            gap: 8px !important;
        }

        /* BENTO & COMMENTS FALLBACKS (to prevent layout breaks if used) */
        .bento-grid-5 { display: grid; grid-template-columns: 1fr 2fr 1fr; grid-template-rows: 250px 250px; gap: 20px; height: 520px; }
        .bento-item { background-size: cover; background-position: center; border-radius: 24px; position: relative; overflow: hidden; display: flex; align-items: flex-end; padding: 30px; border: 1px solid #f0f0f0;}
        .item-1 { grid-row: 1; grid-column: 1; }
        .item-2 { grid-row: 2; grid-column: 1; }
        .item-3 { grid-row: 1 / span 2; grid-column: 2; }
        .item-4 { grid-row: 1; grid-column: 3; }
        .item-5 { grid-row: 2; grid-column: 3; }
        .bento-content { position: relative; z-index: 2; color: #fff; opacity: 0; transform: translateY(20px); transition: 0.4s; }
        .bento-item:hover .bento-content { opacity: 1; transform: translateY(0); }
        .bento-item::before { content: ''; position: absolute; inset: 0; background: linear-gradient(to top, rgba(0,0,0,0.8), transparent); opacity: 0; transition: 0.4s; }
        .bento-item:hover::before { opacity: 1; }
        .bento-item:hover { transform: scale(1.02); z-index: 5; box-shadow: 0 15px 40px rgba(0,0,0,0.08); }
        .bento-badge { position: absolute; top: 20px; right: 20px; padding: 6px 16px; border-radius: 20px; font-weight: 800; font-size: 13px; color: #fff; z-index: 10; display: flex; align-items: center; gap: 6px; }
        .bento-badge.color-blue { background: #1877F2; }
        .bento-badge.color-purple { background: linear-gradient(45deg, #f09433 0%, #e6683c 25%, #dc2743 50%, #cc2366 75%, #bc1888 100%); }
        .bento-badge.color-dark { background: #111; }
        .bento-badge.color-green { background: #25D366; }
        .bento-badge.color-default { background: linear-gradient(180deg, #ED1C24 0%, #B1161C 32.21%, #8A1217 55.77%, #5A0D10 100%); }
        .story-badge-new {
            font-weight: 800;
            background: #3b82f6;
            color: #fff;
            padding: 0.1rem 0.35rem;
            border-radius: 3px;
        }

    .story-item__info { flex: 1; min-width: 0; }
    .story-item__name { font-size: 0.85rem; font-weight: 700; color: #111; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }

    .story-item__meta {
      display: flex;
      align-items: center;
      gap: 0.3rem;
      font-size: 0.7rem;
      color: #888;
      margin-top: 0.1rem;
    }

    .story-item__live-dot {
      width: 6px;
      height: 6px;
      border-radius: 50%;
      background: var(--gradient-primary);
      animation: pulse 1.4s infinite;
    }

    @keyframes pulse {
      0%, 100% { opacity: 1; transform: scale(1); }
      50% { opacity: 0.5; transform: scale(0.8); }
    }

    @media (max-width: 900px) {
      .cars__layout { grid-template-columns: 1fr; }
      .car-hero { min-height: 320px; order: -1; }
      .social__layout { grid-template-columns: 1fr 1fr; }
      .stories-panel { grid-column: span 2; }
    }

    @media (max-width: 580px) {
      .cars__layout, .social__layout { grid-template-columns: 1fr; }
      .stories-panel { grid-column: auto; }
    }

    .grid-4 {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 24px;
    }

    @media (max-width: 1024px) {
        .grid-4 { grid-template-columns: repeat(2, 1fr); }
    }

    @media (max-width: 640px) {
        .grid-4 { grid-template-columns: 1fr; }
    }

    /* Car List Section Styles */
    .btn-discover-all {
        background: var(--primary); color: #fff; padding: 14px 28px;
        border-radius: 12px; font-weight: 800; text-decoration: none;
        transition: 0.3s; display: inline-flex; align-items: center;
    }
    .btn-discover-all:hover { background: var(--primary-dark); color: #fff; transform: translateX(5px); }

    .tabs-container-premium { display: flex; justify-content: flex-end; }
    .tabs-scroll-wrapper { display: flex; gap: 16px; }
    .tab-pill {
        background: #fff; border: 1px solid #f0f0f0; padding: 12px 24px;
        border-radius: 14px; cursor: pointer; font-weight: 800; color: #666;
        transition: 0.3s; display: flex; align-items: center; gap: 10px;
    }
    .tab-pill i { font-size: 18px; }
    .tab-pill:hover { background: #fdfdfd; border-color: #ddd; }
    .tab-pill.active { background: var(--primary); color: #fff; border-color: var(--primary); box-shadow: 0 10px 20px rgba(238, 30, 38, 0.2); }

    .car-premium-card-v2 { background: #fff; border-radius: 30px; overflow: hidden; transition: 0.4s; border: 1px solid #f0f0f0; }
    .car-premium-card-v2:hover { transform: translateY(-12px); box-shadow: 0 20px 40px rgba(0,0,0,0.08); border-color: #EE1E26; }

    .card-media { position: relative; height: 220px; overflow: hidden; margin: 10px; border-radius: 20px; }
    .car-img-v2 { width: 100%; height: 100%; object-fit: cover; transition: 0.6s; }
    .car-premium-card-v2:hover .car-img-v2 { transform: scale(1.1); }

    .card-overlay-top { position: absolute; inset: 0; padding: 15px; display: flex; justify-content: space-between; align-items: flex-start; }
    .btn-compare-mini { background: rgba(255,255,255,0.9); border: none; padding: 6px 14px; border-radius: 10px; font-size: 12px; font-weight: 800; }
    .year-badge { background: #000; color: #fff; padding: 4px 12px; border-radius: 8px; font-size: 11px; font-weight: 900; }

    .car-specs-mini-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
    .spec-mini-item { display: flex; align-items: center; gap: 8px; font-size: 13px; font-weight: 600; color: var(--primary); }
    .spec-mini-item i { font-size: 16px; color: #EE1E26 !important;}

    .car-pricing-v2 { display: flex; flex-direction: column; gap: 4px; }
    .btn-select-premium { background: var(--primary); color: #fff; border: none; transition: 0.3s; }
    .btn-select-premium:hover { opacity: 0.9; }
    .btn-request-outline { border: 1.5px solid rgba(255, 135, 140, 1); color: rgba(238, 30, 38, 1) ;background: transparent; transition: 0.3s; }
    .btn-request-outline:hover {border-top: 1.6px solid rgba(255, 135, 140, 1); background: #ffffffff  }

    .btn-order-now { background: linear-gradient(180deg, #ED1C24 0%, #B1161C 32.21%, #8A1217 55.77%, #5A0D10 100%);
; color: #fff; border: none; transition: 0.3s; }
    .btn-order-now:hover { background: linear-gradient(180deg, #ED1C24 0%, #B1161C 32.21%, #8A1217 55.77%, #5A0D10 100%);; }

    .btn-see-more-premium { background: var(--primary);  color: #fff; padding: 16px 48px; border-radius: 20px; font-weight: 900; text-decoration: none; transition: 0.3s; display: inline-flex; align-items: center; }
    .btn-see-more-premium:hover { background: #000; transform: scale(1.05); }
    .car-premium-card-v2.shadow-sm {
    padding: 0.5rem ;
}
@keyframes popupIn{from{opacity:0;transform:scale(0.85) translateY(30px)}to{opacity:1;transform:scale(1) translateY(0)}}
</style>
@endsection

@section('content')

    {{-- 1. Premium Dynamic Hero Slider (Full Banner) --}}
    <section class="hero-slider-section position-relative">
        @if(isset($heroSlides) && count($heroSlides) > 0)
            <div class="swiper heroMainSwiper w-100 h-100">
                <div class="swiper-wrapper">
                    @foreach($heroSlides as $slide)
                        <div class="swiper-slide">
                            <div class="hero-slide-bg" style="background-image: url('{{ asset('storage/' . $slide['image']) }}');">
                                <div class="hero-gradient-overlay"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Unified Bottom Controls Wrapper --}}
            <div class="hero-bottom-controls">
                {{-- Glass Capsule Navigation & Pagination --}}
                <div class="hero-nav-capsule">
                    <div class="swiper-button-prev-hero hero-nav-btn"><i class="bi bi-arrow-left"></i></div>
                    <div class="swiper-pagination-hero"></div>
                    <div class="swiper-button-next-hero hero-nav-btn"><i class="bi bi-arrow-right"></i></div>
                </div>

                {{-- Dynamic CTA Button --}}
                <div class="hero-cta-container">
                    @foreach($heroSlides as $idx => $slide)
                        <a href="{{ $slide['link'] ?? '#' }}" class="hero-cta-btn {{ $idx === 0 ? 'active' : '' }}" data-index="{{ $idx }}">
                            {{ $slide['button_text'] ?? __('اكتشف السيارات') }}
                        </a>
                    @endforeach
                </div>
            </div>
        @else
            {{-- Fallback default slide --}}
            <div class="hero-slide-bg" style="background-image: url('{{ asset('assets/images/cars/hero-car.png') }}'); background-color: #111;">
                <div class="hero-gradient-overlay"></div>
                <div class="hero-bottom-controls">
                    <div></div> <!-- spacer for flex -->
                    <div class="hero-cta-container">
                        <a href="{{ route('store.cars.index') }}" class="hero-cta-btn active">
                            {{ __('استعرض السيارات') }}
                        </a>
                    </div>
                </div>
            </div>
        @endif
    </section>
<div class="containerpb-5 pt-3" style=" background: rgba(249, 247, 251, 1);
 ">


 <div class="container pt-5">

    {{-- 2. Advanced Search Filter Section (As requested by image) --}}
    <section class="main-search-section">
        <div class="container">
            <div class="search-card-container">
                <div class="search-header text-center mb-4">
                    <h2 class="fw-Cairo fw-900 text-dark search-title">{{ __('ابحث عن سيارتك المثالية') }}</h2>
                </div>

                <form action="{{ route('store.cars.index') }}" method="GET" class="search-form-new">
                    {{-- Desktop layout: Row 1 (Input, Search, Reset) --}}
                    <div class="search-top-row d-none d-lg-flex" dir="{{ App::getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
                        {{-- Search Input --}}
                        <div class="search-input-wrap">
                            <i class="bi bi-search search-icon-input"></i>
                            <input type="text" name="q" placeholder="{{ __('ابحث عن سيارة بالاسم، العلامة التجارية، الموديل، أو المواصفات...') }}">
                        </div>

                        {{-- Search Button --}}
                        <div class="search-btn-wrap">
                            <button type="submit" class="btn-search-main">
                                {{ __('بحث') }}
                            </button>
                        </div>

                        {{-- Reset Button --}}
                        <div class="reset-btn-wrap">
                            <a href="{{ route('store.cars.index') }}" class="btn-reset-main">
                                {{ __('اعادة التعيين') }}
                            </a>
                        </div>
                    </div>

                    {{-- Mobile layout input --}}
                    <div class="search-input-mobile d-lg-none">
                        <div class="search-input-wrap">
                            <i class="bi bi-search search-icon-input"></i>
                            <input type="text" name="q" placeholder="{{ __('ابحث عن سيارة بالاسم، العلامة التجارية...') }}">
                        </div>
                    </div>

                    {{-- Filters Row / Grid (Row 2 on desktop, 2x2 grid on mobile) --}}
                    <div class="search-filters-grid" dir="{{ App::getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
                        {{-- Brand --}}
                        <div class="search-filter-item">
                            <label class="filter-label"><i class="bi bi-tags-fill me-1" style="color: #EE1E26;"></i> {{ __('العلامة التجارية') }}</label>
                            <div class="search-select-box">
                                <select name="brand_id">
                                    <option value="">{{ __('اختر العلامة التجارية') }}</option>
                                    @foreach($filterBrands as $brand)
                                        <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                    @endforeach
                                </select>
                                <i class="bi bi-chevron-down select-arrow"></i>
                            </div>
                        </div>

                        {{-- Category --}}
                        <div class="search-filter-item">
                            <label class="filter-label"><i class="bi bi-car-front-fill me-1" style="color: #a855f7;"></i> {{ __('نوع السيارة') }}</label>
                            <div class="search-select-box">
                                <select name="category_id">
                                    <option value="">{{ __('اختر نوع السيارة') }}</option>
                                    @foreach($filterCategories as $cat)
                                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                    @endforeach
                                </select>
                                <i class="bi bi-chevron-down select-arrow"></i>
                            </div>
                        </div>

                        {{-- Class --}}
                        <div class="search-filter-item">
                            <label class="filter-label"><i class="bi bi-sliders me-1" style="color: #3b82f6;"></i> {{ __('فئة السيارة') }}</label>
                            <div class="search-select-box">
                                <select name="category_id_2">
                                    <option value="">{{ __('اختر الفئة') }}</option>
                                    @foreach($filterCategories as $cat)
                                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                    @endforeach
                                </select>
                                <i class="bi bi-chevron-down select-arrow"></i>
                            </div>
                        </div>

                        {{-- Year / Model --}}
                        <div class="search-filter-item">
                            <label class="filter-label"><i class="bi bi-calendar-event-fill me-1" style="color: #ec4899;"></i> {{ __('موديل السيارة') }}</label>
                            <div class="search-select-box">
                                <select name="year">
                                    <option value="">{{ __('اختر الموديل') }}</option>
                                    @foreach($filterYears as $year)
                                        <option value="{{ $year }}">{{ $year }}</option>
                                    @endforeach
                                </select>
                                <i class="bi bi-chevron-down select-arrow"></i>
                            </div>
                        </div>
                    </div>

                    {{-- Mobile layout actions --}}
                    <div class="search-actions-mobile d-lg-none">
                        <button type="submit" class="btn-search-mobile">
                            {{ __('بحث') }}
                        </button>
                        <a href="{{ route('store.booking.create') }}" class="btn-booking-mobile">
                            <i class="bi bi-calendar3"></i> {{ __('إحجز موعد معنا') }}
                        </a>
                    </div>
                </form>

                {{-- Stats Row (visible on mobile only as requested) --}}
                <div class="search-stats-container d-lg-none">
                    <div class="stat-box">
                        <span class="stat-number">500+</span>
                        <span class="stat-text">{{ __('سيارة متاحة') }}</span>
                    </div>
                    <div class="stat-divider"></div>
                    <div class="stat-box">
                        <span class="stat-number">10+</span>
                        <span class="stat-text">{{ __('علامات تجارية') }}</span>
                    </div>
                    <div class="stat-divider"></div>
                    <div class="stat-box">
                        <span class="stat-number">24/7</span>
                        <span class="stat-text">{{ __('خدمة العملاء') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </section>
 </div>
</div>
    <!-- ========================================================
         SECTION 1: أفخم السيارات في انتظارك
    ======================================================== -->
   <!--  <section class="section cars">
      <div class="section__container">
        <div style="text-align:center; margin-bottom:1.5rem;">
          <span class="section__tag section__tag--dark-red">{{ __('مجموعتنا الحصرية') }}</span>
          <h2 class="section__title section__title--white">{{ __('أفخم السيارات') }} <span class="section__title--gray">{{ __('في انتظارك') }}</span></h2>
          <p class="section__subtitle" style="color: rgba(255,255,255,0.4);">{{ __('اختر من بين مجموعة متنوعة من أرقى السيارات الفاخرة والرياضية') }}</p>
        </div>

        <div class="cars__layout">
          @php
            $offers = collect();
            if ($featuredOffers->isNotEmpty()) {
                $offers = $featuredOffers;
                // If we have less than 3, fill with bentoCars
                if ($offers->count() < 3) {
                    $remaining = 3 - $offers->count();
                    $extra = $bentoCars->whereNotIn('id', $offers->pluck('car_id'))->take($remaining);
                    $offers = $offers->concat($extra);
                }
            } else {
                $offers = $bentoCars;
            }
            $hasOffers = $offers->count() >= 3;
          @endphp

          @if($hasOffers)
          {{-- Left: 2 small cards --}}
          <div class="cars__left">
            @foreach($offers->slice(1, 2) as $item)
            <div class="car-card">
              <img loading="lazy" class="car-card__img" src="{{ asset('storage/' . ($item->image ?? $item->thumbnail)) }}" alt="{{ $item->name }}" onerror="this.style.opacity='0.3'" />
              <div class="car-card__overlay"></div>
              @if($item->badge_text)
                <span class="car-card__badge car-card__badge--offer">{{ $item->badge_text }}</span>
              @endif
              <div class="car-card__content">
                <div class="car-card__info">
                  <div class="car-card__name">{{ $item->getTranslation('name', app()->getLocale()) }}</div>
                  <div class="car-card__specs">
                    @if($item->top_speed)
                    <span class="car-card__spec">
                      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m12 14 4-4"/><path d="M3.34 19a10 10 0 1 1 17.32 0"/></svg>
                      {{ $item->top_speed }}
                    </span>
                    @endif
                    @if($item->power)
                    <span class="car-card__spec">
                      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/></svg>
                      {{ $item->power }}
                    </span>
                    @endif
                  </div>
                  <div class="car-card__footer">
                    <button class="car-card__btn text-center">{{ __('عرض') }}</button>
                    <div class="car-card__price-wrap">
                      <div class="car-card__price-label">{{ __('السعر') }}</div>
                      <div class="car-card__price"><span>﷼</span> {{ is_numeric($item->price) ? number_format($item->price) : $item->price }}</div>
                    </div>
                  </div>
                </div>
              </div>
              <a href="{{ $item->link ?? '#' }}" class="stretched-link"></a>
            </div>
            @endforeach
          </div>

          {{-- Right: Hero card --}}
          @php $hero = $offers->first(); @endphp
          <div class="car-hero">
            <img loading="lazy" class="car-hero__img" src="{{ asset('storage/' . ($hero->image ?? $hero->thumbnail)) }}" alt="{{ $hero->name }}" onerror="this.style.opacity='0.3'" />
            <div class="car-hero__overlay"></div>
            @if($hero->badge_text)
              <span class="car-hero__badge-top">{{ $hero->badge_text }}</span>
            @endif
            <button class="car-hero__fav" aria-label="أضف إلى المفضلة">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"/></svg>
            </button>
            <div class="car-hero__content">
              <div class="car-hero__type">{{ __('عرض خاص') }}</div>
              <div class="car-hero__name">{{ $hero->getTranslation('name', app()->getLocale()) }}</div>
              <div class="car-hero__stats">
                @if($hero->top_speed)
                <div class="car-hero__stat">
                  <div class="car-hero__stat-val">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m12 14 4-4"/><path d="M3.34 19a10 10 0 1 1 17.32 0"/></svg>
                    {{ $hero->top_speed }}
                  </div>
                  <div class="car-hero__stat-label">{{ __('السرعة القصوى') }}</div>
                </div>
                @endif
                @if($hero->power)
                <div class="car-hero__stat">
                  <div class="car-hero__stat-val">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/></svg>
                    {{ $hero->power }}
                  </div>
                  <div class="car-hero__stat-label">{{ __('القوة') }}</div>
                </div>
                @endif
                @if($hero->year)
                <div class="car-hero__stat">
                  <div class="car-hero__stat-val">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>
                    {{ $hero->year }}
                  </div>
                  <div class="car-hero__stat-label">{{ __('الموديل') }}</div>
                </div>
                @endif
              </div>
              <div class="car-hero__bottom">
                <a href="{{ $hero->link ?? '#' }}" class="car-hero__btn text-center">{{ __('التفاصيل') }}</a>
                <div class="car-hero__price-wrap">
                  <div class="car-hero__price-label">{{ __('السعر يبدأ من') }}</div>
                  <div class="car-hero__price"><span>﷼</span> {{ is_numeric($hero->price) ? number_format($hero->price) : $hero->price }}</div>
                </div>
              </div>
            </div>
            <a href="{{ $hero->link ?? '#' }}" class="stretched-link"></a>
          </div>
          @endif
        </div>
      </div>
    </section>

 -->


    {{-- 3. Premium Brands Carousel --}}
    @if($brands->count())
    <section class="brands-carousel-section py-100 bg-white">
        <div class="container">
            {{-- Section Header --}}
            <div class="text-center mb-60">
                <h2 class="fw-900 mb-16" style=" background: linear-gradient(90deg, #FF7E83 0%, #EE1E26 50%, #FF7E83 100%),
linear-gradient(0deg, rgba(0, 0, 0, 0), rgba(0, 0, 0, 0));
 -webkit-background-clip: text; -webkit-text-fill-color: transparent; font-size: 42px;">{{ __('موزع معتمد لجميع أنواع السيارات') }}</h2>
                <p class="text-muted fs-18 fw-700">{{ __('نفخر بكوننا وكلاء معتمدين لأشهر العلامات التجارية العالمية') }}</p>
            </div>

            <div class="position-relative px-lg-60">
                {{-- Swiper Container --}}
                <div class="swiper brandsSwiper">
                    <div class="swiper-wrapper" style="margin-top: 20px;">
                        @foreach($brands as $brand)
                        <div class="swiper-slide h-auto">
                            <a href="{{ route('store.cars.index', ['brand_id' => $brand->id]) }}" class="brand-premium-card">
                                <div class="brand-card-logo">
                                    @if($brand->logo)
                                        <img loading="lazy" src="{{ asset('storage/' . $brand->logo) }}" alt="{{ $brand->name }}">
                                    @else
                                        <div class="brand-initials">{{ substr($brand->name, 0, 1) }}</div>
                                    @endif
                                </div>
                                <div class="brand-card-info">
                                    <h4 class="brand-name fw-800 mb-4">{{ $brand->name }}</h4>
                                    <span class="brand-status-badge">{{ __('موزع معتمد') }}</span>
                                </div>
                            </a>
                        </div>
                        @endforeach
                    </div>
                </div>



                {{-- Pagination --}}
                <div class="swiper-pagination-brands"></div>
            </div>
        </div>
    </section>
    @endif






    {{-- Featured Cars Section --}}
    @if(isset($featuredCars) && $featuredCars->count() > 0)
    <section class="car-list-section py-100 bg-light">
        <div class="container">
            <div class="text-center mb-60">
                <h2 class="fw-900 display-5 mb-12" style="color: #1a1a1a;">{{ __('سيارات مختارة لك') }}</h2>
                <p class="text-muted fs-18 fw-700">{{ __('تصفح مجموعتنا المميزة حسب الماركة') }}</p>
            </div>


            {{-- Car Grid --}}
            <div class="grid-4 gap-10" id="highlightedCarGrid" style="margin-top: 2rem !important; margin-bottom: 2rem !important;">
                @foreach($featuredCars as $car)
                <div class="car-premium-card-v2 shadow-sm featured-item status-{{ $car->is_featured ? 'featured' : 'none' }}">
                    <div class="card-media">
                        <img loading="lazy" src="{{ asset('storage/' . $car->thumbnail) }}" alt="{{ $car->name }}" class="car-img-v2">
                        <div class="card-overlay-top">
                            <span class="year-badge">{{ $car->year ?? '2025' }}</span>
                        </div>
                    </div>
                    <div class="card-content-v2 p-24">
                        <h4 class="car-name-v2 fw-900 mb-20 text-dark">{{ $car->name }}</h4>

                        {{-- Specs Grid 2x2 --}}
                        <div class="car-specs-mini-grid mb-24">
                            <div class="spec-mini-item">
                                <i class="bi bi-people text-primary"></i> <span>{{ $car->specs['seats'] ?? '5' }} {{ __('مقاعد') }}</span>
                            </div>
                            <div class="spec-mini-item">
                                <i class="bi bi-fuel-pump text-primary"></i> <span>{{ $car->specs['fuel'] ?? __('بنزين') }}</span>
                            </div>
                            <div class="spec-mini-item">
                                <i class="bi bi-speedometer2 text-primary"></i> <span>{{ $car->specs['max_speed'] ?? '240' }} {{ __('كم/س') }}</span>
                            </div>
                            <div class="spec-mini-item">
                                <i class="bi bi-gear-wide-connected text-primary"></i> <span>{{ $car->specs['gearbox'] ?? __('أوتوماتيك') }}</span>
                            </div>
                        </div>

                        {{-- Pricing --}}
                        <div class="car-pricing-v2 mb-24">
                            <div class="current-price h4 fw-900 mb-0">
                                {{ number_format($car->cash_price) }} <small class="fs-14">{!! __('ريال') !!}</small>
                            </div>
                        </div>

                        {{-- Actions --}}
                        @if($car->availability_status == 'order_now')
                            <a href="{{ route('store.cars.show', $car->slug) }}" class="btn btn-order-now w-100 py-12 rounded-16 fw-900">{{ __('اطلب الآن') }}</a>
                        @elseif($car->availability_status == 'on_request' || !$car->is_active)
                            <button class="btn btn-request-outline w-100 py-12 rounded-16 fw-900">{{ __('متوفر عند الطلب') }}</button>
                        @else
                            <a href="{{ route('store.cars.show', $car->slug) }}" class="btn btn-select-premium w-100 py-12 rounded-16 fw-900">{{ __('إختر') }}</a>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- 4. Highlighted Car List Section (Tabs) - Redesigned --}}
    @if(isset($highlightedCars) && $highlightedCars->count())

    <style>
    /* ===== Car List Modern Redesign ===== */
    .car-list-section {
        position: relative;
        overflow: hidden;
    }
    .car-list-section::before {
        content: '';
        position: absolute;
        top: -150px; left: -150px;
        width: 500px; height: 500px;
        background: radial-gradient(circle, rgba(238,30,38,0.05) 0%, transparent 70%);
        pointer-events: none;
        border-radius: 50%;
    }
    /* Section Header */
    .cls-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 44px;
        flex-wrap: wrap;
        gap: 20px;
    }
    .cls-title-group {
        display: flex;
        align-items: center;
        gap: 18px;
    }


    .cls-title {
        font-size: 34px;
        font-weight: 900;
        color: linear-gradient(180deg, #ED1C24 0%, #B1161C 32.21%, #8A1217 55.77%, #5A0D10 100%);
        margin: 0 0 5px;
        line-height: 1.2;
    }
    .cls-subtitle {
        font-size: 15px;
        color: #6B7280;
        font-weight: 600;
        margin: 0;
    }
    .cls-view-all {
        background: linear-gradient(180deg, #ED1C24 0%, #B1161C 32.21%, #8A1217 55.77%, #5A0D10 100%);
        color: #fff;
        padding: 13px 26px;
        border-radius: 14px;
        font-size: 14px;
        font-weight: 800;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s ease;
        flex-shrink: 0;
    }
    .cls-view-all:hover {
        background: linear-gradient(180deg, #ED1C24 0%, #B1161C 32.21%, #8A1217 55.77%, #5A0D10 100%);
        color: #fff;
        transform: translateX(-4px);
        box-shadow: 0 6px 20px rgba(238,30,38,0.28);
    }
    /* Tabs */
    .cls-tabs-wrap {
        display: flex;
        justify-content: end    ;
        margin-bottom: 44px;
    }
    .cls-tabs {
        display: inline-flex;
        border-radius: 16px;
        padding: 5px;
        gap: 4px;
        flex-wrap: wrap;
        justify-content: center;
    }
    .cls-tab {
        padding: 10px 22px;
        border-radius: 12px;
        font-size: 14px;
        font-weight: 700;
        color: #6B7280;
        cursor: pointer;
        border: none;
        background: transparent;
        display: flex;
        align-items: center;
        gap: 7px;
        transition: all 0.25s ease;
        white-space: nowrap;
    }
    .cls-tab i { font-size: 15px; opacity: 0.7; }
    .cls-tab:hover { color: #111; background: rgba(255,255,255,0.6); }
    .cls-tab.active {
        background: linear-gradient(180deg, #ED1C24 0%, #B1161C 32.21%, #8A1217 55.77%, #5A0D10 100%);
        color: #fff;
        box-shadow: 0 4px 14px rgba(238,30,38,0.3);
    }
    .cls-tab.active i { opacity: 1; }
    /* ===== Car Card - Premium Dark Design ===== */
    .car-card {
        background:var(--color-white);
        border: 1px solid rgba(255,255,255,0.07);
        border-radius: 24px;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        height: 100%;
        position: relative;
    }

    .car-card::before {
        content: '';
        position: absolute;
        inset: 0;
        border-radius: 24px;
        background: linear-gradient(135deg, rgba(237,28,36,0.06) 0%, transparent 50%);
        pointer-events: none;
        z-index: 0;
        opacity: 0;
        transition: opacity 0.4s ease;
    }

    .car-card:hover::before {
        opacity: 1;
    }

    .car-card:hover {
        box-shadow: 0 24px 60px rgba(0,0,0,0.5), 0 0 0 1px rgba(237,28,36,0.3), inset 0 1px 0 rgba(255,255,255,0.08);
        transform: translateY(-8px) scale(1.01);
        border-color: rgba(237,28,36,0.4);
    }

    /* Image Section */
    .car-card__image-wrap {
        position: relative;
        background: linear-gradient(160deg, #1a1d28 0%, #141720 100%);
        overflow: hidden;
        height: 210px;
    }

    .car-card__image-wrap::after {
        content: '';
        position: absolute;
        bottom: 0; left: 0; right: 0;
        height: 60%;
        background: linear-gradient(to top, rgba(15,17,23,0.95) 0%, rgba(15,17,23,0.4) 60%, transparent 100%);
        pointer-events: none;
        z-index: 2;
    }

    .car-card__img, .car-card__image {
        width: 100%;
        height: 210px;
        object-fit: cover;
        transition: transform 0.7s cubic-bezier(0.2, 0.8, 0.2, 1);
        display: block;
        mix-blend-mode: luminosity;
        opacity: 0.9;
    }

    .car-card:hover .car-card__img,
    .car-card:hover .car-card__image {
        transform: scale(1.1);
        mix-blend-mode: normal;
        opacity: 1;
    }

    /* Compare Badge */
    .car-card__badge {
        position: absolute;
        top: 14px;
        right: 14px;
        background: rgba(15, 17, 23, 0.75);
        color: rgba(255,255,255,0.85);
        font-size: 11px;
        font-weight: 700;
        padding: 6px 12px;
        border-radius: 30px;
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        z-index: 5;
        display: flex;
        align-items: center;
        gap: 5px;
        border: 1px solid rgba(255,255,255,0.12);
        cursor: pointer;
        transition: all 0.25s ease;
    }

    html[dir="rtl"] .car-card__badge {
        right: auto; left: 14px;
    }

    .car-card__badge:hover {
        background: #ED1C24;
        color: #fff;
        border-color: #ED1C24;
        transform: scale(1.05);
        box-shadow: 0 4px 16px rgba(237, 28, 36, 0.4);
    }

    /* Year Badge */
    .car-card__year {
        position: absolute;
        bottom: 14px;
        left: 14px;
        z-index: 5;
      background: rgba(0, 0, 0, 0.7);

        color: #fff;
        font-size: 12px;
        font-weight: 800;
        padding: 4px 10px;
        border-radius: 8px;
        letter-spacing: 0.5px;
    }

    html[dir="rtl"] .car-card__year {
        left: auto; right: 14px;
    }

    /* Offer Badge */
    .car-card__badge--offer,
    .car-card__offer-badge {
        position: absolute;
        top: 14px;
        left: 14px;
        background: linear-gradient(135deg, #ED1C24 0%, #8A1217 100%);
        color: #fff;
        font-size: 11px;
        font-weight: 800;
        padding: 5px 11px;
        border-radius: 8px;
        z-index: 5;
        display: flex;
        align-items: center;
        gap: 4px;
        box-shadow: 0 4px 14px rgba(237, 28, 36, 0.45);
        letter-spacing: 0.3px;
    }

    html[dir="rtl"] .car-card__badge--offer,
    html[dir="rtl"] .car-card__offer-badge {
        left: auto; right: 14px;
    }

    /* Card Body */
    .car-card__body {
        padding: 18px 20px 20px;
        display: flex;
        flex-direction: column;
        gap: 14px;
        flex: 1;
        position: relative;
        z-index: 1;
    }

    /* Title */
    .car-card__title {
        font-size: 17px;
        font-weight: 900;
        color: rgba(16, 24, 40, 1);

        margin: 0;
        line-height: 1.35;
        letter-spacing: -0.2px;
    }

    /* Price Box */
    .car-card__price-box {
        display: flex;
        align-items: baseline;
        gap: 10px;
        flex-wrap: wrap;
    }

    .car-card__price {
        font-size: 21px;
        font-weight: 900;
        color:  rgba(16, 24, 40, 1);
;
        letter-spacing: -0.5px;
        line-height: 1;
    }

    .car-card__price--old {
        font-size: 13px;
        color: rgba(255,255,255,0.35);
        text-decoration: line-through;
        font-weight: 600;
    }

    /* Specs */
    .car-card__specs {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 8px;
        margin: 0;
        padding: 14px;
        list-style: none;
        background: rgba(255,255,255,0.04);
        border-radius: 14px;
        border: 1px solid rgba(255,255,255,0.06);
    }

    .car-card__spec {
     display: flex;
    align-items: end;
        gap: 7px;
        font-size: 12px;
        color: rgba(16, 24, 40, 1);
        font-weight: 700;
        justify-content: flex-end;
    }

    .car-card__spec i {
        font-size: 14px;
        color: #ED1C24;
        width: 14px;
        flex-shrink: 0;
    }

    /* CTA Buttons */
    .car-card__cta {
        display: block;
        width: 100%;
        padding: 12px;
        text-align: center;
        border-radius: 14px;
        font-size: 14px;
        font-weight: 800;
        text-decoration: none;
        cursor: pointer;
        border: none;
        transition: all 0.3s ease;
        letter-spacing: 0.2px;
        font-family: inherit;
    }

    .car-card__cta--order-now,
    .car-card__cta--order {
        background: var(--color-primary);
        color: #fff;
        box-shadow: 0 4px 20px rgba(237,28,36,0.3);
    }

    .car-card__cta--order-now:hover,
    .car-card__cta--order:hover {
        color: #fff;
        box-shadow: 0 8px 28px rgba(237,28,36,0.5);
        transform: translateY(-2px);
        opacity: 0.92;
    }

    .car-card__cta--on-request {
        border: 1.6px solid rgba(255, 135, 140, 1);
        background: rgba(255,255,255,0.06);
        color: #ED1C24;
    }

    .car-card__cta--on-request:hover {
       border: 1.6px solid rgba(255, 135, 140, 1);
        background: rgba(255,255,255,0.06);
        color: #ED1C24;
    }

    /* Divider line above CTA */
    .car-card__body .car-card__cta {
        margin-top: auto;
    }

    .text-center.mt-60 {
        padding-bottom: 40px !important;
    }
    .cls-see-more {
        background:  linear-gradient(180deg, #ED1C24 0%, #B1161C 32.21%, #8A1217 55.77%, #5A0D10 100%); color: #fff;
        padding: 16px 48px; border-radius: 16px;
        font-weight: 900; font-size: 15px;
        text-decoration: none;
        display: inline-flex; align-items: center; gap: 10px;
        transition: all 0.3s;
    }
    .cls-see-more:hover {
        background: #EE1E26; color: #fff;
        transform: scale(1.04);
        box-shadow: 0 8px 24px rgba(238,30,38,0.3);
    }
    @media (max-width: 768px) {
        .cls-header { flex-direction: column; align-items: flex-start; }
        .cls-tabs { gap: 6px; }
        .cls-tab { padding: 9px 16px; font-size: 13px; }
        .cls-title { font-size: 26px; }
    }
    </style>

    <section class="car-list-section py-100">
        <div class="container">

            {{-- Section Header --}}
            <div class="cls-header">
                <div class="cls-title-group">
                    <div>
                        <h2 class="cls-title">{{ __('قائمة السيارات') }}</h2>
                        <p class="cls-subtitle">{{ __('اختر من بين أفضل السيارات المتاحة') }}</p>
                    </div>
                </div>
                <a href="{{ route('store.cars.index') }}" class="cls-view-all">
                    {{ __('اكتشف جميع السيارات') }}
                    <i class="bi bi-arrow-{{ App::getLocale() == 'ar' ? 'right' : 'left' }}"></i>
                </a>
            </div>

            {{-- Tabs --}}
            <div class="cls-tabs-wrap" id="carGridTabs">
                <div class="cls-tabs">
                    <div class="cls-tab active" data-tab="all">
                        <i class="bi bi-grid-3x3-gap"></i> {{ __('سيارات شائعة') }}
                    </div>
                    <div class="cls-tab" data-tab="new_arrival">
                        <i class="bi bi-stars"></i> {{ __('سيارات جديدة') }}
                    </div>
                    <div class="cls-tab" data-tab="featured">
                        <i class="bi bi-box-seam"></i> {{ __('سيارات من المخزن') }}
                    </div>
                    <div class="cls-tab" data-tab="trending">
                        <i class="bi bi-steering-wheel"></i> {{ __('سيارات مع تجربة قيادة') }}
                    </div>
                </div>
            </div>

            {{-- Car Grid --}}
            <div class="grid-4" id="carGrid" style="padding-bottom: 50px;">
                @foreach($highlightedCars as $car)
                <article class="car-card featured-item" data-highlight="{{ $car->is_highlighted ?? 'none' }}">
                    <div class="car-card__image-wrap">
                        <div class="car-card__badge" onclick="addToCompare('{{ $car->slug }}')" data-slug="{{ $car->slug }}">
                            <i class="bi bi-arrow-left-right"></i>
                            {{ __('أضف للمقارنة') }}
                        </div>

                        @if($car->activeOffer ?? false)
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

                        <img loading="lazy" class="car-card__image" src="{{ $car->thumbnail ? asset('storage/' . $car->thumbnail) : asset('assets/images/placeholder-car.jpg') }}" alt="{{ $car->name }}" />
                    </div>

                    <div class="car-card__body">
                        <h3 class="car-card__title">{{ $car->name }}</h3>



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
                  <div class="car-card__price-box">
                            @if($car->activeOffer ?? false)
                                <span class="car-card__price">{{ number_format($car->activeOffer->special_price) }} {!! __('ر.س') !!}</span>
                                <span class="car-card__price--old">{{ number_format($car->cash_price) }} {!! __('ر.س') !!}</span>
                            @else
                                <span class="car-card__price">{{ number_format($car->cash_price) }} {!! __('ر.س') !!}</span>
                            @endif
                        </div>
                        @if($car->availability_status == 'order_now')
                            <a href="{{ route('store.cars.show', $car->slug) }}" class="car-card__cta car-card__cta--order-now">{{ __('اطلب الآن') }}</a>
                        @elseif($car->availability_status == 'on_request' || !$car->is_active)
                            <button type="button" class="car-card__cta car-card__cta--on-request">{{ __('متوفر عند الطلب') }}</button>
                        @else
                            <a href="{{ route('store.cars.show', $car->slug) }}" class="car-card__cta car-card__cta--order">{{ __('إختر') }}</a>
                        @endif
                    </div>
                </article>
                @endforeach
            </div>

            {{-- Footer Button --}}
            <div class="text-center mt-60">
                <a href="{{ route('store.cars.index') }}" class="cls-see-more">
                    {{ __('للمزيد') }} <i class="bi bi-arrow-left"></i>
                </a>
            </div>

        </div>
    </section>
    @endif


<!--
    {{-- Social Media Section Redesigned --}}
    <section class="section social">
      <div class="container">
        <div class="text-center mb-60">
          <span class="premium-badge mb-16">{{ __('تصاميم السوشيال ميديا') }}</span>
          <h2 class="section-title-premium mb-16">
            <span style="background: linear-gradient(90deg, #F6339A 0%, #AD46FF 50%, #2B7FFF 100%),linear-gradient(0deg, rgba(0, 0, 0, 0), rgba(0, 0, 0, 0));background-clip: text;-webkit-background-clip: text;-webkit-text-fill-color: transparent;">{{ __('اعلاناتنا وتصاميمنا') }}  </span>
          </h2>
          <p class="text-muted fs-18 fw-700 max-w-600 mx-auto">{{ __('تابع آخر عروضنا وإعلاناتنا على مختلف منصات التواصل الاجتماعي') }}</p>
        </div>

        <div class="social-premium-layout">
          {{-- Column 1: Facebook --}}
          <div class="social-card-premium">
            @php $fbPost = $socialDesigns->where('platform', 'Facebook')->first() ?? $socialDesigns->first(); @endphp
            <img loading="lazy" class="main-img" src="{{ asset('storage/' . ($fbPost?->image ?? '')) }}" alt="Facebook">
            <div class="overlay"></div>
            <div class="platform-badge fb">
                <i class="bi bi-facebook"></i> Facebook
            </div>
            <div class="social-card-content">
                <h4 class="social-card-title">{{ $fbPost?->getTranslation('name', app()->getLocale()) ?? __('وصول جديد - BMW M8') }}</h4>
                <a href="{{ $fbPost?->link ?? '#' }}" class="social-card-btn fb">{{ __('عرض الإعلان') }}</a>
            </div>
          </div>

          {{-- Column 2: Instagram --}}
          <div class="social-card-premium">
            @php $igPost = $socialDesigns->where('platform', 'Instagram')->first() ?? $socialDesigns->skip(1)->first(); @endphp
            <img loading="lazy" class="main-img" src="{{ asset('storage/' . ($igPost?->image ?? '')) }}" alt="Instagram">
            <div class="overlay"></div>
            <div class="platform-badge ig">
                <i class="bi bi-instagram"></i> Instagram
            </div>
            <div class="social-card-content">
                <h4 class="social-card-title">{{ $igPost?->getTranslation('name', app()->getLocale()) ?? __('عرض الصيف الخاص') }}</h4>
                <a href="{{ $igPost?->link ?? '#' }}" class="social-card-btn ig">{{ __('عرض الإعلان') }}</a>
            </div>
          </div>

          {{-- Column 3: Stories --}}
          <div class="stories-panel-premium">
            <div class="stories-header">
                <div class="stories-title-wrap">
                    <h4>{{ __('القصص الأخيرة') }}</h4>
                    <span>{{ __('آخر التحديثات') }}</span>
                </div>
                <div class="stories-header-icon">
                    <i class="bi bi-graph-up-arrow"></i>
                </div>
            </div>
            <div class="stories-list">
                @foreach($socialDesigns->slice(2)->take(2) as $story)
                <div class="story-premium-item">
                    <img loading="lazy" src="{{ asset('storage/' . $story->image) }}" alt="Story">
                    <div class="story-badge-new">{{ __('جديد') }}</div>
                    <div class="story-premium-overlay">
                        <h5 class="story-item-title">{{ $story->getTranslation('name', app()->getLocale()) }}</h5>
                        <div class="story-item-live">
                            <span class="live-dot"></span> {{ __('مباشر') }}
                        </div>
                    </div>
                    @if($story->link) <a href="{{ $story->link }}" class="stretched-link"></a> @endif
                </div>
                @endforeach
            </div>
          </div>
        </div>
      </div>
    </section>
 -->
  <!-- TESTIMONIALS REDESIGNED -->
  <section class="testimonials-premium-section py-100 bg-white overflow-hidden">
    <div class="container">
      <div class="text-center mb-60">
        <span class="premium-badge mb-16">{{ __('آراء عملاؤنا') }}</span>
        <br>
        <h2 class="section-title-premium mb-16">{{ __('ماذا يقول') }}  <br><span>{{ __('عملاؤنا السعداء') }}</span></h2>
        <p class="text-muted fs-18 fw-700 max-w-600 mx-auto">{{ __('اكتشف تجارب عملاؤنا المميزة وآراءهم حول خدماتنا وسياراتنا الفاخرة') }}</p>
      </div>


      <div class="position-relative px-lg-60">
        <div class="swiper testimonialsSwiper">
          <div class="swiper-wrapper"  style="margin-top: 20px;">
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
@endsection

 @section('js')
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        // Brands Swiper
        const brandsSwiperEl = document.querySelector('.brandsSwiper');
        if (brandsSwiperEl) {
            const brandSlides = brandsSwiperEl.querySelectorAll('.swiper-slide').length;
            const swiper = new Swiper('.brandsSwiper', {
                slidesPerView: 1,
                spaceBetween: 20,
                loop: brandSlides >= 6,
                autoplay: brandSlides > 1 ? { delay: 3000, disableOnInteraction: false } : false,
                navigation: {
                    nextEl: '.swiper-button-next-custom',
                    prevEl: '.swiper-button-prev-custom',
                },
                pagination: {
                    el: '.swiper-pagination-custom',
                    clickable: true,
                    bulletClass: 'swiper-pagination-bullet-custom',
                    bulletActiveClass: 'swiper-pagination-bullet-custom-active',
                    renderBullet: function (index, className) {
                        return '<span class="' + className + '"></span>';
                    },
                },
                breakpoints: {
                    640: { slidesPerView: 2, spaceBetween: 20 },
                    768: { slidesPerView: 3, spaceBetween: 30 },
                    1024: { slidesPerView: 5, spaceBetween: 30 },
                },
            });
        }

        // Testimonials Swiper
        const testimonialsSwiperEl = document.querySelector('.testimonialsSwiper');
        if (testimonialsSwiperEl) {
            const testimonialSlides = testimonialsSwiperEl.querySelectorAll('.swiper-slide').length;
            const testimonialsSwiper = new Swiper('.testimonialsSwiper', {
                slidesPerView: 1,
                spaceBetween: 30,
                centeredSlides: testimonialSlides > 1,
                loop: testimonialSlides >= 4,
                autoplay: testimonialSlides > 1 ? { delay: 5000, disableOnInteraction: false } : false,
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
                    768: { slidesPerView: testimonialSlides >= 2 ? 2 : 1 },
                    1200: { slidesPerView: testimonialSlides >= 3 ? 3 : testimonialSlides },
                },
            });
        }

        // Tab Switching Logic (For Highlighted Cars section — filters by is_highlighted value)
        const carGridTabs = document.querySelectorAll('#carGridTabs .cls-tab');
        if (carGridTabs.length) {
            carGridTabs.forEach(tab => {
                tab.addEventListener('click', () => {
                    carGridTabs.forEach(t => t.classList.remove('active'));
                    tab.classList.add('active');

                    const tabKey = tab.dataset.tab;
                    const grid = document.getElementById('carGrid');

                    if (grid) {
                        grid.style.opacity = '0.4';
                        grid.style.transition = 'opacity 0.25s';

                        setTimeout(() => {
                            grid.querySelectorAll('.featured-item').forEach(item => {
                                const highlight = item.dataset.highlight ?? 'none';
                                const show = (tabKey === 'all') || (highlight === tabKey);
                                item.style.display = show ? '' : 'none';
                            });
                            grid.style.opacity = '1';
                        }, 250);
                    }
                });
            });
        }

        // Hero Slider Initialization
        const heroSwiperEl = document.querySelector('.heroMainSwiper');
        if (heroSwiperEl) {
            const heroSlideCount = heroSwiperEl.querySelectorAll('.swiper-slide').length;
            const heroSwiper = new Swiper('.heroMainSwiper', {
                slidesPerView: 1,
                effect: 'fade',
                fadeEffect: { crossFade: true },
                loop: heroSlideCount > 1,
                autoplay: heroSlideCount > 1 ? { delay: 6000, disableOnInteraction: false } : false,
                navigation: {
                    nextEl: '.swiper-button-next-hero',
                    prevEl: '.swiper-button-prev-hero',
                },
                pagination: {
                    el: '.swiper-pagination-hero',
                    clickable: true,
                },
                on: {
                    slideChange: function () {
                        const activeIndex = this.realIndex;
                        document.querySelectorAll('.hero-cta-btn').forEach(btn => {
                            btn.classList.remove('active');
                            if (parseInt(btn.dataset.index) === activeIndex) {
                                btn.classList.add('active');
                            }
                        });
                    }
                }
            });
        }

    </script>

    {{-- Promo Popup --}}
    @if(!empty($promoPopup['enabled']) && !empty($promoPopup['title']))
    <div id="promoPopupOverlay" style="display:none;position:fixed;inset:0;z-index:99999;background:rgba(0,0,0,0.6);align-items:center;justify-content:center;">
        <div style="background:#fff;border-radius:24px;max-width:460px;width:90%;overflow:hidden;box-shadow:0 30px 60px rgba(0,0,0,0.3);position:relative;animation:popupIn 0.35s ease;">
            <button onclick="closePromoPopup()" style="position:absolute;top:12px;right:16px;border:none;background:none;font-size:28px;cursor:pointer;color:#666;z-index:10;line-height:1;">&times;</button>
            @if(!empty($promoPopup['image']))
            <img loading="lazy" src="{{ asset('storage/' . $promoPopup['image']) }}" alt="{{ $promoPopup['title'] }}" style="width:100%;max-height:240px;object-fit:cover;display:block;">
            @endif
            <div style="padding:32px 28px;text-align:center;">
                <h4 style="font-weight:900;margin:0 0 8px;">{{ $promoPopup['title'] }}</h4>
                @if(!empty($promoPopup['text']))
                <p style="color:#6B7280;margin:0 0 24px;line-height:1.6;">{{ $promoPopup['text'] }}</p>
                @endif
                @if(!empty($promoPopup['link']))
                <a href="{{ $promoPopup['link'] }}" style="display:block;background:linear-gradient(90deg,#EE1E26,#B1161C);color:#fff;font-weight:900;padding:14px 0;border-radius:16px;text-decoration:none;">{{ $promoPopup['button_text'] ?? __('تصفح العروض') }}</a>
                @endif
            </div>
        </div>
    </div>
    <script>
    function closePromoPopup(){document.getElementById('promoPopupOverlay').style.display='none';}
    document.addEventListener('DOMContentLoaded',function(){
        if(!sessionStorage.getItem('promoPopupShown')){
            setTimeout(function(){
                var el=document.getElementById('promoPopupOverlay');
                if(el){el.style.display='flex';sessionStorage.setItem('promoPopupShown','1');}
            },3000);
        }
    });
    </script>
    @endif

@endsection




