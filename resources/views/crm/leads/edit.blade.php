@extends('partials.Layouts.crm-master')
@section('title', __('تعديل بيانات العميل') . ' | AutoCRM')

@section('content')
    <div class="container-fluid" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
        
        {{-- Breadcrumb --}}
        <nav class="crm-breadcrumb mb-4">
            <a href="{{ route('crm.dashboard') }}">{{ __('الرئيسية') }}</a>
            <span class="sep">›</span>
            <a href="{{ route('crm.leads.index') }}">{{ __('إدارة العملاء') }}</a>
            <span class="sep">›</span>
            <span class="current">{{ __('تعديل بيانات العميل') }}</span>
        </nav>

        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden" style="border:1px solid var(--crm-border)!important;">
                    <div class="card-header bg-white border-0 px-4 py-3 d-flex align-items-center gap-3" style="border-bottom:1px solid var(--crm-border)!important;">
                        <a href="{{ route('crm.leads.show', $lead) }}" class="btn btn-light btn-sm rounded-circle"><i class="bi bi-arrow-right"></i></a>
                        <h5 class="fw-bold mb-0">{{ __('تعديل بيانات العميل') }}</h5>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('crm.leads.update', $lead) }}" method="POST">
                            @csrf @method('PUT')
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold" style="font-size:14px;">{{ __('الاسم') }} <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="client_name" class="form-control"
                                        value="{{ old('client_name', $lead->client_name) }}" required style="font-size:14px;border-radius:8px;">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold" style="font-size:14px;">{{ __('جوال') }}</label>
                                    <input type="text" name="client_phone" class="form-control"
                                        value="{{ old('client_phone', $lead->client_phone) }}" style="font-size:14px;border-radius:8px;">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold" style="font-size:14px;">{{ __('البريد') }}</label>
                                    <input type="email" name="client_email" class="form-control"
                                        value="{{ old('client_email', $lead->client_email) }}" style="font-size:14px;border-radius:8px;">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold" style="font-size:14px;">{{ __('مصدر التواصل') }} <span
                                            class="text-danger">*</span></label>
                                    <select name="contact_source_id" class="form-select" required style="font-size:14px;border-radius:8px;">
                                        @foreach ($sources ?? [] as $src)
                                            <option value="{{ $src->id }}" @selected(old('contact_source_id', $lead->contact_source_id) == $src->id)>{{ $src->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold" style="font-size:14px;">{{ __('حالة الطلب') }} <span
                                            class="text-danger">*</span></label>
                                    <select name="status" class="form-select" required style="font-size:14px;border-radius:8px;">
                                        @foreach ($statuses ?? [] as $key => $s)
                                            <option value="{{ $key }}" @selected(old('status', $lead->status) === $key)>{{ $s['label'] ?? $s }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold" style="font-size:14px;">{{ __('تاريخ بدء المتابعة') }} <span
                                            class="text-danger">*</span></label>
                                    <input type="date" name="started_at" class="form-control"
                                        value="{{ old('started_at', $lead->started_at?->toDateString()) }}" required style="font-size:14px;border-radius:8px;">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold" style="font-size:14px;">{{ __('سيارة مهتم بها') }}</label>
                                    <select name="car_id" class="form-select" style="font-size:14px;border-radius:8px;">
                                        <option value="">{{ __('—') }}</option>
                                        @foreach ($cars ?? [] as $car)
                                            <option value="{{ $car->id }}" @selected(old('car_id', $lead->car_id) == $car->id)>
                                                {{ $car->name }} — {{ $car->brand->name ?? '' }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold" style="font-size:14px;">{{ __('مسؤول المتابعة') }}</label>
                                    <select name="assigned_to" class="form-select" style="font-size:14px;border-radius:8px;">
                                        <option value="">{{ __('—') }}</option>
                                        @foreach ($employees ?? [] as $emp)
                                            <option value="{{ $emp->id }}" @selected(old('assigned_to', $lead->assigned_to) == $emp->id)>{{ $emp->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-semibold" style="font-size:14px;">{{ __('تفاصيل الحالة / متابعة') }}</label>
                                    <textarea name="status_details" class="form-control" rows="4" style="font-size:14px;border-radius:8px;">{{ old('status_details', $lead->status_details) }}</textarea>
                                </div>
                            </div>
                            <div class="mt-4 d-flex gap-2 flex-wrap">
                                @can('manage-leads')
                                <button type="submit" class="btn-crm-primary px-4">{{ __('حفظ التغييرات') }}</button>
                                @endcan
                                <a href="{{ route('crm.leads.show', $lead) }}" class="btn btn-light px-4" style="border-radius:8px;">{{ __('رجوع') }}</a>
                            </div>
                        </form>
                        <hr class="my-4" style="border-color:var(--crm-border);">
                        @can('manage-leads')
                        <form action="{{ route('crm.leads.destroy', $lead) }}" method="POST"
                            onsubmit="return confirm('{{ __('تأكيد الحذف؟') }}')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger px-4" style="border-radius:8px;"><i class="bi bi-trash me-1"></i> {{ __('حذف السجل') }}</button>
                        </form>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection§Ù„Ø­Ø°ÙØŸ') }}')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger">{{ __('Ø­Ø°Ù Ø§Ù„Ø³Ø¬Ù„') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

