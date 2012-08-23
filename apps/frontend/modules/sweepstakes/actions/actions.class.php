<?php

/**
 * sweepstakes actions.
 *
 * @package    betterrecipes
 * @subpackage sweepstakes
 * @author     Rusty Cage <rcage@resolute.com>
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class sweepstakesActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    /* $this->forward('default', 'module'); */
    
    // meta
    $response = $this->getResponse();
    $response->setTitle('Daily Sweepstakes | Online Sweepstakes | Cooking Prizes | Better Recipes');
    $response->addMeta('description', 'Enter our daily sweepstakes for a chance to win quality cooking prizes every day. Cook your favorite online recipes with prizes from our sweepstakes! ');
    $response->addMeta('keywords', 'daily sweepstakes, online sweepstakes, cooking prizes, online recipes');
  }
}
