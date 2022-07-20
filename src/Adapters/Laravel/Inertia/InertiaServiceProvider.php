<?php

namespace Codohq\Codo\Adapters\Laravel\Inertia;

use Illuminate\Support\ServiceProvider;
use Inertia\Middleware as InertiaMiddleware;
use Codohq\Codo\Adapters\Laravel\LaravelServiceProvider;

class InertiaServiceProvider extends ServiceProvider
{
  /**
   * Only load the service provider when the precondition is truthy.
   * 
   * @param  \Illuminate\Foundation\Application  $app
   * @return boolean
   */
  public static function precondition($app): bool
  {
    return function_exists('inertia');
  }

  /**
   * Register any application services.
   *
   * @return void
   */
  public function register()
  {
    LaravelServiceProvider::useFallbackRenderer(function ($app) {
      $app->view->addNamespace('codo', __DIR__);

      inertia()->setRootView('codo::inertia');
      
      return inertia('Welcome', [
        'app' => config('app.name'),
      ]);
    });
  }

  /**
   * Bootstrap any application services.
   *
   * @return void
   */
  public function boot()
  {
    $this->app->router->aliasMiddleware('inertia', InertiaMiddleware::class);
    $this->app->router->pushMiddlewareToGroup('web', 'inertia');
  }
}
