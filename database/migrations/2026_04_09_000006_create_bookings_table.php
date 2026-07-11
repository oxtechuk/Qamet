<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('car_id')->constrained('cars')->onDelete('cascade');
            $table->foreignId('assigned_to')->nullable()->constrained('employees')->onDelete('set null');

            // بيانات العميل
            $table->string('client_name');
            $table->string('client_phone');
            $table->string('client_email')->nullable();

            // تفاصيل التقسيط
            $table->unsignedBigInteger('down_payment');   // المقدم
            $table->unsignedTinyInteger('duration_years'); // مدة التقسيط (سنوات)
            $table->decimal('interest_rate', 5, 2)->default(0); // نسبة الفائدة %
            $table->unsignedBigInteger('monthly_installment'); // القسط الشهري المحسوب
            $table->unsignedBigInteger('total_price');    // إجمالي المبلغ

            $table->text('notes')->nullable();            // ملاحظات العميل

            $table->enum('status', [
                'new',          // جديد
                'contacted',    // تم التواصل
                'interested',   // مهتم
                'rejected',     // مرفوض
                'sold',         // تم البيع
            ])->default('new');

            $table->string('source')->default('website'); // المصدر: website, whatsapp...
            $table->timestamp('last_contacted_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
