<?php

/**
 * auth actions.
 *
 * @package    betterrecipes
 * @subpackage auth
 * @author     Bastian Kuberek <bkuberek@resolute.com>
 */
class authActions extends sfActions
{
  /**
   * Both Signin and Signout use the same templates 
   * so I have a bit of a messy controller here trying to separate the logic.
   * Basically, this is the best aproach I could see in order to have
   * all of signin and signup into their own actions. 
   * In the eventuality they will live off 2 separate pages, the changes will be minor.
   */

  /**
   * @see sfAction
   */
  protected function processReferrer($request)
  {
    if (($referrer = $request->getParameter('referrer'))) {
      $this->getUser()->setReferrer($referrer);
    } elseif (!$this->getUser()->getReferrer()) {
      if (!$request->isMethod(sfRequest::POST) && $this->getContext()->getActionStack()->getSize() > 1) {
        $this->getUser()->setReferrer($request->getUri());
      }
    }
    $this->getRegSource();
  }

  /**
   *
   * @param boolean $remove will remove it from session
   * @return string
   */
  protected function getReferrer($remove = false)
  {
    $default = $this->getUser()->isAuthenticated() ? UrlToolkit::getRoute('User', array('display_name' => $this->getUser()->getDisplayName())) : $this->generateUrl('homepage');
    $referrer = $remove ? $this->getUser()->removeReferrer($default) : $this->getUser()->getReferrer($default);
    switch (true) {
      case strpos($referrer, '/signin'):
      case strpos($referrer, '/signout'):
      case strpos($referrer, '/signup'):
        $referrer = $this->generateUrl('homepage');
        break;
      case strpos($referrer, '/edit'):
        $referrer = $this->generateUrl('homepage');
        break;
// add more exceptions here
    }
    return $referrer;
  }

  /**
   * Redirect user to referrer
   */
  public function goToReferrer()
  {
    if (!($referrer = $this->getReferrer(true))) {
      $referrer = $this->generateUrl('homepage');
    }
    $this->redirect($referrer);
  }

  /**
   * Eventually this will map the referrer to a regSource code
   * 
   * @return integer regSource code
   */
  public function getRegSource()
  {
    // RegSouce can only be set on a GET request. If POST, just return what was previously set
    if (!$this->getRequest()->isMethod(sfRequest::POST)) {

      $code = 8273; // default to "Become a Member"
      if ($this->getRequest()->getGetParameter('regSource')) {
        // if set in the request, it has already been saved into the session.
        // this should take precedence
        $regSource = $this->getUser()->getRegSourceAttribute('code');
      } else {
        // if not in the request, could be that this is a secured section
        // and this is an internal forward rather than a redirect. 
        // In this case, the current URI is also our referrer and regSource.
        // In the case we were redirected, then referrer is our regSource.
        $regSourceCodes = sfConfig::get('app_RegServices_source_codes');

        foreach ($regSourceCodes as $pattern => $code) {
          if (preg_match($pattern, $this->getReferrer())) {
            $this->getUser()->setRegSourceAttribute('code', $code);
            break;
          }
        }
      }
      $regSourceNames = sfConfig::get('app_RegServices_source_names');
      if (array_key_exists($code, $regSourceNames)) {
        $regSourceName = $regSourceNames[$code];
        $this->getUser()->setRegSourceAttribute('name', $regSourceName);
      }
    }
  }

  /**
   * Executes signin and signup action ig sf_method = GET
   *
   * @param sfWebRequest $request A request object
   */
  public function executeIndex(sfWebRequest $request)
  {
    $this->processReferrer($request);
    if ($this->getUser()->isAuthenticated()) {
      $this->goToReferrer();
    }

//  If socialize cannot find a record for the fb user prepopulate the signin fields from fb data
    if ($request->getParameter('signup_from_fb', null)) {
      $signup_from_fb['email'] = $request->getParameter('email');
      $signup_from_fb['firstname'] = $request->getParameter('firstName');
      $signup_from_fb['display_name'] = strtolower($request->getParameter('firstName') . '_' . $request->getParameter('lastName'));
      $signup_from_fb['fb_id'] = $request->getParameter('loginProviderUID');
      $this->getUser()->setAttribute('signup_from_fb', $signup_from_fb);
    } else {
      $signup_from_fb = array();
    }

//  meta
    $response = $this->getResponse();
    $response->setTitle('Sign Up | Share Recipes | Daily Sweepstakes | Recipe Contests | Better Recipes');
    $response->addMeta('description', 'Sign up at Better Recipes to submit and share your favorite online recipes, enter daily sweepstakes and recipe contests and join our recipe community!');
    $response->addMeta('keywords', 'online recipes, share recipes, daily sweepstakes, recipe contests, recipe community');

    $this->signinForm = new SigninForm();
    $this->signupForm = new SignupForm($signup_from_fb);
    $this->passwordForm = new ForgotPasswordForm();

    if ($request->isMethod(sfRequest::POST)) {
      if ($request->hasParameter($this->signinForm->getName())) {
        $this->forward('auth', 'signin');
      } elseif ($request->hasParameter($this->signupForm->getName())) {
        $this->forward('auth', 'signup');
      } elseif ($request->hasParameter($this->passwordForm->getName())) {
        $this->forward('auth', 'forgotPassword');
      } else {
//      get rid of POST
        $this->redirect('auth', 'index');
      }
    }

    /**
     * Omniture
     */
    $reg_stuff = ':' . $this->getUser()->getRegSourceAttribute('code') . ':' . $this->getUser()->getRegSourceAttribute('name');
    $this->getOmniture()->setMany(array(
      'pageName' => 'Registration:Page1' . $reg_stuff,
      'channel' => 'Registration',
      'prop5' => 'registration',
      'eVar9' => 'Registration:Page1' . $reg_stuff,
      'eVar14' => 'Registration'
    ));
  }

  /**
   * Executes signout action
   *
   * @param sfWebRequest $request A request object
   */
  public function executeSignout(sfWebRequest $request)
  {
    // destroy the 'lis' nginx cookie
    $this->getResponse()->setCookie('lis', '', time() - 3600, '/', UrlToolkit::getDomain());
    $this->processReferrer($request);
    if (!$this->getUser()->isAuthenticated()) {
      $this->getUser()->signout();
      $this->goToReferrer();
    }
    if ($request->isMethod(sfRequest::POST)) {
      if ($request->getPostParameter('signout')) {
        $this->getUser()->signout();
        $this->getUser()->setFlash('onSignout', true);
      }
      $this->goToReferrer();
    }
  }

  /**
   * Executes signout action
   *
   * @param sfWebRequest $request A request object
   */
  public function executeForgotPassword(sfWebRequest $request)
  {
    $this->processReferrer($request);
    if (!$request->isMethod(sfRequest::POST))
      $this->forward('auth', 'index');

    $this->passwordForm = new ForgotPasswordForm();
    $this->passwordForm->bind($request->getParameter($this->passwordForm->getName()));

    if ($this->passwordForm->isValid() && $this->passwordForm->send()) {
      $this->getUser()->setFlash('notice', 'Password reminder was sent. Please check your inbox.');
      $this->redirect('@signin');
    }

    $this->signinForm = new SigninForm();
    $this->signupForm = new SignupForm();
    $this->setTemplate('index');
  }

  /**
   * Executes signin action
   *
   * @param sfWebRequest $request A request object
   */
  public function executeSignin(sfWebRequest $request)
  {
    $this->processReferrer($request);
    if (!$request->isMethod(sfRequest::POST)) {
      $this->forward('auth', 'index');
    }

    $this->signinForm = new SigninForm();
    $this->signinForm->bind($request->getParameter($this->signinForm->getName()));
    if ($this->signinForm->isValid()) {
      /*$values = $this->signinForm->getValues();
      $this->getUser()->signin($values['user_data']);
      $this->getUser()->setFlash('onSignin', true);
      $this->setLisCookie($values['user_data']);
      $this->goToReferrer();*/
    } else {
	    $values = $this->signinForm->getValues();
	    print_r($values);
    }

    $this->signupForm = new SignupForm();
    $this->passwordForm = new ForgotPasswordForm();
    $this->setTemplate('index');
  }

  /**
   * Callback for Gigya
   * 
   * This action auto signin the user if the user has an account and have linked the provider
   * otherwise the user is presented with normal signup and signin forms which will then link with the provider
   * 
   * @param sfWebRequest $request 
   */
  public function executeSocialize(sfWebRequest $request)
  {
//    $this->processReferrer($request);
// http://www.YourSite.com/PostLoginPage.htm?zip=&UID=123&photoURL=&nickname=John%20Doe&profileURL=&
// birthMonth=10&loginProvider=twitter&loginProviderUID=65e&country=&thumbnailURL=&lastName=Esh&
// signature=pEqAFOUHRiAOjac9z%2FdoHlzNCbU%3D&firstName=John&provider=twitter&gender=&birthYear=1965&
// timestamp=2009%2D12%2D08%2015%3A53%3A45&UIDSig=&state=&email=&city=&birthDay=11&proxiedEmail=

    $this->social = $request->getGetParameters();
    $user = $this->getUser();
    foreach ($this->social as $key => $value) {
      $user->setSocial($key, $value);
    }

    $gigya = $this->getGigya();

    $valid = Gigya::validateUserSignature($user->getSocial('UID'), $user->getSocial('signatureTimestamp'), $gigya->getSecretKey(), $user->getSocial('UIDSignature'));
    $response = $gigya->request('socialize.getSessionInfo', array('uid' => $user->getSocial('UID'), 'provider' => $user->getSocial('loginProvider')));

    $user->setRegSourceAttribute('gigyaResponse', $response);
    $user->setRegSourceAttribute('auth_token_expire', $response->getString('tokenExpiration'));
    $user->setRegSourceAttribute('auth_token', $response->getString('authToken'));
    $user->setRegSourceAttribute('gigya_UID', $user->getSocial('UID'));

    if (!$valid) {
      $user->clearSocial();
      $user->setFlash('error', sprintf('There was a problem contacting %s. You can still login/register with a normal account and link your %s account later.'), $user->getSocial('provider'), $user->getSocial('provider'));
      $this->redirect(UrlToolkit::getSigninUri());
    }

    $local_user = UserTable::getUserByFbId($user->getSocial('loginProviderUID'));
    if (!$local_user) {
      $local_user = UserTable::getUserByEmail($user->getSocial('email'));
    }

    // If the local user data exist update it else cretae a local record for the user
    if (!$local_user) {
      $local_user = new User();
      $local_user->setRegSource($user->getRegSourceAttribute('code'));
    }
    $reg_user = null;

    $reg_services = new RegServices();
    // First try to find the user with profile_id from the local DB. If user does not exist in the DB try to get the user from reg services via user fb email.
    if ($profile_id = $local_user->getProfileId()) {
      $reg_user = $reg_services->getProfile($profile_id);
    } else {
      $result = $reg_services->isUserRegistered($user->getSocial('email') . '');
      if (strval($result['xml']->profileexists) == 'true') {
        $profile_id = strval($result['xml']->profileid);
        $reg_user = $reg_services->getProfile($profile_id);
      }
    }
    if ($reg_user) {
      $contact_info = @$reg_user['user_profile']['contact_info'];
      if (is_null($contact_info)) {
        $contact_info = array('address1' => null, 'address2' => null, 'city' => null, 'state' => null, 'zipcode' => null, 'country' => null);
      }
      $user_profile = array_merge($reg_user['user_profile'], $contact_info);
      unset($user_profile['contact_info']);

      // Update the user profile with FB user first and last names
      $user_profile['first_name'] = $this->social['firstName'];
      $user_profile['last_name'] = $this->social['lastName'];

      // Update reg services user first and last name from FB account
      $reg_data_update = array('profile_id' => $profile_id, 'first_name' => $user_profile['first_name'], 'last_name' => $user_profile['last_name']);
      $reg_services->updateProfile($reg_data_update);

      // Update local user data
      $local_user->commitUserData($user_profile);

      // Update reg services user first name and last name from facebook 
      $user_data = array_merge($user_profile, $local_user->toArray());
      if ($request->hasParameter('loginProviderUID')) {
        $user_data['fb_id'] = $request->getParameter('loginProviderUID');
      } else {
        $user_data['fb_id'] = $user->getSocial('loginProviderUID');
      }
    } else {
      $request->setParameter('signup_from_fb', 1);
      $this->forward('auth', 'signup');
    }

    if (is_null($local_user->getFbId()) || $local_user->getFbId() == '') {
      $local_user->setFbId($user->getSocial('loginProviderUID'));
      $local_user->save();
    }
    // Set lls cookie for nginx usage 
    $this->getResponse()->setCookie('lis', 1, time()+sfConfig::get('app_session_ttl'), '/', UrlToolkit::getDomain());
    $user->signin($local_user);
    $user->setFlash('onSignin', true);
    $user->setUserData($user_data);
    $this->goToReferrer();

    $this->passwordForm = new SigninForm(array(
        'email' => $user->getSocial('email')
      ));
    $this->signinForm = new SigninForm(array(
        'email' => $user->getSocial('email')
      ));
    $this->signupForm = new SignupForm(array(
        'display_name' => $user->getSocial('nickname'),
        'email' => $user->getSocial('email'),
        'firstname' => $user->getSocial('firstName')
      ));
  }

  /**
   * Executes signup action
   *
   * @param sfWebRequest $request A request object
   */
  public function executeSignup(sfWebRequest $request)
  {
    $this->social = $request->getGetParameters();
    $user = $this->getUser();
    foreach ($this->social as $key => $value) {
      $user->setSocial($key, $value);
    }

    $this->processReferrer($request);
    if (!$request->isMethod(sfRequest::POST)) {
      $this->forward('auth', 'index');
    }

    $this->signupForm = new SignupForm();
    $this->signupForm->bind($request->getParameter($this->signupForm->getName()));

    if ($this->signupForm->isValid()) {
      $user_data = $this->signupForm->signup();
      if ($user_data) {
        $user->setFlash('regSourceCode', $user_data['reg_source']);
        $user->setFlash('regSourceName', $user->getRegSourceAttribute('name'));
        $user->removeRegSourceAttribute();
        $user->signin($user_data, false);
        $user->setFlash('onSignup', true);
        $user->setFlash('onSignin', true);

        $values = $this->signupForm->getValues();
        if (!empty($values['newsletter_ids'])) {
          $reg_services = new RegServices();
          $data = $reg_services->newsletterSubscribe($user->getProfileId(), $values['newsletter_ids']);
          if (strpos($data, 'OK') !== false) {
            $user_data['newsletter_ids'] = $values['newsletter_ids'];
            $user->setUserData($user_data);
          }
          $user->setFlash('onNewsletterSignup', $values['newsletter_ids']);
        }
        if ($signup_from_fb = $user->getAttribute('signup_from_fb')) {
          $local_user = UserTable::getUserByProfileId($user_data['profile_id']);
          $local_user->setFbId($signup_from_fb['fb_id']);
          $local_user->save();
          $user_data['fb_id'] = $signup_from_fb['fb_id'];
          $user->setUserData($user_data);
          $user->setAttribute('signup_from_fb', null);

          $gigya = $this->getGigya();
          $time = time();
          $basestring = $time . "_" . $user->getId();
          $uidSig = $gigya->calcSignature( $basestring, $gigya->getSecretKey() );
          $response = $gigya->request('socialize.notifyRegistration', array('uid' => $user->getSocial('UID'), 'siteUID' => $user->getId(), 'UIDTimestamp' => $time, 'UIDSig' => $uidSig));

          /*This is debug information by Chris for ET 6990, remove when done */
          $user->setRegSourceAttribute('gigyaReg', $response);
          $user->setRegSourceAttribute('parameters', $user->getSocial('UID'));
          $user->setRegSourceAttribute('siteUID', $user->getId());
          $user->setRegSourceAttribute('UIDTimestamp', $time);
          $user->setRegSourceAttribute('UIDSig', $uidSig);
        }

        $this->setLisCookie($user_data);
        $this->goToReferrer();
      }
    }

    $this->signinForm = new SigninForm();
    $this->passwordForm = new ForgotPasswordForm();
    $this->setTemplate('index');

    /**
     * Omniture
     */
    $reg_stuff = ':' . $this->getUser()->getRegSourceAttribute('code') . ':' . $this->getUser()->getRegSourceAttribute('name');
    $this->getOmniture()->setMany(array(
      'pageName' => 'Registration:Page1' . $reg_stuff,
      'channel' => 'Registration',
      'prop5' => 'registration',
      'eVar9' => 'Registration:Page1' . $reg_stuff,
      'eVar14' => 'Registration'
    ));
  }

  /**
   * What is this for?
   * 
   * @return type 
   */
  protected function getRecipes()
  {
    $module = 'recipe';
    $is_global = 1;
    return RecipeTable::getList(compact('module', 'is_global'));
  }

  /**
   * Executes secure action
   *
   * @param sfWebRequest $request A request object
   */
  public function executeSecure(sfWebRequest $request)
  {
    $this->processReferrer($request);
    $this->getResponse()->setStatusCode(401);
  }

  public function executeGetAuthInfo(sfWebRequest $request)
  {
    $this->forward404Unless($request->isXmlHttpRequest());
    $user_info = array();
    if ($this->getUser()->isAuthenticated()) {
      if ($request->getParameter('type', 'min') == 'full') {
        $user_info = $this->getUser()->getUserData();
      }
      $user_info['is_authenticated'] = true;
    } else {
      $user_info['is_authenticated'] = false;
    }
    return $this->renderText(json_encode($user_info));
  }

  public function executeRefreshUserArea(sfWebRequest $request)
  {
    $this->forward404Unless($request->isXmlHttpRequest());
    $template = $request->getParameter('template', 'header');
    switch ($template) {
      case 'rr':
        return $this->renderPartial('global/right_rail/user_profile');
        break;
      default:
        return $this->renderPartial('global/header_user_area');
    }
  }

  protected function setLisCookie($user_data)
  {
//  set lis cookie for nginx usage (2 for admin 1 for normal user)
    $lis_status = ($user_data['is_admin'] == 1 || $user_data['is_super_admin'] == 1) ? 2 : 1;
    $this->getResponse()->setCookie('lis', $lis_status, time() + sfConfig::get('app_session_ttl'), '/', UrlToolkit::getDomain());
  }

}