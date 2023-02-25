<?php

namespace App\Providers;

use Filament\Facades\Filament;
use Illuminate\Support\ServiceProvider;
use Filament\Navigation\NavigationGroup;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Filament::serving(function () {
            Filament::registerNavigationGroups([
                NavigationGroup::make()
                    ->label('Configuración Global')
                    ->icon('heroicon-s-cog'),
                NavigationGroup::make()
                    ->label('Módulo de Secretaría')
                    ->icon('heroicon-s-pencil')

            ]);
        });
    }
}
