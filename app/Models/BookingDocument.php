<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookingDocument extends Model
{
    protected $fillable = [
        'booking_id',
        'employee_id',
        'title',
        'file_path',
        'file_type',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
