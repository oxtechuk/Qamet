# API Exception Contract

## Exception Hierarchy

```text
\Exception
└── ApiException (abstract)
    ├── NotFoundException          → 404
    ├── ValidationException        → 422
    ├── UnauthorizedException      → 401
    ├── ForbiddenException         → 403
    └── InternalServerException    → 500
```

## Exception Properties

Each API exception **MUST** expose:

| Property | Type | Description |
|----------|------|-------------|
| `getStatusCode()` | int | HTTP status code to return |
| `getErrorCode()` | string | Machine-readable error identifier (e.g., `NOT_FOUND`) |
| `getDetails()` | array|null | Additional context (field errors for validation, etc.) |

## Error Code Mapping

| Exception | HTTP Status | Error Code |
|-----------|-------------|------------|
| `NotFoundException` | 404 | `NOT_FOUND` |
| `ValidationException` | 422 | `VALIDATION_ERROR` |
| `UnauthorizedException` | 401 | `UNAUTHORIZED` |
| `ForbiddenException` | 403 | `FORBIDDEN` |
| `InternalServerException` | 500 | `INTERNAL_ERROR` |

## Global Handler Behavior

1. Catch `ApiException` → render using `getStatusCode()` and `getErrorCode()`
2. Catch `ValidationException` (Laravel's) → transform to API validation error
3. Catch `AuthenticationException` → transform to 401
4. Catch `NotFoundHttpException` / `ModelNotFoundException` → transform to 404
5. Catch `AccessDeniedHttpException` → transform to 403
6. Catch generic `\Throwable` → render 500, log full trace, return sanitized message
