<?php

namespace App\Models;

use App\Casts\AsImageUrl;
use App\Traits\HasBilingualFields;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Translatable\HasTranslations;

class Offer extends Model
{
    use HasBilingualFields, HasTranslations;

    public $translatable = ['title', 'description'];

    protected $fillable = [
        'car_id', 'image', 'title', 'description', 'discount_percent',
        'special_price', 'special_installment', 'starts_at', 'ends_at', 'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
        'image' => AsImageUrl::class,
    ];

    public function car(): BelongsTo
    {
        return $this->belongsTo(Car::class);
    }

    /**
     * @deprecated Use car() instead. Kept for Blade view backward compatibility.
     */
    public function cars()
    {
        return $this->belongsToMany(Car::class, 'car_offer');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)
            ->where(function ($q) {
                $q->whereNull('ends_at')->orWhere('ends_at', '>=', now());
            });
    }

    public function getIsExpiredAttribute(): bool
    {
        return $this->ends_at !== null && $this->ends_at->isPast();
    }

    public function getTimeRemainingAttribute(): ?string
    {
        if ($this->ends_at === null) {
            return null;
        }

        if ($this->ends_at->isPast()) {
            return 'منتهي';
        }

        $now = now();
        $diff = $now->diff($this->ends_at);

        if ($diff->days === 0) {
            return 'ينتهي اليوم';
        }

        if ($diff->days === 1) {
            return 'ينتهي غداً';
        }

        if ($diff->days < 7) {
            return "ينتهي خلال {$diff->days} أيام";
        }

        $weeks = (int) ceil($diff->days / 7);
        if ($diff->days < 30) {
            return "ينتهي خلال {$weeks} ".($weeks === 1 ? 'أسبوع' : 'أسابيع');
        }

        $months = (int) ceil($diff->days / 30);
        if ($diff->days < 365) {
            return "ينتهي خلال {$months} ".($months === 1 ? 'شهر' : 'أشهر');
        }

        $years = (int) ceil($diff->days / 365);

        return "ينتهي خلال {$years} ".($years === 1 ? 'سنة' : 'سنوات');
    }
}
