<?php

namespace App\Http\Middleware;

use App\Models\Setting;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MaintenanceModeMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $enabled = Setting::where('key', 'maintenance_enabled')->value('value');

        if ($enabled === '1') {
            $allowedIps = Setting::where('key', 'maintenance_allowed_ips')->value('value') ?? '';
            $allowedIps = array_map('trim', array_filter(explode("\n", (string) $allowedIps)));

            if (! in_array($request->ip(), $allowedIps)) {
                $title = Setting::where('key', 'maintenance_title')->value('value') ?? __('نحن نعود قريباً');
                $message = Setting::where('key', 'maintenance_message')->value('value') ?? __('نقوم حالياً بتحديث الموقع لتحسين تجربتك.');
                $image = Setting::where('key', 'maintenance_image')->value('value');

                return response()->view('maintenance', compact('title', 'message', 'image'));
            }
        }

        return $next($request);
    }
}
