<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\Store;

use App\Http\Requests\Api\ApiBaseRequest;
use App\Models\Setting;
use Illuminate\Validation\Validator;

final class CalculatorCalculateRequest extends ApiBaseRequest
{
    public function rules(): array
    {
        $maxCarPrice = Setting::where('key', 'max_car_price')->value('value') ?? 2500000;

        return [
            'car_id' => ['nullable', 'integer', 'exists:cars,id'],
            'car_price' => ['nullable', 'numeric', 'min:1', "max:{$maxCarPrice}"],
            'down_payment_percentage' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'period_months' => ['nullable', 'integer', 'in:12,24,36,48,60'],
            'bank_id' => ['nullable', 'integer', 'exists:calculator_banks,id'],
        ];
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator): void {
            if (empty($this->car_id) && empty($this->car_price)) {
                $validator->errors()->add('car_id', 'Either car_id or car_price is required.');
            }
        });
    }
}
