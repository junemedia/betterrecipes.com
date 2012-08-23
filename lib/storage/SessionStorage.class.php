<?php

/**
 * SessionStorage 
 *
 * @package    betterrecipes
 * @subpackage storage
 * @author     Bastian Kuberek <bkuberek@resolute.com>
 */
class SessionStorage extends sfSessionStorage {
  
  /**
   * Detects domain name for the cookie
   * 
   * @see sfSessionStorage::initialize()
   * @param array $options 
   */
  public function initialize($options = array()) {
    
    $options['session_cookie_domain'] = '.'.UrlToolkit::getDomain();
    
    parent::initialize($options);
  }
}