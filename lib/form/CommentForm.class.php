<?php

class CommentForm extends sfForm
{
 
  protected static $custom_ckeditor_toolbar = array(array('Source'),
    //array('Preview', 'FitWindow'),
    //array('ShowBlocks'),
    array('Cut', 'Copy', 'Paste', '-', 'PasteText', 'PasteFromWord'),
    array('Scayt'),
    array('Undo', 'Redo'),
    //array('Find', 'Replace'),
    array('SelectAll', '-', 'RemoveFormat'),
    array('Outdent', 'Indent', '-', 'Blockquote'),
    array('Subscript', 'Superscript'),
    //array('OrderedList', 'UnorderedList'),
    //array('BulletedList', 'NumberedList'),
    //array('Styles'),
    //array('FontSize'),
    array('Bold', 'Italic', 'Underline', 'StrikeThrough'),
    //array('JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock'),
    //array('BidiLtr', 'BidiRtl'),
    array('Link', 'Unlink'),
    //array('HorizontalRule', '-', 'SpecialChar'),
    array('TextColor', 'BGColor'),
    //array('Image'),
  );
  
  public function configure()
  {
    $this->setWidgets(array(
      //'title'    => new sfWidgetFormInput(),
      //'body' => new sfWidgetFormTextarea(),
      'comment' => new sfWidgetFormCKEditor(array('jsoptions' => array(
                    'skin' => 'kama',
                    'toolbar' => self::$custom_ckeditor_toolbar,
                    'bodyClass' => 'body content',
                    'height' => '300px',
                    'filebrowserImageBrowseUrl' => '',
                    'filebrowserBrowseUrl' => '',
                    'filebrowserFlashBrowseUrl' => '',
                    ))),
    ));
    
    $this->widgetSchema->setNameFormat('comment[%s]');
    
 
    $this->setValidators(
    	array(
      			//'title'    => new sfValidatorString(array('required' => true, 'max_length' => 120)),
      			'comment' => new sfValidatorPass(),
    		)
    );
    
	
	
	
  }
}