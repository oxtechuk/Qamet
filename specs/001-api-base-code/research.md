# Research: API Base Code

## Technical Decisions

### Response Format & Builder Pattern

| Decision | Rationale | Alternatives Considered |
|----------|-----------|------------------------|
| **Standardized JSON envelope** with `success`, `message`, `data`, `errors`, `meta` fields | Existing API uses `response()->json([...])` — wrapping ensures frontend consistency | Raw JSON arrays (current, inconsistent); API Resources (too heavy for simple wrapping) |
| **Builder pattern** with fluent interface (`->success()->data($x)->message('ok')`) | Clean, readable, discoverable; follows SOLID (SRP per builder method) | Factory pattern (less flexible); Static helpers (harder to test/mock) |
| **Laravel API Resources** for transformation pipelines | Already part of Laravel ecosystem, no extra dependency | Fractal (deprecated); Manual `toArray()` on models |
| **Separate builder classes** for success, error, pagination | Single Responsibility — each builder handles one response type | Single monolithic builder (violates SRP) |

### Exception Handling

| Decision | Rationale | Alternatives Considered |
|----------|-----------|------------------------|
| **Custom exception classes** in `App\Http\Api\Exceptions` | Clear hierarchy, catchable by type; extends `\Exception` | Relying on SPL exceptions (too generic); `bootstrap/app.php` callbacks only (mixes handling with routing) |
| **Global exception handler** registered in `bootstrap/app.php` | Leverages existing Laravel pattern; already partially configured | Middleware-based handling (duplicates existing bootstrap config) |
| **Production-safe errors** — strip stack traces, log internally | Security best practice; already partially implemented in existing bootstrap config | Exposing detailed errors (security risk) |

### Base Request & Validation

| Decision | Rationale | Alternatives Considered |
|----------|-----------|------------------------|
| **Form Request classes** extending a base `ApiBaseRequest` | Declarative validation rules; authorization gate per request; follows Laravel convention | Inline `$request->validate()` (current approach — no reusability) |
| **Array-style validation rules** | Matches existing project convention | String rules (not used in project) |
| **Custom error format** for 422 responses | Consistent with the new response envelope | Default Laravel 422 format (mismatches new envelope) |

### Base Controller

| Decision | Rationale | Alternatives Considered |
|----------|-----------|------------------------|
| **Abstract `ApiBaseController`** extending existing `Controller` | Adds API-specific helpers without breaking existing controllers | Modifying existing `Controller` (risks breaking Store/CRM); Trait-only approach (less discoverable) |
| **Helper methods**: `respond()`, `respondSuccess()`, `respondError()`, `respondPaginated()` | Reduces boilerplate; consistent API response structure | Trait mixin (same effect, less OOP) |

### SOLID Alignment

| Principle | How It's Applied |
|-----------|------------------|
| **S**ingle Responsibility | Separate classes for response building, exception types, request validation, controller logic |
| **O**pen/Closed | Response builder extensible via method chaining; exception hierarchy open for new types |
| **L**iskov Substitution | Base exception types usable wherever parent `\Exception` is caught |
| **I**nterface Segregation | Contracts defined for response formatting; consumers depend on abstractions |
| **D**ependency Inversion | Controllers depend on `ApiResponseBuilder` contract, not concrete implementation |

## Key Files & Patterns to Reference

- `app/Http/Controllers/Controller.php` — existing abstract base
- `bootstrap/app.php` — existing exception handler render callbacks
- `app/Http/Controllers/Api/Core/` — existing API controllers (stubs)
- `routes/api.php` — existing API route definitions
- `app/Models/User.php` — existing model with `casts()` method convention
