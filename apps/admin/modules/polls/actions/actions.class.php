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

  public function executeIndex(sfWebRequest $request)
  {
    
   
    $this->pager = new sfDoctrinePager('Poll', '10');
    $this->pager->setQuery(PollTable::getPolls());
    $this->pager->setPage($request->getParameter('page'), 1);
    $this->pager->init();
    
    
    $this->hp_featured = Doctrine_Core::getTable('poll')->findOneByHomepageFeatured(1);
  }

  public function executeFeatureHp(sfWebRequest $request)
  {
    $this->forward404Unless($request->isXmlHttpRequest());
    $id = $request->getParameter('id');
    // Set all the homepage-featured to 0
    Doctrine_Manager::getInstance()->getCurrentConnection()->execute('UPDATE `betterrecipes`.`poll` SET `homepage_featured`=0');
    $poll = Doctrine_Core::getTable('poll')->find($id);
    // If record does not exist create it
    if (!$poll) {
      $poll = new Poll;
      $poll->setId($id);
    }
    // Set it to homepage-featured
    $poll->setHomepageFeatured(1);
    $poll->save();
    return sfView::NONE;
  }

  public function executeDetail(sfWebRequest $request)
  {
    if ($request->isXmlHttpRequest()) {
      $selected_option = Doctrine_Core::getTable('pollOption')->find($request->getParameter('option_id'));
      $selected_option->setRecipeId($request->getParameter('recipe_id'));
      $photo_id = $request->getParameter('photo_id');
      $selected_option->setPhotoId(empty($photo_id) ? null : $photo_id);
      $selected_option->save();
    }
    $id = $request->getParameter('id');
    $this->forward404Unless($this->poll = Doctrine_Core::getTable('poll')->find(array($id)), sprintf('Object poll does not exist (%s).', $request->getParameter('id')));
    $this->hp_featured = $id == Doctrine_Core::getTable('poll')->findOneByHomepageFeatured(1) ? true : false;
    $this->forward404Unless(sizeof($this->poll) > 0, sprintf('Object poll does not exist (%s).', $request->getParameter('id')));
    
    $this->pollOptions = Doctrine_Core::getTable('pollOption')->findByPollId($id);
    
    if ($request->isXmlHttpRequest()) {
      return $this->renderPartial('options', array('poll' => $this->poll, 'pollOptions' => $this->pollOptions));
    }
  }
  
  public function executeNew(sfWebRequest $request)
  {
  	if ($this->getRequest()->isMethod('post')) {
  	 	if ($_POST['poll_title'] == '' || sizeof($_POST['optionTitle'])<2) {
  	 		$this->getUser()->setFlash('notice', 'Poll title and at least two options are required to continue.');
  	 	} else {
  	 		$poll = new Poll;
  	 		$poll->setPollTitle($_POST['poll_title']);
  	 		$poll->setCreatedAt(date('Y-m-d H:i:s'));
  	 		$poll->setUpdatedAt(date('Y-m-d H:i:s'));
  	 		$poll->save();
  	 		foreach( $_POST['optionTitle'] as $v ) {
  	 			$pollOption = new PollOption;
  	 			$pollOption->setOptionTitle($v);
  	 			$pollOption->setPollId($poll->getId());
  	 			$pollOption->save();
  	 		}
  	 		$this->redirect('@poll_detail?id=' . $poll->getId());
  	 	}
  	} 
  }
  
  public function executeEditOptionTitle(sfWebRequest $request)
  {
  	if ($request->isXmlHttpRequest()) {
  		$selected_option = Doctrine_Core::getTable('pollOption')->find($request->getParameter('option_id'));
  		$selected_option->setOptionTitle($request->getParameter('title'));
  		$selected_option->save();
  		$this->poll = Doctrine_Core::getTable('poll')->find(array($request->getParameter('id')));
  		$this->pollOptions = Doctrine_Core::getTable('pollOption')->findByPollId($request->getParameter('id'));
  		return $this->renderPartial('options', array('poll' => $this->poll, 'pollOptions' => $this->pollOptions));
  	}
  	return sfView::NONE;
  }
  
  public function executeToggleActivation(sfWebRequest $request) 
  {
  	if ($request->isXmlHttpRequest()) {
  		$poll = Doctrine_Core::getTable('poll')->find(array($request->getParameter('id')));
  		$poll->setActive($request->getParameter('active'));
  		$poll->save();
  	}
  	return sfView::NONE;
  }

  public function executeSearchRecipes(sfWebRequest $request)
  {
    $this->forward404Unless($request->isXmlHttpRequest());
    $this->getResponse()->setContentType('application/json');
    $q = Doctrine_Manager::getInstance()->getCurrentConnection()->execute('SELECT `recipe`.`id`, `recipe`.`name` FROM `betterrecipes`.`recipe` INNER JOIN `photo` ON `recipe`.`id` = `photo`.`recipe_id` WHERE `is_active` = 1 AND `recipe`.`name` LIKE "%' . $request->getParameter('term') . '%" LIMIT 30;');
    $result = $q->fetchAll(Doctrine_Core::FETCH_ASSOC);
    return $this->renderText(json_encode($result));
  }

  public function executeGetRecipe(sfWebRequest $request)
  {
    $this->forward404Unless($request->isXmlHttpRequest());
    $recipe = Doctrine_Core::getTable('recipe')->find($request->getParameter('id'));
    return $this->renderPartial('recipe', compact('recipe'));
  }

}