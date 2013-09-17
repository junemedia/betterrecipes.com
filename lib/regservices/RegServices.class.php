<?php

/**
 *
 * This Class provides Meredith Registration Services
 */
Class RegServices
{
  /** Settings/initial values  * */
  //  HTTP authentication userid
  private $auth_user;
  //  HTTP authentication password      
  private $auth_pass;
  // Client code for Agriculture    
  private $client_code;
  // Client code for Agriculture forgot password    
  private $client_code_fp = "1013";
  //  Turn on WSDL caching for production by making true (DO THIS!!)        
  private $use_cache = 1;
  // Update path to your local wsdl cache location (IE: /tmp)        
  private $cache_path = "/tmp";
  //  WSDL cache timeout - 86400 = 1 day     
  private $cache_timeout = 86400;
  //  Registration sources     
  private $registration_source = 8273;
  private $registration_source_sweeps = 2525;
  //private $url = '';
  //private $dev_url = 'test.secure.agriculture.com';
  // private $dev_url = 'dev.secure.agriculture.com';

  private $prod_url;
  private $base_url;
  private $protocol = "https";
  private $test_appendix = '';

  public function __construct()
  {
    ini_set("soap.wsdl_cache_enabled", $this->use_cache);
    ini_set("soap.wsdl_cache_dir", $this->cache_path);
    ini_set("soap.wsdl_cache_ttl", $this->cache_timeout);
    $this->auth_user = sfConfig::get('app_regservices_user');
    $this->auth_pass = sfConfig::get('app_regservices_pass');
    $this->client_code = sfConfig::get('app_regservices_clientcode');
    $this->prod_url = sfConfig::get('app_regservices_url');
    $url = $this->prod_url;
    $this->base_url = $this->protocol . "://" . $this->auth_user . ":" . urlencode($this->auth_pass) . "@" . $url . "/ws/profile/";
  }

  public function setClientCode($new_code)
  {
    $this->client_code = $new_code;
  }

  /* Register user  */

  public function register($user_info, $reg_source = null)
  {
    $connection = $this->getConnection(__FUNCTION__);
    $profile_id = false;
    $error = false;
    if ($reg_source == 'sweeps') {
      $registration_source = $this->registration_source_sweeps;
    } elseif (is_numeric($reg_source)) {
      // PDF download source id
      $registration_source = $reg_source;
    } else {
      $registration_source = $this->registration_source;
    }
    //build XML
    $profile_data = "<registration>";
    $profile_data .= "<login>" . $user_info['login_name'] . "</login>";
    $profile_data .= "<firstname>" . $user_info['first_name'] . "</firstname>";
    // $profile_data .= "<lastname>" . $user_info['last_name'] . "</lastname>";
    $profile_data .= "<displayname>" . $user_info['display_name'] . "</displayname>";
    $profile_data .= "<password>" . $user_info['password'] . "</password>";
    $profile_data .= "<registrationsource>" . $registration_source . "</registrationsource>";
    $profile_data .= "<optin>" . (@$user_info['optin'] ? 'true' : 'false') . "</optin>";
    $profile_data .= "<sendregistrationemails>" . $user_info['send_registration_emails'] . "</sendregistrationemails>";
    $profile_data .= "</registration>";
	//echo 'connection '.$connection;
    if ($connection != false) {
      $result = $connection->register($profile_data, $this->client_code);
      $xml = new SimpleXMLElement($result);
      $code = $this->simplexmlFindAttribute($xml, "code");
      $msg = $this->simplexmlFindAttribute($xml, "message");
      switch ($code) {
        case '0':
          $profile_id = strval($xml->profileid);
          break;
        case '100':
          $error = "You are already a member of Betterrecipes.com or one of our sister sites. Please login to the right using your email address and password.";
          break;
        case '101':
          $key = strval($xml->errors->key);
          switch ($key) {
            case 'loginRequired':
              $error = "The email name is already in use";
              break;
            case 'passwordRequired':
              $error = "Please enter a password";
              break;
            case 'alreadyExistingDisplayName':
              $error = "The display name is already in use";
              break;
            case 'loginTooLong':
              $error = "Please limit the email address to 50 characters";
              break;
            case 'firstNameTooLong':
              $error = 'The first name must be between 1 and 12 characters';
              break;
            case 'lastNameTooLong':
              $error = 'The last name you entered is too long';
              break;
            case 'invalidEmailAddressFormat':
            	$error = 'The login is not a valid email address format';
				break;
			case 'firstNameRequired':
				$error = 'The first name field is required, but no value given';
				break;
			case 'displayNameRequired':
				$error = 'The display name is required for the specified registration source, but no value given';
				break;
			case 'insufficientPassword':
				$error = 'The password does not meet minimum requirements';
				break;
            default:
              $error = "There was an error. Please check your information and try again";
              break;
          }
          break;
      }
    }
    return compact('profile_id', 'error', 'msg', 'code', 'key');
  }

  /* Get user profile */

  public function getProfile($profile_id)
  {
    $connection = $this->getConnection(__FUNCTION__);
    if ($connection != false) {
      $xml = simplexml_load_string($connection->{__FUNCTION__}($profile_id, $this->client_code));
      $code = $this->simplexmlFindAttribute($xml, "code");
      $msg = $this->simplexmlFindAttribute($xml, "message");
      if ($code == 0) {
        $profile = $xml->profile;
        $namespaces = $profile->getNameSpaces(true);
        $user = $profile->children($namespaces['user']);
        $u = $user->user;
        $user_profile = array();
        foreach ($u as $el => $c) {
          foreach ($c as $cc) {
            switch ($cc->getName()) {
              case 'user.id':
                $user_profile['id'] = strval($cc);
                break;
              case 'user.login':
                $user_profile['login'] = strval($cc);
                break;
              case 'user.firstName':
                $user_profile['first_name'] = strval($cc);
                break;
              case 'user.lastName':
                $user_profile['last_name'] = strval($cc);
                break;
              case 'user.userDisplayName':
                $user_profile['display_name'] = strval($cc);
                break;
              case 'user.homeAddress':
                $contact_info = array();
                $has_ci = false;
                foreach ($cc as $ci) {
                  foreach ($ci as $ci_item) {
                    switch ($ci_item->getName()) {
                      case 'contactInfo.address1':
                        $val = strval($ci_item);
                        if (!is_null($val) && $val != '') {
                          $has_ci = true;
                        }
                        $contact_info['address1'] = $val;
                        break;
                      case 'contactInfo.address2':
                        $val = strval($ci_item);
                        if (!is_null($val) && $val != '') {
                          $has_ci = true;
                        }
                        $contact_info['address2'] = $val;
                        break;
                      case 'contactInfo.city':
                        $val = strval($ci_item);
                        if (!is_null($val) && $val != '') {
                          $has_ci = true;
                        }
                        $contact_info['city'] = $val;
                        break;
                      case 'contactInfo.state':
                        $val = strval($ci_item);
                        if (!is_null($val) && $val != '') {
                          $has_ci = true;
                        }
                        $contact_info['state'] = $val;
                        break;
                      case 'contactInfo.postalCode':
                        $val = strval($ci_item);
                        if (!is_null($val) && $val != '') {
                          $has_ci = true;
                        }
                        $contact_info['zipcode'] = $val;
                        break;
                      case 'contactInfo.country':
                        $val = strval($ci_item);
                        if (!is_null($val) && $val != '') {
                          $has_ci = true;
                        }
                        $contact_info['country'] = $val;
                        break;
                    }
                  }
                }
                // If all the contact fields are empty unset the contact_info array
                if ($has_ci) {
                  $user_profile['contact_info'] = $contact_info;
                }
                break;
            }
          }
        }
      }
      return compact('code', 'msg', 'user_profile');
    } else {
      return false;
    }
  }

  /* Authenticate user */

  public function authenticate($login, $password)
  {
    $connection = $this->getConnection(__FUNCTION__);
    if ($connection != false) {
      $result = $connection->{__FUNCTION__}($login, $password, $this->client_code);
      return $this->getResult($result);
    } else {
      return false;
    }
  }

  /* Is user registered */

  public function isUserRegistered($login)
  {
    $connection = $this->getConnection(__FUNCTION__);

    if ($connection != false) {
      $result = $connection->{__FUNCTION__}($login, $this->client_code);
      return $this->getResult($result);
    } else {
      return false;
    }
  }

  /* Retrieve password */

  public function sendPasswordReminder($login)
  {
    $connection = $this->getConnection(__FUNCTION__);

    if ($connection != false) {
      $result = $connection->{__FUNCTION__}($login, $this->client_code);
      return $this->getResult($result);
    } else {
      return false;
    }
  }

  /* Subscribe to newsletters */

  public function findNewsletterSubscriptionStatus($profile_id, $newsletter_ids)
  {
    $connection = $this->getConnection(__FUNCTION__);

    if ($connection != false) {
      $result = $connection->{__FUNCTION__}($profile_id, $newsletter_ids, $this->client_code);
      return $this->getResult($result);
    } else {
      return false;
    }
  }

  /* Subscribe to newsletters */

  public function newsletterSubscribe($profile_id, $newsletter_ids)
  {
    $connection = $this->getConnection(__FUNCTION__);
    if ($connection != false) {
      $result = $connection->{__FUNCTION__}($profile_id, $newsletter_ids, $this->client_code);
      return $result;
    } else {
      return false;
    }
  }

  /* Unsubscribe from newsletters */

  public function newsletterUnsubscribe($profile_id, $newsletter_ids)
  {
    $connection = $this->getConnection(__FUNCTION__);

    if ($connection != false) {
      $result = $connection->{__FUNCTION__}($profile_id, $newsletter_ids, $this->client_code);
      return $result;
    } else {
      return false;
    }
  }

  /* Update Profile  */

  public function updateProfile($user_info)
  {
    $connection = $this->getConnection(__FUNCTION__);
    $error = false;

    //build XML
    $profile_data = "<registration>";
    if (isset($user_info['email']) && trim($user_info['email']) != '') {
      $profile_data .= "<login>" . $user_info['email'] . "</login>";
    }
    if (isset($user_info['password']) && trim($user_info['password']) != '') {
      $profile_data .= "<password>" . $user_info['password'] . "</password>";
    }
    if (isset($user_info['first_name']) && trim($user_info['first_name']) != '') {
      $profile_data .= "<firstname>" . $user_info['first_name'] . "</firstname>";
    }
    if (isset($user_info['last_name']) && trim($user_info['last_name']) != '') {
      $profile_data .= "<lastname>" . $user_info['last_name'] . "</lastname>";
    }
    if (isset($user_info['display_name']) && $user_info['display_name'] != '' && $user_info['old_display_name'] != $user_info['display_name']) {
      $profile_data .= "<displayname>" . $user_info['display_name'] . "</displayname>";
    }
    if (isset($user_info['address1']) && trim($user_info['address1']) != '') {
      $profile_data .= "<address1>" . $user_info['address1'] . "</address1>";
    }
    if (isset($user_info['address2']) && trim($user_info['address2']) != '') {
      $profile_data .= "<address2>" . $user_info['address2'] . "</address2>";
    }
    if (isset($user_info['city']) && trim($user_info['city']) != '') {
      $profile_data .= "<city>" . $user_info['city'] . "</city>";
    }
    if (isset($user_info['state']) && trim($user_info['state']) != '') {
      $profile_data .= "<state>" . $user_info['state'] . "</state>";
    }
    if (isset($user_info['zipcode']) && trim($user_info['zipcode']) != '') {
      $profile_data .= "<postalcode>" . $user_info['zipcode'] . "</postalcode>";
    }
    if (isset($user_info['country']) && trim($user_info['country']) != '') {
      $profile_data .= "<country>" . $user_info['country'] . "</country>";
    }
    $profile_data .= "</registration>";
    //echo $profile_data;

    if ($connection != false) {
      $result = $connection->{__FUNCTION__}($user_info['profile_id'], $profile_data, $this->client_code);
      $xml = new SimpleXMLElement($result);
      $code = $this->simplexmlFindAttribute($xml, "code");
      $msg = $this->simplexmlFindAttribute($xml, "message");
      $field = null;
      switch ($code) {
        case '0':
          $error = "";
          break;
        case '100':
          $error = "You are already a member of Agriculture.com. Please login using your email address and password.";
          break;
        case '107':
          $key = strval($xml->errors->key);
          switch ($key) {
            case 'invalidEmailAddressFormat':
              $error = "The login is not a valid email address format.";
              $field = "email";
              break;
            case 'invalidClientCode':
              $error = "The client code passed is not recognized.";
              break;
            case 'alreadyExistingDisplayName':
              $error = 'The display name provided is not unique in our repository.';
              $field = "display_name";
              break;
            case 'firstNameTooLong':
              $error = 'Max 12 characters';
              $field = "first_name";
              break;
            case 'loginTooLong':
              $error = 'Max 50 characters';
              $field = "email";
              break;
            case 'lastNameTooLong':
              $error = 'Max 17 characters';
              $field = "last_name";
              break;
            case 'lastNameTooShort':
              $error = 'The lastname field was provided, but was not at least 2 characters in length.';
              $field = "last_name";
              break;
            case 'address1TooLong':
              $error = 'Max 30 characters';
              $field = "address1";
              break;
            case 'address2TooLong':
              $error = 'Max 30 characters';
              $field = "address2";
              break;
            case 'cityTooLong':
              $error = 'Max 30 characters';
              $field = "city";
              break;
            case 'stateLengthInvalid':
              $error = 'The state field was provided, but was not 2 characters in length.';
              $field = "state";
              break;
            case 'postalCodeTooLong':
              $error = 'Max 10 characters';
              $field = "zipcode";
              break;
            case 'countryLengthInvalid':
              $error = 'The country field was provided, but was not 2 characters in length.';
              $field = "country";
              break;
            case 'alreadyExistingEmailAddress':
            	$error = 'Email address is already in use. Please choose a new one.';
            	$field = 'email';
				break;
            default:
              $error = "There was an error. Please check your information and try again";
              break;
          }
          break;
      }
    }
    return compact('error', 'msg', 'code', 'field');
  }

  /* Auxiliary functions */

  private function simplexmlFindAttribute(SimpleXMLElement $element, $attributeName)
  {
    $attrs = $element->attributes();
    if (isset($attrs[$attributeName])) {
      return (string) $attrs[$attributeName];
    }
    return false;
  }

  private function getConnection($function_name)
  {
    $full_url = $this->base_url . $function_name . '?WSDL';
    //echo $full_url;
    try {
      $result = new SoapClient($full_url, array('login' => $this->auth_user, 'password' => $this->auth_pass, 'connection_timeout' => 90));
      /* var_dump($result);
        if (is_soap_fault($result)) {
        trigger_error("SOAP Fault: (faultcode: {$result->faultcode}, faultstring: {$result->faultstring})", E_USER_ERROR);
        } */
    } catch (Exception $e) {
      $result = false;
    }

    return $result;
  }

  private function getResult($result)
  {
    $xml = new SimpleXMLElement($result);
    $code = $this->simplexmlFindAttribute($xml, "code");
    $message = $this->simplexmlFindAttribute($xml, "message");

    return compact('code', 'message', 'xml');
  }

}
