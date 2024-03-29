<?php

/**
 * ContestImageTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class ContestImageTable extends Doctrine_Table
{
    /**
     * Returns an instance of this class.
     *
     * @return object ContestImageTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('ContestImage');
    }
    
    public static function getActiveContestImage() {
    $q = Doctrine_Core::getTable('ContestImage')->createQuery('c');
    //ADD MORE TIMEZONES BEFORE EASTERN TIME ZONE
    //Central Time Zone
    date_default_timezone_set(timezone_name_from_abbr("CST"));
    $q->where("c.start_date <= ? AND c.end_date >= ? AND c.timezone = 'CST'", array(date('Y-m-d'), date('Y-m-d')));
    //Eastern Time Zone
    date_default_timezone_set(timezone_name_from_abbr("EST"));
    $q->orWhere("c.start_date <= ? AND c.end_date >= ? AND c.timezone = 'EDT'", array(date('Y-m-d'), date('Y-m-d')));    
    $q->orderBy('c.end_date DESC')->limit(1);
    return $q;
  }
  
}