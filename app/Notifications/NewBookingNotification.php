<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewBookingNotification extends Notification
{
    use Queueable;

    protected $booking;

    protected $title;

    protected $message;

    protected $url;

    public function __construct($booking, $title = null, $message = null)
    {
        $this->booking = $booking;
        $this->title = $title ?? __('حجز جديد');
        $this->message = $message ?? __('تم إنشاء طلب حجز جديد من قبل').' '.$booking->client_name;
        $this->url = url('admin/bookings/'.$booking->id);
    }

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toArray($notifiable): array
    {
        return [
            'booking_id' => $this->booking->id,
            'title' => $this->title,
            'message' => $this->message,
            'url' => $this->url,
            'icon' => 'bi-cart-check',
            'type' => 'booking',
        ];
    }
}
