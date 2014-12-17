<?php

/**
 * Slideshow form.
 *
 * @package    betterrecipes
 * @subpackage form
 * @author     Rusty Cage <rcage@resolute.com>
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class SlideshowForm extends BaseSlideshowForm
{

  public function configure()
  {
    $this->setDefault('start_date', time());
    $this->setDefault('end_date', time());

    if ($this->isNew()) {
      unset($this['slug'], $this['photo_id'], $this['sponsor_id'], $this['user_id'], $this['created_at'], $this['updated_at']);
    } else {
      unset($this['photo_id'], $this['sponsor_id'], $this['user_id'], $this['created_at'], $this['updated_at']);
    }


    $this->setWidget('category_id', new sfWidgetFormChoice(array('choices' => CategoryTable::getParentCategoriesAndIds())));
    $this->setWidget('start_date', new sfWidgetFormDate());
    $this->setWidget('end_date', new sfWidgetFormDate());
    $this->setWidget('is_active', new sfWidgetFormInput(array(), array('style' => 'display:none')));

    $this->setValidator('start_date', new sfValidatorDate(array('required' => false)));
    $this->setValidator('end_date', new sfValidatorDate(array('required' => false)));

    $this->widgetSchema['category_id']->setOption('label', 'Category');
    $this->widgetSchema['name']->setOption('label', 'Slideshow Title');
    $this->widgetSchema['description']->setOption('label', 'Slideshow Description');
    $this->widgetSchema['title_tag']->setOption('label', 'Title Tag');
    $this->widgetSchema['summary']->setOption('label', 'Meta Description');
    $this->widgetSchema['is_active']->setOption('label', 'Status');
  }

  public function create($con = null)
  {
    $user_id = sfContext::getInstance()->getUser()->getAttribute('id');
    $this->getObject()->setUserId($user_id);
    $this->getObject()->setCreatedAt(date('Y-m-d H:i:s'));
    $this->getObject()->setUpdatedAt(date('Y-m-d H:i:s'));
    $this->getObject()->setSlug(UrlToolkit::generateCategoryArticleRecipeFriendlySlug($this->getValue('name'), 'slideshow'));
    return parent::save($con);
  }

  public function save($con = null)
  {
    $this->getObject()->setUpdatedAt(date('Y-m-d H:i:s'));
    if ($this->values['slug'] != $this->getObject()->getSlug()) {
      $this->values['slug'] = UrlToolkit::generateCategoryArticleRecipeFriendlySlug($this->getValue('slug'), 'slideshow', $this->getValue('id'));
    }
    return parent::save($con);
  }

}
