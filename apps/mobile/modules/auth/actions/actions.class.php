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
    $default = $this->getUser()->isAuthenticated() ? UrlToolkit::getRoute($this->getUser()->getUserData()) : $this->generateUrl('homepage');
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

//    echo '<p> MATCH: '.$this->getUser()->getRegSourceAttribute('code').'</p>';
//    echo '<p> MATCH: '.$this->getUser()->getRegSourceAttribute('name').'</p>';
//    return $this->getUser()->getRegSourceAttribute('code');
  }

  /**
   * Executes signup action ig sf_method = GET
   *
   * @param sfWebRequest $request A request object
   */
  public function executeIndex(sfWebRequest $request)
  {
    $this->processReferrer($request);
    if ($this->getUser()->isAuthenticated()) {
      $this->goToReferrer();
    }

    // meta
    $response = $this->getResponse();
    $response->setTitle('Sign Up | Share Recipes | Daily Sweepstakes | Recipe Contests | Better Recipes');
    $response->addMeta('description', 'Sign up at Better Recipes to submit and share your favorite online recipes, enter daily sweepstakes and recipe contests and join our recipe community!');
    $response->addMeta('keywords', 'online recipes, share recipes, daily sweepstakes, recipe contests, recipe community');

    //$this->signinForm = new SigninForm();
    $this->signupForm = new SignupForm();
    //$this->passwordForm = new ForgotPasswordForm();

    if ($request->isMethod(sfRequest::POST)) {
      if ($request->hasParameter($this->signupForm->getName())) {
        $this->forward('auth', 'signup');
      } else {
        // get rid of POST
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
   * Executes signin action ig sf_method = GET
   *
   * @param sfWebRequest $request A request object
   */
  public function executeLogin(sfWebRequest $request)
  {
    $this->processReferrer($request);
    if ($this->getUser()->isAuthenticated()) {
      $this->goToReferrer();
    }

    // meta
    $response = $this->getResponse();
    $response->setTitle('Sign In | Share Recipes | Daily Sweepstakes | Recipe Contests | Better Recipes');
    $response->addMeta('description', 'Sign in at Better Recipes to submit and share your favorite online recipes, enter daily sweepstakes and recipe contests and join our recipe community!');
    $response->addMeta('keywords', 'online recipes, share recipes, daily sweepstakes, recipe contests, recipe community');

    $this->signinForm = new SigninForm();
    //$this->signupForm = new SignupForm();
    $this->passwordForm = new ForgotPasswordForm();

    if ($request->isMethod(sfRequest::POST)) {
      if ($request->hasParameter($this->signinForm->getName())) {
        $this->forward('auth', 'signin');
      } elseif ($request->hasParameter($this->passwordForm->getName())) {
        $this->forward('auth', 'forgotPassword');
      } else {
        // get rid of POST
        $this->redirect('auth', 'login');
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

    // destroy the 'DYN_USER_ID' cookie for Krux
    $this->getResponse()->setCookie('DYN_USER_ID', '', time() - 3600, '/', UrlToolkit::getDomain());

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
    /*
      $this->processReferrer($request);
      if (!$request->isMethod(sfRequest::POST))
      $this->forward('auth', 'index');
     */

    $this->processReferrer($request);
    if (!$request->isMethod(sfRequest::POST))
      $this->forward('auth', 'login');

    $this->signinForm = new SigninForm();
    $this->signinForm->bind($request->getParameter($this->signinForm->getName()));

    if ($this->signinForm->isValid()) {
      $values = $this->signinForm->getValues();
      $this->getUser()->signin($values['user'], false);
      $this->getUser()->setFlash('onSignin', true);

      if ($request->getParameter('social') && ($provider_name = $this->getUser()->getSocial('loginProvider'))) {
        $userProvider = new UserProvider();
        $userProvider->fromArray(array(
          'user_id' => $this->getUser()->getId(),
          'provider' => $provider_name,
          'provider_uid' => $this->getUser()->getSocial('loginProviderUID'),
          'created_at' => date('Y-m-d H:i:s')
        ));
        $userProvider->save();
      }
      $this->setLisCookie($values);
      $this->goToReferrer();
    }

    $this->signupForm = new SignupForm();
    $this->passwordForm = new ForgotPasswordForm();
    $this->setTemplate('login');
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
    $this->processReferrer($request);
    // http://www.YourSite.com/PostLoginPage.htm?zip=&UID=123&photoURL=&nickname=John%20Doe&profileURL=&
    // birthMonth=10&loginProvider=twitter&loginProviderUID=65e&country=&thumbnailURL=&lastName=Esh&
    // signature=pEqAFOUHRiAOjac9z%2FdoHlzNCbU%3D&firstName=John&provider=twitter&gender=&birthYear=1965&
    // timestamp=2009%2D12%2D08%2015%3A53%3A45&UIDSig=&state=&email=&city=&birthDay=11&proxiedEmail=

    $this->social = $request->getGetParameters();

    foreach ($this->social as $key => $value) {
      $this->getUser()->setSocial($key, $value);
    }

    $gigya = $this->getGigya();

    $valid = Gigya::validateUserSignature(
        $this->getUser()->getSocial('UID'), $this->getUser()->getSocial('signatureTimestamp'), $gigya->getSecretKey(), $this->getUser()->getSocial('UIDSignature')
    );

    if (!$valid) {
      $this->getUser()->clearSocial();
      $this->getUser()->setFlash('error', sprintf('There was a problem contacting %s. You can still login/register with a normal account and link your %s account later.'), $this->getUser()->getSocial('provider'), $this->getUser()->getSocial('provider'));
      $this->redirect(UrlToolkit::getSigninUri());
    }

    $user = UserTable::getInstance()->createQuery('user')
      ->innerJoin('user.UserProvider up')
      ->where('up.provider = ? AND up.provider_uid = ?')
      ->limit(1)
      ->fetchOne(array(
      $this->getUser()->getSocial('loginProvider'),
      $this->getUser()->getSocial('loginProviderUID')
      ));

    if ($user) {
      // user is automatically logged in
      // use Onesite mk_user_session_data
      $response = $this->getOnesite()->getRpc()->mkUserSessionData($user->getEmail());
      if ($response[0] === true) {
        // set lls cookie for nginx usage
        if (!$this->getRequest()->getCookie('lis')) {
          $this->getResponse()->setCookie('lis', 1, 0, '/', UrlToolkit::getDomain());
        }
        // set DYN_USER_ID cookie for Krux
        if (!$this->getRequest()->getCookie('DYN_USER_ID')) {
          $this->getResponse()->setCookie('DYN_USER_ID', $this->getUser()->getId(), 0, '/', UrlToolkit::getDomain());
        }
        $this->getUser()->signin($user);
        $this->getUser()->setFlash('onSignin', true);
        $this->goToReferrer();
      } else {
        /** @todo verify the reason why the session was not set. Could be the user has been banned, etc */
        $this->getUser()->setFlash('error', 'There was an error creating your session. Please try again later.');
      }
    }

    $this->passwordForm = new SigninForm(array(
        'email' => $this->getUser()->getSocial('email')
      ));
    $this->signinForm = new SigninForm(array(
        'email' => $this->getUser()->getSocial('email')
      ));
    $this->signupForm = new SignupForm(array(
        'display_name' => $this->getUser()->getSocial('nickname'),
        'email' => $this->getUser()->getSocial('email'),
        'firstname' => $this->getUser()->getSocial('firstName')
      ));
  }

  /**
   * Executes signup action
   *
   * @param sfWebRequest $request A request object
   */
  public function executeSignup(sfWebRequest $request)
  {
    $this->processReferrer($request);
    if (!$request->isMethod(sfRequest::POST))
      $this->forward('auth', 'index');

    $this->signupForm = new SignupForm();
    $this->signupForm->bind($request->getParameter($this->signupForm->getName()));

    if ($this->signupForm->isValid()) {
      $user_data = $this->signupForm->signup();
      if ($user_data) {
        $user_data['reg_source'] = $this->getUser()->getRegSourceAttribute('code');

        $this->getUser()->setFlash('regSourceCode', $user_data['reg_source']);
        $this->getUser()->setFlash('regSourceName', $this->getUser()->getRegSourceAttribute('name'));
        $this->getUser()->removeRegSourceAttribute();

        $this->getUser()->signin($user_data, false);
        $this->getUser()->setFlash('onSignup', true);
        $this->getUser()->setFlash('onSignin', true);

        $values = $this->signupForm->getValues();
        if (!empty($values['newsletter_ids'])) {
          $this->getUser()->setFlash('onNewsletterSignup', $values['newsletter_ids']);
        }

        if ($request->getParameter('social') && ($provider_name = $this->getUser()->getSocial('loginProvider'))) {
          $userProvider = new UserProvider();
          $userProvider->fromArray(array(
            'user_id' => $this->getUser()->getId(),
            'provider' => $provider_name,
            'provider_uid' => $this->getUser()->getSocial('loginProviderUID'),
            'created_at' => date('Y-m-d H:i:s')
          ));
          $userProvider->save();
        }
        $this->setLisCookie($values);
        //$this->redirect('signup_step2'); // go to step 2 but dont change the referrer
        // note: not sure if mobile app will require user to fill out extended profile (step2) or simply redirect to referrer
        $this->processReferrer($request);
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
   * Executes signup action
   *
   * @param sfWebRequest $request A request object
   */
  public function executeSignupStep2(sfWebRequest $request)
  {
    $this->processReferrer($request);
    if (!$this->getUser()->isAuthenticated()) {
      $this->redirect('@signin');
    }

    $this->user = $this->getUser()->getUserData();
    $this->form = new SignupStep2Form($this->user);

    if ($request->isMethod(sfRequest::POST)) {
      $this->form->bind($request->getParameter($this->form->getName()), $request->getFiles($this->form->getName()));

      if ($this->form->isValid() && $this->form->save()) {
        $regSource = $this->getUser()->getFlash('regSourceCode');
        if (!in_array($regSource, array(8273, 8260))) {
          $this->goToReferrer();
        }
        $this->redirect('signup_step3'); // got to step 3 but dont change referrer
      }
    }

    /**
     * Omniture
     */
    $reg_stuff = $this->getUser()->getRegSourceAttribute('code') . ':' . $this->getUser()->getRegSourceAttribute('name');
    $this->getOmniture()->setMany(array(
      'pageName' => 'Registration:Page2:' . $reg_stuff,
      'channel' => 'Registration',
      'prop5' => 'registration',
      'eVar9' => 'Registration:Page2:' . $reg_stuff,
      'eVar14' => 'Registration'
    ));
  }

  /**
   * Executes signup action
   *
   * @param sfWebRequest $request A request object
   */
  public function executeSignupStep3(sfWebRequest $request)
  {
    $this->processReferrer($request);
    $this->referrer = $this->getReferrer(true);

    if (!$this->referrer) {
      $this->referrer = $this->generateUrl('cook_profile', $this->getUser()->getUserData());
    }

    $this->getUser()->setReferrer(null);

    $this->rest = $this->getOnesite()->getRest();
    $this->popgroups = $this->rest->viewAllGroups(1, 4, 'num_views');
    $this->recipes = $this->getRecipes();

    /**
     * Omniture
     */
    $this->getOmniture()->setMany(array(
      'pageName' => 'Welcome to Better Recipes',
      'server' => 'www.betterrecipes.com',
      'channel' => 'Community',
      'eVar9' => 'Welcome to Better Recipes',
      'eVar14' => 'Community',
    ));
  }

  /**
   * Used to skip steps in the signup and redirect user to referrer.
   *
   * @param sfWebRequest $request
   */
  public function executeSignupSkip(sfWebRequest $request)
  {
    $this->processReferrer($request);
    $this->goToReferrer();
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

  public function executeTestonesite($request)
  {
    sfConfig::set('sf_web_debug', false);

    $rpc = $this->getOnesite()->getRpc();
    $rest = $this->getOnesite()->getRest();

//    $response = $rpc->mkUserSessionData('bkuberek@resolute.com');
//    $this->renderText(print_r($response, true));
//    $response = $rest->newMsgCount('117796290');
//    $this->renderText(PHP_EOL.str_repeat('=', 80).PHP_EOL);
//    $this->renderText(PHP_EOL.'VIEW USER DETAIL'.PHP_EOL);
//    $this->renderText(PHP_EOL.str_repeat('=', 80).PHP_EOL);
//    $response = $rest->viewUserDetail(117796290);
//    $this->renderText(print_r($response, true));
//
//    $this->renderText(PHP_EOL.str_repeat('=', 80).PHP_EOL);
//    $this->renderText(PHP_EOL.'NEW USER DATA'.PHP_EOL);
//    $this->renderText(PHP_EOL.str_repeat('=', 80).PHP_EOL);
//    $user_profile_fields = array(
//        'profile_id' => '3513241781',
//        'firstname' => 'Simao',
//        'lastname' => 'Brandao Kuberek',
//        'password' => 'bkuberek123',
//        'address1' => '424 W 33rd Street',
//        'address2' => 'Suite 420',
//        'city' => 'New York',
//        'state' => 'NY',
//        'country' => 'US',
//        'postalcode' => '10032',
//        'about_me' => 'This is my about me line!',
//        'email' => 'bkuberek@resolute.com'
//    );
//    $this->renderText(print_r($user_profile_fields, true));
//
//    $this->renderText(PHP_EOL.str_repeat('=', 80).PHP_EOL);
//    $this->renderText(PHP_EOL.'REST.updateUser'.PHP_EOL);
//    $this->renderText(PHP_EOL.str_repeat('=', 80).PHP_EOL);
//    $response = $rest->updateUserProfile($user_profile_fields);
//    $this->renderText('<pre>'.print_r($response, true).'</pre>');
//
//    $this->renderText(PHP_EOL.str_repeat('=', 80).PHP_EOL);
//    $this->renderText(PHP_EOL.'VIEW USER DETAIL'.PHP_EOL);
//    $this->renderText(PHP_EOL.str_repeat('=', 80).PHP_EOL);
//    $response = $rest->viewUserDetail(117796290);
//    $this->renderText(print_r($response, true));
//
//    $response = $rest->viewUserExtendedProfile('117276270');
//    $this->renderText('<pre>'.print_r($response, true).'</pre>');
//    return sfView::NONE;
    // test record data
//
//    $user = UserTable::getInstance()->createQuery('user')
//            ->select('user.id, user.display_name, 12345 as number')
//            ->where('user.display_name = ?', 'bkuberek')
//            ->limit(1)
//            ->fetchOne();
//
//    echo $user->getNumber();
//
//    $user->exposeData();
//    die;
//    // test User hydration
//    $user = $this->getUser()->getUser();
//    var_dump($user->state());
//    $user->exposeData();
////    $this->renderText('<pre>'.print_r($user->toArray(), true).'</pre>');
//    return sfView::NONE;
    // bkuberek = 116599141
    // test = 116586796
    // larry = 116599151
    // test login
//    $response = $rest->getNetworkTiers();
//    $this->renderText('<pre>'.print_r($response, true).'</pre>');
//    $response = $rest->getUserTiers('116599141');
//    $this->renderText('<pre>'.print_r($response, true).'</pre>');
//    $rest->userLogin('Kim.Steffens@meredith.com', 'ksteffens123');
//    $this->renderText('<pre>'.print_r($rest->getLastResponse(), true).'</pre>');
//    return sfView::NONE;
//
//
//    $response = $rpc->emailCheck('bkuberek@resolute.com');
//    $this->renderText("emailcheck\n".'<pre>'.print_r($response, true).'</pre>');
//
//    $response = $rpc->subdirCheck('bkuberek');
//    $this->renderText("subfircheck\n".'<pre>'.print_r($response, true).'</pre>');
//
//    $response = $rpc->userCheck('bkuberek@resolute.com');
//    $this->renderText("usercheck\n".'<pre>'.print_r($response, true).'</pre>');
//
//    return sfView::NONE;
//    $this->renderText('<pre>'.print_r($rest->getLastResponse(), true).'</pre>');
//    return sfView::NONE;
//    // test registration
//    $this->getResponse()->setHttpHeader('Content-Type', 'text/xml');
//
//    $user = substr(md5(mt_rand(0, 9999999999)), 0, 10);
//    ob_start();
//    $response = $rest->userRegister(array(
//        'email' => $user.'.test@resolute.com',
//        'subdir_url' => $user,
//        'password' => '12345',
//        'firstname' => 'Test',
//        'lastname' => 'User',
//        'gender' => 'hybrid',
//        'display_name' => $user,
//        'birth_year' => 1984,
//        'birth_month' => date('m'),
//        'birth_day' => date('d')
//    ));
//    ob_end_flush();
//
//    if ($rest->isError()) {
//      //throw $rest->getLastError();
//
//      echo $response;
//      exit;
//    }
//    $this->renderText('<h2>Test One Site</h2><pre>');
//    $this->renderText('<pre>'.print_r($response, true).'</pre>');
//    $this->renderText(print_r($response, true));
//    $this->renderText(print_r($rpc->getUser('bkuberek@gmail.com'), true));
//    $this->renderText('</pre>');

    return sfView::NONE;
  }

  public function executeGetAuthInfo(sfWebRequest $request)
  {
    $this->forward404Unless($request->isXmlHttpRequest());
    $user_data = array();
    if ($this->getUser()->isAuthenticated()) {
      if ($request->getParameter('type', 'min') == 'full') {
        $user_data = $this->getUser()->getUserData();
      }
      $user_data['is_authenticated'] = true;
    } else {
      $user_data['is_authenticated'] = false;
    }
    return $this->renderText(json_encode($user_data));
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

  // for mobile users, sets cookie so that they can view full site
  public function executeViewfullsite(sfWebRequest $request)
  // note: ffs stands for "force full site"
  {
    if (!$this->getRequest()->getCookie('ffs')) {
      $this->getResponse()->setCookie('ffs', 1, 0, '/', UrlToolkit::getDomain());
    }
    $this->redirect('home/index');
    return sfView::NONE;
  }

  protected function setLisCookie($values)
  {
    // set lis cookie for nginx usage (2 for admin 1 for normal user)
    $lis_status = ($values['user']['is_admin'] == 1) ? 2 : 1;
    $this->getResponse()->setCookie('lis', $lis_status, time() + sfConfig::get('app_session_ttl'), '/', UrlToolkit::getDomain());
    // set the DYN_USER_ID for Krux
    $this->getResponse()->setCookie('DYN_USER_ID', $values['user']['id'], time() + sfConfig::get('app_session_ttl'), '/', UrlToolkit::getDomain());
  }

}