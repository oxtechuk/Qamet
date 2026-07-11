<?php

declare(strict_types=1);

namespace App\Http\Api\Contracts;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\JsonResponse;

final class ApiResponse implements ApiResponseInterface, Responsable
{
    public function __construct(
        private readonly bool $success,
        private readonly string $message,
        private readonly mixed $data = null,
        private readonly ?array $errors = null,
        private readonly ?array $meta = null,
        private readonly int $status = 200,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            success: (bool) ($data['success'] ?? false),
            message: (string) ($data['message'] ?? ''),
            data: $data['data'] ?? null,
            errors: $data['errors'] ?? null,
            meta: $data['meta'] ?? null,
            status: (int) ($data['status'] ?? 200),
        );
    }

    public function toResponse($request): JsonResponse
    {
        return response()->json($this->toArray(), $this->status);
    }

    public function toArray(): array
    {
        return [
            'success' => $this->success,
            'message' => $this->message,
            'data' => $this->data,
            'errors' => $this->errors,
            'meta' => $this->meta,
        ];
    }

    public function getStatusCode(): int
    {
        return $this->status;
    }

    public function isSuccess(): bool
    {
        return $this->success;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getData(): mixed
    {
        return $this->data;
    }

    public function getErrors(): ?array
    {
        return $this->errors;
    }

    public function getMeta(): ?array
    {
        return $this->meta;
    }
}
