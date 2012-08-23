<?php

/**
 * videos actions.
 *
 * @package    betterrecipes
 * @subpackage videos
 * @author     Rusty Cage <rcage@resolute.com>
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class videosActions extends sfActions
{

  public function preExecute()
  {
    $this->rest = $this->getOnesite()->getRest();
    
     if ($this->getUser()->isAuthenticated()){
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
  	// most liked (views)
    $liked = $this->getVideos($this->getRequestParameter('page',1), 10, 'views');
     if (sizeof($liked) >0) {
	    $this->liked = $liked['items'];
	    $this->liked_perPage = $liked['perPage'];
	    $this->liked_total = $liked['total'];
	    
  		$this->liked_pager = new Arraypager(null, 10);
  	 	$this->liked_pager->setResultTotal($this->liked_total);
  	 	$this->liked_pager->setPage($this->getRequestParameter('page',1));
  	 	$this->liked_pager->init();
  	} else {
  		$this->liked = array();
  		$this->liked_pager = '';
  	}
  	
  	// most recent (date)
    $recent = $this->getVideos($this->getRequestParameter('page',1), 10, 'date');
     if (sizeof($recent)>0) {
	    $this->recent = $recent['items'];
	    $this->recent_perPage = $recent['perPage'];
	    $this->recent_total = $recent['total'];
	    
  		$this->recent_pager = new Arraypager(null, 10);
  	 	$this->recent_pager->setResultTotal($this->recent_total);
  	 	$this->recent_pager->setPage($this->getRequestParameter('page',1));
  	 	$this->recent_pager->init();
  	} else {
  		$this->recent = array();
  		$this->recent_pager = '';
  	}
    
    $sponsor = array(
        'id' => 34049,
        'name' => 'Kelloggs'
    );
  	
  	// sponsored
  	$sponsored = $this->getVideos($this->getRequestParameter('page',1), 5, 'date', $sponsor['id']);
  	if (sizeof($sponsored)>0) {
	    $this->sponsored = $sponsored['items'];
	} else {
		$this->sponsored = array();
	}
  	
    // load video wonder
    //$this->videowonder = $this->rest->featuredVideoWonder();
    // meta
    $response = $this->getResponse();
    $response->setTitle('Cooking Videos | Online Videos | Share Recipes | Online Recipes | Better Recipes');
    $response->addMeta('description', 'Post your cooking videos preparing favorite online recipes and offering cooking tips or enjoy one of the videos here for new inspiration.');
    $response->addMeta('keywords', 'cooking videos, online videos, online recipes, share recipes, cooking tips');
    
    /**
     * Omniture
     */
    $this->getOmniture()->setMany(array(
        'pageName' => 'Category:Video',
        'server' => 'www.betterrecipes.com',
        'channel' => 'Videos',
        'prop7' => $this->getUser()->isAuthenticated(),
        'prop18' => 'betterrecipes',
        'prop19' => 'Food',
        'prop20' => $this->getRequest()->getUri(),
        'eVar9' => 'Category:Video',
        'eVar14' => 'Videos',
        'eVar24' => $this->getUser()->isAuthenticated(),
    ));
	
	// removed by Rusty, erroneous
	/*
    if ($sponsor) {
      $this->getOmniture()->set('prop11', $sponsor['name']);
    }*/
  }
  
  
  
  public function executePaginate_liked(sfWebRequest $request)
  {
  	$this->forward404Unless($request->isXmlHttpRequest());
  	$l = $this->getVideos($this->getRequestParameter('page',1), 10, 'views');
     if (sizeof($l['items'])>0) {
	    $liked = $l['items'];
	    $liked_perPage = $l['perPage'];
	    $liked_total = $l['total'];
	    
  		$liked_pager = new Arraypager(null, 2);
  	 	$liked_pager->setResultTotal($liked_total);
  	 	$liked_pager->setPage($this->getRequestParameter('page',1));
  	 	$liked_pager->init();
  	} else {
  		$liked = array();
  		$liked_pager = '';
  	}	$this->renderPartial('videos_liked', compact('liked', 'liked_pager'));
  	return sfView::NONE;
  }
  
  
  public function executePaginate_recent(sfWebRequest $request)
  {
  	$this->forward404Unless($request->isXmlHttpRequest());
  	$r = $this->getVideos($this->getRequestParameter('page',1), 10, 'date');
     if (sizeof($r['items'])>0) {
	    $recent = $r['items'];
	    $recent_perPage = $r['perPage'];
	    $recent_total = $r['total'];
	    
  		$recent_pager = new Arraypager(null, 10);
  	 	$recent_pager->setResultTotal($recent_total);
  	 	$recent_pager->setPage($this->getRequestParameter('page',1));
  	 	$recent_pager->init();
  	} else {
  		$recent = array();
  		$recent_pager = '';
  	}	$this->renderPartial('videos_recent', compact('recent', 'recent_pager'));
  	return sfView::NONE;
  }

  
  public function executeDetail(sfWebRequest $request)
  {
  	$this->forward404Unless($this->getRequestParameter('id') && $this->getRequestParameter('slug'));
  	$content_id = $this->getRequestParameter('id');
  	$this->contentId = $content_id;
  	$this->video = $this->getVideo($content_id);
  	// increment the views for video
  	$this->rest->incrementViewsVideo($content_id);
  	
  	// check if a discussion object exists for this journal entry (needed for comment creation and fetching)
  	  	$this->discussionObject = DiscussionTable::getDiscussion(compact('content_id'));
  	if ($this->discussionObject) {
  		$reset_cache = $this->getUser()->getAttribute('clear_comment_cache', false);
  		// fetch comments
  		$c = $this->getComments($this->getRequestParameter('page',1), 9, $this->discussionObject['discussion_id'], $reset_cache);
  		$this->comments = $c['items'];
  		$this->comments_perPage = $c['perPage'];
  		$this->comments_total = $c['total'];
  		
  		$this->comments_pager = new Arraypager(null, 9);
  		$this->comments_pager->setResultTotal($this->comments_total);
  		$this->comments_pager->setPage($this->getRequestParameter('page',1));
  		$this->comments_pager->init();
  		if ($reset_cache) {
  			$this->getUser()->setAttribute('clear_comment_cache', false);
  		}
  	} else {
  		$this->comments = array();
  		$this->comments_pager = '';
  	}
    
    $tiers = $this->rest->getUserTiers($this->video['user_id']);
  	$this->sponsored = false;
  	if (sizeof($tiers[0])>0) {
	  	for ($i=0; $i<count($tiers); $i++) {
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
        'pageName' => 'Videos:Detail:'.$this->video['title'],
        'server' => 'www.betterrecipes.com',
        'channel' => 'Videos',
        'prop1' => 'Videos:Detail',
        'prop7' => $this->getUser()->isAuthenticated(),
        'prop9' => 'brrecipe:mem'.$content_id,
        'prop11' => $sponsor_name,
        'prop18' => 'betterrecipes',
        'prop19' => 'Food',
        'prop20' => $this->getRequest()->getUri(),
        'eVar9' => 'Videos:Detail:'.$this->video['title'],
        'eVar14' => 'Videos',
        'eVar24' => $this->getUser()->isAuthenticated(),
    ));    
  }

  
  
  public function executeUpload(sfWebRequest $request)
  {
  	// check user auth
  	if (is_null($this->user_id)) {
  		if ($request->getParameter('id')) {
  			$this->getUser()->setReferrer( UrlToolkit::getDomainUri().$this->getController()->genUrl('@video_upload?id='.$request->getParameter('id')) );
  		} else {
  			$this->getUser()->setReferrer( UrlToolkit::getDomainUri().$this->getController()->genUrl('@video_upload') );
  		}
        $this->getUser()->setRegSourceAttribute('code', 8264);
  		$this->redirect('@signin');
  	}
  	
  	$this->form = new VideouploadForm(array('referrer' =>  $request->getReferer()));
  	
  	if ($request->isMethod('post')) {
  	
  		// check user auth
	  	if (is_null($this->user_id)) {
	  		if ($request->getParameter('id')) {
	  			$this->getUser()->setReferrer( UrlToolkit::getDomainUri().$this->getController()->genUrl('@video_upload?id='.$request->getParameter('id')) );
	  		} else {
	  			$this->getUser()->setReferrer( UrlToolkit::getDomainUri().$this->getController()->genUrl('@video_upload') );
	  		}
	  		$this->redirect('@signin');
	  	}
  	
  		$this->form->bind($request->getParameter('videoupload'), $request->getFiles('videoupload'));
  		if ($this->form->isValid()) {
  			$file = $this->form->getValue('file');
  			$filename = 'video_'.sha1($file->getOriginalName());
  			$extension = $file->getExtension($file->getOriginalExtension());
  			$file->save(sfConfig::get('sf_upload_dir').'/content/'.$filename.$extension);
  			
  			$url = UrlToolkit::getDomainUri().'/uploads/content/'.$filename.$extension;
  			$caption = (trim($this->form->getValue('caption')) != '') ? $this->form->getValue('caption') : null;
  			
  			if ($request->getParameter('id')) {
  				// user is attempting to upload a photo to a group they belong to, verify user belongs to group
  				$belongs = $this->rest->getUserGroupList($this->user_id);
  				if ( in_array($request->getParameter('id'), $belongs) ) {
  					$blog_id = $request->getParameter('id');
  				} else {
  					$blog_id = null;
  				}
  			} else {
  				$blog_id = null;
  			}
  			
  			// transmit video to OneSite API
  			$video = $this->uploadVideo($this->user_id, $url, $caption, $blog_id);
  			//print_r($video);
  			if (isset($video['item']['video_id'])) {
  				$video_id = $video['item']['video_id'];
  				// set content category if user selected a category from drop down list
  				if ($this->form->getValue('categories') != 0) {
  					$tag = $this->addContentTag($this->user_id, 'video', $video['item']['video_id'], $this->form->getValue('categories'));
  					// set the caption cause OneSite can't fix a simple API call in the first place
  					$this->rest->updateVideoTitle($video['item']['video_id'], $caption);
  				}
  				$this->getUser()->setFlash('notice', 'Your video has been successfully uploaded.');
                $this->getUser()->setFlash('onUpload', 'video');
//  				$return_path = ($this->form->getValue('referrer') != '') ? $this->form->getValue('referrer') :'videos/upload';
                $return_path = '/videos/'.Doctrine_Inflector::urlize($caption).'/'.$video_id;
  				$this->redirect($return_path);
  			} else {
  				$this->getUser()->setFlash('notice', $video['message']);
  			}
  		} 
  		
  	}
  	 
    /**
     * Omniture
     */
    $this->getOmniture()->setMany(array(
        'pageName' => 'Videos:Upload',
        'server' => 'www.betterrecipes.com',
        'channel' => 'Videos',
        'prop1' => 'Videos:Upload',
        'prop7' => $this->getUser()->isAuthenticated(),
        'prop18' => 'betterrecipes',
        'prop19' => 'Food',
        'prop20' => $this->getRequest()->getUri(),
        'eVar9' => 'Videos:Upload',
        'eVar14' => 'Videos',
        'eVar24' => $this->getUser()->isAuthenticated(),
    ));
  }
  
  
  
  
  
  
  protected function uploadVideo($user_id, $url, $caption, $blog_id)
  {
  	return $this->rest->uploadVideo($user_id, $url, $caption, $blog_id);
  }
  
  protected function addContentTag($user_id, $xref_type, $xref_id, $tag_id)
  {
  	return $this->rest->addContentTag($user_id, $xref_type, $xref_id, $tag_id);
  }
  
  protected function getVideos($page, $per_page, $sort, $tier_id = null)
  {
  	return $this->rest->getVideos($page, $per_page, $sort, null, null, $tier_id);
  }
  
  protected function getVideo($video_id)
  {
  	return $this->rest->getVideo($video_id);
  }
  
  
   protected function addComment($user_id, $comment, $discussion_id, $type, $content_id)
  {
  	return $this->rest->addComment($user_id, $comment, $discussion_id, $type, $content_id);
  }
  
   protected function getComments($page, $num, $discussion_id, $reset_cache = false)
  {
  	return $this->rest->getComments($page, $num, $discussion_id, 'date_created', 'DESC', $reset_cache);
  }

}
