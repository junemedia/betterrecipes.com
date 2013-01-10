<?php

/**
 * SessionStorage 
 *
 * @package    betterrecipes
 * @subpackage storage
 * @author     Bastian Kuberek <bkuberek@resolute.com>
 */
class SessionStorage extends sfSessionStorage
{

  /**
   * Detects domain name for the cookie
   * 
   * @see sfSessionStorage::initialize()
   * @param array $options 
   */
  public function initialize($options = array())
  {
    $options['session_cookie_domain'] = '.' . UrlToolkit::getDomain();
    $sf_context = sfContext::getInstance();
    // If the lis cookie is 0 or not set don't automatically initialize the session (only start the session for logged-in users).
    $lis = $sf_context->getRequest()->getCookie('lis', 0);
    if ($lis == 0) {
      $options['auto_start'] = false;
    }
    // If the request comes from signin method override auto_start settings from the previous line
    if (isset($options['is_signin'])) {
      $options['auto_start'] = true;
      unset($options['is_signin']);
    }
    parent::initialize($options);
  }

}