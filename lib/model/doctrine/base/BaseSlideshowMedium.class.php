<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('SlideshowMedium', 'doctrine');

/**
 * BaseSlideshowMedium
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property integer $slideshow_id
 * @property enum $medium_type
 * @property integer $medium_id
 * @property integer $sequence
 * @property string $name
 * @property string $content
 * @property Slideshow $Slideshow
 * 
 * @method integer         getId()           Returns the current record's "id" value
 * @method integer         getSlideshowId()  Returns the current record's "slideshow_id" value
 * @method enum            getMediumType()   Returns the current record's "medium_type" value
 * @method integer         getMediumId()     Returns the current record's "medium_id" value
 * @method integer         getSequence()     Returns the current record's "sequence" value
 * @method string          getName()         Returns the current record's "name" value
 * @method string          getContent()      Returns the current record's "content" value
 * @method Slideshow       getSlideshow()    Returns the current record's "Slideshow" value
 * @method SlideshowMedium setId()           Sets the current record's "id" value
 * @method SlideshowMedium setSlideshowId()  Sets the current record's "slideshow_id" value
 * @method SlideshowMedium setMediumType()   Sets the current record's "medium_type" value
 * @method SlideshowMedium setMediumId()     Sets the current record's "medium_id" value
 * @method SlideshowMedium setSequence()     Sets the current record's "sequence" value
 * @method SlideshowMedium setName()         Sets the current record's "name" value
 * @method SlideshowMedium setContent()      Sets the current record's "content" value
 * @method SlideshowMedium setSlideshow()    Sets the current record's "Slideshow" value
 * 
 * @package    betterrecipes
 * @subpackage model
 * @author     Rusty Cage <rcage@resolute.com>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseSlideshowMedium extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('slideshow_medium');
        $this->hasColumn('id', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => true,
             'primary' => true,
             'autoincrement' => true,
             'length' => 4,
             ));
        $this->hasColumn('slideshow_id', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => true,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => 4,
             ));
        $this->hasColumn('medium_type', 'enum', 12, array(
             'type' => 'enum',
             'fixed' => 0,
             'unsigned' => false,
             'values' => 
             array(
              0 => 'recipe-photo',
             ),
             'primary' => false,
             'default' => 'recipe-photo',
             'notnull' => false,
             'autoincrement' => false,
             'length' => 12,
             ));
        $this->hasColumn('medium_id', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => true,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => 4,
             ));
        $this->hasColumn('sequence', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => true,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => 4,
             ));
        $this->hasColumn('name', 'string', 150, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 150,
             ));
        $this->hasColumn('content', 'string', null, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => '',
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Slideshow', array(
             'local' => 'slideshow_id',
             'foreign' => 'id'));
    }
}