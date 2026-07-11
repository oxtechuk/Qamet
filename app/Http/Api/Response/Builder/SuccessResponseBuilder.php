<?php

declare(strict_types=1);

namespace App\Http\Api\Response\Builder;

use App\Http\Api\Contracts\ApiResponse;

final class SuccessResponseBuilder
{
    public function __construct(
        private readonly ApiResponseBuilder $builder,
    ) {}

    public function ok(mixed $data = null, string $message = 'Operation completed successfully'): ApiResponse
    {
        return $this->builder
            ->success(true)
            ->message($message)
            ->data($data)
            ->status(200)
            ->build();
    }

    public function created(mixed $data = null, string $message = 'Resource created successfully'): ApiResponse
    {
        return $this->builder
            ->success(true)
            ->message($message)
            ->data($data)
            ->status(201)
            ->build();
    }

    public function updated(mixed $data = null, string $message = 'Resource updated successfully'): ApiResponse
    {
        return $this->builder
            ->success(true)
            ->message($message)
            ->data($data)
            ->status(200)
            ->build();
    }

    public function deleted(string $message = 'Resource deleted successfully'): ApiResponse
    {
        return $this->builder
            ->success(true)
            ->message($message)
            ->data(null)
            ->status(200)
            ->build();
    }
}
