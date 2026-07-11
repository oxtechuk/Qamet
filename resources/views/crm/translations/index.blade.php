@extends('partials.Layouts.crm-master')

@section('title', __('إدارة الترجمة') . ' | AutoCRM')

@section('content')
<div class="container-fluid" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">

    <div class="row mb-4">
        <div class="col-12">
            <div class="p-4 rounded-4 text-white d-flex flex-column flex-md-row align-items-md-center justify-content-between shadow-sm position-relative overflow-hidden" style="background: var(--crm-red);">
                <div class="position-relative" style="z-index: 2;">
                    <h3 class="mb-1 fw-bold"><i class="bi bi-translate me-2"></i> {{ __('إدارة الترجمة المزدوجة') }}</h3>
                    <p class="mb-0 opacity-75">{{ __('تعديل ملفات اللغتين العربية والإنجليزية جنباً إلى جنب وبسهولة تامة.') }}</p>
                </div>
            </div>
        </div>
    </div>

    
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show rounded-4 shadow-sm border-0 mb-4" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <form action="{{ route('crm.translations.update') }}" method="POST" id="translationForm">
            @csrf

            <!-- Sticky Header Tools -->
            <div class="card-header bg-white py-3 border-bottom d-flex flex-column flex-md-row justify-content-between align-items-center sticky-top" style="top: 70px; z-index: 100;">
                <div class="d-flex align-items-center mb-3 mb-md-0">
                    <button type="button" id="toggleUntranslated" class="btn-crm-outline text-dark fw-bold border-1 me-2 shadow-sm rounded-pill px-3" style="border-color: var(--crm-red);">
                        <i class="bi bi-funnel-fill me-1 text-danger"></i> {{ __('الغير مترجم فقط') }}
                        <span class="badge bg-danger text-white ms-1 rounded-pill" id="untranslatedCount">0</span>
                    </button>
                    <div class="input-group ms-2 shadow-sm rounded-pill overflow-hidden border">
                        <span class="input-group-text bg-white border-0"><i class="bi bi-search text-muted"></i></span>
                        <input type="text" id="searchInput" class="form-control border-0 bg-white" placeholder="{{ __('ابحث عن كلمة...') }}" style="min-width: 250px; box-shadow: none;">
                    </div>
                </div>
                <div>
                    @can('manage-translations')
                    <button type="submit" class="btn-crm-primary shadow-sm rounded-pill px-4 fw-bold">
                        <i class="bi bi-save me-1"></i> {{ __('حفظ جميع التعديلات') }}
                    </button>
                    @endcan
                </div>
            </div>

            <!-- Table -->
            <div class="card-body p-0">
                <div class="table-responsive" style="max-height: 65vh;">
                    <table class="crm-table align-middle mb-0" id="translationsTable">
                        <thead class="table-light sticky-top" style="top: 0; z-index: 10;">
                            <tr>
                                <th class="px-4 py-3 border-bottom-0" style="width: 25%;">{{ __('الكلمة المرجعية (Key)') }}</th>
                                <th class="py-3 border-bottom-0" style="width: 35%;">{{ __('English (en)') }}</th>
                                <th class="py-3 border-bottom-0" style="width: 35%;">{{ __('عربي (ar)') }}</th>
                                <th class="py-3 border-bottom-0 text-center" style="width: 5%;">{{ __('حذف') }}</th>
                            </tr>
                        </thead>
                        <tbody id="translationsBody">
                            @foreach($allKeys as $key)
                                <tr>
                                    <td class="px-4 bg-light border-end">
                                        <input type="text" name="keys[]" value="{{ $key }}" class="form-control-plaintext text-muted fw-bold font-monospace" readonly title="{{ $key }}">
                                    </td>
                                    <td class="p-0">
                                        <input type="text" name="en_values[]" value="{{ $enData[$key] ?? '' }}" class="form-control border-0 shadow-none px-4 py-3 bg-transparent seamless-input" dir="ltr">
                                    </td>
                                    <td class="p-0">
                                        <input type="text" name="ar_values[]" value="{{ $arData[$key] ?? '' }}" class="form-control border-0 shadow-none px-4 py-3 bg-transparent seamless-input" dir="rtl">
                                    </td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-sm text-danger remove-row-btn" title="{{ __('حذف الكلمة') }}">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Footer Tools -->
            <div class="card-footer bg-white p-4 border-top">
                @can('manage-translations')
                <button type="button" id="addNewRow" class="btn-crm-outline shadow-sm rounded-pill px-4 fw-bold">
                    <i class="bi bi-plus-circle me-1"></i> {{ __('إضافة كلمة جديدة') }}
                </button>
                @endcan
            </div>
        </form>
    </div>

</div>

<style>
    .font-monospace { font-family: monospace; font-size: 0.9em; }
    #translationsTable input.form-control:focus {
        border-color: var(--crm-primary);
        box-shadow: inset 0 0 0 1px var(--crm-primary);
    }
</style>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const tableBody = document.getElementById('translationsBody');
        const searchInput = document.getElementById('searchInput');
        const toggleBtn = document.getElementById('toggleUntranslated');
        const countSpan = document.getElementById('untranslatedCount');
        const addBtn = document.getElementById('addNewRow');

        let showingUntranslated = false;

        // Count untranslated
        function updateCount() {
            let count = 0;
            const rows = tableBody.querySelectorAll('tr');
            rows.forEach(row => {
                const key = row.querySelector('input[name="keys[]"]').value.trim();
                const en = row.querySelector('input[name="en_values[]"]').value.trim();
                const ar = row.querySelector('input[name="ar_values[]"]').value.trim();
                if (!en || !ar || ar === key) {
                    count++;
                }
            });
            countSpan.textContent = count;
        }

        // Filter Rows
        function filterRows() {
            const term = searchInput.value.toLowerCase();
            const rows = tableBody.querySelectorAll('tr');
            
            rows.forEach(row => {
                const key = row.querySelector('input[name="keys[]"]').value.toLowerCase();
                const en = row.querySelector('input[name="en_values[]"]').value.toLowerCase();
                const ar = row.querySelector('input[name="ar_values[]"]').value.toLowerCase();
                
                const matchesSearch = key.includes(term) || en.includes(term) || ar.includes(term);
                
                let matchesUntranslated = true;
                if (showingUntranslated) {
                    const enVal = row.querySelector('input[name="en_values[]"]').value.trim();
                    const arVal = row.querySelector('input[name="ar_values[]"]').value.trim();
                    const keyVal = row.querySelector('input[name="keys[]"]').value.trim();
                    matchesUntranslated = (!enVal || !arVal || arVal === keyVal);
                }

                if (matchesSearch && matchesUntranslated) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }

        updateCount();

        // Search event
        searchInput.addEventListener('input', filterRows);

        // Toggle Untranslated
        toggleBtn.addEventListener('click', function() {
            showingUntranslated = !showingUntranslated;
            if (showingUntranslated) {
                this.innerHTML = '<i class="bi bi-eye-fill me-1"></i> {{ __("عرض الكل") }} <span class="badge bg-light text-dark ms-1">' + countSpan.textContent + '</span>';
            } else {
                this.classList.remove('btn-success');
                this.classList.add('btn-warning');
                this.innerHTML = '<i class="bi bi-funnel-fill me-1"></i> {{ __("الغير مترجم فقط") }} <span class="badge bg-light text-dark ms-1">' + countSpan.textContent + '</span>';
            }
            filterRows();
        });

        // Add Row
        addBtn.addEventListener('click', function() {
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td class="px-4 bg-light border-end">
                    <input type="text" name="keys[]" class="form-control-plaintext border-0 fw-bold font-monospace text-primary" placeholder="new.key" required>
                </td>
                <td class="p-0">
                    <input type="text" name="en_values[]" class="form-control border-0 shadow-none px-4 py-3 bg-transparent seamless-input" placeholder="{{ __('English text') }}" dir="ltr">
                </td>
                <td class="p-0">
                    <input type="text" name="ar_values[]" class="form-control border-0 shadow-none px-4 py-3 bg-transparent seamless-input" placeholder="{{ __('نص عربي') }}" dir="rtl">
                </td>
                <td class="text-center">
                    <button type="button" class="btn btn-sm text-danger remove-row-btn" title="{{ __('حذف الكلمة') }}">
                        <i class="bi bi-trash"></i>
                    </button>
                </td>
            `;
            tableBody.prepend(tr);
            tr.querySelector('input[name="keys[]"]').focus();
        });

        // Remove Row
        tableBody.addEventListener('click', function(e) {
            if (e.target.closest('.remove-row-btn')) {
                e.target.closest('tr').remove();
                updateCount();
            }
        });

        // Live Count Update
        tableBody.addEventListener('input', function(e) {
            if (e.target.tagName.toLowerCase() === 'input') {
                updateCount();
            }
        });
    });
</script>
@endsection
