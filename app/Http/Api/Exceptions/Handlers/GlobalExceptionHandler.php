<?php

declare(strict_types=1);

namespace App\Http\Api\Exceptions\Handlers;

use App\Http\Api\Exceptions\ApiException;
use App\Http\Api\Response\Builder\ApiResponseBuilder;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException as LaravelValidationException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final class GlobalExceptionHandler
{
    public function __construct(
        private readonly ApiResponseBuilder $builder,
    ) {}

    public function render(\Throwable $e, Request $request): ?array
    {
        if (! $request->expectsJson() && ! $request->is('api/*') && ! $request->is('erp/*')) {
            return null;
        }

        return match (true) {
            $e instanceof ApiException => $this->handleApiException($e),
            $e instanceof LaravelValidationException => $this->handleValidationException($e),
            $e instanceof AuthenticationException => $this->error('Unauthenticated', 401),
            $e instanceof ModelNotFoundException, $e instanceof NotFoundHttpException => $this->error('Resource not found', 404),
            $e instanceof AuthorizationException, $e instanceof AccessDeniedHttpException => $this->error('Forbidden', 403),
            $e instanceof HttpException => $this->error($e->getMessage() ?: 'HTTP error', $e->getStatusCode()),
            default => $this->handleGenericException($e),
        };
    }

    private function handleApiException(ApiException $e): array
    {
        $response = $this->builder
            ->success(false)
            ->message($e->getMessage())
            ->status($e->getStatusCode());

        if ($e->getDetails() !== null) {
            $response->errors($e->getDetails());
        }

        return $response->build()->toArray();
    }

    private function handleValidationException(LaravelValidationException $e): array
    {
        return $this->builder
            ->success(false)
            ->message('Validation failed')
            ->errors($e->errors())
            ->status(422)
            ->build()
            ->toArray();
    }

    private function error(string $message, int $status): array
    {
        return $this->builder
            ->success(false)
            ->message($message)
            ->status($status)
            ->build()
            ->toArray();
    }

    private function handleGenericException(\Throwable $e): array
    {
        logger()->error($e->getMessage(), [
            'exception' => $e::class,
            'file' => $e->getFile(),
            'line' => $e->getLine(),
        ]);

        if (config('app.debug')) {
            return $this->builder
                ->success(false)
                ->message($e->getMessage())
                ->data([
                    'exception' => $e::class,
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                    'trace' => $e->getTraceAsString(),
                ])
                ->status(500)
                ->build()
                ->toArray();
        }

        return $this->error('Internal server error', 500);
    }
}
