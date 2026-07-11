@extends('partials.Layouts.crm-master')
@section('title', __('الربط والإشعارات') . ' | AutoCRM')

@section('content')
    <div class="container-fluid" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
        <div class="mb-2 d-flex align-items-center justify-content-between">
            <div>
                <h4 class="mb-1 fw-bold"> <i class="bi bi-plugin me-2 text-primary"></i>{{ __('الربط والإشعارات (Integrations)') }}</h4>
                <p class="text-muted mb-0 small">{{ __('إدارة ربط الواجهات البرمجية (API) وقوالب رسائل الواتساب والـ SMS') }}</p>
            </div>
        </div>

        @include('partials.settings-subnav')

        <form action="{{ route('crm.settings.update') }}" method="POST">
            @csrf
            <div class="row g-4">
                <div class="col-lg-8">
                    {{-- Twilio API Settings --}}
                    <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
                        <div class="card-header bg-white border-bottom pt-4 px-4 pb-3">
                            <h6 class="fw-bold mb-0 text-dark"><i class="bi bi-whatsapp text-success me-2"></i>{{ __('إعدادات Twilio API (واتساب & رسائل نصية)') }}</h6>
                        </div>
                        <div class="card-body p-4">
                            <p class="text-muted small mb-4">{{ __('أدخل بيانات حسابك في Twilio لتتمكن من إرسال إشعارات للعملاء. يمكنك الحصول عليها من لوحة تحكم Twilio.') }}</p>
                            
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold small text-muted">Twilio Account SID</label>
                                    <input type="text" name="twilio_sid" class="form-control bg-light border-0 shadow-none py-2" value="{{ $settings['twilio_sid'] ?? '' }}" placeholder="ACxxxxxxxxxxxxxxxxxxxxxxxx">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold small text-muted">Twilio Auth Token</label>
                                    <input type="password" name="twilio_auth_token" class="form-control bg-light border-0 shadow-none py-2" value="{{ $settings['twilio_auth_token'] ?? '' }}" placeholder="••••••••••••••••••••••••">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold small text-muted">{{ __('رقم مرسل الواتساب (Twilio WhatsApp Number)') }}</label>
                                    <input type="text" name="twilio_whatsapp_number" class="form-control bg-light border-0 shadow-none py-2 text-start" dir="ltr" value="{{ $settings['twilio_whatsapp_number'] ?? '' }}" placeholder="whatsapp:+14155238886">
                                    <div class="mt-1 small text-muted">{{ __('يجب أن يبدأ بـ whatsapp: ثم كود الدولة') }}</div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold small text-muted">{{ __('رقم مرسل الـ SMS (Twilio Phone Number)') }}</label>
                                    <input type="text" name="twilio_sms_number" class="form-control bg-light border-0 shadow-none py-2 text-start" dir="ltr" value="{{ $settings['twilio_sms_number'] ?? '' }}" placeholder="+1234567890">
                                    <div class="mt-1 small text-muted">{{ __('اختياري، يستخدم للرسائل النصية فقط') }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- WhatsApp Templates --}}
                    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                        <div class="card-header bg-white border-bottom pt-4 px-4 pb-3">
                            <h6 class="fw-bold mb-0 text-dark"><i class="bi bi-file-text text-primary me-2"></i>{{ __('قوالب الرسائل (Templates)') }}</h6>
                        </div>
                        <div class="card-body p-4">
                            <div class="alert alert-info rounded-3 border-0 small mb-4">
                                <i class="bi bi-info-circle-fill me-2"></i>
                                <strong>{{ __('المتغيرات المتاحة:') }}</strong> يمكنك استخدام المتغيرات التالية داخل نص الرسالة وسيتم استبدالها تلقائياً:
                                <ul class="mb-0 mt-2">
                                    <li><code>{customer_name}</code> - {{ __('اسم العميل') }}</li>
                                    <li><code>{car_name}</code> - {{ __('اسم السيارة (إن وجد)') }}</li>
                                    <li><code>{status}</code> - {{ __('حالة الطلب (لرسائل المتابعة)') }}</li>
                                </ul>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold small text-dark">{{ __('قالب رسالة: تقديم طلب جديد (New Lead)') }}</label>
                                <textarea name="whatsapp_template_new_lead" class="form-control bg-light border-0 shadow-none" rows="4" placeholder="{{ __('مثال: مرحباً {customer_name}، شكراً لتواصلك معنا بخصوص {car_name}. سيقوم فريقنا بالتواصل معك قريباً.') }}">{{ $settings['whatsapp_template_new_lead'] ?? '' }}</textarea>
                                <div class="mt-2 text-muted small">{{ __('يتم إرسالها للعميل عند تقديمه لطلب جديد من الموقع.') }}</div>
                            </div>

                            <hr class="text-muted opacity-25 my-4">

                            <div class="mb-3">
                                <label class="form-label fw-bold small text-dark">{{ __('قالب رسالة: تحديث حالة الطلب (Order Status Update)') }}</label>
                                <textarea name="whatsapp_template_status_update" class="form-control bg-light border-0 shadow-none" rows="4" placeholder="{{ __('مثال: مرحباً {customer_name}، نود إعلامك بأنه تم تغيير حالة طلبك الخاص بـ {car_name} لتصبح: {status}.') }}">{{ $settings['whatsapp_template_status_update'] ?? '' }}</textarea>
                                <div class="mt-2 text-muted small">{{ __('يتم إرسالها للعميل تلقائياً عند تغيير حالة طلبه من الإدارة (مثل: مكتمل، قيد التنفيذ).') }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Sidebar Action --}}
                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm rounded-4 bg-primary text-white overflow-hidden shadow-lg sticky-top" style="top: 20px;">
                        <div class="card-body p-4 position-relative"style="background-color: black !important;">
                            <i class="bi bi-save position-absolute opacity-10" style="font-size: 80px; right: -10px; bottom: -20px;"></i>
                            <h5 class="fw-bold mb-3">{{ __('حفظ إعدادات الربط') }}</h5>
                            <p class="small opacity-75 mb-4" >{{ __('تأكد من صحة بيانات Twilio قبل الحفظ لتجنب تعطل خدمة الإشعارات.') }}</p>
                            @can('manage-settings-integrations')
                            <button type="submit" class="btn btn-white w-100 py-3 fw-black text-primary border-0 rounded-3 shadow-sm">
                                <i class="bi bi-check2-circle me-2"#ee1b24"></i> {{ __('تحديث الإعدادات') }}
                            </button>
                            @endcan
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('css')
<style>
    .btn-white { background: #fff; }
    .fw-black { font-weight: 900; }
</style>
@endsection
