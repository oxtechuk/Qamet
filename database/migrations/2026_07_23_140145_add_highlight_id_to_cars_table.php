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
            if (! Schema::hasColumn('cars', 'highlight_id')) {
                $table->foreignId('highlight_id')->nullable()->after('is_highlighted')->constrained()->nullOnDelete();
            } else {
                $table->foreign('highlight_id')->references('id')->on('highlights')->nullOnDelete();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cars', function (Blueprint $table) {
            $table->dropForeign(['highlight_id']);
            $table->dropColumn('highlight_id');
        });
    }
};
