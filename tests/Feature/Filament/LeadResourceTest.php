<?php

namespace Tests\Feature\Filament;

use App\Models\Lead;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LeadResourceTest extends TestCase
{
    use RefreshDatabase;

    public function test_lead_can_be_created_without_started_at_or_source(): void
    {
        $lead = Lead::create([
            'client_name' => 'أحمد علي',
            'client_phone' => '0512345678',
            'client_email' => 'ahmed@example.com',
            'status' => 'new',
        ]);

        $this->assertDatabaseHas('leads', [
            'id' => $lead->id,
            'client_name' => 'أحمد علي',
            'status' => 'new',
        ]);
        $this->assertNotNull($lead->started_at);
    }
}
