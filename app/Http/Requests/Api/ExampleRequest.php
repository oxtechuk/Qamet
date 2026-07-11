<?php

declare(strict_types=1);

namespace App\Http\Requests\Api;

final class ExampleRequest extends ApiBaseRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'The name field is required.',
        ];
    }
}
