<?php

declare(strict_types=1);

namespace App\Services\Api\Store\Data;

final class NewsletterResult
{
    public function __construct(
        public readonly string $message,
        public readonly int $statusCode,
    ) {}

    public function isError(): bool
    {
        return $this->statusCode >= 400;
    }

    public static function alreadySubscribed(): self
    {
        return new self(
            message: __('store-api.newsletter.already_subscribed'),
            statusCode: 409,
        );
    }

    public static function renewed(): self
    {
        return new self(
            message: __('store-api.newsletter.renewed'),
            statusCode: 200,
        );
    }

    public static function subscribed(): self
    {
        return new self(
            message: __('store-api.newsletter.subscribed'),
            statusCode: 201,
        );
    }
}
