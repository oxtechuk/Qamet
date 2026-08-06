@extends('partials.Layouts.crm-master')
@section('title', __('العملاء') . ' | Qemt Najd')

@section('content')
<div class="container-fluid" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">

    {{-- Breadcrumb --}}
    <nav class="crm-breadcrumb">
        <a href="{{ route('crm.dashboard') }}">{{ __('الرئيسية') }}</a>
        <span class="sep">›</span>
        <span>{{ __('إدارة العملاء') }}</span>
        <span class="sep">›</span>
        <span class="current">{{ __('العملاء') }}</span>
    </nav>

    {{-- Header --}}
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h5 class="fw-bold mb-0">{{ __('العملاء') }}</h5>
        @can('manage-leads')
        <a href="{{ route('crm.leads.create') }}" class="btn-crm-primary">
            <i class="bi bi-person-plus"></i> {{ __('إضافة عميل') }}
        </a>
        @endcan
    </div>

    {{-- Stat Cards --}}
    <div class="row g-3 mb-4">
        <div class="col-6 col-xl-4">
            <div class="crm-stat-new">
                <span class="stat-badge orange">65%</span>
                <div class="stat-icon green"><i class="bi bi-person-check"></i></div>
                <div class="stat-lbl">{{ __('العملاء النشطون') }}</div>
                <div class="stat-val">76%</div>
            </div>
        </div>
        <div class="col-6 col-xl-4">
            <div class="crm-stat-new">
                <span class="stat-badge green">+3%</span>
                <div class="stat-icon blue"><i class="bi bi-people"></i></div>
                <div class="stat-lbl">{{ __('العملاء الجدد') }}</div>
                <div class="stat-val">{{ number_format($leads->total()) }}</div>
            </div>
        </div>
        <div class="col-6 col-xl-4">
            <div class="crm-stat-new">
                <span class="stat-badge green">+12%</span>
                <div class="stat-icon purple"><i class="bi bi-person-lines-fill"></i></div>
                <div class="stat-lbl">{{ __('عدد العملاء') }}</div>
                <div class="stat-val">{{ number_format($leads->total()) }}</div>
            </div>
        </div>
    </div>

    {{-- Filter Tabs + Search --}}
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-3">
        <div class="crm-filter-tabs mb-0">
            <a href="{{ route('crm.leads.index') }}"
               class="crm-filter-tab {{ !request('status') ? 'active' : '' }}">{{ __('الكل') }}</a>
            @foreach($statuses as $key => $s)
            <a href="{{ route('crm.leads.index', ['status' => $key]) }}"
               class="crm-filter-tab {{ request('status') === $key ? 'active' : '' }}">{{ $s['label'] }}</a>
            @endforeach
        </div>
        <form method="GET" class="d-flex gap-2 align-items-center">
            <div style="position:relative;">
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="{{ __('بحث ببيانات العميل') }}"
                    style="border:1px solid var(--crm-border);border-radius:8px;padding:8px 36px 8px 14px;font-size:13px;outline:none;font-family:'Cairo',sans-serif;width:220px;">
                <i class="bi bi-search" style="position:absolute;{{ app()->getLocale()=='ar'?'left':'right' }}:12px;top:50%;transform:translateY(-50%);color:var(--crm-text-muted);"></i>
            </div>
            <button type="submit" class="btn-crm-primary" style="padding:8px 16px;">{{ __('بحث') }}</button>
        </form>
    </div>



    {{-- Table --}}
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden" style="border:1px solid var(--crm-border)!important;">
        <div class="card-header bg-white border-0 px-4 py-3" style="border-bottom:1px solid var(--crm-border)!important;">
            <h6 class="fw-bold mb-0">{{ __('العملاء') }}</h6>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead style="background:#F8F9FC;">
                    <tr>
                        <th class="px-4 py-3 text-muted fw-bold" style="font-size:12px;width:40px;">
                            <input type="checkbox" id="selectAllLeads" class="form-check-input">
                        </th>
                        <th class="px-4 py-3 text-muted fw-bold" style="font-size:12px;">{{ __('رقم العميل') }}</th>
                        <th class="py-3 text-muted fw-bold" style="font-size:12px;">{{ __('اسم العميل') }}</th>
                        <th class="py-3 text-muted fw-bold" style="font-size:12px;">{{ __('الهاتف') }}</th>
                        <th class="py-3 text-muted fw-bold text-center" style="font-size:12px;">{{ __('عدد الطلبات') }}</th>
                        <th class="py-3 text-muted fw-bold" style="font-size:12px;">{{ __('نوع السيارات') }}</th>
                        <th class="py-3 text-muted fw-bold" style="font-size:12px;">{{ __('فئة الديون') }}</th>
                        <th class="py-3 text-muted fw-bold" style="font-size:12px;">{{ __('ميعاد طلب') }}</th>
                        <th class="py-3 text-muted fw-bold" style="font-size:12px;">{{ __('الحالة') }}</th>
                        <th class="py-3 text-muted fw-bold" style="font-size:12px;">{{ __('الإجراءات') }}</th>
                    </tr>
                </thead>
                <tbody class="border-top-0">
                    @forelse($leads as $lead)
                    <tr>
                        <td class="px-4">
                            <input type="checkbox" name="lead_ids[]" value="{{ $lead->id }}"
                                   class="form-check-input lead-checkbox"
                                   {{ $lead->client_phone ? '' : 'disabled' }}>
                        </td>
                        <td class="px-4 fw-bold" style="font-size:13px;">#{{ $lead->id }}</td>
                        <td>
                            <div class="fw-bold" style="font-size:13px;color:var(--crm-text);">{{ $lead->client_name }}</div>
                        </td>
                        <td style="font-size:13px;" dir="ltr">{{ $lead->client_phone ?? '—' }}</td>
                        <td class="text-center fw-bold" style="font-size:13px;">{{$lead->orders()->count()}}</td>
                        <td style="font-size:12px;color:var(--crm-text-muted);">
                            {{ $lead->car?->name ?? '—' }}
                            @if($lead->car)
                            <br><small>{{ $lead->car->brand?->name }}</small>
                            @endif
                        </td>
                        <td>
                            <span class="status-dot planned">{{ __('اقتصادية') }}</span>
                        </td>
                        <td style="font-size:12px;color:var(--crm-text-muted);">
                            {{ $lead->started_at?->format('d/m/Y') ?? '—' }}
                        </td>
                        <td>
                            @php
                                $dotClass = match($lead->status) {
                                    'new'         => 'confirmed',
                                    'in_progress' => 'planned',
                                    'waiting'     => 'waiting',
                                    'sold'        => 'done',
                                    'rejected'    => 'late',
                                    default       => 'cancelled',
                                };
                            @endphp
                            <span class="status-dot {{ $dotClass }}">{{ $lead->status_label }}</span>
                        </td>
                        <td>
                            <div class="d-flex gap-2 align-items-center">
                                <a href="{{ route('crm.leads.show', $lead) }}" class="btn btn-sm btn-light rounded-2" title="{{ __('عرض') }}">
                                    <i class="bi bi-eye" style="font-size:14px;"></i>
                                </a>
                                @can('manage-leads')
                                <a href="{{ route('crm.leads.edit', $lead) }}" class="btn btn-sm btn-light rounded-2" title="{{ __('تعديل') }}">
                                    <i class="bi bi-pencil" style="font-size:14px;"></i>
                                </a>
                                @endcan
                                @can('manage-leads')
                                <form action="{{ route('crm.leads.destroy', $lead) }}" method="POST"
                                      onsubmit="return confirm('{{ __('هل أنت متأكد؟') }}')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-light rounded-2" title="{{ __('حذف') }}"
                                            style="color:var(--crm-red);">
                                        <i class="bi bi-trash" style="font-size:14px;"></i>
                                    </button>
                                </form>
                                @endcan
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10" class="text-center text-muted py-5">
                            <i class="bi bi-person-x fs-1 d-block mb-2 opacity-25"></i>
                            {{ __('لا يوجد عملاء حالياً') }}
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($leads->hasPages())
        <div class="card-footer bg-white border-0 py-3" style="border-top:1px solid var(--crm-border)!important;">
            {{ $leads->links() }}
        </div>
        @endif
    </div>

    {{-- WhatsApp Campaign Floating Button --}}
    <button type="button" id="btnWhatsappCampaign"
            class="btn btn-success rounded-pill shadow-lg d-none align-items-center gap-2"
            style="position:fixed;bottom:30px;{{ app()->getLocale()=='ar'?'left':'right' }}:30px;z-index:1050;padding:12px 24px;font-size:14px;font-weight:600;">
        <i class="bi bi-whatsapp" style="font-size:18px;"></i>
        <span id="selectedCount">0</span> {{ __('إرسال واتساب') }}
    </button>

    {{-- WhatsApp Campaign Modal --}}
    <div class="modal fade" id="whatsappCampaignModal" tabindex="-1" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 border-0 shadow">
                <div class="modal-header border-0 pb-0">
                    <h6 class="modal-title fw-bold">
                        <i class="bi bi-whatsapp text-success"></i> {{ __('حملة واتساب') }}
                    </h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3 p-3 rounded-3" style="background:#F0FFF4;">
                        <small class="text-muted">
                            {{ __('سيتم إرسال الرسالة إلى') }}
                            <strong id="modalSelectedCount">0</strong>
                            {{ __('عميل لديهم أرقام هواتف صالحة') }}
                        </small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">{{ __('الرسالة') }}</label>
                        <textarea id="campaignMessage" class="form-control rounded-3" rows="5"
                                  placeholder="{{ __('اكتب رسالتك هنا... يمكنك استخدام {name} لاسم العميل و {phone} لرقم هاتفه') }}"></textarea>
                    </div>
                    <div class="mb-2">
                        <small class="text-muted">
                            <strong>{{ __('المتغيرات المتاحة:') }}</strong>
                            <code>{name}</code> → {{ __('اسم العميل') }},
                            <code>{phone}</code> → {{ __('رقم الهاتف') }}
                        </small>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-light rounded-3" data-bs-dismiss="modal">{{ __('إلغاء') }}</button>
                    <button type="button" id="btnSendCampaign" class="btn btn-success rounded-3 px-4">
                        <i class="bi bi-send"></i> {{ __('إرسال') }}
                    </button>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const selectAll = document.getElementById('selectAllLeads');
    const checkboxes = document.querySelectorAll('.lead-checkbox');
    const btnCampaign = document.getElementById('btnWhatsappCampaign');
    const countEl = document.getElementById('selectedCount');
    const modalCountEl = document.getElementById('modalSelectedCount');
    const modal = new bootstrap.Modal(document.getElementById('whatsappCampaignModal'));
    const btnSend = document.getElementById('btnSendCampaign');
    const messageInput = document.getElementById('campaignMessage');

    function updateCount() {
        const checked = document.querySelectorAll('.lead-checkbox:checked').length;
        countEl.textContent = checked;
        modalCountEl.textContent = checked;
        if (checked > 0) {
            btnCampaign.classList.remove('d-none');
            btnCampaign.classList.add('d-flex');
        } else {
            btnCampaign.classList.add('d-none');
            btnCampaign.classList.remove('d-flex');
        }
    }

    selectAll.addEventListener('change', function () {
        checkboxes.forEach(cb => {
            if (!cb.disabled) {
                cb.checked = selectAll.checked;
            }
        });
        updateCount();
    });

    checkboxes.forEach(cb => {
        cb.addEventListener('change', updateCount);
    });

    btnCampaign.addEventListener('click', function () {
        const checked = document.querySelectorAll('.lead-checkbox:checked').length;
        if (checked === 0) return;
        modal.show();
    });

    btnSend.addEventListener('click', function () {
        const message = messageInput.value.trim();
        if (!message) {
            messageInput.classList.add('is-invalid');
            return;
        }
        messageInput.classList.remove('is-invalid');

        const leadIds = Array.from(document.querySelectorAll('.lead-checkbox:checked'))
            .map(cb => parseInt(cb.value));

        if (leadIds.length === 0) return;

        btnSend.disabled = true;
        btnSend.innerHTML = '<span class="spinner-border spinner-border-sm"></span> {{ __("جاري الإرسال...") }}';

        fetch('{{ route("crm.leads.whatsapp-campaign") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
            },
            body: JSON.stringify({
                lead_ids: leadIds,
                message: message,
            }),
        })
        .then(res => res.json().then(data => ({ status: res.status, data })))
        .then(({ status, data }) => {
            modal.hide();
            messageInput.value = '';
            selectAll.checked = false;
            checkboxes.forEach(cb => cb.checked = false);
            updateCount();

            if (status >= 200 && status < 300 && data.success) {
                showToast(data.message, 'success');
            } else {
                showToast(data.message || '{{ __("حدث خطأ") }}', 'danger');
            }
        })
        .catch(() => {
            showToast('{{ __("حدث خطأ في الاتصال") }}', 'danger');
        })
        .finally(() => {
            btnSend.disabled = false;
            btnSend.innerHTML = '<i class="bi bi-send"></i> {{ __("إرسال") }}';
        });
    });

    function showToast(message, type) {
        const toast = document.createElement('div');
        toast.className = `alert alert-${type} alert-dismissible fade show position-fixed`;
        toast.style.cssText = 'top:80px;right:20px;z-index:9999;min-width:300px;box-shadow:0 4px 12px rgba(0,0,0,0.15);';
        toast.innerHTML = `${message}<button type="button" class="btn-close" data-bs-dismiss="alert"></button>`;
        document.body.appendChild(toast);
        setTimeout(() => toast.remove(), 5000);
    }
});
</script>
@endsection
