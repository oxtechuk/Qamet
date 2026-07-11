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
        $primaryCarId = $carIds[0] ?? null;

        return CalculatorLead::create([
            'name' => $data['name'],
            'phone' => $data['phone'],
            'car_id' => $primaryCarId,
            'details' => [
                'email' => $data['email'],
                'city' => $data['city'],
                'salary' => $data['salary'],
                'monthly_obligations' => $data['monthly_obligations'],
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

    public function calculate(int $carId, float $downPaymentPct, int $periodMonths, int $bankId): array
    {
        $car = Car::findOrFail($carId);
        $bank = CalculatorBank::findOrFail($bankId);

        $carPrice = (float) ($car->current_price ?? $car->cash_price);
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
