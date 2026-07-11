@extends('partials.Layouts.crm-master')
@section('title', __('إعدادات الحاسبة') . ' | AutoCRM')

@php
    use App\Models\CalculatorFactor;
    $typeLabels = [
        CalculatorFactor::TYPE_GENDER => __('الجنس'),
        CalculatorFactor::TYPE_AGE_BAND => __('العمر (شرائح)'),
        CalculatorFactor::TYPE_SALARY_BAND => __('الراتب (شرائح)'),
        CalculatorFactor::TYPE_EMPLOYMENT => __('نوع العمل'),
    ];
@endphp

@section('content')
    <div class="container-fluid" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">

        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h4 class="mb-1 fw-bold"> {{ __('إعدادات حاسبة التقسيط') }}</h4>
                <p class="text-muted mb-0 small">{{ __('إدارة البنوك ونسب الفائدة وعوامل التسعير الديناميكية') }}</p>
            </div>
            @can('manage-calculator-settings')
            <button class="btn btn-primary rounded-pill px-4 shadow-sm fw-bold" data-bs-toggle="modal" data-bs-target="#addBankModal">
                <i class="bi bi-bank me-1"></i> {{ __('إضافة بنك جديد') }}
            </button>
            @endcan
        </div>

        

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-4 mb-4">
                <ul class="mb-0 small fw-bold">
                    @foreach ($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- البنوك --}}
        <div class="card border-0 shadow-sm mb-5 rounded-4 overflow-hidden">
            <div class="card-header bg-white border-0 pt-4 px-4">
                <h5 class="mb-0 fw-bold"><i class="bi bi-buildings text-primary me-2"></i> {{ __('البنوك ونسب الفائدة الأساسية') }}</h5>
            </div>
            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                    <thead class="bg-light">
                        <tr>
                            <th class="px-4 py-3 text-muted fw-bold">{{ __('البنك') }}</th>
                            <th class="py-3 text-muted fw-bold">{{ __('الفائدة السنوية %') }}</th>
                            <th class="py-3 text-muted fw-bold text-center">{{ __('الترتيب') }}</th>
                            <th class="py-3 text-muted fw-bold text-center">{{ __('الحالة') }}</th>
                            <th class="py-3 text-end px-4"></th>
                        </tr>
                    </thead>
                    <tbody class="border-top-0">
                        @forelse ($banks as $bank)
                            <tr>
                                <td class="px-4 fw-bold text-dark">{{ $bank->name }}</td>
                                <td class="fw-bold text-primary">{{ number_format($bank->annual_rate, 2) }}%</td>
                                <td class="text-center"><span class="badge bg-light text-dark border px-2">{{ $bank->sort_order }}</span></td>
                                <td class="text-center">
                                    @if ($bank->is_active)
                                        <span class="badge bg-success-subtle text-success px-3 py-2 rounded-pill small fw-bold">{{ __('نشط') }}</span>
                                    @else
                                        <span class="badge bg-secondary-subtle text-secondary px-3 py-2 rounded-pill small fw-bold">{{ __('متوقف') }}</span>
                                    @endif
                                </td>
                                <td class="text-end px-4">
                                    <div class="d-flex gap-2 justify-content-end">
                                        @can('manage-calculator-settings')
                                        <button class="btn btn-sm btn-white border shadow-xs rounded-2" data-bs-toggle="modal"
                                            data-bs-target="#editBankModal{{ $bank->id }}"><i class="bi bi-pencil-square"></i></button>
                                        @endcan
                                        @can('manage-calculator-settings')
                                        <form action="{{ route('crm.calculator.banks.destroy', $bank) }}" method="POST"
                                            onsubmit="return confirm('{{ __('هل أنت متأكد من حذف هذا البنك؟') }}')">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-sm btn-danger-subtle text-danger rounded-2 shadow-xs"><i class="bi bi-trash"></i></button>
                                        </form>
                                        @endcan
                                    </div>
                                </td>
                            </tr>

                            {{-- Edit Bank Modal --}}
                            <div class="modal fade" id="editBankModal{{ $bank->id }}" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content border-0 shadow rounded-4">
                                        <div class="modal-header border-0 pt-4 px-4">
                                            <h5 class="modal-title fw-bold">{{ __('تعديل بيانات البنك') }}</h5>
                                            <button type="button" class="btn-close {{ app()->getLocale() == 'ar' ? 'ms-0 me-auto' : '' }}" data-bs-dismiss="modal"></button>
                                        </div>
                                        <form action="{{ route('crm.calculator.banks.update', $bank) }}" method="POST">
                                            @csrf @method('PUT')
                                            <div class="modal-body p-4 pt-2">
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold small text-muted">{{ __('اسم البنك') }}</label>
                                                    <input type="text" name="name" class="form-control bg-light border-0 shadow-none" value="{{ $bank->name }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold small text-muted">{{ __('نسبة الفائدة السنوية %') }}</label>
                                                    <input type="number" name="annual_rate" step="0.01" min="0" max="100" class="form-control bg-light border-0 shadow-none" value="{{ $bank->annual_rate }}" required>
                                                </div>
                                                <div class="mb-4">
                                                    <label class="form-label fw-bold small text-muted">{{ __('ترتيب العرض') }}</label>
                                                    <input type="number" name="sort_order" class="form-control bg-light border-0 shadow-none" value="{{ $bank->sort_order }}">
                                                </div>
                                                <div class="form-check form-switch p-3 bg-light rounded-3">
                                                    <input class="form-check-input {{ app()->getLocale() == 'ar' ? 'ms-0 me-2 float-none' : '' }}" type="checkbox" name="is_active" value="1" id="bankAct{{ $bank->id }}" {{ $bank->is_active ? 'checked' : '' }}>
                                                    <label class="form-check-label fw-bold ms-2" for="bankAct{{ $bank->id }}">{{ __('البنك متاح حالياً') }}</label>
                                                </div>
                                            </div>
                                            <div class="modal-footer border-0 p-4 pt-0">
                                                <button type="button" class="btn btn-light px-4 rounded-3" data-bs-dismiss="modal">{{ __('إلغاء') }}</button>
                                                <button type="submit" class="btn btn-primary px-4 rounded-3 fw-bold">{{ __('حفظ') }}</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-5">
                                    <i class="bi bi-buildings fs-1 d-block mb-2 opacity-25"></i>
                                    {{ __('لم يتم إضافة بنوك بعد') }}
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- عوامل التسعير --}}
        @foreach ($typeLabels as $typeKey => $typeTitle)
            @php $list = $factors->get($typeKey, collect()); @endphp
            <div class="card border-0 shadow-sm mb-4 rounded-4 overflow-hidden">
                <div class="card-header bg-white border-0 pt-4 px-4 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold"><i class="bi bi-sliders text-primary me-2"></i> {{ $typeTitle }}</h5>
                    @can('manage-calculator-settings')
                    <button class="btn btn-sm btn-outline-primary px-3 rounded-pill fw-bold" data-bs-toggle="modal"
                        data-bs-target="#addFactorModal" data-factor-type="{{ $typeKey }}">
                        <i class="bi bi-plus-lg me-1"></i> {{ __('إضافة شريحة') }}
                    </button>
                    @endcan
                </div>
                <div class="table-responsive">
                    <table class="table table-hover mb-0 align-middle">
                        <thead class="bg-light">
                            <tr>
                                <th class="px-4 py-3 text-muted fw-bold small">CODE</th>
                                <th class="py-3 text-muted fw-bold">{{ __('العربية') }}</th>
                                <th class="py-3 text-muted fw-bold">English</th>
                                @if ($typeKey === CalculatorFactor::TYPE_AGE_BAND)
                                    <th class="py-3 text-muted fw-bold text-center">{{ __('النطاق العمري') }}</th>
                                @endif
                                <th class="py-3 text-muted fw-bold text-center">{{ __('تعديل النسبة %') }}</th>
                                <th class="py-3 text-muted fw-bold text-center">{{ __('الحالة') }}</th>
                                <th class="py-3 text-end px-4"></th>
                            </tr>
                        </thead>
                        <tbody class="border-top-0">
                            @forelse ($list as $factor)
                                <tr>
                                    <td class="px-4"><code class="bg-light text-primary p-1 rounded small">{{ $factor->code }}</code></td>
                                    <td class="fw-bold text-dark">{{ $factor->label_ar }}</td>
                                    <td class="text-muted">{{ $factor->label_en ?? '—' }}</td>
                                    @if ($typeKey === CalculatorFactor::TYPE_AGE_BAND)
                                        <td class="text-center fw-bold">{{ $factor->min_age }} - {{ $factor->max_age }}</td>
                                    @endif
                                    <td class="text-center">
                                        <span class="badge bg-{{ $factor->rate_adjustment >= 0 ? 'danger' : 'success' }}-subtle text-{{ $factor->rate_adjustment >= 0 ? 'danger' : 'success' }} px-3 py-2 rounded-pill fw-bold">
                                            {{ $factor->rate_adjustment >= 0 ? '+' : '' }}{{ number_format($factor->rate_adjustment, 2) }}%
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        @if ($factor->is_active)
                                            <span class="badge bg-success-subtle text-success px-3 py-2 rounded-pill small fw-bold">{{ __('نشط') }}</span>
                                        @else
                                            <span class="badge bg-secondary-subtle text-secondary px-3 py-2 rounded-pill small fw-bold">{{ __('معطل') }}</span>
                                        @endif
                                    </td>
                                    <td class="text-end px-4">
                                        <div class="d-flex gap-2 justify-content-end">
                                            @can('manage-calculator-settings')
                                            <button class="btn btn-sm btn-white border shadow-xs rounded-2" data-bs-toggle="modal"
                                                data-bs-target="#editFactorModal{{ $factor->id }}"><i class="bi bi-pencil-square"></i></button>
                                            @endcan
                                            @can('manage-calculator-settings')
                                            <form action="{{ route('crm.calculator.factors.destroy', $factor) }}"
                                                method="POST" onsubmit="return confirm('{{ __('هل أنت متأكد من الحذف؟') }}')">
                                                @csrf @method('DELETE')
                                                <button class="btn btn-sm btn-danger-subtle text-danger rounded-2 shadow-xs"><i class="bi bi-trash"></i></button>
                                            </form>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>

                                {{-- Edit Factor Modal --}}
                                <div class="modal fade" id="editFactorModal{{ $factor->id }}" tabindex="-1">
                                    <div class="modal-dialog modal-lg modal-dialog-centered">
                                        <div class="modal-content border-0 shadow rounded-4">
                                            <div class="modal-header border-0 pt-4 px-4">
                                                <h5 class="modal-title fw-bold">{{ __('تعديل عامل التسعير') }}</h5>
                                                <button type="button" class="btn-close {{ app()->getLocale() == 'ar' ? 'ms-0 me-auto' : '' }}" data-bs-dismiss="modal"></button>
                                            </div>
                                            <form action="{{ route('crm.calculator.factors.update', $factor) }}" method="POST">
                                                @csrf @method('PUT')
                                                <input type="hidden" name="type" value="{{ $factor->type }}">
                                                <div class="modal-body p-4 pt-2">
                                                    <div class="row g-3">
                                                        <div class="col-md-6">
                                                            <label class="form-label fw-bold small text-muted">CODE</label>
                                                            <input type="text" name="code" class="form-control bg-light border-0 shadow-none text-lowercase" value="{{ $factor->code }}" required pattern="[a-z0-9_]+">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label fw-bold small text-muted">{{ __('تعديل الفائدة % (+/-)') }}</label>
                                                            <input type="number" name="rate_adjustment" step="0.01" min="-20" max="20" class="form-control bg-light border-0 shadow-none fw-bold" value="{{ $factor->rate_adjustment }}" required>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label fw-bold small text-muted">{{ __('التسمية (بالعربية)') }}</label>
                                                            <input type="text" name="label_ar" class="form-control bg-light border-0 shadow-none" value="{{ $factor->label_ar }}" required>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label fw-bold small text-muted">{{ __('التسمية (بالإنجليزية)') }}</label>
                                                            <input type="text" name="label_en" class="form-control bg-light border-0 shadow-none" value="{{ $factor->label_en }}">
                                                        </div>
                                                        @if ($factor->type === CalculatorFactor::TYPE_AGE_BAND)
                                                            <div class="col-md-6">
                                                                <label class="form-label fw-bold small text-muted">{{ __('من عمر') }}</label>
                                                                <input type="number" name="min_age" min="0" max="120" class="form-control bg-light border-0 shadow-none" value="{{ $factor->min_age }}" required>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="form-label fw-bold small text-muted">{{ __('إلى عمر') }}</label>
                                                                <input type="number" name="max_age" min="0" max="120" class="form-control bg-light border-0 shadow-none" value="{{ $factor->max_age }}" required>
                                                            </div>
                                                        @endif
                                                        <div class="col-md-6">
                                                            <label class="form-label fw-bold small text-muted">{{ __('الترتيب') }}</label>
                                                            <input type="number" name="sort_order" class="form-control bg-light border-0 shadow-none" value="{{ $factor->sort_order }}">
                                                        </div>
                                                        <div class="col-12 mt-4">
                                                            <div class="form-check form-switch p-3 bg-light rounded-3">
                                                                <input class="form-check-input {{ app()->getLocale() == 'ar' ? 'ms-0 me-2 float-none' : '' }}" type="checkbox" name="is_active" value="1" id="fAct{{ $factor->id }}" {{ $factor->is_active ? 'checked' : '' }}>
                                                                <label class="form-check-label fw-bold ms-2" for="fAct{{ $factor->id }}">{{ __('هذا العامل نشط ومستخدم في الحاسبة') }}</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer border-0 p-4 pt-0">
                                                    <button type="button" class="btn btn-light px-4 rounded-3" data-bs-dismiss="modal">{{ __('إلغاء') }}</button>
                                                    <button type="submit" class="btn btn-primary px-4 rounded-3 fw-bold">{{ __('حفظ') }}</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <tr>
                                    <td colspan="{{ $typeKey === CalculatorFactor::TYPE_AGE_BAND ? 7 : 6 }}" class="text-center text-muted py-5">{{ __('لا توجد شرائح مسجلة') }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        @endforeach

        {{-- Modal إضافة بنك --}}
        <div class="modal fade" id="addBankModal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 shadow rounded-4 overflow-hidden">
                    <div class="modal-header border-0 pt-4 px-4">
                        <h5 class="modal-title fw-bold">{{ __('إضافة بنك جديد') }}</h5>
                        <button type="button" class="btn-close {{ app()->getLocale() == 'ar' ? 'ms-0 me-auto' : '' }}" data-bs-dismiss="modal"></button>
                    </div>
                    <form action="{{ route('crm.calculator.banks.store') }}" method="POST">
                        @csrf
                        <div class="modal-body p-4 pt-2">
                            <div class="mb-3">
                                <label class="form-label fw-bold small text-muted">{{ __('اسم البنك') }}</label>
                                <input type="text" name="name" class="form-control bg-light border-0 shadow-none" placeholder="{{ __('مثال: بنك مصر') }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold small text-muted">{{ __('نسبة الفائدة السنوية %') }}</label>
                                <input type="number" name="annual_rate" step="0.01" min="0" max="100" class="form-control bg-light border-0 shadow-none" placeholder="10.5" required>
                            </div>
                            <div class="mb-4">
                                <label class="form-label fw-bold small text-muted">{{ __('ترتيب العرض') }}</label>
                                <input type="number" name="sort_order" class="form-control bg-light border-0 shadow-none" value="0">
                            </div>
                            <div class="form-check form-switch p-3 bg-light rounded-3">
                                <input class="form-check-input {{ app()->getLocale() == 'ar' ? 'ms-0 me-2 float-none' : '' }}" type="checkbox" name="is_active" value="1" id="nbAct" checked>
                                <label class="form-check-label fw-bold ms-2" for="nbAct">{{ __('تفعيل البنك فوراً') }}</label>
                            </div>
                        </div>
                        <div class="modal-footer border-0 p-4 pt-0">
                            <button type="button" class="btn btn-light px-4 rounded-3" data-bs-dismiss="modal">{{ __('إلغاء') }}</button>
                            <button type="submit" class="btn btn-primary px-4 rounded-3 fw-bold">{{ __('إضافة البنك') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Modal إضافة عامل --}}
        <div class="modal fade" id="addFactorModal" tabindex="-1">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content border-0 shadow rounded-4 overflow-hidden">
                    <div class="modal-header border-0 pt-4 px-4">
                        <h5 class="modal-title fw-bold">{{ __('إضافة عامل تسعير جديد') }}</h5>
                        <button type="button" class="btn-close {{ app()->getLocale() == 'ar' ? 'ms-0 me-auto' : '' }}" data-bs-dismiss="modal"></button>
                    </div>
                    <form action="{{ route('crm.calculator.factors.store') }}" method="POST" id="addFactorForm">
                        @csrf
                        <div class="modal-body p-4 pt-2">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold small text-muted">{{ __('النوع') }}</label>
                                    <select name="type" class="form-select bg-light border-0 shadow-none" id="addFactorType" required>
                                        @foreach ($typeLabels as $k => $lbl)
                                            <option value="{{ $k }}">{{ $lbl }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold small text-muted">CODE <small class="text-lowercase opacity-50">(a-z, 0-9, _)</small></label>
                                    <input type="text" name="code" class="form-control bg-light border-0 shadow-none text-lowercase" required pattern="[a-z0-9_]+">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold small text-muted">{{ __('تعديل الفائدة % (+/-)') }}</label>
                                    <input type="number" name="rate_adjustment" step="0.01" min="-20" max="20" class="form-control bg-light border-0 shadow-none fw-bold" value="0" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold small text-muted">{{ __('ترتيب الظهور') }}</label>
                                    <input type="number" name="sort_order" class="form-control bg-light border-0 shadow-none" value="0">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold small text-muted">{{ __('التسمية (عربي)') }}</label>
                                    <input type="text" name="label_ar" class="form-control bg-light border-0 shadow-none" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold small text-muted">{{ __('التسمية (English)') }}</label>
                                    <input type="text" name="label_en" class="form-control bg-light border-0 shadow-none">
                                </div>
                                <div class="col-12 row g-3 d-none mx-0 px-0" id="ageFieldsRow">
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold small text-muted">{{ __('من عمر') }}</label>
                                        <input type="number" name="min_age" min="0" max="120" class="form-control bg-light border-0 shadow-none" id="addMinAge">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold small text-muted">{{ __('إلى عمر') }}</label>
                                        <input type="number" name="max_age" min="0" max="120" class="form-control bg-light border-0 shadow-none" id="addMaxAge">
                                    </div>
                                </div>
                                <div class="col-12 mt-4">
                                    <div class="form-check form-switch p-3 bg-light rounded-3">
                                        <input class="form-check-input {{ app()->getLocale() == 'ar' ? 'ms-0 me-2 float-none' : '' }}" type="checkbox" name="is_active" value="1" id="nfAct" checked>
                                        <label class="form-check-label fw-bold ms-2" for="nfAct">{{ __('تفعيل هذا العامل فوراً') }}</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer border-0 p-4 pt-0">
                            <button type="button" class="btn btn-light px-4 rounded-3" data-bs-dismiss="modal">{{ __('إلغاء') }}</button>
                            <button type="submit" class="btn btn-primary px-4 rounded-3 fw-bold">{{ __('إضافة العامل') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        document.querySelectorAll('[data-bs-target="#addFactorModal"]').forEach(btn => {
            btn.addEventListener('click', () => {
                const t = btn.getAttribute('data-factor-type');
                if (t) document.getElementById('addFactorType').value = t;
                document.getElementById('addFactorType').dispatchEvent(new Event('change'));
            });
        });
        document.getElementById('addFactorType').addEventListener('change', function() {
            const ageRow = document.getElementById('ageFieldsRow');
            const minA = document.getElementById('addMinAge');
            const maxA = document.getElementById('addMaxAge');
            if (this.value === 'age_band') {
                ageRow.classList.remove('d-none');
                minA.required = true;
                maxA.required = true;
            } else {
                ageRow.classList.add('d-none');
                minA.required = false;
                maxA.required = false;
                minA.value = '';
                maxA.value = '';
            }
        });
        document.getElementById('addFactorType').dispatchEvent(new Event('change'));
    </script>
@endsection

<style>
    .btn-white { background: #fff; }
    .btn-danger-subtle { background: #ffebee; border: none; }
    .shadow-xs { box-shadow: 0 1px 2px rgba(0,0,0,0.05); }
    .text-lowercase { text-transform: lowercase; }
</style>
