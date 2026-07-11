@extends('partials.Layouts.crm-master')
@section('title', __('تعديل سيارة') . ' | GR Motors')

@section('content')
<div class="container-fluid" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">

    <nav class="crm-breadcrumb">
        <a href="{{ route('crm.dashboard') }}">{{ __('الرئيسية') }}</a>
        <span class="sep">›</span>
        <a href="{{ route('crm.cars.index') }}">{{ __('الكتالوج') }}</a>
        <span class="sep">›</span>
        <span class="current">{{ __('تعديل') }}: {{ $car->name }}</span>
    </nav>

    <form action="{{ route('crm.cars.update', $car) }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')

        {{-- Sticky Save Bar --}}
        <div class="car-save-bar">
            <span class="fw-bold" style="font-size:15px;">{{ $car->name }}</span>
            <div class="d-flex gap-2">
                <a href="{{ route('crm.cars.index') }}" class="btn-crm-light">{{ __('إلغاء') }}</a>
                <button type="submit" class="btn-crm-primary">
                    <i class="bi bi-check2-circle"></i> {{ __('حفظ التعديلات') }}
                </button>
            </div>
        </div>

        @if($errors->any())
        <div class="alert alert-danger mb-4"><i class="bi bi-exclamation-triangle-fill me-2"></i>{{ __('يوجد أخطاء في البيانات') }}</div>
        @endif

        <div class="row g-4">
            <div class="col-12 col-lg-8">

                {{-- البيانات الأساسية --}}
                <div class="car-section mb-4">
                    <div class="car-section-header"><i class="bi bi-info-circle"></i> {{ __('البيانات الأساسية') }}</div>
                    <div class="car-section-body">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label">{{ __('الماركة') }} <span class="text-danger">*</span></label>
                                <select name="brand_id" class="form-select @error('brand_id') is-invalid @enderror" required>
                                    <option value="">{{ __('اختر الماركة') }}</option>
                                    @foreach($brands as $brand)
                                    <option value="{{ $brand->id }}" {{ $car->brand_id == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
                                    @endforeach
                                </select>
                                @error('brand_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">{{ __('التصنيف') }}</label>
                                <select name="category_id" class="form-select">
                                    <option value="">{{ __('بدون تصنيف') }}</option>
                                    @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" @selected($car->category_id == $cat->id)>{{ $cat->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">{{ __('النوع') }} <span class="text-danger">*</span></label>
                                <select name="type" class="form-select" required>
                                    @foreach($carTypes as $carType)
                                    <option value="{{ $carType->slug }}" {{ $car->type === $carType->slug ? 'selected' : '' }}>{{ $carType->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">{{ __('الموديل') }} <span class="text-danger">*</span></label>
                                <input type="text" name="model" class="form-control" value="{{ $car->model }}" required>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">{{ __('سنة الصنع') }} <span class="text-danger">*</span></label>
                                <input type="number" name="year" class="form-control" value="{{ $car->year }}" min="2000" max="2030" required>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">{{ __('حالة الإتاحة') }}</label>
                                <select name="availability_status" class="form-select">
                                    <option value="available" {{ $car->availability_status=='available'?'selected':'' }}>{{ __('متاحة للعرض') }}</option>
                                    <option value="order_now"  {{ $car->availability_status=='order_now'?'selected':'' }}>{{ __('اطلب الآن') }}</option>
                                    <option value="on_request" {{ $car->availability_status=='on_request'?'selected':'' }}>{{ __('عند الطلب') }}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- الاسم والوصف --}}
                <div class="car-section mb-4">
                    <div class="car-section-header"><i class="bi bi-translate"></i> {{ __('اسم السيارة والوصف') }}</div>
                    <div class="car-section-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">{{ __('بالعربية') }} <span class="text-danger">*</span></label>
                                <input type="text" name="name[ar]" class="form-control @error('name.ar') is-invalid @enderror"
                                       value="{{ $car->getTranslation('name','ar') }}" required dir="rtl">
                                @error('name.ar') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">English <span class="text-danger">*</span></label>
                                <input type="text" name="name[en]" class="form-control @error('name.en') is-invalid @enderror"
                                       value="{{ $car->getTranslation('name','en') }}" required dir="ltr">
                                @error('name.en') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">{{ __('الوصف (عربي)') }}</label>
                                <textarea name="description[ar]" class="form-control" rows="3" dir="rtl">{{ $car->getTranslation('description','ar',false) }}</textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Description (English)</label>
                                <textarea name="description[en]" class="form-control" rows="3" dir="ltr">{{ $car->getTranslation('description','en',false) }}</textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">{{ __('المميزات (عربي)') }}</label>
                                <textarea name="features[ar]" class="form-control" rows="3" dir="rtl">{{ $car->getTranslation('features','ar',false) }}</textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Features (English)</label>
                                <textarea name="features[en]" class="form-control" rows="3" dir="ltr">{{ $car->getTranslation('features','en',false) }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- التسعير --}}
                <div class="car-section mb-4">
                    <div class="car-section-header"><i class="bi bi-currency-dollar"></i> {{ __('التسعير والتقسيط') }}</div>
                    <div class="car-section-body">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label">{{ __('سعر الكاش') }} <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="number" name="cash_price" class="form-control" value="{{ $car->cash_price }}" min="0" required>
                                    <span class="input-group-text">{!! __('ريال') !!}</span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">{{ __('أقل مقدم') }} <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="number" name="min_down_payment" class="form-control" value="{{ $car->min_down_payment }}" min="0" required>
                                    <span class="input-group-text">{!! __('ريال') !!}</span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">{{ __('أقل قسط شهري') }} <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="number" name="min_installment" class="form-control" value="{{ $car->min_installment }}" min="0" required>
                                    <span class="input-group-text">{!! __('ريال') !!}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- المواصفات --}}
                <div class="car-section mb-4">
                    <div class="car-section-header"><i class="bi bi-speedometer2"></i> {{ __('المواصفات التقنية') }}</div>
                    <div class="car-section-body">
                        <div class="row g-3">
                            <div class="col-md-3">
                                <label class="form-label">{{ __('قوة المحرك') }}</label>
                                <input type="text" name="specs[hp]" class="form-control" placeholder="300 HP" value="{{ $car->specs['hp'] ?? '' }}">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">{{ __('نوع الوقود') }}</label>
                                <input type="text" name="specs[fuel]" class="form-control" placeholder="بنزين" value="{{ $car->specs['fuel'] ?? '' }}">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">{{ __('ناقل الحركة') }}</label>
                                <input type="text" name="specs[gearbox]" class="form-control" placeholder="أوتوماتيك" value="{{ $car->specs['gearbox'] ?? '' }}">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">{{ __('عدد المقاعد') }}</label>
                                <input type="number" name="specs[seats]" class="form-control" placeholder="5" value="{{ $car->specs['seats'] ?? '' }}">
                            </div>
                            <div class="col-12">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <label class="form-label mb-0 fw-bold">{{ __('المواصفات') }}</label>
                                    <div class="btn-group btn-group-sm">
                                        <button type="button" class="btn btn-outline-secondary" onclick="toggleCheckboxes('specifications[]', true)">{{ __('تحديد الكل') }}</button>
                                        <button type="button" class="btn btn-outline-secondary" onclick="toggleCheckboxes('specifications[]', false)">{{ __('إلغاء الكل') }}</button>
                                    </div>
                                </div>
                                <div class="checkbox-grid-container">
                                    <div class="row g-2">
                                        @foreach($specifications as $spec)
                                        <div class="col-md-4 col-lg-3">
                                            <div class="checkbox-item-wrapper">
                                                <input type="checkbox" name="specifications[]" value="{{ $spec->id }}" id="spec_{{ $spec->id }}" class="btn-check" @checked($car->specifications->contains($spec->id))>
                                                <label class="btn btn-outline-premium w-100 text-start d-flex align-items-center gap-2" for="spec_{{ $spec->id }}">
                                                    <i class="bi bi-check-circle-fill check-icon"></i>
                                                    <span>{{ $spec->name }}</span>
                                                </label>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mt-4">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <label class="form-label mb-0 fw-bold">{{ __('المميزات') }}</label>
                                    <div class="btn-group btn-group-sm">
                                        <button type="button" class="btn btn-outline-secondary" onclick="toggleCheckboxes('features_list[]', true)">{{ __('تحديد الكل') }}</button>
                                        <button type="button" class="btn btn-outline-secondary" onclick="toggleCheckboxes('features_list[]', false)">{{ __('إلغاء الكل') }}</button>
                                    </div>
                                </div>
                                <div class="checkbox-grid-container">
                                    <div class="row g-2">
                                        @foreach($features_list as $feat)
                                        <div class="col-md-4 col-lg-3">
                                            <div class="checkbox-item-wrapper">
                                                <input type="checkbox" name="features_list[]" value="{{ $feat->id }}" id="feat_{{ $feat->id }}" class="btn-check" @checked($car->features_list->contains($feat->id))>
                                                <label class="btn btn-outline-premium w-100 text-start d-flex align-items-center gap-2" for="feat_{{ $feat->id }}">
                                                    <i class="bi bi-check-circle-fill check-icon"></i>
                                                    <span>{{ $feat->name }}</span>
                                                </label>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mt-4">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <label class="form-label mb-0 fw-bold">{{ __('ميزات السلامة') }}</label>
                                    <div class="btn-group btn-group-sm">
                                        <button type="button" class="btn btn-outline-secondary" onclick="toggleCheckboxes('safety_features[]', true)">{{ __('تحديد الكل') }}</button>
                                        <button type="button" class="btn btn-outline-secondary" onclick="toggleCheckboxes('safety_features[]', false)">{{ __('إلغاء الكل') }}</button>
                                    </div>
                                </div>
                                <div class="checkbox-grid-container">
                                    <div class="row g-2">
                                        @foreach($safety_features as $safetyFeat)
                                        <div class="col-md-4 col-lg-3">
                                            <div class="checkbox-item-wrapper">
                                                <input type="checkbox" name="safety_features[]" value="{{ $safetyFeat->id }}" id="safety_feat_{{ $safetyFeat->id }}" class="btn-check" @checked($car->safety_features->contains($safetyFeat->id))>
                                                <label class="btn btn-outline-premium w-100 text-start d-flex align-items-center gap-2" for="safety_feat_{{ $safetyFeat->id }}">
                                                    <i class="bi bi-check-circle-fill check-icon"></i>
                                                    <span>{{ $safetyFeat->name }}</span>
                                                </label>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- الألوان --}}
                <div class="car-section mb-4">
                    <div class="car-section-header d-flex justify-content-between align-items-center">
                        <span><i class="bi bi-palette"></i> {{ __('الألوان المتاحة') }}</span>
                        <button type="button" class="btn-crm-primary" style="padding:6px 14px;font-size:12px;" onclick="addColorRow()">
                            <i class="bi bi-plus-lg"></i> {{ __('إضافة لون') }}
                        </button>
                    </div>
                    <div class="car-section-body">
                        <div id="colors-container"></div>
                        <p id="no-colors-msg" class="text-muted text-center py-3" style="font-size:13px;{{ $car->colors && count($car->colors) > 0 ? 'display:none;' : '' }}">
                            <i class="bi bi-palette2 d-block fs-2 mb-2 opacity-25"></i>
                            {{ __('لا توجد ألوان — اضغط "إضافة لون"') }}
                        </p>
                    </div>
                </div>



            </div>

            {{-- الجانب الأيمن --}}
            <div class="col-12 col-lg-4">
                <div class="car-section mb-4">
                    <div class="car-section-header"><i class="bi bi-gear"></i> {{ __('الإعدادات') }}</div>
                    <div class="car-section-body">
                        <div class="d-flex align-items-center justify-content-between p-3 rounded-3 mb-3" style="background:#F8F9FC;border:1px solid var(--crm-border);">
                            <div>
                                <div class="fw-bold" style="font-size:13px;">{{ __('عرض في الصفحة الرئيسية') }}</div>
                                <small class="text-muted">{{ __('تظهر في قسم المميزة') }}</small>
                            </div>
                            <div class="form-check form-switch mb-0">
                                <input class="form-check-input" type="checkbox" name="is_featured" value="1" {{ $car->is_featured ? 'checked' : '' }} style="width:40px;height:22px;">
                            </div>
                        </div>
                        <div class="d-flex flex-column p-3 rounded-3 mb-3" style="background:#F8F9FC;border:1px solid var(--crm-border);">
                            <div class="mb-2">
                                <div class="fw-bold" style="font-size:13px;">{{ __('سيارة محددة / Highlight') }}</div>
                                <small class="text-muted">{{ __('تظهر في تبويبات الصفحة الرئيسية') }}</small>
                            </div>
                            <select name="is_highlighted" class="form-select form-select-sm">
                                <option value="none" {{ $car->is_highlighted == 'none' ? 'selected' : '' }}>{{ __('بدون تمييز') }}</option>
                                <option value="new_arrival" {{ $car->is_highlighted == 'new_arrival' ? 'selected' : '' }}>{{ __('أحدث السيارات') }}</option>
                                <option value="featured" {{ $car->is_highlighted == 'featured' ? 'selected' : '' }}>{{ __('سيارات مختارة') }}</option>
                                <option value="trending" {{ $car->is_highlighted == 'trending' ? 'selected' : '' }}>{{ __('الأكثر طلباً') }}</option>
                                <option value="exclusive" {{ $car->is_highlighted == 'exclusive' ? 'selected' : '' }}>{{ __('إصدار خاص') }}</option>
                            </select>
                        </div>
                        <div class="d-flex align-items-center justify-content-between p-3 rounded-3" style="background:#F8F9FC;border:1px solid var(--crm-border);">
                            <div>
                                <div class="fw-bold" style="font-size:13px;">{{ __('السيارة نشطة') }}</div>
                                <small class="text-muted">{{ __('ظاهرة في المعرض') }}</small>
                            </div>
                            <div class="form-check form-switch mb-0">
                                <input class="form-check-input" type="checkbox" name="is_active" value="1" {{ $car->is_active ? 'checked' : '' }} style="width:40px;height:22px;">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="car-section mb-4">
                    <div class="car-section-header"><i class="bi bi-images"></i> {{ __('الصور') }}</div>
                    <div class="car-section-body">
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label">{{ __('الصورة الرئيسية') }}</label>
                                @if($car->thumbnail)
                                <div class="d-flex align-items-center gap-3 mb-2 p-2 rounded-3" style="background:#F8F9FC;border:1px solid var(--crm-border);">
                                    <img src="{{ asset('storage/'.$car->thumbnail) }}" class="car-img-preview" id="thumbPreview">
                                    <div>
                                        <div class="fw-bold" style="font-size:12px;">{{ __('الصورة الحالية') }}</div>
                                        <small class="text-muted">{{ __('ارفع صورة جديدة للاستبدال') }}</small>
                                    </div>
                                </div>
                                @endif
                                <input type="file" name="thumbnail" id="thumbnailInput" accept="image/*" class="form-control">
                            </div>
                            <div class="col-12">
                                <label class="form-label">{{ __('صور خارجية جديدة') }}</label>
                                <input type="file" name="exterior_images[]" class="form-control" accept="image/*" multiple>
                                @if($car->images->where('type','exterior')->count() > 0)
                                <div class="d-flex flex-wrap gap-2 mt-2">
                                    @foreach($car->images->where('type','exterior') as $img)
                                    <div class="position-relative">
                                        <img src="{{ asset('storage/'.$img->image_path) }}" class="rounded" style="width:70px;height:52px;object-fit:cover;">
                                        <a href="{{ route('crm.cars.delete-image', $img) }}" class="position-absolute top-0 end-0" style="background:#E30613;color:#fff;border-radius:50%;width:18px;height:18px;display:flex;align-items:center;justify-content:center;font-size:10px;text-decoration:none;" onclick="return confirm('حذف؟')">×</a>
                                    </div>
                                    @endforeach
                                </div>
                                @endif
                            </div>
                            <div class="col-12">
                                <label class="form-label">{{ __('صور داخلية جديدة') }}</label>
                                <input type="file" name="interior_images[]" class="form-control" accept="image/*" multiple>
                                @if($car->images->where('type','interior')->count() > 0)
                                <div class="d-flex flex-wrap gap-2 mt-2">
                                    @foreach($car->images->where('type','interior') as $img)
                                    <div class="position-relative">
                                        <img src="{{ asset('storage/'.$img->image_path) }}" class="rounded" style="width:70px;height:52px;object-fit:cover;">
                                        <a href="{{ route('crm.cars.delete-image', $img) }}" class="position-absolute top-0 end-0" style="background:#E30613;color:#fff;border-radius:50%;width:18px;height:18px;display:flex;align-items:center;justify-content:center;font-size:10px;text-decoration:none;" onclick="return confirm('حذف؟')">×</a>
                                    </div>
                                    @endforeach
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="car-section">
                    <div class="car-section-body">
                        <button type="submit" class="btn-crm-primary w-100" style="padding:14px;font-size:15px;justify-content:center;">
                            <i class="bi bi-check2-circle fs-5"></i> {{ __('حفظ التعديلات') }}
                        </button>
                        <a href="{{ route('crm.cars.index') }}" class="btn-crm-light w-100 mt-2" style="justify-content:center;">{{ __('إلغاء') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<style>
.car-save-bar { position:sticky;top:64px;z-index:90;background:#fff;border-bottom:1px solid var(--crm-border);padding:12px 0;margin-bottom:24px;display:flex;justify-content:space-between;align-items:center; }
.car-section { background:#fff;border:1px solid var(--crm-border);border-radius:var(--crm-radius);overflow:hidden; }
.car-section-header { padding:14px 20px;font-size:14px;font-weight:800;color:var(--crm-text);background:#FAFBFD;border-bottom:1px solid var(--crm-border);display:flex;align-items:center;gap:8px; }
.car-section-body { padding:20px; }
.car-img-preview { max-height:80px;border-radius:8px;border:1px solid var(--crm-border); }

/* Premium Checkbox Grid */
.checkbox-grid-container {
    max-height: 300px;
    overflow-y: auto;
    padding: 15px;
    background: #fcfcfd;
    border: 1px solid #edf0f5;
    border-radius: 12px;
}
.checkbox-grid-container::-webkit-scrollbar { width: 6px; }
.checkbox-grid-container::-webkit-scrollbar-thumb { background: #e0e0e0; border-radius: 10px; }

.btn-outline-premium {
    border: 1px solid #edf0f5;
    background: #fff;
    color: #4a5568;
    padding: 10px 15px;
    border-radius: 10px;
    font-size: 13px;
    font-weight: 600;
    transition: all 0.2s ease;
    text-align: right !important;
}
.btn-outline-premium:hover {
    background: #f7fafc;
    border-color: var(--crm-red);
    color: var(--crm-red);
}
.btn-check:checked + .btn-outline-premium {
    background: var(--crm-red-light);
    border-color: var(--crm-red);
    color: var(--crm-red);
    box-shadow: 0 4px 12px rgba(227, 6, 19, 0.08);
}
.check-icon {
    font-size: 16px;
    opacity: 0;
    transition: all 0.2s ease;
}
.btn-check:checked + .btn-outline-premium .check-icon {
    opacity: 1;
}

.color-row { display:flex;align-items:center;gap:10px;padding:12px;border:1px solid var(--crm-border);border-radius:10px;margin-bottom:8px;background:#FAFBFD; }
.color-row .color-swatch { width:36px;height:36px;border-radius:8px;border:2px solid var(--crm-border);flex-shrink:0;cursor:pointer; }
.color-row .color-img-label { display:flex;align-items:center;gap:6px;font-size:12px;font-weight:600;color:var(--crm-text-muted);padding:6px 12px;border:1px solid var(--crm-border);border-radius:8px;cursor:pointer;background:#fff;white-space:nowrap; }
.color-row .color-img-label:hover { border-color:var(--crm-red);color:var(--crm-red); }
.color-row .color-img-preview { width:36px;height:36px;border-radius:6px;object-fit:cover;border:1px solid var(--crm-border); }
.color-row .color-remove { background:none;border:none;color:var(--crm-red);cursor:pointer;font-size:18px;flex-shrink:0;padding:0; }
</style>

@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
$(document).ready(function() {
    $('.select2').select2({ theme: 'bootstrap-5', width: '100%', dir: '{{ app()->getLocale() == "ar" ? "rtl" : "ltr" }}' });
});

// Thumbnail preview
document.getElementById('thumbnailInput').addEventListener('change', function() {
    const file = this.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = e => {
        let prev = document.getElementById('thumbPreview');
        if (!prev) { prev = document.createElement('img'); prev.id='thumbPreview'; prev.className='car-img-preview mt-2'; this.parentNode.appendChild(prev); }
        prev.src = e.target.result;
        prev.classList.remove('d-none');
    };
    reader.readAsDataURL(file);
});

// ===== Color Rows =====
let colorCount = 0;

function addColorRow(name = '', hex = '#E30613', existingImg = null, existingImgPath = '') {
    const idx = colorCount++;
    document.getElementById('no-colors-msg').style.display = 'none';
    const container = document.getElementById('colors-container');
    const div = document.createElement('div');
    div.className = 'color-row';
    div.id = 'color-row-' + idx;

    const hasExisting = existingImg && existingImg !== '';
    div.innerHTML = `
        <div style="position:relative;flex-shrink:0;">
            <div class="color-swatch" id="swatch-${idx}" style="background:${hex};" onclick="document.getElementById('hex-${idx}').click()"></div>
            <input type="color" id="hex-${idx}" name="color_hexes[]" value="${hex}"
                   style="position:absolute;top:0;left:0;opacity:0;width:36px;height:36px;cursor:pointer;"
                   oninput="document.getElementById('swatch-${idx}').style.background=this.value">
        </div>
        <input type="text" name="color_names[]" class="form-control" placeholder="{{ __('اسم اللون') }}"
               value="${name}" style="flex:1;font-size:13px;">
        ${existingImgPath ? `<input type="hidden" name="color_keep_images[${idx}]" value="${existingImgPath}">` : ''}
        <div style="position:relative;flex-shrink:0;">
            <label class="color-img-label" for="cimg-${idx}">
                <i class="bi bi-image"></i>
                <span id="cimg-lbl-${idx}">${hasExisting ? '{{ __("تغيير الصورة") }}' : '{{ __("صورة اللون") }}'}</span>
            </label>
            <input type="file" id="cimg-${idx}" name="color_images[${idx}]" accept="image/*" class="d-none"
                   onchange="previewColorImg(this, ${idx})">
        </div>
        <img id="cprev-${idx}" src="${hasExisting ? existingImg : ''}" class="color-img-preview${hasExisting ? '' : ' d-none'}">
        <button type="button" class="color-remove" onclick="removeColorRow(${idx})">
            <i class="bi bi-x-circle-fill"></i>
        </button>
    `;
    container.appendChild(div);
}

function removeColorRow(idx) {
    document.getElementById('color-row-' + idx)?.remove();
    if (document.querySelectorAll('.color-row').length === 0) {
        document.getElementById('no-colors-msg').style.display = '';
    }
}

function previewColorImg(input, idx) {
    if (!input.files[0]) return;
    const reader = new FileReader();
    reader.onload = e => {
        const prev = document.getElementById('cprev-' + idx);
        prev.src = e.target.result;
        prev.classList.remove('d-none');
        document.getElementById('cimg-lbl-' + idx).textContent = '{{ __("تم الرفع") }} ✓';
    };
    reader.readAsDataURL(input.files[0]);
}

// Load existing colors on page load
const existingColors = @json($car->colors ?? []);
existingColors.forEach(c => {
    const isNew = typeof c === 'string'; // old format = hex only
    const name = isNew ? '' : (c.name || '');
    const hex  = isNew ? c  : (c.hex  || '#E30613');
    const img  = isNew ? null : (c.image ? '{{ asset("storage/") }}/' + c.image : null);
    const path = isNew ? '' : (c.image || '');
    addColorRow(name, hex, img, path);
});

// Toggle checkboxes helper
function toggleCheckboxes(name, state) {
    const checkboxes = document.querySelectorAll(`input[name="${name}"]`);
    checkboxes.forEach(cb => cb.checked = state);
}
</script>
@endsection
