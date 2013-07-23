<?php

/**
 * tips actions.
 *
 * @package    betterrecipes
 * @subpackage tips
 * @author     Rusty Cage <rcage@resolute.com>
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class tipsActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    
    $this->tipTitle = $request->getParameter('tipTitle');
    $this->sort = $request->getParameter('sort');
    $this->sortDir = $request->getParameter('sortDir');
    $params = array('tipTitle' => $request->getParameter('tipTitle'),
                    'sort'     => $request->getParameter('sort'),
                    'sortDir'  => $request->getParameter('sortDir'));
    $this->pager = new sfDoctrinePager('Tip', '25');
    $this->pager->setQuery(TipTable::getFilteredTips($params));
    $this->pager->setPage($request->getParameter('page'), 1);
    $this->pager->init();
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new TipForm();
    $this->contests = ContestTable::getContestsAndIds();
    $this->bread_crumbs = array(
      'Tips' => UrlToolkit::getDomainUri() . '/admin/tips', 
      'Create' => null
    );
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));


    $this->form = new TipForm();
    $form = $this->form;

    $form->bind($request->getParameter($form->getName()));
    //print_r($form->getErrorSchema()->getErrors());

     if ($form->isValid())
     {
      $tip = $form->create();

      $id_list = $request->getParameter('contest_ids');
      $contest_array = explode(',', $id_list);

      foreach( $contest_array as $contest_id )
      {
        if( $contest_id != '' )
        {
          $tip_contest_form = new TipContest();
          $tip_contest_form->setContestId($contest_id);
          $tip_contest_form->setTipId($tip->getId());
          $tip_contest_form->save();
        }
      }

      $this->redirect('tips/edit?id='.$tip->getId());
     }else
     {
      $this->setTemplate('new');
     }

    
  }

  public function executeDetail(sfWebRequest $request)
  {
    $this->forward404Unless($recipe = Doctrine_Core::getTable('Tip')->find(array($request->getParameter('id'))), sprintf('Object tip does not exist (%s).', $request->getParameter('id')));
    $this->tip = Doctrine_Core::getTable('Tip')->find($request->getParameter('id'));
    $this->contests = TipContestTable::getSelectedContestsByTipId($request->getParameter('id'));

    $this->bread_crumbs = array(
      'Tips' => UrlToolkit::getDomainUri() . '/admin/tips', 
      ucwords($this->tip->getTitle()) => null
    );
  }
  
  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($tip = Doctrine_Core::getTable('Tip')->find(array($request->getParameter('id'))), sprintf('Object tip does not exist (%s).', $request->getParameter('id')));
    $this->form = new TipForm($tip);
    $this->contests = ContestTable::getContestsAndIds();
    $this->selected_contests = TipContestTable::getSelectedContestsByTipId($request->getParameter('id'));
    $this->bread_crumbs = array(
      'Tips' => UrlToolkit::getDomainUri() . '/admin/tips', 
      ucwords($this->form->getObject()->getTitle()) => null
    );
  }

  public function executeUpdate(sfWebRequest $request)
  {
    //var_dump( $request->isMethod(sfRequest::PUT) );
    //exit;
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($tip = Doctrine_Core::getTable('Tip')->find(array($request->getParameter('id'))), sprintf('Object tip does not exist (%s).', $request->getParameter('id')));
    $this->form = new TipForm($tip);
    $current_selected_contests = TipContestTable::getSelectedContestsByTipId($request->getParameter('id'));
    $id_list = $request->getParameter('contest_ids');
    $contest_array = explode(',', $id_list);

    foreach( $current_selected_contests as $contest )
    {
      if( !in_array( $contest->getId(), $contest_array ) )
      {
        //Delete from DB
        $tip_contest = TipContestTable::getTipContest($request->getParameter('id'), $contest->getId());
        $tip_contest->delete();
      }else
      {
        //remove ID as it is already in the DB
        unset( $contest_array[ key($contest_array) ]);
      }
    }

    foreach( $contest_array as $contest_id )
    {
      if( $contest_id != '' )
      {
        //add each new ID to the Table
        $tip_contest_form = new TipContest();
        $tip_contest_form->setContestId($contest_id);
        $tip_contest_form->setTipId($tip->getId());
        $tip_contest_form->save();
      }
    }

    $this->selected_contests = TipContestTable::getSelectedContestsByTipId($request->getParameter('id'));
    $this->contests = ContestTable::getContestsAndIds();
    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($tip = Doctrine_Core::getTable('Tip')->find(array($request->getParameter('id'))), sprintf('Object tip does not exist (%s).', $request->getParameter('id')));
    $tip->delete();

    $this->redirect('tips/index');
  }
}
