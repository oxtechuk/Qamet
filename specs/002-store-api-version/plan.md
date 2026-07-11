# Implementation Plan: Store API Version

**Branch**: `002-store-api-version` | **Date**: 2026-06-09 | **Spec**: [spec.md](./spec.md)
**Input**: Feature specification from `specs/002-store-api-version/spec.md`

**Note**: This template is filled in by the `/speckit.plan` command. See `.specify/templates/plan-template.md` for the execution workflow.

## Summary

Create RESTful API versions of all 9 Store controllers (Home, Car, Booking, Blog, Offer, Calculator, Compare, Newsletter, About) using clean architecture and SOLID principles. Each controller delegates to a dedicated service class, uses the existing API response infrastructure (ApiResponseBuilder, ApiBaseRequest, exception handlers), and exposes data under the `/api/store/` prefix. Business logic from web controllers is extracted into reusable services rather than duplicated.

## Technical Context

**Language/Version**: PHP 8.4 (Laravel 12.x)
**Primary Dependencies**: Laravel Framework 12, Laravel Sanctum 4, Spatie Laravel Permission 7
**Storage**: MySQL (via Eloquent ORM)
**Testing**: PHPUnit 11 (via `php artisan test`)
**Target Platform**: Linux web server (Apache/Nginx)
**Project Type**: Web application (Laravel) — existing Store web + Admin CRM + ERP API
**Performance Goals**: API responses rendered in <200ms (leveraging existing cache layer)
**Constraints**: Must reuse existing cache services (HomeCacheService, CarCacheService, BlogCacheService, OfferCacheService, CalculatorCacheService, AboutCacheService), Twilio OTP, Twilio WhatsApp, BookingAssignmentService; Must not break existing web routes; API prefix `/api/store/`
**Scale/Scope**: 9 API controllers, 25+ existing models, existing cache layer with 3600s-86400s TTL

## Constitution Check

*GATE: Must pass before Phase 0 research. Re-check after Phase 1 design.*

The project constitution is not yet configured (template placeholders remain). No constitution gates to enforce. Default gates apply:
- ✅ **No violation**: New API controllers are additive — they do not modify existing web controllers
- ✅ **No violation**: Reuses existing services (DRY, no duplication)
- ✅ **No violation**: Follows existing API conventions (ApiBaseController, ApiResponseBuilder, ApiBaseRequest)
- ✅ **No violation**: All testable via PHPUnit (existing test framework)

## Project Structure

### Documentation (this feature)

```text
specs/002-store-api-version/
├── plan.md              # This file (/speckit.plan command output)
├── spec.md              # Feature specification
├── research.md          # Phase 0 output (/speckit.plan command)
├── data-model.md        # Phase 1 output (/speckit.plan command)
├── quickstart.md        # Phase 1 output (/speckit.plan command)
├── contracts/           # Phase 1 output (/speckit.plan command)
└── tasks.md             # Phase 2 output (/speckit.tasks command - NOT created by /speckit.plan)
```

### Source Code (repository root)

```text
app/
├── Http/
│   ├── Controllers/
│   │   └── Api/
│   │       └── Store/             # NEW: 9 Store API controllers
│   │           ├── HomeController.php
│   │           ├── CarController.php
│   │           ├── BookingController.php
│   │           ├── BlogController.php
│   │           ├── OfferController.php
│   │           ├── CalculatorController.php
│   │           ├── CompareController.php
│   │           ├── NewsletterController.php
│   │           └── AboutController.php
│   └── Requests/
│       └── Api/
│           └── Store/             # NEW: Form Request classes for Store APIs
│               ├── BookingRequest.php
│               ├── CalculatorLeadRequest.php
│               ├── CalculatorOtpSendRequest.php
│               ├── CalculatorOtpVerifyRequest.php
│               └── NewsletterSubscribeRequest.php
├── Services/
│   └── Api/
│       └── Store/                 # NEW: Service classes for Store API business logic
│           ├── CarApiService.php
│           ├── BookingApiService.php
│           ├── BlogApiService.php
│           ├── OfferApiService.php
│           ├── CalculatorApiService.php
│           ├── CompareApiService.php
│           ├── NewsletterApiService.php
│           ├── HomeApiService.php
│           └── AboutApiService.php
```

**Structure Decision**: Follows the existing Laravel MVC pattern with a service layer. Each API controller (thin, single-responsibility) delegates to a dedicated service class. Services encapsulate business logic, reuse existing cache/notification/assignment services, and use repository-style queries via Eloquent. This separates API concerns from web concerns and follows SOLID principles.

## Complexity Tracking

No constitution violations — complexity tracking not required.
