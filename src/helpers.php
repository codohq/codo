<?php

use Codohq\Codo\Application;

if (! function_exists('codo'))
{
  /**
   * Retrieve the Codo instance.
   * 
   * @return \Codehq\Code
   */
  function codo()
  {
    return Application::getInstance();
  }
}
