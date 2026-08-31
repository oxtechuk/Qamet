<?php

namespace App\Models;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Lead extends Model
{
    use LogsActivity;

    protected $fillable = [
        'client_name',
        'client_phone',
        'client_email',
        'subject',
        'country',
        'contact_source_id',
        'status',
        'started_at',
        'status_details',
        'car_id',
        'assigned_to',
    ];

    protected function casts(): array
    {
        return [
            'started_at' => 'date',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (Lead $lead) {
            if (empty($lead->started_at)) {
                $lead->started_at = now();
            }
        });
    }

    public const STATUSES = [
        'new' => ['label' => 'جديد', 'color' => 'primary'],
        'contacted' => ['label' => 'تم التواصل', 'color' => 'info'],
        'interested' => ['label' => 'مهتم', 'color' => 'warning'],
        'negotiation' => ['label' => 'قيد التفاوض', 'color' => 'secondary'],
        'converted' => ['label' => 'تم التحويل', 'color' => 'success'],
        'lost' => ['label' => 'غير مهتم / مغلق', 'color' => 'danger'],
    ];

    public function contactSource(): BelongsTo
    {
        return $this->belongsTo(ContactSource::class);
    }

    public function car(): BelongsTo
    {
        return $this->belongsTo(Car::class);
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'assigned_to');
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Booking::class, 'client_phone', 'client_phone');
    }

    public function assignedTo(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'assigned_to');
    }

    public function getStatusLabelAttribute(): string
    {
        return self::STATUSES[$this->status]['label'] ?? $this->status;
    }

    public function getStatusColorAttribute(): string
    {
        return self::STATUSES[$this->status]['color'] ?? 'secondary';
    }
}
