<?php

namespace Tests\Feature\Api\Store;

use App\Models\Branch;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContactMetaTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_returns_contact_page_metadata(): void
    {
        Branch::create([
            'city' => ['en' => 'Riyadh', 'ar' => 'الرياض'],
            'name' => ['en' => 'Qemt Najd Cars — Riyadh', 'ar' => 'قمة نجد للسيارات — الرياض'],
            'address' => ['en' => 'King Fahd Road, Al Olaya', 'ar' => 'طريق الملك فهد، حي العليا'],
            'map_link' => 'https://maps.google.com/?q=24.7136,46.6753',
            'departments' => [
                ['label_ar' => 'قسم المبيعات', 'label_en' => 'Sales', 'phone' => '+966501110001', 'hours_ar' => '٨ص – ١٠م', 'hours_en' => '8am - 10pm'],
            ],
            'sort_order' => 1,
            'is_active' => true,
        ]);

        Branch::create([
            'city' => ['en' => 'Jeddah', 'ar' => 'جدة'],
            'name' => ['en' => 'Qemt Najd Cars — Jeddah', 'ar' => 'قمة نجد للسيارات — جدة'],
            'address' => ['en' => 'Corniche Road', 'ar' => 'طريق الكورنيش'],
            'departments' => [],
            'sort_order' => 2,
            'is_active' => false,
        ]);

        $response = $this->withHeaders(['Accept-Language' => 'en'])
            ->getJson(route('store.api.contact.meta'));

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'message',
            'data' => [
                'hero',
                'branches' => [
                    '*' => ['id', 'city', 'name', 'address', 'map_link', 'departments', 'sort_order'],
                ],
            ],
        ]);

        $this->assertCount(1, $response->json('data.branches'));
        $this->assertSame('Riyadh', $response->json('data.branches.0.city'));
        $this->assertSame('Sales', $response->json('data.branches.0.departments.0.label'));
    }
}
