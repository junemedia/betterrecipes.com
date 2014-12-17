<?php

/**
 * Collection form.
 *
 * @package    betterrecipes
 * @subpackage form
 * @author     Rusty Cage <rcage@resolute.com>
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class CollectionForm extends BaseCollectionForm
{

  public function configure()
  {
    parent::configure();
    unset($this['user_id'], $this['created_at'], $this['updated_at'], $this['source'], $this['legacy_id'], $this['sequence'], $this['recommendations']);
  }

  public function create()
  {
    $user_id = sfContext::getInstance()->getUser()->getAttribute('id');
    $this->getObject()->setUserId($user_id);
    $this->getObject()->setSource('nw');
    $this->getObject()->setCreatedAt(date('Y-m-d H:i:s'));
    return parent::save();
  }

}
