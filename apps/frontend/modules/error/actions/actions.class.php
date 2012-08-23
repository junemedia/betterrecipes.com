<?php

/**
 * error actions.
 *
 * @package    betterrecipes
 * @subpackage errors
 * @author     Rusty Cage <rcage@resolute.com>
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class errorActions extends sfActions
{

  /**
   * Executes Error404 action
   *
   * @param sfRequest $request A request object
   */
  public function executeError404(sfWebRequest $request)
  {
    $this->getOmniture()->setMany(array(
      'server' => 'www.betterrecipes.com',
      'channel' => '404error',
      'pageType' => 'errorPage',
      'prop5' => '404error',
      'prop12' => ltrim($request->getPathInfo(), '/'),
      'prop18' => 'betterrecipes',
      'prop19' => 'Food',
      'prop20' => $request->getUri(),
      'eVar14' => '404error',
    ));
  }

}
