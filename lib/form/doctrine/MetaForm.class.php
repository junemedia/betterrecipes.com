<?php

/**
 * Meta form.
 *
 * @package    betterrecipes
 * @subpackage form
 * @author     Toros Tarpinyan <ttarpinyan@resolute.com>
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class MetaForm extends BaseMetaForm
{

  public function configure()
  {
    unset($this['user_id'], $this['name'], $this['slug'], $this['created_at'], $this['updated_at']);
  }

  public function save($con = null)
  {
    $object = $this->getObject();
    $object->setUpdatedAt(date('Y-m-d H:i:s'));
    $form_obj = parent::save($con);
    return $form_obj;
  }

}
