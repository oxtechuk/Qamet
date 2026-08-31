<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BranchResource\Pages;
use App\Models\Branch;
use Filament\Actions;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class BranchResource extends Resource
{
    use \App\Traits\HasResourcePermission;

    protected static string|array|null $permission = 'manage-settings';

    protected static ?string $model = Branch::class;

    protected static string|\BackedEnum|null $navigationIcon = null;

    public static function getNavigationGroup(): ?string
    {
        return 'الكتالوج';
    }

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?int $navigationSort = 12;

    public static function getModelLabel(): string
    {
        return __('Branch');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Branches');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            Section::make()->schema([
                Grid::make(2)->schema([
                    Forms\Components\TextInput::make('city_ar')->label(__('City').' ('.__('Arabic').')')->required()->maxLength(255),
                    Forms\Components\TextInput::make('city_en')->label(__('City').' ('.__('English').')')->required()->maxLength(255),
                ]),
                Grid::make(2)->schema([
                    Forms\Components\TextInput::make('name_ar')->label(__('Name').' ('.__('Arabic').')')->required()->maxLength(255),
                    Forms\Components\TextInput::make('name_en')->label(__('Name').' ('.__('English').')')->required()->maxLength(255),
                ]),
                Grid::make(2)->schema([
                    Forms\Components\Textarea::make('address_ar')->label(__('Address').' ('.__('Arabic').')')->required(),
                    Forms\Components\Textarea::make('address_en')->label(__('Address').' ('.__('English').')')->required(),
                ]),
                Forms\Components\TextInput::make('map_link')->label(__('Map Link'))->url()->maxLength(255)->columnSpanFull(),
                Forms\Components\Repeater::make('departments')
                    ->label(__('Departments'))
                    ->schema([
                        Grid::make(2)->schema([
                            Forms\Components\TextInput::make('label_ar')->label(__('Label').' ('.__('Arabic').')')->required(),
                            Forms\Components\TextInput::make('label_en')->label(__('Label').' ('.__('English').')')->required(),
                        ]),
                        Grid::make(3)->schema([
                            Forms\Components\TextInput::make('phone')->label(__('Phone'))->tel()->required(),
                            Forms\Components\TextInput::make('hours_ar')->label(__('Hours').' ('.__('Arabic').')')->required(),
                            Forms\Components\TextInput::make('hours_en')->label(__('Hours').' ('.__('English').')')->required(),
                        ]),
                    ])
                    ->addActionLabel(__('Add Department'))
                    ->collapsible(),
                Grid::make(2)->schema([
                    Forms\Components\TextInput::make('sort_order')->label(__('Sort Order'))->numeric()->default(0),
                    Forms\Components\Toggle::make('is_active')->label(__('Active'))->default(true),
                ]),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('city')->label(__('City'))->searchable()->sortable(),
                Tables\Columns\TextColumn::make('name')->label(__('Name'))->searchable(),
                Tables\Columns\TextColumn::make('address')->label(__('Address'))->limit(30),
                Tables\Columns\IconColumn::make('is_active')->label(__('Active'))->boolean()->sortable(),
                Tables\Columns\TextColumn::make('sort_order')->label(__('Sort Order'))->numeric()->sortable(),
            ])
            ->filters([Tables\Filters\TernaryFilter::make('is_active')])
            ->actions([Actions\EditAction::make(), Actions\DeleteAction::make()])
            ->bulkActions([Actions\BulkActionGroup::make([Actions\DeleteBulkAction::make()])])
            ->defaultSort('sort_order');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBranches::route('/'),
            'create' => Pages\CreateBranch::route('/create'),
            'edit' => Pages\EditBranch::route('/{record}/edit'),
        ];
    }
}
