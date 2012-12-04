<?php

/**
 * PhotoTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class PhotoTable extends Doctrine_Table
{

  /**
   * Returns an instance of this class.
   *
   * @return object PhotoTable
   */
  public static function getInstance()
  {
    return Doctrine_Core::getTable('Photo');
  }

  public static function getRecipePhotos($recipe_id)
  {
    return Doctrine_Core::getTable('Photo')->createQuery('p')->where('p.recipe_id = ?', $recipe_id)->orderBy('sequence ASC')->execute();
  }

  public static function getNextSequenceNo($recipe_id)
  {
    return Doctrine_Core::getTable('Photo')->createQuery('p')->select('MAX(p.sequence) AS max_sequence')->where('p.recipe_id=?', $recipe_id)->fetchOne()->getMaxSequence() + 1;
  }

}