<?php

declare(strict_types=1);

namespace App\Services\Api\Store\Helpers;

final class InstallmentCalculator
{
    public function calculate(float $principal, int $totalMonths, float $annualRate): float
    {
        if ($totalMonths <= 0) {
            return 0;
        }

        $monthlyRate = ($annualRate / 100) / 12;

        if ($monthlyRate <= 0) {
            return $principal / $totalMonths;
        }

        $factor = pow(1 + $monthlyRate, $totalMonths);

        return $principal * ($monthlyRate * $factor) / ($factor - 1);
    }
}
