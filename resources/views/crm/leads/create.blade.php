@extends('partials.Layouts.crm-master')
@section('title', __('إضافة عميل') . ' | AutoCRM')

@section('content')
    <div class="container-fluid" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
        
        {{-- Breadcrumb --}}
        <nav class="crm-breadcrumb mb-4">
            <a href="{{ route('crm.dashboard') }}">{{ __('الرئيسية') }}</a>
            <span class="sep">›</span>
            <a href="{{ route('crm.leads.index') }}">{{ __('إدارة العملاء') }}</a>
            <span class="sep">›</span>
            <span class="current">{{ __('إضافة عميل') }}</span>
        </nav>

        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden" style="border:1px solid var(--crm-border)!important;">
                    <div class="card-header bg-white border-0 px-4 py-3 d-flex align-items-center gap-3" style="border-bottom:1px solid var(--crm-border)!important;">
                        <a href="{{ route('crm.leads.index') }}" class="btn btn-light btn-sm rounded-circle"><i class="bi bi-arrow-right"></i></a>
                        <h5 class="fw-bold mb-0">{{ __('إضافة عميل (متابعة)') }}</h5>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('crm.leads.store') }}" method="POST">
                            @csrf
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold" style="font-size:14px;">{{ __('الاسم') }} <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="client_name" class="form-control @error('client_name') is-invalid @enderror"
                                        value="{{ old('client_name') }}" required style="font-size:14px;border-radius:8px;">
                                    @error('client_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold" style="font-size:14px;">{{ __('جوال') }}</label>
                                    <input type="text" name="client_phone" class="form-control"
                                        value="{{ old('client_phone') }}" style="font-size:14px;border-radius:8px;">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold" style="font-size:14px;">{{ __('البريد') }}</label>
                                    <input type="email" name="client_email" class="form-control"
                                        value="{{ old('client_email') }}" style="font-size:14px;border-radius:8px;">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold" style="font-size:14px;">{{ __('مصدر التواصل') }} <span
                                            class="text-danger">*</span></label>
                                    <select name="contact_source_id" class="form-select" required style="font-size:14px;border-radius:8px;">
                                        <option value="">{{ __('اختر') }}</option>
                                        @foreach ($sources ?? [] as $src)
                                            <option value="{{ $src->id }}" @selected(old('contact_source_id') == $src->id)>{{ $src->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('contact_source_id')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold" style="font-size:14px;">{{ __('حالة الطلب') }} <span
                                            class="text-danger">*</span></label>
                                    <select name="status" class="form-select" required style="font-size:14px;border-radius:8px;">
                                        @foreach ($statuses ?? [] as $key => $s)
                                            <option value="{{ $key }}" @selected(old('status', 'new') === $key)>{{ $s['label'] ?? $s }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold" style="font-size:14px;">{{ __('تاريخ بدء المتابعة') }} <span
                                            class="text-danger">*</span></label>
                                    <input type="date" name="started_at" class="form-control"
                                        value="{{ old('started_at', now()->toDateString()) }}" required style="font-size:14px;border-radius:8px;">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold" style="font-size:14px;">{{ __('سيارة مهتم بها (اختياري)') }}</label>
                                    <select name="car_id" class="form-select" style="font-size:14px;border-radius:8px;">
                                        <option value="">{{ __('—') }}</option>
                                        @foreach ($cars ?? [] as $car)
                                            <option value="{{ $car->id }}" @selected(old('car_id') == $car->id)>
                                                {{ $car->name }} — {{ $car->brand->name ?? '' }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold" style="font-size:14px;">{{ __('مسؤول المتابعة') }}</label>
                                    <select name="assigned_to" class="form-select" style="font-size:14px;border-radius:8px;">
                                        <option value="">{{ __('—') }}</option>
                                        @foreach ($employees ?? [] as $emp)
                                            <option value="{{ $emp->id }}" @selected(old('assigned_to') == $emp->id)>{{ $emp->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-semibold" style="font-size:14px;">{{ __('تفاصيل الحالة / متابعة (اختياري)') }}</label>
                                    <textarea name="status_details" class="form-control" rows="4"
                                        placeholder="{{ __('ملاحظات للمتابعة القادمة...') }}" style="font-size:14px;border-radius:8px;">{{ old('status_details') }}</textarea>
                                </div>
                            </div>
                            <div class="mt-4 d-flex gap-2">
                                @can('manage-leads')
                                <button type="submit" class="btn-crm-primary px-4">{{ __('حفظ') }}</button>
                                @endcan
                                <a href="{{ route('crm.leads.index') }}" class="btn btn-light px-4" style="border-radius:8px;">{{ __('إلغاء') }}</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
