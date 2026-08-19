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
        Schema::table('bookings', function (Blueprint $table) {
            $table->unsignedBigInteger('car_id')->nullable()->change();
            $table->string('company_name')->nullable()->after('client_name');
            $table->string('preferred_contact_date')->nullable()->after('purchase_urgency');
            $table->string('preferred_contact_time')->nullable()->after('preferred_contact_date');
            $table->unsignedInteger('car_count')->default(1)->nullable()->after('car_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn([
                'company_name',
                'preferred_contact_date',
                'preferred_contact_time',
                'car_count',
            ]);
        });
    }
};
