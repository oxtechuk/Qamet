@extends('partials.Layouts.crm-master')
@section('title', __('إدارة السيارات') . ' | AutoCRM')

@section('content')
    <div class="container-fluid" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">

        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h4 class="mb-1 fw-bold"> {{ __('إدارة أسطول السيارات') }}</h4>
                <p class="text-muted mb-0 small">{{ __('إجمالي') }} {{ $cars->total() }} {{ __('سيارة مسجلة') }}</p>
            </div>
            @can('manage-cars')
            <a href="{{ route('crm.cars.create') }}" class="btn btn-primary rounded-pill px-4 shadow-sm fw-bold">
                <i class="bi bi-plus-lg me-1"></i> {{ __('إضافة سيارة جديدة') }}
            </a>
            @endcan
        </div>


        {{-- Filters --}}
        <div class="card border-0 shadow-sm mb-4 rounded-4">
            <div class="card-body p-4">
                <form method="GET" class="row g-3 align-items-end">
                    <div class="col-md-4">
                        <label class="form-label fw-bold small text-muted">{{ __('البحث عن سيارة') }}</label>
                        <input type="text" name="search" class="form-control bg-light border-0 shadow-none" placeholder="{{ __('الاسم، الموديل...') }}"
                            value="{{ request('search') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-bold small text-muted">{{ __('الماركة') }}</label>
                        <select name="brand_id" class="form-select bg-light border-0 shadow-none">
                            <option value="">{{ __('كل الماركات') }}</option>
                            @foreach($brands as $brand)
                                <option value="{{ $brand->id }}" @selected(request('brand_id') == $brand->id)>{{ $brand->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-bold small text-muted">{{ __('التصنيف') }}</label>
                        <select name="category_id" class="form-select bg-light border-0 shadow-none">
                            <option value="">{{ __('كل التصنيفات') }}</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" @selected(request('category_id') == $cat->id)>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2 d-flex gap-2">
                        <button type="submit" class="btn btn-primary w-100 fw-bold rounded-3">{{ __('تصفية') }}</button>
                        <a href="{{ route('crm.cars.index') }}" class="btn btn-light rounded-3 px-3"><i class="bi bi-arrow-counterclockwise"></i></a>
                    </div>
                </form>
            </div>
        </div>

        {{-- Grid --}}
        <div class="row g-4">
            @forelse($cars as $car)
                <div class="col-12 col-md-6 col-lg-4 col-xl-3">
                    <div class="card border-0 shadow-sm h-100 car-card-premium overflow-hidden">
                        {{-- Top Badges --}}
                        <div class="car-badges">
                            @if($car->is_featured)
                                <span class="badge-premium featured"><i class="bi bi-star-fill"></i> {{ __('مميز') }}</span>
                            @endif
                            @if(!$car->is_active)
                                <span class="badge-premium hidden"><i class="bi bi-eye-slash"></i> {{ __('مخفي') }}</span>
                            @endif
                        </div>

                        {{-- Image Holder --}}
                        <div class="car-img-wrapper">
                            @if($car->thumbnail)
                                <img src="{{ asset('storage/' . $car->thumbnail) }}" alt="{{ $car->name }}" class="car-img-main">
                            @else
                                <div class="car-no-img">
                                    <i class="bi bi-car-front"></i>
                                </div>
                            @endif
                            {{-- Brand Overlay --}}
                            @if($car->brand && $car->brand->logo)
                                <div class="car-brand-mini">
                                    <img src="{{ asset('storage/' . $car->brand->logo) }}" alt="{{ $car->brand->name }}">
                                </div>
                            @endif
                        </div>

                        <div class="card-body p-4 d-flex flex-column">
                            <div class="mb-3">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <span class="text-danger fw-bold x-small text-uppercase">{{ $car->brand->name ?? '' }}</span>
                                    <span class="text-muted x-small">{{ $car->year }}</span>
                                </div>
                                <h5 class="car-title" title="{{ $car->name }}">{{ $car->name }}</h5>
                                <div class="d-flex align-items-center gap-2 mt-1">
                                    <span class="car-type-tag">{{ $car->category->name ?? __('سيارة') }}</span>
                                    <span class="text-muted small">•</span>
                                    <span class="text-muted x-small">{{ $car->model }}</span>
                                </div>
                            </div>

                            {{-- Price Bar --}}
                            <div class="car-price-grid mb-4">
                                <div class="price-item">
                                    <label>{{ __('سعر الكاش') }}</label>
                                    <div class="value">
                                        <span class="num">{{ number_format($car->cash_price) }}</span>
                                        <span class="gr-currency"></span>
                                    </div>
                                </div>
                                <div class="price-item accent">
                                    <label>{{ __('أقل قسط') }}</label>
                                    <div class="value">
                                        <span class="num">{{ number_format($car->min_installment) }}</span>
                                        <span class="gr-currency"></span>
                                    </div>
                                </div>
                            </div>

                            {{-- Actions --}}
                            <div class="car-actions mt-auto">
                                @can('manage-cars')
                                <a href="{{ route('crm.cars.edit', $car) }}" class="btn-action edit flex-grow-1">
                                    <i class="bi bi-pencil-square"></i> {{ __('تعديل') }}
                                </a>
                                <form action="{{ route('crm.cars.destroy', $car) }}" method="POST"
                                    onsubmit="return confirm('{{ __("هل أنت متأكد من حذف هذه السيارة؟") }}')" class="d-inline-flex">
                                    @csrf @method('DELETE')
                                    <button class="btn-action delete" title="{{ __('حذف') }}">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                                @endcan
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="text-center py-5 bg-white rounded-4 shadow-sm opacity-50">
                        <i class="bi bi-car-front fs-1 d-block mb-3"></i>
                        <h6 class="fw-bold">{{ __('لا توجد سيارات مسجلة حالياً') }}</h6>
                        <p class="small">{{ __('ابدأ بإضافة أول سيارة لأسطولك المعروض') }}</p>
                        @can('manage-cars')
                        <a href="{{ route('crm.cars.create') }}" class="btn btn-primary btn-sm rounded-pill mt-3 px-4">{{ __('إضافة سيارة') }}</a>
                        @endcan
                    </div>
                </div>
            @endforelse
        </div>

        <div class="mt-5 d-flex justify-content-center">{{ $cars->links('pagination::bootstrap-5') }}</div>
    </div>

    <style>
        :root {
            --car-card-red: #E30613;
            --car-card-dark: #1A1C21;
            --car-card-bg: #FFFFFF;
            --car-card-shadow: 0 10px 30px rgba(0,0,0,0.06);
            --car-card-radius: 20px;
        }

        .car-card-premium {
            background: var(--car-card-bg);
            border-radius: var(--car-card-radius);
            transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
            border: 1px solid #F0F0F0 !important;
            position: relative;
        }

        .car-card-premium:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.12);
            border-color: #eee !important;
        }

        .car-badges {
            position: absolute;
            top: 15px;
            inset-inline-end: 15px;
            display: flex;
            flex-direction: column;
            gap: 6px;
            z-index: 10;
        }

        .badge-premium {
            padding: 6px 12px;
            border-radius: 30px;
            font-size: 11px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            backdrop-filter: blur(10px);
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }

        .badge-premium.featured { background: rgba(255, 193, 7, 0.9); color: #000; }
        .badge-premium.hidden { background: rgba(227, 6, 19, 0.9); color: #fff; }

        .car-img-wrapper {
            height: 200px;
            position: relative;
            overflow: hidden;
            background: #F8F9FA;
        }

        .car-img-main {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.6s ease;
        }

        .car-card-premium:hover .car-img-main {
            transform: scale(1.1);
        }

        .car-no-img {
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ddd;
            font-size: 3rem;
        }

        .car-brand-mini {
            position: absolute;
            bottom: 12px;
            inset-inline-start: 15px;
            background: #fff;
            padding: 5px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .car-brand-mini img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }

        .car-title {
            font-size: 16px;
            font-weight: 800;
            color: var(--car-card-dark);
            margin: 0;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .car-type-tag {
            background: #F0F2F5;
            color: #666;
            padding: 2px 10px;
            border-radius: 4px;
            font-size: 10px;
            font-weight: 700;
        }

        .car-price-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            background: #F8F9FB;
            border-radius: 14px;
            overflow: hidden;
            border: 1px solid #EDF0F5;
        }

        .price-item {
            padding: 12px;
            display: flex;
            flex-direction: column;
            border-inline-end: 1px solid #EDF0F5;
        }

        .price-item:last-child { border: none; }

        .price-item label {
            font-size: 9px;
            font-weight: 700;
            color: #888;
            margin-bottom: 4px;
            text-transform: uppercase;
        }

        .price-item .value {
            display: flex;
            align-items: baseline;
            gap: 3px;
        }

        .price-item .num {
            font-size: 15px;
            font-weight: 900;
            color: var(--car-card-dark);
        }

        .price-item .gr-currency {
            width: 14px !important;
            height: 14px !important;
            opacity: 0.6;
        }

        .price-item.accent .num { color: var(--car-card-red); }
        .price-item.accent .gr-currency { color: var(--car-card-red) !important; opacity: 1; }

        .car-actions {
            display: flex;
            gap: 10px;
        }

        .btn-action {
            height: 42px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            font-weight: 800;
            font-size: 13px;
            transition: all 0.2s;
            border: none;
            text-decoration: none;
        }

        .btn-action.edit {
            background: var(--car-card-dark);
            color: #fff;
        }

        .btn-action.edit:hover {
            background: #000;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }

        .btn-action.delete {
            width: 42px;
            background: #FFF0F0;
            color: var(--car-card-red);
        }

        .btn-action.delete:hover {
            background: var(--car-card-red);
            color: #fff;
        }

        .x-small { font-size: 10px; }
    </style>
@endsection
