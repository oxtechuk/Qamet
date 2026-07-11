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
        Schema::create('car_safety_feature', function (Blueprint $table) {
            $table->foreignId('car_id')->constrained()->onDelete('cascade');
            $table->foreignId('safety_feature_id')->constrained()->onDelete('cascade');
            $table->primary(['car_id', 'safety_feature_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('car_safety_feature');
    }
};
