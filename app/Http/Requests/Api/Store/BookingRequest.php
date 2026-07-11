<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\Store;

use App\Http\Requests\Api\ApiBaseRequest;

final class BookingRequest extends ApiBaseRequest
{
    public function rules(): array
    {
        return [
            'car_id' => ['required', 'exists:cars,id'],
            'client_name' => ['required', 'string', 'max:255'],
            'client_phone' => ['required', 'string', 'max:20'],
            'client_email' => ['nullable', 'email', 'max:255'],
            'down_payment' => ['required', 'integer', 'min:0'],
            'duration_years' => ['required', 'integer', 'min:1', 'max:10'],
            'interest_rate' => ['nullable', 'numeric', 'min:0', 'max:50'],
            'notes' => ['nullable', 'string', 'max:1000'],
            'booking_type' => ['nullable', 'string', 'in:test_drive,purchase,inquiry'],
            'location' => ['nullable', 'string', 'max:500'],
        ];
    }
}
