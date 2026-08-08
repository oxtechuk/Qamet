<?php

namespace App\Providers\Filament;

use App\Filament\Pages\Auth\Login;
use App\Filament\Pages\Dashboard;
use App\Http\Middleware\LocalizationMiddleware;
use App\Models\Setting;
use BezhanSalleh\LanguageSwitch\LanguageSwitch;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Assets\Css;
use Filament\Support\Colors\Color;
use Filament\Support\Facades\FilamentAsset;
use Filament\Widgets\AccountWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function boot(): void
    {
        FilamentAsset::register([
            Css::make('dashboard', resource_path('css/filament/dashboard.css')),
        ], package: 'app');

        LanguageSwitch::configureUsing(function (LanguageSwitch $switch) {
            $switch
                ->locales(['ar', 'en'])
                ->labels([
                    'ar' => 'العربية',
                    'en' => 'English',
                ]);
        });
    }

    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login(Login::class)
            ->authGuard('employee')
            ->authPasswordBroker('employees')
            ->colors([
                'primary' => Color::hex('#dfc674'),
                'gray' => Color::Zinc,
                'danger' => Color::Rose,
                'warning' => Color::Amber,
                'success' => Color::Emerald,
                'info' => Color::Cyan,
            ])
            ->font('Inter')
            ->brandName('Qemt Njet')
            ->favicon(function (): string {
                $favicon = Setting::where('key', 'site_favicon')->value('value');

                return $favicon ? asset('storage/'.$favicon) : asset('images/favicon.ico');
            })
            ->brandLogo(function (): \Illuminate\Contracts\Support\Htmlable {
                $logo = Setting::where('key', 'site_logo')->value('value');
                $logoUrl = $logo ? asset('storage/'.$logo) : asset('images/logo_without_bg_white.svg');

                return new \Illuminate\Support\HtmlString('
                    <img src="'.$logoUrl.'" 
                         alt="Qemt Njet" 
                         style="height: 48px; max-height: 75px; width: auto; filter: drop-shadow(0 4px 16px rgba(223, 198, 116, 0.35)); transition: all 0.3s;" 
                         class="hover:scale-105" />
                ');
            })
            ->brandLogoHeight('3.2rem')
            ->sidebarCollapsibleOnDesktop()
            ->sidebarWidth('16rem')
            ->navigationGroups([
                \Filament\Navigation\NavigationGroup::make('الطلبات')
                    ->icon('heroicon-o-shopping-cart'),
                \Filament\Navigation\NavigationGroup::make('العملاء')
                    ->icon('heroicon-o-users'),
                \Filament\Navigation\NavigationGroup::make('الكتالوج')
                    ->icon('heroicon-o-rectangle-stack'),
                \Filament\Navigation\NavigationGroup::make('الفريق')
                    ->icon('heroicon-o-user-group'),
                \Filament\Navigation\NavigationGroup::make('المحتوى')
                    ->icon('heroicon-o-document-text'),
                \Filament\Navigation\NavigationGroup::make('الإعدادات والتحليلات')
                    ->icon('heroicon-o-cog-6-tooth'),
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
            ->widgets([
                AccountWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                LocalizationMiddleware::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            ->renderHook('panels::head.end', function (): string {
                $dir = app()->isLocale('ar') ? 'rtl' : 'ltr';
                $cssUrl = asset('css/filament/dashboard.css');

                return "<script>document.documentElement.setAttribute('dir', '{$dir}')</script><link rel=\"stylesheet\" href=\"{$cssUrl}?v=".time().'">';
            });
    }
}
