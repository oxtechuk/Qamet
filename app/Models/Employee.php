<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class Employee extends Authenticatable
{
    use HasRoles, Notifiable;

    protected $guard_name = 'employee';

    protected $fillable = ['name', 'username', 'email', 'password', 'phone', 'role', 'sales_type', 'is_active', 'avatar'];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'is_active' => 'boolean',
        'password' => 'hashed',
    ];

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class, 'assigned_to');
    }

    public function notes(): HasMany
    {
        return $this->hasMany(BookingNote::class);
    }

    public function isAdmin(): bool
    {
        return $this->hasRole('admin') || $this->role === 'admin';
    }

    public function isCashRep(): bool
    {
        return $this->isAdmin()
            || in_array($this->sales_type, ['cash', 'all'])
            || $this->hasPermissionTo('manage-cash-bookings', 'employee')
            || $this->hasPermissionTo('manage-bookings', 'employee');
    }

    public function isFinanceRep(): bool
    {
        return $this->isAdmin()
            || in_array($this->sales_type, ['finance', 'all'])
            || $this->hasPermissionTo('manage-finance-bookings', 'employee')
            || $this->hasPermissionTo('manage-bookings', 'employee');
    }
}
