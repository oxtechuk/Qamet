<?php

declare(strict_types=1);

namespace App\Http\Api\Exceptions;

abstract class ApiException extends \RuntimeException
{
    abstract public function getStatusCode(): int;

    abstract public function getErrorCode(): string;

    public function getDetails(): ?array
    {
        return null;
    }

    public function render(): array
    {
        return [
            'success' => false,
            'message' => $this->getMessage(),
            'error_code' => $this->getErrorCode(),
            'details' => $this->getDetails(),
        ];
    }
}
