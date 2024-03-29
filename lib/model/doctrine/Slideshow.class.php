<?php

/**
 * Slideshow
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    betterrecipes
 * @subpackage model
 * @author     Rusty Cage <rcage@resolute.com>
 * @version    SVN: $Id: Builder.php 7691 2011-02-04 15:43:29Z jwage $
 */
class Slideshow extends BaseSlideshow
{

//  public function setUp()
//  {
//    parent::setup();
//    $this->actAs('Sluggable', array(
//      'unique' => true,
//      'fields' => array('name'),
//      'canUpdate' => false
//      )
//    );
//  }

  public function getImgSrc($size='400x300')
  {
	$slides = $this->getSortedSlides();
	return $slides[0]->getImgSrc($size);
    /*if (empty($this->photo_id)) {
      return $this->getSortedSlides()->getFirst()->getImgSrc($size);
    } else {
      return Doctrine_Core::getTable('Photo')->findOneIdAndIsActive($this->photo_id, 1)->getImgSrc($size);
    }*/  //Can't find "findOneIdAndIsActive" method in Photo table
  }

  public function getSlideCount()
  {
    return $this->getSlideshowMedium()->count();
  }

  public function getCategoryName()
  {
    return $this->getCategory()->getName();
  }

  public function getSortedSlides()
  {
    $slides = Doctrine_Query::create()->from('SlideshowMedium s')->where('s.slideshow_id = ?', $this->id)->orderBy('s.sequence ASC')->execute()->getData();
    $sorted_slides = array();
    foreach ($slides as $slide) {
      if (!is_null($slide->getImgSrc()) && $slide->getImgSrc() != false) {
        $sorted_slides[] = $slide;
      }
    }
    return $sorted_slides;
  }

  public function generateSlugFromName()
  {
    return UrlToolkit::generateCategoryArticleRecipeFriendlySlug($this->name);
  }

  public function updateSlugFromName()
  {
    $slug = $this->generateSlugFromName();
    $this->setSlug($slug)->save();
  }

}
