<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CarResource\Pages;
use App\Models\Car;
use App\Services\Media\ImageOptimizationService;
use Filament\Actions;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Storage;
use pxlrbt\FilamentExcel\Actions\Tables\ExportAction;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;

class CarResource extends Resource
{
    use \App\Traits\HasResourcePermission;

    protected static string|array|null $permission = 'manage-cars';

    protected static ?string $model = Car::class;

    protected static string|\BackedEnum|null $navigationIcon = null;

    protected static ?int $navigationSort = 1;

    public static function getNavigationGroup(): ?string
    {
        return 'الكتالوج';
    }

    protected static ?string $recordTitleAttribute = 'name';

    public static function getModelLabel(): string
    {
        return __('Car');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Cars');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->columns(3)
            ->schema([
                // Left/Main Column: Basic Info, Pricing, Specs, Description (2/3 Width)
                Grid::make(1)
                    ->columnSpan(2)
                    ->schema([
                        Section::make(__('Basic Information'))
                            ->icon('heroicon-o-information-circle')
                            ->schema([
                                Grid::make(2)
                                    ->schema([
                                        Forms\Components\TextInput::make('name_ar')->label(__('Name').' ('.__('Arabic').')')
                                            ->required()
                                            ->maxLength(255),
                                        Forms\Components\TextInput::make('name_en')->label(__('Name').' ('.__('English').')')
                                            ->required()
                                            ->maxLength(255),
                                        Forms\Components\TextInput::make('model')->label(__('Model'))
                                            ->maxLength(255),
                                    ]),
                                Grid::make(3)
                                    ->schema([
                                        Forms\Components\Select::make('brand_id')->label(__('Brand'))
                                            ->relationship('brand', 'name')
                                            ->required()
                                            ->searchable()
                                            ->preload()
                                            ->createOptionForm([
                                                Forms\Components\TextInput::make('name_ar')
                                                    ->label(__('Name').' ('.__('Arabic').')')
                                                    ->required(),
                                                Forms\Components\TextInput::make('name_en')
                                                    ->label(__('Name').' ('.__('English').')')
                                                    ->required(),
                                            ]),
                                        Forms\Components\Select::make('car_category_id')->label(__('Car Category'))
                                            ->relationship('category', 'name')
                                            ->searchable()
                                            ->preload()
                                            ->createOptionForm([
                                                Forms\Components\TextInput::make('name_ar')
                                                    ->label(__('Name').' ('.__('Arabic').')')
                                                    ->required(),
                                                Forms\Components\TextInput::make('name_en')
                                                    ->label(__('Name').' ('.__('English').')')
                                                    ->required(),
                                            ]),
                                        Forms\Components\TextInput::make('year')->label(__('Year'))
                                            ->numeric()
                                            ->minValue(1990)
                                            ->maxValue(now()->year + 1),
                                    ]),
                            ]),

                        Section::make(__('Pricing'))
                            ->icon('heroicon-o-currency-dollar')
                            ->schema([
                                Grid::make(3)
                                    ->schema([
                                        Forms\Components\TextInput::make('cash_price')->label(__('Cash Price'))
                                            ->numeric()
                                            ->prefix(__('SAR'))
                                            ->required(),
                                        Forms\Components\TextInput::make('min_down_payment')->label(__('Min Down Payment'))
                                            ->numeric()
                                            ->prefix(__('SAR')),
                                        Forms\Components\TextInput::make('min_installment')->label(__('Min Installment'))
                                            ->numeric()
                                            ->prefix(__('SAR/month')),
                                    ]),
                            ]),

                        Section::make(__('Specifications & Features'))
                            ->icon('heroicon-o-list-bullet')
                            ->schema([
                                Grid::make(3)
                                    ->schema([
                                        Forms\Components\Select::make('specifications')->label(__('Specifications'))
                                            ->relationship('specifications', 'name')
                                            ->multiple()
                                            ->preload()
                                            ->searchable()
                                            ->createOptionForm([
                                                Forms\Components\TextInput::make('name_ar')
                                                    ->label(__('Name').' ('.__('Arabic').')')
                                                    ->required(),
                                                Forms\Components\TextInput::make('name_en')
                                                    ->label(__('Name').' ('.__('English').')')
                                                    ->required(),
                                            ]),
                                        Forms\Components\Select::make('features')->label(__('Features'))
                                            ->relationship('features_list', 'name')
                                            ->multiple()
                                            ->preload()
                                            ->searchable()
                                            ->createOptionForm([
                                                Forms\Components\TextInput::make('name_ar')
                                                    ->label(__('Name').' ('.__('Arabic').')')
                                                    ->required(),
                                                Forms\Components\TextInput::make('name_en')
                                                    ->label(__('Name').' ('.__('English').')')
                                                    ->required(),
                                            ]),
                                        Forms\Components\Select::make('safetyFeatures')->label(__('SafetyFeatures'))
                                            ->relationship('safety_features', 'name')
                                            ->multiple()
                                            ->preload()
                                            ->searchable()
                                            ->createOptionForm([
                                                Forms\Components\TextInput::make('name_ar')
                                                    ->label(__('Name').' ('.__('Arabic').')')
                                                    ->required(),
                                                Forms\Components\TextInput::make('name_en')
                                                    ->label(__('Name').' ('.__('English').')')
                                                    ->required(),
                                            ]),
                                    ]),
                            ]),

                        Section::make(__('Descriptions'))
                            ->collapsible()
                            ->schema([
                                Forms\Components\RichEditor::make('description_ar')->label(__('Description').' ('.__('Arabic').')')
                                    ->columnSpanFull(),
                                Forms\Components\RichEditor::make('description_en')->label(__('Description').' ('.__('English').')')
                                    ->columnSpanFull(),
                            ]),

                        Section::make(__('الألوان والصور الخارجية (Exterior Colors & Images)'))
                            ->icon('heroicon-o-swatch')
                            ->collapsible()
                            ->description(__('إضافة الألوان الخارجية للسيارة مع رفع صور متعددة مخصصة لكل لون'))
                            ->schema([
                                Forms\Components\Repeater::make('exterior_colors')
                                    ->label(__('الألوان الخارجية'))
                                    ->schema([
                                        Grid::make(2)
                                            ->schema([
                                                Forms\Components\TextInput::make('name')
                                                    ->label(__('اسم اللون الخارجي'))
                                                    ->placeholder('مثال: أبيض لؤلؤي، أسود ملكي...')
                                                    ->required(),
                                                Forms\Components\ColorPicker::make('hex')
                                                    ->label(__('كود اللون (Hex)'))
                                                    ->required(),
                                            ]),
                                        Forms\Components\FileUpload::make('images')
                                            ->label(__('صور السيارة بهذا اللون (خارجي)'))
                                            ->multiple()
                                            ->reorderable()
                                            ->image()
                                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp', 'image/gif'])
                                            ->maxSize(10240)
                                            ->disk('public')
                                            ->directory('cars/exterior-colors')
                                            ->visibility('public')
                                            ->saveUploadedFileUsing(ImageOptimizationService::makeCallback('cars/exterior-colors', 1400, 1050, 82))
                                            ->helperText(__('يمكنك رفع صور متعددة للسيارة من الخارج بهذا اللون المحدد')),
                                    ])
                                    ->addActionLabel(__('إضافة لون خارجي جديد'))
                                    ->collapsible()
                                    ->cloneable()
                                    ->itemLabel(fn (array $state): ?string => $state['name'] ?? null),
                            ]),

                        Section::make(__('الألوان والصور الداخلية للمقصورة (Interior Colors & Images)'))
                            ->icon('heroicon-o-sparkles')
                            ->collapsible()
                            ->description(__('إضافة ألوان المقصورة والفرش الداخلي مع رفع صور متعددة مخصصة لكل لون'))
                            ->schema([
                                Forms\Components\Repeater::make('interior_colors')
                                    ->label(__('الألوان الداخلية'))
                                    ->schema([
                                        Grid::make(2)
                                            ->schema([
                                                Forms\Components\TextInput::make('name')
                                                    ->label(__('اسم اللون الداخلي'))
                                                    ->placeholder('مثال: جلد جملي فاخر، بيج، أحمر ماروني...')
                                                    ->required(),
                                                Forms\Components\ColorPicker::make('hex')
                                                    ->label(__('كود اللون (Hex)'))
                                                    ->required(),
                                            ]),
                                        Forms\Components\FileUpload::make('images')
                                            ->label(__('صور المقصورة والفرش بهذا اللون (داخلي)'))
                                            ->multiple()
                                            ->reorderable()
                                            ->image()
                                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp', 'image/gif'])
                                            ->maxSize(10240)
                                            ->disk('public')
                                            ->directory('cars/interior-colors')
                                            ->visibility('public')
                                            ->saveUploadedFileUsing(ImageOptimizationService::makeCallback('cars/interior-colors', 1400, 1050, 82))
                                            ->helperText(__('يمكنك رفع صور متعددة لداخلية السيارة والمقصورة بهذا اللون المحدد')),
                                    ])
                                    ->addActionLabel(__('إضافة لون داخلي جديد'))
                                    ->collapsible()
                                    ->cloneable()
                                    ->itemLabel(fn (array $state): ?string => $state['name'] ?? null),
                            ]),

                        Section::make(__('الفروقات والإضافات'))
                            ->icon('heroicon-o-adjustments-horizontal')
                            ->collapsible()
                            ->collapsed()
                            ->description(__('أضف نسخاً مختلفة من نفس السيارة (مريات، جنوط، باقات) مع صورة وسعر ومواصفات خاصة بكل نسخة'))
                            ->schema([
                                Forms\Components\Repeater::make('variants')
                                    ->label(__('الفروقات والإضافات'))
                                    ->relationship('variants')
                                    ->schema([
                                        Grid::make(2)
                                            ->schema([
                                                Forms\Components\TextInput::make('name')
                                                    ->label(__('اسم الفارياتن / الإضافة'))
                                                    ->placeholder('مثال: جنوط 18 بوصة، باقة Sport، دبل كامل...')
                                                    ->required(),
                                                Forms\Components\TextInput::make('sort_order')
                                                    ->label(__('الترتيب'))
                                                    ->numeric()
                                                    ->default(0),
                                            ]),

                                        Forms\Components\FileUpload::make('image')
                                            ->label(__('صورة هذا الفارياتن'))
                                            ->image()
                                            ->disk('public')
                                            ->directory('cars/variants')
                                            ->visibility('public')
                                            ->saveUploadedFileUsing(ImageOptimizationService::makeCallback('cars/variants', 1400, 1050, 82))
                                            ->helperText(__('ارفع صورة توضح الفرق البصري لهذا الفارياتن')),

                                        Grid::make(3)
                                            ->schema([
                                                Forms\Components\TextInput::make('cash_price')
                                                    ->label(__('سعر الكاش'))
                                                    ->numeric()
                                                    ->prefix(__('SAR')),
                                                Forms\Components\TextInput::make('min_installment')
                                                    ->label(__('أقل قسط شهري'))
                                                    ->numeric()
                                                    ->prefix(__('SAR/شهر')),
                                                Forms\Components\TextInput::make('min_down_payment')
                                                    ->label(__('أقل دفعة أولى'))
                                                    ->numeric()
                                                    ->prefix(__('SAR')),
                                            ]),

                                        Forms\Components\Repeater::make('specs')
                                            ->label(__('المواصفات الخاصة بهذا الفارياتن'))
                                            ->schema([
                                                Grid::make(2)
                                                    ->schema([
                                                        Forms\Components\TextInput::make('key')
                                                            ->label(__('المواصفة'))
                                                            ->placeholder('مثال: نوع الجنوط، حجم الإطار...'),
                                                        Forms\Components\TextInput::make('value')
                                                            ->label(__('القيمة'))
                                                            ->placeholder('مثال: ألومنيوم 18 بوصة...'),
                                                    ]),
                                            ])
                                            ->addActionLabel(__('إضافة مواصفة'))
                                            ->collapsible()
                                            ->defaultItems(0),
                                    ])
                                    ->addActionLabel(__('إضافة فارياتن / إضافة جديدة'))
                                    ->collapsible()
                                    ->cloneable()
                                    ->itemLabel(fn (array $state): ?string => $state['name'] ?? null)
                                    ->orderColumn('sort_order'),
                            ]),
                    ]),

                // Right/Side Column: Settings & Media (1/3 Width)
                Grid::make(1)
                    ->columnSpan(1)
                    ->schema([
                        Section::make(__('Settings'))
                            ->icon('heroicon-o-cog-6-tooth')
                            ->schema([
                                Forms\Components\Toggle::make('is_active')
                                    ->label(__('Active'))
                                    ->default(true),
                                Forms\Components\Toggle::make('is_featured')
                                    ->label(__('Featured Car')),
                                Forms\Components\Select::make('availability_status')->label(__('Availability Status'))
                                    ->options([
                                        'available' => __('Available'),
                                        'sold' => __('Sold'),
                                        'reserved' => __('Reserved'),
                                        'coming_soon' => __('Coming Soon'),
                                    ])
                                    ->default('available'),
                                Forms\Components\Select::make('highlight_id')->label(__('Highlight'))
                                    ->relationship('highlight', 'text_en')
                                    ->searchable()
                                    ->preload()
                                    ->nullable()
                                    ->helperText(__('Optional highlight tag for this car')),
                            ]),

                        Section::make(__('Media & Main Images'))
                            ->icon('heroicon-o-photo')
                            ->schema([
                                Forms\Components\FileUpload::make('thumbnail')->label(__('Thumbnail'))
                                    ->image()
                                    ->disk('public')
                                    ->directory('cars/thumbnails')
                                    ->visibility('public')
                                    ->saveUploadedFileUsing(ImageOptimizationService::makeCallback('cars/thumbnails', 800, 600, 82)),
                                Forms\Components\FileUpload::make('exterior_images')->label(__('صور عامة إضافية (خارجي)'))
                                    ->multiple()
                                    ->reorderable()
                                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp', 'image/gif'])
                                    ->maxSize(10240)
                                    ->disk('public')
                                    ->directory('cars/exterior')
                                    ->visibility('public')
                                    ->saveUploadedFileUsing(ImageOptimizationService::makeCallback('cars/exterior', 1400, 1050, 82)),
                                Forms\Components\FileUpload::make('interior_images')->label(__('صور عامة إضافية (داخلي)'))
                                    ->multiple()
                                    ->reorderable()
                                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp', 'image/gif'])
                                    ->maxSize(10240)
                                    ->disk('public')
                                    ->directory('cars/interior')
                                    ->visibility('public')
                                    ->saveUploadedFileUsing(ImageOptimizationService::makeCallback('cars/interior', 1400, 1050, 82)),
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('thumbnail')->label(__('Thumbnail'))
                    ->circular()
                    ->defaultImageUrl(fn () => asset('images/placeholder-car.jpg')),

                Tables\Columns\TextColumn::make('name')->label(__('Name'))
                    ->searchable()
                    ->sortable()
                    ->limit(30)
                    ->searchable(),

                Tables\Columns\TextColumn::make('brand.name')->label(__('Brand'))
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('year')->label(__('Year'))
                    ->sortable(),

                Tables\Columns\TextColumn::make('cash_price')->label(__('Cash Price'))
                    ->money('SAR')
                    ->sortable(),

                Tables\Columns\BadgeColumn::make('availability_status')->label(__('Availability Status'))
                    ->colors([
                        'success' => 'available',
                        'danger' => 'sold',
                        'warning' => 'reserved',
                        'info' => 'coming_soon',
                    ]),

                Tables\Columns\IconColumn::make('is_featured')
                    ->boolean()
                    ->label(__('Featured'))
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')->label(__('Created At'))
                    ->date()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('brand_id')
                    ->relationship('brand', 'name')
                    ->searchable()
                    ->preload(),
                Tables\Filters\SelectFilter::make('availability_status')
                    ->options([
                        'available' => __('Available'),
                        'sold' => __('Sold'),
                        'reserved' => __('Reserved'),
                        'coming_soon' => __('Coming Soon'),
                    ]),
                Tables\Filters\SelectFilter::make('car_category_id')
                    ->relationship('category', 'name'),
                Tables\Filters\TernaryFilter::make('is_featured')
                    ->label(__('Featured')),
            ])
            ->headerActions([
                ExportAction::make()
                    ->label(__('Export to Excel'))
                    ->color('success'),
                Actions\Action::make('import')
                    ->label(__('Import from Excel'))
                    ->icon('heroicon-o-arrow-up-tray')
                    ->color('warning')
                    ->form([
                        Forms\Components\FileUpload::make('file')
                            ->label(__('Excel or CSV File'))
                            ->required()
                            ->disk('local')
                            ->directory('imports')
                            ->acceptedFileTypes([
                                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                                'application/vnd.ms-excel',
                                'text/csv',
                            ]),
                    ])
                    ->action(function (array $data) {
                        $filePath = Storage::disk('local')->path($data['file']);
                        $sheets = \Maatwebsite\Excel\Facades\Excel::toArray(new class {}, $filePath);
                        $rows = $sheets[0] ?? [];

                        if (count($rows) <= 1) {
                            \Filament\Notifications\Notification::make()
                                ->title(__('File is empty or invalid'))
                                ->danger()
                                ->send();

                            return;
                        }

                        $headers = array_map(fn ($h) => strtolower(trim($h)), $rows[0]);

                        $importedCount = 0;
                        foreach (array_slice($rows, 1) as $row) {
                            $dataRow = array_combine($headers, array_pad($row, count($headers), null));
                            if (! $dataRow || (empty($dataRow['name_ar']) && empty($dataRow['name_en']))) {
                                continue;
                            }

                            // Find or create Brand
                            $brandId = null;
                            if (! empty($dataRow['brand'])) {
                                $brand = \App\Models\Brand::where('name_ar', $dataRow['brand'])
                                    ->orWhere('name_en', $dataRow['brand'])
                                    ->first();
                                if (! $brand) {
                                    $brand = \App\Models\Brand::create([
                                        'name_ar' => $dataRow['brand'],
                                        'name_en' => $dataRow['brand'],
                                        'slug' => \Illuminate\Support\Str::slug($dataRow['brand']) ?: 'brand-'.time(),
                                    ]);
                                }
                                $brandId = $brand->id;
                            }

                            // Find or create Type
                            $typeId = null;
                            if (! empty($dataRow['type'])) {
                                $type = \App\Models\CarType::where('name_ar', $dataRow['type'])
                                    ->orWhere('name_en', $dataRow['type'])
                                    ->first();
                                if (! $type) {
                                    $type = \App\Models\CarType::create([
                                        'name_ar' => $dataRow['type'],
                                        'name_en' => $dataRow['type'],
                                        'slug' => \Illuminate\Support\Str::slug($dataRow['type']) ?: 'type-'.time(),
                                    ]);
                                }
                                $typeId = $type->id;
                            }

                            // Find or create Category
                            $categoryId = null;
                            if (! empty($dataRow['category'])) {
                                $category = \App\Models\CarCategory::where('name_ar', $dataRow['category'])
                                    ->orWhere('name_en', $dataRow['category'])
                                    ->first();
                                if (! $category) {
                                    $category = \App\Models\CarCategory::create([
                                        'name_ar' => $dataRow['category'],
                                        'name_en' => $dataRow['category'],
                                        'slug' => \Illuminate\Support\Str::slug($dataRow['category']) ?: 'category-'.time(),
                                    ]);
                                }
                                $categoryId = $category->id;
                            }

                            $nameAr = $dataRow['name_ar'] ?? $dataRow['name_en'] ?? '';
                            $nameEn = $dataRow['name_en'] ?? $dataRow['name_ar'] ?? '';

                            \App\Models\Car::create([
                                'name_ar' => $nameAr,
                                'name_en' => $nameEn,
                                'slug' => \Illuminate\Support\Str::slug($nameEn) ?: 'car-'.time().'-'.rand(100, 999),
                                'brand_id' => $brandId,
                                'car_type_id' => $typeId,
                                'car_category_id' => $categoryId,
                                'year' => (int) ($dataRow['year'] ?? now()->year),
                                'cash_price' => (float) ($dataRow['cash_price'] ?? 0),
                                'min_down_payment' => (float) ($dataRow['min_down_payment'] ?? 0),
                                'min_installment' => (float) ($dataRow['min_installment'] ?? 0),
                                'is_active' => filter_var($dataRow['is_active'] ?? true, FILTER_VALIDATE_BOOLEAN),
                                'is_featured' => filter_var($dataRow['is_featured'] ?? false, FILTER_VALIDATE_BOOLEAN),
                                'availability_status' => $dataRow['availability_status'] ?? 'available',
                            ]);
                            $importedCount++;
                        }

                        \Filament\Notifications\Notification::make()
                            ->title(__('Imported successfully'))
                            ->description(__('Imported :count cars successfully.', ['count' => $importedCount]))
                            ->success()
                            ->send();
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
                    ExportBulkAction::make()
                        ->label(__('Export Selected to Excel'))
                        ->color('success'),
                ]),
            ])
            ->groups([
                Tables\Grouping\Group::make('brand.name'),
                Tables\Grouping\Group::make('availability_status'),
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
            'index' => Pages\ListCars::route('/'),
            'create' => Pages\CreateCar::route('/create'),
            'edit' => Pages\EditCar::route('/{record}/edit'),
        ];
    }
}
