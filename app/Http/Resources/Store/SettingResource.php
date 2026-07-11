<?php

namespace App\Http\Resources\Store;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SettingResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'key' => $this->resource['key'],
            'value' => $this->resolveTranslatable($this->resource['value'] ?? null),
        ];
    }

    private function resolveTranslatable(mixed $value, ?string $locale = null): mixed
    {
        $locale ??= app()->getLocale();

        if (! is_array($value)) {
            return $value;
        }

        if ($this->isTranslatableArray($value)) {
            return $value[$locale] ?? null;
        }

        foreach ($value as $key => $item) {
            $value[$key] = $this->resolveTranslatable($item, $locale);
        }

        return $value;
    }

    private function isTranslatableArray(array $value): bool
    {
        if (array_is_list($value)) {
            return false;
        }

        return array_key_exists('en', $value) || array_key_exists('ar', $value);
    }
}
