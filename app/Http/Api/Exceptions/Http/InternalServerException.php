<?php

declare(strict_types=1);

namespace App\Http\Api\Exceptions\Http;

use App\Http\Api\Exceptions\ApiException;

final class InternalServerException extends ApiException
{
    public function __construct(string $message = 'Internal server error', int $code = 0, ?\Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public function getStatusCode(): int
    {
        return 500;
    }

    public function getErrorCode(): string
    {
        return 'INTERNAL_ERROR';
    }
}
