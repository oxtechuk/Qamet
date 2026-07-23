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
        Schema::table('features', function (Blueprint $table) {
            $table->json('value')->nullable()->after('name');
        });

        Schema::table('specifications', function (Blueprint $table) {
            $table->json('value')->nullable()->after('name');
        });

        Schema::table('safety_features', function (Blueprint $table) {
            $table->json('value')->nullable()->after('name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('features', function (Blueprint $table) {
            $table->dropColumn('value');
        });

        Schema::table('specifications', function (Blueprint $table) {
            $table->dropColumn('value');
        });

        Schema::table('safety_features', function (Blueprint $table) {
            $table->dropColumn('value');
        });
    }
};
