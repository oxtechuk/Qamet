# Response Builder Interface Contract

## Purpose

Provide a fluent, type-safe interface for constructing API responses. Consumers should depend on the contract, not concrete builder implementations.

## Core Interface

```text
ApiResponseBuilder
├── success(bool $success): self                         — Set success flag
├── message(string $message): self                       — Set response message
├── data(mixed $data): self                              — Set payload data
├── errors(array $errors): self                          — Set field-level errors
├── meta(array $meta): self                              — Set metadata
├── status(int $statusCode): self                        — Set HTTP status
├── paginated(LengthAwarePaginator $paginator): self     — Set pagination from Laravel paginator
└── build(): ApiResponse                                 — Return the constructed response
```

## Support Interfaces

```text
ErrorResponseBuilder extends ApiResponseBuilder
├── notFound(string $message = null): ApiResponse
├── validationError(array $errors): ApiResponse
├── unauthorized(string $message = null): ApiResponse
├── forbidden(string $message = null): ApiResponse
└── serverError(string $message = null): ApiResponse

SuccessResponseBuilder extends ApiResponseBuilder
├── created(mixed $data = null, string $message = null): ApiResponse
├── updated(mixed $data = null, string $message = null): ApiResponse
├── deleted(string $message = null): ApiResponse
└── ok(mixed $data = null, string $message = null): ApiResponse
```
