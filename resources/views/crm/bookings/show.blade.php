@extends('partials.Layouts.crm-master')
@section('title', __('تفاصيل الطلب') . ' #' . $booking->id . ' | GR Motors')

@section('content')
<div class="container-fluid" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">

    {{-- Breadcrumb --}}
    <nav class="crm-breadcrumb">
        <a href="{{ route('crm.dashboard') }}">{{ __('الرئيسية') }}</a>
        <span class="sep">›</span>
        <a href="{{ route('crm.bookings.index') }}">{{ __('الطلبات') }}</a>
        <span class="sep">›</span>
        <span class="current">{{ __('تفاصيل الطلب') }} #{{ $booking->id }}</span>
    </nav>

    {{-- Header --}}
    <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
        <h5 class="fw-bold mb-0">{{ __('تفاصيل الطلب') }} <span style="color:var(--crm-red);">#{{ $booking->id }}</span></h5>
        <div class="d-flex gap-2 flex-wrap">
            <a href="{{ route('crm.bookings.index') }}" class="btn-crm-light">
                <i class="bi bi-arrow-right"></i>
                <span class="d-none d-md-inline">{{ __('العودة للطلبات') }}</span>
            </a>
            <button onclick="window.print()" class="btn-crm-light">
                <i class="bi bi-printer"></i>
                <span class="d-none d-md-inline">{{ __('طباعة تفاصيل الطلب') }}</span>
            </button>
        </div>
    </div>


    {{-- Row 1: تفاصيل الطلب + تفاصيل الدفع --}}
    <div class="row g-3 mb-3">

        {{-- تفاصيل الطلب --}}
        <div class="col-12 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 h-100" style="border:1px solid var(--crm-border)!important;">
                <div class="card-header bg-white border-0 px-4 pt-4 pb-3" style="border-bottom:1px solid var(--crm-border)!important;">
                    <h6 class="fw-bold mb-0">{{ __('تفاصيل الطلب') }}</h6>
                </div>
                <div class="card-body px-4 py-3">
                    @php
                        $orderRows = [
                            __('رقم العميل')      => '#' . ($booking->lead_id ?? $booking->id),
                            __('رقم الطلب')       => '#' . $booking->id,
                            __('حوال العميل')     => $booking->client_phone,
                            __('تاريخ الطلب')     => $booking->created_at->format('d/m/Y • H:i') . ($booking->created_at->format('A') == 'AM' ? ' ص' : ' م'),
                            __('نوع الطلب')       => $booking->booking_type ? (\App\Models\Booking::BOOKING_TYPES_LABELS[$booking->booking_type] ?? '—') : '—',
                            __('الموقع الجغرافي') => $booking->location ?: '—',
                        ];
                    @endphp
                    @foreach($orderRows as $label => $value)
                    <div class="d-flex justify-content-between py-2" style="border-bottom:1px solid var(--crm-border);">
                        <span style="font-size:13px;color:var(--crm-text-muted);">{{ $label }}</span>
                        <span style="font-size:13px;font-weight:700;color:var(--crm-text);" dir="{{ in_array($label, [__('حوال العميل')]) ? 'ltr' : 'inherit' }}">{{ $value }}</span>
                    </div>
                    @endforeach
                    <div class="d-flex justify-content-between py-2 align-items-center">
                        <span style="font-size:13px;color:var(--crm-text-muted);">{{ __('حالة الطلب') }}</span>
                        @php
                            $dotClass = match($booking->status) {
                                'new','pending'  => 'planned',
                                'in_progress'    => 'waiting',
                                'sold','done'    => 'done',
                                'rejected'       => 'late',
                                default          => 'confirmed',
                            };
                        @endphp
                        <span class="status-dot {{ $dotClass }}">{{ $booking->status_label }}</span>
                    </div>
                    
                    {{-- تعيين مسؤول المبيعات --}}
                    <div class="mt-3 p-3 rounded-3" style="background:#F8F9FC;border:1px solid var(--crm-border);">
                        <label style="font-size:12px;font-weight:700;margin-bottom:8px;display:block;">{{ __('مسؤول المبيعات') }}</label>
                        <form action="{{ route('crm.bookings.assign', $booking) }}" method="POST" class="d-flex align-items-center gap-2 w-100">
                            @csrf @method('PATCH')
                            <select name="employee_id" class="form-select form-select-sm border-0 shadow-none" style="background:#fff;border-radius:8px;font-size:13px;font-weight:700;">
                                <option value="">{{ __('غير معين') }}</option>
                                @foreach($employees as $emp)
                                <option value="{{ $emp->id }}" {{ $booking->assigned_to == $emp->id ? 'selected' : '' }}>{{ $emp->name }}</option>
                                @endforeach
                            </select>
                            <button type="submit" class="btn btn-sm fw-bold rounded-2 text-white flex-shrink-0" style="background:var(--crm-text);font-size:12px;white-space:nowrap;padding: 6px 12px;">
                                {{ __('تحويل') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        {{-- تفاصيل الدفع --}}
        <div class="col-12 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 h-100" style="border:1px solid var(--crm-border)!important;">
                <div class="card-header bg-white border-0 px-4 pt-4 pb-3" style="border-bottom:1px solid var(--crm-border)!important;">
                    <h6 class="fw-bold mb-0">{{ __('تفاصيل الدفع') }}</h6>
                </div>
                <div class="card-body px-4 py-3">
                    @php
                        $commission = $booking->monthly_installment * 0.035;
                        $delivery   = 125;
                        $total      = $booking->monthly_installment + $commission + $delivery;
                    @endphp
                    <div class="d-flex justify-content-between py-2" style="border-bottom:1px solid var(--crm-border);">
                        <span style="font-size:13px;color:var(--crm-text-muted);">{{ __('إجمالي القسط') }}</span>
                        <span style="font-size:13px;font-weight:700;">{{ number_format($booking->monthly_installment) }} {!! __('ريال') !!}</span>
                    </div>
                    <div class="d-flex justify-content-between py-2" style="border-bottom:1px solid var(--crm-border);">
                        <span style="font-size:13px;color:var(--crm-text-muted);">{{ __('عمولة البنك') }} (3.5%)</span>
                        <span style="font-size:13px;font-weight:700;">{{ number_format($commission) }} {!! __('ريال') !!}</span>
                    </div>
                    <div class="d-flex justify-content-between py-2" style="border-bottom:1px solid var(--crm-border);">
                        <span style="font-size:13px;color:var(--crm-text-muted);">{{ __('رسوم التوصيل') }}</span>
                        <span style="font-size:13px;font-weight:700;">{{ number_format($delivery) }} {!! __('ريال') !!}</span>
                    </div>
                    <div class="d-flex justify-content-between py-3">
                        <span style="font-size:14px;font-weight:800;color:var(--crm-text);">{{ __('الإجمالي') }}</span>
                        <span style="font-size:14px;font-weight:900;color:var(--crm-red);">{{ number_format($total) }} {!! __('ريال') !!}</span>
                    </div>

                    {{-- حالة الطلب + تقرير --}}
                    <div class="mt-3 p-3 rounded-3" style="background:#F8F9FC;border:1px solid var(--crm-border);">
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <form action="{{ route('crm.bookings.status', $booking) }}" method="POST" class="d-flex align-items-center gap-2 w-100">
                                @csrf @method('PATCH')
                                <select name="status" class="form-select form-select-sm border-0 shadow-none" style="background:#fff;border-radius:8px;font-size:13px;font-weight:700;">
                                    @foreach($statuses as $key => $s)
                                    <option value="{{ $key }}" {{ $booking->status === $key ? 'selected' : '' }}>{{ $s['label'] }}</option>
                                    @endforeach
                                </select>
                                <button type="submit" class="btn btn-sm fw-bold rounded-2 text-white flex-shrink-0" style="background:var(--crm-red);font-size:12px;white-space:nowrap;">
                                    {{ __('تقرير الإجابة') }}
                                </button>
                            </form>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span style="font-size:12px;color:var(--crm-text-muted);">{{ __('فئة الراتب') }}</span>
                            <span style="font-size:12px;font-weight:700;">{{ __('أكثر من') }} 2,000 {!! __('ريال') !!}</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span style="font-size:12px;color:var(--crm-text-muted);">{{ __('فئة الديون') }}</span>
                            <span style="font-size:12px;font-weight:700;">{{ __('أكثر من') }} 2,000 {!! __('ريال') !!}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- تفاصيل السيارة --}}
    @if($booking->car)
    <div class="card border-0 shadow-sm rounded-4 mb-3" style="border:1px solid var(--crm-border)!important;">
        <div class="card-header bg-white border-0 px-4 pt-4 pb-3" style="border-bottom:1px solid var(--crm-border)!important;">
            <h6 class="fw-bold mb-0">{{ __('تفاصيل السيارة') }}</h6>
        </div>
        <div class="card-body px-4 py-3">
            <div class="row g-0">
                <div class="col-6 col-md-3 py-2" style="border-{{ app()->getLocale()=='ar'?'left':'right' }}:1px solid var(--crm-border);">
                    <div style="font-size:12px;color:var(--crm-text-muted);margin-bottom:4px;">{{ __('كود السيارة') }}</div>
                    <div style="font-size:13px;font-weight:700;">#{{ $booking->car->id }}</div>
                </div>
                <div class="col-6 col-md-3 py-2 px-3" style="border-{{ app()->getLocale()=='ar'?'left':'right' }}:1px solid var(--crm-border);">
                    <div style="font-size:12px;color:var(--crm-text-muted);margin-bottom:4px;">{{ __('نوع السيارة') }}</div>
                    <div style="font-size:13px;font-weight:700;">{{ $booking->car->brand->name ?? '' }} {{ $booking->car->name }}</div>
                </div>
                <div class="col-6 col-md-3 py-2 px-3" style="border-{{ app()->getLocale()=='ar'?'left':'right' }}:1px solid var(--crm-border);">
                    <div style="font-size:12px;color:var(--crm-text-muted);margin-bottom:4px;">{{ __('اللون المطلوب') }}</div>
                    <div style="font-size:13px;font-weight:700;">{{ $booking->car->color ?? __('أحمر') }}</div>
                </div>
                <div class="col-6 col-md-3 py-2 px-3">
                    <div style="font-size:12px;color:var(--crm-text-muted);margin-bottom:4px;">{{ __('سعر السيارة') }}</div>
                    <div style="font-size:13px;font-weight:700;">{{ number_format($booking->car->cash_price) }} {!! __('ريال') !!}</div>
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- المستندات والتصاريح --}}
    <div class="card border-0 shadow-sm rounded-4 mb-3" style="border:1px solid var(--crm-border)!important;">
        <div class="card-header bg-white border-0 px-4 pt-4 pb-3" style="border-bottom:1px solid var(--crm-border)!important;">
            <h6 class="fw-bold mb-0">{{ __('المستندات والتصاريح') }}</h6>
        </div>
        <div class="card-body p-4">
            {{-- نموذج رفع مستند --}}
            <form action="{{ route('crm.bookings.documents.store', $booking) }}" method="POST" enctype="multipart/form-data" class="mb-4 p-3 rounded-3" style="background:#F8F9FC;border:1px solid var(--crm-border);">
                @csrf
                <div class="row g-2 align-items-end">
                    <div class="col-md-5">
                        <label class="fw-bold mb-1" style="font-size:12px;">{{ __('اسم المستند (اختياري)') }}</label>
                        <input type="text" name="title" class="form-control form-control-sm" placeholder="{{ __('مثال: الهوية الوطنية، تصريح المرور...') }}" style="border-radius:8px;font-size:13px;padding:8px 12px;">
                    </div>
                    <div class="col-md-5">
                        <label class="fw-bold mb-1" style="font-size:12px;">{{ __('الملف') }}</label>
                        <input type="file" name="file" class="form-control form-control-sm" required style="border-radius:8px;font-size:13px;padding:8px 12px;">
                    </div>
                    <div class="col-md-2">
                        @can('manage-bookings')
                        <button type="submit" class="btn-crm-primary w-100" style="padding:8px 16px;">
                            <i class="bi bi-upload"></i> {{ __('رفع') }}
                        </button>
                        @endcan
                    </div>
                </div>
            </form>

            {{-- قائمة المستندات --}}
            @if($booking->documents && $booking->documents->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" style="border:1px solid var(--crm-border);border-radius:8px;overflow:hidden;">
                    <thead style="background:#F8F9FC;">
                        <tr>
                            <th class="py-2 px-3 text-muted fw-bold" style="font-size:12px;border-bottom:1px solid var(--crm-border);">{{ __('المستند') }}</th>
                            <th class="py-2 px-3 text-muted fw-bold" style="font-size:12px;border-bottom:1px solid var(--crm-border);">{{ __('بواسطة') }}</th>
                            <th class="py-2 px-3 text-muted fw-bold" style="font-size:12px;border-bottom:1px solid var(--crm-border);">{{ __('التاريخ') }}</th>
                            <th class="py-2 px-3 text-muted fw-bold text-end" style="font-size:12px;border-bottom:1px solid var(--crm-border);">{{ __('إجراء') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($booking->documents as $doc)
                        <tr>
                            <td class="px-3">
                                <div class="d-flex align-items-center gap-2">
                                    <div style="width:36px;height:36px;background:#F1F5F9;border-radius:8px;display:flex;align-items:center;justify-content:center;color:#475467;">
                                        @if(in_array(strtolower($doc->file_type), ['png','jpg','jpeg','gif']))
                                            <i class="bi bi-file-image fs-5"></i>
                                        @elseif(strtolower($doc->file_type) == 'pdf')
                                            <i class="bi bi-file-pdf fs-5" style="color:var(--crm-red);"></i>
                                        @else
                                            <i class="bi bi-file-earmark fs-5"></i>
                                        @endif
                                    </div>
                                    <div>
                                        <div class="fw-bold" style="font-size:13px;color:var(--crm-text);">{{ $doc->title }}</div>
                                        <div style="font-size:11px;color:var(--crm-text-muted);">.{{ strtoupper($doc->file_type) }}</div>
                                    </div>
                                </div>
                            </td>
                            <td style="font-size:12px;color:var(--crm-text-muted);">{{ $doc->employee->name ?? __('النظام') }}</td>
                            <td style="font-size:12px;color:var(--crm-text-muted);">{{ $doc->created_at->format('Y-m-d H:i') }}</td>
                            <td class="text-end px-3">
                                <div class="d-flex gap-1 justify-content-end">
                                    <a href="{{ asset('storage/'.$doc->file_path) }}" target="_blank" class="btn btn-sm btn-light rounded-2 text-primary" title="{{ __('عرض') }}">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    @can('manage-bookings')
                                    <form action="{{ route('crm.bookings.documents.destroy', $doc) }}" method="POST" onsubmit="return confirm('{{ __('هل تريد حذف هذا المستند؟') }}')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-light rounded-2" style="color:var(--crm-red);" title="{{ __('حذف') }}">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="text-center py-4 opacity-50">
                <i class="bi bi-folder-x fs-1 d-block mb-2"></i>
                <p class="mb-0 small">{{ __('لا توجد مستندات مرفوعة بعد') }}</p>
            </div>
            @endif
        </div>
    </div>

    {{-- سجل المتابعة --}}
    <div class="card border-0 shadow-sm rounded-4" style="border:1px solid var(--crm-border)!important;">
        <div class="card-header bg-white border-0 px-4 pt-4 pb-3" style="border-bottom:1px solid var(--crm-border)!important;">
            <h6 class="fw-bold mb-0">{{ __('سجل المتابعة') }}</h6>
        </div>
        <div class="card-body p-4">
            {{-- إضافة ملاحظة --}}
            @can('manage-bookings')
            <form action="{{ route('crm.bookings.note', $booking) }}" method="POST" class="mb-4 p-3 rounded-3" style="background:#F8F9FC;border:1px solid var(--crm-border);">
                @csrf
                <div class="d-flex gap-2 align-items-end">
                    <div class="flex-grow-1">
                        <label class="fw-bold mb-1" style="font-size:12px;">{{ __('إضافة تحديث جديد') }}</label>
                        <textarea name="note" rows="2" required placeholder="{{ __('اكتب ملاحظة...') }}"
                                  style="width:100%;border:1px solid var(--crm-border);border-radius:8px;padding:10px 14px;font-size:13px;font-family:'Cairo',sans-serif;outline:none;resize:none;"></textarea>
                    </div>
                    <div>
                        <select name="type" style="border:1px solid var(--crm-border);border-radius:8px;padding:9px 12px;font-size:13px;outline:none;font-family:'Cairo',sans-serif;margin-bottom:4px;display:block;">
                            <option value="note">📌 {{ __('ملاحظة') }}</option>
                            <option value="call">📞 {{ __('مكالمة') }}</option>
                        </select>
                        <button type="submit" class="btn-crm-primary w-100" style="padding:9px 16px;">{{ __('إضافة') }}</button>
                    </div>
                </div>
            </form>
            @endcan

            {{-- Timeline --}}
            <div style="position:relative;padding-{{ app()->getLocale()=='ar'?'right':'left' }}:20px;border-{{ app()->getLocale()=='ar'?'right':'left' }}:2px solid var(--crm-border);">
                @forelse($booking->notes_list as $note)
                <div class="d-flex gap-3 mb-4 position-relative">
                    <div class="position-absolute" style="{{ app()->getLocale()=='ar'?'right':'left' }}:-9px;top:4px;width:16px;height:16px;border-radius:50%;background:#fff;border:2px solid {{ $note->type === 'call' ? '#12B76A' : ($note->type === 'status_change' ? '#2E90FA' : 'var(--crm-red)') }};"></div>
                    <div class="flex-grow-1">
                        <div class="p-3 rounded-3 border" style="background:#fff;border-color:var(--crm-border)!important;">
                            <p class="mb-2" style="font-size:13px;font-weight:600;color:var(--crm-text);">{{ $note->note }}</p>
                            <div class="d-flex align-items-center gap-2">
                                <span class="badge bg-light text-dark border" style="font-size:11px;font-weight:600;">{{ $note->employee->name ?? __('النظام') }}</span>
                                <span style="font-size:11px;color:var(--crm-text-muted);"><i class="bi bi-clock me-1"></i>{{ $note->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="text-center py-5 opacity-50">
                    <i class="bi bi-chat-left-dots fs-1 d-block mb-2"></i>
                    <p class="mb-0 small">{{ __('لا توجد ملاحظات بعد') }}</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>

</div>
@endsection

@section('scripts')
<script>
window.onbeforeprint = () => document.title = 'طلب #{{ $booking->id }} — GR Motors';
</script>
@endsection
