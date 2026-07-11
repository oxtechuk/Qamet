@extends('partials.Layouts.crm-master')
@section('title', 'تفاصيل العميل | AutoCRM')

@section('content')
    <div class="container-fluid" dir="rtl">

        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
            <div class="d-flex align-items-center gap-3">
                <a href="{{ route('crm.leads.index') }}" class="btn btn-white shadow-sm rounded-circle p-2" style="width:38px;height:38px;display:flex;align-items:center;justify-content:center;">
                    <i class="bi bi-arrow-right fs-5"></i>
                </a>
                <div>
                    <h4 class="mb-0 fw-bold">{{ $lead->client_name }}</h4>
                    <p class="text-muted mb-0 small">معرف العميل #{{ $lead->id }}</p>
                </div>
            </div>
            @can('manage-leads')
            <a href="{{ route('crm.leads.edit', $lead) }}" class="btn btn-primary rounded-pill px-4 shadow-sm border-0"><i class="bi bi-pencil-square me-1"></i>
                تعديل البيانات</a>
            @endcan
        </div>

        

        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm mb-4 rounded-4">
                    <div class="card-header bg-transparent border-0 pt-4 px-4">
                        <h6 class="mb-0 fw-bold"><i class="bi bi-person-badge text-primary me-2"></i> بيانات التواصل والاهتمام</h6>
                    </div>
                    <div class="card-body p-4">
                        <dl class="row mb-0 gy-3">
                            <dt class="col-sm-4 text-muted fw-normal small">رقم الجوال</dt>
                            <dd class="col-sm-8 fw-bold">
                                @if ($lead->client_phone)
                                    <a href="tel:{{ $lead->client_phone }}" class="text-dark text-decoration-none">{{ $lead->client_phone }}</a>
                                    <a href="https://wa.me/2{{ $lead->client_phone }}" target="_blank" class="text-success ms-2"><i class="bi bi-whatsapp"></i></a>
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </dd>

                            <dt class="col-sm-4 text-muted fw-normal small">البريد الإلكتروني</dt>
                            <dd class="col-sm-8 fw-bold">{{ $lead->client_email ?: '—' }}</dd>

                            <dt class="col-sm-4 text-muted fw-normal small">مصدر العميل</dt>
                            <dd class="col-sm-8">
                                <span class="badge bg-light text-dark border px-3">{{ $lead->contactSource->name ?? 'غير محدد' }}</span>
                            </dd>

                            <dt class="col-sm-4 text-muted fw-normal small">الحالة الحالية</dt>
                            <dd class="col-sm-8">
                                <span class="badge bg-{{ $lead->status_color }}-subtle text-{{ $lead->status_color }} px-3 py-2 rounded-pill small">
                                    {{ $lead->status_label }}
                                </span>
                            </dd>

                            <dt class="col-sm-4 text-muted fw-normal small">تاريخ بدء المتابعة</dt>
                            <dd class="col-sm-8 fw-bold text-dark">{{ $lead->started_at?->format('Y/m/d') ?? '—' }}</dd>

                            <dt class="col-sm-4 text-muted fw-normal small">المسؤول عن المتابعة</dt>
                            <dd class="col-sm-8">
                                @if($lead->employee)
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="avatar-xs bg-primary-subtle text-primary rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width:24px;height:24px;font-size:10px;">{{ mb_substr($lead->employee->name, 0, 1) }}</div>
                                        <span class="fw-bold">{{ $lead->employee->name }}</span>
                                    </div>
                                @else
                                    <span class="text-muted">غير مسند</span>
                                @endif
                            </dd>

                            <dt class="col-sm-4 text-muted fw-normal small">السيارة المهتم بها</dt>
                            <dd class="col-sm-8">
                                @if ($lead->car)
                                    <div class="fw-bold text-primary">{{ $lead->car->name }}</div>
                                    <small class="text-muted">({{ $lead->car->brand->name ?? '' }})</small>
                                @else
                                    <span class="text-muted">غير محدد</span>
                                @endif
                            </dd>
                        </dl>
                    </div>
                </div>

                <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                    <div class="card-header bg-transparent border-0 pt-4 px-4">
                        <h6 class="mb-0 fw-bold"><i class="bi bi-journal-text text-secondary me-2"></i> ملاحظات المتابعة</h6>
                    </div>
                    <div class="card-body p-4 pt-2">
                        @if ($lead->status_details)
                            <div class="bg-light p-4 rounded-4 border border-dashed text-dark" style="white-space: pre-wrap; line-height: 1.6;">{{ $lead->status_details }}</div>
                        @else
                            <div class="text-center py-4 opacity-50">
                                <i class="bi bi-chat-dots fs-1 d-block mb-2"></i>
                                <p class="mb-0 small text-muted">لا توجد ملاحظات مسجلة لهذا العميل</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-body p-4">
                        <h6 class="fw-bold mb-3 small text-muted text-uppercase">إحصائيات السجل</h6>
                        <div class="d-flex flex-column gap-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="small text-muted">تاريخ الإضافة</span>
                                <span class="small fw-bold">{{ $lead->created_at?->format('Y/m/d H:i') }}</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center border-top pt-3">
                                <span class="small text-muted">آخر تحديث</span>
                                <span class="small fw-bold">{{ $lead->updated_at?->format('Y/m/d H:i') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Quick Contact Actions --}}
                <div class="card border-0 shadow-sm rounded-4 bg-primary text-white overflow-hidden">
                    <div class="card-body p-4 position-relative">
                        <i class="bi bi-lightning-fill position-absolute opacity-10" style="font-size: 80px; right: -10px; bottom: -20px;"></i>
                        <h6 class="fw-bold mb-3">إجراءات سريعة</h6>
                        <div class="d-grid gap-2">
                            <a href="tel:{{ $lead->client_phone }}" class="btn btn-white text-primary border-0 fw-bold rounded-3">
                                <i class="bi bi-telephone me-2"></i> اتصال بالعميل
                            </a>
                            <a href="https://wa.me/2{{ $lead->client_phone }}" target="_blank" class="btn btn-success border-0 fw-bold rounded-3">
                                <i class="bi bi-whatsapp me-2"></i> واتساب سريع
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .btn-white { background: #fff; }
        .avatar-xs { width: 24px; height: 24px; }
    </style>
@endsection
