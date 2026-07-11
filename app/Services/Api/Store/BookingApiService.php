<?php

declare(strict_types=1);

namespace App\Services\Api\Store;

use App\Models\Booking;
use App\Models\Car;
use App\Models\Employee;
use App\Models\Setting;
use App\Notifications\NewBookingNotification;
use App\Services\Api\Store\Data\BookingData;
use App\Services\BookingAssignmentService;
use App\Services\TwilioWhatsAppService;
use Illuminate\Support\Facades\Notification;

final class BookingApiService
{
    public function __construct(
        private readonly BookingAssignmentService $assignmentService,
        private readonly TwilioWhatsAppService $whatsAppService,
    ) {}

    public function create(BookingData $data): Booking
    {
        $car = Car::findOrFail($data->car_id);

        $booking = Booking::create($data->toDatabase());

        $this->assignmentService->autoAssign($booking);

        $admins = Employee::where('role', 'admin')->orWhere('id', 1)->get();
        Notification::send($admins, new NewBookingNotification($booking));

        $this->sendWelcomeWhatsApp($booking, $car);

        return $booking;
    }

    private function sendWelcomeWhatsApp(Booking $booking, Car $car): void
    {
        $template = Setting::where('key', 'whatsapp_template_new_lead')->value('value');

        if (! empty($template) && ! empty($booking->client_phone)) {
            $message = str_replace(
                ['{customer_name}', '{car_name}', '{status}'],
                [$booking->client_name, $car->name, 'جديد'],
                $template,
            );
            $this->whatsAppService->sendWhatsApp($booking->client_phone, $message);
        }
    }
}
