<?php

namespace App\Providers\Filament;

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
use Filament\Http\Middleware\Authenticate;
use App\Http\Middleware\CheckRole;

class PetugasPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('petugas')
            ->path('petugas')
            ->brandName('YukPerpus')
            ->colors([
                'primary' => Color::Orange,
            ])
            ->discoverResources(in: app_path('Filament/Petugas/Resources'), for: 'App\Filament\Petugas\Resources')
            ->discoverResources(in: app_path('Filament/Petugas/Resources'), for: 'App\Filament\Petugas\Resources')
            ->discoverPages(in: app_path('Filament/Petugas/Pages'), for: 'App\\Filament\\Petugas\\Pages')
            ->pages([
                \App\Filament\Petugas\Pages\PetugasDashboard::class,
                \App\Filament\Pages\Rakbuku::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Petugas/Widgets'), for: 'App\\Filament\\Petugas\\Widgets')
            ->widgets([
                
            ])
            ->navigationItems([
                \Filament\Navigation\NavigationItem::make('Settings')
                    ->url('/petugas/settings')
                    ->icon('heroicon-o-cog')
                    ->group('Settings')
                    ->sort(3),
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
            ])
            ->authMiddleware([
                Authenticate::class,
                CheckRole::class.':petugas',
            ]);
    }
} 