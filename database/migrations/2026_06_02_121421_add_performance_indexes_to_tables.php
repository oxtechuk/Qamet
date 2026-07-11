<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('cars', function (Blueprint $table) {
            $table->index('brand_id', 'idx_cars_brand_id');
            $table->index('type', 'idx_cars_type');
            $table->index('year', 'idx_cars_year');
            $table->index('cash_price', 'idx_cars_cash_price');
            $table->index('is_highlighted', 'idx_cars_is_highlighted');
            $table->index('availability_status', 'idx_cars_availability_status');
            $table->index(['is_active', 'is_featured', 'id'], 'idx_cars_active_featured_id');
        });

        Schema::table('car_images', function (Blueprint $table) {
            $table->index('car_id', 'idx_car_images_car_id');
            $table->index('sort_order', 'idx_car_images_sort_order');
        });

        Schema::table('blog_posts', function (Blueprint $table) {
            $table->index('is_published', 'idx_blog_posts_is_published');
            $table->index('published_at', 'idx_blog_posts_published_at');
            $table->index('is_featured', 'idx_blog_posts_is_featured');
            $table->index('employee_id', 'idx_blog_posts_employee_id');
        });

        Schema::table('offers', function (Blueprint $table) {
            $table->index('is_active', 'idx_offers_is_active');
            $table->index('starts_at', 'idx_offers_starts_at');
            $table->index('ends_at', 'idx_offers_ends_at');
        });

        Schema::table('bookings', function (Blueprint $table) {
            $table->index('car_id', 'idx_bookings_car_id');
            $table->index('client_phone', 'idx_bookings_client_phone');
            $table->index('assigned_to', 'idx_bookings_assigned_to');
            $table->index(['car_id', 'status'], 'idx_bookings_car_status');
        });

        Schema::table('newsletter_subscribers', function (Blueprint $table) {
            $table->index('email', 'idx_newsletter_email');
            $table->index('is_active', 'idx_newsletter_is_active');
        });

        Schema::table('calculator_banks', function (Blueprint $table) {
            $table->index('is_active', 'idx_calc_banks_is_active');
            $table->index('sort_order', 'idx_calc_banks_sort_order');
        });

        Schema::table('calculator_factors', function (Blueprint $table) {
            $table->index('is_active', 'idx_calc_factors_is_active');
            $table->index('sort_order', 'idx_calc_factors_sort_order');
            $table->index(['type', 'code'], 'idx_calc_factors_type_code');
        });

        Schema::table('settings', function (Blueprint $table) {
            $table->index('key', 'idx_settings_key');
        });

        Schema::table('testimonials', function (Blueprint $table) {
            $table->index('is_visible', 'idx_testimonials_is_visible');
        });

        Schema::table('project_designs', function (Blueprint $table) {
            $table->index('is_featured', 'idx_designs_is_featured');
            $table->index('sort_order', 'idx_designs_sort_order');
            $table->index('type', 'idx_designs_type');
        });

        Schema::table('car_offer', function (Blueprint $table) {
            $table->index('car_id', 'idx_car_offer_car_id');
            $table->index('offer_id', 'idx_car_offer_offer_id');
        });
    }

    public function down(): void
    {
        Schema::table('cars', function (Blueprint $table) {
            $table->dropIndex('idx_cars_brand_id');
            $table->dropIndex('idx_cars_type');
            $table->dropIndex('idx_cars_year');
            $table->dropIndex('idx_cars_cash_price');
            $table->dropIndex('idx_cars_is_highlighted');
            $table->dropIndex('idx_cars_availability_status');
            $table->dropIndex('idx_cars_active_featured_id');
        });

        Schema::table('car_images', function (Blueprint $table) {
            $table->dropIndex('idx_car_images_car_id');
            $table->dropIndex('idx_car_images_sort_order');
        });

        Schema::table('blog_posts', function (Blueprint $table) {
            $table->dropIndex('idx_blog_posts_is_published');
            $table->dropIndex('idx_blog_posts_published_at');
            $table->dropIndex('idx_blog_posts_is_featured');
            $table->dropIndex('idx_blog_posts_employee_id');
        });

        Schema::table('offers', function (Blueprint $table) {
            $table->dropIndex('idx_offers_is_active');
            $table->dropIndex('idx_offers_starts_at');
            $table->dropIndex('idx_offers_ends_at');
        });

        Schema::table('bookings', function (Blueprint $table) {
            $table->dropIndex('idx_bookings_car_id');
            $table->dropIndex('idx_bookings_client_phone');
            $table->dropIndex('idx_bookings_assigned_to');
            $table->dropIndex('idx_bookings_car_status');
        });

        Schema::table('newsletter_subscribers', function (Blueprint $table) {
            $table->dropIndex('idx_newsletter_email');
            $table->dropIndex('idx_newsletter_is_active');
        });

        Schema::table('calculator_banks', function (Blueprint $table) {
            $table->dropIndex('idx_calc_banks_is_active');
            $table->dropIndex('idx_calc_banks_sort_order');
        });

        Schema::table('calculator_factors', function (Blueprint $table) {
            $table->dropIndex('idx_calc_factors_is_active');
            $table->dropIndex('idx_calc_factors_sort_order');
            $table->dropIndex('idx_calc_factors_type_code');
        });

        Schema::table('settings', function (Blueprint $table) {
            $table->dropIndex('idx_settings_key');
        });

        Schema::table('testimonials', function (Blueprint $table) {
            $table->dropIndex('idx_testimonials_is_visible');
        });

        Schema::table('project_designs', function (Blueprint $table) {
            $table->dropIndex('idx_designs_is_featured');
            $table->dropIndex('idx_designs_sort_order');
            $table->dropIndex('idx_designs_type');
        });

        Schema::table('car_offer', function (Blueprint $table) {
            $table->dropIndex('idx_car_offer_car_id');
            $table->dropIndex('idx_car_offer_offer_id');
        });
    }
};
