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
        Schema::table('project_designs', function (Blueprint $table) {
            $table->string('type')->default('social')->after('id'); // social, featured_offer
            $table->string('price')->nullable()->after('link');
            $table->string('top_speed')->nullable()->after('price');
            $table->string('power')->nullable()->after('top_speed');
            $table->string('year')->nullable()->after('power');
            $table->string('badge_text')->nullable()->after('year');
        });
    }

    public function down(): void
    {
        Schema::table('project_designs', function (Blueprint $table) {
            $table->dropColumn(['type', 'price', 'top_speed', 'power', 'year', 'badge_text']);
        });
    }
};
