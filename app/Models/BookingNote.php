<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BookingNote extends Model
{
    protected $fillable = ['booking_id', 'employee_id', 'note', 'type', 'old_status', 'new_status'];

    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }
}
