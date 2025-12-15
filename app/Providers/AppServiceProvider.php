<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
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
        // Registrar las rutas de la API
        Route::prefix('api') // Definimos el prefijo de las rutas (api)
            ->middleware('api') // Usamos el middleware 'api' para estas rutas
            ->group(base_path('routes/api.php')); // Apunta a las rutas en routes/api.php

        // También puedes dejar esto si deseas cargar rutas web (si las tienes)
        // Route::middleware('web')->group(base_path('routes/web.php'));
    }
}
