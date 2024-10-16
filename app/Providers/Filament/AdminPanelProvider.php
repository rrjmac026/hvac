<?php

namespace App\Providers\Filament;


// use app\Filament\Widgets\ClientWidget;


use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

use Saade\FilamentFullCalendar\FilamentFullCalendarPlugin;

use App\Filament\Pages\Calendar;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->plugins([
                FilamentFullCalendarPlugin::make()
                ->selectable()
                ->editable(),
                \Hasnayeen\Themes\ThemesPlugin::make(),
                \BezhanSalleh\FilamentShield\FilamentShieldPlugin::make()
                
            ])

            ->resources([
                config('filament-logger.activity_resource')
            ])
            
            ->sidebarFullyCollapsibleOnDesktop()
            ->brandName('Highland Vets')
            ->colors([
                'danger' => '#C62E2E',
                'gray' => '#6B7280', // Replace Color::Gray with hex code for gray
                'info' => '#77CDFF',
                'primary' => '#0D92F4',
                'success' => '#00FF9C',
                'warning' => '#F95454',
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
                \App\Filament\Pages\Calendar::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                // ClientWidget::class
                // Widgets\AccountWidget::class,
                // Widgets\FilamentInfoWidget::class,
                \App\Filament\Widgets\CalendarWidget::class,
            ])
            
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
                \Hasnayeen\Themes\Http\Middleware\SetTheme::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
