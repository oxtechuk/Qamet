<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class LocalizationMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // LanguageSwitch session key ('locale') takes priority — it's the actively switched locale.
        // Fall back to 'applocale', then default to Arabic.
        $locale = match (true) {
            Session::has('locale') => Session::get('locale'),
            Session::has('applocale') => Session::get('applocale'),
            default => 'ar',
        };

        App::setLocale($locale);
        Session::put('applocale', $locale);
        Session::put('locale', $locale);

        return $next($request);
    }
}
