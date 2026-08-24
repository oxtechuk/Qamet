<?php

namespace App\Console\Commands;

use App\Models\Car;
use Illuminate\Console\Command;

class OptimizeCarSlugsCommand extends Command
{
    protected $signature = 'cars:optimize-slugs';

    protected $description = 'Regenerate and optimize all car slugs to be concise and SEO-friendly';

    public function handle(): int
    {
        $cars = Car::all();
        $this->info("Starting slug optimization for {$cars->count()} cars...");

        $count = 0;
        foreach ($cars as $car) {
            $nameAr = is_array($car->name) ? ($car->name['ar'] ?? reset($car->name)) : (string) $car->name;
            $nameEn = is_array($car->name) ? ($car->name['en'] ?? $nameAr) : (string) $car->name;

            $newSlugAr = Car::generateUniqueSlug($nameAr, (int) ($car->year ?? now()->year), 'ar', $car->id);
            $newSlugEn = Car::generateUniqueSlug($nameEn, (int) ($car->year ?? now()->year), 'en', $car->id);

            $car->update([
                'slug' => [
                    'ar' => $newSlugAr,
                    'en' => $newSlugEn,
                ],
            ]);

            $this->line("Car #{$car->id}: AR -> {$newSlugAr} | EN -> {$newSlugEn}");
            $count++;
        }

        $this->info("Successfully optimized {$count} car slugs!");

        return Command::SUCCESS;
    }
}
