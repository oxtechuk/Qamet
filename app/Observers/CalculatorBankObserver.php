<?php

namespace App\Observers;

use App\Models\CalculatorBank;
use App\Services\Cache\CalculatorCacheService;

class CalculatorBankObserver
{
    public function __construct(
        private CalculatorCacheService $calculatorCache,
    ) {}

    public function saved(CalculatorBank $calculatorBank): void
    {
        $this->calculatorCache->forgetCalculator();
    }

    public function deleted(CalculatorBank $calculatorBank): void
    {
        $this->calculatorCache->forgetCalculator();
    }
}
