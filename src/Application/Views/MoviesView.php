<?php
namespace Jleagle\Homepage\Application\Views;

use Cubex\View\TemplatedViewModel;

class MoviesView extends TemplatedViewModel
{
  protected $_array;

  public function __construct(array $array)
  {
    $this->_array = $array;
  }

  /**
   * @return array
   */
  public function getArray()
  {
    return $this->_array;
  }
}
