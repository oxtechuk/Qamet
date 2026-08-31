<?php

declare(strict_types=1);

namespace App\Services\ActivityLog;

use App\Models\ActivityLog;
use App\Models\Employee;
use Filament\Facades\Filament;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class ActivityLogger
{
    /**
     * Log a general activity.
     */
    public static function log(
        string $action,
        ?string $subjectType = null,
        mixed $subjectId = null,
        ?string $subjectTitle = null,
        ?string $description = null,
        ?array $properties = null,
        ?Employee $employee = null
    ): ?ActivityLog {
        try {
            $user = $employee ?: self::getCurrentEmployee();

            return ActivityLog::create([
                'employee_id' => $user?->id,
                'user_name' => $user?->name ?: ($user ? 'موظف #'.$user->id : 'النظام / زائر'),
                'user_email' => $user?->email,
                'action' => $action,
                'subject_type' => $subjectType,
                'subject_id' => $subjectId ? (string) $subjectId : null,
                'subject_title' => $subjectTitle,
                'description' => $description,
                'properties' => $properties,
                'ip_address' => Request::ip(),
                'user_agent' => Request::userAgent(),
            ]);
        } catch (\Throwable $e) {
            // Silently fail logging so main business logic is never blocked
            report($e);

            return null;
        }
    }

    /**
     * Log a model creation.
     */
    public static function created(Model $model, ?string $title = null, ?string $customSubjectType = null): ?ActivityLog
    {
        $type = $customSubjectType ?: self::getModelNameArabic($model);
        $title = $title ?: self::extractTitle($model);

        return self::log(
            action: 'created',
            subjectType: $type,
            subjectId: $model->getKey(),
            subjectTitle: $title,
            description: "قام بإضافة {$type}: {$title}",
            properties: [
                'attributes' => self::filterSensitiveAttributes($model->getAttributes()),
            ]
        );
    }

    /**
     * Log a model update.
     */
    public static function updated(Model $model, ?string $title = null, ?string $customSubjectType = null): ?ActivityLog
    {
        $type = $customSubjectType ?: self::getModelNameArabic($model);
        $title = $title ?: self::extractTitle($model);

        $dirty = $model->getDirty();
        $original = [];

        foreach (array_keys($dirty) as $key) {
            $original[$key] = $model->getOriginal($key);
        }

        // Ignore timestamps only update
        if (count($dirty) === 1 && isset($dirty['updated_at'])) {
            return null;
        }

        $filteredDirty = self::filterSensitiveAttributes($dirty);
        $filteredOriginal = self::filterSensitiveAttributes($original);

        if (empty($filteredDirty)) {
            return null;
        }

        $description = "قام بتعديل {$type}: {$title}";

        // Specific description if status was changed
        if (isset($filteredDirty['status']) || isset($filteredDirty['availability_status'])) {
            $newStatus = $filteredDirty['status'] ?? $filteredDirty['availability_status'];
            $oldStatus = $filteredOriginal['status'] ?? $filteredOriginal['availability_status'] ?? '';
            $description = "قام بتغيير حالة {$type} ({$title}) من [{$oldStatus}] إلى [{$newStatus}]";
        }

        return self::log(
            action: (isset($filteredDirty['status']) || isset($filteredDirty['availability_status'])) ? 'status_changed' : 'updated',
            subjectType: $type,
            subjectId: $model->getKey(),
            subjectTitle: $title,
            description: $description,
            properties: [
                'old' => $filteredOriginal,
                'new' => $filteredDirty,
            ]
        );
    }

    /**
     * Log a model deletion.
     */
    public static function deleted(Model $model, ?string $title = null, ?string $customSubjectType = null): ?ActivityLog
    {
        $type = $customSubjectType ?: self::getModelNameArabic($model);
        $title = $title ?: self::extractTitle($model);

        return self::log(
            action: 'deleted',
            subjectType: $type,
            subjectId: $model->getKey(),
            subjectTitle: $title,
            description: "قام بحذف {$type}: {$title}",
            properties: [
                'attributes' => self::filterSensitiveAttributes($model->getAttributes()),
            ]
        );
    }

    /**
     * Log task completion.
     */
    public static function completed(Model $model, ?string $title = null, ?string $customSubjectType = null): ?ActivityLog
    {
        $type = $customSubjectType ?: self::getModelNameArabic($model);
        $title = $title ?: self::extractTitle($model);

        return self::log(
            action: 'completed',
            subjectType: $type,
            subjectId: $model->getKey(),
            subjectTitle: $title,
            description: "قام بإنجاز وإنهاء {$type}: {$title}",
            properties: [
                'attributes' => self::filterSensitiveAttributes($model->getAttributes()),
            ]
        );
    }

    /**
     * Extract a human-readable title from a model.
     */
    public static function extractTitle(Model $model): string
    {
        if (isset($model->name)) {
            return is_array($model->name) ? ($model->name['ar'] ?? $model->name['en'] ?? '') : (string) $model->name;
        }

        if (isset($model->title)) {
            return is_array($model->title) ? ($model->title['ar'] ?? $model->title['en'] ?? '') : (string) $model->title;
        }

        if (isset($model->name_ar) && ! empty($model->name_ar)) {
            return (string) $model->name_ar;
        }

        if (isset($model->name_en) && ! empty($model->name_en)) {
            return (string) $model->name_en;
        }

        if (isset($model->booking_number)) {
            return (string) $model->booking_number;
        }

        if (isset($model->phone)) {
            return (string) $model->phone;
        }

        return '#'.$model->getKey();
    }

    /**
     * Get Arabic name for model class.
     */
    public static function getModelNameArabic(Model $model): string
    {
        $class = class_basename($model);

        return match ($class) {
            'Car' => 'سيارة',
            'Booking' => 'طلب حجز',
            'Task' => 'مهمة',
            'Lead' => 'عميل محتمل',
            'Offer' => 'عرض خاص',
            'Employee' => 'موظف',
            'Brand' => 'ماركة / علامة تجارية',
            'BlogPost' => 'مقال مدونة',
            'Setting' => 'إعدادات النظام',
            'Branch' => 'فرع',
            'CalculatorBank' => 'بنك تمويل',
            'CalculatorFactor' => 'حسبة تمويل',
            default => $class,
        };
    }

    /**
     * Get current authenticated employee.
     */
    public static function getCurrentEmployee(): ?Employee
    {
        try {
            $filamentUser = Filament::auth()->user();
            if ($filamentUser instanceof Employee) {
                return $filamentUser;
            }

            $guardUser = Auth::guard('employee')->user();
            if ($guardUser instanceof Employee) {
                return $guardUser;
            }

            $defaultUser = Auth::user();
            if ($defaultUser instanceof Employee) {
                return $defaultUser;
            }

            if ($defaultUser) {
                return Employee::where('email', $defaultUser->email)->first();
            }
        } catch (\Throwable $e) {
            return null;
        }

        return null;
    }

    /**
     * Filter out passwords, tokens and binary data from properties.
     */
    private static function filterSensitiveAttributes(array $attributes): array
    {
        $sensitiveKeys = [
            'password', 'remember_token', 'capi_token', 'two_factor_secret',
            'two_factor_recovery_codes', 'token', 'access_token',
        ];

        foreach ($sensitiveKeys as $key) {
            unset($attributes[$key]);
        }

        return $attributes;
    }
}
