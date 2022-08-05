<?php

namespace Codohq\Codo\Concerns;

use Illuminate\Contracts\Console\Kernel;

trait CreatesApplication
{
  /**
   * Creates the application.
   *
   * @return \Illuminate\Foundation\Application
   */
  public function createApplication()
  {
    $codo = new \Codohq\Codo\Application(
      path: \Composer\InstalledVersions::getInstallPath('codohq/codo'),
      // entrypoint: realpath(__DIR__.'/../'),
    );

    $app = $codo->laravel()->handle([
      \Illuminate\Contracts\Http\Kernel::class => \Illuminate\Foundation\Http\Kernel::class,
      \Illuminate\Contracts\Console\Kernel::class => \Illuminate\Foundation\Console\Kernel::class,
      \Illuminate\Contracts\Debug\ExceptionHandler::class => \Illuminate\Foundation\Exceptions\Handler::class,
    ]);

    $kernel = $app->make(Kernel::class);

    // if (! ($bootstrap = ($_ENV['ATOMIC_BOOTSTRAP_FILE'] ?? null))) {
    //   throw new RuntimeException('You must specify the location of the atomic boostrap file using the ATOMIC_BOOSTRAP_FILE environment variable.');
    // }

    // $app = require $bootstrap;

    // $app->make(Kernel::class)->bootstrap();
    
    // $reflector = new ReflectionClass(LaravelServiceProvider::class);

    // Atomic::setAppPath(app_path());
    // Atomic::setLaravelPath(dirname($reflector->getFileName(), 3));

    return $app;
  }
}
