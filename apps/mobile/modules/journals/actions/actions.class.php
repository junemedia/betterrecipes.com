<?php

/**
 * journals actions.
 *
 * @package    betterrecipes
 * @subpackage journals
 * @author     Rusty Cage <rcage@resolute.com>
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class journalsActions extends sfActions
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
    $reset_cache = $this->getUser()->getAttribute('clear_journal_cache', false);
    // recent 
    $j_recent = $this->getJournals($this->getRequestParameter('page', 1), 10, null, $reset_cache);
    if (sizeof($j_recent) > 0) {
      $this->journal_recent = $j_recent['items'];
      $this->journal_recent_perPage = $j_recent['perPage'];
      $this->journal_recent_total = $j_recent['total'];

      $this->j_recent_pager = new Arraypager(null, 10);
      $this->j_recent_pager->setResultTotal($this->journal_recent_total);
      $this->j_recent_pager->setPage($this->getRequestParameter('page', 1));
      $this->j_recent_pager->init();
    } else {
      $this->journal_recent = array();
      $this->j_recent_pager = '';
    }

    // popular
    $j_popular = $this->getJournals($this->getRequestParameter('page', 1), 10, 'views', $reset_cache);
    if (sizeof($j_popular) > 0) {
      $this->journal_popular = $j_popular['items'];
      $this->journal_popular_perPage = $j_popular['perPage'];
      $this->journal_popular_total = $j_popular['total'];

      $this->j_popular_pager = new Arraypager(null, 10);
      $this->j_popular_pager->setResultTotal($this->journal_popular_total);
      $this->j_popular_pager->setPage($this->getRequestParameter('page', 1));
      $this->j_popular_pager->init();
    } else {
      $this->journal_popular = array();
      $this->j_popular_pager = '';
    }

    if ($reset_cache) {
      $this->getUser()->setAttribute('clear_journal_cache', false);
    }

    // meta
    $response = $this->getResponse();
    $response->setTitle('Journals | Food Journal | Share Recipes | Recipe Community | Better Recipes');
    $response->addMeta('description', 'Get the latest scoop from the Better Recipes community, share recipes, your thoughts, cooking tips and more. Start your food journal today!');
    $response->addMeta('keywords', 'food journal, recipe community, recipes, cooking tips, share recipes');

    /**
     * Omniture
     */
      $this->getOmniture()->setMany(array(
      'pageName' => 'Category:Journals',
      'server' => 'www.betterrecipes.com',
      'channel' => 'Journals',
      'prop7' => $this->getUser()->isAuthenticated(),
      'prop18' => 'betterrecipes',
      'prop19' => 'Food',
      'prop20' => $this->getRequest()->getUri(),
      'eVar9' => 'Category:Journals',
      'eVar14' => 'Journals',
      'eVar24' => $this->getUser()->isAuthenticated(),
      ));
  }

  public function executeDetail(sfWebRequest $request)
  {
    $this->forward404Unless($this->getRequestParameter('id') && $this->getRequestParameter('slug'));
    $content_id = $this->getRequestParameter('id');
    $this->contentId = $content_id;
    $this->journal = $this->getJournal($content_id);

    // increment views on journal entry
    $this->rest->incrementViewsBlog($content_id);

    // check if a discussion object exists for this journal entry (needed for comment creation and fetching)
    $this->discussionObject = DiscussionTable::getDiscussion(compact('content_id'));
    if ($this->discussionObject) {
      $reset_cache = $this->getUser()->getAttribute('clear_comment_cache', false);
      // fetch comments
      $c = $this->getComments($this->getRequestParameter('page', 1), 9, $this->discussionObject['discussion_id'], $reset_cache);
      $this->comments = $c['items'];
      $this->comments_perPage = $c['perPage'];
      $this->comments_total = $c['total'];

      $this->comments_pager = new Arraypager(null, 9);
      $this->comments_pager->setResultTotal($this->comments_total);
      $this->comments_pager->setPage($this->getRequestParameter('page', 1));
      $this->comments_pager->init();

      if ($reset_cache) {
        $this->getUser()->setAttribute('clear_comment_cache', false);
      }
    } else {
      $this->comments = array();
      $this->comments_pager = '';
    }
    $tiers = $this->rest->getUserTiers($this->journal['user_id']);
    $this->sponsored = false;
    if (sizeof($tiers[0]) > 0) {
      for ($i = 0; $i < count($tiers); $i++) {
        if ($tiers[$i]['tierID'] == 34049) {
          $this->sponsored = true;
          break;
        }
      }
    }
    if ($this->sponsored) {
      $sponsor_name = 'Kelloggs';
      $this->sponsor = SponsorTable::getSingleSponsor();
    } else {
      $sponsor_name = '';
      $this->sponsor = null;
    }


    /**
     * Omniture
     */
      $this->getOmniture()->setMany(array(
      'pageName' => 'Journals:Detail:' . $this->journal['display_name'],
      'server' => 'www.betterrecipes.com',
      'channel' => 'Journals',
      'prop1' => 'Journals:Detail',
      'prop7' => $this->getUser()->isAuthenticated(),
      'prop11' => $sponsor_name,
      'prop18' => 'betterrecipes',
      'prop19' => 'Food',
      'prop20' => $this->getRequest()->getUri(),
      'eVar9' => 'Journals:Detail:' . $this->journal['display_name'],
      'eVar14' => 'Journals',
      'eVar24' => $this->getUser()->isAuthenticated(),
      ));
  }

  public function executeAdd(sfWebRequest $request)
  {
    // check user auth
    if (is_null($this->user_id)) {
      $this->getUser()->setReferrer(UrlToolkit::getDomainUri() . $this->getController()->genUrl('@journal_add'));
      $this->redirect('@signin');
    }
    $this->form = new JournaladdForm(array('referrer' => $request->getReferer()));

    if ($request->isMethod('post')) {
      // check user auth
      if (is_null($this->user_id)) {
        $this->getUser()->setReferrer(UrlToolkit::getDomainUri() . $this->getController()->genUrl('@journal_add'));
        $this->redirect('@signin');
      }

      $this->form->bind($request->getParameter('journaladd'));
      if ($this->form->isValid()) {
        // transmit form data to onesite
        $post = $this->rest->addPost($this->user_id, $this->form->getValue('title'), $this->form->getValue('body'));
        if (isset($post['id'])) {
          $this->getUser()->setAttribute('clear_journal_cache', true);
          $this->getUser()->setFlash('notice', 'Your journal entry has been successfully posted.');
          //$return_path = ($this->form->getValue('referrer') != '') ? $this->form->getValue('referrer') :'@journal_add';
          $return_path = '@journal';
          $this->redirect($return_path);
        } else {
          $this->getUser()->setFlash('notice', $post['message']);
        }
      }
    }

    $this->bread_crumbs = array(
      'better recipes' => UrlToolkit::getDomainUri(),
      'journals' => null
    );
  }

  public function executePaginate_recent_journal(sfWebRequest $request)
  {
    $this->forward404Unless($request->isXmlHttpRequest());
    $j_recent = $this->getJournals($this->getRequestParameter('page', 1), 10, null);
    if (sizeof($j_recent['items']) > 0) {
      $journal_recent = $j_recent['items'];
      $journal_recent_perPage = $j_recent['perPage'];
      $journal_recent_total = $j_recent['total'];

      $j_recent_pager = new Arraypager(null, 10);
      $j_recent_pager->setResultTotal($journal_recent_total);
      $j_recent_pager->setPage($this->getRequestParameter('page', 1));
      $j_recent_pager->init();
    } else {
      $journal_recent = array();
      $j_recent_pager = '';
    }
    $this->renderPartial('journals_recent', compact('journal_recent', 'j_recent_pager'));
    return sfView::NONE;
  }

  public function executePaginate_popular_journal(sfWebRequest $request)
  {
    $this->forward404Unless($request->isXmlHttpRequest());
    $j_popular = $this->getJournals($this->getRequestParameter('page', 1), 10, 'views');
    if (sizeof($j_popular['items']) > 0) {
      $journal_popular = $j_popular['items'];
      $journal_popular_perPage = $j_popular['perPage'];
      $journal_popular_total = $j_popular['total'];

      $j_popular_pager = new Arraypager(null, 10);
      $j_popular_pager->setResultTotal($journal_popular_total);
      $j_popular_pager->setPage($this->getRequestParameter('page', 1));
      $j_popular_pager->init();
    } else {
      $journal_popular = array();
      $j_popular_pager = '';
    }
    $this->renderPartial('journals_popular', compact('journal_popular', 'j_popular_pager'));
    return sfView::NONE;
  }

  protected function getJournals($page, $per_page, $sort)
  {
    return $this->rest->getBlogs($page, $per_page, null, $sort);
  }

  protected function getJournal($id)
  {
    return $this->rest->getBlog($id);
  }

  protected function getComments($page, $num, $discussion_id, $reset_cache = false)
  {
    return $this->rest->getComments($page, $num, $discussion_id, 'date_created', 'DESC', $reset_cache);
  }

  protected function addComment($user_id, $comment, $discussion_id, $type, $content_id)
  {
    return $this->rest->addComment($user_id, $comment, $discussion_id, $type, $content_id);
  }
}