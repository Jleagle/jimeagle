<?php
namespace Jleagle\Homepage\Application\Views;

use anlutro\Form\DefaultForm;
use Cubex\View\TemplatedViewModel;
use Jleagle\Homepage\Application\Html\Repo;
use Jleagle\HtmlBuilder\Tags\Div;
use Jleagle\Recaptcha\Recaptcha;
use Packaged\Dispatch\AssetManager;

class HomeView extends TemplatedViewModel
{
  private $_repos;
  private $_form;
  private $_captcha;
  private $_error;

  /**
   * @param array       $repos
   * @param DefaultForm $form
   * @param Recaptcha   $captcha
   * @param array       $error
   */
  public function __construct($repos, $form, Recaptcha $captcha, $error)
  {
    $this->_repos = $repos;
    $this->_form = $form;
    $this->_captcha = $captcha;
    $this->_error = $error;
  }

  public function getRepos()
  {
    $return = [];
    foreach($this->_repos as $v)
    {
      $repo = new Repo($v->name);
      $repo->setLink($v->html_url);
      //$repo->setAttribute('title', $v->description);

      $group = new Div($repo);
      $group->addClass('list-group');

      $col = new Div($group);
      $return[] = $col->addClass('col-xs-12 col-sm-6 col-md-4');
    }
    $row = new Div($return);
    $row->addClass('row');
    return $row;
  }

  /**
   * @return DefaultForm
   */
  public function getForm()
  {
    return $this->_form;
  }

  /**
   * @return string
   */
  public function getError()
  {
    return $this->_error;
  }

  /**
   * @return Recaptcha
   */
  public function getCaptcha()
  {
    return $this->_captcha;
  }

  /**
   * @return AssetManager
   */
  public function getAssetManager()
  {
    return $am = AssetManager::aliasType('src');
  }
}
