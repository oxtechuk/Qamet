<?php

namespace App\Filament\Widgets;

use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Widgets\Widget;

class QuickActionsWidget extends Widget implements HasActions
{
    use InteractsWithActions;

    protected static ?int $sort = 2;

    public int|string|array $columnSpan = 'full';

    protected string $view = 'filament.widgets.quick-actions';

    public static function canView(): bool
    {
        $user = \Illuminate\Support\Facades\Auth::guard('employee')->user();

        if (! $user) {
            return false;
        }

        if ($user->isAdmin()) {
            return true;
        }

        return $user->hasPermission([
            'manage-bookings',
            'manage-cash-bookings',
            'manage-finance-bookings',
            'manage-corporate-bookings',
            'manage-leads',
            'manage-cars',
            'manage-brands',
            'manage-offers',
            'manage-tasks',
            'manage-employees',
        ]);
    }

    public function addCarAction(): Action
    {
        return Action::make('addCar')
            ->label(__('Add Car'))
            ->icon('heroicon-m-plus-circle')
            ->color('primary')
            ->url(route('filament.admin.resources.cars.create'));
    }

    public function addBrandAction(): Action
    {
        return Action::make('addBrand')
            ->label(__('Add Brand'))
            ->icon('heroicon-m-plus-circle')
            ->color('gray')
            ->url(route('filament.admin.resources.brands.create'));
    }

    public function createOfferAction(): Action
    {
        return Action::make('createOffer')
            ->label(__('Create Offer'))
            ->icon('heroicon-m-tag')
            ->color('warning')
            ->url(route('filament.admin.resources.offers.create'));
    }

    public function addDealerAction(): Action
    {
        return Action::make('addDealer')
            ->label(__('Add Dealer'))
            ->icon('heroicon-m-building-storefront')
            ->color('success')
            ->url(route('filament.admin.resources.employees.create'));
    }

    public function createAuctionAction(): Action
    {
        return Action::make('createAuction')
            ->label(__('Create Auction'))
            ->icon('heroicon-m-scale')
            ->color('danger')
            ->url(route('filament.admin.resources.offers.create'));
    }
}
