<?php

declare(strict_types=1);

namespace App\Services\Api\Store;

use App\Models\CalculatorBank;
use App\Models\CalculatorLead;
use App\Models\Car;
use Illuminate\Database\Eloquent\Collection;

final class CalculatorApiService
{
    public function saveLead(array $data): CalculatorLead
    {
        $carIds = $data['car_ids'] ?? [];

        return CalculatorLead::create([
            'name' => $data['name'],
            'phone' => $data['phone'],
            'email' => $data['email'] ?? null,
            'city' => $data['city'] ?? null,
            'salary' => isset($data['salary']) ? (float) $data['salary'] : null,
            'monthly_obligations' => isset($data['monthly_obligations']) ? (float) $data['monthly_obligations'] : null,
            'preferred_bank_id' => $data['preferred_bank_id'] ?? null,
            'car_ids' => $carIds,
            'car_price' => isset($data['car_price']) ? (float) $data['car_price'] : null,
            'notes' => $data['notes'] ?? null,
            'details' => [
                'email' => $data['email'] ?? null,
                'city' => $data['city'] ?? null,
                'salary' => $data['salary'] ?? null,
                'monthly_obligations' => $data['monthly_obligations'] ?? null,
                'preferred_bank_id' => $data['preferred_bank_id'] ?? null,
                'car_ids' => $carIds,
                'notes' => $data['notes'] ?? null,
            ],
        ]);
    }

    public function sendOtp(string $phone): array
    {
        $otpService = app(\App\Services\TwilioOtpService::class);

        $result = $otpService->sendOtp($phone);

        return [
            'success' => $result['success'] ?? false,
            'message' => $result['message'] ?? 'OTP sent',
        ];
    }

    public function verifyOtp(string $phone, string $code): bool
    {
        $otpService = app(\App\Services\TwilioOtpService::class);

        $result = $otpService->verifyOtp($phone, $code);

        return $result['success'] ?? false;
    }

    public function createLeadFromVerified(string $name, string $phone): CalculatorLead
    {
        return CalculatorLead::create([
            'name' => $name,
            'phone' => $phone,
            'details' => [
                'page' => 'calculator_page',
                'otp_verified_at' => now()->toISOString(),
            ],
        ]);
    }

    /** @return Collection<int, CalculatorBank> */
    public function banks(): Collection
    {
        return CalculatorBank::query()->activeOrdered()->get();
    }

    public function calculate(?int $carId, ?float $carPrice, float $downPaymentPct, int $periodMonths, int $bankId): array
    {
        $bank = CalculatorBank::findOrFail($bankId);

        if ($carId) {
            $car = Car::findOrFail($carId);
            $carPrice = (float) ($car->current_price ?? $car->cash_price);
        } else {
            $carPrice = (float) $carPrice;
        }

        $downPaymentAmount = round($carPrice * $downPaymentPct / 100);
        $loanAmount = $carPrice - $downPaymentAmount;
        $annualRate = $bank->annual_rate;
        $monthlyRate = $annualRate / 12 / 100;

        if ($monthlyRate > 0) {
            $compounded = pow(1 + $monthlyRate, $periodMonths);
            $monthlyPayment = round($loanAmount * ($monthlyRate * $compounded) / ($compounded - 1));
        } else {
            $monthlyPayment = round($loanAmount / $periodMonths);
        }

        $totalPayment = $monthlyPayment * $periodMonths;
        $totalInterest = $totalPayment - $loanAmount;

        return [
            'car_price' => $carPrice,
            'down_payment_amount' => $downPaymentAmount,
            'down_payment_percentage' => $downPaymentPct,
            'loan_amount' => $loanAmount,
            'monthly_payment' => $monthlyPayment,
            'period_months' => $periodMonths,
            'total_payment' => $totalPayment,
            'total_interest' => max(0, $totalInterest),
            'annual_rate' => $annualRate,
            'bank' => [
                'id' => $bank->id,
                'name' => $bank->name,
            ],
        ];
    }
}
