<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('car_offer', function (Blueprint $table) {
            $table->id();
            $table->foreignId('car_id')->constrained()->onDelete('cascade');
            $table->foreignId('offer_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });

        // Migrate existing data
        $offers = DB::table('offers')->whereNotNull('car_id')->get();
        foreach ($offers as $offer) {
            DB::table('car_offer')->insert([
                'car_id' => $offer->car_id,
                'offer_id' => $offer->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Make car_id nullable or remove it (let's just keep it nullable for safety for now)
        Schema::table('offers', function (Blueprint $table) {
            $table->unsignedBigInteger('car_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('car_offer');
    }
};
