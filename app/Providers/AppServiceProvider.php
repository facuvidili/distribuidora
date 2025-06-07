<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Empresa;
use Illuminate\Support\Facades\View;
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


    public function boot()
    {
        $empresa = Empresa::first(); // Obtiene los datos de la empresa
        View::share('empresa', $empresa); // Comparte con todas las vistas
    }

}
