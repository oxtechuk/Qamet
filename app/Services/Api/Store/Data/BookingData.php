<?php

declare(strict_types=1);

namespace App\Services\Api\Store\Data;

final class BookingData
{
    public function __construct(
        public readonly ?int $car_id,
        public readonly ?string $car_type,
        public readonly ?string $payment_method,
        public readonly string $client_name,
        public readonly string $client_phone,
        public readonly ?float $down_payment,
        public readonly ?int $duration_years,
        public readonly float $interest_rate,
        public readonly ?int $monthly_installment,
        public readonly ?int $total_price,
        public readonly string $status = 'new',
        public readonly string $source = 'api',
        public readonly ?string $booking_type = null,
        public readonly ?string $location = null,
        public readonly ?string $client_email = null,
        public readonly ?int $age = null,
        public readonly ?string $work_sector = null,
        public readonly ?int $salary = null,
        public readonly ?string $service_duration = null,
        public readonly bool $has_downpayment = false,
        public readonly bool $has_obligations = false,
        public readonly ?int $monthly_obligations = null,
        public readonly ?string $purchase_urgency = null,
        public readonly ?string $company_name = null,
        public readonly ?string $preferred_contact_date = null,
        public readonly ?string $preferred_contact_time = null,
        public readonly ?int $car_count = 1,
        public readonly ?string $notes = null,
        public readonly ?string $ad_platform = null,
        public readonly ?string $utm_source = null,
        public readonly ?string $utm_medium = null,
        public readonly ?string $utm_campaign = null,
        public readonly ?string $utm_content = null,
        public readonly ?string $utm_term = null,
        public readonly ?string $click_id = null,
        public readonly ?string $referrer_url = null,
    ) {}

    public static function detectPlatform(?string $platform, ?string $utmSource, ?string $clickId, ?string $referrer = null): ?string
    {
        if (! empty($platform)) {
            return strtolower(trim($platform));
        }

        $source = strtolower(trim($utmSource ?? ''));
        $click = strtolower(trim($clickId ?? ''));
        $ref = strtolower(trim($referrer ?? ''));

        if (str_contains($source, 'google') || str_contains($source, 'adwords') || str_contains($source, 'youtube') || str_starts_with($click, 'gclid') || str_contains($ref, 'google.')) {
            return 'google';
        }

        if (str_contains($source, 'instagram') || $source === 'ig' || str_contains($source, 'insta') || str_contains($ref, 'instagram.com')) {
            return 'instagram';
        }

        if (str_contains($source, 'facebook') || $source === 'fb' || str_starts_with($click, 'fbclid') || str_contains($ref, 'facebook.com')) {
            return 'facebook';
        }

        if (str_contains($source, 'meta')) {
            return 'meta';
        }

        if (str_contains($source, 'snap') || str_starts_with($click, 'sccid') || str_contains($ref, 'snapchat.com')) {
            return 'snapchat';
        }

        if (str_contains($source, 'tiktok') || str_contains($source, 'tik_tok') || str_starts_with($click, 'ttclid') || str_contains($ref, 'tiktok.com')) {
            return 'tiktok';
        }

        if (str_contains($source, 'twitter') || str_contains($source, 'x.com') || str_contains($ref, 't.co') || str_contains($ref, 'twitter.com')) {
            return 'twitter';
        }

        return ! empty($source) ? $source : null;
    }

    public static function fromRequest(array $validated, ?float $cashPrice = null): self
    {
        $interestRate = isset($validated['interest_rate']) && $validated['interest_rate'] > 0
            ? (float) $validated['interest_rate']
            : (float) config('store-api.booking.default_interest_rate', 4.0);

        $monthlyInstallment = null;
        $totalPrice = null;
        $downPayment = isset($validated['down_payment']) ? (float) $validated['down_payment'] : null;
        $durationYears = isset($validated['duration_years']) ? (int) $validated['duration_years'] : null;

        if ($cashPrice !== null && $durationYears !== null) {
            $principal = max(0, $cashPrice - (float) $downPayment);
            $totalMonths = $durationYears * 12;

            $calculator = new \App\Services\Api\Store\Helpers\InstallmentCalculator;
            $monthly = $calculator->calculate($principal, $totalMonths, $interestRate);

            $monthlyInstallment = (int) round($monthly);
            $totalPrice = (int) round($monthly * $totalMonths + (float) $downPayment);
        }

        $adPlatform = self::detectPlatform(
            $validated['ad_platform'] ?? null,
            $validated['utm_source'] ?? null,
            $validated['click_id'] ?? null,
            $validated['referrer_url'] ?? request()->header('referer')
        );

        return new self(
            car_id: ! empty($validated['car_id']) ? (int) $validated['car_id'] : null,
            car_type: $validated['car_type'] ?? null,
            payment_method: $validated['payment_method'] ?? null,
            client_name: $validated['client_name'],
            client_phone: $validated['client_phone'],
            down_payment: $downPayment,
            duration_years: $durationYears,
            interest_rate: $interestRate,
            monthly_installment: $monthlyInstallment,
            total_price: $totalPrice,
            booking_type: $validated['booking_type'] ?? null,
            location: $validated['location'] ?? null,
            client_email: $validated['client_email'] ?? null,
            age: isset($validated['age']) ? (int) $validated['age'] : null,
            work_sector: $validated['work_sector'] ?? null,
            salary: isset($validated['salary']) ? (int) $validated['salary'] : null,
            service_duration: $validated['service_duration'] ?? null,
            has_downpayment: (bool) ($validated['has_downpayment'] ?? false),
            has_obligations: (bool) ($validated['has_obligations'] ?? false),
            monthly_obligations: isset($validated['monthly_obligations']) ? (int) $validated['monthly_obligations'] : null,
            purchase_urgency: $validated['purchase_urgency'] ?? null,
            company_name: $validated['company_name'] ?? null,
            preferred_contact_date: $validated['preferred_contact_date'] ?? null,
            preferred_contact_time: $validated['preferred_contact_time'] ?? null,
            car_count: isset($validated['car_count']) ? (int) $validated['car_count'] : 1,
            notes: $validated['notes'] ?? null,
            ad_platform: $adPlatform,
            utm_source: $validated['utm_source'] ?? null,
            utm_medium: $validated['utm_medium'] ?? null,
            utm_campaign: $validated['utm_campaign'] ?? null,
            utm_content: $validated['utm_content'] ?? null,
            utm_term: $validated['utm_term'] ?? null,
            click_id: $validated['click_id'] ?? null,
            referrer_url: $validated['referrer_url'] ?? request()->header('referer'),
        );
    }

    public function toDatabase(): array
    {
        return [
            'car_id' => $this->car_id,
            'car_type' => $this->car_type,
            'payment_method' => $this->payment_method,
            'client_name' => $this->client_name,
            'client_phone' => $this->client_phone,
            'down_payment' => $this->down_payment ?? 0,
            'duration_years' => $this->duration_years ?? 0,
            'interest_rate' => $this->interest_rate,
            'monthly_installment' => $this->monthly_installment ?? 0,
            'total_price' => $this->total_price ?? 0,
            'status' => $this->status,
            'source' => $this->source,
            'booking_type' => $this->booking_type,
            'location' => $this->location,
            'client_email' => $this->client_email,
            'age' => $this->age,
            'work_sector' => $this->work_sector,
            'salary' => $this->salary,
            'service_duration' => $this->service_duration,
            'has_downpayment' => $this->has_downpayment,
            'has_obligations' => $this->has_obligations,
            'monthly_obligations' => $this->monthly_obligations,
            'purchase_urgency' => $this->purchase_urgency,
            'company_name' => $this->company_name,
            'preferred_contact_date' => $this->preferred_contact_date,
            'preferred_contact_time' => $this->preferred_contact_time,
            'car_count' => $this->car_count ?? 1,
            'notes' => $this->notes,
            'ad_platform' => $this->ad_platform,
            'utm_source' => $this->utm_source,
            'utm_medium' => $this->utm_medium,
            'utm_campaign' => $this->utm_campaign,
            'utm_content' => $this->utm_content,
            'utm_term' => $this->utm_term,
            'click_id' => $this->click_id,
            'referrer_url' => $this->referrer_url,
        ];
    }
}
