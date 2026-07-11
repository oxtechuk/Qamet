<?php

declare(strict_types=1);

namespace App\Services\Api\Store;

use App\Models\NewsletterSubscriber;
use App\Services\Api\Store\Data\NewsletterResult;

final class NewsletterApiService
{
    public function subscribe(string $email, ?string $ipAddress = null): NewsletterResult
    {
        $normalizedEmail = strtolower(trim($email));

        $existing = NewsletterSubscriber::where('email', $normalizedEmail)->first();

        if ($existing) {
            if ($existing->is_active) {
                return NewsletterResult::alreadySubscribed();
            }

            $existing->update([
                'is_active' => true,
                'subscribed_at' => now(),
                'unsubscribed_at' => null,
                'ip_address' => $ipAddress,
            ]);

            return NewsletterResult::renewed();
        }

        NewsletterSubscriber::create([
            'email' => $normalizedEmail,
            'is_active' => true,
            'ip_address' => $ipAddress,
            'subscribed_at' => now(),
        ]);

        return NewsletterResult::subscribed();
    }
}
