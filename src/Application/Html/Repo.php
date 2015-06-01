<?php
namespace Jleagle\Homepage\Application\Html;

use Jleagle\HtmlBuilder\Tags\A;
use Jleagle\HtmlBuilder\Tags\Div;
use Jleagle\HtmlBuilder\Tags\Headings\H4;
use Jleagle\HtmlBuilder\Tags\I;
use Jleagle\HtmlBuilder\Tags\P;

class Repo extends A
{
  private $_title;
  private $_desc;
  private $_small;

  public function __construct($title, $desc = null, $small = null)
  {
    $this->_title = $title;
    $this->_desc = $desc;
    $this->_small = $small;

    $this->addClass('list-group-item');
    $this->setAttribute('data-toggle', 'tooltip');
    $this->setTarget(A::TARGET_BLANK);
  }

  public function _getContentForRender()
  {
    $i = (new I())->addClass('mdi-file-folder');
    $left = (new Div($i))->addClass('row-action-primary');
    $right = (new Div())->addClass('row-content');

    if($this->_small)
    {
      $right->appendContent(
        new Div($this->_small, ['class' => 'least-content'])
      );
    }

    $right->appendContent(
      new H4($this->_title, ['class' => 'list-group-item-heading'])
    );

    if($this->_desc)
    {
      $right->appendContent(
        new P($this->_desc, ['class' => 'list-group-item-text'])
      );
    }

    return [$left, $right];
  }
}
