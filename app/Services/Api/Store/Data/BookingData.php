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
        public readonly ?string $notes = null,
    ) {}

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

        return new self(
            car_id: $validated['car_id'] ? (int) $validated['car_id'] : null,
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
            notes: $validated['notes'] ?? null,
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
            'notes' => $this->notes,
        ];
    }
}
