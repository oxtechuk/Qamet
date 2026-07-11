@extends('partials.Layouts.crm-master')
@section('title', __('الأسئلة الشائعة') . ' | AutoCRM')

@section('content')
    <div class="container-fluid" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h4 class="mb-1 fw-bold">{{ __('الأسئلة الشائعة (FAQs)') }}</h4>
                <p class="text-muted mb-0 small">{{ __('إجمالي') }} {{ $faqs->count() }} {{ __('سؤال مسجل') }}</p>
            </div>
            @can('manage-faqs')
            <button class="btn btn-primary rounded-pill px-4 shadow-sm fw-bold" data-bs-toggle="modal" data-bs-target="#addFaqModal">
                <i class="bi bi-plus-circle me-1"></i> {{ __('إضافة سؤال') }}
            </button>
            @endcan
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show rounded-3 mb-4" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="row g-3">
            @forelse($faqs as $faq)
                <div class="col-12">
                    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-start justify-content-between gap-3">
                                <div class="flex-grow-1">
                                    <div class="d-flex align-items-center gap-2 mb-2">
                                        @if(!$faq->is_visible)
                                            <span class="badge bg-secondary rounded-pill">{{ __('مخفي') }}</span>
                                        @endif
                                        <span class="badge bg-light text-muted border rounded-pill small">{{ __('ترتيب') }}: {{ $faq->sort_order }}</span>
                                    </div>
                                    <h6 class="fw-bold text-dark mb-2">
                                        {{ $faq->getTranslation('question', 'ar') }}
                                    </h6>
                                    @if($faq->getTranslation('question', 'en'))
                                        <p class="text-muted small mb-2" dir="ltr">{{ $faq->getTranslation('question', 'en') }}</p>
                                    @endif
                                    <p class="text-muted mb-0 small">
                                        {{ mb_strimwidth($faq->getTranslation('answer', 'ar'), 0, 200, '...') }}
                                    </p>
                                </div>
                                <div class="d-flex gap-2 flex-shrink-0">
                                    @can('manage-faqs')
                                    <button class="btn btn-sm btn-white border shadow-xs rounded-2"
                                            data-bs-toggle="modal"
                                            data-bs-target="#editFaqModal{{ $faq->id }}">
                                        <i class="bi bi-pencil"></i> {{ __('تعديل') }}
                                    </button>
                                    <form action="{{ route('crm.settings.faqs.destroy', $faq) }}" method="POST"
                                          onsubmit="return confirm('{{ __('هل أنت متأكد من حذف هذا السؤال؟') }}')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger border shadow-xs rounded-2 px-3">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                    @endcan
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Edit Modal --}}
                @can('manage-faqs')
                <div class="modal fade" id="editFaqModal{{ $faq->id }}" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content border-0 shadow rounded-4 overflow-hidden">
                            <div class="modal-header border-0 pt-4 px-4">
                                <h5 class="modal-title fw-bold">{{ __('تعديل السؤال') }}</h5>
                                <button type="button" class="btn-close {{ app()->getLocale() == 'ar' ? 'ms-0 me-auto' : '' }}" data-bs-dismiss="modal"></button>
                            </div>
                            <form action="{{ route('crm.settings.faqs.update', $faq) }}" method="POST">
                                @csrf @method('PUT')
                                <div class="modal-body p-4 pt-2">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold small text-muted">{{ __('السؤال (عربي)') }} <span class="text-danger">*</span></label>
                                            <textarea name="question[ar]" rows="2" class="form-control bg-light border-0 shadow-none" dir="rtl" required>{{ $faq->getTranslation('question', 'ar') }}</textarea>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold small text-muted">{{ __('السؤال (إنجليزي)') }}</label>
                                            <textarea name="question[en]" rows="2" class="form-control bg-light border-0 shadow-none" dir="ltr">{{ $faq->getTranslation('question', 'en') }}</textarea>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold small text-muted">{{ __('الإجابة (عربي)') }} <span class="text-danger">*</span></label>
                                            <textarea name="answer[ar]" rows="4" class="form-control bg-light border-0 shadow-none" dir="rtl" required>{{ $faq->getTranslation('answer', 'ar') }}</textarea>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold small text-muted">{{ __('الإجابة (إنجليزي)') }}</label>
                                            <textarea name="answer[en]" rows="4" class="form-control bg-light border-0 shadow-none" dir="ltr">{{ $faq->getTranslation('answer', 'en') }}</textarea>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold small text-muted">{{ __('الترتيب') }}</label>
                                            <input type="number" name="sort_order" class="form-control bg-light border-0 shadow-none" value="{{ $faq->sort_order }}" min="0">
                                        </div>
                                        <div class="col-md-6 d-flex align-items-end">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" name="is_visible" id="visible{{ $faq->id }}" {{ $faq->is_visible ? 'checked' : '' }}>
                                                <label class="form-check-label fw-bold small text-muted" for="visible{{ $faq->id }}">{{ __('ظاهر للزوار') }}</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer border-0 p-4 pt-0">
                                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">{{ __('إلغاء') }}</button>
                                    <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold">{{ __('حفظ') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                @endcan
            @empty
                <div class="col-12 text-center py-5">
                    <div class="card border-0 shadow-sm rounded-4 p-5">
                        <i class="bi bi-question-circle fs-1 d-block mb-3 opacity-25"></i>
                        <h6 class="fw-bold">{{ __('لا يوجد أسئلة مسجلة حالياً') }}</h6>
                        @can('manage-faqs')
                        <div class="mt-3">
                            <button class="btn btn-primary btn-sm rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#addFaqModal">
                                {{ __('إضافة أول سؤال') }}
                            </button>
                        </div>
                        @endcan
                    </div>
                </div>
            @endforelse
        </div>
    </div>

    {{-- Add Modal --}}
    @can('manage-faqs')
    <div class="modal fade" id="addFaqModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0 shadow rounded-4 overflow-hidden">
                <div class="modal-header border-0 pt-4 px-4">
                    <h5 class="modal-title fw-bold">{{ __('إضافة سؤال جديد') }}</h5>
                    <button type="button" class="btn-close {{ app()->getLocale() == 'ar' ? 'ms-0 me-auto' : '' }}" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('crm.settings.faqs.store') }}" method="POST">
                    @csrf
                    <div class="modal-body p-4 pt-2">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-muted">{{ __('السؤال (عربي)') }} <span class="text-danger">*</span></label>
                                <textarea name="question[ar]" rows="2" class="form-control bg-light border-0 shadow-none" dir="rtl" required placeholder="{{ __('أدخل السؤال بالعربية...') }}"></textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-muted">{{ __('السؤال (إنجليزي)') }}</label>
                                <textarea name="question[en]" rows="2" class="form-control bg-light border-0 shadow-none" dir="ltr" placeholder="Enter question in English..."></textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-muted">{{ __('الإجابة (عربي)') }} <span class="text-danger">*</span></label>
                                <textarea name="answer[ar]" rows="4" class="form-control bg-light border-0 shadow-none" dir="rtl" required placeholder="{{ __('أدخل الإجابة بالعربية...') }}"></textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-muted">{{ __('الإجابة (إنجليزي)') }}</label>
                                <textarea name="answer[en]" rows="4" class="form-control bg-light border-0 shadow-none" dir="ltr" placeholder="Enter answer in English..."></textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-muted">{{ __('الترتيب') }}</label>
                                <input type="number" name="sort_order" class="form-control bg-light border-0 shadow-none" value="0" min="0">
                            </div>
                            <div class="col-md-6 d-flex align-items-end">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="is_visible" id="is_visible_new" checked>
                                    <label class="form-check-label fw-bold small text-muted" for="is_visible_new">{{ __('ظاهر للزوار') }}</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-0 p-4 pt-0">
                        <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">{{ __('إلغاء') }}</button>
                        <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold">{{ __('إضافة السؤال') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endcan
@endsection

<style>
    .btn-white { background: #fff; }
    .shadow-xs { box-shadow: 0 1px 2px rgba(0,0,0,0.05); }
</style>
