<?php

/**
 * slideshows actions.
 *
 * @package    betterrecipes
 * @subpackage slideshows
 * @author     Rusty Cage <rcage@resolute.com>
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class slideshowsActions extends sfActions
{

  public function executeIndex(sfWebRequest $request)
  {
    //$this->mainCat = $request->getParameter('mainCat');    
    $this->slideshowName = $request->getParameter('slideshowName');
    //$this->categories = CategoryTable::getMainCategoryList();
    $this->sort = $request->getParameter('sort');
    $this->sortDir = $request->getParameter('sortDir');
    $params = array('slideshowName' => $request->getParameter('slideshowName'),
      'sort' => $request->getParameter('sort'),
      'sortDir' => $request->getParameter('sortDir'));
    $this->pager = new sfDoctrinePager('Slideshow', '25');
    $this->pager->setQuery(SlideshowTable::getFilteredSlideshows($params));
    $this->pager->setPage($request->getParameter('page', 1));
    $this->pager->init();
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new SlideshowForm();
    $this->slides = Doctrine_Core::getTable('SlideshowMedium')->createQuery('s')->execute();

    $this->bread_crumbs = array(
      'Slideshows' => UrlToolkit::getDomainUri() . '/admin/slideshows',
      'Create' => null
    );
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new SlideshowForm();
    $form = $this->form;
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));

    if ($form->isValid()) {
      $slideshow = $form->create();

      $this->redirect('slideshows/edit?id=' . $slideshow->getId());
    }

    $this->setTemplate('new');
  }

  public function executeAddSponsor(sfWebRequest $request)
  {
    $this->forward404Unless($request->isXmlHttpRequest());
    $slideshowId = $request->getParameter('slideshowId');
    $sponsors = SponsorTable::getActiveSponsors();

    return $this->renderPartial('sponsor', array('sponsors' => $sponsors, 'slideshowId' => $slideshowId));
  }

  public function executeUpdateSponsor(sfWebRequest $request)
  {
    $this->forward404Unless($request->isXmlHttpRequest());

    if (!$slideshowId = $this->getRequestParameter('slideshowId')) {
      return $this->renderText(json_encode('Please choose a Slideshow'));
    } else if ((!$sponsorId = $this->getRequestParameter('sponsorId')) && ($this->getRequestParameter('sponsorId') != 0)) {
      return $this->renderText(json_encode('Please choose a sponsor'));
    }
    SlideshowTable::updateSponsor($this->getRequestParameter('slideshowId'), $sponsorId);

    $updatedSlideshow = Doctrine_Core::getTable('Slideshow')
      ->createQuery('s')
      ->where('s.id = ?', $this->getRequestParameter('slideshowId'))
      ->fetchOne();
    sfView::NONE;
    $sponsorName = $updatedSlideshow->getSponsor()->getName();
    if (isset($sponsorName))
      return $this->renderText($updatedSlideshow->getSponsor()->getName());
    else
      return $this->renderText("None");
  }

  public function executeUpdateActive(sfWebRequest $request)
  {

    $this->forward404Unless($request->isXmlHttpRequest());
    $slideshowId = $this->getRequestParameter('slideshowId');
    $active = $this->getRequestParameter('active');

    if (isset($slideshowId) && isset($active)) {
      SlideshowTable::updateActive($slideshowId, $active);
    }
    return sfView::NONE;
  }

  public function executeDetail(sfWebRequest $request)
  {
    $this->forward404Unless($recipe = Doctrine_Core::getTable('Slideshow')->find(array($request->getParameter('id'))), sprintf('Object slideshow does not exist (%s).', $request->getParameter('id')));
    $this->slideshow = Doctrine_Core::getTable('Slideshow')->find($request->getParameter('id'));
    $this->slides = Doctrine_Core::getTable('SlideshowMedium')->createQuery('s')->where('s.slideshow_id = ?', $request->getParameter('id'))->orderBy('s.sequence ASC')->execute();

    $this->bread_crumbs = array(
      'Slideshows' => UrlToolkit::getDomainUri() . '/admin/slideshows',
      ucwords($this->slideshow->getName()) => null
    );
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($slideshow = Doctrine_Core::getTable('Slideshow')->find(array($request->getParameter('id'))), sprintf('Object slideshow does not exist (%s).', $request->getParameter('id')));
    $this->form = new SlideshowForm($slideshow);
    $this->slides = Doctrine_Core::getTable('SlideshowMedium')->createQuery('s')->where('s.slideshow_id = ?', $request->getParameter('id'))->orderBy('s.sequence ASC')->execute();
    $this->sponsors = SponsorTable::getActiveSponsors();
    $this->error = $request->getParameter('error');

    $this->bread_crumbs = array(
      'Slideshows' => UrlToolkit::getDomainUri() . '/admin/slideshows',
      ucwords($this->form->getObject()->getName()) => null
    );
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($slideshow = Doctrine_Core::getTable('Slideshow')->find(array($request->getParameter('id'))), sprintf('Object slideshow does not exist (%s).', $request->getParameter('id')));
    $this->form = new SlideshowForm($slideshow);
    $this->sponsors = SponsorTable::getActiveSponsors();

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($slideshow = Doctrine_Core::getTable('Slideshow')->find(array($request->getParameter('id'))), sprintf('Object slideshow does not exist (%s).', $request->getParameter('id')));

    //Delete all slide associated with Slideshow
    $slides = Doctrine_Core::getTable('SlideshowMedium')->findBySlideshowId($request->getParameter('id'));
    foreach ($slides as $s):
      $s->delete();
    endforeach;

    $slideshow->delete();

    $this->redirect('slideshows/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid()) {
      $slideshow = $form->save();

      $this->redirect('slideshows/edit?id=' . $slideshow->getId());
    }
  }

  public function executeAutocomplete(sfWebRequest $request)
  {
    $this->forward404Unless($request->isXmlHttpRequest());
    sfView::NONE;
    $text = $request->getParameter('textField');

    $results = Doctrine_Query::create()->select('id, name')->from('Recipe r')->where('r.name LIKE ?', "%" . $text . "%")->limit(10)->fetchArray();

    foreach ($results as $r) {
      $r['id'] = (int) $r['id'];
      $r['name'] = $r['name'];
      $autoArray[] = $r;
    }

    return $this->renderText(json_encode($autoArray));
  }

  public function executeAddSlide(sfWebRequest $request)
  {
    $this->forward404Unless($request->isXmlHttpRequest());

    $recipeId = $request->getParameter('recipeId');
    $slideshowId = $request->getParameter('slideshowId');
    $slideshowPhotoId = $request->getParameter('slideshowPhotoId');

    if ($request->getParameter('recipeId') != -1) {


      //Get Current Slideshow for # of Slides
      $slideshow = Doctrine_Query::create()->from('Slideshow s')->where('s.id = ?', $slideshowId)->fetchOne();

      //Get Chosen Recipe for Photo Information
      $recipe = Doctrine_Core::getTable('Recipe')->find($recipeId);
      if (count($recipe->getPhoto()) > 0) {
        $duplicateItem = Doctrine_Core::getTable('SlideshowMedium')->createQuery('sm')
          ->where('sm.slideshow_id = ?', $slideshowId)
          ->andWhere('sm.medium_id = ?', $recipe->getPhoto()->getFirst()->getId())
          ->execute();
      } else {
        $duplicateItem = false;
      }
      if ((count($duplicateItem) == 0) || ($duplicateItem == false)) {
        if ($recipe->hasPhoto()) { //Check to make sure recipe has a photo
          //Create new slide from first recipe photo
          $newSlide = new SlideshowMedium();
          $newSlide->setSlideshowId($request->getParameter('slideshowId'));
          $newSlide->setName(trim(htmlentities($recipe->getName(), ENT_QUOTES, 'UTF-8')));
          $newSlide->setContent(trim(htmlentities($recipe->getDescription(), ENT_QUOTES, 'UTF-8')));
          $newSlide->setMediumId($recipe->getPhoto()->getFirst()->getId());
          $newSlide->setSequence($slideshow->getSlideCount() + 1);
          $newSlide->save();

          $error = "";

          //Update Slideshow photo if this is the first slide added
          if ($slideshow->getSlideCount() == 0) {
            $slideshowPhotoId = $recipe->getPhoto()->getFirst()->getId();
            SlideshowTable::updatePhoto($slideshowId, $slideshowPhotoId);
          }
        } else {
          $error = "This recipe does not have a photo";
        }
      } else {
        $error = "The recipe already exists in the slideshow";
      }
    } else {
      $error = "Please choose a Recipe to Add";
    }

    sfView::NONE;
    $slides = Doctrine_Core::getTable('SlideshowMedium')->createQuery('s')->where('s.slideshow_id = ?', $slideshowId)->orderBy('s.sequence ASC')->execute();
    return $this->renderPartial('slidesSection', array('slides' => $slides, 'slideshowPhotoId' => $slideshowPhotoId, 'slideshowId' => $slideshowId, 'error' => $error));
  }

  public function executeSlideInfo(sfWebRequest $request)
  {
    $this->forward404Unless($request->isXmlHttpRequest());
    sfView::NONE;
    $slide = Doctrine_Core::getTable('SlideshowMedium')->createQuery('s')->where('s.id = ?', $request->getParameter('slideId'))->fetchOne();
    $slideForm = new SlideshowMediumForm($slide);
    return $this->renderPartial('slidesForm', array('slideForm' => $slideForm, 'slideshowId' => $request->getParameter('slideshowId')));
  }

  public function executeEditSlide(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));
    sfView::NONE;

    $this->forward404Unless($slide = Doctrine_Core::getTable('SlideshowMedium')->find(array($request->getParameter('id'))), sprintf('Object slideshow does not exist (%s).', $request->getParameter('id')));
    $form = new SlideshowMediumForm($slide);
    $slideshowId = $form->getObject()->getSlideshowId();

    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));

    if ($form->isValid()) {
      $form->save();
      $this->redirect('slideshows/edit?id=' . $slideshowId);
    } else {
      $this->redirect('slideshows/edit?id=' . $slideshowId . '&slide_error=1');
    }
  }

  public function executeDeleteSlide(sfWebRequest $request)
  {
    $this->forward404Unless($request->isXmlHttpRequest());
    sfView::NONE;

    //Request Parameters
    $slideshowId = $request->getParameter('slideshowId');
    $slideshowPhotoId = $request->getParameter('slideshowPhotoId');

    $slide = Doctrine_Core::getTable('SlideshowMedium')->find($request->getParameter('recipeId'));
    $slide->delete();

    $slideshow = Doctrine_Core::getTable('Slideshow')->find($request->getParameter('slideshowId'));
    //Update Slideshow photo if this is the last slide deleted
    if ($slideshow->getSlideCount() == 0) {
      $slideshowPhotoId = 0;
      SlideshowTable::updatePhoto($slideshowId, $slideshowPhotoId);
    }

    $slides = Doctrine_Core::getTable('SlideshowMedium')->createQuery('s')->where('s.slideshow_id = ?', $request->getParameter('slideshowId'))->orderBy('s.sequence ASC')->execute();

    return $this->renderPartial('slidesSection', array('slides' => $slides, 'slideshowPhotoId' => $slideshowPhotoId, 'slideshowId' => $request->getParameter('slideshowId')));
  }

  public function executeSlidesUpdate(sfWebRequest $request)
  {
    $sortSlides = $request->getParameter('slides_ids');
    if ($request->isMethod('post')) {
      $this->sortSlides($request->getParameter('slides_ids'));
    }
    $this->redirect('slideshows/edit?id=' . $request->getParameter('slideshow_id'));
  }

  public function executeUpdateSlideshowPhoto(sfWebRequest $request)
  {
    $this->forward404Unless($request->isXmlHttpRequest());
    sfView::NONE;

    $slide = Doctrine_Core::getTable('SlideshowMedium')->find($request->getParameter('slideId'));
    SlideshowTable::updatePhoto($request->getParameter('slideshowId'), $slide->getMediumId());

    $slides = Doctrine_Core::getTable('SlideshowMedium')->createQuery('s')->where('s.slideshow_id = ?', $request->getParameter('slideshowId'))->orderBy('s.sequence ASC')->execute();
    $newSlideshowPhotoId = $slide->getMediumId();

    return $this->renderPartial('slidesSection', array('slides' => $slides, 'slideshowPhotoId' => $newSlideshowPhotoId, 'slideshowId' => $request->getParameter('slideshowId')));
  }

  private function sortSlides($slides=array())
  {
    if (count($slides) > 0):
      foreach ($slides as $key => $id) {
        $sortOrder = $key + 1;

        Doctrine_Core::getTable('SlideshowMedium')->find($id)->setSequence($sortOrder)->save();
        /* change save to update and add update method in slideshowmedium for SLIDESHOW table to update user_id and updated at fields */
      }
    endif;
  }

}
