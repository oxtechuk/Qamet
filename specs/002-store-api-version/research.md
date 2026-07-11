# Research: Store API Version

## Architectural Decisions

### Controller Architecture

| Decision | Rationale | Alternatives Considered |
|----------|-----------|------------------------|
| **Thin API controllers** — validation → service call → response | Single Responsibility — controllers only handle HTTP concerns | Fat controllers with business logic (mixes concerns) |
| **Service layer** (`ApiService` per domain) | Encapsulates business logic, reusable across controllers, testable in isolation | Traits (global state); Repositories (over-abstraction for Eloquent) |
| **Web controllers unchanged** — API controllers are separate | Zero risk of breaking existing web routes | Modifying web controllers (risk of breaking existing pages) |
| **Extends `ApiBaseController`** | Leverages existing response helpers (`respondSuccess`, `respondError`, `respondPaginated`) | Extending `Controller` directly (loses response helpers) |

### Service Layer Design

| Decision | Rationale | Alternatives Considered |
|----------|-----------|------------------------|
| **Services reuse existing cache services** | No cache duplication; existing TTLs remain valid | Fresh queries (ignores existing performance optimizations) |
| **Services reuse existing notification/assignment services** | BookingAssignmentService and TwilioWhatsAppService already handle business logic | Re-implementing assignment/notification logic (duplication) |
| **Services return `ApiResponse` or collection data** | Controllers transform to response format, not services | Services returning response objects (couples services to HTTP) |
| **Eloquent queries in services** | Follows existing project pattern; scopes/reuse existing query logic | Repositories (added abstraction with no benefit for Eloquent) |

### SOLID Application

| Principle | How It's Applied |
|-----------|------------------|
| **S**ingle Responsibility | Controller = HTTP handling; Service = business logic; Request = validation |
| **O**pen/Closed | Services open for extension via inheritance; closed for modification via dependency injection |
| **L**iskov Substitution | Services depend on interfaces/contracts, not concrete implementations |
| **I**nterface Segregation | Each service has a focused interface; no god services |
| **D**ependency Inversion | Services receive dependencies via constructor injection; consume contracts, not concretions |

### Endpoint Design

| Endpoint | HTTP | Route Name | Purpose |
|----------|------|------------|---------|
| `/api/store/cars` | GET | `store.api.cars.index` | Paginated car listing with filters |
| `/api/store/cars/{slug}` | GET | `store.api.cars.show` | Car detail with brand, images, specs, offers |
| `/api/store/cars/search` | GET | `store.api.cars.search` | Car search by keyword |
| `/api/store/cars/compare` | GET | `store.api.cars.compare` | Compare 2 cars |
| `/api/store/brands` | GET | `store.api.brands.index` | Brand listing |
| `/api/store/booking` | POST | `store.api.booking.store` | Create booking |
| `/api/store/calculator/lead` | POST | `store.api.calculator.lead` | Save calculator lead |
| `/api/store/calculator/otp/send` | POST | `store.api.calculator.otp.send` | Send OTP |
| `/api/store/calculator/otp/verify` | POST | `store.api.calculator.otp.verify` | Verify OTP |
| `/api/store/blog` | GET | `store.api.blog.index` | Paginated blog listing |
| `/api/store/blog/{slug}` | GET | `store.api.blog.show` | Blog post detail |
| `/api/store/offers` | GET | `store.api.offers.index` | Active offers |
| `/api/store/newsletter` | POST | `store.api.newsletter.store` | Subscribe email |
| `/api/store/home` | GET | `store.api.home` | Homepage data |
| `/api/store/about` | GET | `store.api.about` | About page data |

### Reused Services (from existing web layer)

| Service | Used By API | Purpose |
|---------|-------------|---------|
| `CarCacheService` | CarApiService, CompareApiService | Cached filter data |
| `HomeCacheService` | HomeApiService | Homepage data aggregation |
| `BlogCacheService` | BlogApiService | Blog index/hero caching |
| `OfferCacheService` | OfferApiService | Offer data caching |
| `CalculatorCacheService` | CalculatorApiService | Calculator configuration caching |
| `AboutCacheService` | AboutApiService | About page data caching |
| `BookingAssignmentService` | BookingApiService | Auto-assign bookings to sales reps |
| `TwilioWhatsAppService` | BookingApiService | WhatsApp notifications |
| `TwilioOtpService` | CalculatorApiService | OTP send/verify |
| `NewBookingNotification` | BookingApiService | Admin notification on new booking |

### Response Format

All endpoints use the existing `ApiResponse` envelope:

```json
{
  "success": true,
  "message": "Cars retrieved successfully",
  "data": [ ... ],
  "errors": null,
  "meta": {
    "current_page": 1,
    "per_page": 12,
    "total": 50,
    "last_page": 5
  }
}
```
