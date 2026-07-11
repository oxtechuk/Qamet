# Feature Specification: Store API Version

**Feature Branch**: `002-store-api-version`  
**Created**: 2026-06-09  
**Status**: Draft  
**Input**: User description: "@app/Http/Controllers/Store make api version for this put use clean code and api design best practice"

## User Scenarios & Testing *(mandatory)*

### User Story 1 - Car Catalog API (Priority: P1)

A mobile app or third-party system needs to browse the car inventory with the same filtering and sorting options available on the website. The API returns paginated car listings with filters by brand, type, year, price range, and search keyword. Each car detail includes full specifications, features, images, and active offers.

**Why this priority**: Car catalog access is the core business value — customers browse cars before any booking or inquiry.

**Independent Test**: Can be tested by calling the car listing endpoint with filter parameters and verifying paginated results match the web experience.

**Acceptance Scenarios**:

1. **Given** a client requests the car list, **When** they call the listing endpoint, **Then** they receive a paginated response with car data matching the web filters
2. **Given** a client requests a specific car by slug, **When** they call the detail endpoint, **Then** they receive full car details including brand, specs, features, images, and active offers
3. **Given** a client applies filters (brand, type, year, price range, search), **When** they call the listing endpoint with query parameters, **Then** the response is filtered to match only the specified criteria
4. **Given** a client compares two cars, **When** they call the comparison endpoint with two car IDs, **Then** they receive a structured comparison with pricing, performance, design, features, and specs
5. **Given** a client searches for a car by name or keyword, **When** they call the search endpoint, **Then** they receive matching results limited to a configurable maximum

---

### User Story 2 - Booking & Calculator API (Priority: P1)

A partner portal or mobile app needs to submit car bookings and calculator leads programmatically. The booking includes client details, financing preferences (down payment, duration), and triggers the same assignment and notification flow as the website. The calculator lead capture includes OTP verification.

**Why this priority**: Bookings and leads generate revenue directly — API access expands partner channels.

**Independent Test**: Can be tested by submitting a valid booking request and verifying the booking is created with correct data and status.

**Acceptance Scenarios**:

1. **Given** a client submits a booking with valid car, client info, and financing details, **When** they call the booking endpoint, **Then** a booking is created with status "new" and assigned to a sales representative
2. **Given** a booking is created, **When** the system processes it, **Then** the same assignment and notification flows run as the web version
3. **Given** a client submits a calculator lead, **When** they call the lead endpoint, **Then** a calculator lead is stored with client details
4. **Given** a client requests OTP verification, **When** they call the OTP send and verify endpoints, **Then** the OTP flow works identically to the web version

---

### User Story 3 - Content & Engagement API (Priority: P2)

A mobile app or external system needs access to published blog posts, active offers, and newsletter subscription. Blog listings are paginated with featured posts highlighted. Offers return only currently active promotions. Newsletter subscription handles the same duplicate detection logic as the web version.

**Why this priority**: Content APIs support marketing channels and user engagement but are less critical than car catalog and booking.

**Independent Test**: Can be tested by calling the blog listing endpoint and verifying published posts are returned with pagination.

**Acceptance Scenarios**:

1. **Given** a client requests blog posts, **When** they call the blog endpoint, **Then** they receive published posts with pagination, including featured posts highlighted
2. **Given** a client requests a specific blog post by slug, **When** they call the detail endpoint, **Then** they receive the full post with related posts
3. **Given** a client requests active offers, **When** they call the offers endpoint, **Then** they receive only currently active offers
4. **Given** a client subscribes with a new email, **When** they call the newsletter endpoint, **Then** the email is subscribed and confirmed
5. **Given** a client subscribes with an already-active email, **When** they call the newsletter endpoint, **Then** they receive a notification that they are already subscribed (409)

---

### User Story 4 - Home & Static Data API (Priority: P3)

A mobile app or external system needs the same homepage and about-page data that powers the public website. This includes featured cars, active offers, brands, latest blog posts, testimonials, partners, and other curated content.

**Why this priority**: Homepage data is valuable but consolidates data from other endpoints (cars, offers, blog) — clients can compose it from individual APIs.

**Independent Test**: Can be tested by calling the home endpoint and verifying the response structure includes featured cars, offers, brands, posts, and testimonials.

**Acceptance Scenarios**:

1. **Given** a client requests homepage data, **When** they call the home endpoint, **Then** they receive featured cars, active offers, brands, latest posts, testimonials, partners, and hero content
2. **Given** a client requests about page data, **When** they call the about endpoint, **Then** they receive testimonials, partners, and featured designs

---

### Edge Cases

- How does the API handle empty search results (no cars match filters)?
- What happens when a car slug does not exist?
- What happens when a booking is submitted with an invalid or unavailable car?
- How does OTP handle rate limiting or expired codes?
- What happens when the newsletter email is invalid or already unsubscribed?
- How does the API return data when cache is empty or expired?
- What happens when comparison is requested with only one car?
- How does pagination behave beyond available pages?

## Requirements *(mandatory)*

### Functional Requirements

- **FR-001**: System MUST expose car catalog endpoints: list (paginated, filterable), detail by slug, search by keyword, and compare up to 2 cars
- **FR-002**: Car listing MUST support filtering by brand, type, year, min price, max price, and search keyword — matching the web filters
- **FR-003**: Car listing MUST support sorting by price (asc/desc), year (desc), or latest (default) — matching the web sorting
- **FR-004**: Car detail MUST include brand, images, specifications, features, active offers, and related cars — matching the web detail page
- **FR-005**: System MUST expose a brand listing endpoint
- **FR-006**: System MUST expose booking creation endpoint with the same validation rules as the web form
- **FR-007**: Booking creation MUST trigger the same auto-assignment and notification flows as the web version
- **FR-008**: System MUST expose calculator lead creation and OTP send/verify endpoints matching the web calculator flow
- **FR-009**: System MUST expose blog listing (paginated, with featured posts) and blog detail by slug endpoints
- **FR-010**: System MUST expose active offers listing endpoint
- **FR-011**: System MUST expose newsletter subscription endpoint with duplicate detection and reactivation logic matching the web version
- **FR-012**: System MUST expose homepage data endpoint assembling all homepage sections
- **FR-013**: System MUST expose about page data endpoint
- **FR-014**: All API responses MUST use the standardized envelope format (success, message, data, errors, meta)
- **FR-015**: All errors MUST use the base exception hierarchy with consistent error structure
- **FR-016**: All input validation MUST use the base request class and return validation errors in the standard format
- **FR-017**: Read-only endpoints (car list, brands, blog, offers, home, about, compare) MUST be publicly accessible
- **FR-018**: Write endpoints (booking, calculator lead, newsletter) MUST follow the same business logic as the web versions

### Key Entities *(include if feature involves data)*

- **Car**: Vehicle listing with brand, category, images, specs, features, pricing, availability
- **Brand**: Car manufacturer with name, logo, active status
- **Booking**: Customer booking request with car, client info, financing details
- **Calculator Lead**: Pre-qualification lead from calculator with OTP verification
- **Blog Post**: Published article with content, metadata, featured status
- **Offer**: Promotional offer on one or more cars with discount details and validity period
- **Newsletter Subscriber**: Email subscription with active/inactive status
- **Comparison**: Structured comparison data for 2 cars across defined categories

## Success Criteria *(mandatory)*

### Measurable Outcomes

- **SC-001**: All 9 Store controller responsibilities are accessible via API endpoints
- **SC-002**: API responses follow the standardized envelope format — a frontend developer can consume any endpoint without adapting to different response shapes
- **SC-003**: Car listing API supports all filter parameters available on the web (brand, type, year, price range, search) — zero feature gaps
- **SC-004**: Booking API creates the same booking state, assignment, and notifications as the web form — verifiable by comparing outputs
- **SC-005**: Newsletter API handles subscribe, duplicate, and reactivation cases identically to the web version
- **SC-006**: Calculator OTP flow works identically via API and web — same OTP send, verify, and lead creation

## Assumptions

- The existing Store controllers' business logic (services, notifications, cache) will be reused, not duplicated
- The existing API infrastructure (ApiBaseController, ApiResponseBuilder, ApiBaseRequest, exception handling) will be used for all new endpoints
- API routes will be registered under the existing `/api/erp/store/` prefix or a new `/api/store/` prefix
- Authentication is not required for read-only store endpoints (public data)
- Write endpoints (booking, calculator lead) may require rate limiting but not authentication
- Pagination defaults will match the web version (12 per page for cars, 10 for blog)
