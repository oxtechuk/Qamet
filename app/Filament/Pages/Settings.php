<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use Filament\Actions\Action;
use Filament\Forms;
use Filament\Pages\Page;
use Filament\Schemas\Components\Actions;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\EmbeddedSchema;
use Filament\Schemas\Components\Form;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Filament\Support\Exceptions\Halt;

class Settings extends Page
{
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-cog-6-tooth';

    public function getTitle(): string
    {
        return __('Settings');
    }

    public static function getNavigationLabel(): string
    {
        return __('Settings');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('Settings');
    }

    protected static ?int $navigationSort = 1;

    protected string $view = 'filament.pages.settings';

    public ?array $data = [];

    public function mount(): void
    {
        $this->fillForm();
    }

    protected function fillForm(): void
    {
        $this->callHook('beforeFill');

        $this->form->fill([
            'site_name_ar' => $this->getBilingual('site_name', 'ar'),
            'site_name_en' => $this->getBilingual('site_name', 'en'),
            'site_description_ar' => $this->getBilingual('site_description', 'ar'),
            'site_description_en' => $this->getBilingual('site_description', 'en'),
            'support_email' => $this->getSetting('support_email', ''),
            'support_phone' => $this->getSetting('support_phone', ''),
            'address_ar' => $this->getBilingual('address', 'ar'),
            'address_en' => $this->getBilingual('address', 'en'),
            'social_links' => $this->getSetting('social_links', []),
            'working_hours' => $this->getSetting('working_hours', 'Sat-Thu: 9:00 AM - 9:00 PM'),
            'meta_title_ar' => $this->getBilingual('meta_title', 'ar'),
            'meta_title_en' => $this->getBilingual('meta_title', 'en'),
            'meta_description_ar' => $this->getBilingual('meta_description', 'ar'),
            'meta_description_en' => $this->getBilingual('meta_description', 'en'),
            'google_analytics_id' => $this->getSetting('google_analytics_id', ''),
            'facebook_pixel_id' => $this->getSetting('facebook_pixel_id', ''),
            'whatsapp_number' => $this->getSetting('whatsapp_number', ''),
            'maintenance_mode' => $this->getSetting('maintenance_mode', false),
            'maintenance_message_ar' => $this->getBilingual('maintenance_message', 'ar'),
            'maintenance_message_en' => $this->getBilingual('maintenance_message', 'en'),
            'currency' => $this->getSetting('currency', 'SAR'),
            'locale' => $this->getSetting('locale', 'ar'),
        ]);

        $this->callHook('afterFill');
    }

    public function defaultForm(Schema $schema): Schema
    {
        return $schema
            ->statePath('data');
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make(__('Settings'))
                    ->tabs([
                        Tab::make(__('General'))
                            ->icon('heroicon-m-building-storefront')
                            ->schema([
                                Section::make(__('Site Information'))
                                    ->schema([
                                        Grid::make(2)
                                            ->schema([
                                                Forms\Components\TextInput::make('site_name_ar')
                                                    ->label(__('Site Name').' ('.__('Arabic').')')
                                                    ->required()
                                                    ->maxLength(255),
                                                Forms\Components\TextInput::make('site_name_en')
                                                    ->label(__('Site Name').' ('.__('English').')')
                                                    ->required()
                                                    ->maxLength(255),
                                            ]),
                                        Grid::make(2)
                                            ->schema([
                                                Forms\Components\Textarea::make('site_description_ar')
                                                    ->label(__('Site Description').' ('.__('Arabic').')')
                                                    ->maxLength(500),
                                                Forms\Components\Textarea::make('site_description_en')
                                                    ->label(__('Site Description').' ('.__('English').')')
                                                    ->maxLength(500),
                                            ]),
                                        Grid::make(2)
                                            ->schema([
                                                Forms\Components\TextInput::make('support_email')
                                                    ->label(__('Support Email'))
                                                    ->email(),
                                                Forms\Components\TextInput::make('support_phone')
                                                    ->label(__('Support Phone'))
                                                    ->tel(),
                                            ]),
                                        Grid::make(2)
                                            ->schema([
                                                Forms\Components\Textarea::make('address_ar')
                                                    ->label(__('Address').' ('.__('Arabic').')')
                                                    ->columnSpanFull(),
                                                Forms\Components\Textarea::make('address_en')
                                                    ->label(__('Address').' ('.__('English').')')
                                                    ->columnSpanFull(),
                                            ]),
                                        Forms\Components\TextInput::make('working_hours')
                                            ->label(__('Working Hours'))
                                            ->columnSpanFull(),
                                        Forms\Components\Repeater::make('social_links')
                                            ->label(__('Social Links'))
                                            ->schema([
                                                Grid::make(3)
                                                    ->schema([
                                                        Forms\Components\TextInput::make('platform')
                                                            ->label(__('Platform'))
                                                            ->required(),
                                                        Forms\Components\TextInput::make('url')
                                                            ->label(__('URL'))
                                                            ->url()
                                                            ->required(),
                                                        Forms\Components\ColorPicker::make('color')
                                                            ->label(__('Color')),
                                                    ]),
                                            ])
                                            ->addActionLabel(__('Add Social Link')),
                                    ]),
                            ]),
                        Tab::make(__('SEO & Analytics'))
                            ->icon('heroicon-m-chart-bar')
                            ->schema([
                                Section::make(__('SEO'))
                                    ->schema([
                                        Grid::make(2)
                                            ->schema([
                                                Forms\Components\TextInput::make('meta_title_ar')
                                                    ->label(__('Default Meta Title').' ('.__('Arabic').')'),
                                                Forms\Components\TextInput::make('meta_title_en')
                                                    ->label(__('Default Meta Title').' ('.__('English').')'),
                                            ]),
                                        Grid::make(2)
                                            ->schema([
                                                Forms\Components\Textarea::make('meta_description_ar')
                                                    ->label(__('Default Meta Description').' ('.__('Arabic').')'),
                                                Forms\Components\Textarea::make('meta_description_en')
                                                    ->label(__('Default Meta Description').' ('.__('English').')'),
                                            ]),
                                    ]),
                                Section::make(__('Analytics'))
                                    ->schema([
                                        Forms\Components\TextInput::make('google_analytics_id')
                                            ->label(__('Google Analytics ID'))
                                            ->placeholder(__('e.g. G-XXXXXXXXXX')),
                                        Forms\Components\TextInput::make('facebook_pixel_id')
                                            ->label(__('Facebook Pixel ID')),
                                    ]),
                                Section::make(__('Contact'))
                                    ->schema([
                                        Forms\Components\TextInput::make('whatsapp_number')
                                            ->label(__('WhatsApp Number'))
                                            ->tel()
                                            ->placeholder(__('e.g. +966501234567')),
                                    ]),
                            ]),
                        Tab::make(__('Maintenance'))
                            ->icon('heroicon-m-wrench-screwdriver')
                            ->schema([
                                Section::make()
                                    ->schema([
                                        Forms\Components\Toggle::make('maintenance_mode')
                                            ->label(__('Enable Maintenance Mode'))
                                            ->helperText(__('When enabled, only admins can access the site.')),
                                        Grid::make(2)
                                            ->schema([
                                                Forms\Components\Textarea::make('maintenance_message_ar')
                                                    ->label(__('Maintenance Message').' ('.__('Arabic').')')
                                                    ->helperText(__('Message displayed to visitors during maintenance.')),
                                                Forms\Components\Textarea::make('maintenance_message_en')
                                                    ->label(__('Maintenance Message').' ('.__('English').')')
                                                    ->helperText(__('Message displayed to visitors during maintenance.')),
                                            ]),
                                    ]),
                            ]),
                        Tab::make(__('Localization'))
                            ->icon('heroicon-m-language')
                            ->schema([
                                Section::make()
                                    ->schema([
                                        Grid::make(2)
                                            ->schema([
                                                Forms\Components\Select::make('currency')
                                                    ->label(__('Currency'))
                                                    ->options([
                                                        'SAR' => __('SAR - Saudi Riyal'),
                                                        'AED' => __('AED - UAE Dirham'),
                                                        'USD' => __('USD - US Dollar'),
                                                        'EUR' => __('EUR - Euro'),
                                                    ]),
                                                Forms\Components\Select::make('locale')
                                                    ->label(__('Default Language'))
                                                    ->options([
                                                        'ar' => __('Arabic'),
                                                        'en' => __('English'),
                                                    ]),
                                            ]),
                                    ]),
                            ]),
                    ])
                    ->columnSpanFull(),
            ]);
    }

    public function content(Schema $schema): Schema
    {
        return $schema
            ->components([
                $this->getFormContentComponent(),
            ]);
    }

    public function getFormContentComponent(): Component
    {
        return Form::make([EmbeddedSchema::make('form')])
            ->id('form')
            ->livewireSubmitHandler('save')
            ->footer([
                Actions::make($this->getFormActions())
                    ->alignment($this->getFormActionsAlignment())
                    ->fullWidth(false)
                    ->sticky(false),
            ]);
    }

    protected function getFormActions(): array
    {
        return [
            $this->getSaveFormAction(),
        ];
    }

    protected function getSaveFormAction(): Action
    {
        return Action::make('save')
            ->label(__('Save Settings'))
            ->submit('save')
            ->keyBindings(['mod+s']);
    }

    public function save(): void
    {
        try {
            $data = $this->form->getState();

            foreach ($data as $key => $value) {
                // Check if this is an _ar or _en suffix field (bilingual)
                $suffix = '';
                $baseKey = $key;
                if (str_ends_with($key, '_ar')) {
                    $baseKey = substr($key, 0, -3);
                    $suffix = 'ar';
                } elseif (str_ends_with($key, '_en')) {
                    $baseKey = substr($key, 0, -3);
                    $suffix = 'en';
                }

                if ($suffix !== '' && in_array($baseKey, self::BILINGUAL_KEYS)) {
                    // Merge into existing bilingual value
                    $existing = $this->getSetting($baseKey, []);
                    $existing[$suffix] = $value;
                    Setting::updateOrCreate(
                        ['key' => $baseKey],
                        ['value' => $existing]
                    );
                } elseif (! str_ends_with($key, '_ar') && ! str_ends_with($key, '_en')) {
                    // Regular single-value field
                    Setting::updateOrCreate(
                        ['key' => $key],
                        ['value' => $value]
                    );
                }
            }

            $this->dispatch('settings-saved');
        } catch (Halt $e) {
            return;
        }
    }

    private const BILINGUAL_KEYS = [
        'site_name', 'site_description', 'address',
        'meta_title', 'meta_description', 'maintenance_message',
    ];

    private function getSetting(string $key, mixed $default = null, ?string $locale = null): mixed
    {
        $setting = Setting::where('key', $key)->first();

        if (! $setting) {
            return $default;
        }

        $value = $setting->value;

        if ($locale && is_array($value)) {
            return $value[$locale] ?? null;
        }

        return $value;
    }

    private function getBilingual(string $key, string $locale): ?string
    {
        return $this->getSetting($key, null, $locale);
    }
}
