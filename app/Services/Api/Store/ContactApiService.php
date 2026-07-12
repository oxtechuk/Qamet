<?php

declare(strict_types=1);

namespace App\Services\Api\Store;

use App\Models\ContactSource;
use App\Models\Lead;

final class ContactApiService
{
    public function submitContactForm(array $data): Lead
    {
        $source = ContactSource::firstOrCreate(
            ['name' => 'Contact Us Form'],
            ['is_active' => true]
        );

        $lead = Lead::create([
            'client_name' => $data['name'],
            'client_phone' => $data['phone'],
            'client_email' => $data['email'] ?? null,
            'subject' => $data['subject'] ?? null,
            'country' => $data['country'] ?? null,
            'status_details' => $data['message'] ?? null,
            'contact_source_id' => $source->id,
            'status' => 'new',
            'started_at' => now(),
        ]);

        app(\App\Services\BookingAssignmentService::class)->autoAssignLead($lead);

        return $lead;
    }
}
