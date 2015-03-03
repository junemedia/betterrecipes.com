<?php

/**
 * groups actions.
 *
 * @package    betterrecipes
 * @subpackage groups
 * @author     Rusty Cage <rcage@resolute.com>
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class groupsActions extends sfActions
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
    $this->popgroups = $this->rest->viewAllGroups(1, 12, 'num_views');

    // meta
    $response = $this->getResponse();
    $response->setTitle('Group Recipes | Share Recipes | Online Recipes | Recipe Community | Better Recipes');
    $response->addMeta('description', 'Swap online recipes and cooking tips with the members of our recipe community. Discuss group recipes and share recipes for all your favorite meals!');
    $response->addMeta('keywords', 'group recipes, share recipes, online recipes, cooking tips, recipe community');
    
    //Omniture
    $this->getOmniture()->setMany(array(
      'pageName' => 'Category:Groups',
      'server' => 'www.betterrecipes.com',
      'Channel' => 'Groups',
      'prop1' => 'Groups:Main',
      'prop7' => $this->getUser()->isAuthenticated(),
      'prop18' => 'betterrecipes',
      'prop19' => 'Food',
      'prop20' => $request->getUri(),
      'eVar9' => 'Category:Groups',
      'eVar14' => 'Groups',
      'eVar24' => $this->getUser()->isAuthenticated()
    ));
  }

  public function executeDetail(sfWebRequest $request)
  {
    $this->forward404Unless($slug = $request->getParameter('slug'));
    $this->group = $this->getGroupInfo($slug);
    $this->forward404Unless(!empty($this->group));
    $this->my_group = $this->getUser()->isAuthenticated() && $this->group['owner_id'] === $this->getUser()->getOnesiteId();

    $this->active = 'home';
    // check if logged in user belongs to group
    if (!is_null($this->user_id)) {
      $belongs = $this->rest->getUserGroupList($this->user_id);
      $this->blog_id = ( in_array($this->group['blog_id'], $belongs) ) ? $this->group['blog_id'] : null;
    } else {
      $this->blog_id = null;
    }

    // increment the view
    $this->rest->incrementViewsUser($this->group['blog_id']);

    $this->group_activity = $this->getGroupActivity($this->group['group_id']);

    //Title Tag & Meta Data    
    $this->getResponse()->setTitle(Microformat::correct_caps($this->group['display_name']));
    $this->getResponse()->addMeta('keywords', $this->group['desc_small'], true);
    $this->getResponse()->addMeta('description', $this->group['desc_small'], true);

    // is this a sponsored group?
    $sponsored = $this->rest->getUserGroupsList(115752559, 1, 2000); // pull sponsored by kellog's kitchen
    if (sizeof($sponsored) > 0) {
      $this->is_sponsor = ( in_array($this->group['group_id'], $sponsored) ) ? 'Kelloggs' : '';
      $this->sponsor = SponsorTable::getSingleSponsor();
    } else {
      $this->is_sponsor = '';
      $this->sponsor = null;
    }
    
    //Detail View Omniture
    $this->getOmniture()->setMany(array(
      'pageName' => 'Groups:' . GroupTable::getGroupCategoryObjBySlug($slug)->getName() . ':' . $this->group['display_name'],
      'Server' => 'www.betterrecipes.com',
      'Channel' => 'Groups',
      'prop1' => 'Groups:' . GroupTable::getGroupCategoryObjBySlug($slug)->getName(),
      'prop7' => $this->getUser()->isAuthenticated() ? true : false,
      'prop11' => $this->is_sponsor,
      'prop18' => 'betterrecipes',
      'prop19' => 'Food',
      'prop20' => $request->getUri(),
      'eVar9' => 'Groups:' . GroupTable::getGroupCategoryObjBySlug($slug)->getName() . ':' . $this->group['display_name'],
      'eVar14' => 'Groups',
      'eVar24' => $this->getUser()->isAuthenticated() ? true : false
    ));

  }
  
  public function executeJoingroup(sfWebRequest $request)
  {
    $this->forward404Unless($slug = $request->getParameter('slug'));
    $group = $this->getGroupInfo($slug);
    $this->forward404Unless(!empty($group));
    if (is_null($this->user_id)) {
      $this->getUser()->setRegSourceAttribute('code', 8256);
      $this->getUser()->setReferrer(UrlToolkit::getDomainUri() . '/joingroup/' . $slug);
      $this->redirect('@signin');
    } else {
      $j = $this->rest->addUserToGroup($group['group_id'], $this->user_id);
      if (isset($j) && $j['code'] == 1) {
        // kill the memcache key if it exists
        $memcache = $this->getMemcache();
        $key = $this->getMemcacheKey('user_groups', array('%user_id%' => $this->user_id));
        if ($memcache->has($key)) {
          $memcache->set($key, array($group['blog_id']), strtotime('+2 minutes') - time());
        }
      }
      $redirect = UrlToolkit::getRoute('@group_detail', array('category' => $group['category'], 'slug' => $slug));
      $this->redirect($redirect);
    }

    return sfView::NONE;
  }


  public function executeMembers(sfWebRequest $request)
  {
    $this->forward404Unless($slug = $request->getParameter('slug'));
    $this->group = $this->getGroupInfo($slug);
    $this->forward404Unless(!empty($this->group));
    $this->my_group = $this->getUser()->isAuthenticated() && $this->group['owner_id'] === $this->getUser()->getOnesiteId();

    $this->group_cat = GroupTable::getGroupCategoryObjBySlug($slug)->getName();
    $this->groupRoles = $this->rest->getGroupRoles();

    $this->active = 'members';

    // check if logged in user belongs to group
    if (!is_null($this->user_id)) {
      $belongs = $this->rest->getUserGroupList($this->user_id);
      $this->blog_id = ( in_array($this->group['blog_id'], $belongs) ) ? $this->group['blog_id'] : null;
    } else {
      $this->blog_id = null;
    }

    $resetCache = $this->getUser()->getAttribute('clear_member_cache', false);  //Check if cache needs to be cleared
    $m = $this->getGroupMembers($this->getRequestParameter('page', 1), 9, $this->group['group_id'], $resetCache);
    if ($resetCache) //reset session var to false
      $this->getUser()->setAttribute('clear_member_cache', false);
    if (sizeof($m) > 0) {
      $this->members = $m['items'];
      $this->members_perPage = $m['perPage'];
      $this->members_total = $m['total'];

      $this->members_pager = new Arraypager(null, 9);
      $this->members_pager->setResultTotal($this->members_total);
      $this->members_pager->setPage($request->getParameter('page', 1));
      $this->members_pager->init();
    } else {
      $this->members = array();
      $this->members_pager = '';
    }


    // is this is sponsored group?
    $sponsored = $this->rest->getUserGroupsList(115752559, 1, 2000); // pull sponsored by kellog's kitchen
    if (sizeof($sponsored) > 0) {
      $this->is_sponsor = ( in_array($this->group['group_id'], $sponsored) ) ? 'Kelloggs' : '';
      $this->sponsor = SponsorTable::getSingleSponsor();
    } else {
      $this->is_sponsor = '';
      $this->sponsor = null;
    }
    
    // Omniture
    $this->getOmniture()->setMany(array(
      'pageName' => 'Groups:' . GroupTable::getGroupCategoryObjBySlug($slug)->getName() . ':' . $this->group['display_name'] . ':members',
      'Server' => 'www.betterrecipes.com',
      'Channel' => 'Groups',
      'prop1' => 'Groups:' . GroupTable::getGroupCategoryObjBySlug($slug)->getName(),
      'prop2' => 'Groups:' . GroupTable::getGroupCategoryObjBySlug($slug)->getName() . ':members',
      'prop7' => $this->getUser()->isAuthenticated() ? true : false,
      'prop18' => 'betterrecipes',
      'prop19' => 'Food',
      'prop20' => $request->getUri(),
      'eVar9' => 'Groups:' . GroupTable::getGroupCategoryObjBySlug($slug)->getName() . ':' . $this->group['display_name'] . ':members',
      'eVar14' => 'Groups',
      'eVar24' => $this->getUser()->isAuthenticated() ? true : false
    ));

  }

  public function executePaginatemembers(sfWebRequest $request)
  {
    $this->forward404Unless($request->isXmlHttpRequest());
    $this->forward404Unless($slug = $request->getParameter('slug'));
    $group = $this->getGroupInfo($slug);
    $this->forward404Unless(!empty($group));
    $group_cat = GroupTable::getGroupCategoryObjBySlug($slug)->getName();
    $groupRoles = $this->rest->getGroupRoles();
    $my_group = $this->getUser()->isAuthenticated() && $group['owner_id'] === $this->getUser()->getOnesiteId();
    // check if logged in user belongs to group
    if (!is_null($this->user_id)) {
      $belongs = $this->rest->getUserGroupList($this->user_id);
      $blog_id = ( in_array($group['blog_id'], $belongs) ) ? $group['blog_id'] : null;
    } else {
      $blog_id = null;
    }

    $m = $this->getGroupMembers($request->getParameter('page', 1), 9, $group['group_id']);
    if (sizeof($m) > 0) {
      $members = $m['items'];
      $members_perPage = $m['perPage'];
      $members_total = $m['total'];

      $members_pager = new Arraypager(null, 9);
      $members_pager->setResultTotal($members_total);
      $members_pager->setPage($request->getParameter('page', 1));
      $members_pager->init();
    } else {
      $members = array();
      $members_pager = '';
    }
    $this->renderPartial('group_members', compact('members', 'members_pager', 'group', 'blog_id', 'group_cat', 'groupRoles', 'my_group'));
    return sfView::NONE;
  }

  public function executeDiscussions(sfWebRequest $request)
  {
    $this->forward404Unless($slug = $request->getParameter('slug'));
    $this->group = $this->getGroupInfo($slug);
    $this->forward404Unless(!empty($this->group));
    $this->my_group = $this->getUser()->isAuthenticated() && $this->group['owner_id'] === $this->getUser()->getOnesiteId();

    $this->active = 'discussions';
    // check if logged in user belongs to group
    if (!is_null($this->user_id)) {
      $belongs = $this->rest->getUserGroupList($this->user_id);
      $this->blog_id = ( in_array($this->group['blog_id'], $belongs) ) ? $this->group['blog_id'] : null;
    } else {
      $this->blog_id = null;
    }

    // retrieve the forum ID associated with this group
    $this->forum_id = GroupTable::getForumIdBySlug($slug);

    // retrieve list of discussions
    $reset_cache = $this->getUser()->getAttribute('clear_thread_cache', false);
    $d = $this->getDiscussions($request->getParameter('page', 1), 9, 'last_post_id', 'DESC', $this->group['blog_id'], $reset_cache);
    if ($reset_cache) {
      $this->getUser()->setAttribute('clear_thread_cache', false);
    }
    if (sizeof($d) > 0) {
      $this->discussions = $d['items'];
      $this->discussions_perPage = $d['perPage'];
      $this->discussions_total = $d['total'];

      $this->discussions_pager = new Arraypager(null, 9);
      $this->discussions_pager->setResultTotal($this->discussions_total);
      $this->discussions_pager->setPage($request->getParameter('page', 1));
      $this->discussions_pager->init();
    } else {
      $this->discussions = array();
      $this->discussions_pager = '';
    }

    // is this is sponsored group?
    $sponsored = $this->rest->getUserGroupsList(115752559, 1, 2000); // pull sponsored by kellog's kitchen
    if (sizeof($sponsored) > 0) {
      $this->is_sponsor = ( in_array($this->group['group_id'], $sponsored) ) ? 'Kelloggs' : '';
      $this->sponsor = SponsorTable::getSingleSponsor();
    } else {
      $this->is_sponsor = '';
      $this->sponsor = null;
    }
    $this->category = GroupTable::getGroupCategoryObjBySlug($slug)->getName();
    
    // Omniture
    $this->getOmniture()->setMany(array(
      'pageName' => 'Discussions:Groups:Main:' . $this->group['display_name'],
      'Server' => 'www.betterrecipes.com',
      'Channel' => 'Discussions',
      'prop1' => 'Discussions:Groups',
      'prop2' => 'Discussions:Group:Main',
      'prop7' => $this->getUser()->isAuthenticated() ? true : false,
      'prop18' => 'betterrecipes',
      'prop19' => 'Food',
      'prop20' => $request->getUri(),
      'eVar9' => 'Discussions:Groups:Main:' . $this->group['display_name'],
      'eVar14' => 'Discussions',
      'eVar24' => $this->getUser()->isAuthenticated() ? true : false
    ));

  }

  public function executePaginatediscussions(sfWebRequest $request)
  {
    $this->forward404Unless($request->isXmlHttpRequest());
    $this->forward404Unless($slug = $request->getParameter('slug'));
    $group = $this->getGroupInfo($slug);
    $this->forward404Unless(!empty($group));
    // check if logged in user belongs to group
    if (!is_null($this->user_id)) {
      $belongs = $this->rest->getUserGroupList($this->user_id);
      $blog_id = ( in_array($group['blog_id'], $belongs) ) ? $group['blog_id'] : null;
    } else {
      $blog_id = null;
    }
    // retrieve the forum ID associated with this group
    $forum_id = GroupTable::getForumIdBySlug($slug);

    // retrieve list of discussions
    $d = $this->getDiscussions($request->getParameter('page', 1), 9, 'date', 'DESC', $group['blog_id'], false);
    if (sizeof($d) > 0) {
      $discussions = $d['items'];
      $discussions_perPage = $d['perPage'];
      $discussions_total = $d['total'];

      $discussions_pager = new Arraypager(null, 9);
      $discussions_pager->setResultTotal($discussions_total);
      $discussions_pager->setPage($request->getParameter('page', 1));
      $discussions_pager->init();
    } else {
      $discussions = array();
      $discussions_pager = '';
    }

    if ($this->getUser()->isAuthenticated()) {
      $user_id = $this->getUser()->getOnesiteId();
    } else {
      $user_id = null;
    }

    $category = GroupTable::getGroupCategoryObjBySlug($slug)->getName();
    $this->renderPartial('group_discussions', compact('blog_id', 'forum_id', 'discussions', 'discussions_pager', 'group', 'user_id', 'category'));
    return sfView::NONE;
  }

  public function executeDiscussiondetail(sfWebRequest $request)
  {
    $this->forward404Unless($slug = $request->getParameter('slug'));
    $this->forward404Unless($thread_id = $request->getParameter('id'));
    $this->thread_id = $thread_id;

    // increment the discussion thread
    $this->rest->incrementViewsThread($thread_id);

    $this->group = $this->getGroupInfo($slug);
    $this->forward404Unless(!empty($this->group));
    $this->my_group = $this->getUser()->isAuthenticated() && $this->group['owner_id'] === $this->getUser()->getOnesiteId();
    $this->active = 'discussions';
    // check if logged in user belongs to group
    if (!is_null($this->user_id)) {
      $belongs = $this->rest->getUserGroupList($this->user_id);
      $this->blog_id = ( in_array($this->group['blog_id'], $belongs) ) ? $this->group['blog_id'] : null;
    } else {
      $this->blog_id = null;
    }

    // retrieve the thread info
    $this->thread = $this->getThreadInfo($thread_id);

    // OneSite Hack, compare last post id to first post id in order to determine if we need to retrieve a list of posts for the discussion thread
    if ($this->thread['first_post_id'] == $this->thread['last_post_id']) {
      $this->posts = array();
      $this->posts_pager = '';
    } else {
      // retrieve list of posts
      $reset_cache = $this->getUser()->getAttribute('clear_post_cache', false);
      $p = $this->getPosts($request->getParameter('page', 1), 9, $thread_id, $reset_cache);
      if ($reset_cache) {
        $this->getUser()->setAttribute('clear_post_cache', false);
      }
      if (sizeof($p) > 0) {
        //Hack to remove first post (should only be top thread and not appear in the posts)
        foreach ($p['items'] as $i => $post) {
          if ($post['post_id'] == $this->thread['first_post_id'])
            unset($p['items'][$i]);
        }
        $this->posts = $p['items'];
        $this->posts_perPage = $p['perPage'];
        $this->posts_total = $p['total'];

        $this->posts_pager = new Arraypager(null, 9);
        $this->posts_pager->setResultTotal($this->posts_total);
        $this->posts_pager->setPage($request->getParameter('page', 1));
        $this->posts_pager->init();
      } else {
        $this->posts = array();
        $this->posts_pager = '';
      }
    }


    // is this is sponsored group?
    $sponsored = $this->rest->getUserGroupsList(115752559, 1, 2000); // pull sponsored by kellog's kitchen
    if (sizeof($sponsored) > 0) {
      $this->is_sponsor = ( in_array($this->group['group_id'], $sponsored) ) ? 'Kelloggs' : '';
      $this->sponsor = SponsorTable::getSingleSponsor();
    } else {
      $this->is_sponsor = '';
      $this->sponsor = null;
    }
    
    // Omniture
    $this->getOmniture()->setMany(array(
      'pageName' => 'Discussions:Groups:Detail:' . $this->group['display_name'],
      'Server' => 'www.betterrecipes.com',
      'Channel' => 'Discussions',
      'prop1' => 'Discussions:Groups',
      'prop2' => 'Discussions:Group:Detail',
      'prop7' => $this->getUser()->isAuthenticated() ? true : false,
      'prop18' => 'betterrecipes',
      'prop19' => 'Food',
      'prop20' => $request->getUri(),
      'eVar9' => 'Discussions:Groups:Detail:' . $this->group['display_name'],
      'eVar14' => 'Discussions',
      'eVar24' => $this->getUser()->isAuthenticated() ? true : false
    ));
  }

  public function executePaginatediscussionsdetail(sfWebRequest $request)
  {
    $this->forward404Unless($request->isXmlHttpRequest());
    $this->forward404Unless($slug = $request->getParameter('slug'));
    $this->forward404Unless($thread_id = $request->getParameter('thread_id'));
    $group = $this->getGroupInfo($slug);
    $this->forward404Unless(!empty($group));

    // check if logged in user belongs to group
    if (!is_null($this->user_id)) {
      $belongs = $this->rest->getUserGroupList($this->user_id);
      $blog_id = ( in_array($group['blog_id'], $belongs) ) ? $group['blog_id'] : null;
    } else {
      $blog_id = null;
    }

    // retrieve the thread info
    $thread = $this->getThreadInfo($thread_id);

    // retrieve list of posts
    $p = $this->getPosts($request->getParameter('page', 1), 9, $thread_id, false);
    if (sizeof($p) > 0) {
      $posts = $p['items'];
      $posts_perPage = $p['perPage'];
      $posts_total = $p['total'];

      $posts_pager = new Arraypager(null, 9);
      $posts_pager->setResultTotal($posts_total);
      $posts_pager->setPage($request->getParameter('page', 1));
      $posts_pager->init();
    } else {
      $posts = array();
      $posts_pager = '';
    }

    if ($this->getUser()->isAuthenticated()) {
      $user_id = $this->getUser()->getOnesiteId();
    } else {
      $user_id = null;
    }

    $this->renderPartial('group_discussion_detail_replies', compact('thread_id', 'posts', 'posts_pager', 'group'));
    return sfView::NONE;
  }

  public function executeRecipes(sfWebRequest $request)
  {
    $this->forward404Unless($slug = $request->getParameter('slug'));
    $this->group = $this->getGroupInfo($slug);
    $this->forward404Unless(!empty($this->group));
    $this->my_group = $this->getUser()->isAuthenticated() && $this->group['owner_id'] === $this->getUser()->getOnesiteId();
    $this->group_cat = GroupTable::getGroupCategoryObjBySlug($slug)->getName();
    $this->active = 'recipes';

    // check if logged in user belongs to group
    if (!is_null($this->user_id)) {
      $belongs = $this->rest->getUserGroupList($this->user_id);
      $this->blog_id = ( in_array($this->group['blog_id'], $belongs) ) ? $this->group['blog_id'] : null;
    } else {
      $this->blog_id = null;
    }
    $this->sortby = $request->getParameter('sort', 'date');
    // output a list of recipes
    $params = array('group_id' => $this->group['group_id'],
      'search_type' => $this->sortby,
      'paginate' => true
    );
    $this->pager = new sfDoctrinePager('Recipe', '9');
    $this->pager->setQuery(RecipeTable::getGroupRecipes($params));
    $this->pager->setPage($request->getParameter('page', 1));
    $this->pager->init();


    // is this is sponsored group?
    $sponsored = $this->rest->getUserGroupsList(115752559, 1, 2000); // pull sponsored by kellog's kitchen
    if (sizeof($sponsored) > 0) {
      $this->is_sponsor = ( in_array($this->group['group_id'], $sponsored) ) ? 'Kelloggs' : '';
      $this->sponsor = SponsorTable::getSingleSponsor();
    } else {
      $this->is_sponsor = '';
      $this->sponsor = null;
    }
    
    $prop11 = '';
    foreach ($this->pager->getResults() as $r) {
    	if ( $r->getSponsorName() != '') {
      		$prop11 = $r->getSponsorName();
            break;
      	}
    }
    
    // Omniture
    $this->getOmniture()->setMany(array(
      'pageName' => 'Groups:' . GroupTable::getGroupCategoryObjBySlug($slug)->getName() . ':' . $this->group['display_name'] . ':recipes',
      'Server' => 'www.betterrecipes.com',
      'Channel' => 'Groups',
      'prop1' => 'Groups:' . GroupTable::getGroupCategoryObjBySlug($slug)->getName(),
      'prop2' => 'Groups:' . GroupTable::getGroupCategoryObjBySlug($slug)->getName() . ':recipes',
      'prop7' => $this->getUser()->isAuthenticated() ? true : false,
      'prop11' => $prop11,
      'prop18' => 'betterrecipes',
      'prop19' => 'Food',
      'prop20' => $request->getUri(),
      'eVar9' => 'Groups:' . GroupTable::getGroupCategoryObjBySlug($slug)->getName() . ':' . $this->group['display_name'] . ':recipes',
      'eVar14' => 'Groups',
      'eVar24' => $this->getUser()->isAuthenticated() ? true : false
    ));

  }

  public function executePaginaterecipes(sfWebRequest $request)
  {
    $this->forward404Unless($request->isXmlHttpRequest());
    $this->forward404Unless($slug = $request->getParameter('slug'));
    $group = $this->getGroupInfo($slug);
    $this->forward404Unless(!empty($group));
    $group_cat = GroupTable::getGroupCategoryObjBySlug($slug)->getName();
    $my_group = $this->getUser()->isAuthenticated() && $group['owner_id'] === $this->getUser()->getOnesiteId();
    // check if logged in user belongs to group
    if (!is_null($this->user_id)) {
      $belongs = $this->rest->getUserGroupList($this->user_id);
      $blog_id = ( in_array($group['blog_id'], $belongs) ) ? $group['blog_id'] : null;
    } else {
      $blog_id = null;
    }
    $sortby = $request->getParameter('sort', 'date');

    // output a list of recipes
    $params = array('group_id' => $group['group_id'],
      'search_type' => $sortby,
      'paginate' => true
    );
    $pager = new sfDoctrinePager('Recipe', '9');
    $pager->setQuery(RecipeTable::getGroupRecipes($params));
    $pager->setPage($request->getParameter('page', 1));
    $pager->init();

    $this->renderPartial('group_recipes', compact('my_group', 'pager', 'group', 'blog_id', 'group_cat', 'sortby'));
    return sfView::NONE;
  }

  public function executePolls(sfWebRequest $request)
  {
    $this->forward404Unless($slug = $request->getParameter('slug'));
    $this->group = $this->getGroupInfo($slug);
    $this->forward404Unless(!empty($this->group));
    $this->my_group = $this->getUser()->isAuthenticated() && $this->group['owner_id'] === $this->getUser()->getOnesiteId();

    $this->active = 'polls';

    // check if logged in user belongs to group
    if (!is_null($this->user_id)) {
      $belongs = $this->rest->getUserGroupList($this->user_id);
      $this->blog_id = ( in_array($this->group['blog_id'], $belongs) ) ? $this->group['blog_id'] : null;
    } else {
      $this->blog_id = null;
    }


    // fetch polls
    $reset_cache = $this->getUser()->getAttribute('clear_poll_cache', false);
    $polls = $this->rest->getPolls($request->getParameter('page', 1), 9, null, null, $this->group['blog_id'], null, $reset_cache);
    if ($reset_cache) {
      $this->getUser()->setAttribute('clear_poll_cache', false);
    }
    if (sizeof($polls) > 0) {
      $this->polls = $polls['items'];
      $this->polls_perPage = $polls['perPage'];
      $this->polls_total = $polls['total'];

      $this->polls_pager = new Arraypager(null, 9);
      $this->polls_pager->setResultTotal($this->polls_total);
      $this->polls_pager->setPage($request->getParameter('page', 1));
      $this->polls_pager->init();
    } else {
      $this->polls = array();
      $this->polls_pager = '';
    }

    $this->poll_blog = $this->group['blog_id'];

    // is this is sponsored group?
    $sponsored = $this->rest->getUserGroupsList(115752559, 1, 2000); // pull sponsored by kellog's kitchen
    if (sizeof($sponsored) > 0) {
      $this->is_sponsor = ( in_array($this->group['group_id'], $sponsored) ) ? 'Kelloggs' : '';
      $this->sponsor = SponsorTable::getSingleSponsor();
    } else {
      $this->is_sponsor = '';
      $this->sponsor = null;
    }
    
    // Omniture
    $this->getOmniture()->setMany(array(
      'pageName' => 'Polls:Groups:' . $this->group['display_name'],
      'Server' => 'www.betterrecipes.com',
      'Channel' => 'Polls',
      'prop1' => 'Polls:Groups:',
      'prop2' => 'Polls:Groups:' . $this->group['display_name'],
      'prop7' => $this->getUser()->isAuthenticated() ? true : false,
      'prop18' => 'betterrecipes',
      'prop19' => 'Food',
      'prop20' => $request->getUri(),
      'eVar9' => 'Polls:Groups:' . $this->group['display_name'],
      'eVar14' => 'Polls',
      'eVar24' => $this->getUser()->isAuthenticated() ? true : false
    ));
  }

  public function executePaginatepolls(sfWebRequest $request)
  {
    $this->forward404Unless($request->isXmlHttpRequest());
    $poll_blog = $request->getParameter('poll_blog');

    $p = $this->rest->getPolls($request->getParameter('page', 1), 9, null, null, $poll_blog);
    if (sizeof($p) > 0) {
      $polls = $p['items'];
      $polls_perPage = $p['perPage'];
      $polls_total = $p['total'];

      $polls_pager = new Arraypager(null, 9);
      $polls_pager->setResultTotal($polls_total);
      $polls_pager->setPage($request->getParameter('page', 1));
      $polls_pager->init();
    } else {
      $polls = array();
      $polls_pager = '';
    }
    $this->renderPartial('group_polls', compact('polls', 'polls_pager', 'poll_blog'));
    return sfView::NONE;
  }

  public function executePolldetail(sfWebRequest $request)
  {
    $this->forward404Unless($slug = $request->getParameter('slug'));
    $this->forward404Unless($id = $request->getParameter('id'));

    $this->group = $this->getGroupInfo($slug);
    $this->forward404Unless(!empty($this->group));
    $this->my_group = $this->getUser()->isAuthenticated() && $this->group['owner_id'] === $this->getUser()->getOnesiteId();

    $this->active = 'polls';

    // check if logged in user belongs to group
    if (!is_null($this->user_id)) {
      $belongs = $this->rest->getUserGroupList($this->user_id);
      $this->blog_id = ( in_array($this->group['blog_id'], $belongs) ) ? $this->group['blog_id'] : null;
    } else {
      $this->blog_id = null;
    }


    $content_id = $id;
    $this->contentId = $content_id;

    $this->poll = $this->rest->loadPoll($id);
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

    // is this is sponsored group?
    $sponsored = $this->rest->getUserGroupsList(115752559, 1, 2000); // pull sponsored by kellog's kitchen
    if (sizeof($sponsored) > 0) {
      $this->is_sponsor = ( in_array($this->group['group_id'], $sponsored) ) ? 'Kelloggs' : '';
      $this->sponsor = SponsorTable::getSingleSponsor();
    } else {
      $this->is_sponsor = '';
      $this->sponsor = null;
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
      'eVar24' => $this->getUser()->isAuthenticated() ? true : false
    ));

  }

  public function executePhotos(sfWebRequest $request)
  {
    $this->forward404Unless($slug = $request->getParameter('slug'));
    $this->group = $this->getGroupInfo($slug);
    $this->forward404Unless(!empty($this->group));
    $this->my_group = $this->getUser()->isAuthenticated() && $this->group['owner_id'] === $this->getUser()->getOnesiteId();

    $this->active = 'photos';
    // check if logged in user belongs to group
    if (!is_null($this->user_id)) {
      $belongs = $this->rest->getUserGroupList($this->user_id);
      $this->blog_id = ( in_array($this->group['blog_id'], $belongs) ) ? $this->group['blog_id'] : null;
    } else {
      $this->blog_id = null;
    }

    $this->sortby = $request->getParameter('sort', 'date');

    // retrieve photos
    $p = $this->getPhotos($this->getRequestParameter('page', 1), 9, $this->sortby, $this->group['blog_id']);
    if (sizeof($p) > 0) {
      $this->photos = $p['items'];
      $this->photos_perPage = $p['perPage'];
      $this->photos_total = $p['total'];

      $this->photos_pager = new Arraypager(null, 9);
      $this->photos_pager->setResultTotal($this->photos_total);
      $this->photos_pager->setPage($this->getRequestParameter('page', 1));
      $this->photos_pager->init();
    } else {
      $this->photos = array();
      $this->photos_pager = '';
    }


    // is this is sponsored group?
    $sponsored = $this->rest->getUserGroupsList(115752559, 1, 2000); // pull sponsored by kellog's kitchen
    if (sizeof($sponsored) > 0) {
      $this->is_sponsor = ( in_array($this->group['group_id'], $sponsored) ) ? 'Kelloggs' : '';
      $this->sponsor = SponsorTable::getSingleSponsor();
    } else {
      $this->is_sponsor = '';
      $this->sponsor = null;
    }
    
    // Omniture
    $this->getOmniture()->setMany(array(
      'pageName' => 'Photos:Groups:' . $this->group['display_name'],
      'Server' => 'www.betterrecipes.com',
      'Channel' => 'Photos',
      'prop1' => 'Photos:Groups:',
      'prop2' => 'Photos:Groups:' . $this->group['display_name'],
      'prop7' => $this->getUser()->isAuthenticated() ? true : false,
      'prop18' => 'betterrecipes',
      'prop19' => 'Food',
      'prop20' => $request->getUri(),
      'eVar9' => 'Photos:Groups:' . $this->group['display_name'],
      'eVar14' => 'Photos',
      'eVar24' => $this->getUser()->isAuthenticated() ? true : false
    ));
  }

  public function executePaginatephotos(sfWebRequest $request)
  {
    $this->forward404Unless($request->isXmlHttpRequest());
    $this->forward404Unless($slug = $request->getParameter('slug'));
    $group = $this->getGroupInfo($slug);
    $this->forward404Unless(!empty($group));

    // check if logged in user belongs to group
    if (!is_null($this->user_id)) {
      $belongs = $this->rest->getUserGroupList($this->user_id);
      $blog_id = ( in_array($group['blog_id'], $belongs) ) ? $group['blog_id'] : null;
    } else {
      $blog_id = null;
    }
    $sortby = $request->getParameter('sort', 'date');
    // retrieve photos
    $p = $this->getPhotos($this->getRequestParameter('page', 1), 9, $sortby, $group['blog_id']);
    if (sizeof($p) > 0) {
      $photos = $p['items'];
      $photos_perPage = $p['perPage'];
      $photos_total = $p['total'];

      $photos_pager = new Arraypager(null, 9);
      $photos_pager->setResultTotal($photos_total);
      $photos_pager->setPage($this->getRequestParameter('page', 1));
      $photos_pager->init();
    } else {
      $photos = array();
      $photos_pager = '';
    }
    $this->renderPartial('group_photos', compact('sortby', 'blog_id', 'photos', 'photos_pager', 'group'));
    return sfView::NONE;
  }

  public function executeVideos(sfWebRequest $request)
  {
    $this->forward404Unless($slug = $request->getParameter('slug'));
    $this->group = $this->getGroupInfo($slug);
    $this->forward404Unless(!empty($this->group));
    $this->my_group = $this->getUser()->isAuthenticated() && $this->group['owner_id'] === $this->getUser()->getOnesiteId();

    $this->active = 'videos';
    // check if logged in user belongs to group
    if (!is_null($this->user_id)) {
      $belongs = $this->rest->getUserGroupList($this->user_id);
      $this->blog_id = ( in_array($this->group['blog_id'], $belongs) ) ? $this->group['blog_id'] : null;
    } else {
      $this->blog_id = null;
    }
    $this->sortby = $this->getRequestParameter('sort', 'date');
    // retrieve videos
    $v = $this->getVideos($this->getRequestParameter('page', 1), 9, $this->sortby, $this->group['blog_id']);
    if (sizeof($v) > 0) {
      $this->videos = $v['items'];
      $this->videos_perPage = $v['perPage'];
      $this->videos_total = $v['total'];

      $this->videos_pager = new Arraypager(null, 9);
      $this->videos_pager->setResultTotal($this->videos_total);
      $this->videos_pager->setPage($this->getRequestParameter('page', 1));
      $this->videos_pager->init();
    } else {
      $this->videos = array();
      $this->videos_pager = '';
    }


    // is this is sponsored group?
    $sponsored = $this->rest->getUserGroupsList(115752559, 1, 2000); // pull sponsored by kellog's kitchen
    if (sizeof($sponsored) > 0) {
      $this->is_sponsor = ( in_array($this->group['group_id'], $sponsored) ) ? 'Kelloggs' : '';
      $this->sponsor = SponsorTable::getSingleSponsor();
    } else {
      $this->is_sponsor = '';
      $this->sponsor = null;
    }
	
	$prop11 = '';
    foreach ($this->videos as $v) {
      $tiers = $this->rest->getUserTiers($v['user_id']);
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
        $this->sponsor = Doctrine_Core::getTable('Sponsor')->findOneByName('Kellogs');
      } else {
        $sponsor_name = '';
        $this->sponsor = null;
      }
      $prop11 .= $sponsor_name . ';';
    }
    
    // Omniture
    $this->getOmniture()->setMany(array(
      'pageName' => 'Videos:Groups:' . $this->group['display_name'],
      'Server' => 'www.betterrecipes.com',
      'Channel' => 'Videos',
      'prop1' => 'Videos:Groups:',
      'prop2' => 'Videos:Groups:' . $this->group['display_name'],
      'prop7' => $this->getUser()->isAuthenticated() ? true : false,
      'prop11' => $prop11,
      'prop18' => 'betterrecipes',
      'prop19' => 'Food',
      'prop20' => $request->getUri(),
      'eVar9' => 'Videos:Groups:' . $this->group['display_name'],
      'eVar14' => 'Videos',
      'eVar24' => $this->getUser()->isAuthenticated() ? true : false
    ));
  }

  public function executePaginatevideos(sfWebRequest $request)
  {
    $this->forward404Unless($request->isXmlHttpRequest());
    $this->forward404Unless($slug = $request->getParameter('slug'));
    $group = $this->getGroupInfo($slug);
    $this->forward404Unless(!empty($group));

    // check if logged in user belongs to group
    if (!is_null($this->user_id)) {
      $belongs = $this->rest->getUserGroupList($this->user_id);
      $blog_id = ( in_array($group['blog_id'], $belongs) ) ? $group['blog_id'] : null;
    } else {
      $blog_id = null;
    }
    $sortby = $request->getParameter('sort', 'date');
    // retrieve videos
    $p = $this->getVideos($this->getRequestParameter('page', 1), 9, $sortby, $group['blog_id']);
    if (sizeof($p) > 0) {
      $videos = $p['items'];
      $videos_perPage = $p['perPage'];
      $videos_total = $p['total'];

      $videos_pager = new Arraypager(null, 9);
      $videos_pager->setResultTotal($videos_total);
      $videos_pager->setPage($this->getRequestParameter('page', 1));
      $videos_pager->init();
    } else {
      $videos = array();
      $videos_pager = '';
    }
    $this->renderPartial('group_videos', compact('sortby', 'blog_id', 'videos', 'videos_pager', 'group'));
    return sfView::NONE;
  }

  public function executeSaverecipe(sfWebRequest $request)
  {
    $this->forward404Unless($request->isXmlHttpRequest());
    $this->forward404Unless($id = $request->getParameter('id'));

    $user_id = $this->getUser()->getAttribute('id');
    SavedTable::add($id, $user_id);
    $is_saved = true;
    $this->renderPartial('save_recipe', compact('is_saved', 'id'));
    return sfView::NONE;
  }

  protected function getThreadInfo($thread_id)
  {
    return $this->rest->getThreadInfo($thread_id);
  }

  protected function getPosts($page, $num, $thread_id, $reset_cache = false)
  {
    return $this->rest->getPosts($page, $num, $thread_id, 'date_created', 'DESC', $reset_cache);
  }

  protected function getDiscussions($page, $num, $sort_key, $sort_order, $blog_id, $reset_cache = false)
  {
    return $this->rest->getNetworkThreads($page, $num, $sort_key, $sort_order, $category_id = null, $blog_id, 1, null, $reset_cache);
  }

  protected function getPhotos($page, $per_page, $sort, $blog_id)
  {
    return $this->rest->getPhotos($page, $per_page, $sort, null, $blog_id);
  }

  protected function getVideos($page, $per_page, $sort, $blog_id)
  {
    return $this->rest->getVideos($page, $per_page, $sort, null, $blog_id);
  }

  protected function getGroupMembers($page, $per_page, $group_id, $resetCache = false)
  {
    return $this->rest->getGroupMembers($page, $per_page, $group_id, $resetCache);
  }

  protected function getGroupInfo($slug)
  {
    // retrieve group id (onesite ID) from group table
    $group_id = GroupTable::getGroupIdBySlug($slug);
    return $this->viewGroup($group_id);
  }

  protected function getDiscussionLanding($blog_id)
  {
    return $this->rest->getNetworkThreads(1, 10, 'num_views', 'DESC', null, $blog_id);
  }

  protected function getActivity()
  {
    return $this->rest->getNetworkData();
  }

  protected function getGroupActivity($group_id)
  {
    return $this->rest->getGroupData($group_id);
  }

  protected function viewGroup($group_id)
  {
    return $this->rest->viewGroup($group_id);
  }

  protected function getGroupRecipesLanding($type, $group_id)
  {
    $p = array('group_id' => $group_id, 'search_type' => $type, 'limit' => 10);
    return RecipeTable::getGroupRecipes($p);
  }

  protected function getComments($page, $num, $discussion_id, $reset_cache = false)
  {
    return $this->rest->getComments($page, $num, $discussion_id, 'date_created', 'DESC', $reset_cache);
  }

}
