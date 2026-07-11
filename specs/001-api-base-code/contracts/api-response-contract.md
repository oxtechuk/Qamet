# API Response Contract

## Envelope Structure

Every API endpoint **MUST** return responses conforming to this structure:

```json
{
  "success": true,
  "message": "Operation completed successfully",
  "data": { ... },
  "errors": null,
  "meta": {
    "current_page": 1,
    "per_page": 15,
    "total": 42,
    "last_page": 3
  }
}
```

## Success Response

```json
{
  "success": true,
  "message": "Resource created successfully",
  "data": {
    "id": 1,
    "name": "Example"
  },
  "errors": null,
  "meta": null
}
```

## Error Response

```json
{
  "success": false,
  "message": "Resource not found",
  "data": null,
  "errors": null,
  "meta": null
}
```

## Validation Error Response

```json
{
  "success": false,
  "message": "Validation failed",
  "data": null,
  "errors": {
    "email": ["The email field is required.", "The email must be a valid email address."],
    "name": ["The name field is required."]
  },
  "meta": null
}
```

## Paginated Response

```json
{
  "success": true,
  "message": "Resources retrieved successfully",
  "data": [
    { "id": 1, "name": "Item 1" },
    { "id": 2, "name": "Item 2" }
  ],
  "errors": null,
  "meta": {
    "current_page": 1,
    "per_page": 15,
    "total": 42,
    "last_page": 3,
    "from": 1,
    "to": 15
  }
}
```

## Status Code Rules

| Scenario | HTTP Status |
|----------|-------------|
| Successful GET/PUT/PATCH | 200 |
| Successful POST (create) | 201 |
| Successful DELETE (no content) | 200 with message |
| Validation failure | 422 |
| Unauthenticated | 401 |
| Forbidden | 403 |
| Resource not found | 404 |
| Server error | 500 |
