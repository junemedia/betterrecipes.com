<?php

/**
 * home actions.
 *
 * @package    betterrecipes
 * @subpackage home
 * @author     Rusty Cage <rcage@resolute.com>
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class homeActions extends sfActions
{

  /**
   * Executes index action
   *
   * @param sfRequest $request A request object
   */
  public function executeIndex(sfWebRequest $request)
  {
    // If the url has a subdomain with no detail attached forward it to the recipes module.
    $host_parts = explode('.', $request->getHost());
    if (UrlToolkit::getDomain() != $request->getHost() && $host_parts[0] != 'www') {
      $this->forward('recipes', 'category');
    }

    $rest = $this->getOnesite()->getRest();
    $this->popgroups = $rest->viewAllGroups(1, 3, 'num_views');
    $params = array('is_global' => 1, 'is_mobile' => 1);
    $this->recipes = RecipeTable::getList($params);

    // meta
    $response = $this->getResponse();
    $response->setTitle('Online Recipes | Online Cookbook | Recipe Contests | Daily Sweepstakes | Better Recipes');
    $response->addMeta('description', 'Better Recipes is the premier online cookbook and recipe community. Sign up to share online recipes, enter recipe contests, daily sweepstakes and more.');
    $response->addMeta('keywords', 'online recipes, online cookbook, recipe community, recipes, recipe contests, daily sweepstakes, share recipes');
    
    /**
     * Omniture
     */
    $this->getOmniture()->setMany(array(
      'pageName' => 'Category:BetterRecipes.com',
      'Server' => 'www.betterrecipes.com',
      'Channel' => 'Homepage',
      'prop7' => true, // not sure? says true or false in the table
      'prop18' => 'betterrecipes',
      'prop19' => 'Food',
      'prop20' => $request->getUri(),
      'evar9' => 'Category:BetterRecipes.com',
      'evar14' => 'Homepage',
      'evar18' => $this->getUser()->isAuthenticated() ? $this->getUser()->getAttribute('regSource') : '',
      'evar24' => $this->getUser()->isAuthenticated(),
      'evar26' => '', // not sure - Party ID
    ));
  }

}
