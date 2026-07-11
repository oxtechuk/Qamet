<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('offers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('car_id')->constrained('cars')->onDelete('cascade');
            $table->string('title');                     // عنوان العرض
            $table->text('description')->nullable();
            $table->unsignedTinyInteger('discount_percent')->nullable(); // نسبة الخصم %
            $table->unsignedBigInteger('special_price')->nullable();     // سعر خاص (بدل نسبة)
            $table->unsignedBigInteger('special_installment')->nullable(); // قسط مميز
            $table->timestamp('starts_at')->nullable();
            $table->timestamp('ends_at')->nullable();    // للـ Countdown
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('offers');
    }
};
