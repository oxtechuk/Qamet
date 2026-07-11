# Implementation Plan: API Base Code

**Branch**: `001-api-base-code` | **Date**: 2026-06-09 | **Spec**: [spec.md](./spec.md)
**Input**: Feature specification from `specs/001-api-base-code/spec.md`

**Note**: This template is filled in by the `/speckit.plan` command. See `.specify/templates/plan-template.md` for the execution workflow.

## Summary

Establish a clean, reusable API infrastructure layer in the existing Laravel application — providing a standardized response envelope (with builder pattern), a base exception hierarchy with global handling, a base request class for declarative validation, and a base controller with common response helpers. All classes follow SOLID principles and clean code practices.

## Technical Context

**Language/Version**: PHP 8.4 (Laravel 12.x)
**Primary Dependencies**: Laravel Framework 12, Laravel Sanctum 4, Spatie Laravel Permission 7
**Storage**: MySQL (via Eloquent ORM)
**Testing**: PHPUnit 11 (via `php artisan test`)
**Target Platform**: Linux web server (Apache/Nginx)
**Project Type**: Web application (Laravel) — existing API at `/erp` prefix
**Performance Goals**: Standard Laravel expectations — API responses rendered in <200ms
**Constraints**: Must not break existing `/erp` API routes; must follow existing project conventions (no `declare(strict_types=1)` on controllers, array-style validation rules, `casts()` method on models)
**Scale/Scope**: 25+ existing models, 40+ existing controllers, existing Sanctum-based API authentication

## Constitution Check

*GATE: Must pass before Phase 0 research. Re-check after Phase 1 design.*

The project constitution is not yet configured (template placeholders remain). No constitution gates to enforce. Default gates apply:
- ✅ **No violation**: New classes are additive — they do not replace or modify existing functionality
- ✅ **No violation**: Follows existing project conventions (PHP namespacing, Laravel patterns)
- ✅ **No violation**: All testable via PHPUnit (existing test framework)

## Project Structure

### Documentation (this feature)

```text
specs/001-api-base-code/
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
│   ├── Api/
│   │   ├── Contracts/          # Interface contracts (response, exception contracts)
│   │   ├── Response/           # API response builder, response DTOs
│   │   │   ├── Builder/
│   │   │   ├── Facades/
│   │   │   └── Support/
│   │   └── Exceptions/         # Base API exception hierarchy
│   │       ├── Http/
│   │       └── Handlers/
│   ├── Controllers/
│   │   └── Api/                # New ApiBaseController
│   └── Requests/
│       └── Api/                # New ApiBaseRequest
└── Services/
    └── Api/                    # API response service classes
```

**Structure Decision**: Added dedicated `Api/` namespaces within existing `Http/` structure to keep API concerns isolated from web (Store/CRM) controllers. Interfaces (`Contracts/`) are co-located with implementations for cohesion. This mirrors the existing convention of separating Store, CRM, and Api controller groups.

## Complexity Tracking

No constitution violations — complexity tracking not required.
