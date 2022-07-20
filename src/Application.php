<?php

namespace Codohq\Codo;

use Codohq\Codo\{ Adapters, Contracts };

class Application
{
  /**
   * Holds the singleton instance.
   * 
   * @var \Codohq\Codo\Application
   */
  protected static ?Application $instance = null;

  /**
   * Instantiate a new Codo application object.
   * 
   * @param  string  $entrypoint
   * @param  string  $path
   * @return void
   */
  public function __construct(protected string $entrypoint, protected string $path)
  {
    if (! is_null(static::$instance)) {
      return;
    }

    if (isset($_SERVER['HTTP_CF_CONNECTING_IP'])) {
      $_SERVER['REMOTE_ADDR'] = $_SERVER['HTTP_CF_CONNECTING_IP'];
    }

    static::$instance = $this;
  }

  /**
   * Retrieve the singleton instance.
   * 
   * @return \Codohq\Codo\Application
   */
  public static function getInstance(): self
  {
    if (! (static::$instance instanceof self)) {
      throw new RuntimeException('Codo must be instantiated in an entrypoint first.');
    }

    return static::$instance;
  }

  /**
   * Retrieve the path to the entrypoint.
   * 
   * @return string
   */
  public function entrypoint(): string
  {
    return $this->entrypoint;
  }

  /**
   * Retrieve the path to the codohq/codo package.
   * 
   * @return string
   */
  public function path(): string
  {
    return $this->path;
  }

  /**
   * Bootstrap the Laravel application.
   * 
   * @return \Codohq\Codo\Contracts\Adapter
   */
  public function laravel(): Contracts\Adapter
  {
    return new Adapters\Laravel\LaravelAdapter($this);
  }
}
