@extends('partials.Layouts.crm-master')
@section('title', __('إدارة المدونة') . ' | AutoCRM')

@section('content')
<div class="container-fluid" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">

    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h4 class="mb-1 fw-bold"> {{ __('إدارة المدونة والمحتوى') }}</h4>
            <p class="text-muted mb-0 small">{{ __('إجمالي') }} {{ $posts->total() }} {{ __('مقالة منشورة أو مسودة') }}</p>
        </div>
        @can('manage-blog')
        <a href="{{ route('crm.blog.create') }}" class="btn btn-primary rounded-pill px-4 shadow-sm fw-bold">
            <i class="bi bi-pencil-square me-1"></i> {{ __('كتابة مقالة جديدة') }}
        </a>
        @endcan
    </div>

    

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="px-4 py-3 text-muted fw-bold small text-uppercase">{{ __('الصورة') }}</th>
                        <th class="py-3 text-muted fw-bold small text-uppercase">{{ __('عنوان المقالة') }}</th>
                        <th class="py-3 text-muted fw-bold small text-uppercase">{{ __('الكاتب') }}</th>
                        <th class="py-3 text-muted fw-bold small text-uppercase text-center">{{ __('الحالة') }}</th>
                        <th class="py-3 text-muted fw-bold small text-uppercase text-center">{{ __('مميزة') }}</th>
                        <th class="py-3 text-muted fw-bold small text-uppercase">{{ __('تاريخ النشر') }}</th>
                        <th class="py-3 text-end px-4"></th>
                    </tr>
                </thead>
                <tbody class="border-top-0">
                    @forelse($posts as $post)
                    <tr>
                        <td class="px-4">
                            @if($post->thumbnail)
                                <img src="{{ asset('storage/'.$post->thumbnail) }}" alt="{{ $post->title }}" width="70" height="48" class="rounded-3 shadow-xs object-fit-cover">
                            @else
                                <div class="bg-light rounded-3 d-flex align-items-center justify-content-center border border-dashed" style="width:70px;height:48px;">
                                    <i class="bi bi-image text-muted opacity-25"></i>
                                </div>
                            @endif
                        </td>
                        <td>
                            <h6 class="mb-1 fw-bold text-dark">{{ Str::limit($post->title, 50) }}</h6>
                            <p class="text-muted x-small mb-0">{{ Str::limit($post->excerpt, 80) }}</p>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="avatar-xs bg-primary-subtle text-primary rounded-circle me-2 d-flex align-items-center justify-content-center fw-bold small" style="width: 30px; height: 30px;">
                                    {{ strtoupper(substr($post->employee->name ?? 'A', 0, 1)) }}
                                </div>
                                <span class="small fw-medium">{{ $post->employee->name ?? __('غير معروف') }}</span>
                            </div>
                        </td>
                        <td class="text-center">
                            @if($post->is_published)
                                <span class="badge bg-success-subtle text-success px-3 py-2 rounded-pill small fw-bold">{{ __('منشورة') }}</span>
                            @else
                                <span class="badge bg-warning-subtle text-warning px-3 py-2 rounded-pill small fw-bold">{{ __('مسودة') }}</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <form action="{{ route('crm.blog.toggle-featured', $post) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-link p-0 text-decoration-none" title="{{ __('تمييز المقالة') }}">
                                    @if($post->is_featured)
                                        <i class="bi bi-star-fill text-warning fs-5"></i>
                                    @else
                                        <i class="bi bi-star text-muted opacity-50 fs-5"></i>
                                    @endif
                                </button>
                            </form>
                        </td>
                        <td class="text-muted small fw-medium">
                            <i class="bi bi-calendar3 me-1"></i>
                            {{ $post->published_at ? $post->published_at->format('Y/m/d') : '—' }}
                        </td>
                        <td class="text-end px-4">
                            <div class="d-flex gap-2 justify-content-end">
                                @can('manage-blog')
                                <a href="{{ route('crm.blog.edit', $post) }}" class="btn btn-sm btn-white border shadow-xs rounded-2">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                @endcan
                                @can('manage-blog')
                                <form action="{{ route('crm.blog.destroy', $post) }}" method="POST" onsubmit="return confirm('{{ __("هل أنت متأكد من حذف هذه المقالة نهائياً؟") }}')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-danger-subtle text-danger rounded-2 shadow-xs"><i class="bi bi-trash"></i></button>
                                </form>
                                @endcan
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5">
                            <div class="opacity-25 mb-3">
                                <i class="bi bi-journal-text" style="font-size: 4rem;"></i>
                            </div>
                            <h6 class="fw-bold">{{ __('لا توجد مقالات في المدونة حالياً') }}</h6>
                            <p class="small text-muted mb-4">{{ __('ابدأ بمشاركة أخبار المعرض أو نصائح السيارات مع عملائك') }}</p>
                            <a href="{{ route('crm.blog.create') }}" class="btn btn-primary btn-sm rounded-pill px-4">{{ __('كتابة أول مقالة') }}</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($posts->hasPages())
        <div class="card-footer bg-white border-top-0 p-4">
            {{ $posts->links() }}
        </div>
        @endif
    </div>
</div>

<style>
    .btn-white { background: #fff; }
    .btn-danger-subtle { background: #ffebee; border: none; }
    .shadow-xs { box-shadow: 0 1px 2px rgba(0,0,0,0.05); }
    .x-small { font-size: 11px; }
    .bg-primary-subtle { background: #e7f1ff; }
</style>
@endsection
