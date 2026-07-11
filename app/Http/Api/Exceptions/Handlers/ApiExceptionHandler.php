<?php

declare(strict_types=1);

namespace App\Http\Api\Exceptions\Handlers;

use App\Http\Api\Exceptions\ApiException;
use App\Http\Api\Response\Builder\ApiResponseBuilder;

final class ApiExceptionHandler
{
    public function __construct(
        private readonly ApiResponseBuilder $builder,
    ) {}

    public function handle(ApiException $e): array
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
}
