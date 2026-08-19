<?php

namespace App\Http\Controllers\Api\Core;

use App\Core\ModuleManager;
use App\Http\Controllers\Controller;
use App\Models\Module;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ModuleController extends Controller
{
    /**
     * قائمة بكل الموديولات المسجلة في النظام
     */
    public function index()
    {
        // يجب التأكد من وجود الصلاحية
        // Gate::authorize('modules.manage');

        $modules = Module::all()->map(function ($module) {
            // جلب البيانات الإضافية من ملف module.json لو أردنا
            $manifestPath = base_path("Modules/{$module->alias}/module.json");
            $manifest = file_exists($manifestPath) ? json_decode(file_get_contents($manifestPath), true) : [];

            return [
                'id' => $module->id,
                'alias' => $module->alias,
                'name' => $module->name,
                'description' => $manifest['description_ar'] ?? ($manifest['description'] ?? ''),
                'version' => $module->version,
                'is_active' => (bool) $module->is_active,
                'icon' => $manifest['icon'] ?? 'ri-box-3-line',
                'color' => $manifest['color'] ?? '#6c757d',
            ];
        });

        return response()->json($modules);
    }

    /**
     * تفعيل موديول
     */
    public function enable(Request $request, string $alias)
    {
        // Gate::authorize('modules.manage');

        if (ModuleManager::enable($alias)) {
            return response()->json(['message' => 'تم تفعيل الموديول بنجاح']);
        }

        return response()->json(['message' => 'فشل التفعيل أو الموديول غير موجود'], 400);
    }

    /**
     * إيقاف موديول
     */
    public function disable(Request $request, string $alias)
    {
        // Gate::authorize('modules.manage');

        // لا يمكن إيقاف النواة الأساسية
        if ($alias === 'core') {
            return response()->json(['message' => 'لا يمكن إيقاف النظام الأساسي'], 400);
        }

        if (ModuleManager::disable($alias)) {
            return response()->json(['message' => 'تم إيقاف الموديول بنجاح']);
        }

        return response()->json(['message' => 'فشل الإيقاف'], 400);
    }
}
