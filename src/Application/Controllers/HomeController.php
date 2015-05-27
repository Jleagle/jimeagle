<?php
namespace Jleagle\Homepage\Application\Controllers;

use anlutro\Form\Builder;
use anlutro\Form\DefaultForm;
use Cubex\View\LayoutController;
use google\appengine\api\mail\Message;
use Jleagle\Homepage\Application\Views\HomeView;
use Jleagle\Recaptcha\Exceptions\RecaptchaException;
use Jleagle\Recaptcha\Recaptcha;
use Respect\Validation\Validator;
use Symfony\Component\HttpFoundation\RedirectResponse;

class HomeController extends LayoutController
{
  /**
   * @param array  $post
   * @param string $error
   *
   * @return HomeView
   * @internal param string $errors
   */
  public function defaultAction($post = [], $error = null)
  {
    $repos = $this->_getRepos();

    $form = $this->_getForm();

    if($post)
    {
      $form->setModel($post);
    }

    $captcha = $this->_getRecaptcha();

    return new HomeView($repos, $form, $captcha, $error);
  }

  public function postDefaultAction()
  {
    $input = $this->_getForm()->getInput();

    // Validation
    try
    {
      $this->_getRecaptcha()->check($input['g-recaptcha-response']);
    }
    catch(RecaptchaException $e)
    {
      return $this->defaultAction($input, 'Please enter the captcha.');
    }

    if(!Validator::notEmpty()->validate($input['name']))
    {
      return $this->defaultAction($input, 'Please enter your name.');
    }

    if(!Validator::notEmpty()->validate($input['email']))
    {
      return $this->defaultAction($input, 'Please enter your email.');
    }

    if(!Validator::email()->validate($input['email']))
    {
      return $this->defaultAction($input, 'Please enter a valid email.');
    }

    if(!Validator::notEmpty()->validate($input['body']))
    {
      return $this->defaultAction($input, 'Please enter your message.');
    }

    // Email
    $message = new Message();
    $message->setSender("jimeagle@gmail.com");
    $message->addTo("jimeagle@gmail.com");
    $message->setSubject("Message from jimeagle.com");
    $message->setTextBody(print_r($input, true));
    $message->send();

    // Redirect
    return new RedirectResponse('/');
  }

  private function _getRepos()
  {
    $key = 'repos';
    $memcache = new \Memcache;
    $data = $memcache->get($key);
    if($data === false || !$data)
    {
      $context = [
        'http' => [
          'method' => 'GET',
          'header' => "User-Agent: Jimeagle.uk\r\n",
        ]
      ];
      $context = stream_context_create($context);
      $data = file_get_contents(
        'https://api.github.com/users/Jleagle/repos',
        false,
        $context
      );
      $data = json_decode($data);

      if(is_array($data) && !empty($data))
      {
        $memcache->set($key, $data, 500000);
      }
    }

    // Remove projects
    $projects = [
      'jimeagle.com',
      'brew-formulas.com',
      'php-packages.com',
      'buttons'
    ];
    foreach($data as $k => $repo)
    {
      if(in_array($repo->name, $projects))
      {
        unset($data[$k]);
      }
    }

    return array_values($data);
  }

  private function _getForm()
  {
    $builder = new Builder();
    $builder->setRequest($this->_getRequest());
    $builder->input('textarea', 'message', '');
    $form = new DefaultForm($builder);
    return $form;
  }

  private function _getRecaptcha()
  {
    return new Recaptcha(
      $this->getConfigItem('recapcha', 'site_key'),
      $this->getConfigItem('recapcha', 'secret_key'),
      $this->_getRequest()->getClientIp()
    );
  }
}
