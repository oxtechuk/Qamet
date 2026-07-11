@extends('partials.Layouts.crm-master')
@section('title', __('توصيات العملاء') . ' | AutoCRM')

@section('content')
    <div class="container-fluid" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h4 class="mb-1 fw-bold">{{ __('توصيات العملاء (Testimonials)') }}</h4>
                <p class="text-muted mb-0 small">{{ __('إجمالي') }} {{ $testimonials->count() }} {{ __('توصية مسجلة') }}</p>
            </div>
            @can('manage-testimonials')
            <a href="{{ route('crm.settings.testimonials.create') }}" class="btn btn-primary rounded-pill px-4 shadow-sm fw-bold">
                <i class="bi bi-plus-circle me-1"></i> {{ __('إضافة توصية') }}
            </a>
            @endcan
        </div>

     

        <div class="row g-4">
            @forelse($testimonials as $testimonial)
                <div class="col-md-6 col-xl-4">
                    <div class="card border-0 shadow-sm h-100 rounded-4 overflow-hidden">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center mb-3">
                                <div class="{{ app()->getLocale() == 'ar' ? 'ms-3' : 'me-3' }}">
                                    @if($testimonial->image)
                                        <img src="{{ asset('storage/' . $testimonial->image) }}" alt="User" class="rounded-circle object-fit-cover" width="50" height="50">
                                    @else
                                        <div class="bg-light rounded-circle d-flex align-items-center justify-content-center" style="width:50px;height:50px;">
                                            <i class="bi bi-person fs-4 text-muted"></i>
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <h6 class="mb-0 fw-bold text-dark">{{ $testimonial->getTranslation('name', app()->getLocale()) }}</h6>
                                    <small class="text-muted">{{ $testimonial->getTranslation('title', app()->getLocale()) }}</small>
                                </div>
                                <div class="{{ app()->getLocale() == 'ar' ? 'me-auto' : 'ms-auto' }} text-warning">
                                    @for($i=0; $i<$testimonial->rating; $i++) <i class="bi bi-star-fill small"></i> @endfor
                                </div>
                            </div>
                            <p class="card-text text-muted mb-0 fst-italic">
                                "{{ mb_strimwidth($testimonial->getTranslation('content', app()->getLocale()), 0, 150, '...') }}"
                            </p>
                        </div>
                        <div class="card-footer bg-light border-0 d-flex gap-2 p-2">
                            @can('manage-testimonials')
                            <a href="{{ route('crm.settings.testimonials.edit', $testimonial) }}" class="btn btn-sm btn-white border shadow-xs rounded-2 flex-grow-1">
                                <i class="bi bi-pencil"></i> {{ __('تعديل') }}
                            </a>
                            @endcan
                            @can('manage-testimonials')
                            <form action="{{ route('crm.settings.testimonials.destroy', $testimonial) }}" method="POST" onsubmit="return confirm('{{ __('هل أنت متأكد من حذف هذه التوصية؟') }}')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger border shadow-xs rounded-2 px-3"><i class="bi bi-trash"></i></button>
                            </form>
                            @endcan
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <div class="card border-0 shadow-sm rounded-4 p-5">
                        <i class="bi bi-chat-quote fs-1 d-block mb-3 opacity-25"></i>
                        <h6 class="fw-bold">{{ __('لا يوجد توصيات مسجلة حالياً') }}</h6>
                        <div class="mt-3">
                            <a href="{{ route('crm.settings.testimonials.create') }}" class="btn btn-primary btn-sm rounded-pill px-4">{{ __('إضافة أول توصية') }}</a>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
@endsection

<style>
    .btn-white { background: #fff; }
    .shadow-xs { box-shadow: 0 1px 2px rgba(0,0,0,0.05); }
    .object-fit-cover { object-fit: cover; }
</style>
