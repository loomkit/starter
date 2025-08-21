<?php

namespace App\Providers\Filament;

use Filament\Panel;

class AppPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        $panel
            ->default(config('panels.default') === config('panels.app.id'))
            ->id(config('panels.app.id'))
            ->path(config('panels.app.path'))
            ->authGuard(config('panels.app.guard'))
            ->registration()
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->discoverClusters(in: app_path('Filament/Clusters'), for: 'App\\Filament\\Clusters');

        return parent::panel($panel);
    }
}
