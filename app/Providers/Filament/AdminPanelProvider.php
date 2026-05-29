<?php

namespace App\Providers\Filament;

use App\Filament\Widgets\ChatVolumeWidget;
use App\Filament\Widgets\OrderStatusWidget;
use App\Filament\Widgets\PendingTestimonialsWidget;
use App\Filament\Widgets\UnpaidCommissionsWidget;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\View\PanelsRenderHook;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\Facades\Blade;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->profile(isSimple: false)
            ->brandName('Rielcode Studio')
            ->brandLogo(asset('IMG/Rielcode Logo Square Transparent.svg'))
            ->brandLogoHeight('2rem')
            ->favicon(asset('IMG/Rielcode Logo Square Transparent Icon.png'))
            ->darkMode(false)
            ->spa()
            ->theme(asset('css/filament/admin/theme.css'))
            ->renderHook(
                PanelsRenderHook::BODY_END,
                fn () => view('filament.admin.skeleton-loader')
            )
            ->renderHook(
                PanelsRenderHook::TOPBAR_START,
                fn () => Blade::render('<button id="rc-admin-back" onclick="rcAdminBack()" style="display:inline-flex;align-items:center;gap:0.35rem;font-size:0.8rem;color:var(--gray-400);background:none;border:none;cursor:pointer;padding:0 0.75rem;white-space:nowrap;" onmouseover="this.style.color=\'var(--gray-200)\'" onmouseout="this.style.color=\'var(--gray-400)\'"><svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>Back</button><script>window._rcNavStack=window._rcNavStack||[location.href];document.addEventListener("livewire:navigated",function(){var c=location.href,s=window._rcNavStack;if(s[s.length-1]!==c)s.push(c);});function rcAdminBack(){var s=window._rcNavStack;if(s.length>1){s.pop();window.location.href=s[s.length-1];}else{window.location.href="/admin";}}</script>')
            )
            ->colors([
                'primary' => Color::hex('#2d4a3a'),
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
                OrderStatusWidget::class,
                ChatVolumeWidget::class,
                PendingTestimonialsWidget::class,
                UnpaidCommissionsWidget::class,
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
            ]);
    }
}
