@extends('store.layouts.app')

@section('title', __('المدونة') . ' | ' . (is_array($globalSettings['site_name'] ?? null) ? ($globalSettings['site_name'][App::getLocale()] ?? ($globalSettings['site_name']['ar'] ?? 'GR Motors')) : ($globalSettings['site_name'] ?? 'GR Motors')))

@section('css')
<style>
    /* ============================================================
   BLOG INDEX STYLES
   ============================================================ */
:root {
  --clr-primary: linear-gradient(180deg, #ED1C24 0%, #B1161C 32.21%, #8A1217 55.77%, #5A0D10 100%);
    --clr-primary-dark: linear-gradient(180deg, #b81219 0%, #8a1217 32.21%, #5a0d10 55.77%, #4a080a 100%);
  --clr-bg-light: #f8f8f8;
  --clr-text: #1a1a1a;
  --clr-text-muted: #666666;
  --clr-text-light: #999999;
  --clr-border: #e8e8e8;
  --clr-card-bg: #ffffff;
  --clr-stat-icon: var(--primary-gradiant);

  --radius-sm: 6px;
  --radius-md: 10px;
  --radius-lg: 14px;

  --shadow-card: 0 2px 16px rgba(0,0,0,0.08);
  --shadow-card-hover: 0 8px 32px rgba(0,0,0,0.13);

  --transition: 0.22s ease;
  --container-max: 1200px;
  --container-pad: 1.25rem;
}

/* ============================================================
   STATS SECTION
   ============================================================ */
.stats {
  background: var(--clr-bg);
  padding: 2.5rem var(--container-pad);
}

.stats__container {
  max-width: var(--container-max);
  margin: 0 auto;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 0;
  border: 1.5px solid var(--clr-border);
  border-radius: var(--radius-lg);
  overflow: hidden;
  background: var(--clr-bg);
  box-shadow: var(--shadow-card);
  max-width: 960px;
}

.stats__item {
 flex: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.75rem;
    padding: 1.5rem 2rem;
    flex-direction: column;
}

.stats__divider {
  width: 1.5px;
  height: 60px;
  background: var(--clr-border);
  flex-shrink: 0;
}

.stats__icon {
  color: var(--color-red);
  display: flex;
  align-items: center;
  flex-shrink: 0;
}

.stats__info {
  display: flex;
  flex-direction: column;
  align-items: flex-start;
  gap: 0.1rem;
}

.stats__number {
  font-size: 1.75rem;
  font-weight: 900;
  color: var(--clr-text);
  line-height: 1.1;
}

.stats__label {
  font-size: 0.8125rem;
  font-weight: 500;
  color: var(--clr-text-muted);
}

/* ============================================================
   ARTICLES SECTION SHARED
   ============================================================ */
.articles {
  padding: 3rem var(--container-pad);
}


.articles__container {
  max-width: var(--container-max);
  margin: 0 auto;
}

.articles__header {
  text-align: center;
  margin-bottom: 2rem;
}

.articles__title {
  font-size: 1.75rem;
  font-weight: 900;
  color: var(--clr-text);
  margin-bottom: 0.35rem;
}

.articles__title--accent {
  color: var(--clr-primary);
}

.articles__subtitle {
  font-size: 0.9375rem;
  color: var(--clr-text-muted);
}

/* ============================================================
   ARTICLES GRID
   ============================================================ */
.articles__grid {
  display: grid;
  grid-template-columns: repeat(3, 2fr);
  gap: 1.25rem;
}

/* ============================================================
   CARD
   ============================================================ */
.blog-card {
  background: var(--clr-card-bg);
  border-radius: var(--radius-lg);
  overflow: hidden;
  box-shadow: var(--shadow-card);
  display: flex;
  flex-direction: column;
  transition: box-shadow var(--transition), transform var(--transition);
  height: 100%;
}

.blog-card:hover {
  box-shadow: var(--shadow-card-hover);
  transform: translateY(-3px);
}

.blog-card__image-wrap {
  position: relative;
  width: 100%;
  aspect-ratio: 16 / 9;
  overflow: hidden;
  background: #222;
}

.blog-card__image {
  width: 100%;
  height: 100%;
  object-fit: cover;
  transition: transform 0.4s ease;
}

.blog-card:hover .blog-card__image {
  transform: scale(1.04);
}

.blog-card__body {
  padding: 1rem 1rem 0.75rem;
  display: flex;
  flex-direction: column;
  flex: 1;
  gap: 0.45rem;
}

.blog-card__title {
  font-size: 1rem;
  font-weight: 700;
  color: var(--clr-text);
  line-height: 1.4;
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
  text-decoration: none;
}

.blog-card__excerpt {
  font-size: 0.8125rem;
  color: var(--clr-text-muted);
  line-height: 1.55;
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
  flex: 1;
}

.blog-card__meta {
  display: flex;
  align-items: center;
  gap: 1rem;
  flex-wrap: wrap;
}

.blog-card__meta-item {
  display: flex;
  align-items: center;
  gap: 0.3rem;
  font-size: 0.75rem;
  color: var(--clr-text-light);
  font-weight: 500;
}

.blog-card__meta-item i {
  flex-shrink: 0;
  color: var(--clr-text-light);
}

.blog-card__footer {
  padding: 0 1rem 1rem;
}

.blog-card__btn {
  display: block;
  width: 100%;
  text-align: center;
  background: var(--clr-primary);
  color: #ffffff;
  font-size: 0.8125rem;
  font-weight: 700;
  padding: 0.6rem 1rem;
  border-radius: var(--radius-sm);
  text-decoration: none;
  transition: background var(--transition), transform var(--transition);
}

.blog-card__btn:hover {
  background: var(--clr-primary-dark);
}

/* ============================================================
   PAGINATION
   ============================================================ */
.blog-pagination {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 0.75rem;
  margin-top: 2rem;
}

.pagination .page-item {
    list-style: none;
}

.pagination .page-link {
    width: 38px;
    height: 38px;
    border-radius: 50%;
    background: #fff;
    color: var(--clr-text);
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all var(--transition);
    border: 1.5px solid var(--clr-border);
    text-decoration: none;
    font-weight: 700;
}

.pagination .page-item.active .page-link {
    background: var(--clr-primary);
    color: #fff;
    border-color: var(--clr-primary);
}

.pagination .page-link:hover:not(.active) {
    border-color: var(--clr-primary);
    color: var(--clr-primary);
}

/* ============================================================
   RESPONSIVE
   ============================================================ */
@media (max-width: 1024px) {
  .articles__grid {
    grid-template-columns: repeat(2, 1fr);
  }
}

@media (max-width: 640px) {
  .stats__container {
    flex-direction: column;
    max-width: 100%;
  }
  .stats__divider {
    width: 80%;
    height: 1.5px;
  }
  .articles__grid {
    grid-template-columns: 1fr;
  }
}
</style>
@endsection

@section('breadcrumb-title', __('مدونة السيارات'))

@section('content')
@include('partials.Store.breadcrumb')

  <!-- STATS SECTION -->
  <section class="stats">
      <div class="articles__header">
        <h2 class="articles__title" style="margin-bottom: 5px; font-size: 40px;font-weight: 700 ;">{{ __('عالم') }} <span class="articles__title--accent" style="color: var(--color-red);">{{ __('السيارات') }}  </span></h2>
        <p class="articles__subtitle" style="margin-top: 5px;">{{ __('أحدث الأخبار والمراجعات والنصائح في عالم السيارات') }}</p>
      </div>
      
    <div class="stats__container">
      <div class="stats__item">
        <span class="stats__icon">
          <i class="bi bi-journal-text" style="font-size: 32px;"></i>
        </span>
        <div class="stats__info">
          <span class="stats__number">{{ $posts->total() }}+</span>
          <span class="stats__label">{{ __('مقالة') }}</span>
        </div>
      </div>
      <div class="stats__divider"></div>
      <div class="stats__item">
        <span class="stats__icon">
          <i class="bi bi-people" style="font-size: 32px;"></i>
        </span>
        <div class="stats__info">
          <span class="stats__number">10,000+</span>
          <span class="stats__label">{{ __('قارئ') }}</span>
        </div>
      </div>
    </div>
  </section>

  <!-- FEATURED ARTICLES (Only on first page) -->
  @if($posts->currentPage() == 1 && $featuredPosts->isNotEmpty())
  <section class="articles articles--featured" style="margin-top: 25px;">
    <div class="articles__container">
      <div class="articles__header">
        <h2 class="articles__title" style="margin-bottom: 5px; font-size: 40px;font-weight: 700 ;">{{ __('المقالات') }} <span class="articles__title--accent" style="color: var(--color-red);">{{ __('المميزة') }}</span></h2>
        <p class="articles__subtitle" style="margin-top: 5px;">{{ __('إطلع على أفضل المقالات لدينا') }}</p>
      </div>
      <div class="articles__grid">
        @foreach($featuredPosts as $post)
            <article class="blog-card">
                <div class="blog-card__image-wrap">
                    <img class="blog-card__image" src="{{ $post->thumbnail ? asset('storage/' . $post->thumbnail) : asset('assets/images/placeholder.jpg') }}" alt="{{ $post->title }}" loading="lazy" />
                </div>
                <div class="blog-card__body">
                    <a href="{{ route('store.blog.show', $post->slug) }}" class="blog-card__title">{{ $post->title }}</a>
                    <p class="blog-card__excerpt">{{ $post->excerpt }}</p>
                    <div class="blog-card__meta">
                        <span class="blog-card__meta-item"><i class="bi bi-calendar3"></i> {{ $post->published_at ? $post->published_at->format('d M Y') : $post->created_at->format('d M Y') }}</span>
                    </div>
                </div>
                <div class="blog-card__footer">
                    <a href="{{ route('store.blog.show', $post->slug) }}" class="blog-card__btn">{{ __('اقرأ المقالة') }}</a>
                </div>
            </article>
        @endforeach
      </div>
    </div>
  </section>
  @endif

  <!-- LATEST ARTICLES -->
  <section class="articles articles--latest">
    <div class="articles__container">
      <div class="articles__header">
        <h2 class="articles__title">{{ __('احدث') }} <span class="articles__title--accent" style="color: #E01B1B;">{{ __('المقالات') }} </span></h2>
        <p class="articles__subtitle">{{ __('إطلع على اخر الاخبار والمقالات') }}</p>
      </div>
      <div class="articles__grid">
        @foreach($posts as $post)
            <article class="blog-card">
                <div class="blog-card__image-wrap">
                    <img class="blog-card__image" src="{{ $post->thumbnail ? asset('storage/' . $post->thumbnail) : asset('assets/images/placeholder.jpg') }}" alt="{{ $post->title }}" loading="lazy" />
                </div>
                <div class="blog-card__body">
                    <a href="{{ route('store.blog.show', $post->slug) }}" class="blog-card__title">{{ $post->title }}</a>
                    <p class="blog-card__excerpt">{{ $post->excerpt }}</p>
                    <div class="blog-card__meta">
                        <span class="blog-card__meta-item"><i class="bi bi-calendar3"></i> {{ $post->published_at ? $post->published_at->format('d M Y') : $post->created_at->format('d M Y') }}</span>
                    </div>
                </div>
                <div class="blog-card__footer">
                    <a href="{{ route('store.blog.show', $post->slug) }}" class="blog-card__btn">{{ __('اقرأ المقالة') }}</a>
                </div>
            </article>
        @endforeach
      </div>

      <!-- Pagination -->
      <div class="blog-pagination">
        {{ $posts->links() }}
      </div>
    </div>
  </section>
@endsection