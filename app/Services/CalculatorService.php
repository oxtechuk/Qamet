<?php

namespace App\Services;

/**
 * حساب التمويل (قسط شهري) بنفس منطق Car::calculateInstallment.
 */
class CalculatorService
{
    /**
     * @return array{monthly: float, total: float, principal: float, effective_rate: float}
     */
    public function installment(
        float $carPrice,
        float $downPaymentPercent,
        int $months,
        float $annualRatePercent
    ): array {
        $downPayment = round($carPrice * ($downPaymentPercent / 100));
        $principal = max(0, $carPrice - $downPayment);
        $monthlyRate = $annualRatePercent / 100 / 12;

        if ($months < 1) {
            $months = 1;
        }

        if ($monthlyRate <= 0) {
            $monthly = $principal / $months;
        } else {
            $monthly = $principal * ($monthlyRate * pow(1 + $monthlyRate, $months))
                / (pow(1 + $monthlyRate, $months) - 1);
        }

        $total = $monthly * $months + $downPayment;

        return [
            'monthly' => round($monthly, 2),
            'total' => round($total, 2),
            'principal' => (float) $principal,
            'effective_rate' => $annualRatePercent,
        ];
    }

    public function clampAnnualRate(float $rate): float
    {
        return max(0, min(100, $rate));
    }
}
