<?php

/**
 * contests actions.
 *
 * @package    betterrecipes
 * @subpackage contests
 * @author     Rusty Cage <rcage@resolute.com>
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class contestsActions extends sfActions
{

  public function executeIndex(sfWebRequest $request)
  {
    $this->activeContests = ContestTable::getActiveContests()->execute();
    $this->pendingContests = ContestTable::getPendingContests()->execute();
    $this->pager = new sfDoctrinePager('Contest', '10');
    $this->pager->setQuery(ContestTable::getPreviousContests());
    $this->pager->setPage($request->getParameter('page'), 1);
    $this->pager->init();

    $this->resetTimezoneEST();
  }

  public function executeSort(sfWebRequest $request)
  {
    $this->sortContests = $request->getParameter('contest_ids');
    if ($request->isMethod('post') && $request->getParameter('sorted')) {
      $this->sortContests($request->getParameter('contest_ids'));
      $this->success = "Active Contest Reordering Saved";
    }

    $this->pager = new sfDoctrinePager('Contest', '25');
    $this->pager->setQuery(ContestTable::getActiveContests());
    $this->pager->setPage($request->getParameter('page', 1));
    $this->pager->init();
  }

  public function executeAddSponsor(sfWebRequest $request)
  {
    $this->forward404Unless($request->isXmlHttpRequest());
    $contestId = $request->getParameter('itemId');
    $sponsors = SponsorTable::getActiveSponsors();

    return $this->renderPartial('sponsor', array('sponsors' => $sponsors, 'contestId' => $contestId));
  }

  public function executeUpdateSponsor(sfWebRequest $request)
  {
    $this->forward404Unless($request->isXmlHttpRequest());

    if (!$contestId = $this->getRequestParameter('itemId')) {
      return $this->renderText(json_encode('Please choose a Contest'));
    } else if ((!$sponsorId = $this->getRequestParameter('sponsorId')) && ($this->getRequestParameter('sponsorId') != 0)) {
      return $this->renderText(json_encode('Please choose a sponsor'));
    }
    ContestTable::updateSponsor($contestId, $sponsorId);

    $updatedContest = Doctrine_Core::getTable('Contest')
      ->createQuery('c')
      ->where('c.id = ?', $contestId)
      ->fetchOne();
    sfView::NONE;
    $sponsorName = $updatedContest->getSponsor()->getName();
    if (isset($sponsorName))
      return $this->renderText($sponsorName);
    else
      return $this->renderText("None");
  }

  public function executeUpdateContestantStatus(sfWebRequest $request)
  {
    $this->forward404Unless($request->isXmlHttpRequest());
    $contestant = Doctrine_Core::getTable('Contestant')->find(array($request->getParameter('contestant_id')));
    if ($contestant->getRecipe()->getIsActive() == 0 && $request->getParameter('status') == 0)
      $alert = "<script>$(document).ready(function(){alert('You must activate this recipe before you can activate it as a contestant')});</script>";
    else {
      $alert = "";
      $contestant->setIsActive($request->getParameter('status') == 1 ? 0 : 1);
      $contestant->save();
    }
    return $this->renderText($alert . '<input type="checkbox" value="' . $contestant->getIsActive() . '" onchange="updateContestantStatus($(this))"' . ($contestant->getIsActive() ? ' checked' : '') . '>');
  }
  
  public function executeExportcontest(sfWebRequest $request)
  {
	$this->forward404Unless($this->contest = Doctrine_Core::getTable('Contest')->find(array($request->getParameter('id'))), sprintf('Object contest does not exist (%s).', $request->getParameter('id')));
	$this->report = ContestantTable::getContestReport($this->contest->getId(), $this->contest->getStartDate());
	$this->setlayout('csv');
	$this->getResponse()->clearHttpHeaders();
	$this->getResponse()->setHttpHeader('Content-Type', 'application/vnd.ms-excel');
	$this->getResponse()->setHttpHeader('Content-Disposition', 'attachment; filename=contest_report_' . $this->contest->getSlug() . '.csv');
	
  }

  public function executeDetail(sfWebRequest $request)
  {
    $this->forward404Unless($this->contest = Doctrine_Core::getTable('Contest')->find(array($request->getParameter('id'))), sprintf('Object contest does not exist (%s).', $request->getParameter('id')));

    //Set timezone
    date_default_timezone_set(timezone_name_from_abbr($this->contest->getTimezone()));
    //Editing - If contest is in the past, then do not allow editing
    //($this->contest->getEndDate() >= date('Y-m-d')) ? $this->edit = true : $this->edit = false;
    $this->edit = true;

    //All contest periods 
    $this->allContests = ContestPeriodTable::getAllContestPeriods($request->getParameter('id'));

    //Get the current contest period (current week)
    if ($request->getParameter('cp')) {
      $this->contestPeriod = Doctrine_Core::getTable('ContestPeriod')->find($request->getParameter('cp'));
    } else {
      $this->contestPeriod = ContestPeriodTable::getCurrentContestPeriod($request->getParameter('id'));
    }
    //Dropdown Menu for Contest Periods
    $this->offset = $this->contest->getCurrentWeekOffset();

    //All contestants entered into this contest
    $this->pager = new sfDoctrinePager('Contestant', '50');
    $this->pager->setQuery(ContestantTable::getContestantsByContest($this->contest->getId(), false));
    $this->pager->setPage($request->getParameter('page', 1));
    $this->pager->init();

    $this->bread_crumbs = array(
      'Contests' => UrlToolkit::getDomainUri() . '/admin/contests',
      $this->contest->getName() => null
    );

    $this->resetTimezoneEST(); //Reset timezone to EST
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new ContestForm();

    $this->bread_crumbs = array(
      'Contests' => UrlToolkit::getDomainUri() . '/admin/contests',
      'Create' => null
    );
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new ContestForm();

    $this->processForm($request, $this->form, 'create');

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($contest = Doctrine_Core::getTable('Contest')->find(array($request->getParameter('id'))), sprintf('Object contest does not exist (%s).', $request->getParameter('id')));
    $this->form = new ContestForm($contest);

    $this->sponsors = SponsorTable::getActiveSponsors();

    $this->bread_crumbs = array(
      'Contests' => UrlToolkit::getDomainUri() . '/admin/contests',
      $contest->getName() => null
    );
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($contest = Doctrine_Core::getTable('Contest')->find(array($request->getParameter('id'))), sprintf('Object contest does not exist (%s).', $request->getParameter('id')));
    $this->sponsors = SponsorTable::getActiveSponsors();
    $this->form = new ContestForm($contest);

    $this->processForm($request, $this->form, 'update');

    $this->setTemplate('edit');
  }

  protected function processForm(sfWebRequest $request, sfForm $form, $type = 'update')
  {
    //var_dump($form->getName(), $request->getParameter($form->getName())); exit;
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));

    if ($form->isValid()) {
      $file = $this->form->getValue('image');
      if ($file) {

        $filename = $file->getOriginalName();
        //$extension = $file->getExtension($file->getOriginalExtension());
        $filePath = sfConfig::get('sf_upload_dir') . '/contest/';

        @mkdir($filePath, 0777, true);
        $file->save($filePath . $filename);
        $form->getObject()->setImage($filename);
      }

      if ($type == 'create')
        $contest = $form->create();
      else
        $contest = $form->save();

      $this->redirect('contests/edit?id=' . $contest->getId());
    }
  }

  /*
    public function executeDelete(sfWebRequest $request)
    {
    $request->checkCSRFProtection();

    $this->forward404Unless($contest = Doctrine_Core::getTable('Contest')->find(array($request->getParameter('id'))), sprintf('Object contest does not exist (%s).', $request->getParameter('id')));
    $contest->delete();

    $this->redirect('contests/index');
    }
   */

  public function executeWinnerForm(sfWebRequest $request)
  {
    $this->forward404Unless($request->isXmlHttpRequest());
    sfView::NONE;

    if ($request->getParameter('winnerType') == 'user') {
      $contestWinner = Doctrine_Core::getTable('ContestPeriod')->find($request->getParameter('cpId'))->getOfficialWinner();
      if (empty($contestWinner))
        $contestWinner = Doctrine_Core::getTable('ContestPeriod')->find($request->getParameter('cpId'))->getUnofficialWinner();
    } else {
      $contestWinner = Doctrine_Core::getTable('ContestPeriod')->find($request->getParameter('cpId'))->getEditorWinner();
    }

    if (empty($contestWinner))
      $contestWinner = '';

    return $this->renderPartial('winnerForm', array('cpId' => $request->getParameter('cpId'), 'contestWinner' => $contestWinner, 'contestId' => $request->getParameter('contestId'), 'winnerType' => $request->getParameter('winnerType')));
  }

  public function executeAutocomplete(sfWebRequest $request)
  {
    $this->forward404Unless($request->isXmlHttpRequest());
    sfView::NONE;
    $text = $request->getParameter('textField');
    $contestId = $request->getParameter('contestId');

    $results = Doctrine_Query::create()->select('id, name')->from('Recipe r')->where('r.name LIKE ?', "%" . $text . "%")->leftJoin('r.Contestant c')->andWhere('c.contest_id = ?', $contestId)->limit(10)->fetchArray();

    foreach ($results as $r) {
      $r['id'] = (int) $r['id'];
      $r['name'] = $r['name'];
      $autoArray[] = $r;
    }

    return $this->renderText(json_encode($autoArray));
  }

  //Edit the User Selected Winner
  public function executeEditWinner(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));
    sfView::NONE;
    //Params
    $contestPeriodId = $request->getParameter('contestPeriodId');
    $recipeId = $request->getParameter('recipeId');
    $winnerType = $request->getParameter('winnerType');
    $winnerBlogId = $request->getParameter('winnerBlogId');
    //Get new winner id
    $newWinner = Doctrine::getTable('Contestant')->createQuery('c')->where('c.recipe_id = ?', $recipeId)->fetchOne();

    if ($winnerType == 'user' && isset($newWinner)) {
      //Set official winner      
      Doctrine_Query::create()->update('ContestPeriod cp')->set('cp.official_winner_id', '?', $newWinner->getId())->where('cp.id = ?', $contestPeriodId)->execute();
    } else if ($winnerType == 'editor' && isset($newWinner)) { // editor winner   
      //Set new winner
      Doctrine_Query::create()->update('ContestPeriod cp')->set('cp.editor_winner_id', '?', $newWinner->getId())->where('cp.id = ?', $contestPeriodId)->execute();
    }

    $allContests = ContestPeriodTable::getAllContestPeriods($request->getParameter('contestId'));
    $contestPeriod = Doctrine_Core::getTable('ContestPeriod')->find($contestPeriodId);
    $contest = Doctrine_Core::getTable('Contest')->find($request->getParameter('contestId'));
    (strtotime($contest->getEndDate()) < strtotime(date('Y/m/d H:i:s'))) ? $edit = 'no' : $edit = 'yes';

    $this->redirect('contests/detail?id=' . $contest->getId() . '&edit=' . $edit . '&cp=' . $contestPeriodId);
  }

  private function sortContests($contests = array())
  {
    if (count($contests) > 0):
      foreach ($contests as $key => $id) {
        $sortOrder = $key + 1;
        Doctrine_Core::getTable('Contest')->find($id)->setSequence($sortOrder)->save();
        /* change save to update and add update method in phototable to update user_id and updated at fields */
      }
    endif;
  }

  private function resetTimezoneEST()
  {
    date_default_timezone_set(timezone_name_from_abbr("EST"));
  }

}
