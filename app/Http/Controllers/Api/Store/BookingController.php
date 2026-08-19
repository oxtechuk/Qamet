<?php

namespace App\Http\Controllers\Api\Store;

use App\Http\Controllers\Api\ApiBaseController;
use App\Http\Requests\Api\Store\BookingRequest;
use App\Jobs\SendConversionEventJob;
use App\Models\Car;
use App\Services\Api\Store\BookingApiService;
use App\Services\Api\Store\Data\BookingData;
use App\Services\Cache\BookingCacheService;

final class BookingController extends ApiBaseController
{
    public function __construct(
        private readonly BookingApiService $bookingService,
        private readonly BookingCacheService $bookingCache,
    ) {
        parent::__construct(app(\App\Http\Api\Response\Builder\ApiResponseBuilder::class));
    }

    /**
     * Return booking page layout metadata (hero, steps, sections).
     */
    public function meta()
    {
        return $this->respondSuccess([
            'hero' => $this->bookingCache->rememberBookingHero(),
            'steps' => $this->bookingCache->rememberBookingSteps(),
            'sections' => $this->bookingCache->rememberBookingSections(),
        ], 'Booking page metadata retrieved successfully');
    }

    /**
     * Submit a new booking request.
     */
    public function store(BookingRequest $request)
    {
        $carId = $request->input('car_id');
        $car = $carId ? Car::find($carId) : null;

        $data = BookingData::fromRequest(
            $request->validated(),
            $car?->cash_price,
        );

        $booking = $this->bookingService->create($data);

        SendConversionEventJob::dispatchAfterResponse([
            'event_name' => 'Lead',
            'email' => $booking->client_email ?? null,
            'phone' => $booking->client_phone,
            'value' => $booking->total_price ?? ($car?->cash_price ?? 0),
            'currency' => 'SAR',
            'content_name' => $booking->car_type ?? ($car?->name ?? 'Car Booking'),
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return $this->respondCreated([
            'booking_id' => $booking->id,
            'client_name' => $booking->client_name,
            'client_phone' => $booking->client_phone,
            'car_id' => $booking->car_id,
            'car_type' => $booking->car_type,
            'payment_method' => $booking->payment_method,
            'booking_type' => $booking->booking_type,
            'monthly_installment' => $booking->monthly_installment,
            'total_price' => $booking->total_price,
            'down_payment' => $booking->down_payment,
            'duration_years' => $booking->duration_years,
            'status' => $booking->status,
        ], 'Booking created successfully');
    }
}
