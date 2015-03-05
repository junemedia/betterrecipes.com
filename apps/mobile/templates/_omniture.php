<?
/**
 * This file handles all static omniture, i.e., on page load NOT ajax.
 * 
 * Here we listen for events and other variables that need to be set on the page after the event happened
 */

// Omniture instance for the current request
$omniture = $sf_context->getOmniture();

// -- Start events and additional tracking -- //

// User signed in or signed out
$omniture->set('prop7', $sf_user->isAuthenticated());
$omniture->set('eVar24', $sf_user->isAuthenticated());

// URL
$omniture->set('prop20', $sf_request->getUri());

// Signin or Signup
if ($sf_user->isAuthenticated() && ($sf_user->hasFlash('onSignin') || $sf_user->hasFlash('onSignup'))) {
  // Profile ID - Track commerce activity back to Interactive user profile
  $omniture->set('eVar32', $sf_user->getProfileId());
}

// Signup
if ($sf_user->isAuthenticated() &&  $sf_user->hasFlash('onSignup')) {
  // Registrations - Counts the number of registrations obtained. 
  // 
  // Passed on registration confirmation pages (the page after we gather information deemed a "registration" 
  // - typically defined by an email address and name
  $omniture->addEvent('scRemove:'.$sf_user->getId().':'.$sf_user->getEmail());
  if (($regSource = $sf_user->getRegSource())) {
    // Registration Sources - Reg - Used to track the source of successful registrations
    // 
    // Passed whenever scRemove (Registration event) is passed.
    // Pass the 4-digit registration source followed by the registration source name, as "#RegSource#: #RegSourceName#"
    //
    // The following is assumed: if PAGE_A sends user to registration, page PAGE_A is RegSource
    // Thus, if PAGE_A is RegSource, then PAGE_A.pageName is #RegSourceName#"
    // Therefore, upon successful registration and the user is redirected back to PAGE_A, we can use s.pageName as the #RegSourceName#"
    //
    // The above assumption is wrong. After a successfull registration the user is redirected to Reg Step 2. So #RegSourceName#" needs to be passed by the source page
    $regSourceName = $sf_user->getFlash('regSourceName'); //$omniture->get('pageName'); 
    $omniture->set('eVar6', sprintf('%d:%s', $regSource, $regSourceName));
  }
}

// Signin
if ($sf_user->isAuthenticated() && $sf_user->hasFlash('onSignin')) {
  // Login - Track number of logins
  // Pass "event8" on the page that follows a login
  $omniture->addEvent('event8');
  if (($regSource = $sf_user->getRegSource())) {
    // Registration Source - Traffic - Used to track return visits from registered members to see the lifetime value of specific registration sources.
    // 
    // Pass the original registration source value onto the FIRST PAGE of all visits OR UPON LOGIN. 
    // The format should be #RegSource#: #YYYY#: #MM# where the Year and Month are the date associated with the individual's registration date in the database. 
    // If no registration source exists, do not pass a value. (Can this be passed through Registration Services?)
    $omniture->set('eVar18', sprintf('%d:%s', $regSource, $sf_user->getDateTimeObject('created_at')->format('Y:m')));
  }
}

// newsletter signup
if ($sf_user->isAuthenticated() && $sf_user->hasFlash('onNewsletterSignup')) {
  // Newsletters - Counts the number of newsletter signups obtained. Passed on any page after a newsletter opt-in is selected (such as registration step 2, the roadblock, quick newsletter signup, persistent module, sweepstakes, etc.)
  // 
  // Pass the event "scAdd." When passing this event, also pass s.evar27 (Newsletter Sign-up source) and pass a string in the s.Products variable. 
  // Note: When passing multiple events on the same page, the values should be separated by a dcomma with NO SPACE between the comma and the next entry
  $omniture->addEvent('scAdd');
  // Products - no instructions on this - making assumption based on example (s.products="Magazine;prod70008;1;20.0)
  $omniture->set('products', 'Newsletter:'.implode(';Newsletter:', $sf_user->getFlash('onNewsletterSignup')));
  // Newsletter Signup Source - Track registration source of newsletter signup event only (does not replace original registration source in database)
  // 
  // Pass on any page where the scAdd event is passed (Newsletter Signup). 
  // Pass the registration source of the transaction just completed (NOT the "original" registration source in the database 
  // - and DO NOT update the registration source in the database.
  if ($sf_user->hasFlash('regSourceCode')) {
    $omniture->set('eVar27', $sf_user->getFlash('regSourceCode')); // note how this is different from $sf_user->getRegSource()
  }
}

// On Upload events
if ($sf_user->hasFlash('onUpload')) {
  // Content Upload - Track number of content uploads
  // 
  // Pass "event60" when recipe, video or photo are uploaded.  When passing this event, also pass s.prop 22.
  $omniture->addEvent('event60');
  $omniture->set('prop22', $sf_user->getFlash('onUpload'));
}

// Signout
if ($sf_user->getFlash('onSignout')) {
  // Logout - Track number of logouts
  // 
  // Pass "event9" on the page that follows a logout confirmation
  $omniture->addEvent('event9');
}

// -- END -- //
?>
<!-- ######### START OMNITURE CODE ######### -->
<!-- SiteCatalyst code version: H. Copyright 1997-2006 Omniture, Inc. More info available at http://www.omniture.com -->  
<script type="text/javascript"> 
  
<?= $omniture ?>

/************* DO NOT ALTER ANYTHING BELOW THIS LINE ! **************/ 
<? if($omniture->getAutoload()): ?>var s_code=s.t();<? endif; ?>if(s_code)document.write(s_code)/* ]]> */</script> 
<script type="text/javascript">/* <![CDATA[*/ if(navigator.appVersion.indexOf('MSIE')>=0)document.write(unescape('%3C')+'\!-'+'-') /*]]>*/</script>
<!--##### END OMNITURE CODE ##### -->
