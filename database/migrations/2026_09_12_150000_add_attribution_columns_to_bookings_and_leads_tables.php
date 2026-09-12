<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->string('ad_platform', 50)->nullable()->after('source')->index();
            $table->string('utm_source')->nullable()->after('ad_platform');
            $table->string('utm_medium')->nullable()->after('utm_source');
            $table->string('utm_campaign')->nullable()->after('utm_medium');
            $table->string('utm_content')->nullable()->after('utm_campaign');
            $table->string('utm_term')->nullable()->after('utm_content');
            $table->string('click_id')->nullable()->after('utm_term');
            $table->text('referrer_url')->nullable()->after('click_id');

            $table->index(['ad_platform', 'status', 'created_at'], 'bookings_attribution_perf_idx');
        });

        Schema::table('leads', function (Blueprint $table) {
            $table->string('ad_platform', 50)->nullable()->after('status')->index();
            $table->string('utm_source')->nullable()->after('ad_platform');
            $table->string('utm_medium')->nullable()->after('utm_source');
            $table->string('utm_campaign')->nullable()->after('utm_medium');
            $table->string('utm_content')->nullable()->after('utm_campaign');
            $table->string('utm_term')->nullable()->after('utm_content');
            $table->string('click_id')->nullable()->after('utm_term');
            $table->text('referrer_url')->nullable()->after('click_id');

            $table->index(['ad_platform', 'status', 'created_at'], 'leads_attribution_perf_idx');
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropIndex('bookings_attribution_perf_idx');
            $table->dropIndex(['ad_platform']);
            $table->dropColumn([
                'ad_platform',
                'utm_source',
                'utm_medium',
                'utm_campaign',
                'utm_content',
                'utm_term',
                'click_id',
                'referrer_url',
            ]);
        });

        Schema::table('leads', function (Blueprint $table) {
            $table->dropIndex('leads_attribution_perf_idx');
            $table->dropIndex(['ad_platform']);
            $table->dropColumn([
                'ad_platform',
                'utm_source',
                'utm_medium',
                'utm_campaign',
                'utm_content',
                'utm_term',
                'click_id',
                'referrer_url',
            ]);
        });
    }
};
