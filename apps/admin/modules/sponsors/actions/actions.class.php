<?php

/**
 * sponsors actions.
 *
 * @package    betterrecipes
 * @subpackage sponsors
 * @author     Rusty Cage <rcage@resolute.com>
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class sponsorsActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $this->sponsorsName = $request->getParameter('sponsorsName');
    $this->sort = $request->getParameter('sort');
    $this->sortDir = $request->getParameter('sortDir');        
    $params = array('sponsorsName' => $request->getParameter('sponsorsName'), 
                    'sort'     => $request->getParameter('sort'),
                    'sortDir'  => $request->getParameter('sortDir'));
    $this->pager = new sfDoctrinePager('Sponsor', '25');
    $this->pager->setQuery(SponsorTable::getFilteredSponsors($params));
    $this->pager->setPage($request->getParameter('page', 1));
    $this->pager->init();
  }

  public function executeUpdateActive(sfWebRequest $request)
  {    
    $this->forward404Unless($request->isXmlHttpRequest());
    $sponsorId = $this->getRequestParameter('sponsorId');
    $active = $this->getRequestParameter('active');
    if (isset($sponsorId) && isset($active)) {
      SponsorTable::updateActive($sponsorId, $active);
    }
    sfView::NONE;    
  }
  
  public function executeNew(sfWebRequest $request)
  {
    $this->form = new SponsorForm();
    
    $this->bread_crumbs = array(
      'Sponsors' => UrlToolkit::getDomainUri() . '/admin/sponsors', 
      'Create' => null
    );
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new SponsorForm();
    $form = $this->form;

    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $sponsor = $form->create();

      $this->redirect('sponsors/edit?id='.$sponsor->getId());
    }

    $this->setTemplate('new');
  }

  public function executeDetail(sfWebRequest $request)
  {
    $this->forward404Unless($sponsor = Doctrine_Core::getTable('Sponsor')->find(array($request->getParameter('id'))), sprintf('Object sponsor does not exist (%s).', $request->getParameter('id')));
    $this->sponsor = Doctrine_Core::getTable('Sponsor')->find($request->getParameter('id'));
    
    $this->bread_crumbs = array(
      'Sponsors' => UrlToolkit::getDomainUri() . '/admin/sponsors', 
      ucwords($this->sponsor->getName()) => null
    );
  }
  
  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($sponsor = Doctrine_Core::getTable('Sponsor')->find(array($request->getParameter('id'))), sprintf('Object sponsor does not exist (%s).', $request->getParameter('id')));
    $this->form = new SponsorForm($sponsor);
    
    $this->bread_crumbs = array(
      'Sponsors' => UrlToolkit::getDomainUri() . '/admin/sponsors', 
      ucwords($this->form->getObject()->getName()) => null
    );
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($sponsor = Doctrine_Core::getTable('Sponsor')->find(array($request->getParameter('id'))), sprintf('Object sponsor does not exist (%s).', $request->getParameter('id')));
    $this->form = new SponsorForm($sponsor);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($sponsor = Doctrine_Core::getTable('Sponsor')->find(array($request->getParameter('id'))), sprintf('Object sponsor does not exist (%s).', $request->getParameter('id')));
    //Delete Sponsor Id's from Articles if they have this sponsor
    $items = Doctrine_Core::getTable('Article')->findBySponsorId($request->getParameter('id'));
    foreach($items as $i):
      $i->setSponsorId(NULL);
      $i->save();
    endforeach;
    //Delete Sponsor Id's from Slideshows if they have this sponsor
    $items = Doctrine_Core::getTable('Slideshow')->findBySponsorId($request->getParameter('id'));
    foreach($items as $i):
      $i->setSponsorId(NULL);
      $i->save();
    endforeach;
    //Delete Sponsor Id's from Recipes if they have this sponsor
    $items = Doctrine_Core::getTable('Recipe')->findBySponsorId($request->getParameter('id'));
    foreach($items as $i):
      $i->setSponsorId(NULL);
      $i->save();
    endforeach;
    
    $sponsor->delete();

    $this->redirect('sponsors/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $sponsor = $form->save();

      $this->redirect('sponsors/edit?id='.$sponsor->getId());
    }
  }
}
