# Data Model: Store API Version

## Overview

This feature introduces no new database entities. It defines **API resource representations** for existing models exposed through the Store API.

## API Resources

### CarResource

| Field | Source | Type | Description |
|-------|--------|------|-------------|
| `id` | `Car->id` | int | Car ID |
| `name` | `Car->name` | string | Translatable name |
| `slug` | `Car->slug` | string | URL slug |
| `brand` | `Car->brand` | object | `{id, name, logo}` |
| `category` | `Car->category` | object | `{id, name}` |
| `year` | `Car->year` | int | Model year |
| `type` | `Car->type` | string | Vehicle type |
| `cash_price` | `Car->cash_price` | float | Cash price |
| `min_down_payment` | `Car->min_down_payment` | float | Minimum down payment |
| `min_installment` | `Car->min_installment` | float | Minimum monthly installment |
| `thumbnail` | `Car->thumbnail` | string | Thumbnail URL |
| `is_featured` | `Car->is_featured` | bool | Featured flag |
| `availability_status` | `Car->availability_status` | string | Availability |
| `description` | `Car->description` | string | Translatable description |
| `features` | `Car->features` | string | Translatable features |
| `colors` | `Car->colors` | array | Available colors |
| `images` | `Car->images` | array | Gallery images (detail only) |
| `specifications` | `Car->specifications` | array | Specs (detail only) |
| `features_list` | `Car->features_list` | array | Feature badges (detail only) |
| `active_offers` | `Car->activeOffers` | array | Active promotions (detail only) |
| `views` | `Car->views` | int | View count |

### BrandResource

| Field | Source | Type |
|-------|--------|------|
| `id` | `Brand->id` | int |
| `name` | `Brand->name` | string |
| `logo` | `Brand->logo` | string |
| `slug` | `Brand->slug` | string |
| `car_count` | computed | int |

### BookingResource

| Field | Source | Type |
|-------|--------|------|
| `id` | `Booking->id` | int |
| `car` | `Booking->car` | object |
| `client_name` | `Booking->client_name` | string |
| `client_phone` | `Booking->client_phone` | string |
| `client_email` | `Booking->client_email` | string |
| `down_payment` | `Booking->down_payment` | int |
| `duration_years` | `Booking->duration_years` | int |
| `monthly_installment` | `Booking->monthly_installment` | float |
| `total_price` | `Booking->total_price` | float |
| `status` | `Booking->status` | string |

### BlogPostResource

| Field | Source | Type |
|-------|--------|------|
| `id` | `BlogPost->id` | int |
| `title` | `BlogPost->title` | string |
| `slug` | `BlogPost->slug` | string |
| `thumbnail` | `BlogPost->thumbnail` | string |
| `excerpt` | `BlogPost->excerpt` | string |
| `content` | `BlogPost->content` | string (detail only) |
| `published_at` | `BlogPost->published_at` | string |
| `is_featured` | `BlogPost->is_featured` | bool |
| `related_posts` | computed | array (detail only) |

### OfferResource

| Field | Source | Type |
|-------|--------|------|
| `id` | `Offer->id` | int |
| `title` | `Offer->title` | string |
| `description` | `Offer->description` | string |
| `image` | `Offer->image` | string |
| `discount_percent` | `Offer->discount_percent` | float |
| `special_price` | `Offer->special_price` | float |
| `special_installment` | `Offer->special_installment` | float |
| `starts_at` | `Offer->starts_at` | string |
| `ends_at` | `Offer->ends_at` | string |

### HomeResource

Composite resource aggregating:
- `featured_cars` — CarResource[]
- `active_offers` — OfferResource[]
- `brands` — BrandResource[]
- `latest_posts` — BlogPostResource[]
- `testimonials` — array
- `partners` — array
- `stats` — object
- `hero_slides` — array

### AboutResource

Composite resource aggregating:
- `testimonials` — array
- `partners` — array
- `featured_designs` — array

## Validation Rules

### BookingRequest

| Field | Rules |
|-------|-------|
| `car_id` | required, exists:cars,id |
| `client_name` | required, string, max:255 |
| `client_phone` | required, string, max:20 |
| `client_email` | nullable, email, max:255 |
| `down_payment` | required, integer, min:0 |
| `duration_years` | required, integer, min:1, max:10 |
| `interest_rate` | nullable, numeric, min:0, max:50 |
| `notes` | nullable, string, max:1000 |

### CalculatorLeadRequest

| Field | Rules |
|-------|-------|
| `name` | required, string, max:255 |
| `phone` | required, string, max:20 |
| `car_id` | nullable, exists:cars,id |
| `details` | nullable, array |

### OtpSendRequest

| Field | Rules |
|-------|-------|
| `name` | required, string, max:255 |
| `phone` | required, string, max:20 |

### OtpVerifyRequest

| Field | Rules |
|-------|-------|
| `phone` | required, string, max:20 |
| `code` | required, string, size:6 |

### NewsletterSubscribeRequest

| Field | Rules |
|-------|-------|
| `email` | required, email, max:191 |
