<div class="post-card">
    @if($post->thumbnail)
        <img loading="lazy" src="{{ asset('storage/' . $post->thumbnail) }}" alt="{{ $post->title }}" class="post-card-img">
    @else
        <div class="post-card-img" style="background: var(--color-bg); display: flex; align-items: center; justify-content: center; color: var(--color-border); font-size: 40px;">
            <i class="bi bi-image"></i>
        </div>
    @endif
    
    <div class="post-card-body">
        <h3 class="post-title">{{ $post->title }}</h3>
        
        <p class="post-excerpt">{{ strip_tags($post->excerpt ?: $post->content) }}</p>
        
        <div class="post-meta-row">
            <div class="post-meta-badge">
                <i class="bi bi-calendar3"></i> {{ $post->published_at ? $post->published_at->translatedFormat('d F Y') : date('d M Y') }}
            </div>
            <div class="post-meta-badge">
                <i class="bi bi-eye"></i> {{ number_format(rand(100, 999) / 10, 1) }}K
            </div>
        </div>

        <a href="{{ route('store.blog.show', $post->slug) }}" class="btn-read-post">
            {{ __('اقرأ المقالة') }}
        </a>
    </div>
</div>
