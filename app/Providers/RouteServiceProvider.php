<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    protected $namespace = 'App\Http\Controllers';
    protected $bashkaruu = 'App\Http\Controllers\Bashkaruu';

    public function boot()
    {
        parent::boot();
    }
    public function map()
    {
        $this->mapApiRoutes();
        $this->mapWebRoutes();
        $this->mapBashkaruuRoutes();
    }
    protected function mapWebRoutes()
    {
        Route::middleware('web')
             ->namespace($this->namespace)
             ->group(base_path('routes/web.php'));
    }
    protected function mapBashkaruuRoutes()
    {
        Route::middleware('bashkaruu')
             ->namespace($this->bashkaruu)
             ->group(base_path('routes/bashkaruu.php'));
    }
    protected function mapApiRoutes()
    {
        Route::prefix('api')
             ->middleware('api')
             ->namespace($this->namespace)
             ->group(base_path('routes/api.php'));
    }
}