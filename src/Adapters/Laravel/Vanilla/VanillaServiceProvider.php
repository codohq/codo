<?php

namespace Codohq\Codo\Adapters\Laravel\Vanilla;

use Illuminate\Support\ServiceProvider;
use Codohq\Codo\Adapters\Laravel\LaravelServiceProvider;

class VanillaServiceProvider extends ServiceProvider
{
  /**
   * Register the service provider.
   *
   * @return void
   */
  public function register()
  {
    LaravelServiceProvider::useFallbackRenderer(function ($app) {
      $app->view->addNamespace('codo', __DIR__);

      return view('codo::vanilla');
    });
  }

  /**
   * Bootstrap any application services.
   *
   * @return void
   */
  public function boot()
  {
    //
  }
}
