# Data Model: API Base Code

## Overview

This feature introduces no new database entities. It defines **in-memory data structures** (DTOs/value objects) and **interface contracts** for the API layer.

## Data Structures

### ApiResponse

The universal response envelope returned by every API endpoint.

| Field | Type | Required | Description |
|-------|------|----------|-------------|
| `success` | bool | yes | Whether the request succeeded |
| `message` | string | yes | Human-readable result message |
| `data` | mixed | no | Primary payload (object, array, or null) |
| `errors` | object | no | Validation/field errors when applicable |
| `meta` | object | no | Metadata (pagination, timestamps, etc.) |
| `status` | int | yes | HTTP status code |

### ApiError

Structured error representation.

| Field | Type | Required | Description |
|-------|------|----------|-------------|
| `code` | string | yes | Machine-readable error code (e.g., `NOT_FOUND`, `VALIDATION_ERROR`) |
| `message` | string | yes | Human-readable error description |
| `details` | mixed | no | Additional context (field errors, stack trace in debug mode) |

### PaginationMeta

Metadata included in paginated list responses.

| Field | Type | Required | Description |
|-------|------|----------|-------------|
| `current_page` | int | yes | Current page number |
| `per_page` | int | yes | Items per page |
| `total` | int | yes | Total items across all pages |
| `last_page` | int | yes | Total number of pages |
| `from` | int | no | Item offset on current page |
| `to` | int | no | Item offset end on current page |

## Validation Rules (from spec requirements)

- Field-level validation errors must identify which field failed and why (FR-009)
- Validation rules use array syntax (matching project convention)
- Each Form Request encapsulates its own validation logic

## State Transitions

Not applicable — this feature introduces infrastructure classes with no stateful entities.
