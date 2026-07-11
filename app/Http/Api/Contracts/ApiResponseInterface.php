<?php

declare(strict_types=1);

namespace App\Http\Api\Contracts;

interface ApiResponseInterface
{
    public function toArray(): array;

    public function getStatusCode(): int;
}
