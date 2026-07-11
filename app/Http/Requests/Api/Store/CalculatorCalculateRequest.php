<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\Store;

use App\Http\Requests\Api\ApiBaseRequest;

final class CalculatorCalculateRequest extends ApiBaseRequest
{
    public function rules(): array
    {
        return [
            'car_id' => ['required', 'integer', 'exists:cars,id'],
            'down_payment_percentage' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'period_months' => ['nullable', 'integer', 'in:12,24,36,48,60'],
            'bank_id' => ['nullable', 'integer', 'exists:calculator_banks,id'],
        ];
    }
}
