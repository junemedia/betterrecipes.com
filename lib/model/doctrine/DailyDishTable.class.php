<?php

/**
 * DailyDishTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class DailyDishTable extends Doctrine_Table
{
    /**
     * Returns an instance of this class.
     *
     * @return object DailyDishTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('DailyDish');
    }
    
    
    public static function insertGetDish($slug)
    {
    	// check if object exists
    	$q = Doctrine_Core::getTable('DailyDish')->createQuery('d')->where('d.slug = ?', $slug);
    	$obj = $q->fetchOne();
    	if (!$obj) {
    		// insert new daily dish
    		$d = new DailyDish();
    		$d->setSlug($slug);
    		$d->save();
            $q = Doctrine_Core::getTable('DailyDish')->createQuery('d')->where('d.slug = ?', $slug);
    		$obj = $q->fetchOne();
    		return $obj['id'];
    	} else {
    		return $obj['id'];
    	}
    }
    
}