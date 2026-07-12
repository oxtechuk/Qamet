<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewLeadNotification extends Notification
{
    use Queueable;

    protected $lead;

    protected $title;

    protected $message;

    protected $url;

    public function __construct($lead, $title = null, $message = null)
    {
        $this->lead = $lead;
        $this->title = $title ?? __('عميل جديد');
        $this->message = $message ?? __('تم تعيين عميل جديد لك:').' '.$lead->client_name;
        $this->url = route('crm.leads.show', $lead->id);
    }

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toArray($notifiable): array
    {
        return [
            'lead_id' => $this->lead->id,
            'title' => $this->title,
            'message' => $this->message,
            'url' => $this->url,
            'icon' => 'bi-person-plus',
            'type' => 'lead',
        ];
    }
}
