<?php

namespace App\Observers;

use App\Models\CalculatorFactor;
use App\Services\Cache\CalculatorCacheService;

class CalculatorFactorObserver
{
    public function __construct(
        private CalculatorCacheService $calculatorCache,
    ) {}

    public function saved(CalculatorFactor $calculatorFactor): void
    {
        $this->calculatorCache->forgetCalculator();
    }

    public function deleted(CalculatorFactor $calculatorFactor): void
    {
        $this->calculatorCache->forgetCalculator();
    }
}
