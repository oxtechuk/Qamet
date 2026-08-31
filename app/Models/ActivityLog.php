<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ActivityLog extends Model
{
    protected $fillable = [
        'employee_id',
        'user_name',
        'user_email',
        'action',
        'subject_type',
        'subject_id',
        'subject_title',
        'description',
        'properties',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'properties' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function getActionLabelAttribute(): string
    {
        return match ($this->action) {
            'created' => 'إضافة / إنشاء',
            'updated' => 'تعديل / تحديث',
            'deleted' => 'حذف',
            'completed' => 'إنجاز / إنهاء',
            'status_changed' => 'تغيير حالة',
            'login' => 'تسجيل دخول',
            'logout' => 'تسجيل خروج',
            'restored' => 'استعادة',
            default => $this->action,
        };
    }

    public function getActionColorAttribute(): string
    {
        return match ($this->action) {
            'created' => 'success',
            'updated' => 'info',
            'deleted' => 'danger',
            'completed' => 'success',
            'status_changed' => 'warning',
            'login' => 'gray',
            default => 'primary',
        };
    }
}
