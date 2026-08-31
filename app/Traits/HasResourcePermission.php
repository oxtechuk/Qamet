<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

trait HasResourcePermission
{
    public static function canViewAny(): bool
    {
        $user = Auth::guard('employee')->user();

        if (! $user) {
            return false;
        }

        if ($user->isAdmin()) {
            return true;
        }

        $permission = static::getResourcePermission();

        if (! $permission) {
            return true;
        }

        return $user->hasPermission($permission);
    }

    public static function canCreate(): bool
    {
        return static::canViewAny();
    }

    public static function canEdit(Model $record): bool
    {
        return static::canViewAny();
    }

    public static function canDelete(Model $record): bool
    {
        return static::canViewAny();
    }

    public static function canDeleteAny(): bool
    {
        return static::canViewAny();
    }

    public static function getResourcePermission(): string|array|null
    {
        return static::$permission ?? null;
    }
}
