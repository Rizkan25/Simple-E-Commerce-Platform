<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use App\Filament\Pages\StitchDashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets\AccountWidget;
use Filament\Widgets\FilamentInfoWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\PreventRequestForgery;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Filament\View\PanelsRenderHook;
use Illuminate\Support\HtmlString;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->spa()
            ->viteTheme('resources/css/filament/admin/theme.css')
            ->login()
            ->colors([
                'primary' => Color::Amber,
                'gray' => [
                    50 => '#f0f3f8',
                    100 => '#dce4f0',
                    200 => '#bacae2',
                    300 => '#8ba9cf',
                    400 => '#5983b8',
                    500 => '#3a6496',
                    600 => '#2b4d77',
                    700 => '#213c5e',
                    800 => '#14253d',
                    900 => '#091426',
                    950 => '#050a13',
                ],
            ])
            ->font('Inter', 'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap')
            ->navigationGroups([
                'Transaksi',
                'Katalog & Moderasi',
                'Manajemen Akun',
                'Layanan Pelanggan',
            ])
            ->brandLogo(fn () => view('filament.logo'))
            ->darkMode(true, true)
            ->renderHook(
                PanelsRenderHook::HEAD_START,
                fn (): string => new HtmlString('<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />')
            )
            ->renderHook(
                PanelsRenderHook::HEAD_END,
                fn (): string => new HtmlString('
                    <style>
                        /* Sembunyikan ikon secara default */
                        th.fi-ta-header-cell .fi-ta-header-cell-sort-btn svg {
                            opacity: 0;
                            transition: opacity 0.2s ease-in-out;
                        }
                        
                        /* Tampilkan ikon saat di-hover ATAU jika sedang aktif di-sort */
                        th.fi-ta-header-cell:hover .fi-ta-header-cell-sort-btn svg,
                        th.fi-ta-header-cell[aria-sort="ascending"] .fi-ta-header-cell-sort-btn svg,
                        th.fi-ta-header-cell[aria-sort="descending"] .fi-ta-header-cell-sort-btn svg,
                        th.fi-ta-header-cell.fi-ta-header-cell-sorted .fi-ta-header-cell-sort-btn svg {
                            opacity: 1 !important;
                        }
                    </style>
                ')
            )
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->pages([
                StitchDashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
            ->widgets([
                AccountWidget::class,
                FilamentInfoWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                PreventRequestForgery::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
