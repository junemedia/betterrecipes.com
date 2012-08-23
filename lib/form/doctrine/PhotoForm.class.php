<?php

/**
 * Photo form.
 *
 * @package    betterrecipes
 * @subpackage form
 * @author     Rusty Cage <rcage@resolute.com>
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class PhotoForm extends BasePhotoForm
{

  public function configure()
  {
    parent::configure();
    unset($this['user_id'], $this['created_at'], $this['updated_at'], $this['source'], $this['legacy_id'], $this['sequence']);

    $this->setWidget('recipe_id', new sfWidgetFormInputHidden());
    $this->widgetSchema['name']->setLabel('Photo Title');
    $this->validatorSchema['recipe_id'] = new sfValidatorInteger(array('required' => true));
    // Image field widgets
    $this->setWidget('image', new sfWidgetFormInputFile(array('label' => 'Browse'), array('class' => 'image-source')));
    // Image field validators
    $file_name = $this->getObject()->isNew() ? time() . rand() : $this->getObject()->getId();
    $this->validatorSchema['image'] = new sfValidatorFileCustom(array('required' => true, 'max_size' => 2097152, 'path' => sfConfig::get('app_uploads_tmp'), 'mime_types' => 'web_images', 'file_name' => $file_name), array('mime_types' => 'All images must be jpg, gif, tiff or png format with the max size of 2Mb', 'max_size' => 'Max file size is 2Mb'));
  }

  public function create()
  {
    $object = $this->getObject();
    $object->setUserId(sfContext::getInstance()->getUser()->getAttribute('id'));
    $object->setSequence(PhotoTable::getNextSequenceNo($this->getValue('recipe_id')));
    $object->setSource('nw');
    $object->setThumb(null);
    $object->setCreatedAt(date('Y-m-d H:i:s'));
    $form_obj = parent::save();
    $object->processFile();
    return $form_obj;
  }

}