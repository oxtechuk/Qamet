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
        Schema::table('brands', function (Blueprint $table) {
            $table->json('name')->change();
        });

        Schema::table('cars', function (Blueprint $table) {
            $table->json('name')->change();
            $table->json('description')->nullable()->change();
        });

        Schema::table('offers', function (Blueprint $table) {
            $table->json('title')->change();
            $table->json('description')->nullable()->change();
        });

        Schema::table('blog_posts', function (Blueprint $table) {
            $table->json('title')->change();
            $table->json('excerpt')->nullable()->change();
            $table->json('content')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('brands', function (Blueprint $table) {
            $table->string('name')->change();
        });

        Schema::table('cars', function (Blueprint $table) {
            $table->string('name')->change();
            $table->text('description')->nullable()->change();
        });

        Schema::table('offers', function (Blueprint $table) {
            $table->string('title')->change();
            $table->text('description')->nullable()->change();
        });

        Schema::table('blog_posts', function (Blueprint $table) {
            $table->string('title')->change();
            $table->text('excerpt')->nullable()->change();
            $table->text('content')->change();
        });
    }
};
