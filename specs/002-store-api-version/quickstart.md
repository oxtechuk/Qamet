# Quickstart: Store API Usage

## Listing Cars with Filters

```http
GET /api/store/cars?brands[]=1&brands[]=3&sort=price_asc&page=1
```

```json
{
  "success": true,
  "message": "Cars retrieved successfully",
  "data": [ { "id": 1, "name": "...", ... } ],
  "meta": { "current_page": 1, "per_page": 12, "total": 34, "last_page": 3 }
}
```

## Creating a Booking

```http
POST /api/store/booking
Content-Type: application/json

{
  "car_id": 5,
  "client_name": "Ahmed Ali",
  "client_phone": "+966500000000",
  "down_payment": 30000,
  "duration_years": 5
}
```

```json
{
  "success": true,
  "message": "Booking created successfully",
  "data": { "id": 42, "client_name": "Ahmed Ali", "status": "new" }
}
```

## Sending & Verifying OTP

```http
POST /api/store/calculator/otp/send
{"name": "Ahmed", "phone": "+966500000000"}
```

```http
POST /api/store/calculator/otp/verify
{"phone": "+966500000000", "code": "123456"}
```

## Compare Two Cars

```http
GET /api/store/cars/compare?cars[]=toyota-camry-2024&cars[]=honda-accord-2024
```

## Newsletter Subscribe

```http
POST /api/store/newsletter
{"email": "user@example.com"}
```

## Error Handling

Invalid requests return the standard error format:

```json
{
  "success": false,
  "message": "Validation failed",
  "errors": { "client_name": ["The client name field is required."] }
}
```
