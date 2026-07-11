<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Drop unique constraint safely
        try {
            Schema::table('cars', function (Blueprint $table) {
                $table->dropUnique('cars_slug_unique');
            });
        } catch (\Exception $e) {
            // Index might not exist or has a different name
        }

        // 2. Convert existing string slugs to JSON
        $cars = DB::table('cars')->get();
        foreach ($cars as $car) {
            if (!str_starts_with($car->slug, '{')) {
                $jsonSlug = json_encode([
                    'en' => $car->slug,
                    'ar' => $car->slug,
                ]);
                DB::table('cars')->where('id', $car->id)->update(['slug' => $jsonSlug]);
            }
        }

        // 3. Change column type to json
        Schema::table('cars', function (Blueprint $table) {
            $table->json('slug')->nullable(false)->change();
        });
    }

    public function down(): void
    {
        // Convert JSON slugs back to regular string (English fallback)
        $cars = DB::table('cars')->get();
        foreach ($cars as $car) {
            $decoded = json_decode($car->slug, true);
            $slug = is_array($decoded) ? ($decoded['en'] ?? array_values($decoded)[0] ?? '') : $car->slug;
            DB::table('cars')->where('id', $car->id)->update(['slug' => substr($slug, 0, 255)]);
        }

        Schema::table('cars', function (Blueprint $table) {
            $table->string('slug')->unique()->change();
        });
    }
};
