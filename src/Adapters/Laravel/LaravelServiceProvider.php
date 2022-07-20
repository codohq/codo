<?php

namespace Codohq\Codo\Adapters\Laravel;

use Closure;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\AggregateServiceProvider;
use Illuminate\Foundation\Application as Laravel;

class LaravelServiceProvider extends AggregateServiceProvider
{
  /**
   * The provider class names.
   *
   * @var array
   */
  protected $providers = [
    Inertia\InertiaServiceProvider::class,
    Vanilla\VanillaServiceProvider::class,
  ];

  /**
   * Holds the fallback renderer.
   * 
   * @var \Closure
   */
  protected static ?Closure $fallbackRenderer = null;

  /**
   * Register the service provider.
   *
   * @return void
   */
  public function register()
  {
    $this->instances = [];

    foreach ($this->providers as $provider) {
      if (method_exists($provider, 'precondition') and ! call_user_func_array([$provider, 'precondition'], [$this->app])) {
        continue;
      }

      $this->instances[] = $this->app->register($provider);
    }
  }

  /**
   * Bootstrap any application services.
   *
   * @return void
   */
  public function boot()
  {
    $this->registerFallbackRoute($this->app);
  }

  /**
   * Register the fallback route.
   * 
   * @param  \Illuminate\Foundation\Application  $app
   * @return void
   */
  protected function registerFallbackRoute(Laravel $app): void
  {
    $renderer = static::$fallbackRenderer;

    $routes = $app->router->getRoutes()->getRoutes();
    
    if (empty($routes) and ! is_null($renderer)) {
      Route::fallback(fn () => $renderer($app));
    }
  }

  /**
   * Register a fallback route renderer.
   * 
   * @param  \Closure  $callback
   * @return void
   */
  public static function useFallbackRenderer(Closure $callback): void
  {
    if (! is_null(static::$fallbackRenderer)) {
      return;
    }

    static::$fallbackRenderer = $callback;
  }
}
