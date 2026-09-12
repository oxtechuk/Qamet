<?php

declare(strict_types=1);

namespace App\Services\Analytics;

use App\Models\Booking;
use App\Models\Lead;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

final class AdAttributionService
{
    public function isAttributionSchemaReady(): bool
    {
        try {
            return Schema::hasColumn('leads', 'ad_platform') && Schema::hasColumn('bookings', 'ad_platform');
        } catch (\Throwable) {
            return false;
        }
    }

    public function detectPlatformFromText(?string ...$texts): ?string
    {
        foreach ($texts as $text) {
            if (empty($text)) {
                continue;
            }
            $t = mb_strtolower(trim($text));

            // Google Ads / Analytics
            if (
                str_contains($t, 'google') ||
                str_contains($t, 'جوجل') ||
                str_contains($t, 'قوقل') ||
                str_contains($t, 'adwords') ||
                str_contains($t, 'gclid') ||
                str_contains($t, 'googleads')
            ) {
                return 'google';
            }

            // Meta (Facebook & Instagram)
            if (
                str_contains($t, 'meta') ||
                str_contains($t, 'facebook') ||
                str_contains($t, 'فيسبوك') ||
                str_contains($t, 'فيس بوك') ||
                str_contains($t, 'فيس') ||
                str_contains($t, 'instagram') ||
                str_contains($t, 'انستقرام') ||
                str_contains($t, 'انستغرام') ||
                str_contains($t, 'انستجرام') ||
                str_contains($t, 'fbclid') ||
                str_contains($t, 'igshid') ||
                preg_match('/\b(fb|ig)\b/i', $t)
            ) {
                return 'meta';
            }

            // Snapchat
            if (
                str_contains($t, 'snapchat') ||
                str_contains($t, 'سناب') ||
                str_contains($t, 'سنابشات') ||
                str_contains($t, 'سناب شات') ||
                str_contains($t, 'sccid') ||
                str_contains($t, 'snap')
            ) {
                return 'snapchat';
            }

            // TikTok
            if (
                str_contains($t, 'tiktok') ||
                str_contains($t, 'تيك توك') ||
                str_contains($t, 'تيكتوك') ||
                str_contains($t, 'تيك') ||
                str_contains($t, 'ttclid')
            ) {
                return 'tiktok';
            }
        }

        return null;
    }

    public function extractUtmParam(string $param, ?string ...$texts): ?string
    {
        foreach ($texts as $text) {
            if (empty($text)) {
                continue;
            }
            if (preg_match('/[?&]' . preg_quote($param, '/') . '=([^&\s#]+)/i', $text, $matches)) {
                return urldecode($matches[1]);
            }
            if (preg_match('/' . preg_quote($param, '/') . '[:\s=]+([^\r\n,;&]+)/i', $text, $matches)) {
                $val = trim($matches[1]);
                if (! empty($val)) {
                    return $val;
                }
            }
        }

        return null;
    }

    public function extractClickId(?string ...$texts): ?string
    {
        foreach ($texts as $text) {
            if (empty($text)) {
                continue;
            }
            foreach (['gclid', 'fbclid', 'ttclid', 'sccid'] as $param) {
                if (preg_match('/[?&]' . $param . '=([^&\s#]+)/i', $text, $matches)) {
                    return urldecode($matches[1]);
                }
            }
        }

        return null;
    }

    /**
     * Scan existing past bookings and leads from the last month and attribute them retroactively
     *
     * @return array{bookings_updated: int, leads_updated: int}
     */
    public function retroactivelyScanAndAttributePastRecords(): array
    {
        if (! $this->isAttributionSchemaReady()) {
            return ['bookings_updated' => 0, 'leads_updated' => 0];
        }

        $updatedBookings = 0;
        $updatedLeads = 0;

        // 1. Scan Leads without ad_platform
        $leads = Lead::where(function ($q) {
            $q->whereNull('ad_platform')->orWhere('ad_platform', '');
        })->with('contactSource')->get();

        foreach ($leads as $l) {
            $platform = $this->detectPlatformFromText(
                $l->contactSource?->name,
                $l->status_details,
                $l->subject,
                $l->utm_source,
                $l->referrer_url
            );

            if ($platform) {
                $campaign = $l->utm_campaign ?: $this->extractUtmParam('utm_campaign', $l->status_details, $l->referrer_url);
                $source = $l->utm_source ?: ($this->extractUtmParam('utm_source', $l->status_details, $l->referrer_url) ?: $l->contactSource?->name);
                $medium = $l->utm_medium ?: $this->extractUtmParam('utm_medium', $l->status_details, $l->referrer_url);
                $clickId = $l->click_id ?: $this->extractClickId($l->status_details, $l->referrer_url);

                $l->update([
                    'ad_platform' => $platform,
                    'utm_source' => $source,
                    'utm_campaign' => $campaign,
                    'utm_medium' => $medium,
                    'click_id' => $clickId ?: $l->click_id,
                ]);
                $updatedLeads++;
            }
        }

        // Build a phone lookup map from attributed leads to cross-attribute bookings
        $attributedLeadPhones = Lead::whereNotNull('ad_platform')
            ->where('ad_platform', '!=', '')
            ->whereNotNull('client_phone')
            ->pluck('ad_platform', 'client_phone')
            ->all();

        // 2. Scan Bookings without ad_platform
        $bookings = Booking::where(function ($q) {
            $q->whereNull('ad_platform')->orWhere('ad_platform', '');
        })->get();

        foreach ($bookings as $b) {
            $platform = $this->detectPlatformFromText(
                $b->source,
                $b->notes,
                $b->utm_source,
                $b->click_id,
                $b->referrer_url
            );

            // Cross-match with Lead phone if not found directly
            if (! $platform && ! empty($b->client_phone)) {
                $cleanPhone = preg_replace('/[^0-9]/', '', (string) $b->client_phone);
                foreach ($attributedLeadPhones as $leadPhone => $leadPlatform) {
                    $cleanLeadPhone = preg_replace('/[^0-9]/', '', (string) $leadPhone);
                    if ($cleanPhone === $cleanLeadPhone || (! empty($cleanPhone) && strlen($cleanPhone) >= 9 && str_ends_with($cleanPhone, substr($cleanLeadPhone, -9)))) {
                        $platform = $leadPlatform;
                        break;
                    }
                }
            }

            if ($platform) {
                $campaign = $b->utm_campaign ?: $this->extractUtmParam('utm_campaign', $b->notes, $b->source, $b->referrer_url);
                $source = $b->utm_source ?: ($this->extractUtmParam('utm_source', $b->notes, $b->source, $b->referrer_url) ?: $b->source);
                $medium = $b->utm_medium ?: $this->extractUtmParam('utm_medium', $b->notes, $b->source, $b->referrer_url);
                $clickId = $b->click_id ?: $this->extractClickId($b->notes, $b->source, $b->referrer_url);

                $b->update([
                    'ad_platform' => $platform,
                    'utm_source' => $source,
                    'utm_campaign' => $campaign,
                    'utm_medium' => $medium,
                    'click_id' => $clickId ?: $b->click_id,
                ]);
                $updatedBookings++;
            }
        }

        return [
            'bookings_updated' => $updatedBookings,
            'leads_updated' => $updatedLeads,
        ];
    }

    public const SUPPORTED_PLATFORMS = [
        'google' => [
            'key' => 'google',
            'name' => 'Google Ads & Analytics',
            'name_ar' => 'إعلانات وتحليلات جوجل (Google)',
            'color' => '#EA4335',
            'bg_light' => 'bg-red-50 dark:bg-red-950/30',
            'border' => 'border-red-200 dark:border-red-800',
            'text' => 'text-red-700 dark:text-red-300',
            'icon' => 'google',
        ],
        'meta' => [
            'key' => 'meta',
            'name' => 'Meta (Facebook & Instagram)',
            'name_ar' => 'إعلانات ميتا (فيسبوك وإنستغرام)',
            'color' => '#1877F2',
            'bg_light' => 'bg-blue-50 dark:bg-blue-950/30',
            'border' => 'border-blue-200 dark:border-blue-800',
            'text' => 'text-blue-700 dark:text-blue-300',
            'icon' => 'meta',
        ],
        'snapchat' => [
            'key' => 'snapchat',
            'name' => 'Snapchat Ads',
            'name_ar' => 'إعلانات سناب شات (Snapchat)',
            'color' => '#EAB308',
            'bg_light' => 'bg-amber-50 dark:bg-amber-950/30',
            'border' => 'border-amber-200 dark:border-amber-800',
            'text' => 'text-amber-700 dark:text-amber-300',
            'icon' => 'snapchat',
        ],
        'tiktok' => [
            'key' => 'tiktok',
            'name' => 'TikTok Ads',
            'name_ar' => 'إعلانات تيك توك (TikTok)',
            'color' => '#06B6D4',
            'bg_light' => 'bg-cyan-50 dark:bg-cyan-950/30',
            'border' => 'border-cyan-200 dark:border-cyan-800',
            'text' => 'text-cyan-700 dark:text-cyan-300',
            'icon' => 'tiktok',
        ],
    ];

    /**
     * Compute Top KPI summary cards
     *
     * @param  array{date_from?: string|null, date_to?: string|null, platform?: string|null}  $filters
     * @return array<string, mixed>
     */
    public function getOverviewKpis(array $filters = []): array
    {
        if (! $this->isAttributionSchemaReady()) {
            return [
                'schema_ready' => false,
                'total_ad_leads' => 0,
                'total_ad_bookings' => 0,
                'sold_ad_bookings' => 0,
                'total_ad_revenue' => 0.0,
                'avg_deal_size' => 0.0,
                'conversion_rate' => 0,
                'top_platform_name' => 'في انتظار تحديث قاعدة البيانات',
                'top_platform_key' => null,
                'organic_sold' => 0,
                'organic_revenue' => 0.0,
            ];
        }

        $paidPlatforms = ['google', 'meta', 'snapchat', 'tiktok'];

        $bookingQuery = Booking::query();
        $leadsQuery = Lead::query();

        $this->applyFilters($bookingQuery, $filters);
        $this->applyFilters($leadsQuery, $filters);

        // Ads specific
        $adBookingsQuery = (clone $bookingQuery)->whereIn('ad_platform', $paidPlatforms);
        $adLeadsQuery = (clone $leadsQuery)->whereIn('ad_platform', $paidPlatforms);

        $totalAdLeads = (clone $adLeadsQuery)->count();
        $totalAdBookings = (clone $adBookingsQuery)->count();
        $soldAdBookings = (clone $adBookingsQuery)->where('status', 'sold')->count();
        $totalAdRevenue = (clone $adBookingsQuery)->where('status', 'sold')->sum('total_price');

        // Organic / Direct
        $organicBookings = (clone $bookingQuery)->where(function ($q) use ($paidPlatforms) {
            $q->whereNull('ad_platform')->orWhereNotIn('ad_platform', $paidPlatforms);
        })->where('status', 'sold')->count();

        $organicRevenue = (clone $bookingQuery)->where(function ($q) use ($paidPlatforms) {
            $q->whereNull('ad_platform')->orWhereNotIn('ad_platform', $paidPlatforms);
        })->where('status', 'sold')->sum('total_price');

        $overallConversionRate = $totalAdLeads > 0 ? round(($soldAdBookings / $totalAdLeads) * 100, 1) : 0;
        $avgDealSize = $soldAdBookings > 0 ? round($totalAdRevenue / $soldAdBookings) : 0;

        // Find best platform by revenue
        $bestPlatformData = (clone $adBookingsQuery)
            ->select('ad_platform', DB::raw('SUM(total_price) as rev'), DB::raw('COUNT(*) as count'))
            ->where('status', 'sold')
            ->groupBy('ad_platform')
            ->orderByDesc('rev')
            ->first();

        $topPlatformKey = $bestPlatformData?->ad_platform;
        $topPlatformName = $topPlatformKey && isset(self::SUPPORTED_PLATFORMS[$topPlatformKey])
            ? self::SUPPORTED_PLATFORMS[$topPlatformKey]['name_ar']
            : 'لا توجد بيانات كافية';

        return [
            'schema_ready' => true,
            'total_ad_leads' => $totalAdLeads,
            'total_ad_bookings' => $totalAdBookings,
            'sold_ad_bookings' => $soldAdBookings,
            'total_ad_revenue' => (float) $totalAdRevenue,
            'avg_deal_size' => (float) $avgDealSize,
            'conversion_rate' => $overallConversionRate,
            'top_platform_name' => $topPlatformName,
            'top_platform_key' => $topPlatformKey,
            'organic_sold' => $organicBookings,
            'organic_revenue' => (float) $organicRevenue,
        ];
    }

    /**
     * Get detailed comparison for the 4 platforms
     *
     * @param  array{date_from?: string|null, date_to?: string|null}  $filters
     * @return array<string, array<string, mixed>>
     */
    public function getPlatformBreakdown(array $filters = []): array
    {
        $breakdown = [];

        if (! $this->isAttributionSchemaReady()) {
            foreach (self::SUPPORTED_PLATFORMS as $key => $meta) {
                $breakdown[$key] = [
                    'key' => $key,
                    'name' => $meta['name'],
                    'name_ar' => $meta['name_ar'],
                    'color' => $meta['color'],
                    'bg_light' => $meta['bg_light'],
                    'border' => $meta['border'],
                    'text' => $meta['text'],
                    'icon' => $meta['icon'],
                    'total_leads' => 0,
                    'total_bookings' => 0,
                    'sold_bookings' => 0,
                    'negotiation_bookings' => 0,
                    'total_revenue' => 0.0,
                    'avg_deal_size' => 0.0,
                    'conversion_rate' => 0,
                ];
            }

            return $breakdown;
        }

        foreach (self::SUPPORTED_PLATFORMS as $key => $meta) {
            $bQuery = Booking::query()->where('ad_platform', $key);
            $lQuery = Lead::query()->where('ad_platform', $key);

            $this->applyFilters($bQuery, $filters);
            $this->applyFilters($lQuery, $filters);

            $totalLeads = (clone $lQuery)->count();
            $totalBookings = (clone $bQuery)->count();
            $soldBookings = (clone $bQuery)->where('status', 'sold')->count();
            $negotiationBookings = (clone $bQuery)->whereIn('status', ['interested', 'negotiation'])->count();
            $revenue = (clone $bQuery)->where('status', 'sold')->sum('total_price');

            $convRate = $totalLeads > 0 ? round(($soldBookings / $totalLeads) * 100, 1) : 0;
            $avgOrder = $soldBookings > 0 ? round($revenue / $soldBookings) : 0;

            $breakdown[$key] = [
                'key' => $key,
                'name' => $meta['name'],
                'name_ar' => $meta['name_ar'],
                'color' => $meta['color'],
                'bg_light' => $meta['bg_light'],
                'border' => $meta['border'],
                'text' => $meta['text'],
                'icon' => $meta['icon'],
                'total_leads' => $totalLeads,
                'total_bookings' => $totalBookings,
                'sold_bookings' => $soldBookings,
                'negotiation_bookings' => $negotiationBookings,
                'total_revenue' => (float) $revenue,
                'avg_deal_size' => (float) $avgOrder,
                'conversion_rate' => $convRate,
            ];
        }

        return $breakdown;
    }

    /**
     * Get Campaign-level breakdown table
     *
     * @param  array{date_from?: string|null, date_to?: string|null, platform?: string|null}  $filters
     * @return array<int, array<string, mixed>>
     */
    public function getCampaignBreakdown(array $filters = [], int $limit = 30): array
    {
        if (! $this->isAttributionSchemaReady()) {
            return [];
        }

        $query = Booking::query()
            ->select(
                'ad_platform',
                DB::raw("COALESCE(NULLIF(utm_campaign, ''), 'غير محدد (Direct / Untagged)') as campaign_name"),
                DB::raw("COALESCE(NULLIF(utm_medium, ''), '-') as campaign_medium"),
                DB::raw('COUNT(*) as total_bookings'),
                DB::raw("SUM(CASE WHEN status = 'sold' THEN 1 ELSE 0 END) as sold_count"),
                DB::raw("SUM(CASE WHEN status = 'sold' THEN total_price ELSE 0 END) as total_revenue")
            )
            ->whereNotNull('ad_platform')
            ->groupBy('ad_platform', 'campaign_name', 'campaign_medium')
            ->orderByDesc('total_revenue')
            ->orderByDesc('sold_count');

        $this->applyFilters($query, $filters);

        if (! empty($filters['platform'])) {
            $query->where('ad_platform', $filters['platform']);
        }

        return $query->limit($limit)->get()->map(function ($row) {
            $sold = (int) $row->sold_count;
            $total = (int) $row->total_bookings;
            $revenue = (float) $row->total_revenue;

            return [
                'platform' => $row->ad_platform,
                'platform_info' => self::SUPPORTED_PLATFORMS[$row->ad_platform] ?? [
                    'name_ar' => ucfirst((string) $row->ad_platform),
                    'color' => '#64748B',
                ],
                'campaign_name' => $row->campaign_name,
                'campaign_medium' => $row->campaign_medium,
                'total_bookings' => $total,
                'sold_count' => $sold,
                'total_revenue' => $revenue,
                'conversion_rate' => $total > 0 ? round(($sold / $total) * 100, 1) : 0,
            ];
        })->toArray();
    }

    /**
     * Get daily trend data for charts
     *
     * @param  array{date_from?: string|null, date_to?: string|null}  $filters
     * @return array{labels: array<int, string>, datasets: array<string, array<string, mixed>>}
     */
    public function getTimelineChartData(array $filters = []): array
    {
        if (! $this->isAttributionSchemaReady()) {
            return [
                'labels' => [],
                'datasets' => [],
            ];
        }

        $from = ! empty($filters['date_from']) ? Carbon::parse($filters['date_from']) : now()->subDays(14)->startOfDay();
        $to = ! empty($filters['date_to']) ? Carbon::parse($filters['date_to']) : now()->endOfDay();

        $diffDays = $from->diffInDays($to);
        $format = $diffDays > 45 ? '%Y-%m' : '%Y-%m-%d';
        $displayFormat = $diffDays > 45 ? 'M Y' : 'd M';

        $days = [];
        $current = $from->copy();
        while ($current->lte($to)) {
            $key = $diffDays > 45 ? $current->format('Y-m') : $current->format('Y-m-d');
            $label = $current->translatedFormat($displayFormat);
            $days[$key] = $label;
            $current = $diffDays > 45 ? $current->addMonth() : $current->addDay();
        }

        $datasets = [];
        foreach (self::SUPPORTED_PLATFORMS as $platformKey => $meta) {
            $soldPerDay = Booking::query()
                ->select(DB::raw("DATE_FORMAT(created_at, '{$format}') as period"), DB::raw('COUNT(*) as total'))
                ->where('ad_platform', $platformKey)
                ->where('status', 'sold')
                ->whereBetween('created_at', [$from, $to])
                ->groupBy('period')
                ->pluck('total', 'period')
                ->toArray();

            $leadsPerDay = Lead::query()
                ->select(DB::raw("DATE_FORMAT(created_at, '{$format}') as period"), DB::raw('COUNT(*) as total'))
                ->where('ad_platform', $platformKey)
                ->whereBetween('created_at', [$from, $to])
                ->groupBy('period')
                ->pluck('total', 'period')
                ->toArray();

            $soldSeries = [];
            $leadsSeries = [];
            foreach (array_keys($days) as $dateKey) {
                $soldSeries[] = (int) ($soldPerDay[$dateKey] ?? 0);
                $leadsSeries[] = (int) ($leadsPerDay[$dateKey] ?? 0);
            }

            $datasets[$platformKey] = [
                'name' => $meta['name_ar'],
                'color' => $meta['color'],
                'sold_data' => $soldSeries,
                'leads_data' => $leadsSeries,
            ];
        }

        return [
            'labels' => array_values($days),
            'datasets' => $datasets,
        ];
    }

    /**
     * Get top cars requested through advertising platforms
     *
     * @param  array{date_from?: string|null, date_to?: string|null, platform?: string|null}  $filters
     * @return array<int, array<string, mixed>>
     */
    public function getTopCarsFromAds(array $filters = [], int $limit = 6): array
    {
        if (! $this->isAttributionSchemaReady()) {
            return [];
        }

        $query = Booking::query()
            ->select('car_id', 'ad_platform', DB::raw('COUNT(*) as total_orders'), DB::raw("SUM(CASE WHEN status = 'sold' THEN 1 ELSE 0 END) as sold_orders"))
            ->whereNotNull('car_id')
            ->whereIn('ad_platform', ['google', 'meta', 'snapchat', 'tiktok'])
            ->with(['car.brand'])
            ->groupBy('car_id', 'ad_platform')
            ->orderByDesc('sold_orders')
            ->orderByDesc('total_orders');

        $this->applyFilters($query, $filters);

        if (! empty($filters['platform'])) {
            $query->where('ad_platform', $filters['platform']);
        }

        return $query->limit($limit)->get()->map(function ($row) {
            return [
                'car_name' => $row->car?->name ?? 'سيارة غير محددة',
                'brand_name' => $row->car?->brand?->name ?? '',
                'car_image' => $row->car?->featured_image ?? null,
                'platform' => $row->ad_platform,
                'platform_info' => self::SUPPORTED_PLATFORMS[$row->ad_platform] ?? null,
                'total_orders' => (int) $row->total_orders,
                'sold_orders' => (int) $row->sold_orders,
            ];
        })->toArray();
    }

    /**
     * Apply date range and common filters to query
     */
    private function applyFilters($query, array $filters): void
    {
        if (! empty($filters['date_from'])) {
            $query->whereDate('created_at', '>=', $filters['date_from']);
        }
        if (! empty($filters['date_to'])) {
            $query->whereDate('created_at', '<=', $filters['date_to']);
        }
    }
}
