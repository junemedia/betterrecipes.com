<?php

/**
 * SlideshowMedium form.
 *
 * @package    betterrecipes
 * @subpackage form
 * @author     Rusty Cage <rcage@resolute.com>
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class SlideshowMediumForm extends BaseSlideshowMediumForm
{
  public function configure()
  {
    //unset ($this['slideshow_id'], $this['medium_type'], $this['medium_id'], $this['sequence']);
    $this->setWidget('slideshow_id', new sfWidgetFormInputHidden());
    $this->setWidget('medium_id', new sfWidgetFormInputHidden());
    $this->setWidget('sequence', new sfWidgetFormInputHidden());
    
  }
}
