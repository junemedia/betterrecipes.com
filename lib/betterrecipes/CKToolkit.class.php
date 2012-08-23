<?php

class CKToolkit {

  public function __construct() {
    throw new LogicException('Cannot instantiate class '.__CLASS__);
  }

  /**
   * Creates a simple editor
   * 
   * @param array $options
   * @param array $attributes
   * @pram boolean $override if true, $options will not be merged with the defaults and $options will be passed as is
   * @return sfWidgetFormCKEditor 
   */
  public static function createSimpleFormWidget(array $options = array(), array $attributes = array(), $override = false) {
    if (!$override) {
      $options = sfToolkit::arrayDeepMerge(array(
          'jsoptions' => array(
              'skin' => 'kama',
              'forcePasteAsPlainText' => true,
              'enterMode' => 'CKEDITOR.ENTER_BR',
              'forceEnterMode' => true,
              'autoParagraph' => false,
              'fullPage' => false,
              'removePlugins' => 'elementspath',
              'removeFormatTags' => 'div,p,b,big,code,del,dfn,em,font,i,ins,kbd,q,samp,small,span,strike,strong,sub,sup,tt,u,var',
              'toolbar' => array(
                  array('Bold', 'Italic', 'Underline', 'StrikeThrough'),
                  array('Link', 'Unlink'),
                  array('SpecialChar'),
//                  array('Paste', 'PasteText', 'PasteFromWord'),
              ),
          )
      ), $options);
    }

    return new sfWidgetFormCKEditor($options, $attributes);
  }

}