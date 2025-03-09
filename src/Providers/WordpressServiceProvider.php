<?php

namespace Luinuxscl\WordpressIntegration\Providers;

use Illuminate\Support\ServiceProvider;
use Luinuxscl\WordpressIntegration\Services\WordpressService;

class WordpressServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../../config/wordpress.php', 'wordpress');

        // Registrar el servicio en el contenedor para la Facade
        $this->app->singleton('wordpress-integration', function () {
            return new WordpressService();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Cargar rutas
        $this->loadRoutesFrom(__DIR__ . '/../../routes/web.php');

        // Cargar migraciones
        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');

        // Cargar vistas con namespace 'wordpress'
        $this->loadViewsFrom(__DIR__ . '/../../resources/views/vendor/wordpress', 'wordpress');

        // Publicar archivos de configuración
        $this->publishes([
            __DIR__ . '/../../config/wordpress.php' => config_path('wordpress.php'),
        ], 'wordpress-config');

        // Publicar vistas para permitir modificaciones en la aplicación
        $this->publishes([
            __DIR__ . '/../../resources/views/vendor/wordpress' => resource_path('views/vendor/wordpress'),
        ], 'wordpress-views');
    }
}
