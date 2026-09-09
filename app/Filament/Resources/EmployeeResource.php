<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EmployeeResource\Pages;
use App\Models\Employee;
use Filament\Actions;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Hash;

class EmployeeResource extends Resource
{
    use \App\Traits\HasResourcePermission;

    protected static string|array|null $permission = 'manage-employees';

    protected static ?string $model = Employee::class;

    protected static string|\BackedEnum|null $navigationIcon = null;

    public static function getNavigationGroup(): ?string
    {
        return 'الفريق';
    }

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?int $navigationSort = 1;

    public static function getModelLabel(): string
    {
        return __('Employee');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Employees');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('البيانات الأساسية والحساب')
                    ->icon('heroicon-o-user')
                    ->description('أدخل معلومات الموظف الشخصية وبيانات تسجيل الدخول')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('الاسم الكامل')
                            ->placeholder('مثال: أحمد إبراهيم')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('username')
                            ->label('اسم المستخدم')
                            ->placeholder('مثال: ahmed_sales')
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),

                        Forms\Components\TextInput::make('email')
                            ->label('البريد الإلكتروني')
                            ->placeholder('name@qmtnjdcars.sa')
                            ->email()
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),

                        Forms\Components\TextInput::make('phone')
                            ->label('رقم الهاتف / الجوال')
                            ->placeholder('05xxxxxxxx')
                            ->tel()
                            ->maxLength(20),

                        Forms\Components\Select::make('roles')
                            ->label('الدور الوظيفي والصلاحيات')
                            ->relationship('roles', 'name')
                            ->preload()
                            ->searchable()
                            ->required()
                            ->native(false),

                        Forms\Components\TextInput::make('password')
                            ->label('كلمة المرور')
                            ->password()
                            ->revealable()
                            ->placeholder('••••••••')
                            ->dehydrateStateUsing(fn ($state) => filled($state) ? Hash::make($state) : null)
                            ->dehydrated(fn ($state) => filled($state))
                            ->required(fn (string $operation): bool => $operation === 'create')
                            ->helperText(fn (string $operation): ?string => $operation === 'edit' ? 'اتركه فارغاً إذا كنت لا ترغب في تغيير كلمة المرور' : null)
                            ->maxLength(255),

                        Forms\Components\FileUpload::make('avatar')
                            ->label('الصورة الشخصية')
                            ->image()
                            ->disk('public')
                            ->directory('employees/avatars')
                            ->visibility('public')
                            ->imageResizeMode('cover')
                            ->imageCropAspectRatio('1:1')
                            ->imageResizeTargetWidth('150')
                            ->imageResizeTargetHeight('150')
                            ->columnSpanFull(),

                        Forms\Components\Toggle::make('is_active')
                            ->label('الحساب نشط ومفعل')
                            ->default(true)
                            ->inline(false)
                            ->helperText('تعطيل الحساب يمنع الموظف من الدخول إلى النظام واستقبال أي طلبات.')
                            ->columnSpanFull(),
                    ])->columns(2),

                Section::make('إعدادات المبيعات وتوزيع الطلبات')
                    ->description('تحديد تخصص المبيعات وما إذا كان الموظف/المدير يستقبل طلبات تلقائية')
                    ->icon('heroicon-o-presentation-chart-line')
                    ->schema([
                        Forms\Components\Toggle::make('receive_auto_assignments')
                            ->label('استقبال الطلبات في التوزيع التلقائي 📥')
                            ->default(true)
                            ->inline(false)
                            ->helperText('عند التفعيل: ستسند الطلبات الجديدة لهذا الموظف (أو المدير) تلقائياً بنظام التوزيع العادل بالأقل حملاً.')
                            ->columnSpanFull(),

                        Forms\Components\Radio::make('sales_type')
                            ->label('نوع وتخصص المبيعات')
                            ->options([
                                'all' => '🔄 شامل (مبيعات كاش وتقسيط معاً)',
                                'cash' => '💵 مندوب مبيعات كاش فقط (الشراء النقدي)',
                                'finance' => '💳 مندوب مبيعات تقسيط وتمويل فقط (الأفراد والبنوك)',
                                'corporate' => '🏢 مبيعات تمويل الشركات والأساطيل',
                                'none' => '🚫 غير متاح للتوزيع (إداري / مدخل بيانات / دعم)',
                            ])
                            ->descriptions([
                                'all' => 'يستقبل طلبات الكاش والتقسيط بالتساوي مع زملائه وفق التوزيع العادل',
                                'cash' => 'يستقبل ويدير فقط طلبات الشراء النقدي والدفع المباشر',
                                'finance' => 'يستقبل ويدير فقط طلبات التمويل البنكي والتقسيط للأفراد',
                                'corporate' => 'يستقبل ويدير فقط طلبات الشركات والمؤسسات وأساطيل السيارات',
                                'none' => 'لا يستقبل أي طلبات تلقائياً (مناسب للمدراء الإشرافيين ومدخلي البيانات)',
                            ])
                            ->default('all')
                            ->dehydrateStateUsing(fn ($state) => $state ?: 'all')
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('avatar')->label(__('Avatar'))
                    ->circular()
                    ->defaultImageUrl(fn ($record) => 'https://ui-avatars.com/api/?name='.urlencode($record->name).'&background=2563EB&color=fff'),

                Tables\Columns\TextColumn::make('name')->label(__('Name'))
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('username')->label(__('Username'))
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('email')->label(__('Email'))
                    ->searchable()
                    ->copyable()
                    ->icon('heroicon-m-envelope'),

                Tables\Columns\TextColumn::make('phone')->label(__('Phone'))
                    ->searchable()
                    ->copyable(),

                Tables\Columns\TextColumn::make('roles.name')->label(__('Role'))
                    ->badge()
                    ->color('primary')
                    ->sortable(),

                Tables\Columns\TextColumn::make('sales_type')->label('تخصص المبيعات')
                    ->badge()
                    ->formatStateUsing(fn (?string $state): string => match ($state) {
                        'cash' => '💵 كاش فقط',
                        'finance' => '💳 تقسيط فقط',
                        'corporate' => '🏢 شركات',
                        'none' => '🚫 إداري / لا يستقبل',
                        default => '🔄 شامل (كاش وتقسيط)',
                    })
                    ->color(fn (?string $state): string => match ($state) {
                        'cash' => 'success',
                        'finance' => 'info',
                        'corporate' => 'warning',
                        'none' => 'danger',
                        default => 'primary',
                    })
                    ->sortable(),

                Tables\Columns\IconColumn::make('receive_auto_assignments')
                    ->label('استقبال الطلبات')
                    ->boolean()
                    ->trueIcon('heroicon-o-arrow-down-tray')
                    ->falseIcon('heroicon-o-no-symbol')
                    ->trueColor('success')
                    ->falseColor('gray')
                    ->sortable(),

                Tables\Columns\TextColumn::make('cash_bookings_count')
                    ->label('طلبات الكاش')
                    ->counts(['bookings as cash_bookings_count' => fn ($q) => $q->where('payment_method', 'cash')])
                    ->badge()
                    ->color('success')
                    ->sortable(),

                Tables\Columns\TextColumn::make('finance_bookings_count')
                    ->label('طلبات التقسيط')
                    ->counts(['bookings as finance_bookings_count' => fn ($q) => $q->where('payment_method', '!=', 'cash')])
                    ->badge()
                    ->color('info')
                    ->sortable(),

                Tables\Columns\TextColumn::make('bookings_count')
                    ->label(__('إجمالي الطلبات'))
                    ->counts('bookings')
                    ->badge()
                    ->color('primary')
                    ->sortable(),

                Tables\Columns\IconColumn::make('is_active')->label(__('Active'))
                    ->boolean()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('roles')
                    ->relationship('roles', 'name')
                    ->multiple()
                    ->preload(),
                Tables\Filters\SelectFilter::make('sales_type')
                    ->label('تخصص المبيعات')
                    ->options([
                        'all' => 'شامل (كاش وتقسيط)',
                        'cash' => 'كاش فقط',
                        'finance' => 'تقسيط فقط',
                        'corporate' => 'شركات',
                        'none' => 'إداري (لا يستقبل)',
                    ]),
                Tables\Filters\TernaryFilter::make('receive_auto_assignments')
                    ->label('استقبال الطلبات التلقائية'),
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('الحالة (نشط / غير نشط)'),
            ])
            ->actions([
                Actions\EditAction::make()
                    ->slideOver()
                    ->modalWidth('4xl')
                    ->modalHeading('تعديل بيانات الموظف')
                    ->modalDescription('تحديث بيانات الموظف وتخصصه في المبيعات واستقبال الطلبات'),
                Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Actions\BulkActionGroup::make([
                    Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('name');
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEmployees::route('/'),
        ];
    }
}
