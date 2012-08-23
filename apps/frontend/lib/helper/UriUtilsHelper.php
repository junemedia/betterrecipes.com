<?

/**
 * @deprecated use getRoute instead
 */
function getUrl($type, $params = array())
{
  return UrlToolkit::getUrl($type, $params);
}

/**
 * Get Url for given object
 * 
 * @param Object|String An object instance or a string representing the route name or object class name 
 * @param array  $params
 * @return string 
 */
function getRoute($type, $params = array())
{
  return UrlToolkit::getRoute($type, $params);
}

/**
 * Get the domain name
 * 
 * @return string the domain name
 */
function getDomain()
{
  return UrlToolkit::getDomain();
}

/**
 * Get the protocol
 * 
 * @return string http:// or https://
 */
function getProtocol()
{
  return UrlToolkit::getProtocol();
}

function getDomainUri()
{
  return UrlToolkit::getDomainUri();
}

function getSigninUri($referrer=null)
{
  return UrlToolkit::getSigninUri($referrer);
}

function getSignupUri($referrer=null)
{
  return UrlToolkit::getSignupUri($referrer);
}

function getSignoutUri($referrer=null)
{
  return UrlToolkit::getSignoutUri($referrer);
}

function getHomepageUri($referrer=null)
{
  return UrlToolkit::getHomepageUri($referrer);
}

function getDefaultAvatarSrc($avatar_no)
{
  return '/img/avatars/default_' . $avatar_no . '.jpg';
}

?>
