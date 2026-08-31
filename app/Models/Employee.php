<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class Employee extends Authenticatable implements FilamentUser
{
    use HasRoles, Notifiable;

    public function canAccessPanel(Panel $panel): bool
    {
        return (bool) $this->is_active;
    }

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
        return $this->hasRole('admin', 'employee') || $this->role === 'admin';
    }

    public function hasPermission(string|array $permissions): bool
    {
        if ($this->isAdmin()) {
            return true;
        }

        try {
            if (is_array($permissions)) {
                return $this->hasAnyPermission($permissions, 'employee');
            }

            return $this->hasPermissionTo($permissions, 'employee');
        } catch (\Throwable $e) {
            return false;
        }
    }

    public function isCashRep(): bool
    {
        return $this->isAdmin()
            || $this->hasPermission('manage-cash-bookings')
            || $this->hasPermission('manage-bookings')
            || in_array($this->sales_type, ['cash', 'all']);
    }

    public function isFinanceRep(): bool
    {
        return $this->isAdmin()
            || $this->hasPermission('manage-finance-bookings')
            || $this->hasPermission('manage-bookings')
            || in_array($this->sales_type, ['finance', 'all']);
    }
}
