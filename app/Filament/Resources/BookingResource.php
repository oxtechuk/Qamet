<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BookingResource\Pages;
use App\Models\Booking;
use Filament\Actions;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class BookingResource extends Resource
{
    protected static ?string $model = Booking::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-shopping-cart';

    public static function getNavigationGroup(): ?string
    {
        return __('Sales & Customers');
    }

    protected static ?string $recordTitleAttribute = 'client_name';

    protected static ?int $navigationSort = 1;

    public static function getModelLabel(): string
    {
        return __('Booking');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Bookings');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Tabs::make(__('Booking'))
                    ->tabs([
                        Tab::make(__('Client Info'))
                            ->schema([
                                Section::make()
                                    ->schema([
                                        Grid::make(2)
                                            ->schema([
                                                Forms\Components\TextInput::make('client_name')->label(__('Client Name'))
                                                    ->required()
                                                    ->maxLength(255),
                                                Forms\Components\TextInput::make('client_phone')->label(__('Client Phone'))
                                                    ->tel()
                                                    ->required()
                                                    ->maxLength(20),
                                            ]),
                                        Grid::make(2)
                                            ->schema([
                                                Forms\Components\TextInput::make('client_email')->label(__('Client Email'))
                                                    ->email()
                                                    ->maxLength(255),
                                                Forms\Components\Select::make('booking_type')->label(__('Booking Type'))
                                                    ->options([
                                                        'test_drive' => __('Test Drive'),
                                                        'booking' => __('Booking'),
                                                        'loan' => __('Loan Request'),
                                                    ])
                                                    ->required(),
                                            ]),
                                    ]),
                            ]),
                        Tab::make(__('Car & Pricing'))
                            ->schema([
                                Section::make()
                                    ->schema([
                                        Grid::make(2)
                                            ->schema([
                                                Forms\Components\Select::make('car_id')->label(__('Car'))
                                                    ->relationship('car', 'name')
                                                    ->searchable()
                                                    ->preload(),
                                                Forms\Components\TextInput::make('car_type')->label(__('Car Type'))
                                                    ->placeholder(__('e.g. Toyota Camry 2025'))
                                                    ->helperText(__('Required if no car is selected from inventory.')),
                                            ]),
                                        Grid::make(3)
                                            ->schema([
                                                Forms\Components\TextInput::make('total_price')->label(__('Total Price'))
                                                    ->numeric()
                                                    ->prefix(__('SAR')),
                                                Forms\Components\TextInput::make('down_payment')->label(__('Down Payment'))
                                                    ->numeric()
                                                    ->prefix(__('SAR')),
                                                Forms\Components\TextInput::make('monthly_installment')->label(__('Monthly Installment'))
                                                    ->numeric()
                                                    ->prefix(__('SAR')),
                                            ]),
                                        Grid::make(3)
                                            ->schema([
                                                Forms\Components\TextInput::make('duration_years')->label(__('Duration Years'))
                                                    ->numeric()
                                                    ->suffix(__('years')),
                                                Forms\Components\Select::make('payment_method')->label(__('Payment Method'))
                                                    ->options([
                                                        'cash' => __('Cash'),
                                                        'bank' => __('Bank Financing'),
                                                    ]),
                                            ]),
                                    ]),
                            ]),
                        Tab::make(__('Status & Assignment'))
                            ->schema([
                                Section::make()
                                    ->schema([
                                        Grid::make(2)
                                            ->schema([
                                                Forms\Components\Select::make('status')->label(__('Status'))
                                                    ->options([
                                                        'new' => __('New'),
                                                        'contacted' => __('Contacted'),
                                                        'interested' => __('Interested'),
                                                        'negotiation' => __('Negotiation'),
                                                        'sold' => __('Sold'),
                                                        'rejected' => __('Rejected'),
                                                        'cancelled' => __('Cancelled'),
                                                    ])
                                                    ->required(),
                                                Forms\Components\Select::make('assigned_to')->label(__('Assigned To'))
                                                    ->relationship('assignedTo', 'name')
                                                    ->searchable()
                                                    ->preload(),
                                            ]),
                                        Grid::make(2)
                                            ->schema([
                                                Forms\Components\Select::make('source')->label(__('Source'))
                                                    ->options([
                                                        'website' => __('Website'),
                                                        'whatsapp' => __('WhatsApp'),
                                                        'referral' => __('Referral'),
                                                        'instagram' => __('Instagram'),
                                                        'facebook' => __('Facebook'),
                                                        'showroom' => __('Showroom'),
                                                        'other' => __('Other'),
                                                    ])
                                                    ->searchable(),
                                                Forms\Components\Textarea::make('notes')->label(__('Notes'))
                                                    ->columnSpanFull(),
                                            ]),
                                    ]),
                            ]),
                    ])
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label(__('ID'))
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('client_name')->label(__('Client Name'))
                    ->searchable()
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('client_phone')->label(__('Client Phone'))
                    ->searchable()
                    ->copyable()
                    ->icon('heroicon-m-phone'),

                Tables\Columns\TextColumn::make('car.name')
                    ->label(__('Car'))
                    ->searchable()
                    ->limit(25),

                Tables\Columns\TextColumn::make('car_type')
                    ->label(__('Car Type'))
                    ->limit(25)
                    ->placeholder('-'),

                Tables\Columns\TextColumn::make('payment_method')
                    ->label(__('Payment'))
                    ->badge()
                    ->formatStateUsing(fn (?string $state): string => match ($state) {
                        'cash' => __('Cash'),
                        'bank' => __('Bank'),
                        default => '-',
                    })
                    ->color(fn (?string $state): string => match ($state) {
                        'cash' => 'success',
                        'bank' => 'info',
                        default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('total_price')->label(__('Total Price'))
                    ->money('SAR')
                    ->sortable(),

                Tables\Columns\TextColumn::make('assignedTo.name')
                    ->label(__('Assigned'))
                    ->badge()
                    ->sortable(),

                Tables\Columns\BadgeColumn::make('status')->label(__('Status'))
                    ->colors([
                        'primary' => 'new',
                        'info' => 'contacted',
                        'warning' => 'interested',
                        'warning' => 'negotiation',
                        'success' => 'sold',
                        'danger' => 'rejected',
                        'gray' => 'cancelled',
                    ]),

                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('Date'))
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'new' => __('New'),
                        'contacted' => __('Contacted'),
                        'interested' => __('Interested'),
                        'negotiation' => __('Negotiation'),
                        'sold' => __('Sold'),
                        'rejected' => __('Rejected'),
                    ]),
                Tables\Filters\SelectFilter::make('booking_type'),
                Tables\Filters\SelectFilter::make('assigned_to')
                    ->relationship('assignedTo', 'name')
                    ->searchable(),
                Tables\Filters\Filter::make('created_at')
                    ->form([
                        Forms\Components\DatePicker::make('created_from')->label(__('Created From')),
                        Forms\Components\DatePicker::make('created_until')->label(__('Created Until')),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when($data['created_from'], fn ($q) => $q->whereDate('created_at', '>=', $data['created_from']))
                            ->when($data['created_until'], fn ($q) => $q->whereDate('created_at', '<=', $data['created_until']));
                    }),
            ])
            ->actions([
                Actions\ViewAction::make(),
                Actions\EditAction::make(),
                Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Actions\BulkActionGroup::make([
                    Actions\DeleteBulkAction::make(),
                    Actions\BulkAction::make('markAsSold')
                        ->label(__('Mark as Sold'))
                        ->icon('heroicon-m-check-circle')
                        ->color('success')
                        ->action(fn ($records) => $records->each->update(['status' => 'sold'])),
                ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->contentGrid([
                'default' => 1,
                'md' => 2,
                'xl' => 3,
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBookings::route('/'),
            'create' => Pages\CreateBooking::route('/create'),
            'view' => Pages\ShowBooking::route('/{record}'),
            'edit' => Pages\EditBooking::route('/{record}/edit'),
        ];
    }
}
