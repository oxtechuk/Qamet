<?php

declare(strict_types=1);

namespace App\Traits;

use App\Services\ActivityLog\ActivityLogger;
use Illuminate\Database\Eloquent\Model;

trait LogsActivity
{
    public static function bootLogsActivity(): void
    {
        static::created(function (Model $model) {
            ActivityLogger::created($model);
        });

        static::updated(function (Model $model) {
            ActivityLogger::updated($model);
        });

        static::deleted(function (Model $model) {
            ActivityLogger::deleted($model);
        });
    }
}
