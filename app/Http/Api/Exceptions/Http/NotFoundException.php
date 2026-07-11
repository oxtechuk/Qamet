<?php

declare(strict_types=1);

namespace App\Http\Api\Exceptions\Http;

use App\Http\Api\Exceptions\ApiException;

final class NotFoundException extends ApiException
{
    public function __construct(string $message = 'Resource not found', int $code = 0, ?\Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public function getStatusCode(): int
    {
        return 404;
    }

    public function getErrorCode(): string
    {
        return 'NOT_FOUND';
    }
}
