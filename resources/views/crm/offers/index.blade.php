@extends('partials.Layouts.crm-master')
@section('title', __('إدارة العروض') . ' | AutoCRM')

@section('content')
<div class="container-fluid" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">

    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h4 class="mb-1 fw-bold"> {{ __('إدارة العروض الترويجية') }}</h4>
            <p class="text-muted mb-0 small">{{ __('إجمالي') }} {{ $offers->total() }} {{ __('عرض متاح') }}</p>
        </div>
        @can('manage-offers')
        <button class="btn btn-primary rounded-pill px-4 shadow-sm fw-bold" data-bs-toggle="modal" data-bs-target="#addOfferModal">
            <i class="bi bi-plus-lg me-1"></i> {{ __('إضافة عرض جديد') }}
        </button>
        @endcan
    </div>

    
    
    @if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-4 mb-4">
        <ul class="mb-0 small fw-bold">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <div class="row g-4">
        @forelse($offers as $offer)
        <div class="col-12 col-md-6 col-xl-4">
            <div class="card border-0 shadow-sm h-100 rounded-4 overflow-hidden position-relative">
                {{-- مؤشر الحالة --}}
                @php
                    $isActive = $offer->is_active && (!$offer->ends_at || $offer->ends_at > now());
                @endphp
                <div class="position-absolute top-0 bottom-0 start-0 bg-{{ $isActive ? 'success' : 'danger' }}" style="width: 5px;"></div>
                
                <div class="card-body p-4 ps-5">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <h5 class="mb-1 fw-bold text-dark">{{ $offer->title }}</h5>
                            <div class="d-flex align-items-center gap-2 flex-wrap">
                                <span class="badge bg-light text-primary border px-2 py-1 small">
                                    <i class="bi bi-car-front me-1"></i>{{ $offer->cars->count() }} {{ __('سيارة') }}
                                </span>
                                @if(!$offer->is_active)
                                    <span class="badge bg-secondary-subtle text-secondary small">{{ __('معطل') }}</span>
                                @elseif($offer->ends_at && $offer->ends_at < now())
                                    <span class="badge bg-danger-subtle text-danger small">{{ __('منتهي') }}</span>
                                @endif
                            </div>
                        </div>
                        @if($offer->discount_percent)
                            <div class="bg-danger text-white rounded-circle d-flex align-items-center justify-content-center fw-black shadow-sm" style="width: 55px; height: 55px; font-size: 16px;">
                                {{ $offer->discount_percent }}%
                            </div>
                        @endif
                    </div>
                    
                    <p class="text-muted small mb-4" style="line-height: 1.6;">{{ Str::limit($offer->description, 100) }}</p>
                    
                    <div class="bg-light rounded-4 p-3 mb-4 border border-light shadow-xs">
                        <div class="row g-0">
                            @if($offer->special_price)
                            <div class="col-6 border-{{ app()->getLocale() == 'ar' ? 'left' : 'right' }} border-light text-center">
                                <small class="text-muted d-block small fw-bold text-uppercase mb-1">{{ __('السعر الخاص') }}</small>
                                <span class="fw-black text-success fs-5">{{ number_format($offer->special_price) }} <small class="fw-normal fs-12">{!! __('ريال') !!}</small></span>
                            </div>
                            @endif
                            @if($offer->special_installment)
                            <div class="col-6 text-center">
                                <small class="text-muted d-block small fw-bold text-uppercase mb-1">{{ __('قسط يبدأ من') }}</small>
                                <span class="fw-black text-primary fs-5">{{ number_format($offer->special_installment) }} <small class="fw-normal fs-12">/ شهر</small></span>
                            </div>
                            @endif
                        </div>
                    </div>
                    
                    <div class="d-flex align-items-center justify-content-between text-muted x-small fw-bold">
                        <span><i class="bi bi-calendar3 me-1"></i> {{ __('يبدأ') }}: {{ $offer->starts_at ? $offer->starts_at->format('Y/m/d') : __('الآن') }}</span>
                        @if($offer->ends_at)
                            <span class="{{ $offer->ends_at < now() ? 'text-danger' : 'text-warning' }}">
                                <i class="bi bi-clock-history me-1"></i> {{ __('ينتهي') }}: {{ $offer->ends_at->format('Y/m/d') }}
                            </span>
                        @else
                            <span class="text-info"><i class="bi bi-infinity me-1"></i> {{ __('عرض مستمر') }}</span>
                        @endif
                    </div>
                </div>
                
                <div class="card-footer bg-light border-0 d-flex gap-2 p-3 ps-5">
                    @can('manage-offers')
                    <button class="btn btn-sm btn-white border shadow-xs flex-grow-1 fw-bold rounded-3" data-bs-toggle="modal" data-bs-target="#editOfferModal{{ $offer->id }}">
                        <i class="bi bi-pencil-square me-1"></i> {{ __('تعديل') }}
                    </button>
                    @endcan
                    @can('manage-offers')
                    <form action="{{ route('crm.offers.destroy', $offer) }}" method="POST" onsubmit="return confirm('{{ __("هل أنت متأكد من حذف هذا العرض؟") }}')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger-subtle text-danger rounded-3 px-3 shadow-xs"><i class="bi bi-trash"></i></button>
                    </form>
                    @endcan
                </div>
            </div>
        </div>

        {{-- Modal التعديل --}}
        <div class="modal fade" id="editOfferModal{{ $offer->id }}" tabindex="-1">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content border-0 shadow rounded-4">
                    <div class="modal-header border-0 pt-4 px-4">
                        <h5 class="modal-title fw-bold">{{ __('تعديل العرض') }}</h5>
                        <button type="button" class="btn-close {{ app()->getLocale() == 'ar' ? 'ms-0 me-auto' : '' }}" data-bs-dismiss="modal"></button>
                    </div>
                    <form action="{{ route('crm.offers.update', $offer) }}" method="POST" enctype="multipart/form-data">
                        @csrf @method('PUT')
                        <div class="modal-body p-4">
                            <div class="row g-3">
                                <div class="col-md-12">
                                    <label class="form-label fw-bold">{{ __('السيارات المرتبطة') }}</label>
                                    <select name="car_ids[]" class="form-select bg-light border-0 select2-multiple" multiple="multiple" required style="height: 150px;">
                                        @foreach($cars as $car)
                                        <option value="{{ $car->id }}" {{ in_array($car->id, $offer->cars->pluck('id')->toArray()) ? 'selected' : '' }}>{{ $car->brand->name ?? '' }} - {{ $car->name }}</option>
                                        @endforeach
                                    </select>
                                    <small class="text-muted">{{ __('يمكنك اختيار أكثر من سيارة بالضغط مع Control') }}</small>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">{{ __('عنوان العرض (عربي)') }}</label>
                                    <input type="text" name="title[ar]" class="form-control bg-light border-0" value="{{ $offer->getTranslation('title', 'ar', false) }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">{{ __('عنوان العرض (EN)') }}</label>
                                    <input type="text" name="title[en]" class="form-control bg-light border-0" value="{{ $offer->getTranslation('title', 'en', false) }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">{{ __('الوصف (عربي)') }}</label>
                                    <textarea name="description[ar]" class="form-control bg-light border-0" rows="2">{{ $offer->getTranslation('description', 'ar', false) }}</textarea>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">{{ __('الوصف (EN)') }}</label>
                                    <textarea name="description[en]" class="form-control bg-light border-0" rows="2">{{ $offer->getTranslation('description', 'en', false) }}</textarea>
                                </div>
                                
                                <div class="col-md-4">
                                    <label class="form-label fw-bold">{{ __('خصم (%)') }}</label>
                                    <input type="number" name="discount_percent" class="form-control bg-light border-0" value="{{ $offer->discount_percent }}">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-bold">{{ __('السعر الخاص') }}</label>
                                    <input type="number" name="special_price" class="form-control bg-light border-0" value="{{ $offer->special_price }}">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-bold">{{ __('قسط خاص') }}</label>
                                    <input type="number" name="special_installment" class="form-control bg-light border-0" value="{{ $offer->special_installment }}">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-bold">{{ __('تاريخ البدء') }}</label>
                                    <input type="date" name="starts_at" class="form-control bg-light border-0" value="{{ $offer->starts_at ? $offer->starts_at->format('Y-m-d') : '' }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">{{ __('تاريخ الانتهاء') }}</label>
                                    <input type="date" name="ends_at" class="form-control bg-light border-0" value="{{ $offer->ends_at ? $offer->ends_at->format('Y-m-d') : '' }}">
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label fw-bold">{{ __('صورة العرض') }}</label>
                                    <div class="d-flex align-items-center gap-3 mb-2">
                                        @if($offer->image)
                                            <div class="rounded-3 border overflow-hidden" style="width: 100px; height: 60px;">
                                                <img src="{{ asset('storage/' . $offer->image) }}" class="w-100 h-100 object-fit-cover">
                                            </div>
                                        @endif
                                        <input type="file" name="image" class="form-control bg-light border-0" accept="image/*">
                                    </div>
                                    <small class="text-muted">{{ __('اتركه فارغاً لاستخدام صورة السيارة الافتراضية') }}</small>
                                </div>
                                
                                <div class="col-12 mt-4">
                                    <div class="form-check form-switch p-3 bg-light rounded-3 border-0">
                                        <input class="form-check-input {{ app()->getLocale() == 'ar' ? 'ms-0 me-2 float-none' : '' }}" type="checkbox" name="is_active" value="1" id="active{{ $offer->id }}" {{ $offer->is_active ? 'checked' : '' }}>
                                        <label class="form-check-label fw-bold ms-2" for="active{{ $offer->id }}">{{ __('تفعيل العرض فوراً') }}</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer border-0 p-4 pt-0">
                            <button type="button" class="btn btn-light px-4 rounded-3" data-bs-dismiss="modal">{{ __('إلغاء') }}</button>
                            <button type="submit" class="btn btn-primary px-4 rounded-3 fw-bold">{{ __('حفظ التغييرات') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="text-center py-5 bg-white rounded-4 shadow-sm opacity-50">
                <i class="bi bi-tags fs-1 d-block mb-3"></i>
                <h6 class="fw-bold">{{ __('لا توجد عروض ترويجية حالياً') }}</h6>
                <p class="small">{{ __('يمكنك البدء بإضافة عرض جديد لسيارة محددة') }}</p>
            </div>
        </div>
        @endforelse
    </div>
    
    <div class="mt-4">{{ $offers->links() }}</div>

</div>

{{-- Modal الإضافة --}}
<div class="modal fade" id="addOfferModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow rounded-4">
            <div class="modal-header border-0 pt-4 px-4">
                <h5 class="modal-title fw-bold">{{ __('إضافة عرض ترويجي جديد') }}</h5>
                <button type="button" class="btn-close {{ app()->getLocale() == 'ar' ? 'ms-0 me-auto' : '' }}" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('crm.offers.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label fw-bold">{{ __('السيارات المستهدفة') }} <span class="text-danger">*</span></label>
                            <select name="car_ids[]" class="form-select bg-light border-0 select2-multiple" multiple="multiple" required style="height: 150px;">
                                @foreach($cars as $car)
                                <option value="{{ $car->id }}">{{ $car->brand->name ?? '' }} - {{ $car->name }}</option>
                                @endforeach
                            </select>
                            <small class="text-muted">{{ __('يمكنك اختيار أكثر من سيارة بالضغط مع Control') }}</small>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">{{ __('عنوان العرض (عربي)') }} <span class="text-danger">*</span></label>
                            <input type="text" name="title[ar]" class="form-control bg-light border-0" placeholder="مثال: عرض الصيف الهائل" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">{{ __('عنوان العرض (EN)') }} <span class="text-danger">*</span></label>
                            <input type="text" name="title[en]" class="form-control bg-light border-0" placeholder="e.g.: Mega Summer Sale" required>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label fw-bold">{{ __('الوصف المختصر (عربي)') }}</label>
                            <textarea name="description[ar]" class="form-control bg-light border-0" rows="2" placeholder="اكتب تفاصيل العرض..."></textarea>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label fw-bold">{{ __('الوصف المختصر (EN)') }}</label>
                            <textarea name="description[en]" class="form-control bg-light border-0" rows="2" placeholder="English description..."></textarea>
                        </div>
                        
                        <div class="col-md-4">
                            <label class="form-label fw-bold">{{ __('نسبة الخصم (%)') }}</label>
                            <input type="number" name="discount_percent" class="form-control bg-light border-0" placeholder="10">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">{{ __('سعر كاش خاص') }}</label>
                            <input type="number" name="special_price" class="form-control bg-light border-0" placeholder="السعر بعد الخصم">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">{{ __('قسط شهري يبدأ من') }}</label>
                            <input type="number" name="special_installment" class="form-control bg-light border-0" placeholder="أقل قسط متاح">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold">{{ __('تاريخ البدء') }}</label>
                            <input type="date" name="starts_at" class="form-control bg-light border-0">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">{{ __('تاريخ الانتهاء') }}</label>
                            <input type="date" name="ends_at" class="form-control bg-light border-0">
                        </div>

                        <div class="col-md-12">
                            <label class="form-label fw-bold">{{ __('صورة العرض') }}</label>
                            <input type="file" name="image" class="form-control bg-light border-0" accept="image/*">
                            <small class="text-muted">{{ __('سيتم استخدام صورة السيارة تلقائياً إذا لم ترفع صورة هنا') }}</small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 p-4 pt-0">
                    <button type="button" class="btn btn-light px-4 rounded-3" data-bs-dismiss="modal">{{ __('إلغاء') }}</button>
                    <button type="submit" class="btn btn-primary px-4 rounded-3 fw-bold">{{ __('إضافة العرض الآن') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .btn-white { background: #fff; }
    .btn-danger-subtle { background: #ffebee; }
    .fw-black { font-weight: 900; }
    .shadow-xs { box-shadow: 0 1px 2px rgba(0,0,0,0.05); }
    .x-small { font-size: 11px; }
    .fs-12 { font-size: 12px; }
</style>
@endsection
