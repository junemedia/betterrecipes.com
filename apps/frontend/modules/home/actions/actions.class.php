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
    $this->poll = PollTable::getHomepagePoll();
    $this->hpWonder = WondersTable::getHomepageWonder();
    $this->categoryWonder = CategoryWondersTable::getWonder();

    // meta
    $response = $this->getResponse();
    $response->setTitle('Online Recipes | Online Cookbook | Recipe Contests | Daily Sweepstakes | Better Recipes');
    $response->addMeta('description', 'Better Recipes is the premier online cookbook and recipe community. Sign up to share online recipes, enter recipe contests, daily sweepstakes and more.');
    $response->addMeta('keywords', 'online recipes, online cookbook, recipe community, recipes, recipe contests, daily sweepstakes, share recipes');
    /**
     * Omniture
     */

    if( $this->getUser()->isAuthenticated() && $this->getUser()->getFbId() && $this->getUser()->getRegSourceAttribute('auth_token') )
    {
      $facebook_helper = new Facebook_helper($this->getGigya(), $this->getUser());
      $this->friends = $facebook_helper->get_friends_ids_using_app();
    }

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

  public function executeCastvote(sfWebRequest $request)
  {
    $this->forward404Unless($request->isXmlHttpRequest());
    $poll_id = $request->getParameter('poll_id');
    $option_id = $request->getParameter('option_id');
    PollTable::voteForPoll($poll_id);
    PollOptionTable::voteForPollOption($option_id);
    $result = PollTable::getPollDetails($poll_id);
    $this->renderPartial('vote_results', compact('result'));
    return sfView::NONE;
  }
  
}