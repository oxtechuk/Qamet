<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LeadResource\Pages;
use App\Models\Lead;
use Filament\Actions;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class LeadResource extends Resource
{
    protected static ?string $model = Lead::class;

    protected static string|\BackedEnum|null $navigationIcon = null;

    public static function getNavigationGroup(): ?string
    {
        return 'العملاء';
    }

    protected static ?string $recordTitleAttribute = 'client_name';

    protected static ?int $navigationSort = 1;

    public static function getModelLabel(): string
    {
        return __('Lead');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Leads');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->schema([
                Section::make()
                    ->columns(1)
                    ->schema([
                        Forms\Components\TextInput::make('client_name')
                            ->label(__('Client Name'))
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('client_phone')
                            ->label(__('Client Phone'))
                            ->tel()
                            ->required()
                            ->maxLength(20),
                        Forms\Components\TextInput::make('client_email')
                            ->label(__('Client Email'))
                            ->email()
                            ->maxLength(255),
                        Forms\Components\Select::make('contact_source_id')
                            ->label(__('Source'))
                            ->relationship('contactSource', 'name')
                            ->searchable()
                            ->preload(),
                        Forms\Components\Select::make('status')
                            ->label(__('Status'))
                            ->options([
                                'new' => __('New'),
                                'contacted' => __('Contacted'),
                                'interested' => __('Interested'),
                                'negotiation' => __('Negotiation'),
                                'converted' => __('Converted'),
                                'lost' => __('Lost'),
                            ])
                            ->default('new')
                            ->required(),
                        Forms\Components\Select::make('car_id')
                            ->label(__('Car'))
                            ->relationship('car', 'name')
                            ->searchable()
                            ->preload(),
                        Forms\Components\Select::make('assigned_to')
                            ->label(__('Assigned To'))
                            ->relationship('assignedTo', 'name')
                            ->searchable()
                            ->preload(),
                        Forms\Components\Textarea::make('subject')
                            ->label(__('Subject'))
                            ->rows(3),
                    ]),
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

                Tables\Columns\TextColumn::make('contactSource.name')
                    ->label(__('Source'))
                    ->badge()
                    ->sortable(),

                Tables\Columns\TextColumn::make('car.name')
                    ->label(__('Interested Car'))
                    ->limit(20),

                Tables\Columns\BadgeColumn::make('status')->label(__('Status'))
                    ->colors([
                        'primary' => 'new',
                        'info' => 'contacted',
                        'warning' => 'interested',
                        'warning' => 'negotiation',
                        'success' => 'converted',
                        'danger' => 'lost',
                    ]),

                Tables\Columns\TextColumn::make('assignedTo.name')
                    ->label(__('Assigned'))
                    ->badge()
                    ->sortable(),

                Tables\Columns\TextColumn::make('orders_count')
                    ->label(__('Orders'))
                    ->counts('orders')
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')->label(__('Created At'))
                    ->date()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'new' => __('New'),
                        'contacted' => __('Contacted'),
                        'interested' => __('Interested'),
                        'negotiation' => __('Negotiation'),
                        'converted' => __('Converted'),
                        'lost' => __('Lost'),
                    ]),
                Tables\Filters\SelectFilter::make('contact_source_id')
                    ->relationship('contactSource', 'name'),
                Tables\Filters\SelectFilter::make('assigned_to')
                    ->relationship('assignedTo', 'name'),
            ])
            ->actions([
                Actions\ViewAction::make()
                    ->label(__('Details'))
                    ->icon('heroicon-o-eye')
                    ->color('info')
                    ->slideOver()
                    ->modalWidth('3xl')
                    ->form([
                        Section::make(__('Client Information'))
                            ->schema([
                                Grid::make(3)->schema([
                                    Forms\Components\TextInput::make('client_name')->label(__('Client Name'))->disabled(),
                                    Forms\Components\TextInput::make('client_phone')->label(__('Client Phone'))->disabled(),
                                    Forms\Components\TextInput::make('client_email')->label(__('Client Email'))->disabled(),
                                ]),
                                Grid::make(3)->schema([
                                    Forms\Components\TextInput::make('contactSource.name')->label(__('Source'))->disabled(),
                                    Forms\Components\TextInput::make('status')->label(__('Status'))->disabled(),
                                    Forms\Components\TextInput::make('assignedTo.name')->label(__('Assigned To'))->disabled(),
                                ]),
                                Forms\Components\Textarea::make('subject')->label(__('Subject'))->disabled(),
                            ]),
                        Section::make(__('Client Orders & Bookings'))
                            ->icon('heroicon-o-shopping-cart')
                            ->schema([
                                Forms\Components\Placeholder::make('orders_list')
                                    ->label('')
                                    ->content(function (Lead $record) {
                                        $orders = $record->orders()->with('car')->get();
                                        if ($orders->isEmpty()) {
                                            return new \Illuminate\Support\HtmlString('<div class="p-4 text-center text-gray-500 bg-gray-50 dark:bg-gray-800 rounded-lg">'.__('No orders found for this client.').'</div>');
                                        }
                                        $html = '<div class="overflow-x-auto"><table class="w-full text-sm text-right border-collapse border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden">';
                                        $html .= '<thead class="bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-200"><tr>';
                                        $html .= '<th class="p-3 border border-gray-200 dark:border-gray-700">'.__('ID').'</th>';
                                        $html .= '<th class="p-3 border border-gray-200 dark:border-gray-700">'.__('Car').'</th>';
                                        $html .= '<th class="p-3 border border-gray-200 dark:border-gray-700">'.__('Type').'</th>';
                                        $html .= '<th class="p-3 border border-gray-200 dark:border-gray-700">'.__('Status').'</th>';
                                        $html .= '<th class="p-3 border border-gray-200 dark:border-gray-700">'.__('Date').'</th>';
                                        $html .= '</tr></thead><tbody>';
                                        foreach ($orders as $order) {
                                            $html .= '<tr class="border-t border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800/50">';
                                            $html .= '<td class="p-3 border border-gray-200 dark:border-gray-700 font-mono font-bold text-primary-600">#'.$order->id.'</td>';
                                            $html .= '<td class="p-3 border border-gray-200 dark:border-gray-700 font-semibold">'.htmlspecialchars($order->car?->name ?? '-').'</td>';
                                            $html .= '<td class="p-3 border border-gray-200 dark:border-gray-700">'.htmlspecialchars($order->booking_type ?? '-').'</td>';
                                            $html .= '<td class="p-3 border border-gray-200 dark:border-gray-700"><span class="px-2 py-1 text-xs font-bold rounded bg-amber-100 text-amber-800 dark:bg-amber-900 dark:text-amber-200">'.htmlspecialchars($order->status ?? '-').'</span></td>';
                                            $html .= '<td class="p-3 border border-gray-200 dark:border-gray-700 text-gray-500">'.($order->created_at ? $order->created_at->format('Y-m-d H:i') : '-').'</td>';
                                            $html .= '</tr>';
                                        }
                                        $html .= '</tbody></table></div>';

                                        return new \Illuminate\Support\HtmlString($html);
                                    }),
                            ]),
                    ]),
                Actions\EditAction::make()
                    ->slideOver()
                    ->modalWidth('2xl'),
                Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Actions\BulkActionGroup::make([
                    Actions\BulkAction::make('export_selected_csv')
                        ->label(__('Export Selected CSV'))
                        ->icon('heroicon-o-arrow-down-tray')
                        ->action(function (\Illuminate\Database\Eloquent\Collection $records) {
                            $csvData = "ID,Client Name,Client Phone,Client Email,Source,Interested Car,Status,Assigned To,Created At\n";

                            foreach ($records as $lead) {
                                $csvData .= sprintf(
                                    "\"%s\",\"%s\",\"%s\",\"%s\",\"%s\",\"%s\",\"%s\",\"%s\",\"%s\"\n",
                                    $lead->id,
                                    str_replace('"', '""', $lead->client_name),
                                    str_replace('"', '""', $lead->client_phone),
                                    str_replace('"', '""', $lead->client_email ?? ''),
                                    str_replace('"', '""', $lead->contactSource?->name ?? ''),
                                    str_replace('"', '""', $lead->car?->name ?? ''),
                                    str_replace('"', '""', $lead->status_label),
                                    str_replace('"', '""', $lead->assignedTo?->name ?? ''),
                                    $lead->created_at->format('Y-m-d H:i')
                                );
                            }

                            return response()->streamDownload(function () use ($csvData) {
                                echo "\xEF\xBB\xBF";
                                echo $csvData;
                            }, 'selected_leads_'.date('Y-m-d_H-i').'.csv', [
                                'Content-Type' => 'text/csv; charset=UTF-8',
                            ]);
                        }),
                    Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLeads::route('/'),
        ];
    }
}
