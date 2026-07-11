<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->foreignId('brand_id')->constrained('brands')->onDelete('cascade');
            $table->string('name');                      // اسم السيارة
            $table->string('slug')->unique();
            $table->string('model');                     // الموديل
            $table->year('year');                        // سنة الصنع
            $table->enum('type', ['sedan', 'suv', 'coupe', 'hatchback', 'pickup', 'van', 'other'])->default('sedan');
            $table->string('color')->nullable();
            $table->unsignedBigInteger('cash_price');    // سعر الكاش بالجنيه/ريال
            $table->unsignedBigInteger('min_down_payment'); // أقل مقدم
            $table->unsignedBigInteger('min_installment'); // أقل قسط شهري
            $table->text('description')->nullable();
            $table->json('specs')->nullable();           // مواصفات كـ JSON
            $table->string('thumbnail')->nullable();     // الصورة الرئيسية
            $table->boolean('is_featured')->default(false); // هل ستظهر في الصفحة الرئيسية
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('views')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cars');
    }
};
