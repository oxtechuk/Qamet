<?php

namespace App\Filament\Resources\ReviewBookingResource\Pages;

use App\Filament\Resources\ReviewBookingResource;
use Filament\Resources\Pages\ListRecords;

class ListReviewBookings extends ListRecords
{
    protected static string $resource = ReviewBookingResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
