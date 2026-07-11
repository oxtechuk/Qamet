<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\Store;

use App\Http\Requests\Api\ApiBaseRequest;

final class NewsletterSubscribeRequest extends ApiBaseRequest
{
    public function rules(): array
    {
        return [
            'email' => ['required', 'email', 'max:191'],
        ];
    }
}
