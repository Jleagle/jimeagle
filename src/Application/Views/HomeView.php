<?php
namespace Jleagle\Homepage\Application\Views;

use Cubex\View\TemplatedViewModel;
use Packaged\Dispatch\AssetManager;

class HomeView extends TemplatedViewModel
{
  public function __construct()
  {
  }

  /**
   * @return AssetManager
   */
  public function getAssetManager()
  {
    return $am = AssetManager::aliasType('src');
  }
}
