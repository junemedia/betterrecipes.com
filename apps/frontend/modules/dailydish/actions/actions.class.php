<?php

/**
 * dailydish actions.
 *
 * @package    betterrecipes
 * @subpackage dailydish
 * @author     Rusty Cage <rcage@resolute.com>
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class dailydishActions extends sfActions
{
  
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
  	if ($request->getParameter('page')) {
    	$this->currentPage = $request->getParameter('page');
    } else {
    	$this->currentPage = 1;
    }
    
    if ($request->getParameter('category')) {
    	$this->category = $request->getParameter('category');
    	$this->catUrlPart = '/'.$this->category;
    	$this->type = 'category';
   	} elseif ($request->getParameter('tag')) {
   		$this->category = $request->getParameter('tag');
    	$this->catUrlPart = '/'.$this->category;
    	$this->type = 'tag';
    } else {
    	$this->category = null;
    	$this->catUrlPart = '';
    	$this->type = '';
    }
    
    
    $this->perPage = 10;
  
    $this->getResponse()->setTitle('The Daily Dish');

    $d = new DailydishWp();
    
    // fetch daily dish categories
    $this->cats = $d->getCategories();
    
    // fetch daily dish tags
    $this->tags = $d->getTags();
    
    // fetch daily dish blogroll
    $this->blogroll = $d->getBlogroll();
    
    // fetch daily dish archive
    $this->archive = $d->getArchives();
    
    // fetch daily dish rss feed list
    $dish = $d->getFeed($this->category, $this->currentPage, $this->perPage, $this->type);
    if (sizeof($dish)>0) {
    	$this->items = $dish['items'];
    	$this->total = $dish['total'];
    	$this->title = $dish['title'];
    	$pages = new Paginator($this->perPage, $this->total, $this->currentPage);
    	$pages->site_path = ($this->type == '') ? UrlToolkit::getDomainUri().'/blogs/daily-dish'.$this->catUrlPart : UrlToolkit::getDomainUri().'/blogs/daily-dish/'.$this->type.$this->catUrlPart;
    	$pages->paginate(); 
  		$this->pager = $pages->display_pages();
    } else {
    	$this->items = array();
    }
    
    // meta
    $response = $this->getResponse();
    $response->setTitle('The Daily Dish | Online Recipes | Food Blog | Recipe Blog | Better Recipes');
    $response->addMeta('description', 'Read Kristina Vanni\'s food blog The Daily Dish for the Better Recipes news, award-winning online recipes and cooking tips for every occasion.');
    $response->addMeta('keywords', 'online recipes, recipe blog, food blog, cooking tips');
    
    //Omniture
    $this->getOmniture()->setMany(array(
        'pageName' => 'Blogs:The Daily Dish',
        'Server' => 'www.betterrecipes.com',
        'Channel' => 'Blogs',
        'prop7' => $this->getUser()->isAuthenticated(),
        'prop18' => 'betterrecipes',
        'prop19' => 'Food',
        'prop20' => $request->getUri(),
        'eVar9' => 'Blogs:The Daily Dish',
        'eVar14' => 'Blogs',
        'eVar18' => $this->getUser()->isAuthenticated() ? $this->getUser()->getAttribute('regSource') : '',
        'eVar24' => $this->getUser()->isAuthenticated()
    ));
  }
  
  public function executeArchive(sfWebRequest $request)
  {
  	if ($request->getParameter('page')) {
    	$this->currentPage = $request->getParameter('page');
    } else {
    	$this->currentPage = 1;
    }
    if (! $request->getParameter('year') || ! $request->getParameter('month') ) {
    	$this->forward404();
    }
    
    
    $this->catUrlPart = '/'.$request->getParameter('year').'/'.$request->getParameter('month');
    
    
    $this->perPage = 10;
  
    $this->getResponse()->setTitle('The Daily Dish');

    $d = new DailydishWp();
    
    // fetch daily dish categories
    $this->cats = $d->getCategories();
    
    // fetch daily dish tags
    $this->tags = $d->getTags();
    
    // fetch daily dish blogroll
    $this->blogroll = $d->getBlogroll();
    
    // fetch daily dish archive
    $this->archive = $d->getArchives();
    
    // fetch daily dish rss feed list
    $dish = $d->getFeedArchive($this->currentPage, $this->perPage, $request->getParameter('year'), $request->getParameter('month'));
    if (sizeof($dish)>0) {
    	$this->items = $dish['items'];
    	$this->total = $dish['total'];
    	$this->title = $dish['title'];
    	$pages = new Paginator($this->perPage, $this->total, $this->currentPage);
    	$pages->site_path = UrlToolkit::getDomainUri().'/blogs/daily-dish'.$this->catUrlPart;
    	$pages->paginate(); 
  		$this->pager = $pages->display_pages();
    } else {
    	$this->items = array();
    }
  	
		//

    if ($request->getParameter('category')) {
    	$this->category = $request->getParameter('category');
    	$this->catUrlPart = '/'.$this->category;
    	$this->type = 'category';
   	} elseif ($request->getParameter('tag')) {
   		$this->category = $request->getParameter('tag');
    	$this->catUrlPart = '/'.$this->category;
    	$this->type = 'tag';
    } else {
    	$this->category = null;
    	$this->catUrlPart = '';
    	$this->type = '';
    }
    
    
    $this->perPage = 10;
		// fetch daily dish rss feed list
    $dish = $d->getFeed($this->category, $this->currentPage, $this->perPage, $this->type);
    if (sizeof($dish)>0) {
    	$this->items_sb = $dish['items'];
    	$this->total_sb = $dish['total'];
    	$this->title_sb = $dish['title'];
    	$pages = new Paginator($this->perPage, $this->total, $this->currentPage);
    	$pages->site_path = ($this->type == '') ? UrlToolkit::getDomainUri().'/blogs/daily-dish'.$this->catUrlPart : UrlToolkit::getDomainUri().'/blogs/daily-dish/'.$this->type.$this->catUrlPart;
    	$pages->paginate(); 
  		$this->pager_sb = $pages->display_pages();
    } else {
    	$this->items_sb = array();
    }
    //
    // meta
    $response = $this->getResponse();
    $response->setTitle('The Daily Dish | Online Recipes | Food Blog | Recipe Blog | Better Recipes');
    $response->addMeta('description', 'Read Kristina Vanni\'s food blog The Daily Dish for the Better Recipes news, award-winning online recipes and cooking tips for every occasion.');
    $response->addMeta('keywords', 'online recipes, recipe blog, food blog, cooking tips');
    
    //Omniture
    $this->getOmniture()->setMany(array(
        'pageName' => 'Blogs:The Daily Dish',
        'Server' => 'www.betterrecipes.com',
        'Channel' => 'Blogs',
        'prop7' => $this->getUser()->isAuthenticated(),
        'prop18' => 'betterrecipes',
        'prop19' => 'Food',
        'prop20' => $request->getUri(),
        'eVar9' => 'Blogs:The Daily Dish',
        'eVar14' => 'Blogs',
        'eVar18' => $this->getUser()->isAuthenticated() ? $this->getUser()->getAttribute('regSource') : '',
        'eVar24' => $this->getUser()->isAuthenticated()
    ));

  }
  
  
  
  public function executeDetail(sfWebRequest $request)
  {
  	if ( !$request->getParameter('year') || !$request->getParameter('month') || !$request->getParameter('day') || !$request->getParameter('slug') ) {
  		$this->forward404();
  	}
  	
  	$url = $request->getParameter('year').'/'.$request->getParameter('month').'/'.$request->getParameter('day').'/'.$request->getParameter('slug');

  	$d = new DailydishWp();
  	// fetch the blog post
  	$this->post = $d->getPost($url);
  	
  	// fetch daily dish categories
    $this->cats = $d->getCategories();
    
    // fetch daily dish tags
    $this->tags = $d->getTags();
    
    // fetch daily dish blogroll
    $this->blogroll = $d->getBlogroll();
    
    // fetch daily dish archive
    //$this->archive = $d->getArchives();
  	
		
		if ($request->getParameter('page')) {
    	$this->currentPage = $request->getParameter('page');
    } else {
    	$this->currentPage = 1;
    }
    
    if ($request->getParameter('category')) {
    	$this->category = $request->getParameter('category');
    	$this->catUrlPart = '/'.$this->category;
    	$this->type = 'category';
   	} elseif ($request->getParameter('tag')) {
   		$this->category = $request->getParameter('tag');
    	$this->catUrlPart = '/'.$this->category;
    	$this->type = 'tag';
    } else {
    	$this->category = null;
    	$this->catUrlPart = '';
    	$this->type = '';
    }
    
    
    $this->perPage = 10;
		// fetch daily dish rss feed list
    $dish = $d->getFeed($this->category, $this->currentPage, $this->perPage, $this->type);
    if (sizeof($dish)>0) {
    	$this->items = $dish['items'];
    	$this->total = $dish['total'];
    	$this->title = $dish['title'];
    	$pages = new Paginator($this->perPage, $this->total, $this->currentPage);
    	$pages->site_path = ($this->type == '') ? UrlToolkit::getDomainUri().'/blogs/daily-dish'.$this->catUrlPart : UrlToolkit::getDomainUri().'/blogs/daily-dish/'.$this->type.$this->catUrlPart;
    	$pages->paginate(); 
  		$this->pager = $pages->display_pages();
    } else {
    	$this->items = array();
    }
		
    $this->getResponse()->setTitle($this->post[0]['title']);

  	$content_id = DailyDishTable::insertGetDish($request->getParameter('slug'));
  	$this->contentId = $content_id;
		
  	// check if a discussion object exists for this entry (needed for comment creation and fetching)
  	  	$this->discussionObject = DiscussionTable::getDiscussion(compact('content_id'));
  	if ($this->discussionObject) {
  		$reset_cache = $this->getUser()->getAttribute('clear_comment_cache', false);
  		// fetch comments
  		$c = $this->getComments($request->getParameter('page',1), 10, $this->discussionObject['discussion_id'], $reset_cache);
  		$this->comments = $c['items'];
  		$this->comments_perPage = $c['perPage'];
  		$this->comments_total = $c['total'];
  		
  		$this->comments_pager = new Arraypager(null, 10);
  		$this->comments_pager->setResultTotal($this->comments_total);
  		$this->comments_pager->setPage($request->getParameter('page',1));
  		$this->comments_pager->init();
  		
  		if ($reset_cache) {
  			$this->getUser()->setAttribute('clear_comment_cache', false);
  		}
  		
  	} else {
  		$this->comments = array();
  		$this->comments_pager = '';
  	}
  	
  	$this->bread_crumbs = array(
      'better recipes' => UrlToolkit::getDomainUri(),
      'the daily dish' => UrlToolkit::getDomainUri() . '/blogs/daily-dish',
      strtolower($this->post[0]['title']) => null
    );


  	//Omniture
    $this->getOmniture()->setMany(array(
        'pageName' => 'Blogs:The Daily Dish:'.$this->post[0]['title'],
        'Server' => 'www.betterrecipes.com',
        'Channel' => 'Blogs',
        'prop7' => $this->getUser()->isAuthenticated() ? true : false,
        'prop18' => 'betterrecipes',
        'prop19' => 'Food',
        'prop20' => $request->getUri(),
        'eVar9' => 'Blogs:The Daily Dish:'.$this->post[0]['title'],
        'eVar14' => 'Blogs',
        'eVar18' => $this->getUser()->isAuthenticated() ? $this->getUser()->getAttribute('regSource') : '',
        'eVar24' => $this->getUser()->isAuthenticated() ? true : false
    ));
  }
  
  
  public function executePaginate_dish_list (sfWebRequest $request)
  {
  	$this->forward404Unless($request->isXmlHttpRequest());
  	$d = new DailydishWp();
	$dish = $d->getFeed($request->getParameter('tag'), $request->getParameter('page',1), 10, 'tag');
	if (sizeof($dish)>0) {
		$dish_items = $dish['items'];
		$dish_perPage = 10;
		$dish_total = $dish['total'];
	
		$dish_pager = new Arraypager(null, 10);
		$dish_pager->setResultTotal($dish_total);
		$dish_pager->setPage($request->getParameter('page',1));
		$dish_pager->init();

	} else {
		$dish_items = array();
		$dish_pager = '';
	}
	$dish_tag = $request->getParameter('tag');
	$this->renderPartial('recipes/dailydish', compact('dish_items', 'dish_pager', 'dish_tag'));
    return sfView::NONE;
  }
}
