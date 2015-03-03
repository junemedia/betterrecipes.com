<?php

/**
 * contests actions.
 *
 * @package    betterrecipes
 * @subpackage contests
 * @author     Rusty Cage <rcage@resolute.com>
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class contestsActions extends sfActions
{
  /*
   * Preexecute Method
   * Sets up Onesite Rest API calls
   * Sets up User's Onesite ID
   */

  public function preexecute()
  {
    $this->rest = $this->getOnesite()->getRest();
    if ($this->getUser()->isAuthenticated()) {
      $this->user_id = $this->getUser()->getOnesiteId();
    } else {
      $this->user_id = null;
    }
  }

  public function executeIndex(sfWebRequest $request)
  {
    $this->activeContests = ContestTable::getActiveContests()->execute();

    $this->contestWinners = new sfDoctrinePager('Contestant', 20);
    $this->contestWinners->setQuery(ContestantTable::getAllPastWinners());
    $this->contestWinners->setPage($request->getParameter('page'), 1);
    $this->contestWinners->init();

    $this->previous_contests = new sfDoctrinePager('Contest', 10);
    $this->previous_contests->setQuery(ContestTable::getPreviousContests());
    $this->previous_contests->setPage($request->getParameter('page'), 1);
    $this->previous_contests->init();

    //Meta Data
    $response = $this->getResponse();
    $response->setTitle('Online Contests | Recipe Contests | Online Recipes | Better Recipes');
    $response->addMeta('description', 'Do you have prize-winning online recipes? Enter your favorite recipe in one of our weekly online recipe contests for a chance to win cash prizes!');
    $response->addMeta('keywords', 'recipe contests, online recipes, online contests');
    // Omniture
      $this->getOmniture()->setMany(array(
      'pageName' => 'Category:Contest',
      'server' => 'www.betterrecipes.com',
      'Channel' => 'Contest',
      'prop7' => $this->getUser()->isAuthenticated(),
      'prop18' => 'betterrecipes',
      'prop19' => 'Food',
      'prop20' => $request->getUri(),
      'eVar9' => 'Category:Contest',
      'eVar14' => 'Contest',
      'eVar18' => $this->getUser()->isAuthenticated() ? $this->getUser()->getAttribute('regSource') : '',
      'eVar24' => $this->getUser()->isAuthenticated()
      )); 

    $this->resetTimezoneEST();
  }

  public function executeDetail(sfWebRequest $request)
  {
    $this->forward404Unless($this->contest = Doctrine_Core::getTable('Contest')->createQuery('c')->where('slug = ?', $request->getParameter('slug'))->fetchOne(), sprintf('Object contest does not exist (%s).', $request->getParameter('slug')));
    $this->sponsor = $this->contest->getSponsor();
    $this->currentContestPeriod = ContestPeriodTable::getCurrentContestPeriod($this->contest->getId());
    //Contestants entered into contest
    $this->contestants = new sfDoctrinePager('Contestant', 10);
    $this->contestants->setQuery(ContestantTable::getContestantsByContest($this->contest->getId()));
    $this->contestants->setPage($request->getParameter('page'), 1);
    $this->contestants->init();

    $this->contestId = $this->contest->getId();

    //Message - after submitting recipe to contest
    $this->msg = $this->getUser()->getFlash('msg');

    //Meta Data
    $response = $this->getResponse();
    $response->setTitle($this->contest->getTitleTag());
    $response->addMeta('description', $this->contest->getSummary());
    $response->addMeta('keywords', $this->contest->getKeywords());
    // Omniture
     $this->getOmniture()->setMany(array(
      'pageName' => 'Category:'.$this->contest->getName(),
      'server' => 'www.betterrecipes.com',
      'Channel' => 'Contest',
      'prop1' => 'Contest:Detail',
      'prop7' => $this->getUser()->isAuthenticated() ? true : false,
      'prop11' => ($this->contest->getSponsor()->getName()) ? $this->contest->getSponsor()->getName() : '',
      'prop18' => 'betterrecipes',
      'prop19' => 'Food',
      'prop20' => $request->getUri(),
      'eVar9' => 'Contest:'.$this->contest->getName(),
      'eVar14' => 'Contest',
      'eVar18' => $this->getUser()->isAuthenticated() ? $this->getUser()->getAttribute('regSource') : '',
      'eVar24' => $this->getUser()->isAuthenticated() ? true : false,
      )); 
  }

  public function executePaginate_contestants(sfWebRequest $request)
  {
    $this->forward404Unless($request->isXmlHttpRequest());
    $contestants = new sfDoctrinePager('Contestant', 10);
    $contestants->setQuery(ContestantTable::getContestantsByContest($request->getParameter('contestId')));
    $contestants->setPage($request->getParameter('page'), 1);
    $contestants->init();

    $contestId = $request->getParameter('contestId');
    $this->renderPartial('recipeEntries', compact('contestants', 'contestId'));
    return sfView::NONE;
  }

  public function executeRules(sfWebRequest $request)
  {
    $this->forward404Unless($this->contest = Doctrine_Core::getTable('Contest')->createQuery('c')->where('slug = ?', $request->getParameter('slug'))->fetchOne(), sprintf('Object contest does not exist (%s).', $request->getParameter('slug')));

    //Breadcrumbs
    /* $this->bread_crumbs = array(
      'better recipes' => UrlToolkit::getDomainUri(),
      'contests' => UrlToolkit::getDomainUri().'/contests',
      strtolower($this->contest->getName()) => UrlToolkit::getDomainUri().'/contests/'.$this->contest->getSlug(),
      'official rules' => null
      ); */
  }

  public function executePastWinners(sfWebRequest $request)
  {

    $this->pastWinners = new sfDoctrinePager('Contestant', 10);
    $this->pastWinners->setQuery(ContestantTable::getAllPastWinners());
    $this->pastWinners->setPage($request->getParameter('page'), 1);
    $this->pastWinners->init();

    $this->resetTimezoneEST();

    //Breadcrumbs
    /* $this->bread_crumbs = array(
      'better recipes' => UrlToolkit::getDomainUri(),
      'contests' => UrlToolkit::getDomainUri() . '/contests',
      'past winners' => null
      ); */
  }

  public function executePaginate_pastwinners(sfWebRequest $request)
  {
    $this->forward404Unless($request->isXmlHttpRequest());
    $pastWinners = new sfDoctrinePager('Contestant', 10);
    $pastWinners->setQuery(ContestantTable::getAllPastWinners());
    $pastWinners->setPage($request->getParameter('page'), 1);
    $pastWinners->init();
    $this->renderPartial('pastWinners', compact('pastWinners'));
    return sfView::NONE;
  }

  public function executePastContests(sfWebRequest $request)
  {
    $this->past_contests = new sfDoctrinePager('Contest', 10);
    $this->past_contests->setQuery(ContestTable::getPreviousContests());
    $this->past_contests->setPage($request->getParameter('page'), 1);
    $this->past_contests->init();

    $this->resetTimezoneEST();

    //Breadcrumbs
    /* $this->bread_crumbs = array(
      'better recipes' => UrlToolkit::getDomainUri(),
      'contests' => UrlToolkit::getDomainUri() . '/contests',
      'past contests' => null
      ); */
  }

  public function executePaginate_pastcontests(sfWebRequest $request)
  {
    $this->forward404Unless($request->isXmlHttpRequest());
    $past_contests = new sfDoctrinePager('Contest', 10);
    $past_contests->setQuery(ContestTable::getPreviousContests());
    $past_contests->setPage($request->getParameter('page'), 1);
    $past_contests->init();
    $this->renderPartial('pastContests', compact('past_contests'));
    return sfView::NONE;
  }

  public function executeEnterContest(sfWebRequest $request)
  {
    $this->contestId = $request->getParameter('id');
    $contest = Doctrine_Core::getTable('Contest')->createQuery('c')->where('c.id = ?', $this->contestId)->fetchOne();
    $contestPeriod = ContestPeriodTable::getCurrentContestPeriod($request->getParameter('id'));

    //Parameters
    $recipeId = $request->getParameter('recipe_id');
    $type = $request->getParameter('type');
    $new_recipe = $request->getParameter('new_recipe');

    // Check user authentication
    if (is_null($this->user_id)) {
      $this->getUser()->setReferrer(UrlToolkit::getDomainUri() . $this->generateUrl('contests_detail', array('slug' => $contest->getSlug())));
      $this->redirect('@signin');
    }

    $addToContest = false;

    $existsInContest = Doctrine_Core::getTable('Contestant')->createQuery('c')->where('c.contest_id = ?', $this->contestId)->andWhere('c.recipe_id = ?', $recipeId)->fetchArray();
    $existsInOtherContest = Doctrine_Core::getTable('Contestant')->createQuery('c')->where('c.contest_id != ?', $this->contestId)->andWhere('c.recipe_id = ?', $recipeId)->fetchArray();
    if ($contest->isCurrent() == false) {
      if ($contest->isOver()) {
        $this->getUser()->setFlash('msg', 'This contest has ended.');
      } else {
        $this->getUser()->setFlash('msg', 'This contest has not started yet.');
      }
    } else if (count($existsInContest) > 0 && $new_recipe != 1) { //Check if recipe already exists in contest
      $this->getUser()->setFlash('msg', 'This recipe has already been entered into this contest.');
    } else if (count($existsInOtherContest) > 0) { //Check if recipe already exists in another contest       
      $this->getUser()->setFlash('msg', 'This recipe has already been entered into another contest.');
    } else {
      if (!empty($recipeId) && $new_recipe != 1)
        $addToContest = true;
      else if ($new_recipe == 1)
        $this->getUser()->setFlash('msg', 'This recipe has been successfully entered into the contest!');
    }

    if ($addToContest) {
      //Add to contest
      $contestant = new Contestant();
      $contestant->setContestId($this->contestId);
      $contestant->setRecipeId($recipeId);
      $userId = Doctrine_Core::getTable('Recipe')->find($recipeId)->getUserId();
      $contestant->setUserId($userId);
      //Set Rank
      $numContesants = count(Doctrine_Core::getTable('Contestant')->createQuery('c')->where('c.contest_id = ?', $this->contestId)->fetchArray());
      $contestant->setRank($numContesants + 1);
      $contestant->save();
      $this->getUser()->setFlash('msg', 'This recipe has been successfully entered into the contest!');
    }

    $this->redirect(UrlToolkit::getDomainUri() . '/contests/' . $contest->getSlug());
  }

  public function executeAutocomplete(sfWebRequest $request)
  {
    $this->forward404Unless($request->isXmlHttpRequest());
    sfView::NONE;
    $text = $request->getParameter('textField');
    $userId = $request->getParameter('userId');

    $results = Doctrine_Query::create()->select('id, name')->from('Recipe r')->where('r.name LIKE ?', "%" . $text . "%")->leftJoin('r.User u')->andWhere('u.onesite_id = ?', $userId)->limit(10)->fetchArray();

    foreach ($results as $r) {
      $r['id'] = (int) $r['id'];
      $r['name'] = $r['name'];
      $autoArray[] = $r;
    }

    return $this->renderText(json_encode($autoArray));
  }

  private function resetTimezoneEST()
  {
    date_default_timezone_set(timezone_name_from_abbr("EST"));
  }

}
