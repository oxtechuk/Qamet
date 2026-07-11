<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\Store;

use App\Http\Requests\Api\ApiBaseRequest;

final class CalculatorOtpVerifyRequest extends ApiBaseRequest
{
    public function rules(): array
    {
        return [
            'phone' => ['required', 'string', 'max:20'],
            'code' => ['required', 'string', 'size:6'],
        ];
    }
}
