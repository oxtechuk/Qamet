<?php

namespace Tests\Feature\Api\Store;

use App\Models\ContactSource;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContactUsTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_submits_contact_us_form_successfully(): void
    {
        $payload = [
            'name' => 'John Doe',
            'phone' => '1234567890',
            'email' => 'john@example.com',
            'message' => 'I would like to inquire about a car.',
        ];

        $response = $this->postJson(route('store.api.contact.store'), $payload);

        $response->assertStatus(201);
        $response->assertJsonStructure([
            'success',
            'message',
            'data' => [
                'lead_id',
            ],
            'meta',
        ]);

        $this->assertDatabaseHas('contact_sources', [
            'name' => 'Contact Us Form',
        ]);

        $source = ContactSource::where('name', 'Contact Us Form')->first();

        $this->assertDatabaseHas('leads', [
            'client_name' => 'John Doe',
            'client_phone' => '1234567890',
            'client_email' => 'john@example.com',
            'status_details' => 'I would like to inquire about a car.',
            'contact_source_id' => $source->id,
            'status' => 'new',
        ]);
    }
}
