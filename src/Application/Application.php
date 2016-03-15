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
        '//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css',
        '//maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css',
        '//fonts.googleapis.com/css?family=Montserrat:400,700',
        'css/css',
      ]
    );
  }

  public function getRoutes()
  {
    return [
      '' => new HomeController(),
    ];
  }
}
