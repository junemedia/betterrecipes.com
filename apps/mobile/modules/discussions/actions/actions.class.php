<?php

/**
 * discussions actions.
 *
 * @package    betterrecipes
 * @subpackage discussions
 * @author     Rusty Cage <rcage@resolute.com>
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class discussionsActions extends sfActions
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
    // retrieve list of discussions
    $r = $this->getDiscussions($request->getParameter('page', 1), 10, 'date', 'DESC');
    if (sizeof($r) > 0) {
      $this->recent = $r['items'];
      $this->recent_perPage = $r['perPage'];
      $this->recent_total = $r['total'];

      $this->recent_pager = new Arraypager(null, 10);
      $this->recent_pager->setResultTotal($this->recent_total);
      $this->recent_pager->setPage($request->getParameter('page', 1));
      $this->recent_pager->init();
    } else {
      $this->recent = array();
      $this->recent_pager = '';
    }

    $p = $this->getDiscussions($request->getParameter('page', 1), 10, 'num_views', 'DESC');
    if (sizeof($p) > 0) {
      $this->popular = $p['items'];
      $this->popular_perPage = $p['perPage'];
      $this->popular_total = $p['total'];

      $this->popular_pager = new Arraypager(null, 10);
      $this->popular_pager->setResultTotal($this->popular_total);
      $this->popular_pager->setPage($request->getParameter('page', 1));
      $this->popular_pager->init();
    } else {
      $this->popular = array();
      $this->popular_pager = '';
    }

    // meta
    $response = $this->getResponse();
    $response->setTitle('Better Recipes Discussions | Online Recipes | Cooking Tips | Better Recipes');
    $response->addMeta('description', 'Share your thoughts on online recipes or cooking topics or ask fellow cookers, bakers and eaters for their cooking tips. Join in the discussion today!');
    $response->addMeta('keywords', 'online recipes, recipe community, cooking tips');

    /**
     * Omniture
     */
    $this->getOmniture()->setMany(array(
      'pageName' => 'Category:Discussions',
      'server' => 'www.betterrecipes.com',
      'channel' => 'Discussions',
      'prop7' => $this->getUser()->isAuthenticated(),
      'prop18' => 'betterrecipes',
      'prop19' => 'Food',
      'prop20' => $this->getRequest()->getUri(),
      'eVar9' => 'Category:Discussions',
      'eVar14' => 'Discussions',
      'eVar24' => $this->getUser()->isAuthenticated(),
    ));
  }

  public function executePaginate_recent_discussion(sfWebRequest $request)
  {
    $this->forward404Unless($request->isXmlHttpRequest());
    $r = $this->getDiscussions($request->getParameter('page', 1), 10, 'date', 'DESC');
    if (sizeof($r) > 0) {
      $recent = $r['items'];
      $recent_perPage = $r['perPage'];
      $recent_total = $r['total'];

      $recent_pager = new Arraypager(null, 10);
      $recent_pager->setResultTotal($recent_total);
      $recent_pager->setPage($request->getParameter('page', 1));
      $recent_pager->init();
    } else {
      $recent = array();
      $recent_pager = '';
    }
    if ($this->getUser()->isAuthenticated()) {
      $user_id = $this->getUser()->getOnesiteId();
    } else {
      $user_id = null;
    }

    $this->renderPartial('discussions_recent', compact('recent', 'recent_pager', 'user_id'));
    return sfView::NONE;
  }

  public function executePaginate_popular_discussion(sfWebRequest $request)
  {
    $this->forward404Unless($request->isXmlHttpRequest());
    $p = $this->getDiscussions($request->getParameter('page', 1), 10, 'num_views', 'DESC');
    if (sizeof($p) > 0) {
      $popular = $p['items'];
      $popular_perPage = $p['perPage'];
      $popular_total = $p['total'];

      $popular_pager = new Arraypager(null, 10);
      $popular_pager->setResultTotal($popular_total);
      $popular_pager->setPage($request->getParameter('page', 1));
      $popular_pager->init();
    } else {
      $popular = array();
      $popular_pager = '';
    }
    if ($this->getUser()->isAuthenticated()) {
      $user_id = $this->getUser()->getOnesiteId();
    } else {
      $user_id = null;
    }

    $this->renderPartial('discussions_popular', compact('popular', 'popular_pager', 'user_id'));
    return sfView::NONE;
  }

  protected function getDiscussions($page, $num, $sort_key, $sort_order)
  {
    return $this->rest->getNetworkThreads($page, $num, $sort_key, $sort_order, null, null, 1);
  }

}
