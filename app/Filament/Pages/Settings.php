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

        $homeHero = $this->getSetting('store_home_hero', []);
        $bookingHero = $this->getSetting('store_booking_hero', []);
        $carsHero = $this->getSetting('store_hero', []);
        $offersHero = $this->getSetting('store_offers_hero', []);
        $contactHero = $this->getSetting('store_contact_hero', []);
        $blogHero = $this->getSetting('store_blog_hero', []);
        $featured = $this->getSetting('homepage_featured', []);

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
            'hero_slides' => $this->getSetting('hero_slides', []),
            'homepage_stats' => $this->getSetting('homepage_stats', []),
            'home_hero_title_ar' => $homeHero['title']['ar'] ?? '',
            'home_hero_title_en' => $homeHero['title']['en'] ?? '',
            'home_hero_subtitle_ar' => $homeHero['subtitle']['ar'] ?? '',
            'home_hero_subtitle_en' => $homeHero['subtitle']['en'] ?? '',
            'home_hero_image' => $homeHero['image'] ?? null,
            'featured_title_ar' => $featured['title']['ar'] ?? '',
            'featured_title_en' => $featured['title']['en'] ?? '',
            'featured_description_ar' => $featured['description']['ar'] ?? '',
            'featured_description_en' => $featured['description']['en'] ?? '',
            'about_stats' => $this->getSetting('about_stats', []),
            'about_branches' => $this->getSetting('about_branches', []),
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
                            ]),
                        Tab::make(__('Pages'))
                            ->icon('heroicon-m-document-text')
                            ->schema([
                                Tabs::make('pages')
                                    ->tabs([
                                        Tab::make(__('Homepage'))
                                            ->icon('heroicon-m-home')
                                            ->schema([
                                                Section::make(__('Homepage Hero'))
                                                    ->schema([
                                                        Grid::make(2)
                                                            ->schema([
                                                                Forms\Components\TextInput::make('home_hero_title_ar')
                                                                    ->label(__('Title').' ('.__('Arabic').')'),
                                                                Forms\Components\TextInput::make('home_hero_title_en')
                                                                    ->label(__('Title').' ('.__('English').')'),
                                                            ]),
                                                        Grid::make(2)
                                                            ->schema([
                                                                Forms\Components\Textarea::make('home_hero_subtitle_ar')
                                                                    ->label(__('Subtitle').' ('.__('Arabic').')'),
                                                                Forms\Components\Textarea::make('home_hero_subtitle_en')
                                                                    ->label(__('Subtitle').' ('.__('English').')'),
                                                            ]),
                                                        Forms\Components\FileUpload::make('home_hero_image')
                                                            ->label(__('Hero Image'))
                                                            ->image()
                                                            ->directory('heroes/home')
                                                            ->visibility('public'),
                                                    ]),
                                                Section::make(__('Hero Slides'))
                                                    ->description(__('Carousel banners displayed on homepage'))
                                                    ->schema([
                                                        Forms\Components\Repeater::make('hero_slides')
                                                            ->label(__('Slides'))
                                                            ->schema([
                                                                Grid::make(2)
                                                                    ->schema([
                                                                        Forms\Components\FileUpload::make('image')
                                                                            ->label(__('Image'))
                                                                            ->image()
                                                                            ->directory('slides/home')
                                                                            ->visibility('public')
                                                                            ->required(),
                                                                        Forms\Components\TextInput::make('link')
                                                                            ->label(__('Link URL'))
                                                                            ->url(),
                                                                    ]),
                                                                Forms\Components\TextInput::make('button_text')
                                                                    ->label(__('Button Text')),
                                                            ])
                                                            ->addActionLabel(__('Add Slide'))
                                                            ->collapsible(),
                                                    ]),
                                                Section::make(__('Stats'))
                                                    ->description(__('Statistics counters displayed on homepage'))
                                                    ->schema([
                                                        Forms\Components\Repeater::make('homepage_stats')
                                                            ->label(__('Stats'))
                                                            ->schema([
                                                                Grid::make(2)
                                                                    ->schema([
                                                                        Forms\Components\TextInput::make('value')
                                                                            ->label(__('Value'))
                                                                            ->required(),
                                                                        Forms\Components\TextInput::make('label_ar')
                                                                            ->label(__('Label').' ('.__('Arabic').')')
                                                                            ->required(),
                                                                    ]),
                                                                Forms\Components\TextInput::make('label_en')
                                                                    ->label(__('Label').' ('.__('English').')')
                                                                    ->required(),
                                                            ])
                                                            ->addActionLabel(__('Add Stat'))
                                                            ->collapsible(),
                                                    ]),
                                                Section::make(__('Featured Section'))
                                                    ->schema([
                                                        Grid::make(2)
                                                            ->schema([
                                                                Forms\Components\TextInput::make('featured_title_ar')
                                                                    ->label(__('Title').' ('.__('Arabic').')'),
                                                                Forms\Components\TextInput::make('featured_title_en')
                                                                    ->label(__('Title').' ('.__('English').')'),
                                                            ]),
                                                        Grid::make(2)
                                                            ->schema([
                                                                Forms\Components\Textarea::make('featured_description_ar')
                                                                    ->label(__('Description').' ('.__('Arabic').')'),
                                                                Forms\Components\Textarea::make('featured_description_en')
                                                                    ->label(__('Description').' ('.__('English').')'),
                                                            ]),
                                                    ]),
                                            ]),
                                        Tab::make(__('About'))
                                            ->icon('heroicon-m-information-circle')
                                            ->schema([
                                                Section::make(__('About Stats'))
                                                    ->schema([
                                                        Forms\Components\Repeater::make('about_stats')
                                                            ->label(__('Stats'))
                                                            ->schema([
                                                                Grid::make(2)
                                                                    ->schema([
                                                                        Forms\Components\TextInput::make('value')
                                                                            ->label(__('Value'))
                                                                            ->required(),
                                                                        Forms\Components\TextInput::make('label_ar')
                                                                            ->label(__('Label').' ('.__('Arabic').')')
                                                                            ->required(),
                                                                    ]),
                                                                Forms\Components\TextInput::make('label_en')
                                                                    ->label(__('Label').' ('.__('English').')')
                                                                    ->required(),
                                                            ])
                                                            ->addActionLabel(__('Add Stat'))
                                                            ->collapsible(),
                                                    ]),
                                                Section::make(__('Branches'))
                                                    ->schema([
                                                        Forms\Components\Repeater::make('about_branches')
                                                            ->label(__('Branches'))
                                                            ->schema([
                                                                Grid::make(2)
                                                                    ->schema([
                                                                        Forms\Components\TextInput::make('city')
                                                                            ->label(__('City'))
                                                                            ->required(),
                                                                        Forms\Components\TextInput::make('name')
                                                                            ->label(__('Name'))
                                                                            ->required(),
                                                                    ]),
                                                                Forms\Components\TextInput::make('address')
                                                                    ->label(__('Address'))
                                                                    ->required(),
                                                                Grid::make(2)
                                                                    ->schema([
                                                                        Forms\Components\TextInput::make('phone')
                                                                            ->label(__('Phone'))
                                                                            ->tel(),
                                                                        Forms\Components\TextInput::make('working_hours')
                                                                            ->label(__('Working Hours')),
                                                                    ]),
                                                                Forms\Components\TextInput::make('map_link')
                                                                    ->label(__('Map Link'))
                                                                    ->url(),
                                                            ])
                                                            ->addActionLabel(__('Add Branch'))
                                                            ->collapsible(),
                                                    ]),
                                            ]),
                                        Tab::make(__('Booking'))
                                            ->icon('heroicon-m-calendar')
                                            ->schema([
                                                Section::make(__('Booking Hero'))
                                                    ->schema([
                                                        Grid::make(2)
                                                            ->schema([
                                                                Forms\Components\TextInput::make('booking_hero_title_ar')
                                                                    ->label(__('Title').' ('.__('Arabic').')'),
                                                                Forms\Components\TextInput::make('booking_hero_title_en')
                                                                    ->label(__('Title').' ('.__('English').')'),
                                                            ]),
                                                        Grid::make(2)
                                                            ->schema([
                                                                Forms\Components\Textarea::make('booking_hero_subtitle_ar')
                                                                    ->label(__('Subtitle').' ('.__('Arabic').')'),
                                                                Forms\Components\Textarea::make('booking_hero_subtitle_en')
                                                                    ->label(__('Subtitle').' ('.__('English').')'),
                                                            ]),
                                                        Forms\Components\FileUpload::make('booking_hero_image')
                                                            ->label(__('Hero Image'))
                                                            ->image()
                                                            ->directory('heroes/booking')
                                                            ->visibility('public'),
                                                    ]),
                                                Section::make(__('Booking Steps'))
                                                    ->schema([
                                                        Forms\Components\Repeater::make('booking_steps')
                                                            ->label(__('Steps'))
                                                            ->schema([
                                                                Grid::make(2)
                                                                    ->schema([
                                                                        Forms\Components\TextInput::make('icon')
                                                                            ->label(__('Icon'))
                                                                            ->placeholder('heroicon-m-calendar'),
                                                                        Forms\Components\TextInput::make('title_ar')
                                                                            ->label(__('Title').' ('.__('Arabic').')')
                                                                            ->required(),
                                                                    ]),
                                                                Grid::make(2)
                                                                    ->schema([
                                                                        Forms\Components\TextInput::make('title_en')
                                                                            ->label(__('Title').' ('.__('English').')')
                                                                            ->required(),
                                                                        Forms\Components\Textarea::make('description_ar')
                                                                            ->label(__('Description').' ('.__('Arabic').')'),
                                                                    ]),
                                                                Forms\Components\Textarea::make('description_en')
                                                                    ->label(__('Description').' ('.__('English').')'),
                                                            ])
                                                            ->addActionLabel(__('Add Step'))
                                                            ->collapsible(),
                                                    ]),
                                            ]),
                                        Tab::make(__('Cars'))
                                            ->icon('heroicon-m-truck')
                                            ->schema([
                                                Section::make(__('Cars Page Hero'))
                                                    ->schema([
                                                        Grid::make(2)
                                                            ->schema([
                                                                Forms\Components\TextInput::make('cars_hero_title_ar')
                                                                    ->label(__('Title').' ('.__('Arabic').')'),
                                                                Forms\Components\TextInput::make('cars_hero_title_en')
                                                                    ->label(__('Title').' ('.__('English').')'),
                                                            ]),
                                                        Grid::make(2)
                                                            ->schema([
                                                                Forms\Components\Textarea::make('cars_hero_subtitle_ar')
                                                                    ->label(__('Subtitle').' ('.__('Arabic').')'),
                                                                Forms\Components\Textarea::make('cars_hero_subtitle_en')
                                                                    ->label(__('Subtitle').' ('.__('English').')'),
                                                            ]),
                                                        Forms\Components\FileUpload::make('cars_hero_image')
                                                            ->label(__('Hero Image'))
                                                            ->image()
                                                            ->directory('heroes/cars')
                                                            ->visibility('public'),
                                                    ]),
                                                Section::make(__('Hero Ads'))
                                                    ->schema([
                                                        Grid::make(2)
                                                            ->schema([
                                                                Section::make(__('Ad 1'))
                                                                    ->schema([
                                                                        Forms\Components\FileUpload::make('hero_ad_1_image')
                                                                            ->label(__('Image'))
                                                                            ->image()
                                                                            ->directory('ads')
                                                                            ->visibility('public'),
                                                                        Forms\Components\TextInput::make('hero_ad_1_link')
                                                                            ->label(__('Link URL'))
                                                                            ->url(),
                                                                    ]),
                                                                Section::make(__('Ad 2'))
                                                                    ->schema([
                                                                        Forms\Components\FileUpload::make('hero_ad_2_image')
                                                                            ->label(__('Image'))
                                                                            ->image()
                                                                            ->directory('ads')
                                                                            ->visibility('public'),
                                                                        Forms\Components\TextInput::make('hero_ad_2_link')
                                                                            ->label(__('Link URL'))
                                                                            ->url(),
                                                                    ]),
                                                            ]),
                                                    ]),
                                            ]),
                                        Tab::make(__('Offers'))
                                            ->icon('heroicon-m-megaphone')
                                            ->schema([
                                                Section::make(__('Offers Page Hero'))
                                                    ->schema([
                                                        Grid::make(2)
                                                            ->schema([
                                                                Forms\Components\TextInput::make('offers_hero_title_ar')
                                                                    ->label(__('Title').' ('.__('Arabic').')'),
                                                                Forms\Components\TextInput::make('offers_hero_title_en')
                                                                    ->label(__('Title').' ('.__('English').')'),
                                                            ]),
                                                        Grid::make(2)
                                                            ->schema([
                                                                Forms\Components\Textarea::make('offers_hero_subtitle_ar')
                                                                    ->label(__('Subtitle').' ('.__('Arabic').')'),
                                                                Forms\Components\Textarea::make('offers_hero_subtitle_en')
                                                                    ->label(__('Subtitle').' ('.__('English').')'),
                                                            ]),
                                                        Forms\Components\FileUpload::make('offers_hero_image')
                                                            ->label(__('Hero Image'))
                                                            ->image()
                                                            ->directory('heroes/offers')
                                                            ->visibility('public'),
                                                    ]),
                                            ]),
                                        Tab::make(__('Contact'))
                                            ->icon('heroicon-m-phone')
                                            ->schema([
                                                Section::make(__('Contact Page Hero'))
                                                    ->schema([
                                                        Grid::make(2)
                                                            ->schema([
                                                                Forms\Components\TextInput::make('contact_hero_title_ar')
                                                                    ->label(__('Title').' ('.__('Arabic').')'),
                                                                Forms\Components\TextInput::make('contact_hero_title_en')
                                                                    ->label(__('Title').' ('.__('English').')'),
                                                            ]),
                                                        Grid::make(2)
                                                            ->schema([
                                                                Forms\Components\Textarea::make('contact_hero_subtitle_ar')
                                                                    ->label(__('Subtitle').' ('.__('Arabic').')'),
                                                                Forms\Components\Textarea::make('contact_hero_subtitle_en')
                                                                    ->label(__('Subtitle').' ('.__('English').')'),
                                                            ]),
                                                        Forms\Components\FileUpload::make('contact_hero_image')
                                                            ->label(__('Hero Image'))
                                                            ->image()
                                                            ->directory('heroes/contact')
                                                            ->visibility('public'),
                                                    ]),
                                            ]),
                                        Tab::make(__('Blog'))
                                            ->icon('heroicon-m-pencil-square')
                                            ->schema([
                                                Section::make(__('Blog Page Hero'))
                                                    ->schema([
                                                        Grid::make(2)
                                                            ->schema([
                                                                Forms\Components\TextInput::make('blog_hero_title_ar')
                                                                    ->label(__('Title').' ('.__('Arabic').')'),
                                                                Forms\Components\TextInput::make('blog_hero_title_en')
                                                                    ->label(__('Title').' ('.__('English').')'),
                                                            ]),
                                                        Grid::make(2)
                                                            ->schema([
                                                                Forms\Components\Textarea::make('blog_hero_subtitle_ar')
                                                                    ->label(__('Subtitle').' ('.__('Arabic').')'),
                                                                Forms\Components\Textarea::make('blog_hero_subtitle_en')
                                                                    ->label(__('Subtitle').' ('.__('English').')'),
                                                            ]),
                                                        Forms\Components\FileUpload::make('blog_hero_image')
                                                            ->label(__('Hero Image'))
                                                            ->image()
                                                            ->directory('heroes/blog')
                                                            ->visibility('public'),
                                                    ]),
                                            ]),
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
                                            ->placeholder(__('e.g. G-XXXXXXXXXX'))
                                            ->helperText(__('Format: G-XXXXXXXXXX')),
                                        Forms\Components\TextInput::make('facebook_pixel_id')
                                            ->label(__('Facebook Pixel ID'))
                                            ->helperText(__('Numeric ID from Facebook Events Manager')),
                                    ]),
                                Section::make(__('Contact'))
                                    ->schema([
                                        Forms\Components\TextInput::make('whatsapp_number')
                                            ->label(__('WhatsApp Number'))
                                            ->tel()
                                            ->placeholder(__('e.g. +966501234567'))
                                            ->helperText(__('Used for WhatsApp confirmation messages')),
                                    ]),
                            ]),
                        Tab::make(__('Calculator'))
                            ->icon('heroicon-m-calculator')
                            ->schema([
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
                        Tab::make(__('Offers Slider'))
                            ->icon('heroicon-m-photo')
                            ->schema([
                                Section::make(__('Offer Hero Slides'))
                                    ->description(__('Image slider displayed at the top of the offers page.'))
                                    ->schema([
                                        Forms\Components\Repeater::make('offer_hero_slides')
                                            ->label(__('Slides'))
                                            ->schema([
                                                Grid::make(2)
                                                    ->schema([
                                                        Forms\Components\FileUpload::make('image')
                                                            ->label(__('Image'))
                                                            ->image()
                                                            ->directory('slides/offers')
                                                            ->visibility('public')
                                                            ->required(),
                                                        Forms\Components\TextInput::make('link')
                                                            ->label(__('Link URL'))
                                                            ->url(),
                                                    ]),
                                                Grid::make(2)
                                                    ->schema([
                                                        Forms\Components\TextInput::make('title_ar')
                                                            ->label(__('Title').' ('.__('Arabic').')'),
                                                        Forms\Components\TextInput::make('title_en')
                                                            ->label(__('Title').' ('.__('English').')'),
                                                    ]),
                                                Grid::make(2)
                                                    ->schema([
                                                        Forms\Components\TextInput::make('button_text_ar')
                                                            ->label(__('Button Text').' ('.__('Arabic').')'),
                                                        Forms\Components\TextInput::make('button_text_en')
                                                            ->label(__('Button Text').' ('.__('English').')'),
                                                    ]),
                                            ])
                                            ->addActionLabel(__('Add Slide'))
                                            ->collapsible(),
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
            'home_hero_title_ar' => ['store_home_hero', 'title', 'ar'],
            'home_hero_title_en' => ['store_home_hero', 'title', 'en'],
            'home_hero_subtitle_ar' => ['store_home_hero', 'subtitle', 'ar'],
            'home_hero_subtitle_en' => ['store_home_hero', 'subtitle', 'en'],
            'home_hero_image' => ['store_home_hero', 'image'],
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
            'featured_title_ar' => ['homepage_featured', 'title', 'ar'],
            'featured_title_en' => ['homepage_featured', 'title', 'en'],
            'featured_description_ar' => ['homepage_featured', 'description', 'ar'],
            'featured_description_en' => ['homepage_featured', 'description', 'en'],
        ];

        if (! isset($map[$flatKey])) {
            return;
        }

        $parts = $map[$flatKey];
        $settingKey = $parts[0];
        $existing = $this->getSetting($settingKey, []);

        if (count($parts) === 3) {
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
    ];

    private const HERO_KEYS = [
        'home_hero_title_ar', 'home_hero_title_en',
        'home_hero_subtitle_ar', 'home_hero_subtitle_en',
        'home_hero_image',
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
        'featured_title_ar', 'featured_title_en',
        'featured_description_ar', 'featured_description_en',
    ];

    private const ARRAY_KEYS = [
        'social_links', 'working_days', 'offer_hero_slides',
        'hero_slides', 'homepage_stats', 'about_stats',
        'about_branches', 'booking_steps',
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
