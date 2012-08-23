<?php

class JournaladdForm extends sfForm
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
    //array('Styles'),
    array('FontSize'),
    array('Bold', 'Italic', 'Underline', 'StrikeThrough'),
    array('JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock'),
    array('BidiLtr', 'BidiRtl'),
    array('Link', 'Unlink'),
    array('HorizontalRule', '-', 'SpecialChar'),
    array('TextColor', 'BGColor'),
    //array('Image'),
  );
  
  public function configure()
  {
    $this->setWidgets(array(
      'referrer' => new sfWidgetFormInputHidden(),
      'title'    => new sfWidgetFormInput(),
      'body' => new sfWidgetFormTextarea(array(),array('class'=>'wym-editor')),
      // 'body' => new sfWidgetFormCKEditor(array('jsoptions' => array(
      //               'skin' => 'kama',
      //               'toolbar' => self::$custom_ckeditor_toolbar,
      //               'bodyClass' => 'body content',
      //               'height' => '500px',
      //               'filebrowserImageBrowseUrl' => '',
      //               'filebrowserBrowseUrl' => '',
      //               'filebrowserFlashBrowseUrl' => '',
      //               ))),
    ));

    $this->widgetSchema->setNameFormat('journaladd[%s]');
    
    // $editor = $this->widgetSchema['body']->getFinder();
	  $editor->config['enabled'] = false;
 
    $this->setValidators(
    	array(
	      'referrer'  => new sfValidatorPass(),
  			'title'     => new sfValidatorString(array('required' => true, 'max_length' => 120)),
  			'body'      => new sfValidatorString(array('required' => true, 'max_length' => 10000)),
    	)
    );
    
    $this->widgetSchema->setLabels(
      array(
	      'title' => 'Journal Title',
	      'body'  => 'Journal Body',
	    )
	  );

  }
}