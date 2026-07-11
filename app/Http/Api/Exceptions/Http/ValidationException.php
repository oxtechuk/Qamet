<?php

declare(strict_types=1);

namespace App\Http\Api\Exceptions\Http;

use App\Http\Api\Exceptions\ApiException;

final class ValidationException extends ApiException
{
    public function __construct(
        string $message = 'Validation failed',
        private readonly ?array $errors = null,
        int $code = 0,
        ?\Throwable $previous = null,
    ) {
        parent::__construct($message, $code, $previous);
    }

    public function getStatusCode(): int
    {
        return 422;
    }

    public function getErrorCode(): string
    {
        return 'VALIDATION_ERROR';
    }

    public function getDetails(): ?array
    {
        return $this->errors;
    }
}
