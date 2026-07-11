<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\Store;

use App\Http\Requests\Api\ApiBaseRequest;

final class CalculatorLeadRequest extends ApiBaseRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:20'],
            'email' => ['required', 'email', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'salary' => ['required', 'numeric', 'min:0'],
            'monthly_obligations' => ['required', 'numeric', 'min:0'],
            'preferred_bank_id' => ['nullable', 'integer', 'exists:calculator_banks,id'],
            'car_ids' => ['nullable', 'array'],
            'car_ids.*' => ['integer', 'exists:cars,id'],
            'notes' => ['nullable', 'string', 'max:500'],
        ];
    }
}
