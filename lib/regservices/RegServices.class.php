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
//    $connection = $this->getConnection(__FUNCTION__);
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

//*
	$query = new Doctrine_Query();
	$query->select('r.*')
		  ->from('MeredithReg r')
		  ->where('r.email = ?',$user_info['login_name']);
//		  ->andWhere('r.password = ?', sha1($password));
	$users = $query->execute();
	
	if (count($users)  > 0)
	{
		$result = "<result code=\"100\" message=\"Profile already exists for user ".$user_info['login_name']."\"></result>";
	}
	elseif (strlen($user_info['display_name']) < 1)	
	{
		$result = "<result code=\"101\" message=\"Registration failed: Validation exception\"><errors><key>displayNameRequired</key></errors></result>";
	}
	elseif (strlen($user_info['first_name']) < 1 || strlen($user_info['first_name']) > 12)	
	{
		$result = "<result code=\"101\" message=\"Registration failed: Validation exception\"><errors><key>firstNameTooLong</key></errors></result>";
	}
	elseif (strlen($user_info['first_name']) < 1)	
	{
		$result = "<result code=\"101\" message=\"Registration failed: Validation exception\"><errors><key>firstNameRequired</key></errors></result>";
	}
	elseif (strlen($user_info['login_name']) < 1 || strlen($user_info['login_name']) > 50)	
	{
		$result = "<result code=\"101\" message=\"Registration failed: Validation exception\"><errors><key>loginTooLong</key></errors></result>";
	}
	elseif (strlen($user_info['password']) < 1)	
	{
		$result = "<result code=\"101\" message=\"Registration failed: Validation exception\"><errors><key>passwordRequired</key></errors></result>";
	}
	elseif (strlen($user_info['password']) < 6 || strlen($user_info['password']) > 20 || ctype_lower($user_info['password']) || preg_match('/^\[a-zA-Z]+$/',$user_info['password']) )	//Must be from 6 to 20 characters in length. Must contain at least one capital letter or special character.
	{
		$result = "<result code=\"101\" message=\"Registration failed: Validation exception\"><errors><key>insufficientPassword</key></errors></result>";
	}
	else
	{
		$udid = uniqid();
		$ssotoken = uniqid();
		$d = new DateTime();
		$display_date = $d->format("Y-m-d 00:00:00 T");
		$d->modify('+2 weeks');
		$token_date = $d->format("Y-m-d h:i:s T");

		$mreg = new MeredithReg();
//		$mreg->set('id', $id); // maybe you don't need this line, if `id` is the primary key
		$mreg->set('user_id', $udid);
		$mreg->set('first_name', $user_info['first_name']);
		$mreg->set('email', $user_info['login_name']);
		$mreg->set('registration_date', $display_date);
		$mreg->set('registration_source', $registration_source);
		$mreg->set('password', sha1($user_info['password']));
		$mreg->save();
		
		$result = "<result code=\"0\" message=\"OK\"><profileid>".$udid."</profileid><ssotoken>".$ssotoken."</ssotoken><ssotokenexpire>".$token_date."</ssotokenexpire></result>";
	}
//*/
//*	
//    if ($connection != false) {
//      $result = $connection->register($profile_data, $this->client_code);
//*/
		if (sfConfig::get('sf_logging_enabled'))
		{
			sfContext::getInstance()->getLogger()->info("BEN-register:".$result);
		}
		//<result code="100" message="Profile already exists for user bsanders@resoluted.com"></result>
      	//<result code="101" message="Registration failed: Validation exception"><errors><key>firstNameRequired</key></errors></result>
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
//    }
    return compact('profile_id', 'error', 'msg', 'code', 'key');
  }

  /* Get user profile */

  public function getProfile($profile_id)
  {
/*  
    $connection = $this->getConnection(__FUNCTION__);
    if ($connection != false) {
      $xml = simplexml_load_string($connection->{__FUNCTION__}($profile_id, $this->client_code));


      $code = $this->simplexmlFindAttribute($xml, "code");
      $msg = $this->simplexmlFindAttribute($xml, "message");

		if (sfConfig::get('sf_logging_enabled'))
		{
			sfContext::getInstance()->getLogger()->info("BEN-getprofile:".serialize($connection->{__FUNCTION__}($profile_id, $this->client_code)));
		}
//<result code="0" message="OK"><profile><user:user xmlns:user="http://www.atg.com/ns/_002fmeredith_002fprofile_002fwebservices_002fmoreProfileMapping/UserProfiles/user" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"  xsi:schemaLocation="http://www.atg.com/ns/_002fmeredith_002fprofile_002fwebservices_002fmoreProfileMapping/UserProfiles/user _002fmeredith_002fprofile_002fwebservices_002fmoreProfileMapping+UserProfiles+user.xsd " xmlns:enc="http://schemas.xmlsoap.org/soap/encoding/" ID="user478016436tst" repositoryId="478016436tst"><user:user.homeAddress xsi:type="itemRef" componentType="contactInfo"><user:homeAddresscontactInfo ID="contactInfo172528015" repositoryId="172528015"><user:contactInfo.postalCode xsi:nil="true"/><user:contactInfo.city xsi:nil="true"/><user:contactInfo.country xsi:type="string"><![CDATA[USA]]></user:contactInfo.country><user:contactInfo.state xsi:nil="true"/><user:contactInfo.address2 xsi:nil="true"/><user:contactInfo.address1 xsi:nil="true"/></user:homeAddresscontactInfo></user:user.homeAddress><user:user.firstName xsi:type="string"><![CDATA[benjaminc]]></user:user.firstName><user:user.userDisplayName xsi:type="string"><![CDATA[techyogi123457]]></user:user.userDisplayName><user:user.lastName xsi:nil="true"/><user:user.login xsi:type="string"><![CDATA[bsanders@resolutedddd3.com]]></user:user.login><user:user.id xsi:type="string"><![CDATA[478016436tst]]></user:user.id></user:user></profile></result>      
//*/

//	$query = new Doctrine_Query();
//	$query->select('r.*,u.*')
//		  ->from('MeredithReg r')
//		  ->leftJoin('r.User u ON r.user_id = u.profile_id')
//		  ->where('r.user_id = ?',$profile_id);
	$profile_email = false;
	$connection = Doctrine_Manager::connection();
	$query = "SELECT email from meredith_reg where user_id = '".$profile_id."'";
	$statement = $connection->execute($query);
	$statement->execute();
	if (count($statement)  > 0)
	{
		$resultset = $statement->fetchAll(PDO::FETCH_ASSOC);	
		$profile_email = $resultset[0]['email'];
	}
	else
	{
		$query = "SELECT email from user where profile_id_id = '".$profile_id."'";
		$statement = $connection->execute($query);
		$statement->execute();
		if (count($statement)  > 0)
		{
			$resultset = $statement->fetchAll(PDO::FETCH_ASSOC);	
			$profile_email = $resultset[0]['email'];	
		}
	}
	if ($profile_email != false)
	{
		$query = "SELECT * from meredith_reg r left join user u on r.email = u.email where r.email = '".$profile_email."'";
		$statement = $connection->execute($query);
		$statement->execute();
		$resultset = $statement->fetchAll(PDO::FETCH_ASSOC);		
	
	}
	else
	{
		$query = "SELECT * from meredith_reg r left join user u on r.user_id = u.profile_id where r.user_id = '".$profile_id."'";
		$statement = $connection->execute($query);
		$statement->execute();
		$resultset = $statement->fetchAll(PDO::FETCH_ASSOC);			
	}
	


/*
	//$connection = Doctrine_Manager::connection();
	$query = "SELECT * from meredith_reg r left join user u on r.user_id = u.profile_id where r.user_id = '".$profile_id."'";
	$statement = $connection->execute($query);
	$statement->execute();
	$resultset = $statement->fetchAll(PDO::FETCH_ASSOC);	
//*/
//print_r($resultset);
//print_r($resultset[0]['user_id']);
//exit;
		if (sfConfig::get('sf_logging_enabled'))
		{
			sfContext::getInstance()->getLogger()->info("BEN-query:".count($statement));	//->getSqlQuery()
		}	
	if (count($statement)  > 0)
	{
		$result = "<result code=\"0\" message=\"OK\"><profile><user:user xmlns:user=\"http://www.atg.com/ns/_002fmeredith_002fprofile_002fwebservices_002fmoreProfileMapping/UserProfiles/user\" xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" xsi:schemaLocation=\"http://www.atg.com/ns/_002fmeredith_002fprofile_002fwebservices_002fmoreProfileMapping/UserProfiles/user _002fmeredith_002fprofile_002fwebservices_002fmoreProfileMapping+UserProfiles+user.xsd\" xmlns:enc=\"http://schemas.xmlsoap.org/soap/encoding/\">";
		$result .= "<user:user.homeAddress>";
		$result .= "<user:homeAddresscontactInfo>";
		$result .= "<user:contactInfo.postalCode/>";
		$result .= "<user:contactInfo.city/>";
		$result .= "<user:contactInfo.country><![CDATA[USA]]></user:contactInfo.country>";
		$result .= "<user:contactInfo.state/>";
		$result .= "<user:contactInfo.address2/>";
		$result .= "<user:contactInfo.address1/>";
		$result .= "</user:homeAddresscontactInfo>";
		$result .= "</user:user.homeAddress>";
		$result .= "<user:user.firstName><![CDATA[".$resultset[0]['first_name']."]]></user:user.firstName>";
		$result .= "<user:user.userDisplayName><![CDATA[".$resultset[0]['display_name']."]]></user:user.userDisplayName>";
		$result .= "<user:user.lastName/>";
		$result .= "<user:user.login><![CDATA[".$resultset[0]['email']."]]></user:user.login>";
		$result .= "<user:user.id><![CDATA[".$resultset[0]['user_id']."]]></user:user.id>";
		$result .= "</user:user></profile></result>";
      $xml = simplexml_load_string($result);

		if (sfConfig::get('sf_logging_enabled'))
		{
			sfContext::getInstance()->getLogger()->info("BEN-getprofile:".serialize($result));
		}
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
//*
		if (sfConfig::get('sf_logging_enabled'))
		{
			sfContext::getInstance()->getLogger()->info("BEN-auth:".serialize($login.":".$password));
		}
		$query = new Doctrine_Query();
		$query->select('r.*')
			  ->from('MeredithReg r')
			  ->where('r.password = ?', sha1($password))
			  ->andWhere('r.email = ?',$login);

		$users = $query->execute();
		if (count($users)  > 0)
		{
			if (strlen($users[0]->password) > 0 && $users[0]->password != "")
			{
				if (sfConfig::get('sf_logging_enabled'))
				{
					sfContext::getInstance()->getLogger()->info("BEN-authuser:".serialize($users));
				}
				$udid = uniqid();
				$d = new DateTime();
				$d->modify('+2 weeks');
				$display_date = $d->format("Y-m-d h:i:s T");
				//$result = "<result code="0" message="OK"><profileid>253180015tst</profileid><ssotoken>162435a7</ssotoken><ssotokenexpire>2015-04-15 10:56:34 CDT</ssotokenexpire></result>";
				$result = "<result code=\"0\" message=\"OK\"><profileid>".$users[0]->user_id."</profileid><ssotoken>".$udid."</ssotoken><ssotokenexpire>".$display_date."</ssotokenexpire></result>";

				if (sfConfig::get('sf_logging_enabled'))
				{
					sfContext::getInstance()->getLogger()->info("BEN-authuser-temp:".$result);
				}
//				$result['code'] = "0";
				return $this->getResult($result);
			}
			else
			{
				$result = "<result code=\"1\" message=\"The login and password do not match\"></result>";
				return $this->getResult($result);
				//return false;
			}
		}
		else
		{
			$query = new Doctrine_Query();
			$query->select('r.*')
				  ->from('MeredithReg r')
				  ->where('r.password is null')
				  ->andWhere('r.email = ?',$login);

			$users = $query->execute();
			if (count($users) > 0)					
				$result = "<result code=\"2\" message=\"Your password has been reset for security. Please use 'Forgot Your Password' below to reset it now.\"></result>";			
			else
				$result = "<result code=\"1\" message=\"The login and password do not match\"></result>";
			return $this->getResult($result);
			//return false;
		}
//		echo $users[0]->password;
//		foreach($users as $user) {
//			print $user->password;
//		}
//		exit;
///*/
/*    
    $connection = $this->getConnection(__FUNCTION__);
    if ($connection != false) {
      $result = $connection->{__FUNCTION__}($login, $password, $this->client_code);
		if (sfConfig::get('sf_logging_enabled'))
		{
			sfContext::getInstance()->getLogger()->info("BEN-reguser:".$result);
		}

      return $this->getResult($result);
    } else {
      return false;
    }
//*/
  }

  /* Is user registered */

  public function isUserRegistered($login)
  {
//    $connection = $this->getConnection(__FUNCTION__);

//    if ($connection != false) {
//      $result = $connection->{__FUNCTION__}($login, $this->client_code);

		$query = new Doctrine_Query();
		$query->select('r.*')
			  ->from('MeredithReg r')
			  ->where('r.email = ?', $login);

		$users = $query->execute();
		if (count($users)  > 0)
		{
				$result = "<result code=\"0\" message=\"OK\"><profileexists>true</profileexists><profileid>".$users[0]->user_id."</profileid><registeredforsite>false</registeredforsite></result>";
		}
		else
		{
				$result = "<result code=\"0\" message=\"OK\"><profileexists>false</profileexists><profileid></profileid><registeredforsite>false</registeredforsite></result>";
		
		}
		if (sfConfig::get('sf_logging_enabled'))
		{
			sfContext::getInstance()->getLogger()->info("BEN-isuserreg:".$result);
		}

      return $this->getResult($result);
//    } else {
//      return false;
//    }
  }

  /* Retrieve password */

  public function sendPasswordReminder($login)
  {
//*
		$query = new Doctrine_Query();
		$query->select('r.*')
			  ->from('MeredithReg r')
			  ->where('r.email = ?', $login);

		$users = $query->execute();
		if (count($users)  > 0)
		{
				$result = "<result code=\"0\" message=\"OK\"></result>";
		}
		else
		{
			if (sfConfig::get('sf_logging_enabled'))
			{
				sfContext::getInstance()->getLogger()->info("BEN-handle_forgot_user_noreg:".$login);
			}			
			//added case to handle a user needing forgotpassword who is in the User table but not in the MeredithReg table - so we add the entry. 
			//Safe by assumption that only that user gets the reset email. - ben
			$query = new Doctrine_Query();
			$query->select('u.*')
				  ->from('User u')
				  ->where('u.email = ?', $login);
			$users = $query->execute();
			if (count($users)  > 0)
			{
				if (sfConfig::get('sf_logging_enabled'))
				{
					sfContext::getInstance()->getLogger()->info("BEN-handle_forgot_user_noreg:".$users[0]->email.":".$users[0]->first_name);
				}			
				//user is in user table, so create the reg entry
				$udid = $users[0]->profile_id;
				if (strlen($udid) < 1 || $udid == "")
				{
					$udid = uniqid();
					//should update User table with this ID as well so the later joins work.
					$q = Doctrine_Query::create()->update('User u');
					$q->set('u.profile_id', '?', $udid);
					$q->where('u.email = ?', $login)->execute();
					
				}
				$d = new DateTime();
				$display_date = $d->format("Y-m-d 00:00:00 T");
			    $registration_source = $this->registration_source;

				$mreg = new MeredithReg();
		//		$mreg->set('id', $id); // maybe you don't need this line, if `id` is the primary key
				$mreg->set('user_id', $udid);
				$mreg->set('first_name', $users[0]->first_name);
				$mreg->set('email', $users[0]->email);
				$mreg->set('registration_date', $display_date);
				$mreg->set('registration_source', $registration_source);
				$mreg->set('password', "");// still needs to be reset, so blank is fine. - ben	//sha1($user_info['password']));
				$mreg->save();


				$result = "<result code=\"0\" message=\"OK\"></result>";
			}
			else
			{
				//user doesnt exist, so they should just register!
				$result = "<result code=\"102\" message=\"Send Password Reset failed: User does not exist\"></result>";			
			}
		}
		if (sfConfig::get('sf_logging_enabled'))
		{
			sfContext::getInstance()->getLogger()->info("BEN-sendPasswordReminder:".$result);
		}

      return $this->getResult($result);
//*/
/*
    $connection = $this->getConnection(__FUNCTION__);

    if ($connection != false) {
      $result = $connection->{__FUNCTION__}($login, $this->client_code);
		if (sfConfig::get('sf_logging_enabled'))
		{
			sfContext::getInstance()->getLogger()->info("BEN-sendPasswordReminder:".$result);
		}
      return $this->getResult($result);
    } else {
      return false;
    }
//*/
  }

  /* Subscribe to newsletters */
/*
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
//*/
  /* Subscribe to newsletters */

  public function newsletterSubscribe($profile_id, $newsletter_ids)
  {
		$q = Doctrine_Query::create()->update('MeredithReg u');
		$q->set('u.newsletter_id', '?', $newsletter_ids);
		$q->where('u.user_id = ?', $profile_id)->execute();
  
		if (sfConfig::get('sf_logging_enabled'))
		{
			sfContext::getInstance()->getLogger()->info("BEN-newslettersub:".$profile_id.":".$newsletter_ids);
		}
  
//    $connection = $this->getConnection(__FUNCTION__);
//    if ($connection != false) {
//      $result = $connection->{__FUNCTION__}($profile_id, $newsletter_ids, $this->client_code);
		$result = "OK";
		return $result;
//    } else {
//      return false;
//    }
  }

  /* Unsubscribe from newsletters */
/*
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
//*/
  /* Update Profile  */

  public function updateProfile($user_info)
  {
//    $connection = $this->getConnection(__FUNCTION__);
    $error = false;
	$result = "";

    //build XML
    $profile_data = "<registration>";
    if (isset($user_info['email']) && trim($user_info['email']) != '' && $user_info['email'] != $user_info['email_old']) 
    {
		if (strlen($user_info['email']) < 1 || strlen($user_info['email']) > 50)	
		{
			$result = "<result code=\"101\" message=\"Registration failed: Validation exception\"><errors><key>loginTooLong</key></errors></result>";
		}
        else
        {
			$query = new Doctrine_Query();
			$query->select('r.*')
			->from('MeredithReg r')
			->where('r.email = ?',$user_info['email']);
			//		  ->andWhere('r.password = ?', sha1($password));
			$users = $query->execute();

			if (count($users)  > 0)
			{
				$result = "<result code=\"107\" message=\"Registration failed: Validation exception\"><errors><key>alreadyExistingEmailAddress</key></errors></result>";
//				$result = "<result code=\"100\" message=\"Profile already exists for user ".$user_info['login_name']."\"></result>";
			}
		}
	    $profile_data .= "<login>" . $user_info['email'] . "</login>";
    }
    if (isset($user_info['password']) && trim($user_info['password']) != '') {
      $profile_data .= "<password>" . sha1($user_info['password']) . "</password>";
    }
    if (isset($user_info['first_name']) && trim($user_info['first_name']) != '') {
		if (strlen($user_info['first_name']) < 1 || strlen($user_info['first_name']) > 12)	
		{
			$result = "<result code=\"101\" message=\"Registration failed: Validation exception\"><errors><key>firstNameTooLong</key></errors></result>";
		}    
      	$profile_data .= "<firstname>" . $user_info['first_name'] . "</firstname>";
    }
    if (isset($user_info['last_name']) && trim($user_info['last_name']) != '') {
		if (strlen($user_info['last_name']) < 2)	
		{
			$result = "<result code=\"101\" message=\"Registration failed: Validation exception\"><errors><key>lastNameTooShort</key></errors></result>";
		}    
		elseif (strlen($user_info['last_name']) > 17)	
		{
			$result = "<result code=\"101\" message=\"Registration failed: Validation exception\"><errors><key>lastNameTooLong</key></errors></result>";
		}    
      	$profile_data .= "<lastname>" . $user_info['last_name'] . "</lastname>";
    }
    if (isset($user_info['display_name']) && $user_info['display_name'] != '' && $user_info['old_display_name'] != $user_info['display_name']) {
		$query = new Doctrine_Query();
		$query->select('u.id')
		->from('User u')
		->where('u.display_name = ?',$user_info['display_name']);
		$users = $query->execute();

		if (count($users)  > 0)
		{
			$result = "<result code=\"107\" message=\"Registration failed: Validation exception\"><errors><key>alreadyExistingDisplayName</key></errors></result>";
		}
      	$profile_data .= "<displayname>" . $user_info['display_name'] . "</displayname>";
    }
    if (isset($user_info['address1']) && trim($user_info['address1']) != '') {
		if (strlen($user_info['address1']) > 30)	
		{
			$result = "<result code=\"101\" message=\"Registration failed: Validation exception\"><errors><key>address1TooLong</key></errors></result>";
		}   
      	$profile_data .= "<address1>" . $user_info['address1'] . "</address1>";
    }
    if (isset($user_info['address2']) && trim($user_info['address2']) != '') {
		if (strlen($user_info['address2']) > 30)	
		{
			$result = "<result code=\"101\" message=\"Registration failed: Validation exception\"><errors><key>address2TooLong</key></errors></result>";
		}   
      	$profile_data .= "<address2>" . $user_info['address2'] . "</address2>";
    }
    if (isset($user_info['city']) && trim($user_info['city']) != '') {
		if (strlen($user_info['city']) > 30)	
		{
			$result = "<result code=\"101\" message=\"Registration failed: Validation exception\"><errors><key>cityTooLong</key></errors></result>";
		}   
      	$profile_data .= "<city>" . $user_info['city'] . "</city>";
    }
    if (isset($user_info['state']) && trim($user_info['state']) != '') {
		if (strlen($user_info['state']) <> 2)	
		{
			$result = "<result code=\"101\" message=\"Registration failed: Validation exception\"><errors><key>stateLengthInvalid</key></errors></result>";
		}   
      	$profile_data .= "<state>" . $user_info['state'] . "</state>";
    }
    if (isset($user_info['zipcode']) && trim($user_info['zipcode']) != '') {
		if (strlen($user_info['zipcode']) < 1 || strlen($user_info['zipcode']) > 10)	
		{
			$result = "<result code=\"101\" message=\"Registration failed: Validation exception\"><errors><key>postalCodeTooLong</key></errors></result>";
		}   
      	$profile_data .= "<postalcode>" . $user_info['zipcode'] . "</postalcode>";
    }
    if (isset($user_info['country']) && trim($user_info['country']) != '') {
		if (strlen($user_info['country']) <> 2)	
		{
			$result = "<result code=\"101\" message=\"Registration failed: Validation exception\"><errors><key>countryLengthInvalid</key></errors></result>";
		}   
      	$profile_data .= "<country>" . $user_info['country'] . "</country>";
    }
    $profile_data .= "</registration>";

//print_r($user_info);exit;
	if (strlen($result) < 1)
	{
		$udid = uniqid();
		$ssotoken = uniqid();
		$d = new DateTime();
		$display_date = $d->format("Y-m-d 00:00:00 T");
		$d->modify('+2 weeks');
		$token_date = $d->format("Y-m-d h:i:s T");

		$q = Doctrine_Query::create()->update('MeredithReg r');
	    if (isset($user_info['first_name']) && trim($user_info['first_name']) != '')
			$q->set('r.first_name', '?', $user_info['first_name']);
	    if (isset($user_info['last_name']) && trim($user_info['last_name']) != '')
			$q->set('r.last_name', '?', $user_info['last_name']);
	    if (isset($user_info['address1']) && trim($user_info['address1']) != '')
			$q->set('r.address1', '?', $user_info['address1']);
	    if (isset($user_info['address2']) && trim($user_info['address2']) != '')
			$q->set('r.address2', '?', $user_info['address2']);
	    if (isset($user_info['city']) && trim($user_info['city']) != '')
			$q->set('r.city', '?', $user_info['city']);
	    if (isset($user_info['state']) && trim($user_info['state']) != '')
			$q->set('r.state', '?', $user_info['state']);
	    if (isset($user_info['zipcode']) && trim($user_info['zipcode']) != '')
			$q->set('r.postal_code', '?', $user_info['zipcode']);
	    if (isset($user_info['password']) && trim($user_info['password']) != '')
			$q->set('r.password', '?', sha1($user_info['password']));
//		$q->set('r.updated', '?', date('Y-m-d H:i:s'));
		$q->where('r.user_id = ?', $user_info['profile_id'])->execute();

		$q = Doctrine_Query::create()->update('User u');
	    if (isset($user_info['first_name']) && trim($user_info['first_name']) != '')
			$q->set('u.first_name', '?', $user_info['first_name']);
	    if (isset($user_info['last_name']) && trim($user_info['last_name']) != '')
			$q->set('u.last_name', '?', $user_info['last_name']);
	    if (isset($user_info['display_name']) && trim($user_info['display_name']) != '')
			$q->set('u.display_name', '?', $user_info['display_name']);
//		$q->set('r.updated', '?', date('Y-m-d H:i:s'));
		$q->where('u.profile_id = ?', $user_info['profile_id'])->execute();


//		$q = Doctrine_Query::create()->update('Recipe r');
//		$q->set('r.is_featured', '?', $isFeatured);
//		$q->set('r.updated_at', '?', date('Y-m-d H:i:s'));
//		$q->where('r.id = ?', $recipeId)->execute();

		$result = "<result code=\"0\" message=\"OK\"><profileid>".$udid."</profileid><ssotoken>".$ssotoken."</ssotoken><ssotokenexpire>".$token_date."</ssotokenexpire></result>";	

	}

	if (sfConfig::get('sf_logging_enabled'))
	{
		sfContext::getInstance()->getLogger()->info("BEN-updateprofile:".$profile_data);
	}

//    if ($connection != false) {
//      $result = $connection->{__FUNCTION__}($user_info['profile_id'], $profile_data, $this->client_code);
      $xml = new SimpleXMLElement($result);
      $code = $this->simplexmlFindAttribute($xml, "code");
      $msg = $this->simplexmlFindAttribute($xml, "message");
      
		if (sfConfig::get('sf_logging_enabled'))
		{
			sfContext::getInstance()->getLogger()->info("BEN-updateprofile:".$result);
		}
      //<result code="107" message="Profile update failed: ProfileID 551d60520cba5 not in repository"></result>
      $field = null;
      switch ($code) {
        case '0':
          $error = "";
          break;
        case '100':
          $error = "You are already a member of BetterRecipes.com. Please login using your email address and password.";
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
//    }
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
      $result = new SoapClient($full_url, array(
        'login'              => $this->auth_user,
        'password'           => $this->auth_pass,
        'connection_timeout' => 90,
        'exceptions'         => true,
        'trace'              => true,
        'cache_wsdl'         => WSDL_CACHE_BOTH,
        'compression'        => SOAP_COMPRESSION_ACCEPT | SOAP_COMPRESSION_GZIP)
      );
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
