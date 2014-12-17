<?php

/**
 * Article form.
 *
 * @package    betterrecipes
 * @subpackage form
 * @author     Rusty Cage <rcage@resolute.com>
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class ArticleForm extends BaseArticleForm
{
  protected static $custom_ckeditor_toolbar = array(array('Source'),
    array('Preview', 'FitWindow'),
    array('ShowBlocks'),
    array('Cut', 'Copy', 'Paste', '-', 'PasteText', 'PasteFromWord'),
    array('Scayt'),
    array('Undo', 'Redo'),
    array('Find', 'Replace'),
    array('SelectAll', '-', 'RemoveFormat'),
    array('Outdent', 'Indent', '-', 'Blockquote'),
    array('Subscript', 'Superscript'),
    array('OrderedList', 'UnorderedList'),
    array('BulletedList', 'NumberedList'),
    array('Styles'),
    array('FontSize'),
    array('Bold', 'Italic', 'Underline', 'StrikeThrough'),
    array('JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock'),
    array('BidiLtr', 'BidiRtl'),
    array('Link', 'Unlink'),
    array('HorizontalRule', '-', 'SpecialChar'),
    array('TextColor', 'BGColor'),
    array('Image'),
  );

  public function configure()
  {
    if ($this->isNew()) {
      unset($this['sponsor_id'], $this['slug'], $this['user_id'], $this['created_at'], $this['updated_at']);
    } else {
      unset($this['sponsor_id'], $this['user_id'], $this['created_at'], $this['updated_at']);
    }

    $this->setWidget('category_id', new sfWidgetFormChoice(array('choices' => CategoryTable::getParentCategoriesAndIds())));
    $this->setWidget('image', new sfWidgetFormInputFile());
    $this->setWidget('is_active', new sfWidgetFormInput(array(), array('style' => 'display:none')));

    $category_options = $this->getCategoryOptions();
    $this->setWidget('category_id', new sfWidgetFormChoice(array('choices' => $category_options)));

    // Image field validators
    $file_name = $this->getObject()->isNew() ? time() . rand() : $this->getObject()->getId();
    $this->validatorSchema['image'] = new sfValidatorFileCustom(array('required' => false, 'max_size' => 2097152, 'path' => sfConfig::get('app_uploads_tmp'), 'mime_types' => 'web_images', 'file_name' => $file_name), array('mime_types' => 'All images must be jpg, gif, tiff or png format with the max size of 2Mb', 'max_size' => 'Max file size is 2Mb'));

    $this->widgetSchema['category_id']->setOption('label', 'Category');
    $this->widgetSchema['name']->setOption('label', 'Article Title');
    $this->widgetSchema['description']->setOption('label', 'Article Description');
    $this->widgetSchema['title_tag']->setOption('label', 'Title Tag');
    $this->widgetSchema['summary']->setOption('label', 'Meta Description');
    $this->widgetSchema['keywords']->setOption('label', 'Keywords');
    $this->widgetSchema['is_active']->setOption('label', 'Status');
    $this->widgetSchema['content'] = new sfWidgetFormCKEditor(array('jsoptions' => array(
          'skin' => 'kama',
          'toolbar' => self::$custom_ckeditor_toolbar,
          'bodyClass' => 'article-body content',
          'height' => '500px',
        )));
  }

  protected function getCategoryOptions()
  {
    $categories = CategoryTable::getMainCategoryList();
    $options[''] = 'Select Category';
    foreach ($categories as $category) {
      $options[$category->getId()] = $category->getName();
    }
    return $options;
  }

  public function create($con = null)
  {
    $user_id = sfContext::getInstance()->getUser()->getAttribute('id');

    $object = $this->getObject();
    $object->setCreatedAt(date('Y-m-d H:i:s'));
    $object->setUpdatedAt(date('Y-m-d H:i:s'));
    $object->setSlug(UrlToolkit::generateCategoryArticleRecipeFriendlySlug($this->getValue('name'), 'article'));
    $object->setUserId($user_id);

    $form_obj = parent::save($con);
    $object->processFile();
    return $form_obj;
  }

  public function save($con = null)
  {
    $object = $this->getObject();
    $object->setUpdatedAt(date('Y-m-d H:i:s'));
    if ($this->values['slug'] != $this->getObject()->getSlug()) {
      $this->values['slug'] = UrlToolkit::generateCategoryArticleRecipeFriendlySlug($this->getValue('slug'), 'article', $this->getValue('id'));
    }
    $form_obj = parent::save($con);
    if (!is_null($this->values['image'])):
      $object->processFile();
    endif;
    return $form_obj;
  }

}
