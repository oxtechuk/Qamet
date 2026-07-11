<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\Store;

use App\Http\Requests\Api\ApiBaseRequest;

final class CalculatorOtpSendRequest extends ApiBaseRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:20'],
        ];
    }
}
