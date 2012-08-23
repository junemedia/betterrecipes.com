<?php

/**
 * users actions.
 *
 * @package    betterrecipes
 * @subpackage users
 * @author     Rusty Cage <rcage@resolute.com>
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class usersActions extends sfActions
{

  public function executeAdministrators(sfWebRequest $request)
  {
    $this->pager = null;
    $criteria = $request->getParameterHolder()->getAll();
    if (isset($criteria['email'])) {
      $this->query = '&email=' . $criteria['email'];
      $this->pager = new sfDoctrinePager('User', '25');
      $this->pager->setQuery(UserTable::getFilteredAdmins($criteria));
      $this->pager->setPage($request->getParameter('page', 1));
      $this->pager->init();
    }
  }

  public function executeIndex(sfWebRequest $request)
  {
    $this->pager = null;
    $criteria = $request->getParameterHolder()->getAll();
    if (isset($criteria['keyword'])) {
      $this->query = '&searchby=' . $criteria['searchby'] . '&method=' . $criteria['method'] . '&keyword=' . $criteria['keyword'];
      $this->pager = new sfDoctrinePager('User', '25');
      $this->pager->setQuery(UserTable::getSearchQuery($criteria));
      $this->pager->setPage($request->getParameter('page', 1));
      $this->pager->init();
    }
  }

  public function executePremiums(sfWebRequest $request)
  {
    $criteria = $request->getParameterHolder()->getAll();
    $this->query = isset($criteria['sortby']) ? '&sortby=' . $criteria['sortby'] : '';
    $this->query .= isset($criteria['order']) ? '&order=' . $criteria['order'] : '';
    $this->pager = new sfDoctrinePager('User', '25');
    $this->pager->setQuery(UserTable::getPremiumUsersQuery($criteria));
    $this->pager->setPage($request->getParameter('page', 1));
    $this->pager->init();
  }

  public function executeUpdateUserStatus(sfWebRequest $request)
  {
    $this->forward404Unless($request->isXmlHttpRequest());
    $params = $request->getParameterHolder()->getAll();
    $user = Doctrine_Core::getTable('User')->find(array($request->getParameter('user_id')));
    $this->forward404Unless($recipe = Doctrine_Core::getTable('User')->find(array($request->getParameter('user_id'))), sprintf('Object user does not exist (%s).', $request->getParameter('user_id')));
    if ($params['update_element'] == 'is_active') {
      $user->setIsActive($params['status']);
    } else {
      $user->setIsPremium($params['status']);
    }
    $user->save();
    return $this->renderPartial('user_row', compact('user'));
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new AdminSignupForm();
    $this->existingForm = new AdminAddExistingUserForm();
    if ($request->isMethod(sfRequest::POST)) {
      $type = $request->getParameter('type');
      if ($type == 'new') {
        $this->form->bind($request->getParameter($this->form->getName()), $request->getFiles($this->form->getName()));
        if ($this->form->isValid()) {
          $admin = $this->form->signup();
          if ($admin)
            $this->redirect('users/detail?id=' . $admin['user_id']);
          else
            $this->errorMsg = 'User could not be registered at this time.';
        }
      } else if ($type == 'exist') {
        $this->existingForm->bind($request->getParameter($this->existingForm->getName()));
        if ($this->existingForm->isValid()) {
          // Save the user data TODO 
        }
      }
    }
  }

  public function executeDetail(sfWebRequest $request)
  {
    $this->forward404Unless($this->user = Doctrine_Core::getTable('User')->find(array($request->getParameter('id'))), sprintf('Object user does not exist (%s).', $request->getParameter('id')));
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($this->user = Doctrine_Core::getTable('User')->find(array($request->getParameter('id'))), sprintf('Object user does not exist (%s).', $request->getParameter('id')));
    $this->form = new AdminProfileForm($this->user);
    if ($request->isMethod(sfRequest::POST)) {
      $this->form->bind($request->getParameter($this->form->getName()), $request->getFiles($this->form->getName()));
      if ($this->form->isValid()) {
        $this->form->update();
        $this->getUser()->setFlash('notice', 'Your profile was saved');
        $this->redirect('users_detail', array('id' => $this->user->getId()));
      } else {
        $errorMsg = "Profile information not valid.";
      }
    }
  }

}