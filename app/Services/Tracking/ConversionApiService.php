<?php

declare(strict_types=1);

namespace App\Services\Tracking;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

final class ConversionApiService
{
    /**
     * Send server-side conversion event to Meta, TikTok, and Snapchat
     *
     * @param  array{
     *     event_id?: string,
     *     event_name?: string,
     *     email?: string|null,
     *     phone?: string|null,
     *     ip_address?: string|null,
     *     user_agent?: string|null,
     *     value?: float|int|null,
     *     currency?: string,
     *     content_name?: string|null,
     *     content_category?: string|null,
     *     custom_data?: array<string, mixed>
     * }  $payload
     */
    public function sendLeadEvent(array $payload): void
    {
        $eventId = $payload['event_id'] ?? ('srv_'.round(microtime(true) * 1000).'_'.bin2hex(random_bytes(4)));
        $eventName = $payload['event_name'] ?? 'Lead';
        $email = ! empty($payload['email']) ? $this->hashString(trim(strtolower((string) $payload['email']))) : null;
        $phone = ! empty($payload['phone']) ? $this->hashPhone((string) $payload['phone']) : null;
        $ip = $payload['ip_address'] ?? request()->ip();
        $userAgent = $payload['user_agent'] ?? request()->userAgent();
        $value = (float) ($payload['value'] ?? 0);
        $currency = $payload['currency'] ?? 'SAR';
        $contentName = $payload['content_name'] ?? 'Car Booking';

        // 1. Send to Meta Conversions API (CAPI)
        $this->sendToMeta([
            'event_id' => $eventId,
            'event_name' => $eventName,
            'email_hash' => $email,
            'phone_hash' => $phone,
            'ip' => $ip,
            'user_agent' => $userAgent,
            'value' => $value,
            'currency' => $currency,
            'content_name' => $contentName,
        ]);

        // 2. Send to TikTok Events API
        $this->sendToTikTok([
            'event_id' => $eventId,
            'event_name' => 'SubmitForm',
            'email_hash' => $email,
            'phone_hash' => $phone,
            'ip' => $ip,
            'user_agent' => $userAgent,
            'value' => $value,
            'currency' => $currency,
            'content_name' => $contentName,
        ]);

        // 3. Send to Snapchat Conversions API
        $this->sendToSnapchat([
            'event_id' => $eventId,
            'event_name' => 'SIGN_UP',
            'email_hash' => $email,
            'phone_hash' => $phone,
            'ip' => $ip,
            'user_agent' => $userAgent,
            'value' => $value,
            'currency' => $currency,
            'content_name' => $contentName,
        ]);
    }

    private function httpClient(): \Illuminate\Http\Client\PendingRequest
    {
        return app()->isLocal()
            ? Http::withoutVerifying()->timeout(5)
            : Http::timeout(5);
    }

    private function sendToMeta(array $data): void
    {
        $pixelId = config('services.meta.pixel_id');
        $token = config('services.meta.capi_token');

        if (! $pixelId || ! $token) {
            return;
        }

        try {
            $userData = array_filter([
                'em' => $data['email_hash'] ? [$data['email_hash']] : null,
                'ph' => $data['phone_hash'] ? [$data['phone_hash']] : null,
                'client_ip_address' => $data['ip'],
                'client_user_agent' => $data['user_agent'],
            ]);

            $customData = array_filter([
                'currency' => $data['currency'],
                'value' => $data['value'] > 0 ? $data['value'] : null,
                'content_name' => $data['content_name'],
            ]);

            $response = $this->httpClient()->post("https://graph.facebook.com/v19.0/{$pixelId}/events", [
                'access_token' => $token,
                'data' => [
                    [
                        'event_name' => $data['event_name'],
                        'event_time' => time(),
                        'event_id' => $data['event_id'],
                        'action_source' => 'website',
                        'user_data' => $userData,
                        'custom_data' => $customData,
                    ],
                ],
            ]);

            if (! $response->successful()) {
                Log::debug('[Meta CAPI] Event response: '.$response->body());
            }
        } catch (\Throwable $e) {
            Log::debug('[Meta CAPI] Error: '.$e->getMessage());
        }
    }

    private function sendToTikTok(array $data): void
    {
        $pixelId = config('services.tiktok.pixel_id');
        $token = config('services.tiktok.capi_token');

        if (! $pixelId || ! $token) {
            return;
        }

        try {
            $user = array_filter([
                'phone' => $data['phone_hash'],
                'email' => $data['email_hash'],
                'ip' => $data['ip'],
                'user_agent' => $data['user_agent'],
            ]);

            $response = $this->httpClient()->withHeaders([
                'Access-Token' => $token,
                'Content-Type' => 'application/json',
            ])->post('https://business-api.tiktok.com/open_api/v1.3/event/track/', [
                'event_source' => 'web',
                'event_source_id' => $pixelId,
                'data' => [
                    [
                        'event' => $data['event_name'],
                        'event_id' => $data['event_id'],
                        'event_time' => time(),
                        'user' => $user,
                        'properties' => array_filter([
                            'currency' => $data['currency'],
                            'value' => $data['value'] > 0 ? $data['value'] : null,
                            'content_name' => $data['content_name'],
                        ]),
                    ],
                ],
            ]);

            if (! $response->successful()) {
                Log::debug('[TikTok CAPI] Event response: '.$response->body());
            }
        } catch (\Throwable $e) {
            Log::debug('[TikTok CAPI] Error: '.$e->getMessage());
        }
    }

    private function sendToSnapchat(array $data): void
    {
        $pixelId = config('services.snapchat.pixel_id');
        $token = config('services.snapchat.capi_token');

        if (! $pixelId || ! $token) {
            return;
        }

        try {
            $payload = array_filter([
                'pixel_id' => $pixelId,
                'event_type' => $data['event_name'],
                'event_conversion_type' => 'WEB',
                'event_id' => $data['event_id'],
                'timestamp' => (string) round(microtime(true) * 1000),
                'hashed_email' => $data['email_hash'],
                'hashed_phone_number' => $data['phone_hash'],
                'client_ip_address' => $data['ip'],
                'client_user_agent' => $data['user_agent'],
                'price' => $data['value'] > 0 ? $data['value'] : null,
                'currency' => $data['currency'],
            ]);

            $response = $this->httpClient()
                ->withToken($token)
                ->post('https://tr.snapchat.com/v2/conversion', $payload);

            if (! $response->successful()) {
                Log::debug('[Snapchat CAPI] Event response: '.$response->body());
            }
        } catch (\Throwable $e) {
            Log::debug('[Snapchat CAPI] Error: '.$e->getMessage());
        }
    }

    private function hashString(string $val): string
    {
        return hash('sha256', $val);
    }

    private function hashPhone(string $phone): string
    {
        // Normalize Saudi / International phone numbers: remove all non-digits
        $clean = preg_replace('/\D/', '', $phone) ?? '';

        // If local 05XXXXXXXX, normalize to 9665XXXXXXXX
        if (str_starts_with($clean, '05') && strlen($clean) === 10) {
            $clean = '966'.substr($clean, 1);
        }

        return hash('sha256', $clean);
    }
}
