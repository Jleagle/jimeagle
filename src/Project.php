<?php
namespace Jleagle\Homepage;

use Cubex\Kernel\CubexKernel;
use Jleagle\Homepage\Application\Application;
use Symfony\Component\HttpFoundation\RedirectResponse;

class Project extends CubexKernel
{
  /**
   * @return Application
   */
  public function defaultAction()
  {
    $this->_checkDomain();

    return new Application();
  }

  /**
   * @return $this
   */
  private function _checkDomain()
  {
    $request = $this->_getRequest();

    if($request->port() == 80)
    {
      if($request->tld() != 'uk' || $request->subDomain() == 'www')
      {
        $url = 'http://' . $request->domain() . '.uk' . $request->path();
        return RedirectResponse::create($url)->send();
      }
    }
    return $this;
  }
}
