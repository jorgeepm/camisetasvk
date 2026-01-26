<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;   // Para compartir variables
use Illuminate\Support\Facades\Schema; // Para verificar la base de datos
use App\Models\Category;               // Tu modelo de Categorías

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
        // Compartir la variable $globalCategories con TODAS las vistas (necesario para el menú)
        try {
            // Verificamos primero si la tabla existe para que no falle al ejecutar migraciones
            if (Schema::hasTable('categories')) {
                View::share('globalCategories', Category::all());
            }
        } catch (\Exception $e) {
            // Si la base de datos no está lista o falla la conexión, ignoramos el error
            // para que la web no se rompa completamente (simplemente no saldrá el menú desplegable)
        }
    }
}