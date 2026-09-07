<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

trait HasResourcePermission
{
    protected static function getAuthenticatedUser()
    {
        return Auth::guard('employee')->user() ?? auth()->user();
    }

    public static function canViewAny(): bool
    {
        $user = static::getAuthenticatedUser();

        if (! $user) {
            return false;
        }

        if (method_exists($user, 'isAdmin') && $user->isAdmin()) {
            return true;
        }

        $permission = static::getResourcePermission();

        if (! $permission) {
            return true;
        }

        if (method_exists($user, 'hasPermission')) {
            return $user->hasPermission($permission);
        }

        return true;
    }

    public static function canView(Model $record): bool
    {
        return static::canViewAny();
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
