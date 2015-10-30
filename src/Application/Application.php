<?php
namespace Jleagle\Homepage\Application;

use Cubex\Kernel\ApplicationKernel;
use Jleagle\Homepage\Application\Controllers\HomeController;
use Packaged\Dispatch\AssetManager;

class Application extends ApplicationKernel
{
  protected function _init()
  {
    $am = AssetManager::aliasType('src');

    $am->requireCss(
      [
        '//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css',
        'css/roboto.min',
        'css/material',
        'css/ripples.min',
        'css/main',
      ]
    );

    $am->requireJs(
      [
        '//ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js',
        '//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js',
        '//www.google.com/recaptcha/api.js',
        'js/ripples.min',
        'js/material.min',
        'js/main',
      ], 'defer'
    );
  }

  public function getRoutes()
  {
    return [
      '' => new HomeController(),
    ];
  }
}
