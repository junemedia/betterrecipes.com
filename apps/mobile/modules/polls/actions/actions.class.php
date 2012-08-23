<?php

/**
 * polls actions.
 *
 * @package    betterrecipes
 * @subpackage polls
 * @author     Rusty Cage <rcage@resolute.com>
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class pollsActions extends sfActions
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
    // get all polls
    $polls = $this->rest->getPolls($request->getParameter('page', 1), 10);
    if (sizeof($polls) > 0) {
      $this->polls = $polls['items'];
      $this->polls_perPage = $polls['perPage'];
      $this->polls_total = $polls['total'];

      $this->polls_pager = new Arraypager(null, 10);
      $this->polls_pager->setResultTotal($this->polls_total);
      $this->polls_pager->setPage($request->getParameter('page', 1));
      $this->polls_pager->init();
    } else {
      $this->polls = array();
      $this->polls_pager = '';
    }

    // load featured poll
    //$this->poll = $this->rest->loadPoll(258729);

    // meta
    $response = $this->getResponse();
    $response->setTitle('Recipe Polls | Online Polls | Online Recipes | Recipe Community | Better Recipes');
    $response->addMeta('description', 'Whatever your interests, from online recipe questions to cooking tips, use our online polls to get recipe community opinions and share your opinions.');
    $response->addMeta('keywords', 'online recipes, cooking tips, online polls, recipe community');
    
    /**
     * Omniture
     */
    $this->getOmniture()->setMany(array(
      'pageName' => 'Category:Polls',
      'server' => 'www.betterrecipes.com',
      'channel' => 'Polls',
      'prop7' => $this->getUser()->isAuthenticated(),
      'prop18' => 'betterrecipes',
      'prop19' => 'Food',
      'prop20' => $this->getRequest()->getUri(),
      'eVar9' => 'Category:Polls',
      'eVar14' => 'Polls',
      'eVar24' => $this->getUser()->isAuthenticated(),
    ));


  }

  public function executePaginatepolls(sfWebRequest $request)
  {
    $this->forward404Unless($request->isXmlHttpRequest());
    // get all polls
    $p = $this->rest->getPolls($request->getParameter('page', 1), 10);
    if (sizeof($p) > 0) {
      $polls = $p['items'];
      $polls_perPage = $p['perPage'];
      $polls_total = $p['total'];

      $polls_pager = new Arraypager(null, 10);
      $polls_pager->setResultTotal($polls_total);
      $polls_pager->setPage($request->getParameter('page', 1));
      $polls_pager->init();
    } else {
      $polls = array();
      $polls_pager = '';
    }
    $this->renderPartial('poll_list', compact('polls', 'polls_pager'));
    return sfView::NONE;
  }

  public function executeCastvote(sfWebRequest $request)
  {
    $this->forward404Unless($request->isXmlHttpRequest());
    $poll_id = $request->getParameter('poll_id');
    $option_id = $request->getParameter('option_id');
    $this->rest->castVote($poll_id, $option_id);
    $this->result = $this->rest->getPollResults($poll_id);

	/**
     * Omniture
     */
    $this->tracker = $this->getOmniture();
    $this->tracker->setMany(array(
      'pageName' => 'Polls:Detail:Voted',
      'server' => 'www.betterrecipes.com',
      'channel' => 'Polls',
      'prop1' => 'Polls:Detail',
      'prop7' => $this->getUser()->isAuthenticated(),
      'prop18' => 'betterrecipes',
      'prop19' => 'Food',
      'prop20' => $this->getRequest()->getUri(),
      'eVar9' => 'Polls:Detail:Voted',
      'eVar14' => 'Polls',
      'eVar24' => $this->getUser()->isAuthenticated(),
    ));

    $this->renderPartial('results');
    return sfView::NONE;
  }

  public function executeDetail(sfWebRequest $request)
  {
    $this->forward404Unless($poll_id = $request->getParameter('id'));
    $content_id = $request->getParameter('id');
    $this->contentId = $content_id;

    $this->poll = $this->rest->loadPoll($poll_id);
    if (sizeof($this->poll) == 0) {
      $this->forward404();
    }

    // check if a discussion object exists for this journal entry (needed for comment creation and fetching)
    $this->discussionObject = DiscussionTable::getDiscussion(compact('content_id'));
    if ($this->discussionObject) {
      $reset_cache = $this->getUser()->getAttribute('clear_comment_cache', false);
      // fetch comments
      $c = $this->getComments($request->getParameter('page', 1), 9, $this->discussionObject['discussion_id'], $reset_cache);
      $this->comments = $c['items'];
      $this->comments_perPage = $c['perPage'];
      $this->comments_total = $c['total'];

      $this->comments_pager = new Arraypager(null, 9);
      $this->comments_pager->setResultTotal($this->comments_total);
      $this->comments_pager->setPage($request->getParameter('page', 1));
      $this->comments_pager->init();
      if ($reset_cache) {
        $this->getUser()->setAttribute('clear_comment_cache', false);
      }
    } else {
      $this->comments = array();
      $this->comments_pager = '';
    }
    
    // Omniture
    $this->getOmniture()->setMany(array(
      'pageName' => 'Polls:Detail',
      'Server' => 'www.betterrecipes.com',
      'Channel' => 'Polls',
      'prop1' => 'Polls:Detail:',
      'prop7' => $this->getUser()->isAuthenticated() ? true : false,
      'prop18' => 'betterrecipes',
      'prop19' => 'Food',
      'prop20' => $request->getUri(),
      'eVar9' => 'Polls:Detail:',
      'eVar14' => 'Polls',
      'eVar18' => $this->getUser()->isAuthenticated() ? $this->getUser()->getAttribute('regSource') : '',
      'eVar24' => $this->getUser()->isAuthenticated() ? true : false
    ));

  }


  protected function getComments($page, $num, $discussion_id, $reset_cache = false)
  {
    return $this->rest->getComments($page, $num, $discussion_id, 'date_created', 'DESC', $reset_cache);
  }

}
