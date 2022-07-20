<?php

namespace Codohq\Codo\Adapters\Laravel;

use Codohq\Codo\Contracts\Adapter;
use Codohq\Codo\Application as Codo;
use Illuminate\Foundation\Application as Laravel;

class LaravelAdapter implements Adapter
{
  /**
   * Instantiate a new Laravel adapter object.
   * 
   * @param  \Codohq\Codo\Application  $codo
   * @return void
   */
  public function __construct(protected Codo $codo)
  {
    //
  }

  /**
   * Inject Laravel into Codo.
   * 
   * @param  array  $instances
   * @return mixed
   */
  public function handle(array $instances)
  {
    $app = new Laravel(
      $this->codo->entrypoint()
    );

    $this->normalizeCacheEnv($app, 'APP_SERVICES_CACHE', $app->getCachedServicesPath());
    $this->normalizeCacheEnv($app, 'APP_PACKAGES_CACHE', $app->getCachedPackagesPath());
    $this->normalizeCacheEnv($app, 'APP_CONFIG_CACHE', $app->getCachedConfigPath());
    $this->normalizeCacheEnv($app, 'APP_ROUTES_CACHE', $app->getCachedRoutesPath());
    $this->normalizeCacheEnv($app, 'APP_EVENTS_CACHE', $app->getCachedEventsPath());

    $app->useLangPath($app->basePath('locale'));

    foreach ($instances as $contract => $instance) {
      $app->singleton($contract, $instance);
    }

    $app->register(LaravelServiceProvider::class);

    return $app;
  }

  /**
   * Normalize the given cache environment variable.
   * 
   * @param  \Illuminate\Foundation\Application  $app
   * @param  string  $env
   * @param  string  $default
   * @return void
   */
  protected function normalizeCacheEnv(Laravel $app, string $env, string $default): void
  {
    if (isset($_ENV[$env])) {
      return;
    }

    $_ENV[$env] = str_ireplace($app->basePath(), $app->storagePath(), $default);
  }
}
