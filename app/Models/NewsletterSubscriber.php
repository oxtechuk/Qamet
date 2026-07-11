<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsletterSubscriber extends Model
{
    protected $fillable = [
        'email',
        'is_active',
        'ip_address',
        'subscribed_at',
        'unsubscribed_at',
    ];

    protected $casts = [
        'is_active'       => 'boolean',
        'subscribed_at'   => 'datetime',
        'unsubscribed_at' => 'datetime',
    ];

    // Scope: المشتركون الفعّالون فقط
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Scope: اشتركوا هذا الشهر
    public function scopeThisMonth($query)
    {
        return $query->whereMonth('subscribed_at', now()->month)
                     ->whereYear('subscribed_at', now()->year);
    }
}
