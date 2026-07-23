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
        Schema::table('calculator_leads', function (Blueprint $table) {
            $table->dropForeign(['car_id']);
            $table->dropColumn('car_id');

            $table->string('email')->nullable()->after('phone');
            $table->string('city')->nullable()->after('email');
            $table->decimal('salary', 12, 2)->nullable()->after('city');
            $table->decimal('monthly_obligations', 12, 2)->nullable()->after('salary');
            $table->foreignId('preferred_bank_id')->nullable()->constrained('calculator_banks')->nullOnDelete()->after('monthly_obligations');
            $table->json('car_ids')->nullable()->after('preferred_bank_id');
            $table->decimal('car_price', 12, 2)->nullable()->after('car_ids');
            $table->text('notes')->nullable()->after('car_price');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('calculator_leads', function (Blueprint $table) {
            $table->dropColumn(['email', 'city', 'salary', 'monthly_obligations', 'preferred_bank_id', 'car_ids', 'car_price', 'notes']);

            $table->foreignId('car_id')->nullable()->constrained('cars')->nullOnDelete();
        });
    }
};
