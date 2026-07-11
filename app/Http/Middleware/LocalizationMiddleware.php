<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class LocalizationMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Session::has('applocale')) {
            App::setLocale(Session::get('applocale'));
        } else {
            // Default to Arabic
            App::setLocale('ar');
            Session::put('applocale', 'ar');
        }

        return $next($request);
    }
}
