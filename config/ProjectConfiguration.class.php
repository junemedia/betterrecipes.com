<?php

require_once 'symfony1.4/lib/autoload/sfCoreAutoload.class.php';
sfCoreAutoload::register();

/**
 *
 */
class ProjectConfiguration extends sfProjectConfiguration
{
  protected $serializer;
  protected $gigya;

  public function setup()
  {
    // override the plugins directory
    sfConfig::set('sf_plugins_dir', '/srv/lib/symfony1.4.plugins');
    //@mkdir('/dev/shm/symfony/betterrecipes', 0777, true);
    //$this->setCacheDir('/dev/shm/symfony/betterrecipes');

    $this->enablePlugins(array(
      'sfDoctrinePlugin', 'sfCKEditorPlugin'
    ));

    $this->dispatcher->connect('context.load_factories', array($this, 'listenToContextLoadFactories'));
    $this->dispatcher->connect('component.method_not_found', array($this, 'listenToMethodNotFoundEvent'));
    $this->dispatcher->connect('context.method_not_found', array($this, 'listenToMethodNotFoundEvent'));
    $this->dispatcher->connect('form.method_not_found', array($this, 'listenToMethodNotFoundEvent'));
  }

  /**
   * Listen to context.load_factories event.
   * Initialize the sfMemcacheCache.
   *
   * @param sfEvent $event The event object.
   * @return void
   */
  public function listenToContextLoadFactories(sfEvent $event)
  {
    $memcache = new sfMemcacheCache(sfConfig::get('app_memcache_config'));
    $this->memcache_keys = sfConfig::get('app_memcache_keys');
    $context = $event->getSubject();
    $context->set('memcache', $memcache);
    $context->set('memcache_keys', $this->memcache_keys);

    $omniture = new Omniture(sfConfig::get('app_omniture_defaults'), sfConfig::get('app_omniture_tracker'));
    $context->set('omniture', $omniture);
    // Set adtag header variables: adchild1id, default ''
    $context->set('adchild1id', '');
  }

  /**
   * Listen to *.method_not_fount events.
   * Returns the sfMemcacheCache, sfI18n, sfUser, components and forms:
   *
   *  $this->getMemcache()
   *  $this->getI18n()
   *  $this->getUser()
   *
   * @param sfEvent $event
   * @return bool If it returns the requested object.
   */
  public function listenToMethodNotFoundEvent(sfEvent $event)
  {
    $context = null;
    if (class_exists('sfContext', false) && sfContext::hasInstance()) {
      $context = sfContext::getInstance();
    }
    if ('getMemcache' == $event['method'] && $context) {
      $event->setReturnValue($context->get('memcache'));
      return true;
    } elseif ('getMemcacheKey' == $event['method']) {
      $val = call_user_func_array(array($this, 'getMemcacheKey'), $event['arguments']);
      $event->setReturnValue($val);
      return true;
    } elseif ('getI18n' == $event['method'] && $context) {
      $event->setReturnValue($context->getI18n());
      return true;
    } elseif ('getUser' == $event['method'] && $context) {
      $event->setReturnValue($context->getUser());
      return true;
    } elseif ('getOmniture' == $event['method'] && $context) {
      $event->setReturnValue($context->get('omniture'));
      return true;
    } elseif ('getSerializer' == $event['method']) {
      $event->setReturnValue($this->getSerializer());
      return true;
    } elseif ('getGigya' == $event['method']) {
      $event->setReturnValue($this->getGigya());
      return true;
    }
    return false;
  }

  /**
   * Creates a new instance or retrieves the current instance of Gigya
   *
   * @return Gigya
   */
  public function getGigya()
  {
    if (!$this->gigya) {
      $this->gigya = new Gigya(sfConfig::get('app_gigya_api_key'), sfConfig::get('app_gigya_secret_key'), sfConfig::get('app_gigya_partner_id'));
    }
    return $this->gigya;
  }

  /**
   * Retrieves a Serializer instance capable of encoding and decoding xml
   *
   * @see Symfony\Component\Serializer\Serializer
   * @see http://api.symfony.com/2.0/index.html?q=serializer
   * @return Symfony\Component\Serializer\Serializer
   */
  public function getSerializer()
  {
    if (!$this->serializer) {
      $this->serializer = new Serializer(array(), array('xml' => new XmlEncoder()));
    }
    return $this->serializer;
  }

  /**
   * Just a way to keep memcache keys consistent
   *
   * @param string $key
   * @param string $default
   * @return string
   */
  public function getMemcacheKey($key, array $params = array())
  {
    if (array_key_exists($key, $this->memcache_keys)) {
      return str_replace(array_keys($params), array_values($params), $this->memcache_keys[$key]);
    }
  }

  /**
   * Get the the name of the current environment
   *
   * @return string
   */
  public static function getEnv()
  {
    return self::isDevelopment() ? 'dev' : 'prod';
  }

  /**
   * Whether the server is debugging
   *
   * @return boolean
   */
  public static function isDebugging()
  {
    return isset($_SERVER['DEBUG']) && $_SERVER['DEBUG'];
  }

  /**
   * Whether the server is development
   *
   * @return boolean
   */
  public static function isDevelopment()
  {
    return strpos($_SERVER['HTTP_HOST'], 'resolute.com') === false ? false : true;
  }

}
