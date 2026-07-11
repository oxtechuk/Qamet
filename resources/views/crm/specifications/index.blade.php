@extends('partials.Layouts.crm-master')
@section('title', __('إدارة المواصفات التقنية') . ' | AutoCRM')

@section('content')
    <div class="container-fluid" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">

        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h4 class="mb-1">{{ __('إدارة المواصفات التقنية') }}</h4>
                <p class="text-muted mb-0">{{ __('إجمالي') }} {{ $specifications->total() }} {{ __('مواصفة') }}</p>
            </div>
            @can('manage-specifications')
            <button class="btn btn-primary rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#addSpecModal">
                <i class="bi bi-plus-circle me-1"></i> {{ __('إضافة مواصفة جديدة') }}
            </button>
            @endcan
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-4">
                <i class="bi bi-check-circle me-1"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="border-0 px-4 py-3" style="width: 80px;">{{ __('الأيقونة') }}</th>
                            <th class="border-0 px-4 py-3">{{ __('الاسم') }}</th>
                            <th class="border-0 px-4 py-3">{{ __('الكود') }}</th>
                            <th class="border-0 px-4 py-3 text-end">{{ __('الإجراءات') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($specifications as $spec)
                            <tr>
                                <td class="px-4 py-3">
                                    <div class="bg-primary-subtle rounded-circle d-flex align-items-center justify-content-center"
                                        style="width:40px;height:40px;">
                                        @if($spec->icon)
                                            <i class="bi {{ $spec->icon }} fs-5 text-primary"></i>
                                        @else
                                            <i class="bi bi-gear-wide-connected fs-5 text-primary"></i>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-4 py-3 fw-bold">{{ $spec->name }}</td>
                                <td class="px-4 py-3 text-muted" dir="ltr"><small>{{ $spec->icon ?? __('افتراضي') }}</small></td>
                                <td class="px-4 py-3 text-end">
                                    @can('manage-specifications')
                                    <button class="btn btn-sm btn-light rounded-3 me-2" data-bs-toggle="modal"
                                        data-bs-target="#editSpec{{ $spec->id }}" title="{{ __('تعديل') }}"><i class="bi bi-pencil-square"></i></button>
                                    @endcan
                                    @can('manage-specifications')
                                    <form action="{{ route('crm.specifications.destroy', $spec) }}" method="POST"
                                        class="d-inline-block" onsubmit="return confirm('{{ __("هل أنت متأكد من حذف هذه المواصفة؟") }}')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger rounded-3" title="{{ __('حذف') }}"><i class="bi bi-trash"></i></button>
                                    </form>
                                    @endcan
                                </td>
                            </tr>

                            {{-- Modal التعديل --}}
                            <div class="modal fade" id="editSpec{{ $spec->id }}" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content border-0 shadow-lg rounded-4">
                                        <div class="modal-header border-0">
                                            <h5 class="modal-title fw-bold">{{ __('تعديل المواصفة') }}</h5>
                                            <button type="button" class="btn-close {{ app()->getLocale() == 'ar' ? 'ms-0 me-auto' : '' }}" data-bs-dismiss="modal"></button>
                                        </div>
                                        <form action="{{ route('crm.specifications.update', $spec) }}" method="POST">
                                            @csrf @method('PUT')
                                            <div class="modal-body text-start">
                                                <ul class="nav nav-pills nav-fill bg-light p-1 rounded-pill mb-3" role="tablist">
                                                    <li class="nav-item">
                                                        <button class="nav-link active rounded-pill py-1" data-bs-toggle="tab" data-bs-target="#edit-ar-spec-{{ $spec->id }}" type="button">{{ __('العربية') }}</button>
                                                    </li>
                                                    <li class="nav-item">
                                                        <button class="nav-link rounded-pill py-1" data-bs-toggle="tab" data-bs-target="#edit-en-spec-{{ $spec->id }}" type="button">{{ __('الإنجليزية') }}</button>
                                                    </li>
                                                </ul>

                                                <div class="tab-content mb-3">
                                                    <div class="tab-pane fade show active" id="edit-ar-spec-{{ $spec->id }}">
                                                        <label class="form-label fw-semibold">{{ __('اسم المواصفة (بالعربية)') }} <span class="text-danger">*</span></label>
                                                        <input type="text" name="name[ar]" class="form-control rounded-3"
                                                            value="{{ $spec->getTranslation('name', 'ar', false) ?? '' }}" required>
                                                    </div>
                                                    <div class="tab-pane fade" id="edit-en-spec-{{ $spec->id }}">
                                                        <label class="form-label fw-semibold">{{ __('اسم المواصفة (بالإنجليزية)') }} <span class="text-danger">*</span></label>
                                                        <input type="text" name="name[en]" class="form-control rounded-3"
                                                            value="{{ $spec->getTranslation('name', 'en', false) ?? '' }}" required>
                                                    </div>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label fw-semibold">{{ __('أيقونة المواصفة (Bootstrap Icons)') }}</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text bg-light"><i class="bi {{ $spec->icon ?: 'bi-gear' }} icon-preview-{{ $spec->id }}"></i></span>
                                                        <input type="text" name="icon" id="icon-input-{{ $spec->id }}" class="form-control" placeholder="{{ __('مثال: bi-speedometer') }}"
                                                            value="{{ $spec->icon }}">
                                                        <button type="button" class="btn btn-outline-primary" onclick="openIconPicker('icon-input-{{ $spec->id }}', 'icon-preview-{{ $spec->id }}')">
                                                            <i class="bi bi-grid-3x3-gap"></i> {{ __('اختر') }}
                                                        </button>
                                                    </div>
                                                    <small class="text-muted">{{ __('استخدم أكواد Bootstrap Icons (مثل: bi-fuel-pump)') }}</small>
                                                </div>
                                            </div>
                                            <div class="modal-footer border-0 pt-0">
                                                <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">{{ __('إلغاء') }}</button>
                                                <button type="submit" class="btn btn-primary rounded-pill px-4">{{ __('حفظ') }}</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <tr>
                                <td colspan="4">
                                    <div class="text-center py-5 text-muted bg-white rounded-4">
                                        <i class="bi bi-gear fs-1 d-block mb-3 text-light"></i>
                                        <p class="mb-0">{{ __('لا توجد مواصفات تقنية مسجلة حالياً') }}</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-4 d-flex justify-content-center">{{ $specifications->links() }}</div>

        {{-- Modal الإضافة --}}
        <div class="modal fade" id="addSpecModal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 shadow-lg rounded-4">
                    <div class="modal-header border-0">
                        <h5 class="modal-title fw-bold">{{ __('إضافة مواصفة جديدة') }}</h5>
                        <button type="button" class="btn-close {{ app()->getLocale() == 'ar' ? 'ms-0 me-auto' : '' }}" data-bs-dismiss="modal"></button>
                    </div>
                    <form action="{{ route('crm.specifications.store') }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <ul class="nav nav-pills nav-fill bg-light p-1 rounded-pill mb-3" role="tablist">
                                <li class="nav-item">
                                    <button class="nav-link active rounded-pill py-1" data-bs-toggle="tab" data-bs-target="#add-ar-spec" type="button">{{ __('العربية') }}</button>
                                </li>
                                <li class="nav-item">
                                    <button class="nav-link rounded-pill py-1" data-bs-toggle="tab" data-bs-target="#add-en-spec" type="button">{{ __('الإنجليزية') }}</button>
                                </li>
                            </ul>

                            <div class="tab-content mb-3">
                                <div class="tab-pane fade show active" id="add-ar-spec">
                                    <label class="form-label fw-semibold">{{ __('اسم المواصفة (بالعربية)') }} <span class="text-danger">*</span></label>
                                    <input type="text" name="name[ar]" class="form-control rounded-3" placeholder="{{ __('مثال: فتحة سقف') }}" required>
                                </div>
                                <div class="tab-pane fade" id="add-en-spec">
                                    <label class="form-label fw-semibold">{{ __('اسم المواصفة (بالإنجليزية)') }} <span class="text-danger">*</span></label>
                                    <input type="text" name="name[en]" class="form-control rounded-3" placeholder="{{ __('e.g., Sunroof') }}" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">{{ __('أيقونة المواصفة (Bootstrap Icons)') }}</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="bi bi-gear icon-preview-add"></i></span>
                                    <input type="text" name="icon" id="icon-input-add" class="form-control" placeholder="{{ __('مثال: bi-speedometer') }}">
                                    <button type="button" class="btn btn-outline-primary" onclick="openIconPicker('icon-input-add', 'icon-preview-add')">
                                        <i class="bi bi-grid-3x3-gap"></i> {{ __('اختر') }}
                                    </button>
                                </div>
                                <small class="text-muted">{{ __('استخدم أكواد Bootstrap Icons (مثل: bi-fuel-pump)') }}</small>
                            </div>
                        </div>
                        <div class="modal-footer border-0 pt-0">
                            <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">{{ __('إلغاء') }}</button>
                            <button type="submit" class="btn btn-primary rounded-pill px-4">{{ __('إضافة') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Icon Picker Modal --}}
    <div class="modal fade" id="iconPickerModal" tabindex="-1" style="z-index: 2000;">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0 shadow-lg rounded-4">
                <div class="modal-header border-0 bg-light rounded-top-4">
                    <h5 class="modal-title fw-bold"><i class="bi bi-grid-3x3-gap me-2"></i>{{ __('اختر أيقونة') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="input-group mb-4 shadow-sm rounded-pill overflow-hidden border">
                        <span class="input-group-text bg-white border-0"><i class="bi bi-search text-muted"></i></span>
                        <input type="text" id="iconSearchInput" class="form-control border-0 bg-white" placeholder="{{ __('ابحث عن أيقونة...') }}" style="box-shadow: none;">
                    </div>
                    
                    <div class="icon-grid" id="iconGrid">
                        {{-- Icons will be rendered here --}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .transition-hover { transition: transform 0.2s ease-in-out; }
        .transition-hover:hover { transform: translateY(-5px); }

        .icon-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(80px, 1fr));
            gap: 15px;
            max-height: 400px;
            overflow-y: auto;
            padding: 5px;
        }
        .icon-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 15px 10px;
            background: #fff;
            border: 1px solid #eee;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.2s;
        }
        .icon-item:hover {
            background: var(--crm-red-light);
            border-color: var(--crm-red);
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        }
        .icon-item i {
            font-size: 1.5rem;
            margin-bottom: 8px;
            color: #444;
        }
        .icon-item span {
            font-size: 10px;
            color: #888;
            text-align: center;
            word-break: break-all;
        }
        .icon-item:hover i { color: var(--crm-red); }
    </style>
@endsection

@section('scripts')
<script>
    const commonIcons = [
        'bi-speedometer', 'bi-speedometer2', 'bi-fuel-pump', 'bi-fuel-pump-diesel', 'bi-gear-wide-connected', 
        'bi-people', 'bi-person', 'bi-snow', 'bi-lightning-charge', 'bi-shield-check', 
        'bi-palette', 'bi-calendar-event', 'bi-tags', 'bi-car-front', 'bi-door-closed', 
        'bi-soundwave', 'bi-pci-card', 'bi-camera-video', 'bi-key', 'bi-joystick', 
        'bi-wind', 'bi-tools', 'bi-map', 'bi-bluetooth', 'bi-usb-drive', 
        'bi-ev-station', 'bi-battery-full', 'bi-thermometer-half', 'bi-brightness-high', 'bi-water', 
        'bi-fan', 'bi-activity', 'bi-check-circle', 'bi-star', 'bi-lightning', 
        'bi-shield-shaded', 'bi-hdd-network', 'bi-cpu', 'bi-music-note-beamed', 'bi-broadcast',
        'bi-geo-alt', 'bi-telephone', 'bi-envelope', 'bi-whatsapp', 'bi-facebook',
        'bi-instagram', 'bi-tiktok', 'bi-twitter-x', 'bi-youtube', 'bi-link-45deg',
        'bi-info-circle', 'bi-exclamation-triangle', 'bi-patch-check', 'bi-award', 'bi-gem',
        'bi-plugin', 'bi-plug', 'bi-outlet', 'bi-display', 'bi-tablet',
        'bi-phone', 'bi-smartwatch', 'bi-headset', 'bi-mic', 'bi-speaker'
    ];

    let currentInputId = '';
    let currentPreviewId = '';
    const iconModal = new bootstrap.Modal(document.getElementById('iconPickerModal'));
    const iconGrid = document.getElementById('iconGrid');
    const iconSearch = document.getElementById('iconSearchInput');

    function renderIcons(filter = '') {
        iconGrid.innerHTML = '';
        const filtered = commonIcons.filter(icon => icon.includes(filter.toLowerCase()));
        
        filtered.forEach(icon => {
            const div = document.createElement('div');
            div.className = 'icon-item';
            div.innerHTML = `<i class="bi ${icon}"></i><span>${icon.replace('bi-', '')}</span>`;
            div.onclick = () => selectIcon(icon);
            iconGrid.appendChild(div);
        });

        if (filtered.length === 0) {
            iconGrid.innerHTML = `<div class="col-12 text-center py-5 text-muted">{{ __('لا توجد نتائج مطابقة...') }}</div>`;
        }
    }

    function openIconPicker(inputId, previewId) {
        currentInputId = inputId;
        currentPreviewId = previewId;
        iconSearch.value = '';
        renderIcons();
        iconModal.show();
    }

    function selectIcon(icon) {
        document.getElementById(currentInputId).value = icon;
        const previews = document.querySelectorAll('.' + currentPreviewId);
        previews.forEach(p => {
            p.className = `bi ${icon} ${currentPreviewId}`;
        });
        iconModal.hide();
    }

    iconSearch.addEventListener('input', (e) => {
        renderIcons(e.target.value);
    });

    // Initialize if needed
    document.addEventListener('DOMContentLoaded', () => {
        renderIcons();
    });
</script>
@endsection
