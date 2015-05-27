<?php
namespace Jleagle\Homepage;

use Cubex\Kernel\CubexKernel;
use Jleagle\Homepage\Application\Application;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

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
    $domain = $this->_getRequest()->domain();
    $sub = $this->_getRequest()->subDomain();
    $tld = $this->_getRequest()->tld();
    $path = $this->_getRequest()->path();
    $port = $this->_getRequest()->port();

    if ($port == 80)
    {
      if($tld != 'uk' || $sub == 'www')
      {
        $url = 'http://' . $domain . '.uk' . $path;
        return RedirectResponse::create($url)->send();
      }
    }
    return $this;
  }

}
