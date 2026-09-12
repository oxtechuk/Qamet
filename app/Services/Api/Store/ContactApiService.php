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

        $adPlatform = \App\Services\Api\Store\Data\BookingData::detectPlatform(
            $data['ad_platform'] ?? null,
            $data['utm_source'] ?? null,
            $data['click_id'] ?? null,
            $data['referrer_url'] ?? request()->header('referer')
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
            'ad_platform' => $adPlatform,
            'utm_source' => $data['utm_source'] ?? null,
            'utm_medium' => $data['utm_medium'] ?? null,
            'utm_campaign' => $data['utm_campaign'] ?? null,
            'utm_content' => $data['utm_content'] ?? null,
            'utm_term' => $data['utm_term'] ?? null,
            'click_id' => $data['click_id'] ?? null,
            'referrer_url' => $data['referrer_url'] ?? request()->header('referer'),
        ]);

        app(\App\Services\BookingAssignmentService::class)->autoAssignLead($lead);

        return $lead;
    }
}
