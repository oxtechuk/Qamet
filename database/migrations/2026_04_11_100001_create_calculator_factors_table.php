<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('calculator_factors', function (Blueprint $table) {
            $table->id();
            $table->string('type', 32);
            $table->string('code', 64);
            $table->string('label_ar');
            $table->string('label_en')->nullable();
            $table->unsignedTinyInteger('min_age')->nullable();
            $table->unsignedTinyInteger('max_age')->nullable();
            $table->decimal('rate_adjustment', 5, 2)->default(0);
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->unique(['type', 'code']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('calculator_factors');
    }
};
