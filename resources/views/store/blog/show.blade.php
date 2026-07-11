@extends('store.layouts.app')
@section('title', $post->title . ' | ' . (is_array($globalSettings['site_name'] ?? null) ? ($globalSettings['site_name'][App::getLocale()] ?? ($globalSettings['site_name']['ar'] ?? 'GR Motors')) : ($globalSettings['site_name'] ?? 'GR Motors')))
@section('meta_description', Str::limit($post->excerpt ?: strip_tags($post->content), 150))

@section('content')

<div class="blog-post-page">
    <div class="container">
        <div class="blog-post-container">
            
            {{-- Header --}}
            <header class="blog-post-header">
                <h1>{{ $post->title }}</h1>
                <div class="blog-post-meta">
                    <span><i class="bi bi-calendar3"></i> {{ $post->published_at?->translatedFormat('d F Y') }}</span>
                    <span><i class="bi bi-person"></i> {{ $post->employee->name ?? __('الإدارة') }}</span>
                    <span><i class="bi bi-eye"></i> {{ number_format(rand(100, 999) / 10, 1) }}K {{ __('مشاهدة') }}</span>
                </div>
            </header>

            {{-- Featured Image --}}
            @if($post->thumbnail)
                <div class="blog-post-img-wrapper">
                    <img loading="lazy" src="{{ asset('storage/' . $post->thumbnail) }}" alt="{{ $post->title }}">
                </div>
            @endif

            {{-- Main Content --}}
            <article class="blog-post-content">
                <div class="content-body">
                    {!! nl2br($post->content) !!}

                    {{-- Social Share --}}
                    <div class="social-share-row">
                        <a href="https://twitter.com/intent/tweet?text={{ urlencode($post->title) }}&url={{ url()->current() }}" target="_blank" class="share-btn" style="background:#000;"><i class="bi bi-twitter-x"></i></a>
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ url()->current() }}" target="_blank" class="share-btn" style="background:#1877f2;"><i class="bi bi-facebook"></i></a>
                        <a href="https://wa.me/?text={{ urlencode($post->title . ' ' . url()->current()) }}" target="_blank" class="share-btn" style="background:#25d366;"><i class="bi bi-whatsapp"></i></a>
                    </div>
                </div>
            </article>

        </div>
    </div>
</div>

{{-- Related Posts Section --}}
@if($related->count())
<section class="related-posts-section">
    <div class="container">
        <div class="related-posts-header">
            <span class="section-label">{{ __('المزيد من الأخبار') }}</span>
            <h2>{{ __('مقالات قد تهمك') }}</h2>
        </div>

        <div class="grid-3">
            @foreach($related as $post)
                @include('store.blog._post_card', ['post' => $post])
            @endforeach
        </div>
    </div>
</section>
@endif

@endsection
