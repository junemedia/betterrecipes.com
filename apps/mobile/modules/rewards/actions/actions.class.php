<?php

/**
 * rewards actions.
 *
 * @package    betterrecipes
 * @subpackage rewards
 * @author     Rusty Cage <rcage@resolute.com>
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class rewardsActions extends sfActions
{

  public function preExecute()
  {
    $this->rest = $this->getOnesite()->getRest();
  }

  /**
   * Executes index action
   *
   * @param sfRequest $request A request object
   */
  public function executeIndex(sfWebRequest $request)
  {
    $this->cooks = $this->rest->getTopUsers(1, 48);
    $this->badges = $this->rest->getNodeBadges();

    // meta
    $response = $this->getResponse();
    $response->setTitle('Rewards | Recipe Community | Share Recipes | Online Recipes | Better Recipes');
    $response->addMeta('description', 'Rewards are our way of saying thanks you as we work together to make Better Recipes the premier community for online recipes and social sharing.');
    $response->addMeta('keywords', 'online recipes, recipe rewards, recipe community, share recipes');

    /**
     * Omniture
     */
    $this->getOmniture()->setMany(array(
      'pageName' => 'Category:Rewards',
      'server' => 'www.betterrecipes.com',
      'channel' => 'Rewards',
      'prop7' => $this->getUser()->isAuthenticated(),
      'prop18' => 'betterrecipes',
      'prop19' => 'Food',
      'prop20' => $this->getRequest()->getUri(),
      'eVar9' => 'Category:Rewards',
      'eVar14' => 'Rewards',
      'eVar24' => $this->getUser()->isAuthenticated(),
    ));
  }

}
