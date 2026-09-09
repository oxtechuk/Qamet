<?php

namespace App\Models;

use App\Traits\LogsActivity;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class Employee extends Authenticatable implements FilamentUser
{
    use HasRoles, LogsActivity, Notifiable;

    public function canAccessPanel(Panel $panel): bool
    {
        return (bool) $this->is_active;
    }

    protected $guard_name = 'employee';

    protected $fillable = ['name', 'username', 'email', 'password', 'phone', 'role', 'sales_type', 'receive_auto_assignments', 'is_active', 'avatar'];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'is_active' => 'boolean',
        'receive_auto_assignments' => 'boolean',
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
        $adminRoles = [
            'admin',
            'Admin',
            'super_admin',
            'Super Admin',
            'super-admin',
            'Super-Admin',
            'manager',
            'Manager',
            'مدير',
            'مدير عام',
            'مدير النظام',
            'ادمن',
            'أدمن',
        ];

        $roleString = strtolower(trim((string) $this->role));
        if (in_array($roleString, ['admin', 'super_admin', 'super-admin', 'manager', 'owner']) || in_array($this->role, $adminRoles)) {
            return true;
        }

        try {
            if ($this->hasAnyRole($adminRoles, 'employee') || $this->hasAnyRole($adminRoles)) {
                return true;
            }
        } catch (\Throwable $e) {
            // Guard against Spatie exceptions
        }

        return false;
    }

    public function hasPermission(string|array $permissions): bool
    {
        if ($this->isAdmin()) {
            return true;
        }

        try {
            if (is_array($permissions)) {
                return $this->hasAnyPermission($permissions, 'employee') || $this->hasAnyPermission($permissions);
            }

            return $this->hasPermissionTo($permissions, 'employee') || $this->hasPermissionTo($permissions);
        } catch (\Throwable $e) {
            return false;
        }
    }

    public function canReceiveAutoAssignments(): bool
    {
        if (! (bool) $this->is_active) {
            return false;
        }

        if (array_key_exists('receive_auto_assignments', $this->attributes) && $this->receive_auto_assignments === false) {
            return false;
        }

        if (empty($this->sales_type) || $this->sales_type === 'none') {
            return false;
        }

        return true;
    }

    public function isCashRep(): bool
    {
        return $this->canReceiveAutoAssignments() && in_array($this->sales_type, ['cash', 'all']);
    }

    public function isFinanceRep(): bool
    {
        return $this->canReceiveAutoAssignments() && in_array($this->sales_type, ['finance', 'all']);
    }
}
