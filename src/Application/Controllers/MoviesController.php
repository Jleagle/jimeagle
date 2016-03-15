<?php
namespace Jleagle\Homepage\Application\Controllers;

use Cubex\View\LayoutController;
use Jleagle\Homepage\Application\Views\MoviesView;

class MoviesController extends LayoutController
{
  public function defaultAction()
  {
    $url = $this->getConfigItem('movies', 'json', '[]');

    $result = file_get_contents($url, false);

    $array = json_decode($result);

    if(!is_array($array))
    {
      die('Cant find movies');
    }

    return new MoviesView($array);
  }
}
