# Tasks: API Base Code

**Input**: Design documents from `specs/001-api-base-code/`
**Prerequisites**: plan.md, spec.md, research.md, data-model.md, contracts/

**Organization**: Tasks are grouped by user story to enable independent implementation and testing of each story.

## Format: `[ID] [P] [Story] Description`

- **[P]**: Can run in parallel (different files, no dependencies)
- **[Story]**: Which user story this task belongs to

## Conventions

- PHP 8.4, Laravel 12.x, namespace `App\Http\Api\*`
- Array-style validation rules; no `declare(strict_types=1)` on controllers
- Existing `app/Http/Controllers/Controller.php` — empty abstract base
- Existing `bootstrap/app.php` — has exception render callbacks to preserve

---

## Phase 1: Setup (Shared Infrastructure)

**Purpose**: Create directory structure and foundational interfaces

- [ ] T001 Create API directory tree: `app/Http/Api/Contracts/`, `app/Http/Api/Response/Builder/`, `app/Http/Api/Response/Support/`, `app/Http/Api/Exceptions/Http/`, `app/Http/Api/Exceptions/Handlers/`, `app/Http/Controllers/Api/`, `app/Http/Requests/Api/`

---

## Phase 2: Foundational (Blocking Prerequisites)

**Purpose**: Response data contract and interface — everything depends on these

**⚠️ CRITICAL**: No user story work can begin until this phase is complete

- [ ] T002 [P] Create `ApiResponse` DTO class in `app/Http/Api/Contracts/ApiResponse.php` with `success`, `message`, `data`, `errors`, `meta`, `status` properties and a named constructor `fromArray()`
- [ ] T003 [P] Create `ApiResponseInterface` contract in `app/Http/Api/Contracts/ApiResponseInterface.php` defining `toArray(): array` and `getStatusCode(): int`

**Checkpoint**: Foundation ready — user story implementation can now begin

---

## Phase 3: User Story 1 — Creating a Consistent API Response (Priority: P1) 🎯 MVP

**Goal**: Provide a fluent response builder so every API endpoint returns the same JSON envelope.

**Independent Test**: Hit any endpoint using the builder and verify the JSON shape matches `{success, message, data, errors, meta}`.

- [ ] T004 [P] [US1] Create `ApiResponseBuilder` concrete class in `app/Http/Api/Response/Builder/ApiResponseBuilder.php` implementing a fluent interface with methods: `success(bool)`, `message(string)`, `data(mixed)`, `errors(array)`, `meta(array)`, `status(int)`, `build(): ApiResponse`
- [ ] T005 [P] [US1] Create `SuccessResponseBuilder` convenience class in `app/Http/Api/Response/Builder/SuccessResponseBuilder.php` with helper methods: `ok($data, $message)`, `created($data, $message)`, `updated($data, $message)`, `deleted($message)`
- [ ] T006 [P] [US1] Create `ErrorResponseBuilder` convenience class in `app/Http/Api/Response/Builder/ErrorResponseBuilder.php` with helper methods: `notFound($message)`, `validationError($errors)`, `unauthorized($message)`, `forbidden($message)`, `serverError($message)`
- [ ] T007 [US1] Create `PaginationHelper` in `app/Http/Api/Response/Support/PaginationHelper.php` that extracts `current_page`, `per_page`, `total`, `last_page`, `from`, `to` from a `LengthAwarePaginator` instance
- [ ] T008 [US1] Register `ApiResponseBuilder` and `PaginationHelper` in a service provider or bind them in `bootstrap/app.php` via `app()->singleton()`
- [ ] T009 [US1] Verify the builder works end-to-end: `php artisan tinker` with `app(ApiResponseBuilder::class)->success(true)->message('ok')->data(['foo' => 'bar'])->build()->toArray()`

**Checkpoint**: User Story 1 is complete. Any developer can construct consistent responses.

---

## Phase 4: User Story 2 — Handling API Errors Uniformly (Priority: P1)

**Goal**: Catch every exception and transform it into the standard API error response format.

**Independent Test**: Throw each exception type in a route and verify the JSON error shape matches the contract.

- [ ] T010 [P] [US2] Create abstract `ApiException` in `app/Http/Api/Exceptions/ApiException.php` extending `\Exception` with `getStatusCode(): int`, `getErrorCode(): string`, `getDetails(): ?array`
- [ ] T011 [P] [US2] Create concrete exceptions in `app/Http/Api/Exceptions/Http/`: `NotFoundException` (404), `UnauthorizedException` (401), `ForbiddenException` (403), `ValidationException` (422), `InternalServerException` (500)
- [ ] T012 [US2] Create `ApiExceptionHandler` in `app/Http/Api/Exceptions/Handlers/ApiExceptionHandler.php` that renders any `ApiException` to the standard error response using `ApiResponseBuilder`
- [ ] T013 [US2] Create `GlobalExceptionHandler` in `app/Http/Api/Exceptions/Handlers/GlobalExceptionHandler.php` that catches Laravel exceptions (`NotFoundHttpException`, `ModelNotFoundException`, `AuthenticationException`, `AccessDeniedHttpException`, `ValidationException`, generic `\Throwable`) and transforms them into the standard error format
- [ ] T014 [US2] Register global exception handlers in `bootstrap/app.php` — add render callbacks that delegate to `GlobalExceptionHandler` for API requests (`$request->expectsJson()` or `$request->is('api/*')` or `$request->is('erp/*')`)
- [ ] T015 [US2] Verify production-safe error responses: assert no stack traces leak when `APP_DEBUG=false`

**Checkpoint**: User Stories 1 AND 2 are complete. All errors return consistent JSON.

---

## Phase 5: User Story 3 — Building a New API Endpoint Quickly (Priority: P2)

**Goal**: Provide a base controller with response helpers and a base request with validation so developers write 50% less boilerplate.

**Independent Test**: Create a minimal endpoint extending the base controller + base request class and verify it validates, succeeds, and errors properly.

- [ ] T016 [P] [US3] Create abstract `ApiBaseController` in `app/Http/Controllers/Api/ApiBaseController.php` extending `App\Http\Controllers\Controller` with helper methods: `respond($data, $message, $status)`, `respondSuccess($data, $message)`, `respondError($message, $status)`, `respondPaginated($paginator, $message)` — all delegating to `ApiResponseBuilder`
- [ ] T017 [P] [US3] Create abstract `ApiBaseRequest` in `app/Http/Requests/Api/ApiBaseRequest.php` extending `Illuminate\Foundation\Http\FormRequest` with: `failedValidation()` override that throws a `ValidationException` in the API error format, and `authorize()` defaulting to `true`
- [ ] T018 [US3] Add a runnable example: create `app/Http/Controllers/Api/ExampleController.php` extending `ApiBaseController` with an `index` method returning `respondSuccess(['ping' => 'pong'])` and register a test route `Route::get('/erp/example', [ExampleController::class, 'index'])`
- [ ] T019 [US3] Add a runnable example request: create `app/Http/Requests/Api/ExampleRequest.php` extending `ApiBaseRequest` with a `name` required rule — wire it into `ExampleController::store` and verify 422 on missing `name`
- [ ] T020 [US3] Verify the 50% boilerplate reduction: compare lines of code in `ExampleController` vs. a hypothetical controller written with inline `response()->json()` calls

**Checkpoint**: All user stories are complete. Developers can scaffold new endpoints in minutes.

---

## Phase 6: Polish & Cross-Cutting Concerns

**Purpose**: Tests, formatting, and final validation

- [ ] T021 [P] Run `vendor/bin/pint` to auto-format all new files
- [ ] T022 [P] Run `php artisan test --filter=Feature` to ensure no existing tests are broken
- [ ] T023 Run quickstart.md validation — verify all code examples work end-to-end

---

## Dependencies & Execution Order

### Phase Dependencies

- **Setup (Phase 1)**: No dependencies
- **Foundational (Phase 2)**: Depends on Setup — BLOCKS all user stories
- **User Story 1 (Phase 3)**: Depends on Foundational
- **User Story 2 (Phase 4)**: Depends on Foundational + US1 response builder (exceptions reuse `ApiResponseBuilder`)
- **User Story 3 (Phase 5)**: Depends on Foundational + US1 response builder + US2 exception format
- **Polish (Phase 6)**: Depends on all user stories

### User Story Dependencies

- **User Story 1 (P1)**: No story dependencies — can start after Foundational
- **User Story 2 (P1)**: Depends on US1 for response formatting in error responses
- **User Story 3 (P2)**: Depends on US1 (response builder) and US2 (exception handling)

### Within Each User Story

- Interfaces/contracts before implementations
- Builder classes before helpers
- Core handlers before registration in bootstrap
- Story complete before moving to next priority

### Parallel Opportunities

- **T002, T003** can run in parallel
- **T004-T006** can run in parallel
- **T010, T011** can run in parallel
- **T016, T017** can run in parallel
- **T021, T022** can run in parallel

---

## Parallel Example: User Story 1

```bash
# In parallel:
php artisan make:class "Http/Api/Contracts/ApiResponse"
php artisan make:class "Http/Api/Contracts/ApiResponseInterface"

# Then after:
php artisan make:class "Http/Api/Response/Builder/ApiResponseBuilder"
php artisan make:class "Http/Api/Response/Builder/SuccessResponseBuilder"
php artisan make:class "Http/Api/Response/Builder/ErrorResponseBuilder"
```

---

## Implementation Strategy

### MVP First (User Story 1 Only)

1. Phase 1: Setup
2. Phase 2: Foundational (ApiResponse DTO + Interface)
3. Phase 3: User Story 1 (Response Builder)
4. **STOP and VALIDATE**: Hit any route with the builder — confirm JSON shape
5. Deploy/demo if ready

### Incremental Delivery

1. Setup + Foundational → Response contract ready
2. Add User Story 1 → Consistent responses → MVP!
3. Add User Story 2 → Uniform error handling
4. Add User Story 3 → Rapid endpoint scaffolding
5. Each story adds value without breaking previous stories
