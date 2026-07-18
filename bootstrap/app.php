<?php

use App\Http\Api\Exceptions\Handlers\GlobalExceptionHandler;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        then: function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/store-api.php'));
        },
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->web(append: [
            \App\Http\Middleware\LocalizationMiddleware::class,
        ]);

        $middleware->api(prepend: [
            \App\Http\Middleware\ApiLocalizationMiddleware::class,
        ]);

        $middleware->alias([
            'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
            'guard.employee' => \App\Http\Middleware\SetEmployeeGuard::class,
            'maintenance' => \App\Http\Middleware\MaintenanceModeMiddleware::class,
        ]);

        $middleware->redirectTo(
            guests: function ($request) {
                if ($request->is('admin') || $request->is('admin/*')) {
                    return route('filament.admin.auth.login');
                }

                return route('store.auth.login');
            }
        );
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (\Throwable $e, Request $request) {
            return app(GlobalExceptionHandler::class)->render($e, $request);
        });

        $exceptions->render(function (NotFoundHttpException $e, Request $request) {
            if ($request->expectsJson()) {
                return response()->json(['message' => __('Not Found')], 404);
            }

            return response()->view('errors.404', [], 404);
        });

        $exceptions->render(function (AccessDeniedHttpException $e, Request $request) {
            if ($request->expectsJson()) {
                return response()->json(['message' => __('Forbidden')], 403);
            }

            return response()->view('errors.403', [], 403);
        });

        $exceptions->render(function (ModelNotFoundException $e, Request $request) {
            if ($request->expectsJson()) {
                return response()->json(['message' => __('Resource not found')], 404);
            }

            return response()->view('errors.404', [], 404);
        });

        $exceptions->render(function (HttpException $e, Request $request) {
            $statusCode = $e->getStatusCode();

            if ($request->expectsJson()) {
                return response()->json(['message' => $e->getMessage() ?: __('Error')], $statusCode);
            }

            if (view()->exists("errors.{$statusCode}")) {
                return response()->view("errors.{$statusCode}", ['exception' => $e], $statusCode);
            }
        });

        $exceptions->render(function (AuthenticationException $e, Request $request) {
            if ($request->expectsJson() || $request->is('api/*') || $request->is('erp/*')) {
                return response()->json(['message' => __('Unauthenticated')], 401);
            }

            if ($request->is('admin') || $request->is('admin/*')) {
                return redirect()->guest(route('filament.admin.auth.login'));
            }

            return redirect()->guest(route('store.auth.login'));
        });
    })->create();
