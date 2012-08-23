<?php

/**
 * Contest form.
 *
 * @package    betterrecipes
 * @subpackage form
 * @author     Rusty Cage <rcage@resolute.com>
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class ContestForm extends BaseContestForm {

  protected static $custom_ckeditor_toolbar = array(
      array('Styles'),
      array('FontSize'),
      //array('Scayt'),
      array('TextColor', 'BGColor'),
      //array('Find', 'Replace'),
      //array('SelectAll', '-', 'RemoveFormat'),
      array('Outdent', 'Indent', '-', 'Blockquote'),
      array('Bold', 'Italic', 'Underline', 'StrikeThrough'),
      array('OrderedList', 'UnorderedList'),
      array('BulletedList', 'NumberedList'),
      array('JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock'),
      array('Link', 'Unlink'),
          //array('HorizontalRule', '-', 'SpecialChar'),
  );

  public function configure() {
    if ($this->isNew()) {
      unset($this['user_id'], $this['is_active'], $this['slug'], $this['created_at'], $this['updated_at']);
    } else {
      unset($this['user_id'], $this['is_active'], $this['created_at'], $this['updated_at']);
    }


    $this->widgetSchema['rules'] = new sfWidgetFormCKEditor(array('jsoptions' => array(
                    'skin' => 'kama',
                    'toolbar' => self::$custom_ckeditor_toolbar,
                    'bodyClass' => 'article-body content',
                    'height' => '300px',
                    'width' => '200px',
                    )));

    $this->setWidget('image', new sfWidgetFormInputFile());
    $this->setWidget('start_date', new sfWidgetFormInputHidden());
    $this->setWidget('end_date', new sfWidgetFormInputHidden());
    $this->setWidget('timezone', new sfWidgetFormInputHidden());
    $this->setWidget('weeks', new sfWidgetFormInputHidden());


//    $filePath = sfConfig::get('sf_uploads_dir').'/contests/';
//    $this->validatorSchema['image'] = new sfValidatorFileCustom(array(
//      'required' => false,         
//      'mime_types' => 'web_images',
//      'path' => $filePath
//    ));
    $this->isNew() ? $imageRequired = true : $imageRequired = false;
    $this->validatorSchema['image'] = new sfValidatorFile(
                    array(
                        'required' => $imageRequired,
                        'mime_types' => 'web_images',
                        'max_size' => 2097152
                    ),
                    array(
                        'max_size' => 'File size of 2MB exceeded',
                        'mime_types' => 'You are only allowed to upload JPG, PNG or GIF files.'
                    )
    );

    if ($this->isNew()) {
      $this->validatorSchema->setPostValidator(new sfValidatorCallback(array('callback' => array($this, 'myCallback'))));
    }
  }

  public function myCallback($validator, $values) {
    if (strtotime($values['start_date']) < strtotime(date('Y/m/d'))) {
      throw new sfValidatorError($validator, 'Contest start date can not be prior to current date');
    } else if (strtotime($values['start_date']) > strtotime($values['end_date'])) {
      throw new sfValidatorError($validator, 'Contest start date can not be greater than Contest end date');
    } else
      return $values;
  }

  public function create($con = null) {
    unset($this['image']);
    $userId = sfContext::getInstance()->getUser()->getAttribute('id');
    $this->getObject()->setSlug(UrlToolkit::generateCategoryArticleRecipeFriendlySlug($this->getValue('name'), 'contest'));
    $this->getObject()->setUserId($userId);
    $this->getObject()->setCreatedAt(date('Y-m-d H:i:s'));
    $this->getObject()->setUpdatedAt(date('Y-m-d H:i:s'));   
    $formObj = parent::save($con);
    $formObj->setTimezone('CST'); //Set time zone to central time    
    $formObj->setWeeks(ContestPeriodTable::createNewContestPeriods($formObj));//Create new contest periods and set num weeks
    $formObj->save(); 
    return $formObj;
  }

  public function save($con = null) {
    unset($this['image']);
    if ($this->values['slug'] != $this->getObject()->getSlug()) {
      $this->values['slug'] = UrlToolkit::generateCategoryArticleRecipeFriendlySlug($this->getValue('slug'), 'contest', $this->getValue('id'));
    }    
    $this->getObject()->setUpdatedAt(date('Y-m-d H:i:s'));
    return parent::save($con);
  }

}
