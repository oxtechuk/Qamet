<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RoleResource\Pages;
use Filament\Actions;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Spatie\Permission\Models\Role;

class RoleResource extends Resource
{
    protected static ?string $model = Role::class;

    protected static string|\BackedEnum|null $navigationIcon = null;

    public static function getNavigationGroup(): ?string
    {
        return 'الفريق';
    }

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?int $navigationSort = 2;

    public static function getModelLabel(): string
    {
        return 'الدور والصلاحية';
    }

    public static function getPluralModelLabel(): string
    {
        return 'الأدوار والصلاحيات';
    }

    public static function getPermissionsGrouped(): array
    {
        return [
            'الطلبات والحجوزات' => [
                'icon' => 'heroicon-o-shopping-cart',
                'description' => 'صلاحيات الوصول وإدارة طلبات الحجز وتتبع مسارها',
                'permissions' => [
                    'manage-bookings' => [
                        'label' => 'إدارة وعرض الطلبات والحجوزات',
                        'description' => 'عرض سجلات الطلبات وتعديل الحالات والمتابعة اليومية',
                    ],
                    'manage-tracking' => [
                        'label' => 'تتبع مسار وسجلات الطلبات',
                        'description' => 'الاطلاع على حركة الطلبات وتاريخ التحديثات',
                    ],
                ],
            ],
            'العملاء والليدز' => [
                'icon' => 'heroicon-o-users',
                'description' => 'صلاحيات إدارة جهات الاتصال والعملاء المحتملين',
                'permissions' => [
                    'manage-leads' => [
                        'label' => 'إدارة العملاء المحتملين (Leads)',
                        'description' => 'عرض ومتابعة بيانات العملاء والمهتمين بالشراء',
                    ],
                    'manage-calculator-leads' => [
                        'label' => 'طلبات حاسبة التمويل',
                        'description' => 'عرض حسابات التمويل وطلبات العملاء عبر الحاسبة',
                    ],
                    'manage-contact-sources' => [
                        'label' => 'مصادر التواصل والإحالة',
                        'description' => 'إدارة قنوات التسويق ومصادر ورود العملاء',
                    ],
                    'manage-newsletter' => [
                        'label' => 'النشرة البريدية',
                        'description' => 'الاطلاع على قائمة المشتركين بالنشرة البريدية',
                    ],
                ],
            ],
            'السيارات والكتالوج' => [
                'icon' => 'heroicon-o-truck',
                'description' => 'صلاحيات إدارة المخزون والمواصفات والعروض',
                'permissions' => [
                    'manage-cars' => [
                        'label' => 'إدارة السيارات والمخزون',
                        'description' => 'إضافة وتعديل بيانات السيارات والأسعار والصور والألوان',
                    ],
                    'manage-brands' => [
                        'label' => 'الماركات والشركات المصنعة',
                        'description' => 'إدارة الماركات وشعاراتها وبياناتها',
                    ],
                    'manage-brand-types' => [
                        'label' => 'أنواع الماركات وتصنيفاتها',
                        'description' => 'تصنيف الماركات وفق الفئات المستهدفة',
                    ],
                    'manage-car-categories' => [
                        'label' => 'فئات وتصنيفات السيارات',
                        'description' => 'إدارة فئات السيارات (سيدان، SUV، عائلي..)',
                    ],
                    'manage-car-types' => [
                        'label' => 'أنواع هياكل السيارات',
                        'description' => 'تصنيف أنواع الهياكل والمواصفات الخارجية',
                    ],
                    'manage-specifications' => [
                        'label' => 'المواصفات الفنية للسيارات',
                        'description' => 'إدارة المحركات، استهلاك الوقود، ونواقل الحركة',
                    ],
                    'manage-features' => [
                        'label' => 'المميزات والكماليات',
                        'description' => 'إدارة خيارات الرفاهية والمواصفات الإضافية',
                    ],
                    'manage-safety-features' => [
                        'label' => 'ميزات وأنظمة الأمان',
                        'description' => 'إدارة تجهيزات السلامة والحماية بالسيارات',
                    ],
                    'manage-offers' => [
                        'label' => 'العروض والخصومات',
                        'description' => 'إنشاء حملات العروض الترويجية والأسعار الخاصة',
                    ],
                ],
            ],
            'المهام ولوحة التحكم والتقارير' => [
                'icon' => 'heroicon-o-clipboard-document-check',
                'description' => 'صلاحيات الإحصائيات ومهام المتابعة والتقارير المالية',
                'permissions' => [
                    'manage-dashboard' => [
                        'label' => 'الوصول للوحة التحكم والإحصائيات',
                        'description' => 'عرض المؤشرات العامة والأداء والرسوم البيانية',
                    ],
                    'manage-tasks' => [
                        'label' => 'إدارة مهام المتابعة',
                        'description' => 'إنشاء وإسناد مهام التواصل مع العملاء ومواعيدها',
                    ],
                    'manage-reports' => [
                        'label' => 'عرض وتصدير التقارير',
                        'description' => 'تقارير المبيعات والأداء والتحليلات',
                    ],
                ],
            ],
            'الفريق والمستخدمين' => [
                'icon' => 'heroicon-o-user-group',
                'description' => 'صلاحيات إدارة حسابات الموظفين ومنح الصلاحيات',
                'permissions' => [
                    'manage-employees' => [
                        'label' => 'إدارة حسابات الموظفين والمناديب',
                        'description' => 'إنشاء وتعديل حسابات فريق العمل وتحديد تخصص المبيعات',
                    ],
                    'manage-roles' => [
                        'label' => 'إدارة الأدوار ومصفوفة الصلاحيات',
                        'description' => 'تحديد وتخصيص مستويات الصلاحيات للأدوار الوظيفية',
                    ],
                ],
            ],
            'المحتوى والواجهة' => [
                'icon' => 'heroicon-o-document-text',
                'description' => 'صلاحيات إدارة محتوى الموقع التعريفي والمدونة',
                'permissions' => [
                    'manage-blog' => [
                        'label' => 'المقالات والمدونة',
                        'description' => 'نشر وتعديل المقالات والأخبار وتصنيفاتها',
                    ],
                    'manage-designs' => [
                        'label' => 'مشاريع التصميم والمظهر',
                        'description' => 'إدارة العناصر المرئية ومشاريع الهوية',
                    ],
                    'manage-partners' => [
                        'label' => 'الشركاء والجهات التمويلية',
                        'description' => 'إدارة بيانات وشعارات البنوك وشركات التمويل',
                    ],
                    'manage-testimonials' => [
                        'label' => 'آراء وتقييمات العملاء',
                        'description' => 'إدارة تجارب العملاء المعروضة على الموقع',
                    ],
                    'manage-faqs' => [
                        'label' => 'الأسئلة الشائعة',
                        'description' => 'إدارة قائمة الأسئلة المتكررة وإجاباتها',
                    ],
                ],
            ],
            'الإعدادات والربط والتقنية' => [
                'icon' => 'heroicon-o-cog-6-tooth',
                'description' => 'صلاحيات الضبط المالي، الهوية، والتكاملات التقنية',
                'permissions' => [
                    'manage-calculator-settings' => [
                        'label' => 'إعدادات وضوابط حاسبة التمويل',
                        'description' => 'تحديد نسب الفائدة وشروط البنوك وفترات السداد',
                    ],
                    'manage-settings' => [
                        'label' => 'الإعدادات العامة وهوية الموقع',
                        'description' => 'بيانات التواصل، الشعار، والخيارات الأساسية',
                    ],
                    'manage-settings-integrations' => [
                        'label' => 'إعدادات الربط والـ API',
                        'description' => 'مفاتيح الربط والخدمات الخارجية والتتبع',
                    ],
                    'manage-translations' => [
                        'label' => 'إدارة اللغات والترجمات',
                        'description' => 'تعديل النصوص متعددة اللغات في الواجهات',
                    ],
                ],
            ],
        ];
    }

    public static function getPermissionOptions(): array
    {
        $options = [];
        foreach (self::getPermissionsGrouped() as $group) {
            foreach ($group['permissions'] as $key => $item) {
                $options[$key] = $item['label'];
            }
        }

        return $options;
    }

    public static function getPermissionDescriptions(): array
    {
        $descriptions = [];
        foreach (self::getPermissionsGrouped() as $group) {
            foreach ($group['permissions'] as $key => $item) {
                $descriptions[$key] = $item['description'];
            }
        }

        return $descriptions;
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('معلومات الدور')
                    ->description('أدخل مسمى الدور الوظيفي لتحديد صلاحياته للموظفين')
                    ->icon('heroicon-o-shield-check')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('اسم الدور / المسمى الوظيفي')
                            ->placeholder('مثال: مندوب مبيعات كاش، مدير التسويق، خدمة العملاء')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),
                        Forms\Components\Hidden::make('guard_name')
                            ->default('employee'),
                    ]),

                Section::make('مصفوفة الصلاحيات الممنوحة')
                    ->description('حدد الصلاحيات التي يحق لشاغل هذا الدور الوصول إليها وإدارتها في لوحة التحكم')
                    ->icon('heroicon-o-key')
                    ->schema([
                        Forms\Components\CheckboxList::make('permissions')
                            ->label('قائمة الصلاحيات المتاحة')
                            ->relationship('permissions', 'name')
                            ->options(self::getPermissionOptions())
                            ->descriptions(self::getPermissionDescriptions())
                            ->bulkToggleable()
                            ->searchable()
                            ->columns([
                                'default' => 1,
                                'sm' => 2,
                                'xl' => 3,
                            ])
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('اسم الدور')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                Tables\Columns\TextColumn::make('users_count')
                    ->label('عدد الموظفين')
                    ->counts('users')
                    ->sortable()
                    ->badge()
                    ->color('info'),
                Tables\Columns\TextColumn::make('permissions_count')
                    ->label('عدد الصلاحيات الممنوحة')
                    ->counts('permissions')
                    ->sortable()
                    ->badge()
                    ->color('success'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('تاريخ الإنشاء')
                    ->date('Y-m-d')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([])
            ->actions([
                Actions\EditAction::make()->label('تعديل الصلاحيات'),
                Actions\DeleteAction::make()->label('حذف')
                    ->hidden(fn (Role $record): bool => in_array($record->name, ['admin', 'employee'])),
            ])
            ->bulkActions([])
            ->defaultSort('name');
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRoles::route('/'),
            'create' => Pages\CreateRole::route('/create'),
            'edit' => Pages\EditRole::route('/{record}/edit'),
        ];
    }
}
