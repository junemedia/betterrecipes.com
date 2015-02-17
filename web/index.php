<?

// sessions stored on mc2 (rd2) temporarily
//ini_set('session.save_path', "tcp://mc2:11212");

ini_set("session.save_handler", "memcache");  
ini_set("session.save_path", "tcp://127.0.0.1:11211"); 


if (strpos($_SERVER['HTTP_HOST'], 'mixingbowl.com') !== FALSE) {
  if ( ($_SERVER['REQUEST_URI'] == '/') || (substr($_SERVER['REQUEST_URI'],0,2) == '/?') || ($_SERVER['REQUEST_URI'] == '/home/view.castle') ) {
    header('Location: http://betterrecipes.com/mixing-bowl');
    exit;
  }
}


// DISABLED MOBILE SITE:
$app = 'frontend';

// // Device detection
// switch ($_SERVER['DEVICE']) {
//   case 3:  // blackberry
//   case 2:  // tablet
//   case 1:  // mobile
//     $app = 'mobile';
//     break;
//   default: // desktop or unkown
//     $app = 'frontend';
//     break;
// }


require_once($_SERVER['DOCUMENT_ROOT'].'/../config/ProjectConfiguration.class.php');
$configuration = ProjectConfiguration::getApplicationConfiguration($app, ProjectConfiguration::getEnv(), ProjectConfiguration::isDebugging());
sfConfig::set('sf_web_debug', ProjectConfiguration::isDebugging());
sfContext::createInstance($configuration)->dispatch();
