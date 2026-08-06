@extends('partials.Layouts.crm-master')
@section('title', __('الصيانة') . ' | Qemt Najd')

@section('content')
<div class="container-fluid" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">

    <div class="crm-page-header">
        <h1 class="crm-page-title">{{ __('وضع الصيانة') }}</h1>
        <p class="crm-page-sub">{{ __('التحكم في وضع الصيانة للموقع وصورة الخلفية') }}</p>
    </div>

    @include('partials.settings-subnav')

    @if (session('success'))
    <div class="crm-card mb-4" style="background:#ECFDF5;border:1px solid #A7F3D0;">
        <div style="padding:12px 20px;display:flex;align-items:center;gap:8px;font-size:14px;color:#065F46;">
            <i class="bi bi-check-circle-fill" style="color:#059669;"></i>
            {{ session('success') }}
        </div>
    </div>
    @endif

    <form action="{{ route('crm.settings.update') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="row g-4">
            {{-- Left: Maintenance Toggle --}}
            <div class="col-lg-6">
                <div class="crm-card">
                    <h6 style="font-weight:800;font-size:15px;margin-bottom:20px;color:var(--crm-text);">
                        <i class="bi bi-shield-exclamation" style="color:var(--crm-primary);"></i> {{ __('حالة الموقع') }}
                    </h6>

                    {{-- Maintenance Toggle --}}
                    <div style="display:flex;align-items:center;justify-content:space-between;padding:16px;background:var(--crm-bg);border-radius:var(--crm-radius-sm);">
                        <div>
                            <div style="font-weight:700;font-size:14px;color:var(--crm-text);">{{ __('تفعيل وضع الصيانة') }}</div>
                            <div style="font-size:12px;color:var(--crm-text-muted);margin-top:2px;">{{ __('عند التفعيل، سيشاهد الزوار صفحة الصيانة بدلاً من الموقع') }}</div>
                        </div>
                        <label style="position:relative;display:inline-block;width:52px;height:28px;flex-shrink:0;">
                            <input type="hidden" name="maintenance_enabled" value="0">
                            <input type="checkbox" name="maintenance_enabled" value="1"
                                   style="opacity:0;width:0;height:0;"
                                   {{ ($settings['maintenance_enabled'] ?? '0') === '1' ? 'checked' : '' }}
                                   onchange="var s=this.parentElement.querySelector('.crm-toggle-slider');var d=s.querySelector('span');s.style.background=this.checked?'var(--crm-primary)':'#D1D5DB';d.style.transform=this.checked?'translateX(24px)':'';">
                            <span class="crm-toggle-slider" style="position:absolute;cursor:pointer;top:0;left:0;right:0;bottom:0;background:{{ ($settings['maintenance_enabled'] ?? '0') === '1' ? 'var(--crm-primary)' : '#D1D5DB' }};border-radius:28px;transition:.3s;">
                                <span style="position:absolute;content:'';height:22px;width:22px;left:3px;bottom:3px;background:white;border-radius:50%;transition:.3s;{{ ($settings['maintenance_enabled'] ?? '0') === '1' ? 'transform:translateX(24px);' : '' }}"></span>
                            </span>
                        </label>
                    </div>

                    {{-- Maintenance Title --}}
                    <div class="mt-4">
                        <label class="form-label fw-bold" style="font-size:13px;">{{ __('عنوان الصيانة') }}</label>
                        <input type="text" name="maintenance_title" class="form-control"
                               value="{{ $settings['maintenance_title'] ?? __('نحن نعود قريباً') }}"
                               style="font-size:14px;border-radius:var(--crm-radius-sm);border-color:var(--crm-border-light);"
                               placeholder="{{ __('مثال: الموقع تحت الصيانة') }}">
                    </div>

                    {{-- Maintenance Message --}}
                    <div class="mt-3">
                        <label class="form-label fw-bold" style="font-size:13px;">{{ __('رسالة الصيانة') }}</label>
                        <textarea name="maintenance_message" class="form-control" rows="4"
                                  style="font-size:14px;border-radius:var(--crm-radius-sm);border-color:var(--crm-border-light);"
                                  placeholder="{{ __('مثال: نقوم حالياً بتحديث الموقع لتحسين تجربتك، شكراً لصبرك.') }}">{{ $settings['maintenance_message'] ?? __('نقوم حالياً بتحديث الموقع لتحسين تجربتك.') }}</textarea>
                    </div>

                    {{-- Allowed IPs --}}
                    <div class="mt-3">
                        <label class="form-label fw-bold" style="font-size:13px;">{{ __('عناوين IP المسموح لها بالتجاوز') }}</label>
                        <textarea name="maintenance_allowed_ips" class="form-control" rows="3"
                                  style="font-size:14px;border-radius:var(--crm-radius-sm);border-color:var(--crm-border-light);"
                                  placeholder="{{ __('كل IP في سطر، أو افصل بفاصلة') }}">{{ $settings['maintenance_allowed_ips'] ?? '' }}</textarea>
                        <small style="color:var(--crm-text-muted);font-size:12px;margin-top:4px;display:block;">
                            <i class="bi bi-info-circle"></i> {{ __('أدخل IP واحد لكل سطر. سيبقى بإمكان أصحاب هذه العناوين رؤية الموقع بشكل طبيعي.') }}
                        </small>
                    </div>
                </div>
            </div>

            {{-- Right: Background Image --}}
            <div class="col-lg-6">
                <div class="crm-card">
                    <h6 style="font-weight:800;font-size:15px;margin-bottom:20px;color:var(--crm-text);">
                        <i class="bi bi-image" style="color:var(--crm-primary);"></i> {{ __('صورة الخلفية') }}
                    </h6>

                    {{-- Current Image Preview --}}
                    @if(!empty($settings['maintenance_image']))
                    <div style="margin-bottom:16px;border-radius:var(--crm-radius-sm);overflow:hidden;border:1px solid var(--crm-border-light);">
                        <img src="{{ asset('storage/' . $settings['maintenance_image']) }}"
                             alt="{{ __('صورة الصيانة') }}"
                             style="width:100%;height:200px;object-fit:cover;display:block;">
                        <div style="padding:8px 12px;background:var(--crm-bg);font-size:12px;color:var(--crm-text-muted);display:flex;align-items:center;justify-content:space-between;">
                            <span><i class="bi bi-check-circle" style="color:#059669;"></i> {{ __('الصورة الحالية') }}</span>
                            <label style="cursor:pointer;color:var(--crm-danger);font-weight:700;">
                                <input type="checkbox" name="remove_maintenance_image" value="1" style="vertical-align:middle;">
                                {{ __('حذف') }}
                            </label>
                        </div>
                    </div>
                    @endif

                    {{-- Upload --}}
                    <div>
                        <label class="form-label fw-bold" style="font-size:13px;">{{ __('رفع صورة جديدة') }}</label>
                        <input type="file" name="maintenance_image" class="form-control"
                               accept="image/png,image/jpeg,image/webp,image/svg+xml"
                               style="font-size:14px;border-radius:var(--crm-radius-sm);border-color:var(--crm-border-light);">
                        <small style="color:var(--crm-text-muted);font-size:12px;margin-top:4px;display:block;">
                            <i class="bi bi-info-circle"></i> {{ __('يُفضل استخدام صورة بدقة 1920×1080 بصيغة WebP أو JPEG، حجم أقصى 2MB') }}
                        </small>
                    </div>

                    {{-- Preview of hidden field for toggle JS --}}
                    <div style="margin-top:16px;padding:12px 16px;background:var(--crm-bg);border-radius:var(--crm-radius-sm);font-size:13px;color:var(--crm-text-muted);">
                        <i class="bi bi-lightbulb" style="color:#D97706;"></i>
                        {{ __('عند تفعيل وضع الصيانة، سيتم توجيه جميع زوار الموقع إلى صفحة الصيانة مع الخلفية والرسالة التي تختارها.') }}
                    </div>
                </div>
            </div>
        </div>

        {{-- Submit --}}
        <div class="d-flex gap-2 mt-4">
            <button type="submit" class="btn-crm-primary px-4">
                <i class="bi bi-check-lg"></i> {{ __('حفظ الإعدادات') }}
            </button>
        </div>
    </form>
</div>
@endsection
