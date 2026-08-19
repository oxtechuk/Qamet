<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\Store;

use App\Http\Requests\Api\ApiBaseRequest;
use Illuminate\Validation\Validator;

final class BookingRequest extends ApiBaseRequest
{
    public function rules(): array
    {
        return [
            'car_id' => ['nullable', 'integer', 'exists:cars,id'],
            'car_type' => ['nullable', 'string', 'max:255', 'required_without:car_id'],
            'payment_method' => ['nullable', 'string', 'in:cash,bank,finance,installment'],
            'client_name' => ['required', 'string', 'max:255'],
            'client_phone' => ['required', 'string', 'max:20'],
            'client_email' => ['nullable', 'email', 'max:255'],
            'age' => ['nullable', 'integer', 'min:18', 'max:100'],
            'work_sector' => ['nullable', 'string', 'max:255'],
            'salary' => ['nullable', 'numeric', 'min:0'],
            'service_duration' => ['nullable', 'string', 'max:255'],
            'has_downpayment' => ['nullable', 'boolean'],
            'has_obligations' => ['nullable', 'boolean'],
            'monthly_obligations' => ['nullable', 'numeric', 'min:0'],
            'purchase_urgency' => ['nullable', 'string', 'max:255'],
            'down_payment' => ['nullable', 'integer', 'min:0'],
            'duration_years' => ['nullable', 'integer', 'min:1', 'max:10'],
            'interest_rate' => ['nullable', 'numeric', 'min:0', 'max:50'],
            'notes' => ['nullable', 'string', 'max:1000'],
            'booking_type' => ['nullable', 'string', 'in:test_drive,purchase,inquiry'],
            'location' => ['nullable', 'string', 'max:500'],
        ];
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator): void {
            if (empty($this->car_id) && empty($this->car_type)) {
                $validator->errors()->add('car_id', 'Either car_id or car_type is required.');
            }
        });
    }
}
