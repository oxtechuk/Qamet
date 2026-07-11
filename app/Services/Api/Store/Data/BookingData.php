<?php

declare(strict_types=1);

namespace App\Services\Api\Store\Data;

final class BookingData
{
    public function __construct(
        public readonly int $car_id,
        public readonly string $client_name,
        public readonly string $client_phone,
        public readonly float $down_payment,
        public readonly int $duration_years,
        public readonly float $interest_rate,
        public readonly int $monthly_installment,
        public readonly int $total_price,
        public readonly string $status = 'new',
        public readonly string $source = 'api',
        public readonly ?string $booking_type = null,
        public readonly ?string $location = null,
    ) {}

    public static function fromRequest(array $validated, float $cashPrice): self
    {
        $interestRate = isset($validated['interest_rate']) && $validated['interest_rate'] > 0
            ? (float) $validated['interest_rate']
            : (float) config('store-api.booking.default_interest_rate', 4.0);

        $principal = max(0, $cashPrice - (float) $validated['down_payment']);
        $totalMonths = (int) $validated['duration_years'] * 12;

        $calculator = new \App\Services\Api\Store\Helpers\InstallmentCalculator;
        $monthly = $calculator->calculate($principal, $totalMonths, $interestRate);

        return new self(
            car_id: (int) $validated['car_id'],
            client_name: $validated['client_name'],
            client_phone: $validated['client_phone'],
            down_payment: (float) $validated['down_payment'],
            duration_years: (int) $validated['duration_years'],
            interest_rate: $interestRate,
            monthly_installment: (int) round($monthly),
            total_price: (int) round($monthly * $totalMonths + (float) $validated['down_payment']),
            booking_type: $validated['booking_type'] ?? null,
            location: $validated['location'] ?? null,
        );
    }

    public function toDatabase(): array
    {
        return [
            'car_id' => $this->car_id,
            'client_name' => $this->client_name,
            'client_phone' => $this->client_phone,
            'down_payment' => $this->down_payment,
            'duration_years' => $this->duration_years,
            'interest_rate' => $this->interest_rate,
            'monthly_installment' => $this->monthly_installment,
            'total_price' => $this->total_price,
            'status' => $this->status,
            'source' => $this->source,
            'booking_type' => $this->booking_type,
            'location' => $this->location,
        ];
    }
}
