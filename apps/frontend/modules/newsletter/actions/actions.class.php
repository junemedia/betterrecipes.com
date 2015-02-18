<?php

/**
 * newsletter actions.
 *
 * @package    betterrecipes
 * @subpackage newsletter
 * @author     Howe Wang <howe.wang@lionbridge.com>
 */
class newsletterActions extends sfActions
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
   * Executes newsletter signup action
   *
   * @param sfWebRequest $request A request object
   */
  public function executeIndex(sfWebRequest $request)
  {
  	$this->doRedirect = false;
    $this->processReferrer($request);
	$this->email_addr = '';
    if ($this->getUser()->isAuthenticated()) {
      $this->goToReferrer();
    }

//  If socialize cannot find a record for the fb user prepopulate the signin fields from fb data
    if ($request->getParameter('signup_from_fb', null)) {
	
    } else {
      $signup_from_fb = array();
    }

//  meta
    $response = $this->getResponse();
    $response->setTitle('Newsletter Registration | Online Recipes | Online Cookbook | Recipe Contests | Daily Sweepstakes | Better Recipes');

	$error = '';
	$success = '';
    if ($request->isMethod(sfRequest::POST)) {
      if ($request->getParameter('quick_submit',null) == 'Submit') {
		$listid = '';
		//$aJoinListId = $_POST['aJoinListId'];
		$this->email_addr = $request->getParameter('email_addr');
		$email_addr = $this->email_addr;
		
		if (!preg_match("/^[A-Za-z0-9\._-]+[@]{1,1}[A-Za-z0-9-]+[\.]{1}[A-Za-z0-9\.-]+[A-Za-z]$/", $email_addr)) {
			$error = 'Please enter valid email address!';
		} else {
			list($prefix, $domain) = preg_split("/@/",$email_addr);
			if (!getmxrr($domain, $mxhosts)) {
				$error = 'Please enter valid email address!';
			}
		}

		if ($error == '') {
			$listid = '504,505';
			$user_ip = trim($request->getRemoteAddress());
			$subcampid = '4183';

			$posting_url = "http://r4l.popularliving.com/br_api.php?email=$email_addr&ipaddr=".$user_ip."&keycode=if3lkj6i8hjnax&sublists=$listid&subcampid=$subcampid&source=BetterRecipesEmailSignup";
			$response = file_get_contents($posting_url);
			//echo $posting_url.'<br>'.$response;exit;
			
			setcookie("EMAIL_ID", $email_addr, time()+642816000, "/", ".recipe4living.com");
			$plant_cookie = "<img src='http://jmtkg.com/plant.php?email=$email_addr' width='0' height='0'></img>";
			
			$pixel = "<!-- Google Tag Manager -->
					<noscript><iframe src=\"//www.googletagmanager.com/ns.html?id=GTM-PPMDBL\"
					height=\"0\" width=\"0\" style=\"display:none;visibility:hidden\"></iframe></noscript>
					<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
					new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
					j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
					'//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
					})(window,document,'script','dataLayer','GTM-PPMDBL');
					dataLayer.push({'event': 'formsubscriberecipe4living'});</script>
					<!-- End Google Tag Manager -->";
			
			$success = 'Thank you for signing up!'.$plant_cookie.$pixel;			
			$email_addr = '';
			//$aJoinListId = array();
			$this->forward('newsletter', 'thanks');
		}	
      } else {
//      get rid of POST
        $this->redirect('email-signup', 'index');
      }
    }

  }
  
    /**
   * Executes newsletter thanks action
   *
   * @param sfWebRequest $request A request object
   */
  public function executeThanks(sfWebRequest $request)
  {
	$this->success = '';
	if ($request->isMethod(sfRequest::POST)) {
		$this->post_string = "";
		$email_addr = $request->getParameter('email_addr');
		if($email_addr)
		{				
			setcookie("EMAIL_ID", $email_addr, time()+642816000, "/", ".recipe4living.com");
			$plant_cookie = "<img src='http://jmtkg.com/plant.php?email=$email_addr' width='0' height='0'></img>";

			$pixel = "<!-- Google Tag Manager -->
					<noscript><iframe src=\"//www.googletagmanager.com/ns.html?id=GTM-PPMDBL\"
					height=\"0\" width=\"0\" style=\"display:none;visibility:hidden\"></iframe></noscript>
					<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
					new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
					j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
					'//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
					})(window,document,'script','dataLayer','GTM-PPMDBL');
					dataLayer.push({'event': 'formsubscriberecipe4living'});</script>
					<!-- End Google Tag Manager -->";
					
			$this->success = 'Thank you for signing up!'.$plant_cookie.$pixel;
		}
		else
		{
			$this->redirect('signup_newsletter', 'index');
		}		
	}
  }

  
      /**
   * Executes newsletter unsub thanks action
   *
   * @param sfWebRequest $request A request object
   */
  public function executeUnsub(sfWebRequest $request)
  {
	$this->success = '';
	if ($request->isMethod(sfRequest::GET)) {
		$this->post_string = "";
		$email_addr = $request->getParameter('e');
                $this->jid = $request->getParameter('jid');
                $this->lid = $request->getParameter('lid');
		if($email_addr)
		{				
			setcookie("EMAIL_ID", $email_addr, time()+642816000, "/", ".recipe4living.com");
			$plant_cookie = "<img src='http://jmtkg.com/plant.php?email=$email_addr' width='0' height='0'></img>";

			$pixel = "<!-- Google Tag Manager -->
					<noscript><iframe src=\"//www.googletagmanager.com/ns.html?id=GTM-PPMDBL\"
					height=\"0\" width=\"0\" style=\"display:none;visibility:hidden\"></iframe></noscript>
					<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
					new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
					j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
					'//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
					})(window,document,'script','dataLayer','GTM-PPMDBL');
					dataLayer.push({'event': 'formsubscriberecipe4living'});</script>
					<!-- End Google Tag Manager -->";
					
			$this->success = 'Thank you for signing up!'.$plant_cookie.$pixel;
                        $this->email = $email_addr;
		}
		else
		{
			$this->redirect('signup_newsletter', 'index');
		}		
	}
  }
}