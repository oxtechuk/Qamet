<?php

namespace App\Models;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Booking extends Model
{
    use LogsActivity;

    protected $fillable = [
        'car_id', 'car_type', 'car_count', 'payment_method', 'assigned_to', 'client_name',
        'company_name', 'client_phone', 'client_email', 'age', 'work_sector', 'salary',
        'service_duration', 'has_downpayment', 'has_obligations', 'monthly_obligations',
        'purchase_urgency', 'preferred_contact_date', 'preferred_contact_time', 'down_payment', 'duration_years',
        'interest_rate', 'monthly_installment', 'total_price', 'notes', 'status',
        'source', 'last_contacted_at', 'booking_type', 'location',
    ];

    protected $casts = [
        'last_contacted_at' => 'datetime',
        'has_downpayment' => 'boolean',
        'has_obligations' => 'boolean',
        'age' => 'integer',
        'salary' => 'integer',
        'monthly_obligations' => 'integer',
        'car_count' => 'integer',
    ];

    const BOOKING_TYPES = ['test_drive', 'purchase', 'inquiry', 'corporate'];

    const BOOKING_TYPES_LABELS = [
        'test_drive' => 'تجربة قيادة',
        'purchase' => 'شراء أفراد',
        'inquiry' => 'استفسار',
        'corporate' => 'تمويل شركات',
    ];

    const STATUSES = [
        'new' => ['label' => 'جديد', 'color' => 'primary'],
        'contacted' => ['label' => 'تم التواصل', 'color' => 'info'],
        'interested' => ['label' => 'مهتم', 'color' => 'warning'],
        'negotiation' => ['label' => 'تفاوض / عروض', 'color' => 'warning'],
        'under_review' => ['label' => 'طلب إغلاق / مراجعة الإدارة', 'color' => 'danger'],
        'rejected' => ['label' => 'مرفوض', 'color' => 'danger'],
        'cancelled' => ['label' => 'ملغي', 'color' => 'gray'],
        'sold' => ['label' => 'تم البيع ✓', 'color' => 'success'],
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

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class)->latest();
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

    public function scopeCancelled($query)
    {
        return $query->where('status', 'rejected');
    }

    public function scopeCash($query)
    {
        return $query->where('payment_method', 'cash');
    }

    public function scopeFinance($query)
    {
        return $query->where(function ($q) {
            $q->whereIn('payment_method', ['bank', 'finance', 'installment'])
                ->orWhereNull('payment_method');
        });
    }

    public function scopeUnderReview($query)
    {
        return $query->where('status', 'under_review');
    }

    public function scopeCorporate($query)
    {
        return $query->where('booking_type', 'corporate');
    }
}
