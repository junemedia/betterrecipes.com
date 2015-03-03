<?php

/**
 * comment actions.
 *
 * @package    betterrecipes
 * @subpackage comment
 * @author     Rusty Cage <rcage@resolute.com>
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class commentActions extends sfActions
{
 
  public function preExecute()
  {
    $this->rest = $this->getOnesite()->getRest();
    
    /** 
     * @todo login works please fix this - bk 
     * @example
     * 
     * if ($this->getUser()->isAuthenticated()){
     *   $this->user_id = $this->getUser()->getOnesiteId();
     * }
     */
    //$this->user_id = 113941231; // use this id (citizencagetest) for testing purposes    
  }
 
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
  	
    $this->forward404Unless($request->isXmlHttpRequest());
  	$content_id = $request->getParameter('content_id');
  	$user_id = $request->getParameter('user_id');
  	$comment = $request->getParameter('comment');
  	$type = $request->getParameter('type');
  	
  	
  	if ($content_id == '' || $user_id == '' || $comment == '' || $type == '') {
  		$response = array('code' => 999, 'message' => 'Error adding comment, missing required fields');
  		return $this->renderText(json_encode($response));
  	} else {
	  	// check if a discussion object exists for this content object (needed for comment creation and fetching)
	  	$this->discussionObject = DiscussionTable::getDiscussion(compact('content_id'));
	  	
	  	if ($this->discussionObject) {
	  		$comment = $this->rest->addComment($user_id, $comment, $this->discussionObject['discussion_id'], $type, $content_id);
	  		$this->getUser()->setAttribute('clear_comment_cache', true);
	  		if ($type == 'recipe') {
  				$response = array('code' => 1, 'message' => 'Review successfully created');
  				return $this->renderText(json_encode($response));
  			} else {
  				return $this->renderText(json_encode($comment));
  			}
	  	} else {
	  		$content = $this->rest->createContent($type, $content_id, $type.'-'.$content_id);
	  		if ($content['code'] == 1) {
	  			$comment = $this->rest->addComment($user_id, $comment, null, $type, $content_id);
	  			//print_r($comment);
	  			$discussion_id = $comment['item']['discussion_id'];
	  			DiscussionTable::insertDiscussion(compact('content_id', 'discussion_id', 'type'));
	  			$this->getUser()->setAttribute('clear_comment_cache', true);
	  			if ($type == 'recipe') {
	  				$response = array('code' => 1, 'message' => 'Review successfully created');
	  				return $this->renderText(json_encode($response));
	  			} else {
	  				return $this->renderText(json_encode($comment));
	  			}
	  		} else {
	  			$response = array('code' => 999, 'message' => 'error creating content: '.$content['message']);
	  			return $this->renderText(json_encode($response));
	  		}
	  	}
	}
	
  	return sfView::NONE;

  }
  
  public function executeGetcomments(sfWebRequest $request) {
  	$this->forward404Unless($request->isXmlHttpRequest());
  	$content_id = $request->getParameter('contentId');
    $contentId = $content_id;
  	// check if a discussion object exists for this journal entry (needed for comment creation and fetching)
    $this->discussionObject = DiscussionTable::getDiscussion(compact('content_id'));
    if ($this->discussionObject) {
      $reset_cache = $this->getUser()->getAttribute('clear_comment_cache', false);
      // fetch comments
      $c = $this->getComments($request->getParameter('page', 1), 9, $this->discussionObject['discussion_id'], $reset_cache);
      $comments = $c['items'];
      $comments_perPage = $c['perPage'];
      $comments_total = $c['total'];

      $comments_pager = new Arraypager(null, 9);
      $comments_pager->setResultTotal($comments_total);
      $comments_pager->setPage($request->getParameter('page', 1));
      $comments_pager->init();

      if ($reset_cache) {
        $this->getUser()->setAttribute('clear_comment_cache', false);
      }
    } else {
      $comments = array();
      $comments_pager = '';
    }
  	
  	$this->renderPartial('global/comments', compact('comments', 'comments_pager', 'contentId'));
    return sfView::NONE;
  }
  
  public function executeCommentauth(sfWebRequest $request) {
  	if ($request->isMethod('post')) {
  		if ($this->getUser()->isAuthenticated()){
  			$this->redirect($request->getParameter('return_path'));
  		} else {
            $this->getUser()->setRegSourceAttribute('code', 8253);
  			$this->getUser()->setReferrer($request->getParameter('return_path'));
  			$this->redirect('@signin');
  		}
  	} else {
  		$this->redirect('@homepage');
  	}
  	return sfView::NONE;
  }
  
  
  public function executeFlag(sfWebRequest $request) {
  	$this->forward404Unless($request->isXmlHttpRequest());
  	$xref_id = $request->getParameter('xref_id');
  	$user_id = $request->getParameter('user_id');
  	$xref_type = $request->getParameter('type');
	$f = $this->rest->postFlag($user_id, $xref_id, $xref_type); 
	return $this->renderText(json_encode($f)); 	
  	return sfView::NONE;
  }
  
  
  public function executeImageupload(sfWebRequest $request) {
  	sfConfig::set('sf_web_debug', false);
  	/* Where should the images be saved? Use a trailing slash */
	$target = sfConfig::get('sf_upload_dir').'/';
	
	$type	= 'bestand';

	if ($type=='bestand') {
			$naam = strtolower(basename($_FILES['bestand']['name']));
			$naam = str_replace(' ', '-', $naam);
			$ext = '.'.$this->get_file_extension($naam);
			$naam = 'img_'.sha1($naam);
			if ($ext == '.jpg' || $ext == '.png' || $ext == '.gif' || $ext == '.jpeg') {
				if(move_uploaded_file($_FILES['bestand']['tmp_name'], $target.$naam.$ext)) {
					$url = UrlToolkit::getDomainUri().'/uploads/'.$naam.$ext;
					echo 'document.lm_imgform.wym_src.value="'.$url.'";';
				} else {
					echo 'alert("Upload error");';
				}
			} else {
				echo 'alert("Upload error - must be an valid image");';
			}
		
	}
	else {
		//die();
	}
  	
  	return sfView::NONE;	
  }
  
  private function get_file_extension($file_name)
	{
		return substr(strrchr($file_name,'.'),1);
	}

  
  protected function getComments($page, $num, $discussion_id, $reset_cache = false)
  {
    return $this->rest->getComments($page, $num, $discussion_id, 'date_created', 'DESC', $reset_cache);
  }

}