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
            if (Schema::hasColumn('cars', 'category_id')) {
                $table->index('category_id', 'idx_cars_category_id');
            }
        });

        Schema::table('brands', function (Blueprint $table) {
            if (Schema::hasColumn('brands', 'is_active')) {
                $table->index('is_active', 'idx_brands_is_active');
            }
            if (Schema::hasColumn('brands', 'brand_type_id')) {
                $table->index('brand_type_id', 'idx_brands_brand_type_id');
            }
        });

        Schema::table('car_categories', function (Blueprint $table) {
            if (Schema::hasColumn('car_categories', 'is_active')) {
                $table->index('is_active', 'idx_car_categories_is_active');
            }
        });

        Schema::table('car_types', function (Blueprint $table) {
            if (Schema::hasColumn('car_types', 'is_active')) {
                $table->index('is_active', 'idx_car_types_is_active');
            }
        });

        Schema::table('brand_types', function (Blueprint $table) {
            if (Schema::hasColumn('brand_types', 'is_active')) {
                $table->index('is_active', 'idx_brand_types_is_active');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cars', function (Blueprint $table) {
            $table->dropIndex('idx_cars_category_id');
        });

        Schema::table('brands', function (Blueprint $table) {
            $table->dropIndex('idx_brands_is_active');
            $table->dropIndex('idx_brands_brand_type_id');
        });

        Schema::table('car_categories', function (Blueprint $table) {
            $table->dropIndex('idx_car_categories_is_active');
        });

        Schema::table('car_types', function (Blueprint $table) {
            $table->dropIndex('idx_car_types_is_active');
        });

        Schema::table('brand_types', function (Blueprint $table) {
            $table->dropIndex('idx_brand_types_is_active');
        });
    }
};
