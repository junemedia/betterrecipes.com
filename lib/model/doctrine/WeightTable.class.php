<?php

/**
 * WeightTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class WeightTable extends Doctrine_Table
{

  /**
   * Returns an instance of this class.
   *
   * @return object WeightTable
   */
  public static function getInstance()
  {
    return Doctrine_Core::getTable('Weight');
  }
  
  public static function getWeightedItem($itemId, $overrideId){
    return Doctrine_Core::getTable('Weight')->createQuery('w')->where('w.override_id = ?', $overrideId)->andWhere('w.item_id = ?', $itemId)->fetchOne();
  }

}