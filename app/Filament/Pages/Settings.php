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
    protected static string|\BackedEnum|null $navigationIcon = null;

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
        return 'الإعدادات والتحليلات';
    }

    protected static ?int $navigationSort = 2;

    protected string $view = 'filament.pages.settings';

    public ?array $data = [];

    public function mount(): void
    {
        $this->fillForm();
    }

    protected function fillForm(): void
    {
        $this->callHook('beforeFill');

        $bookingHero = $this->getSetting('store_booking_hero', []);
        $carsHero = $this->getSetting('store_hero', []);
        $offersHero = $this->getSetting('store_offers_hero', []);
        $contactHero = $this->getSetting('store_contact_hero', []);
        $blogHero = $this->getSetting('store_blog_hero', []);
        $aboutHero = $this->getSetting('about_hero', []);
        $aboutStory = $this->getSetting('about_story', []);
        $aboutValuesSection = $this->getSetting('about_values_section', []);
        $aboutWhyChooseUsSection = $this->getSetting('about_why_choose_us_section', []);

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
            'working_hours_from' => $this->getSetting('working_hours_from', '09:00'),
            'working_hours_to' => $this->getSetting('working_hours_to', '21:00'),
            'working_days' => $this->getSetting('working_days', ['sat', 'sun', 'mon', 'tue', 'wed', 'thu']),
            'sales_phone' => $this->getSetting('sales_phone', ''),
            'finance_phone' => $this->getSetting('finance_phone', ''),
            'aftersales_phone' => $this->getSetting('aftersales_phone', ''),
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
            'max_car_price' => $this->getSetting('max_car_price', 2500000),
            'max_down_payment' => $this->getSetting('max_down_payment', 80),
            'offer_hero_slides' => $this->getSetting('offer_hero_slides', []),
            'offers_hero_offer_id' => $this->getSetting('offers_hero_offer_id'),
            'car_hero_slides' => $this->getSetting('car_hero_slides', []),
            'hero_video' => $this->getSetting('hero_video'),
            'hero_video_youtube_ar' => $this->getBilingual('hero_video_youtube', 'ar'),
            'hero_video_youtube_en' => $this->getBilingual('hero_video_youtube', 'en'),
            'hero_slides' => $this->getSetting('hero_slides', []),
            'home_why_us' => $this->getSetting('home_why_us', []),
            'home_budget_brackets' => $this->getSetting('home_budget_brackets', []),
            'homepage_stats' => $this->getSetting('homepage_stats', []),
            ...$this->flattenHomepageSections($this->getSetting('homepage_sections', [])),
            'home_banner' => $this->getSetting('home_banner', []),
            'about_hero_badge_ar' => $aboutHero['badge']['ar'] ?? '',
            'about_hero_badge_en' => $aboutHero['badge']['en'] ?? '',
            'about_hero_title_ar' => $aboutHero['title']['ar'] ?? '',
            'about_hero_title_en' => $aboutHero['title']['en'] ?? '',
            'about_hero_subtitle_ar' => $aboutHero['subtitle']['ar'] ?? '',
            'about_hero_subtitle_en' => $aboutHero['subtitle']['en'] ?? '',
            'about_hero_image' => $aboutHero['image'] ?? null,
            'about_hero_mobile_image' => $aboutHero['mobile_image'] ?? null,
            'about_hero_cta_text_ar' => $aboutHero['cta_text']['ar'] ?? '',
            'about_hero_cta_text_en' => $aboutHero['cta_text']['en'] ?? '',
            'about_hero_cta_url' => $aboutHero['cta_url'] ?? '',
            'about_story_title_ar' => $aboutStory['title']['ar'] ?? '',
            'about_story_title_en' => $aboutStory['title']['en'] ?? '',
            'about_story_description_ar' => $aboutStory['description']['ar'] ?? '',
            'about_story_description_en' => $aboutStory['description']['en'] ?? '',
            'about_story_mission_title_ar' => $aboutStory['mission_title']['ar'] ?? '',
            'about_story_mission_title_en' => $aboutStory['mission_title']['en'] ?? '',
            'about_story_mission_text_ar' => $aboutStory['mission_text']['ar'] ?? '',
            'about_story_mission_text_en' => $aboutStory['mission_text']['en'] ?? '',
            'about_story_vision_title_ar' => $aboutStory['vision_title']['ar'] ?? '',
            'about_story_vision_title_en' => $aboutStory['vision_title']['en'] ?? '',
            'about_story_vision_text_ar' => $aboutStory['vision_text']['ar'] ?? '',
            'about_story_vision_text_en' => $aboutStory['vision_text']['en'] ?? '',
            'about_story_image' => $aboutStory['image'] ?? null,
            'about_values_section_title_ar' => $aboutValuesSection['title']['ar'] ?? '',
            'about_values_section_title_en' => $aboutValuesSection['title']['en'] ?? '',
            'about_values_section_subtitle_ar' => $aboutValuesSection['subtitle']['ar'] ?? '',
            'about_values_section_subtitle_en' => $aboutValuesSection['subtitle']['en'] ?? '',
            'about_why_choose_us_section_title_ar' => $aboutWhyChooseUsSection['title']['ar'] ?? '',
            'about_why_choose_us_section_title_en' => $aboutWhyChooseUsSection['title']['en'] ?? '',
            'about_why_choose_us_section_subtitle_ar' => $aboutWhyChooseUsSection['subtitle']['ar'] ?? '',
            'about_why_choose_us_section_subtitle_en' => $aboutWhyChooseUsSection['subtitle']['en'] ?? '',
            'booking_hero_title_ar' => $bookingHero['title']['ar'] ?? '',
            'booking_hero_title_en' => $bookingHero['title']['en'] ?? '',
            'booking_hero_subtitle_ar' => $bookingHero['subtitle']['ar'] ?? '',
            'booking_hero_subtitle_en' => $bookingHero['subtitle']['en'] ?? '',
            'booking_hero_image' => $bookingHero['image'] ?? null,
            'booking_steps' => $this->getSetting('store_booking_steps', []),
            'cars_hero_title_ar' => $carsHero['title']['ar'] ?? '',
            'cars_hero_title_en' => $carsHero['title']['en'] ?? '',
            'cars_hero_subtitle_ar' => $carsHero['subtitle']['ar'] ?? '',
            'cars_hero_subtitle_en' => $carsHero['subtitle']['en'] ?? '',
            'cars_hero_image' => $carsHero['image'] ?? null,
            'hero_ad_1_image' => $this->getSetting('hero_ad_1_image'),
            'hero_ad_1_link' => $this->getSetting('hero_ad_1_link', ''),
            'hero_ad_2_image' => $this->getSetting('hero_ad_2_image'),
            'hero_ad_2_link' => $this->getSetting('hero_ad_2_link', ''),
            'offers_hero_title_ar' => $offersHero['title']['ar'] ?? '',
            'offers_hero_title_en' => $offersHero['title']['en'] ?? '',
            'offers_hero_subtitle_ar' => $offersHero['subtitle']['ar'] ?? '',
            'offers_hero_subtitle_en' => $offersHero['subtitle']['en'] ?? '',
            'offers_hero_image' => $offersHero['image'] ?? null,
            'contact_hero_title_ar' => $contactHero['title']['ar'] ?? '',
            'contact_hero_title_en' => $contactHero['title']['en'] ?? '',
            'contact_hero_subtitle_ar' => $contactHero['subtitle']['ar'] ?? '',
            'contact_hero_subtitle_en' => $contactHero['subtitle']['en'] ?? '',
            'contact_hero_image' => $contactHero['image'] ?? null,
            'blog_hero_title_ar' => $blogHero['title']['ar'] ?? '',
            'blog_hero_title_en' => $blogHero['title']['en'] ?? '',
            'blog_hero_subtitle_ar' => $blogHero['subtitle']['ar'] ?? '',
            'blog_hero_subtitle_en' => $blogHero['subtitle']['en'] ?? '',
            'blog_hero_image' => $blogHero['image'] ?? null,
            'footer_text' => $this->getSetting('footer_text', ''),
            'auto_assign_bookings' => $this->getSetting('auto_assign_bookings', false),
            'site_logo' => $this->getSetting('site_logo'),
            'site_logo_color' => $this->getSetting('site_logo_color'),
            'site_favicon' => $this->getSetting('site_favicon'),
            'breadcrumb_bg' => $this->getSetting('breadcrumb_bg'),
            'hero_video' => $this->getSetting('hero_video'),
            'page_loader_enabled' => $this->getSetting('page_loader_enabled', true),
            'page_loader_image' => $this->getSetting('page_loader_image'),
            'promo_popup_enabled' => $this->getSetting('promo_popup_enabled', false),
            'promo_popup_image' => $this->getSetting('promo_popup_image'),
            'promo_popup_title' => $this->getSetting('promo_popup_title', ''),
            'promo_popup_text' => $this->getSetting('promo_popup_text', ''),
            'promo_popup_link' => $this->getSetting('promo_popup_link', ''),
            'promo_popup_button_text' => $this->getSetting('promo_popup_button_text', __('Browse Offers')),
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
                        Tab::make(__('General & Branding'))
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
                                                    ->email()
                                                    ->helperText(__('Email displayed in footer and contact pages')),
                                                Forms\Components\TextInput::make('support_phone')
                                                    ->label(__('Support Phone'))
                                                    ->tel()
                                                    ->helperText(__('Main support phone number')),
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
                                    ]),
                                Section::make(__('Branding'))
                                    ->description(__('Logo, favicon, and page backgrounds'))
                                    ->schema([
                                        Grid::make(3)
                                            ->schema([
                                                Forms\Components\FileUpload::make('site_logo')
                                                    ->label(__('Site Logo'))
                                                    ->image()
                                                    ->directory('branding')
                                                    ->visibility('public'),
                                                Forms\Components\FileUpload::make('site_logo_color')
                                                    ->label(__('Colored Site Logo'))
                                                    ->image()
                                                    ->directory('branding')
                                                    ->visibility('public'),
                                                Forms\Components\FileUpload::make('site_favicon')
                                                    ->label(__('Favicon'))
                                                    ->image()
                                                    ->directory('branding')
                                                    ->visibility('public'),
                                            ]),
                                        Forms\Components\FileUpload::make('breadcrumb_bg')
                                            ->label(__('Breadcrumb Background'))
                                            ->image()
                                            ->directory('branding')
                                            ->visibility('public')
                                            ->helperText(__('Background image shown on inner page headers')),
                                    ]),
                                Section::make(__('Page Loader'))
                                    ->description(__('Loading screen shown while the page loads'))
                                    ->schema([
                                        Forms\Components\Toggle::make('page_loader_enabled')
                                            ->label(__('Enable Page Loader'))
                                            ->default(true)
                                            ->helperText(__('Show a loading screen before the page fully loads')),
                                        Forms\Components\FileUpload::make('page_loader_image')
                                            ->label(__('Loader Image / GIF'))
                                            ->image()
                                            ->directory('loader')
                                            ->visibility('public')
                                            ->helperText(__('PNG or animated GIF')),
                                    ]),
                                Section::make(__('Promo Popup'))
                                    ->description(__('Promotional popup shown to visitors after browsing'))
                                    ->schema([
                                        Forms\Components\Toggle::make('promo_popup_enabled')
                                            ->label(__('Enable Popup'))
                                            ->default(false),
                                        Grid::make(2)
                                            ->schema([
                                                Forms\Components\FileUpload::make('promo_popup_image')
                                                    ->label(__('Popup Image'))
                                                    ->image()
                                                    ->directory('popup')
                                                    ->visibility('public'),
                                                Forms\Components\TextInput::make('promo_popup_title')
                                                    ->label(__('Popup Title'))
                                                    ->maxLength(255),
                                            ]),
                                        Forms\Components\Textarea::make('promo_popup_text')
                                            ->label(__('Popup Text'))
                                            ->rows(3)
                                            ->maxLength(500),
                                        Grid::make(2)
                                            ->schema([
                                                Forms\Components\TextInput::make('promo_popup_link')
                                                    ->label(__('Button URL'))
                                                    ->url()
                                                    ->maxLength(500),
                                                Forms\Components\TextInput::make('promo_popup_button_text')
                                                    ->label(__('Button Text'))
                                                    ->maxLength(255)
                                                    ->default(__('Browse Offers')),
                                            ]),
                                    ]),
                                Section::make(__('Localization'))
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
                                                    ])
                                                    ->helperText(__('Default currency for all prices')),
                                                Forms\Components\Select::make('locale')
                                                    ->label(__('Default Language'))
                                                    ->options([
                                                        'ar' => __('Arabic'),
                                                        'en' => __('English'),
                                                    ])
                                                    ->helperText(__('Default language for the storefront')),
                                            ]),
                                    ]),
                            ]),
                        Tab::make(__('Contact & Social'))
                            ->icon('heroicon-m-phone')
                            ->schema([
                                Section::make(__('Working Hours'))
                                    ->description(__('Operating hours for customer service'))
                                    ->schema([
                                        Grid::make(3)
                                            ->schema([
                                                Forms\Components\TimePicker::make('working_hours_from')
                                                    ->label(__('From'))
                                                    ->required(),
                                                Forms\Components\TimePicker::make('working_hours_to')
                                                    ->label(__('To'))
                                                    ->required(),
                                                Forms\Components\Select::make('working_days')
                                                    ->label(__('Working Days'))
                                                    ->multiple()
                                                    ->options([
                                                        'sat' => __('Saturday'),
                                                        'sun' => __('Sunday'),
                                                        'mon' => __('Monday'),
                                                        'tue' => __('Tuesday'),
                                                        'wed' => __('Wednesday'),
                                                        'thu' => __('Thursday'),
                                                        'fri' => __('Friday'),
                                                    ])
                                                    ->helperText(__('Select all days the showroom is open'))
                                                    ->required(),
                                            ]),
                                    ]),
                                Section::make(__('Department Phones'))
                                    ->description(__('Phone numbers for each department'))
                                    ->schema([
                                        Grid::make(3)
                                            ->schema([
                                                Forms\Components\TextInput::make('sales_phone')
                                                    ->label(__('Sales Department'))
                                                    ->tel()
                                                    ->placeholder(__('e.g. +966501234567'))
                                                    ->helperText(__('Direct line for sales inquiries')),
                                                Forms\Components\TextInput::make('finance_phone')
                                                    ->label(__('Finance Department'))
                                                    ->tel()
                                                    ->placeholder(__('e.g. +966501234567'))
                                                    ->helperText(__('For financing and installment questions')),
                                                Forms\Components\TextInput::make('aftersales_phone')
                                                    ->label(__('After-Sales Service'))
                                                    ->tel()
                                                    ->placeholder(__('e.g. +966501234567'))
                                                    ->helperText(__('Maintenance and warranty support')),
                                            ]),
                                    ]),
                                Section::make(__('Social Links'))
                                    ->schema([
                                        Forms\Components\Repeater::make('social_links')
                                            ->label(__('Social Links'))
                                            ->schema([
                                                Grid::make(3)
                                                    ->schema([
                                                        Forms\Components\Select::make('platform')
                                                            ->label(__('Platform'))
                                                            ->options([
                                                                'twitter' => 'Twitter / X',
                                                                'instagram' => 'Instagram',
                                                                'facebook' => 'Facebook',
                                                                'snapchat' => 'Snapchat',
                                                                'tiktok' => 'TikTok',
                                                                'youtube' => 'YouTube',
                                                                'linkedin' => 'LinkedIn',
                                                                'whatsapp' => 'WhatsApp',
                                                            ])
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
                                Section::make(__('Contact Integration'))
                                    ->schema([
                                        Forms\Components\TextInput::make('whatsapp_number')
                                            ->label(__('WhatsApp Number'))
                                            ->tel()
                                            ->placeholder(__('e.g. +966501234567'))
                                            ->helperText(__('Used for WhatsApp confirmation messages')),
                                    ]),
                                Section::make(__('Footer & Automation'))
                                    ->schema([
                                        Forms\Components\Textarea::make('footer_text')
                                            ->label(__('Footer Text'))
                                            ->rows(3)
                                            ->maxLength(500)
                                            ->helperText(__('Text displayed in the site footer')),
                                        Forms\Components\Toggle::make('auto_assign_bookings')
                                            ->label(__('Auto-assign Bookings'))
                                            ->default(false)
                                            ->helperText(__('Automatically distribute bookings to sales employees (Round-Robin)')),
                                    ]),
                            ]),
                        Tab::make(__('Homepage Settings'))
                            ->icon('heroicon-m-home')
                            ->schema([
                                Section::make(__('Hero Media & Slides'))
                                    ->description(__('Configure video or slide background banners at the top of the homepage.'))
                                    ->schema([
                                        Grid::make(2)
                                            ->schema([
                                                Forms\Components\FileUpload::make('hero_video')
                                                    ->label(__('Hero Video (MP4)'))
                                                    ->acceptedFileTypes(['video/mp4', 'video/quicktime'])
                                                    ->maxSize(20480)
                                                    ->directory('branding/videos')
                                                    ->visibility('public')
                                                    ->helperText(__('An MP4 video file to show in the background (max 20MB)')),
                                                Forms\Components\TextInput::make('hero_video_youtube_ar')
                                                    ->label(__('Hero Video YouTube URL').' ('.__('Arabic').')')
                                                    ->url()
                                                    ->placeholder('https://www.youtube.com/watch?v=...')
                                                    ->helperText(__('YouTube video link to show in the background (Arabic)')),
                                                Forms\Components\TextInput::make('hero_video_youtube_en')
                                                    ->label(__('Hero Video YouTube URL').' ('.__('English').')')
                                                    ->url()
                                                    ->placeholder('https://www.youtube.com/watch?v=...')
                                                    ->helperText(__('YouTube video link to show in the background (English)')),
                                            ]),
                                        Forms\Components\Repeater::make('hero_slides')
                                            ->label(__('Image Slides (Fallback if no video is set)'))
                                            ->schema([
                                                Grid::make(2)
                                                    ->schema([
                                                        Forms\Components\FileUpload::make('image')
                                                            ->label(__('Background Image'))
                                                            ->image()
                                                            ->directory('slides/home')
                                                            ->visibility('public')
                                                            ->required(),
                                                        Forms\Components\Select::make('car_id')
                                                            ->label(__('Linked Car').' ('.__('optional').')')
                                                            ->options(fn () => \App\Models\Car::query()->where('is_active', true)->get()->pluck('name', 'id'))
                                                            ->searchable()
                                                            ->helperText(__('If set, price is pulled from this car automatically')),
                                                    ]),
                                                Grid::make(2)
                                                    ->schema([
                                                        Forms\Components\TextInput::make('title_ar')
                                                            ->label(__('Title').' ('.__('Arabic').')'),
                                                        Forms\Components\TextInput::make('title_en')
                                                            ->label(__('Title').' ('.__('English').')'),
                                                    ]),
                                                Grid::make(3)
                                                    ->schema([
                                                        Forms\Components\TextInput::make('button_text_ar')
                                                            ->label(__('Button Text').' ('.__('Arabic').')'),
                                                        Forms\Components\TextInput::make('button_text_en')
                                                            ->label(__('Button Text').' ('.__('English').')'),
                                                        Forms\Components\TextInput::make('link')
                                                            ->label(__('Button Link')),
                                                    ]),
                                                Grid::make(3)
                                                    ->schema([
                                                        Forms\Components\TextInput::make('button_2_text_ar')
                                                            ->label(__('Button 2 Text').' ('.__('Arabic').')'),
                                                        Forms\Components\TextInput::make('button_2_text_en')
                                                            ->label(__('Button 2 Text').' ('.__('English').')'),
                                                        Forms\Components\TextInput::make('link_2')
                                                            ->label(__('Button 2 Link')),
                                                    ]),
                                                Forms\Components\Toggle::make('is_active')
                                                    ->label(__('Active'))
                                                    ->default(true),
                                            ])
                                            ->addActionLabel(__('Add Slide'))
                                            ->reorderable()
                                            ->collapsible()
                                            ->collapsed(),
                                    ]),
                                Section::make(__('Why Choose Us'))
                                    ->description(__('Icon + text cards shown below the hero'))
                                    ->collapsed()
                                    ->schema([
                                        Forms\Components\Repeater::make('home_why_us')
                                            ->label(__('Items'))
                                            ->schema([
                                                Forms\Components\TextInput::make('icon')
                                                    ->label(__('Icon'))
                                                    ->placeholder('heroicon-o-currency-dollar'),
                                                Grid::make(2)
                                                    ->schema([
                                                        Forms\Components\TextInput::make('title_ar')
                                                            ->label(__('Title').' ('.__('Arabic').')')
                                                            ->required(),
                                                        Forms\Components\TextInput::make('title_en')
                                                            ->label(__('Title').' ('.__('English').')')
                                                            ->required(),
                                                    ]),
                                                Grid::make(2)
                                                    ->schema([
                                                        Forms\Components\Textarea::make('description_ar')
                                                            ->label(__('Description').' ('.__('Arabic').')')
                                                            ->rows(2),
                                                        Forms\Components\Textarea::make('description_en')
                                                            ->label(__('Description').' ('.__('English').')')
                                                            ->rows(2),
                                                    ]),
                                            ])
                                            ->addActionLabel(__('Add Item'))
                                            ->collapsible()
                                            ->collapsed(),
                                    ]),
                                Section::make(__('Budget Brackets'))
                                    ->description(__('Quick search brackets by price on homepage'))
                                    ->collapsed()
                                    ->schema([
                                        Forms\Components\Repeater::make('home_budget_brackets')
                                            ->label(__('Brackets'))
                                            ->schema([
                                                Grid::make(3)
                                                    ->schema([
                                                        Forms\Components\TextInput::make('min_price')
                                                            ->label(__('Min Price'))
                                                            ->numeric()
                                                            ->prefix(__('SAR'))
                                                            ->required(),
                                                        Forms\Components\TextInput::make('max_price')
                                                            ->label(__('Max Price'))
                                                            ->numeric()
                                                            ->prefix(__('SAR'))
                                                            ->required(),
                                                        Forms\Components\Select::make('car_category_id')
                                                            ->label(__('Category').' ('.__('optional').')')
                                                            ->options(fn () => \App\Models\CarCategory::query()->where('is_active', true)->get()->pluck('name', 'id'))
                                                            ->searchable()
                                                            ->preload(),
                                                    ]),
                                            ])
                                            ->addActionLabel(__('Add Bracket'))
                                            ->collapsible()
                                            ->collapsed(),
                                    ]),
                                Section::make(__('Homepage Stats'))
                                    ->description(__('Numerical statistics shown on the homepage'))
                                    ->collapsed()
                                    ->schema([
                                        Forms\Components\Repeater::make('homepage_stats')
                                            ->label(__('Stats'))
                                            ->schema([
                                                Grid::make(3)
                                                    ->schema([
                                                        Forms\Components\TextInput::make('number')
                                                            ->label(__('Number / Value'))
                                                            ->required()
                                                            ->placeholder('e.g. 50+'),
                                                        Forms\Components\TextInput::make('label_ar')
                                                            ->label(__('Label').' ('.__('Arabic').')')
                                                            ->required(),
                                                        Forms\Components\TextInput::make('label_en')
                                                            ->label(__('Label').' ('.__('English').')')
                                                            ->required(),
                                                    ]),
                                            ])
                                            ->addActionLabel(__('Add Stat'))
                                            ->collapsible()
                                            ->collapsed(),
                                    ]),
                                Section::make(__('Homepage Sections'))
                                    ->description(__('Enable / disable or customize sections on the homepage'))
                                    ->collapsed()
                                    ->schema([
                                        Grid::make(2)
                                            ->schema([
                                                Forms\Components\Toggle::make('home_section_why_choose_us_enabled')
                                                    ->label(__('Enable "Why Choose Us"'))
                                                    ->default(true),
                                                Forms\Components\Toggle::make('home_section_budget_brackets_enabled')
                                                    ->label(__('Enable Budget Brackets'))
                                                    ->default(true),
                                                Forms\Components\Toggle::make('home_section_latest_cars_enabled')
                                                    ->label(__('Enable Latest Cars'))
                                                    ->default(true),
                                                Forms\Components\Toggle::make('home_section_stats_enabled')
                                                    ->label(__('Enable Homepage Stats'))
                                                    ->default(true),
                                                Forms\Components\Toggle::make('home_section_testimonials_enabled')
                                                    ->label(__('Enable Testimonials'))
                                                    ->default(true),
                                                Forms\Components\Toggle::make('home_section_partners_enabled')
                                                    ->label(__('Enable Partners'))
                                                    ->default(true),
                                                Forms\Components\Toggle::make('home_section_features_enabled')
                                                    ->label(__('Enable Key Features Section'))
                                                    ->default(true),
                                                Forms\Components\Toggle::make('home_section_gallery_enabled')
                                                    ->label(__('Enable Showcase Gallery'))
                                                    ->default(true),
                                            ]),
                                    ]),
                                Section::make(__('Home Banner'))
                                    ->description(__('Promotional banner section on homepage'))
                                    ->collapsed()
                                    ->schema([
                                        Grid::make(2)
                                            ->schema([
                                                Forms\Components\TextInput::make('home_banner.title_ar')
                                                    ->label(__('Title').' ('.__('Arabic').')'),
                                                Forms\Components\TextInput::make('home_banner.title_en')
                                                    ->label(__('Title').' ('.__('English').')'),
                                            ]),
                                        Grid::make(2)
                                            ->schema([
                                                Forms\Components\Textarea::make('home_banner.description_ar')
                                                    ->label(__('Description').' ('.__('Arabic').')')
                                                    ->rows(2),
                                                Forms\Components\Textarea::make('home_banner.description_en')
                                                    ->label(__('Description').' ('.__('English').')')
                                                    ->rows(2),
                                            ]),
                                        Grid::make(3)
                                            ->schema([
                                                Forms\Components\FileUpload::make('home_banner.image')
                                                    ->label(__('Banner Image'))
                                                    ->image()
                                                    ->directory('banners')
                                                    ->visibility('public'),
                                                Forms\Components\TextInput::make('home_banner.button_text_ar')
                                                    ->label(__('Button Text').' ('.__('Arabic').')'),
                                                Forms\Components\TextInput::make('home_banner.button_text_en')
                                                    ->label(__('Button Text').' ('.__('English').')'),
                                            ]),
                                        Grid::make(3)
                                            ->schema([
                                                Forms\Components\TextInput::make('home_banner.link')
                                                    ->label(__('Button Link')),
                                                Forms\Components\TextInput::make('home_banner.badge_ar')
                                                    ->label(__('Badge Text').' ('.__('Arabic').')')
                                                    ->placeholder(__('e.g. Special Offer')),
                                                Forms\Components\TextInput::make('home_banner.badge_en')
                                                    ->label(__('Badge Text').' ('.__('English').')')
                                                    ->placeholder(__('e.g. Special Offer')),
                                            ]),
                                    ]),
                            ]),
                        Tab::make(__('Other Pages'))
                            ->icon('heroicon-m-document-text')
                            ->schema([
                                Tabs::make('other_pages')
                                    ->tabs([
                                        Tab::make(__('About Page'))
                                            ->icon('heroicon-m-information-circle')
                                            ->schema([
                                                Section::make(__('About Page Hero'))
                                                    ->schema([
                                                        Grid::make(2)
                                                            ->schema([
                                                                Forms\Components\TextInput::make('about_hero_badge_ar')
                                                                    ->label(__('Badge Text').' ('.__('Arabic').')'),
                                                                Forms\Components\TextInput::make('about_hero_badge_en')
                                                                    ->label(__('Badge Text').' ('.__('English').')'),
                                                            ]),
                                                        Grid::make(2)
                                                            ->schema([
                                                                Forms\Components\TextInput::make('about_hero_title_ar')
                                                                    ->label(__('Title').' ('.__('Arabic').')'),
                                                                Forms\Components\TextInput::make('about_hero_title_en')
                                                                    ->label(__('Title').' ('.__('English').')'),
                                                            ]),
                                                        Grid::make(2)
                                                            ->schema([
                                                                Forms\Components\Textarea::make('about_hero_subtitle_ar')
                                                                    ->label(__('Subtitle').' ('.__('Arabic').')'),
                                                                Forms\Components\Textarea::make('about_hero_subtitle_en')
                                                                    ->label(__('Subtitle').' ('.__('English').')'),
                                                            ]),
                                                        Grid::make(2)
                                                            ->schema([
                                                                Forms\Components\FileUpload::make('about_hero_image')
                                                                    ->label(__('Hero Background Image'))
                                                                    ->image()
                                                                    ->directory('about')
                                                                    ->visibility('public'),
                                                                Forms\Components\FileUpload::make('about_hero_mobile_image')
                                                                    ->label(__('Hero Background Image (Mobile)'))
                                                                    ->image()
                                                                    ->directory('about')
                                                                    ->visibility('public'),
                                                            ]),
                                                        Grid::make(2)
                                                            ->schema([
                                                                Forms\Components\TextInput::make('about_hero_cta_text_ar')
                                                                    ->label(__('Call to Action Button Text').' ('.__('Arabic').')'),
                                                                Forms\Components\TextInput::make('about_hero_cta_text_en')
                                                                    ->label(__('Call to Action Button Text').' ('.__('English').')'),
                                                            ]),
                                                        Forms\Components\TextInput::make('about_hero_cta_url')
                                                            ->label(__('Call to Action URL'))
                                                            ->url(),
                                                    ]),
                                                Section::make(__('About Story'))
                                                    ->schema([
                                                        Grid::make(2)
                                                            ->schema([
                                                                Forms\Components\TextInput::make('about_story_title_ar')
                                                                    ->label(__('Story Title').' ('.__('Arabic').')'),
                                                                Forms\Components\TextInput::make('about_story_title_en')
                                                                    ->label(__('Story Title').' ('.__('English').')'),
                                                            ]),
                                                        Grid::make(2)
                                                            ->schema([
                                                                Forms\Components\Textarea::make('about_story_description_ar')
                                                                    ->label(__('Story Description').' ('.__('Arabic').')'),
                                                                Forms\Components\Textarea::make('about_story_description_en')
                                                                    ->label(__('Story Description').' ('.__('English').')'),
                                                            ]),
                                                        Grid::make(2)
                                                            ->schema([
                                                                Forms\Components\TextInput::make('about_story_mission_title_ar')
                                                                    ->label(__('Mission Title').' ('.__('Arabic').')'),
                                                                Forms\Components\TextInput::make('about_story_mission_title_en')
                                                                    ->label(__('Mission Title').' ('.__('English').')'),
                                                            ]),
                                                        Grid::make(2)
                                                            ->schema([
                                                                Forms\Components\Textarea::make('about_story_mission_text_ar')
                                                                    ->label(__('Mission Text').' ('.__('Arabic').')'),
                                                                Forms\Components\Textarea::make('about_story_mission_text_en')
                                                                    ->label(__('Mission Text').' ('.__('English').')'),
                                                            ]),
                                                        Grid::make(2)
                                                            ->schema([
                                                                Forms\Components\TextInput::make('about_story_vision_title_ar')
                                                                    ->label(__('Vision Title').' ('.__('Arabic').')'),
                                                                Forms\Components\TextInput::make('about_story_vision_title_en')
                                                                    ->label(__('Vision Title').' ('.__('English').')'),
                                                            ]),
                                                        Grid::make(2)
                                                            ->schema([
                                                                Forms\Components\Textarea::make('about_story_vision_text_ar')
                                                                    ->label(__('Vision Text').' ('.__('Arabic').')'),
                                                                Forms\Components\Textarea::make('about_story_vision_text_en')
                                                                    ->label(__('Vision Text').' ('.__('English').')'),
                                                            ]),
                                                        Forms\Components\FileUpload::make('about_story_image')
                                                            ->label(__('Optional Image'))
                                                            ->image()
                                                            ->directory('about')
                                                            ->visibility('public'),
                                                    ]),
                                            ]),
                                    ]),
                            ]),
                        Tab::make(__('SEO & Integrations'))
                            ->icon('heroicon-m-globe-alt')
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
                                            ->placeholder(__('e.g. G-XXXXXXXXXX'))
                                            ->helperText(__('Format: G-XXXXXXXXXX')),
                                        Forms\Components\TextInput::make('facebook_pixel_id')
                                            ->label(__('Facebook Pixel ID'))
                                            ->helperText(__('Numeric ID from Facebook Events Manager')),
                                    ]),
                                Section::make(__('Calculator Limits'))
                                    ->description(__('Configure maximum values for the installment calculator'))
                                    ->schema([
                                        Grid::make(2)
                                            ->schema([
                                                Forms\Components\TextInput::make('max_car_price')
                                                    ->label(__('Max Car Price'))
                                                    ->numeric()
                                                    ->prefix(__('SAR'))
                                                    ->required()
                                                    ->helperText(__('Maximum car price allowed in the calculator.')),
                                                Forms\Components\TextInput::make('max_down_payment')
                                                    ->label(__('Max Down Payment %'))
                                                    ->numeric()
                                                    ->suffix('%')
                                                    ->minValue(0)
                                                    ->maxValue(100)
                                                    ->required()
                                                    ->helperText(__('Maximum down payment percentage allowed.')),
                                            ]),
                                    ]),
                            ]),
                        Tab::make(__('Maintenance Mode'))
                            ->icon('heroicon-m-wrench-screwdriver')
                            ->schema([
                                Section::make(__('Maintenance'))
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
                    $existing = $this->getSetting($baseKey, []);
                    $existing[$suffix] = $value;
                    Setting::updateOrCreate(
                        ['key' => $baseKey],
                        ['value' => $existing]
                    );
                } elseif (in_array($key, self::HERO_KEYS)) {
                    $this->saveHeroSetting($key, $value);
                } elseif (in_array($key, self::ARRAY_KEYS)) {
                    Setting::updateOrCreate(
                        ['key' => $key],
                        ['value' => $value]
                    );
                } elseif (! str_ends_with($key, '_ar') && ! str_ends_with($key, '_en')) {
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

    private function saveHeroSetting(string $flatKey, mixed $value): void
    {
        $map = [
            'booking_hero_title_ar' => ['store_booking_hero', 'title', 'ar'],
            'booking_hero_title_en' => ['store_booking_hero', 'title', 'en'],
            'booking_hero_subtitle_ar' => ['store_booking_hero', 'subtitle', 'ar'],
            'booking_hero_subtitle_en' => ['store_booking_hero', 'subtitle', 'en'],
            'booking_hero_image' => ['store_booking_hero', 'image'],
            'cars_hero_title_ar' => ['store_hero', 'title', 'ar'],
            'cars_hero_title_en' => ['store_hero', 'title', 'en'],
            'cars_hero_subtitle_ar' => ['store_hero', 'subtitle', 'ar'],
            'cars_hero_subtitle_en' => ['store_hero', 'subtitle', 'en'],
            'cars_hero_image' => ['store_hero', 'image'],
            'offers_hero_title_ar' => ['store_offers_hero', 'title', 'ar'],
            'offers_hero_title_en' => ['store_offers_hero', 'title', 'en'],
            'offers_hero_subtitle_ar' => ['store_offers_hero', 'subtitle', 'ar'],
            'offers_hero_subtitle_en' => ['store_offers_hero', 'subtitle', 'en'],
            'offers_hero_image' => ['store_offers_hero', 'image'],
            'contact_hero_title_ar' => ['store_contact_hero', 'title', 'ar'],
            'contact_hero_title_en' => ['store_contact_hero', 'title', 'en'],
            'contact_hero_subtitle_ar' => ['store_contact_hero', 'subtitle', 'ar'],
            'contact_hero_subtitle_en' => ['store_contact_hero', 'subtitle', 'en'],
            'contact_hero_image' => ['store_contact_hero', 'image'],
            'blog_hero_title_ar' => ['store_blog_hero', 'title', 'ar'],
            'blog_hero_title_en' => ['store_blog_hero', 'title', 'en'],
            'blog_hero_subtitle_ar' => ['store_blog_hero', 'subtitle', 'ar'],
            'blog_hero_subtitle_en' => ['store_blog_hero', 'subtitle', 'en'],
            'blog_hero_image' => ['store_blog_hero', 'image'],
            'about_hero_badge_ar' => ['about_hero', 'badge', 'ar'],
            'about_hero_badge_en' => ['about_hero', 'badge', 'en'],
            'about_hero_title_ar' => ['about_hero', 'title', 'ar'],
            'about_hero_title_en' => ['about_hero', 'title', 'en'],
            'about_hero_subtitle_ar' => ['about_hero', 'subtitle', 'ar'],
            'about_hero_subtitle_en' => ['about_hero', 'subtitle', 'en'],
            'about_hero_image' => ['about_hero', 'image'],
            'about_hero_mobile_image' => ['about_hero', 'mobile_image'],
            'about_hero_cta_text_ar' => ['about_hero', 'cta_text', 'ar'],
            'about_hero_cta_text_en' => ['about_hero', 'cta_text', 'en'],
            'about_hero_cta_url' => ['about_hero', 'cta_url'],
            'about_story_title_ar' => ['about_story', 'title', 'ar'],
            'about_story_title_en' => ['about_story', 'title', 'en'],
            'about_story_description_ar' => ['about_story', 'description', 'ar'],
            'about_story_description_en' => ['about_story', 'description', 'en'],
            'about_story_mission_title_ar' => ['about_story', 'mission_title', 'ar'],
            'about_story_mission_title_en' => ['about_story', 'mission_title', 'en'],
            'about_story_mission_text_ar' => ['about_story', 'mission_text', 'ar'],
            'about_story_mission_text_en' => ['about_story', 'mission_text', 'en'],
            'about_story_vision_title_ar' => ['about_story', 'vision_title', 'ar'],
            'about_story_vision_title_en' => ['about_story', 'vision_title', 'en'],
            'about_story_vision_text_ar' => ['about_story', 'vision_text', 'ar'],
            'about_story_vision_text_en' => ['about_story', 'vision_text', 'en'],
            'about_story_image' => ['about_story', 'image'],
            'about_values_section_title_ar' => ['about_values_section', 'title', 'ar'],
            'about_values_section_title_en' => ['about_values_section', 'title', 'en'],
            'about_values_section_subtitle_ar' => ['about_values_section', 'subtitle', 'ar'],
            'about_values_section_subtitle_en' => ['about_values_section', 'subtitle', 'en'],
            'about_why_choose_us_section_title_ar' => ['about_why_choose_us_section', 'title', 'ar'],
            'about_why_choose_us_section_title_en' => ['about_why_choose_us_section', 'title', 'en'],
            'about_why_choose_us_section_subtitle_ar' => ['about_why_choose_us_section', 'subtitle', 'ar'],
            'about_why_choose_us_section_subtitle_en' => ['about_why_choose_us_section', 'subtitle', 'en'],
            // Homepage section copy
            'hcs_filter_title_ar' => ['homepage_sections', 'filter', 'title', 'ar'],
            'hcs_filter_title_en' => ['homepage_sections', 'filter', 'title', 'en'],
            'hcs_featured_cars_badge_ar' => ['homepage_sections', 'featured_cars', 'badge', 'ar'],
            'hcs_featured_cars_badge_en' => ['homepage_sections', 'featured_cars', 'badge', 'en'],
            'hcs_featured_cars_title_ar' => ['homepage_sections', 'featured_cars', 'title', 'ar'],
            'hcs_featured_cars_title_en' => ['homepage_sections', 'featured_cars', 'title', 'en'],
            'hcs_featured_cars_subtitle_ar' => ['homepage_sections', 'featured_cars', 'subtitle', 'ar'],
            'hcs_featured_cars_subtitle_en' => ['homepage_sections', 'featured_cars', 'subtitle', 'en'],
            'hcs_featured_cars_button_text_ar' => ['homepage_sections', 'featured_cars', 'button_text', 'ar'],
            'hcs_featured_cars_button_text_en' => ['homepage_sections', 'featured_cars', 'button_text', 'en'],
            'hcs_offers_badge_ar' => ['homepage_sections', 'offers', 'badge', 'ar'],
            'hcs_offers_badge_en' => ['homepage_sections', 'offers', 'badge', 'en'],
            'hcs_offers_title_ar' => ['homepage_sections', 'offers', 'title', 'ar'],
            'hcs_offers_title_en' => ['homepage_sections', 'offers', 'title', 'en'],
            'hcs_offers_button_text_ar' => ['homepage_sections', 'offers', 'button_text', 'ar'],
            'hcs_offers_button_text_en' => ['homepage_sections', 'offers', 'button_text', 'en'],
            'hcs_highlighted_cars_badge_ar' => ['homepage_sections', 'highlighted_cars', 'badge', 'ar'],
            'hcs_highlighted_cars_badge_en' => ['homepage_sections', 'highlighted_cars', 'badge', 'en'],
            'hcs_highlighted_cars_title_ar' => ['homepage_sections', 'highlighted_cars', 'title', 'ar'],
            'hcs_highlighted_cars_title_en' => ['homepage_sections', 'highlighted_cars', 'title', 'en'],
            'hcs_highlighted_cars_subtitle_ar' => ['homepage_sections', 'highlighted_cars', 'subtitle', 'ar'],
            'hcs_highlighted_cars_subtitle_en' => ['homepage_sections', 'highlighted_cars', 'subtitle', 'en'],
            'hcs_highlighted_cars_button_text_ar' => ['homepage_sections', 'highlighted_cars', 'button_text', 'ar'],
            'hcs_highlighted_cars_button_text_en' => ['homepage_sections', 'highlighted_cars', 'button_text', 'en'],
            'hcs_finance_badge_ar' => ['homepage_sections', 'finance', 'badge', 'ar'],
            'hcs_finance_badge_en' => ['homepage_sections', 'finance', 'badge', 'en'],
            'hcs_finance_title_ar' => ['homepage_sections', 'finance', 'title', 'ar'],
            'hcs_finance_title_en' => ['homepage_sections', 'finance', 'title', 'en'],
            'hcs_finance_subtitle_ar' => ['homepage_sections', 'finance', 'subtitle', 'ar'],
            'hcs_finance_subtitle_en' => ['homepage_sections', 'finance', 'subtitle', 'en'],
            'hcs_finance_features_ar' => ['homepage_sections', 'finance', 'features', 'ar'],
            'hcs_finance_features_en' => ['homepage_sections', 'finance', 'features', 'en'],
            'hcs_finance_button_text_ar' => ['homepage_sections', 'finance', 'button_text', 'ar'],
            'hcs_finance_button_text_en' => ['homepage_sections', 'finance', 'button_text', 'en'],
            'hcs_brands_title_ar' => ['homepage_sections', 'brands', 'title', 'ar'],
            'hcs_brands_title_en' => ['homepage_sections', 'brands', 'title', 'en'],
            'hcs_brands_subtitle_ar' => ['homepage_sections', 'brands', 'subtitle', 'ar'],
            'hcs_brands_subtitle_en' => ['homepage_sections', 'brands', 'subtitle', 'en'],
            'hcs_budget_badge_ar' => ['homepage_sections', 'budget', 'badge', 'ar'],
            'hcs_budget_badge_en' => ['homepage_sections', 'budget', 'badge', 'en'],
            'hcs_budget_title_ar' => ['homepage_sections', 'budget', 'title', 'ar'],
            'hcs_budget_title_en' => ['homepage_sections', 'budget', 'title', 'en'],
            'hcs_budget_description_ar' => ['homepage_sections', 'budget', 'description', 'ar'],
            'hcs_budget_description_en' => ['homepage_sections', 'budget', 'description', 'en'],
            'hcs_budget_button_text_ar' => ['homepage_sections', 'budget', 'button_text', 'ar'],
            'hcs_budget_button_text_en' => ['homepage_sections', 'budget', 'button_text', 'en'],
        ];

        if (! isset($map[$flatKey])) {
            return;
        }

        $parts = $map[$flatKey];
        $settingKey = $parts[0];
        $existing = $this->getSetting($settingKey, []);

        if (count($parts) === 4) {
            $existing[$parts[1]][$parts[2]][$parts[3]] = $value;
        } elseif (count($parts) === 3) {
            $existing[$parts[1]][$parts[2]] = $value;
        } else {
            $existing[$parts[1]] = $value;
        }

        Setting::updateOrCreate(
            ['key' => $settingKey],
            ['value' => $existing]
        );
    }

    private const BILINGUAL_KEYS = [
        'site_name', 'site_description', 'address',
        'meta_title', 'meta_description', 'maintenance_message',
        'hero_video_youtube',
    ];

    private const HERO_KEYS = [
        'booking_hero_title_ar', 'booking_hero_title_en',
        'booking_hero_subtitle_ar', 'booking_hero_subtitle_en',
        'booking_hero_image',
        'cars_hero_title_ar', 'cars_hero_title_en',
        'cars_hero_subtitle_ar', 'cars_hero_subtitle_en',
        'cars_hero_image',
        'offers_hero_title_ar', 'offers_hero_title_en',
        'offers_hero_subtitle_ar', 'offers_hero_subtitle_en',
        'offers_hero_image',
        'contact_hero_title_ar', 'contact_hero_title_en',
        'contact_hero_subtitle_ar', 'contact_hero_subtitle_en',
        'contact_hero_image',
        'blog_hero_title_ar', 'blog_hero_title_en',
        'blog_hero_subtitle_ar', 'blog_hero_subtitle_en',
        'blog_hero_image',
        'about_hero_badge_ar', 'about_hero_badge_en',
        'about_hero_title_ar', 'about_hero_title_en',
        'about_hero_subtitle_ar', 'about_hero_subtitle_en',
        'about_hero_image', 'about_hero_mobile_image',
        'about_hero_cta_text_ar', 'about_hero_cta_text_en', 'about_hero_cta_url',
        'about_story_title_ar', 'about_story_title_en',
        'about_story_description_ar', 'about_story_description_en',
        'about_story_mission_title_ar', 'about_story_mission_title_en',
        'about_story_mission_text_ar', 'about_story_mission_text_en',
        'about_story_vision_title_ar', 'about_story_vision_title_en',
        'about_story_vision_text_ar', 'about_story_vision_text_en',
        'about_story_image',
        'about_values_section_title_ar', 'about_values_section_title_en',
        'about_values_section_subtitle_ar', 'about_values_section_subtitle_en',
        'about_why_choose_us_section_title_ar', 'about_why_choose_us_section_title_en',
        'about_why_choose_us_section_subtitle_ar', 'about_why_choose_us_section_subtitle_en',
        // Homepage section copy (hcs_ prefix)
        'hcs_filter_title_ar', 'hcs_filter_title_en',
        'hcs_featured_cars_badge_ar', 'hcs_featured_cars_badge_en',
        'hcs_featured_cars_title_ar', 'hcs_featured_cars_title_en',
        'hcs_featured_cars_subtitle_ar', 'hcs_featured_cars_subtitle_en',
        'hcs_featured_cars_button_text_ar', 'hcs_featured_cars_button_text_en',
        'hcs_offers_badge_ar', 'hcs_offers_badge_en',
        'hcs_offers_title_ar', 'hcs_offers_title_en',
        'hcs_offers_button_text_ar', 'hcs_offers_button_text_en',
        'hcs_highlighted_cars_badge_ar', 'hcs_highlighted_cars_badge_en',
        'hcs_highlighted_cars_title_ar', 'hcs_highlighted_cars_title_en',
        'hcs_highlighted_cars_subtitle_ar', 'hcs_highlighted_cars_subtitle_en',
        'hcs_highlighted_cars_button_text_ar', 'hcs_highlighted_cars_button_text_en',
        'hcs_finance_badge_ar', 'hcs_finance_badge_en',
        'hcs_finance_title_ar', 'hcs_finance_title_en',
        'hcs_finance_subtitle_ar', 'hcs_finance_subtitle_en',
        'hcs_finance_features_ar', 'hcs_finance_features_en',
        'hcs_finance_button_text_ar', 'hcs_finance_button_text_en',
        'hcs_brands_title_ar', 'hcs_brands_title_en',
        'hcs_brands_subtitle_ar', 'hcs_brands_subtitle_en',
        'hcs_budget_badge_ar', 'hcs_budget_badge_en',
        'hcs_budget_title_ar', 'hcs_budget_title_en',
        'hcs_budget_description_ar', 'hcs_budget_description_en',
        'hcs_budget_button_text_ar', 'hcs_budget_button_text_en',
    ];

    private const ARRAY_KEYS = [
        'social_links', 'working_days', 'offer_hero_slides',
        'car_hero_slides', 'hero_slides', 'homepage_stats', 'booking_steps',
        'home_why_us', 'home_budget_brackets',
        'home_banner',
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

    /**
     * @param  array<string, array<string, array<string, string>>>  $sections
     * @return array<string, string>
     */
    private function flattenHomepageSections(array $sections): array
    {
        $flat = [];
        $groups = [
            'filter' => ['title'],
            'featured_cars' => ['badge', 'title', 'subtitle', 'button_text'],
            'offers' => ['badge', 'title', 'button_text'],
            'highlighted_cars' => ['badge', 'title', 'subtitle', 'button_text'],
            'finance' => ['badge', 'title', 'subtitle', 'features', 'button_text'],
            'brands' => ['title', 'subtitle'],
            'budget' => ['badge', 'title', 'description', 'button_text'],
        ];

        foreach ($groups as $group => $fields) {
            foreach ($fields as $field) {
                foreach (['ar', 'en'] as $locale) {
                    $flatKey = "hcs_{$group}_{$field}_{$locale}";
                    $flat[$flatKey] = $sections[$group][$field][$locale] ?? '';
                }
            }
        }

        return $flat;
    }
}
