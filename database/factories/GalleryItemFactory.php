<?php

namespace Database\Factories;

use App\Models\GalleryItem;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<GalleryItem>
 */
class GalleryItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'type' => 'image',
            'file' => 'gallery/'.$this->faker->uuid().'.jpg',
            'thumbnail' => null,
            'caption' => ['en' => $this->faker->words(3, true), 'ar' => $this->faker->words(3, true)],
            'alt_text' => $this->faker->words(3, true),
            'sort_order' => 0,
            'is_active' => true,
        ];
    }

    public function video(): static
    {
        return $this->state(fn (array $attributes): array => [
            'type' => 'video',
            'file' => 'gallery/videos/'.$this->faker->uuid().'.mp4',
            'thumbnail' => 'gallery/thumbnails/'.$this->faker->uuid().'.jpg',
        ]);
    }
}
