<?php

namespace FredoAntonio\License;

use FredoAntonio\License\Http\Middleware\CheckTokenMiddleware;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Config;
class LicenseServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Publicar arquivo de configuração
     /*    $this->publishes([
            __DIR__ . '/../config/tokendata.php' => __DIR__ . '/../../config/tokendata.php',
        ], 'config'); */
        
        $this->publishes([
            __DIR__ . '/../config/tokendata.php' => config::path('tokendata.php'),
        ], 'config');

        // Publicar o middleware
        $this->publishes([
            __DIR__ . '/../Http/Middleware/CheckTokenMiddleware.php' => App::path('Http/Middleware/CheckTokenMiddleware.php'),
        ], 'middleware');

        // Publicar o middleware
      /*   $this->publishes([
            __DIR__ . '/Http/Middleware/CheckTokenLicense.php' => __DIR__ . 'app/Http/Middleware/CheckTokenLicense.php',
        ], 'middleware'); */

        // Registra o middleware
        $this->app->make('Illuminate\Contracts\Http\Kernel')->pushMiddleware(CheckTokenMiddleware::class);


        $this->publishes([
            __DIR__.'/Models' => App::path('Models'),
        ], 'models');
       /*  $this->publishes([
            __DIR__.'/Models' => __DIR__ .'app/Models',
        ], 'models'); */
    }

    public function register()
    {
        // Registro de qualquer serviço adicional
    }
}
