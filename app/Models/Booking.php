<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Booking extends Model
{
    protected $fillable = [
        'car_id', 'assigned_to', 'client_name', 'client_phone', 'client_email',
        'down_payment', 'duration_years', 'interest_rate', 'monthly_installment',
        'total_price', 'notes', 'status', 'source', 'last_contacted_at',
        'booking_type', 'location',
    ];

    protected $casts = [
        'last_contacted_at' => 'datetime',
    ];

    const BOOKING_TYPES = ['test_drive', 'purchase', 'inquiry'];

    const BOOKING_TYPES_LABELS = [
        'test_drive' => 'تجربة قيادة',
        'purchase' => 'شراء',
        'inquiry' => 'استفسار',
    ];

    const STATUSES = [
        'new' => ['label' => 'جديد',          'color' => 'primary'],
        'contacted' => ['label' => 'تم التواصل',     'color' => 'info'],
        'interested' => ['label' => 'مهتم',           'color' => 'warning'],
        'rejected' => ['label' => 'مرفوض',          'color' => 'danger'],
        'sold' => ['label' => 'تم البيع ✓',     'color' => 'success'],
    ];

    protected static function booted(): void
    {
        static::created(function (Booking $booking) {
            $source = ContactSource::firstOrCreate(
                ['name' => 'طلب حجز من المتجر'],
                ['is_active' => true]
            );

            $existingLead = Lead::where('client_phone', $booking->client_phone)->first();

            if (! $existingLead) {
                Lead::create([
                    'client_name' => $booking->client_name,
                    'client_phone' => $booking->client_phone,
                    'client_email' => $booking->client_email,
                    'contact_source_id' => $source->id,
                    'status' => 'new',
                    'started_at' => now(),
                    'car_id' => $booking->car_id,
                    'assigned_to' => $booking->assigned_to,
                    'status_details' => $booking->notes ?? 'طلب حجز تلقائي من المتجر',
                ]);
            } else {
                $updateData = [];
                if (empty($existingLead->car_id)) {
                    $updateData['car_id'] = $booking->car_id;
                }
                if (empty($existingLead->assigned_to)) {
                    $updateData['assigned_to'] = $booking->assigned_to;
                }
                if (! empty($updateData)) {
                    $existingLead->update($updateData);
                }
            }
        });
    }

    public function car(): BelongsTo
    {
        return $this->belongsTo(Car::class);
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'assigned_to');
    }

    public function assignedTo(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'assigned_to');
    }

    public function notes_list(): HasMany
    {
        return $this->hasMany(BookingNote::class)->latest();
    }

    public function documents(): HasMany
    {
        return $this->hasMany(BookingDocument::class)->latest();
    }

    public function getStatusLabelAttribute(): string
    {
        return self::STATUSES[$this->status]['label'] ?? $this->status;
    }

    public function getStatusColorAttribute(): string
    {
        return self::STATUSES[$this->status]['color'] ?? 'secondary';
    }

    public function scopeNew($query)
    {
        return $query->where('status', 'new');
    }

    public function scopeInProgress($query)
    {
        return $query->whereIn('status', ['contacted', 'interested']);
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'sold');
    }
}
