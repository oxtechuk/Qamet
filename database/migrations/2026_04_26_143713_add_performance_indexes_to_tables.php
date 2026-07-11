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
        Schema::table('cars', function (Blueprint $table) {
            $table->index(['is_active', 'is_featured'], 'idx_active_featured');
            $table->index('is_active', 'idx_active');
        });

        Schema::table('bookings', function (Blueprint $table) {
            $table->index('status', 'idx_status');
            $table->index('created_at', 'idx_created');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cars', function (Blueprint $table) {
            $table->dropIndex('idx_active_featured');
            $table->dropIndex('idx_active');
        });

        Schema::table('bookings', function (Blueprint $table) {
            $table->dropIndex('idx_status');
            $table->dropIndex('idx_created');
        });
    }
};
