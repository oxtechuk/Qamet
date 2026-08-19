<?php

namespace App\Models;

use App\Traits\HasBilingualFields;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Translatable\HasTranslations;

class BlogPost extends Model
{
    use HasBilingualFields, HasTranslations;

    public $translatable = ['title', 'excerpt', 'content'];

    protected $fillable = [
        'employee_id', 'title', 'slug', 'thumbnail', 'excerpt', 'content',
        'meta_title', 'meta_description', 'meta_keywords',
        'is_published', 'is_featured', 'published_at',
    ];

    protected $appends = ['reading_time'];

    protected $casts = [
        'is_published' => 'boolean',
        'is_featured' => 'boolean',
        'published_at' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::saving(function (self $model) {
            if (empty($model->slug)) {
                $title = $model->title_en ?: ($model->title_ar ?: 'post');
                if (is_array($title)) {
                    $title = $title['en'] ?? ($title['ar'] ?? 'post');
                }
                $slug = \Illuminate\Support\Str::slug((string) $title);
                if (empty($slug)) {
                    $slug = preg_replace('/[^\p{L}\p{N}]+/u', '-', (string) $title);
                    $slug = trim((string) preg_replace('/-+/', '-', (string) $slug), '-');
                }
                $model->slug = $slug ?: ('post-'.uniqid());
            }
        });
    }

    public function getReadingTimeAttribute(): int
    {
        return max(1, (int) ceil(mb_strlen(strip_tags($this->content ?? '')) / 1000));
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(BlogCategory::class, 'blog_post_category');
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }
}
