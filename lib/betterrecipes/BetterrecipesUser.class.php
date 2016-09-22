<?php

/**
 * Betterrecipes User
 * 
 * @package betterrecipes
 * @subpackage User
 * @author Bastian Kuberek <bkuberek@resolute.com>
 */
class BetterrecipesUser extends sfBasicSecurityUser
{
//  const LAST_REQUEST_NAMESPACE = 'lastRequest';
//  const AUTH_NAMESPACE         = 'authenticated';
//  const CREDENTIAL_NAMESPACE   = 'credentials';
//  const ATTRIBUTE_NAMESPACE    = 'attributes';
//  const CULTURE_NAMESPACE      = 'culture';
  /**
   * @var User
   */
  protected $session_checked = false;

  /**
   * Set $name on the regSource namespace
   * 
   * regSource needs to be on its own namespace to avoid it being cleared by the session check
   * 
   * @param string $name
   * @param integer $value 
   */
  public function setRegSourceAttribute($name, $value)
  {
    $this->attributeHolder->set($name, $value, 'regSource');
  }

  /**
   * get $name from the regSource namespace
   * 
   * @param string $name
   * @param integer $default 
   */
  public function getRegSourceAttribute($name, $default = null)
  {
    return $this->attributeHolder->get($name, $default, 'regSource');
  }

  /**
   * remove the $name from regSource namespace
   * 
   * @param string $name
   * @param integer $default 
   */
  public function removeRegSourceAttribute($name = null, $default = null)
  {
    if ($name) {
      return $this->attributeHolder->remove($name, $default, 'regSource');
    } else {
      return $this->attributeHolder->removeNamespace('regSource');
    }
  }

  /**
   * Set the URL to redirect to
   * 
   * @param string $referrer 
   */
  public function setReferrer($referrer)
  {
    $this->attributeHolder->set('referrer', $referrer, 'application');
  }

  /**
   * Get the URL to redirect to
   * 
   * @param string $default 
   */
  public function getReferrer($default = null)
  {
    return $this->attributeHolder->get('referrer', $default, 'application');
  }

  /**
   * Remove the referrer
   * 
   * @param string $default 
   */
  public function removeReferrer($default = null)
  {
    return $this->attributeHolder->remove('referrer', $default, 'application');
  }

  /**
   * It removes and returns the attribute
   * 
   * @param string $attribute
   * @param mixed $default reurned if $attribute is not set
   * @param string $ns the namespace
   * @return mixed 
   */
  public function removeAttribute($attribute, $default = null, $ns = null)
  {
    return $this->attributeHolder->remove($attribute, $default, $ns);
  }

  /**
   *
   * @param type $name
   * @param type $value 
   */
  public function setSocial($name, $value)
  {
    $this->attributeHolder->set($name, $value, 'social');
  }

  /**
   *
   * @param type $name
   * @param type $default
   * @return type 
   */
  public function getSocial($name, $default = null)
  {
    return $this->attributeHolder->get($name, $default, 'social');
  }

  /**
   * 
   * @param type $name
   * @param type $default
   * @return type 
   */
  public function removeSocial($name = null, $default = null)
  {
    if ($name) {
      return $this->attributeHolder->remove($name, $default, 'social');
    } else {
      return $this->attributeHolder->removeNamespace('social');
    }
  }

  /**
   * signin
   * instantiates session object for valid $user (assumes all appropriate validation has been taken care of upfront and user is not null)
   */
  public function signin($user_data = null)
  {
    // If the lis cookie is not set we are not automatically starting the session so before signing in the user initiate the session.
    $sf_context = sfContext::getInstance();
    $options = $sf_context->getStorage()->getOptions();
    $options['is_signin'] = true;
    $sf_context->getStorage()->initialize($options);

if (sfConfig::get('sf_logging_enabled'))
{
                        sfContext::getInstance()->getLogger()->info("BEN was here".serialize($user_data));
}
    if (!$user_data) {
      throw new InvalidArgumentException('Invalid. User data cannot be null or empty.');
      return false;
    } else {
      if ($user_data['is_admin']) {
        $this->addCredential('Admin');
      }
      if ($user_data['is_super_admin']) {
        $this->addCredential('Super Admin');
      }
      $this->setUserData($user_data);
      $this->setAuthenticated(true);

if (sfConfig::get('sf_logging_enabled'))
{
sfContext::getInstance()->getLogger()->info("BEN was here".$this->isAuthenticated());
}
      return $this;
    }
  }

  /**
   * Signs User out and destroy sensitive session data
   * 
   * @return BetterrecipesUser 
   */
  public function signout()
  {
    $this->setAuthenticated(false);
    $this->clearCredentials();
    $this->getAttributeHolder()->removeNamespace(); // clear the default namespace only
    $this->getAttributeHolder()->clear();
    $this->removeAttribute('user_data');
    // Remove the cookie from browser after cleaning up the session data on the server
    sfContext::getInstance()->getResponse()->setCookie('sid', '', time() - 3600, '/', UrlToolkit::getDomain());
    return $this;
  }

  /**
   * Set the current User
   * 
   * @param User $user
   * @return BetterrecipesUser 
   */
  public function setUserData($user_data = null)
  {
    $this->setAttribute('user_data', $user_data);
    $this->setAttribute('id', $user_data['id']);
    return $this;
  }

  /**
   * Retrieves currently authenticated user
   * 
   * @return User
   */
  public function getUserData()
  {
    return $this->getAttribute('user_data', array());
  }

  /**
   * Overload User methods - will only work if User is signed in
   * Make sure to always check if User is authenticated before using this
   * 
   * @example 
   *     <code>
   *         if ($sf_user->isAuthenticated()) {
   *             echo "Welcome ".$sf_user->getName();
   *         }
   *     </code>
   *     
   * 
   * @see sfUser::__call()
   * @param string $method The method name
   * @param array $arguments The method arguments
   * @return mixed will return User::$method or the return value of sfUser::__call($method, $arguments)
   * @throws sfException If the call fails
   */

  /**
   * User have a FB account
   * 
   */
  public function hasFb()
  {
    $user_data = $this->getUserData();
    return !is_null($user_data['fb_id']) ? true : false;
  }

  /**
   * Is user eligible to be social (does he/she have fb id and choose fb share?)
   * 
   */
  public function isSocial()
  {
    $user_data = $this->getUserData();
    if (empty($user_data)) {
      return null;
    } else {
      return $user_data['fb_share'] && $this->hasFb() ? true : false;
    }
  }

  /**
   * Get Local User Avatar path
   * 
   */
  public function getLocalAvatarSrc()
  {
    $user_data = $this->getUserData();
    if (strpos($user_data['avatar'], 'default_') === false) {
      return '/uploads/avatars/' . $user_data['avatar'];
    } else {
      return '/img/avatars/' . $user_data['avatar'];
    }
  }

  /**
   * Get User Avatar Path
   * 
   */
  public function getAvatarSrc()
  {
    if ($this->attributeHolder->has('auth_token', 'regSource')) {
      $user_data = $this->getUserData();
      return 'http://graph.facebook.com/' . $user_data['fb_id'] . '/picture';
    } else {
      return $this->getLocalAvatarSrc();
    }
  }

  public function __call($method, $arguments = array())
  {
    if (($user_data = $this->getUserData())) {
      if (strpos($method, 'get') === 0) {
        $key = str_replace('get_', '', Utilities::fromCamelCase($method));
        return array_key_exists($key, $user_data) ? $user_data[$key] : parent::__call($method, $arguments);
      }
    }
    try {
      return parent::__call($method, $arguments);
    } catch (Exception $e) {
      throw $e;
    }
  }

}
