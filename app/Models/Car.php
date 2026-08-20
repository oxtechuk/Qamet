<?php

namespace App\Models;

use App\Casts\AsImageUrl;
use App\Traits\HasBilingualFields;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Translatable\HasTranslations;

class Car extends Model
{
    use HasBilingualFields, HasTranslations;

    public const HIGHLIGHT_OPTIONS = [
        'new_arrival' => ['ar' => 'أحدث السيارات', 'en' => 'New Arrivals'],
        'featured' => ['ar' => 'سيارات مختارة', 'en' => 'Featured'],
        'trending' => ['ar' => 'الأكثر طلباً', 'en' => 'Trending'],
        'exclusive' => ['ar' => 'إصدار خاص', 'en' => 'Exclusive'],
    ];

    public $translatable = ['name', 'description', 'features', 'slug'];

    protected $fillable = [
        'brand_id', 'category_id', 'name', 'slug', 'model', 'year', 'type',
        'color', 'colors', 'exterior_colors', 'interior_colors', 'cash_price', 'min_down_payment', 'min_installment',
        'description', 'features', 'specs', 'thumbnail', 'is_featured', 'is_active', 'is_highlighted', 'highlight_id', 'views',
        'availability_status',
    ];

    protected $appends = ['main_image'];

    protected $casts = [
        'colors' => 'array',
        'exterior_colors' => 'array',
        'interior_colors' => 'array',
        'specs' => 'array',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function getFormattedExteriorColorsAttribute(): ?array
    {
        $colors = $this->exterior_colors ?? $this->colors;
        if (! is_array($colors)) {
            return null;
        }

        return array_map(function (mixed $color): array {
            $color = is_array($color) ? $color : [];

            if (! empty($color['images']) && is_array($color['images'])) {
                $color['images'] = array_values(array_map(fn ($img) => AsImageUrl::url($img), array_filter($color['images'])));
            } elseif (! empty($color['image'])) {
                $color['images'] = [AsImageUrl::url($color['image'])];
            } else {
                $color['images'] = [];
            }

            if (! empty($color['image'])) {
                $color['image'] = AsImageUrl::url($color['image']);
            } elseif (! empty($color['images'][0])) {
                $color['image'] = $color['images'][0];
            }

            return $color;
        }, $colors);
    }

    public function getFormattedInteriorColorsAttribute(): ?array
    {
        if (! is_array($this->interior_colors)) {
            return null;
        }

        return array_map(function (mixed $color): array {
            $color = is_array($color) ? $color : [];

            if (! empty($color['images']) && is_array($color['images'])) {
                $color['images'] = array_values(array_map(fn ($img) => AsImageUrl::url($img), array_filter($color['images'])));
            } elseif (! empty($color['image'])) {
                $color['images'] = [AsImageUrl::url($color['image'])];
            } else {
                $color['images'] = [];
            }

            if (! empty($color['image'])) {
                $color['image'] = AsImageUrl::url($color['image']);
            } elseif (! empty($color['images'][0])) {
                $color['image'] = $color['images'][0];
            }

            return $color;
        }, $this->interior_colors);
    }

    public function getFormattedColorsAttribute(): ?array
    {
        return $this->formatted_exterior_colors;
    }

    public function getSpecsAttribute(mixed $value): ?array
    {
        $specs = is_string($value) ? json_decode($value, true) : $value;

        return is_array($specs) ? $specs : null;
    }

    public function getHorsepowerAttribute(): ?int
    {
        $hp = $this->specs['hp'] ?? null;

        if ($hp === null || $hp === '') {
            return null;
        }

        $numeric = preg_replace('/[^0-9]/', '', (string) $hp);

        return $numeric === '' ? null : (int) $numeric;
    }

    public function specifications()
    {
        return $this->belongsToMany(Specification::class, 'car_specification');
    }

    public function features_list()
    {
        return $this->belongsToMany(Feature::class, 'car_feature');
    }

    public function safety_features()
    {
        return $this->belongsToMany(SafetyFeature::class, 'car_safety_feature');
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(CarCategory::class, 'category_id');
    }

    public function highlight(): BelongsTo
    {
        return $this->belongsTo(Highlight::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(CarImage::class)->orderBy('sort_order');
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    public function offers(): HasMany
    {
        return $this->hasMany(Offer::class);
    }

    public function activeOffers(): HasMany
    {
        return $this->offers()
            ->where('is_active', true)
            ->where(function ($q) {
                $q->whereNull('ends_at')->orWhere('ends_at', '>=', now());
            })
            ->latest();
    }

    /**
     * @deprecated Use offers() instead. Kept for the legacy car_offer pivot which the current CRM no longer writes to.
     */
    public function legacyOffers()
    {
        return $this->belongsToMany(Offer::class, 'car_offer');
    }

    public function getExteriorImagesAttribute(): array
    {
        return $this->images->where('type', 'exterior')
            ->pluck('image_path')
            ->filter()
            ->values()
            ->all();
    }

    public function getInteriorImagesAttribute(): array
    {
        return $this->images->where('type', 'interior')
            ->pluck('image_path')
            ->filter()
            ->values()
            ->all();
    }

    public function getMainImageAttribute(): ?string
    {
        if ($this->thumbnail) {
            return AsImageUrl::url($this->thumbnail);
        }

        if ($this->relationLoaded('images') && $this->images->isNotEmpty()) {
            return AsImageUrl::url($this->images->first()->image_path);
        }

        $colors = $this->exterior_colors ?? $this->colors;
        if (! empty($colors) && is_array($colors)) {
            foreach ($colors as $color) {
                if (! empty($color['images']) && is_array($color['images']) && ! empty($color['images'][0])) {
                    return AsImageUrl::url($color['images'][0]);
                }
                if (! empty($color['image'])) {
                    return AsImageUrl::url($color['image']);
                }
            }
        }

        return null;
    }

    public function getThumbnailUrlAttribute(): ?string
    {
        return AsImageUrl::url($this->thumbnail);
    }

    public function getActiveOfferAttribute()
    {
        return $this->activeOffers->first();
    }

    public function getCurrentPriceAttribute()
    {
        $offer = $this->activeOffer;
        if ($offer && $offer->special_price) {
            return $offer->special_price;
        }

        return $this->cash_price;
    }

    public function calculateInstallment(int $downPayment, int $months, float $interestRate): array
    {
        $principal = $this->cash_price - $downPayment;
        $monthlyRate = $interestRate / 100 / 12;

        if ($monthlyRate == 0) {
            $monthly = $principal / $months;
        } else {
            $monthly = $principal * ($monthlyRate * pow(1 + $monthlyRate, $months))
                     / (pow(1 + $monthlyRate, $months) - 1);
        }

        return [
            'monthly' => round($monthly),
            'total' => round($monthly * $months) + $downPayment,
            'principal' => $principal,
        ];
    }

    public static function generateUniqueSlug(string $name, int $year, string $locale, ?int $excludeCarId = null): string
    {
        $baseSlug = self::slugify($name);

        if (! str_contains($baseSlug, (string) $year)) {
            $baseSlug .= '-'.$year;
        }

        $slug = $baseSlug;
        $counter = 1;

        while (true) {
            $query = self::where(function ($q) use ($slug) {
                $q->where('slug->en', $slug)
                    ->orWhere('slug->ar', $slug);
            });

            if ($excludeCarId) {
                $query->where('id', '!=', $excludeCarId);
            }

            if (! $query->exists()) {
                break;
            }

            $slug = $baseSlug.'-'.$counter;
            $counter++;
        }

        return $slug;
    }

    private static function slugify(string $text): string
    {
        $text = mb_strtolower($text, 'UTF-8');
        $slug = preg_replace('/[^\p{L}\p{N}]+/u', '-', $text);
        $slug = preg_replace('/-+/', '-', $slug);

        return trim($slug, '-');
    }
}
