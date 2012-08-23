<?php

/**
 * SlideshowMediumTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class SlideshowMediumTable extends Doctrine_Table
{
    /**
     * Returns an instance of this class.
     *
     * @return object SlideshowMediumTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('SlideshowMedium');
    }
    
    public static function updateSlide($id, $name, $content){
      $q = Doctrine_Query::create()->update('SlideshowMedium s');
      $q->set('s.name', '?', trim(htmlentities($name, ENT_QUOTES, 'UTF-8')));
      $q->set('s.content', '?', trim(htmlentities($content, ENT_QUOTES, 'UTF-8')));
      $q->where('s.id = ?', $id)->execute();
      return;
    }
}