<?php

declare(strict_types=1);

namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

final class AsImageUrl implements CastsAttributes
{
    public function get(Model $model, string $key, mixed $value, array $attributes): ?string
    {
        if ($value === null) {
            return null;
        }
        if (str_starts_with($value, 'http://') || str_starts_with($value, 'https://') || $this->isWebRequest()) {
            return $value;
        }

        return Storage::disk('public')->url($value);
    }

    public function set(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        return $value;
    }

    private function isWebRequest(): bool
    {
        $accept = request()->header('Accept', '');

        if (empty($accept)) {
            return true;
        }

        return ! str_contains($accept, 'application/json');
    }
}
