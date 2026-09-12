<?php

declare(strict_types=1);

namespace App\Filament\Pages;

use App\Services\Analytics\AdAttributionService;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;

class AdCampaignsAnalytics extends Page
{
    public static function canAccess(): bool
    {
        $user = Auth::guard('employee')->user();

        return (bool) ($user && ($user->isAdmin() || $user->hasPermission('manage-reports') || $user->hasPermission('view-reports')));
    }

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-presentation-chart-line';

    public function getTitle(): string
    {
        return 'تحليلات مبيعات وحملات الإعلانات';
    }

    public static function getNavigationLabel(): string
    {
        return 'تحليلات مبيعات الإعلانات';
    }

    public static function getNavigationGroup(): ?string
    {
        return 'الإعدادات والتحليلات';
    }

    protected static ?int $navigationSort = 2;

    protected string $view = 'filament.pages.ad-campaigns-analytics';

    public string $activeTab = 'overview';

    /**
     * @var array{date_from: string|null, date_to: string|null, platform: string|null}
     */
    public array $filters = [
        'date_from' => null,
        'date_to' => null,
        'platform' => null,
    ];

    public function mount(): void
    {
        $this->filters['date_from'] = now()->startOfMonth()->toDateString();
        $this->filters['date_to'] = now()->endOfMonth()->toDateString();
    }

    public function setQuickFilter(string $period): void
    {
        match ($period) {
            'today' => [
                $this->filters['date_from'] = now()->toDateString(),
                $this->filters['date_to'] = now()->toDateString(),
            ],
            'yesterday' => [
                $this->filters['date_from'] = now()->subDay()->toDateString(),
                $this->filters['date_to'] = now()->subDay()->toDateString(),
            ],
            'week' => [
                $this->filters['date_from'] = now()->startOfWeek()->toDateString(),
                $this->filters['date_to'] = now()->endOfWeek()->toDateString(),
            ],
            'last7' => [
                $this->filters['date_from'] = now()->subDays(7)->toDateString(),
                $this->filters['date_to'] = now()->toDateString(),
            ],
            'month' => [
                $this->filters['date_from'] = now()->startOfMonth()->toDateString(),
                $this->filters['date_to'] = now()->endOfMonth()->toDateString(),
            ],
            'last_month' => [
                $this->filters['date_from'] = now()->subMonth()->startOfMonth()->toDateString(),
                $this->filters['date_to'] = now()->subMonth()->endOfMonth()->toDateString(),
            ],
            'quarter' => [
                $this->filters['date_from'] = now()->startOfQuarter()->toDateString(),
                $this->filters['date_to'] = now()->endOfQuarter()->toDateString(),
            ],
            'year' => [
                $this->filters['date_from'] = now()->startOfYear()->toDateString(),
                $this->filters['date_to'] = now()->endOfYear()->toDateString(),
            ],
            default => null,
        };

        $this->dispatch('$refresh');
    }

    public function setPlatformFilter(?string $platform): void
    {
        $this->filters['platform'] = $platform;
        $this->dispatch('$refresh');
    }

    public function changeTab(string $tab): void
    {
        $this->activeTab = $tab;
    }

    public function updatedFilters(): void
    {
        $this->dispatch('$refresh');
    }

    /**
     * @return array<string, mixed>
     */
    public function getOverviewKpis(): array
    {
        return app(AdAttributionService::class)->getOverviewKpis($this->filters);
    }

    /**
     * @return array<string, array<string, mixed>>
     */
    public function getPlatformBreakdown(): array
    {
        return app(AdAttributionService::class)->getPlatformBreakdown($this->filters);
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public function getCampaignBreakdown(): array
    {
        return app(AdAttributionService::class)->getCampaignBreakdown($this->filters);
    }

    /**
     * @return array{labels: array<int, string>, datasets: array<string, array<string, mixed>>}
     */
    public function getTimelineChartData(): array
    {
        return app(AdAttributionService::class)->getTimelineChartData($this->filters);
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public function getTopCars(): array
    {
        return app(AdAttributionService::class)->getTopCarsFromAds($this->filters);
    }
}
