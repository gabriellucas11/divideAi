<?php

namespace App\Providers\Filament;

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

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->registration()
            ->colors([
                'primary' => Color::Amber,
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
                Widgets\FilamentInfoWidget::class,
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
            ])->brandLogo(asset('https://s3-alpha-sig.figma.com/img/4b0d/9306/d845793a66f73ea7e14dcce218872dec?Expires=1701043200&Signature=XVOS3KjQedQy9WYS4d3bkHSM9VRTHOn1VgYOjfQ5gA2Z6zbhpQs6F0M9PAmP2Yr1hH1t2YgcuCpbBCAbez906TF-R4bNNC0WaDrpQqmndIre0E-hDUbFplOOSDFJ~d~Q0nTC73oI6jmIRgAoCmPyE9s7aHdfGw18FeO7GKPvGIdUBi5kFrT2sIVogXRVgkuQ9H-CxGV5ghhS6qFmPtV~GT7ycjqK3BVmWy0oj97-nRUK5PC9fCMx0SsEs49urvR21SULHgQW8hiuk~pYnVzYaLwx-QANxQyv0NPpQAsjxWa1kPntTAXIRJEVQUbVSOVx7scvhw3JMD8lCutPHEn4hw__&Key-Pair-Id=APKAQ4GOSFWCVNEHN3O4'));;
    }
}
