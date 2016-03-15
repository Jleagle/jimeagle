<?php
namespace Jleagle\Homepage\Application\Controllers;

use Cubex\View\LayoutController;
use Jleagle\Homepage\Application\Views\HomeView;

class HomeController extends LayoutController
{
  public function defaultAction()
  {
    return new HomeView();
  }
}
