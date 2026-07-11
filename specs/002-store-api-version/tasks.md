# Tasks: Store API Version

**Input**: Design documents from `specs/002-store-api-version/`
**Prerequisites**: plan.md, spec.md, research.md, data-model.md, contracts/

**Organization**: Tasks are grouped by user story to enable independent implementation and testing of each story.

## Format: `[ID] [P] [Story] Description`

- **[P]**: Can run in parallel (different files, no dependencies)
- **[Story]**: Which user story this task belongs to

## Conventions

- PHP 8.4, Laravel 12.x
- All controllers extend `App\Http\Controllers\Api\ApiBaseController`
- All requests extend `App\Http\Requests\Api\ApiBaseRequest`
- API prefix: `/api/store/`
- No auth required for public store endpoints
- Reuse existing services: cache services, BookingAssignmentService, TwilioOtpService, TwilioWhatsAppService

---

## Phase 1: Setup (Shared Infrastructure)

**Purpose**: Create directory structure for new Store API layer

- [ ] T001 Create Store API directories: `app/Http/Controllers/Api/Store/`, `app/Http/Requests/Api/Store/`, `app/Services/Api/Store/`

---

## Phase 2: Foundational (Blocking Prerequisites)

**Purpose**: Register the Store API route group — all user stories depend on this

- [ ] T002 Add Route group in `routes/api.php`: `Route::prefix('store')->name('store.api.')->group(...)` with all 15 Store API endpoints (public, no auth middleware)

---

## Phase 3: User Story 1 — Car Catalog API (Priority: P1) 🎯 MVP

**Goal**: Expose car inventory via RESTful API with filtering, sorting, detail, search, compare, and brand listing — matching the web CarController and CompareController functionality.

**Independent Test**: Call `GET /api/store/cars?brands[]=1&sort=price_asc` and verify paginated response with car data matches the web filter results.

- [ ] T003 [P] [US1] Create `CarApiService` in `app/Services/Api/Store/CarApiService.php` with methods: `list(array $filters)` (paginated, filterable, sortable), `findBySlug(string $slug)` (detail with brand/images/specs/features/offers/related), `search(string $query)` (keyword search limited to 8), reusing `CarCacheService` for filter data
- [ ] T004 [P] [US1] Create `CompareApiService` in `app/Services/Api/Store/CompareApiService.php` with method: `compare(string $slug1, string $slug2)` returning structured comparison sections (prices, performance, design, features, specs)
- [ ] T005 [P] [US1] Create `CarController` in `app/Http/Controllers/Api/Store/CarController.php` extending `ApiBaseController` with methods: `index(Request)` (calls CarApiService->list), `show(string $slug)` (calls CarApiService->findBySlug), `search(Request)` (calls CarApiService->search), `compare(Request)` (calls CompareApiService->compare)
- [ ] T006 [US1] Register Car API routes: `GET /api/store/cars` → `CarController@index`, `GET /api/store/cars/search` → `CarController@search`, `GET /api/store/cars/compare` → `CarController@compare`, `GET /api/store/cars/{slug}` → `CarController@show`, `GET /api/store/brands` → `CarController@brands`

**Checkpoint**: Car catalog API is functional — browse, filter, search, detail, compare, brands all work.

---

## Phase 4: User Story 2 — Booking & Calculator API (Priority: P1)

**Goal**: Expose booking creation and calculator lead capture via API — matching web BookingController and CalculatorController functionality.

**Independent Test**: Submit `POST /api/store/booking` with valid data and verify a Booking with status "new" is created and assigned.

- [ ] T007 [P] [US2] Create `BookingApiService` in `app/Services/Api/Store/BookingApiService.php` with method: `create(array $data)` that validates car existence, calculates monthly installment (reuse web BookingController formula), calls `BookingAssignmentService::autoAssign()`, sends `NewBookingNotification`, builds WhatsApp share text, returns the created booking
- [ ] T008 [P] [US2] Create `CalculatorApiService` in `app/Services/Api/Store/CalculatorApiService.php` with methods: `saveLead(array $data)` (create CalculatorLead), `sendOtp(string $name, string $phone)` (delegates to `TwilioOtpService`), `verifyOtp(string $phone, string $code)` (delegates to `TwilioOtpService`, on success creates CalculatorLead)
- [ ] T009 [P] [US2] Create `BookingRequest` in `app/Http/Requests/Api/Store/BookingRequest.php` extending `ApiBaseRequest` with rules: car_id required|exists:cars,id, client_name required|string|max:255, client_phone required|string|max:20, client_email nullable|email|max:255, down_payment required|integer|min:0, duration_years required|integer|min:1|max:10, interest_rate nullable|numeric|min:0|max:50, notes nullable|string|max:1000
- [ ] T010 [P] [US2] Create `CalculatorLeadRequest` in `app/Http/Requests/Api/Store/CalculatorLeadRequest.php` extending `ApiBaseRequest` with rules: name required|string|max:255, phone required|string|max:20, car_id nullable|exists:cars,id, details nullable|array
- [ ] T011 [P] [US2] Create `CalculatorOtpSendRequest` in `app/Http/Requests/Api/Store/CalculatorOtpSendRequest.php` extending `ApiBaseRequest` with rules: name required|string|max:255, phone required|string|max:20
- [ ] T012 [P] [US2] Create `CalculatorOtpVerifyRequest` in `app/Http/Requests/Api/Store/CalculatorOtpVerifyRequest.php` extending `ApiBaseRequest` with rules: phone required|string|max:20, code required|string|size:6
- [ ] T013 [US2] Create `BookingController` in `app/Http/Controllers/Api/Store/BookingController.php` extending `ApiBaseController` with method: `store(BookingRequest)` (calls BookingApiService->create, returns respondCreated)
- [ ] T014 [US2] Create `CalculatorController` in `app/Http/Controllers/Api/Store/CalculatorController.php` extending `ApiBaseController` with methods: `saveLead(CalculatorLeadRequest)`, `sendOtp(CalculatorOtpSendRequest)`, `verifyOtp(CalculatorOtpVerifyRequest)`
- [ ] T015 [US2] Register Booking + Calculator routes: `POST /api/store/booking` → `BookingController@store`, `POST /api/store/calculator/lead` → `CalculatorController@saveLead`, `POST /api/store/calculator/otp/send` → `CalculatorController@sendOtp`, `POST /api/store/calculator/otp/verify` → `CalculatorController@verifyOtp`

**Checkpoint**: Booking and calculator lead capture work via API — identical business logic to web versions.

---

## Phase 5: User Story 3 — Content & Engagement API (Priority: P2)

**Goal**: Expose blog posts, active offers, and newsletter subscription — matching web BlogController, OfferController, and NewsletterController functionality.

**Independent Test**: Call `GET /api/store/blog` and verify published posts with pagination are returned.

- [ ] T016 [P] [US3] Create `BlogApiService` in `app/Services/Api/Store/BlogApiService.php` with methods: `list(int $page, int $perPage)` (paginated published posts with featured posts highlighted, reusing `BlogCacheService`), `findBySlug(string $slug)` (post detail with related posts)
- [ ] T017 [P] [US3] Create `OfferApiService` in `app/Services/Api/Store/OfferApiService.php` with method: `list(int $page, int $perPage)` (paginated active offers, reusing `OfferCacheService`)
- [ ] T018 [P] [US3] Create `NewsletterApiService` in `app/Services/Api/Store/NewsletterApiService.php` with method: `subscribe(string $email)` (normalize email, check duplicate/active → 409, reactivate if inactive, create new if not found — matching web NewsletterController logic)
- [ ] T019 [P] [US3] Create `NewsletterSubscribeRequest` in `app/Http/Requests/Api/Store/NewsletterSubscribeRequest.php` extending `ApiBaseRequest` with rules: email required|email|max:191
- [ ] T020 [P] [US3] Create `BlogController` in `app/Http/Controllers/Api/Store/BlogController.php` extending `ApiBaseController` with methods: `index(Request)` (calls BlogApiService->list), `show(string $slug)` (calls BlogApiService->findBySlug)
- [ ] T021 [P] [US3] Create `OfferController` in `app/Http/Controllers/Api/Store/OfferController.php` extending `ApiBaseController` with method: `index(Request)` (calls OfferApiService->list)
- [ ] T022 [P] [US3] Create `NewsletterController` in `app/Http/Controllers/Api/Store/NewsletterController.php` extending `ApiBaseController` with method: `store(NewsletterSubscribeRequest)` (calls NewsletterApiService->subscribe, returns 201 on new, 409 on duplicate)
- [ ] T023 [US3] Register Content routes: `GET /api/store/blog` → `BlogController@index`, `GET /api/store/blog/{slug}` → `BlogController@show`, `GET /api/store/offers` → `OfferController@index`, `POST /api/store/newsletter` → `NewsletterController@store`

**Checkpoint**: Content and engagement APIs are functional — blog, offers, newsletter all work.

---

## Phase 6: User Story 4 — Home & Static Data API (Priority: P3)

**Goal**: Expose homepage and about page data — matching web HomeController and AboutController functionality.

**Independent Test**: Call `GET /api/store/home` and verify response includes featured_cars, active_offers, brands, latest_posts, testimonials, partners.

- [ ] T024 [P] [US4] Create `HomeApiService` in `app/Services/Api/Store/HomeApiService.php` with method: `home()` returning aggregated homepage data (featured cars, active offers, brands, latest posts, testimonials, partners, stats, hero slides — delegating to `HomeCacheService`)
- [ ] T025 [P] [US4] Create `AboutApiService` in `app/Services/Api/Store/AboutApiService.php` with method: `about()` returning about page data (visible testimonials, sorted partners, featured designs — delegating to `AboutCacheService`)
- [ ] T026 [P] [US4] Create `HomeController` in `app/Http/Controllers/Api/Store/HomeController.php` extending `ApiBaseController` with method: `__invoke()` (calls HomeApiService->home)
- [ ] T027 [P] [US4] Create `AboutController` in `app/Http/Controllers/Api/Store/AboutController.php` extending `ApiBaseController` with method: `__invoke()` (calls AboutApiService->about)
- [ ] T028 [US4] Register Home + About routes: `GET /api/store/home` → `HomeController@__invoke`, `GET /api/store/about` → `AboutController@__invoke`

**Checkpoint**: Home and About APIs deliver full page data.

---

## Phase 7: Polish & Cross-Cutting Concerns

**Purpose**: Code formatting, route verification, and final validation

- [ ] T029 Run `vendor/bin/pint` to auto-format all new files
- [ ] T030 Run `php artisan route:list --path=api/store` to verify all 15 endpoints are registered
- [ ] T031 Run `php artisan test --filter=Feature` to ensure no existing tests are broken

---

## Dependencies & Execution Order

### Phase Dependencies

- **Setup (Phase 1)**: No dependencies
- **Foundational (Phase 2)**: Depends on Setup — BLOCKS all user stories
- **US1 — Car Catalog (Phase 3)**: Depends on Foundational — no story dependencies
- **US2 — Booking & Calculator (Phase 4)**: Depends on Foundational — can run in parallel with US1
- **US3 — Content & Engagement (Phase 5)**: Depends on Foundational — can run in parallel with US1/US2
- **US4 — Home & Static (Phase 6)**: Depends on Foundational — can run in parallel with US1/US2/US3
- **Polish (Phase 7)**: Depends on all user stories

### User Story Dependencies

- **US1 (P1)**: No story dependencies — start immediately after Foundational
- **US2 (P1)**: No story dependencies — start immediately after Foundational
- **US3 (P2)**: No story dependencies — start immediately after Foundational
- **US4 (P3)**: No story dependencies — start immediately after Foundational

### Parallel Opportunities

- **T003, T004** (US1 services) can run in parallel
- **T007, T008, T009-T012** (US2 services + requests) can all run in parallel
- **T016-T019** (US3 services + request) can run in parallel
- **T024, T025** (US4 services) can run in parallel
- All 4 user stories can be implemented in parallel (different files, no cross-dependencies)

---

## Parallel Example: User Story 1

```bash
# Create both services in parallel:
# T003: app/Services/Api/Store/CarApiService.php
# T004: app/Services/Api/Store/CompareApiService.php

# Then create controller:
# T005: app/Http/Controllers/Api/Store/CarController.php

# Then register routes:
# T006: routes/api.php (car group)
```

---

## Implementation Strategy

### MVP First (User Story 1 Only)

1. Phase 1: Setup
2. Phase 2: Foundational (route group)
3. Phase 3: US1 — Car Catalog API (P1)
4. **STOP and VALIDATE**: Test car listing, detail, search, compare, brands
5. Deploy if ready — car catalog is the core business value

### Incremental Delivery

1. Setup + Foundational → Route infrastructure ready
2. Add US1 (Car Catalog) → MVP: inventory accessible via API
3. Add US2 (Booking & Calculator) → Revenue: book cars via API
4. Add US3 (Content & Engagement) → Marketing: blog, offers, newsletter
5. Add US4 (Home & Static) → Portal: full homepage data
6. Each story adds value independently without blocking others
