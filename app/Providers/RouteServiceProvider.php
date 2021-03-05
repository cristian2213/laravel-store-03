<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * This is used by Laravel authentication to redirect users after login.
     *
     * @var string
     */
    public const HOME = '/';


    //********************** START ************************
    /**
     * The controller namespace for the application.
     *
     * When present, controller route declarations will automatically be prefixed with this namespace.
     *
     * @var string|null
     */
    protected $namespace = 'App\\Http\\Controllers'; //* para que laravel lea los controladores


    //* Organizando la contrucion de las rutas como se hacia en versiones pasadas de laravel, es un más organizado 
    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureRateLimiting();
    }

    //* metodo que se llama internamente
    public function map()
    {
        $this->mapApiRoutes();
        $this->mapWebRoutes();
        // routes "admin panel"
        $this->mapPanelRoutes();
    }

    protected function mapApiRoutes() // registra las rutas API
    {
        Route::prefix('api')
            ->namespace($this->namespace) //* todos los controladores se van a resolver desde este espacio de nombre
            ->middleware('api')
            ->group(base_path('routes/api.php'));
    }

    protected function mapWebRoutes() // registra rutas Web
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/web.php'));
    }


    // "admin panel"
    protected function mapPanelRoutes()
    {
        Route::prefix('panel')
            ->middleware(['web', 'auth', 'is.admin', 'verified'])
            ->namespace("{$this->namespace}\Panel")
            ->group(base_path('routes/panel.php'));
    }

    //************************* END **************** */

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by(optional($request->user())->id ?: $request->ip());
        });
    }
}
