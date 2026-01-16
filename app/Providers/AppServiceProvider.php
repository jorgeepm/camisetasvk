<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View; // <--- IMPORTANTE
use App\Models\Category;             // <--- IMPORTANTE

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
        // Esto hace que la variable $globalCategories esté disponible en TODO el menú
        // Usamos try-catch por si aún no has migrado la base de datos y no existe la tabla
        try {
            View::share('globalCategories', Category::all());
        } catch (\Exception $e) {
            // No hacemos nada si falla (ej: durante la migración inicial)
        }
    }
}