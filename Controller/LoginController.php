<?php

namespace Limitland\LdapBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Security\Core\SecurityContext;

class LoginController extends Controller
{
  /**
   * @Route("/login", name="login")
   * @Template("LimitlandLdapBundle:Login:login.html.twig")
   */
  public function loginAction()
  {
    $request = $this->getRequest();
    $session = $request->getSession();
    
    // get the login error if there is one
    if( $request->attributes->has(SecurityContext::AUTHENTICATION_ERROR) ) {
      $error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
    }
    else {
      $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
      $session->remove(SecurityContext::AUTHENTICATION_ERROR);
    }
    
    return array (
        // last username entered by the user
        'last_username' => $session->get(SecurityContext::LAST_USERNAME),
        'error' => $error
    );
  }
  
  /**
   * @Route("/", name="hello")
   * @Template("LimitlandLdapBundle:Login:dashboard.html.twig")
   */
  public function helloAction()
  {
      return array ();
  }
}
