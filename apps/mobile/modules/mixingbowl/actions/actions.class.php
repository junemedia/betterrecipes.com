<?php

/**
 * mixingbowl actions.
 *
 * @package    betterrecipes
 * @subpackage mixingbowl
 * @author     Rusty Cage <rcage@resolute.com>
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class mixingbowlActions extends sfActions
{

  public function preExecute()
  {
    $this->rest = $this->getOnesite()->getRest();
    if ($this->getUser()->isAuthenticated()) {
      $this->user_id = $this->getUser()->getOnesiteId();
    } else {
      $this->user_id = null;
    }
  }

 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    $this->popgroups = $this->rest->viewAllGroups(1, 6, 'num_views');
    $this->activity = $this->getActivity();
    
    // meta
    $response = $this->getResponse();
    $response->setTitle('Online Recipes | Share Recipes | Recipe Community | Better Recipes');
    $response->addMeta('description', 'Enjoy online recipes from members of the Mixing Bowl recipe community at Better Recipes. Rate and share recipes, interact with members and more.');
    $response->addMeta('keywords', 'online recipes, share recipes, recipe community');
    
    /**
     * Omniture
     */
    $this->getOmniture()->setMany(array(
      'pageName' => 'Category:MixingBowl',
      'server' => 'www.betterrecipes.com',
      'channel' => 'Mixing Bowl',
      'prop7' => $this->getUser()->isAuthenticated(),
      'prop18' => 'betterrecipes',
      'prop19' => 'Food',
      'prop20' => $this->getRequest()->getUri(),
      'eVar9' => 'Category:MixingBowl',
      'eVar14' => 'Mixing Bowl',
      'eVar24' => $this->getUser()->isAuthenticated(),
    ));
  }
  
  protected function getActivity()
  {
    return $this->rest->getNetworkData();
  }
}
