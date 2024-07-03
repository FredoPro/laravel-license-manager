<?php

namespace FredoAntonio\License;

use FredoAntonio\License\Http\Middleware\CheckTokenMiddleware;
use Illuminate\Support\ServiceProvider;

class LicenseServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Publicar arquivo de configuração
        $this->publishes([
            __DIR__ . '/../config/tokendata.php' => $this->app->basePath('config/tokendata.php'),
        ], 'config');

        // Publicar o middleware
        $this->publishes([
            __DIR__ . '/../Http/Middleware/CheckTokenMiddleware.php' => $this->app->basePath('app/Http/Middleware/CheckTokenMiddleware.php'),
        ], 'middleware');

        // Registra o middleware
        $this->app->make('Illuminate\Contracts\Http\Kernel')->pushMiddleware(CheckTokenMiddleware::class);

        // Publicar os modelos
        $this->publishes([
            __DIR__ . '/Models' => $this->app->basePath('app/Models'),
        ], 'models');
    }

    public function register()
    {
        // Registro de qualquer serviço adicional
    }
}
