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
        Schema::create('car_specification', function (Blueprint $table) {
            $table->foreignId('car_id')->constrained()->onDelete('cascade');
            $table->foreignId('specification_id')->constrained()->onDelete('cascade');
            $table->primary(['car_id', 'specification_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('car_specification');
    }
};
