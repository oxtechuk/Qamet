# Store API Contract

## Base URL

```
/api/store/
```

## Authentication

- Read-only endpoints: **Public** (no auth required)
- Write endpoints (booking, calculator): **Public** with optional rate limiting

## Response Envelope

All responses follow the standard format:

```json
{
  "success": true,
  "message": "string",
  "data": null | object | array,
  "errors": null | object,
  "meta": null | {
    "current_page": int,
    "per_page": int,
    "total": int,
    "last_page": int,
    "from": int | null,
    "to": int | null
  }
}
```

---

## Endpoints

### 1. Car Listing

```
GET /api/store/cars
```

**Query Parameters:**

| Param | Type | Required | Description |
|-------|------|----------|-------------|
| `brands[]` | array | no | Filter by brand IDs |
| `type` | string | no | Filter by vehicle type |
| `year` | int | no | Filter by model year |
| `min_price` | float | no | Minimum cash price |
| `max_price` | float | no | Maximum cash price |
| `search` | string | no | Search in name, brand, model |
| `q` | string | no | Alias for search |
| `offer_id` | int | no | Filter by offer |
| `sort` | string | no | `price_asc`, `price_desc`, `year_desc`, `latest` |
| `page` | int | no | Page number (default: 1) |
| `per_page` | int | no | Items per page (default: 12) |

**Response:** `200` — Paginated CarResource[]

---

### 2. Car Detail

```
GET /api/store/cars/{slug}
```

**Response:** `200` — CarResource with images, specifications, features_list, active_offers, related_cars
**Error:** `404` — `{success: false, message: "Car not found"}`

---

### 3. Car Search

```
GET /api/store/cars/search?q=keyword
```

**Response:** `200` — CarResource[] (max 8 results)

---

### 4. Car Compare

```
GET /api/store/cars/compare?cars[]=slug1&cars[]=slug2
```

**Response:** `200` — Comparison object with sections (prices, performance, design, features, specs)

---

### 5. Brand Listing

```
GET /api/store/brands
```

**Response:** `200` — BrandResource[]

---

### 6. Create Booking

```
POST /api/store/booking
Content-Type: application/json

{
  "car_id": 1,
  "client_name": "Ahmed",
  "client_phone": "+9665xxxxxxxx",
  "client_email": null,
  "down_payment": 50000,
  "duration_years": 5,
  "interest_rate": null,
  "notes": null
}
```

**Response:** `201` — BookingResource
**Error:** `422` — Validation errors

---

### 7. Save Calculator Lead

```
POST /api/store/calculator/lead
Content-Type: application/json

{
  "name": "Ahmed",
  "phone": "+9665xxxxxxxx",
  "car_id": null,
  "details": {}
}
```

**Response:** `201` — `{success: true, message: "...", data: {lead_id: int}}`

---

### 8. Send OTP

```
POST /api/store/calculator/otp/send
Content-Type: application/json

{
  "name": "Ahmed",
  "phone": "+9665xxxxxxxx"
}
```

**Response:** `200` — `{success: true, message: "OTP sent"}`
**Error:** `422` — Validation or Twilio error

---

### 9. Verify OTP

```
POST /api/store/calculator/otp/verify
Content-Type: application/json

{
  "phone": "+9665xxxxxxxx",
  "code": "123456"
}
```

**Response:** `200` — `{success: true, message: "...", data: {lead_id: int}}`
**Error:** `422` — Invalid or expired code

---

### 10. Blog Listing

```
GET /api/store/blog
```

**Query Parameters:**

| Param | Type | Required | Description |
|-------|------|----------|-------------|
| `page` | int | no | Page number (default: 1) |
| `per_page` | int | no | Items per page (default: 10) |

**Response:** `200` — Paginated BlogPostResource[] with `featured_posts` in meta

---

### 11. Blog Detail

```
GET /api/store/blog/{slug}
```

**Response:** `200` — BlogPostResource with content and related_posts
**Error:** `404` — `{success: false, message: "Post not found"}`

---

### 12. Active Offers

```
GET /api/store/offers
```

**Response:** `200` — Paginated OfferResource[]

---

### 13. Newsletter Subscribe

```
POST /api/store/newsletter
Content-Type: application/json

{
  "email": "user@example.com"
}
```

**Response:** `201` — `{success: true, message: "Subscribed successfully"}`
**Error:** `409` — `{success: false, message: "Already subscribed"}`

---

### 14. Homepage Data

```
GET /api/store/home
```

**Response:** `200` — HomeResource

---

### 15. About Page Data

```
GET /api/store/about
```

**Response:** `200` — AboutResource

---

## Error Codes

| HTTP Status | Error Code | Meaning |
|-------------|------------|---------|
| 400 | `VALIDATION_ERROR` | Request validation failed |
| 404 | `NOT_FOUND` | Resource not found |
| 409 | `already_subscribed` | Email already subscribed |
| 422 | `VALIDATION_ERROR` | Validation or business rule violation |
| 500 | `INTERNAL_ERROR` | Server error |
