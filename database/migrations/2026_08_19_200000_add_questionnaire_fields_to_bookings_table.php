<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->unsignedSmallInteger('age')->nullable()->after('client_email');
            $table->string('work_sector')->nullable()->after('age'); // حكومي / قطاع خاص / عسكري / متقاعد / أخرى
            $table->unsignedBigInteger('salary')->nullable()->after('work_sector');
            $table->string('service_duration')->nullable()->after('salary'); // مدة الخدمة
            $table->boolean('has_downpayment')->default(false)->after('service_duration');
            $table->boolean('has_obligations')->default(false)->after('has_downpayment');
            $table->unsignedBigInteger('monthly_obligations')->nullable()->after('has_obligations');
            $table->string('purchase_urgency')->nullable()->after('monthly_obligations'); // توقيت الشراء
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn([
                'age',
                'work_sector',
                'salary',
                'service_duration',
                'has_downpayment',
                'has_obligations',
                'monthly_obligations',
                'purchase_urgency',
            ]);
        });
    }
};
