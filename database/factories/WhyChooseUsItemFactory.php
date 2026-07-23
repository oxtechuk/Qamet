<?php

namespace Database\Factories;

use App\Models\WhyChooseUsItem;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<WhyChooseUsItem>
 */
class WhyChooseUsItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'icon' => 'heroicon-o-check-badge',
            'title' => ['en' => $this->faker->words(2, true), 'ar' => $this->faker->words(2, true)],
            'description' => ['en' => $this->faker->sentence(), 'ar' => $this->faker->sentence()],
            'sort_order' => 0,
            'is_active' => true,
        ];
    }
}
