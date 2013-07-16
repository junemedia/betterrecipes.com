<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('Tip', 'doctrine');

/**
 * BaseTip
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $title
 * @property string $url
 * @property integer $updated_by
 * @property timestamp $updated_at
 * 
 * @method integer   getId()         Returns the current record's "id" value
 * @method string    getTitle()      Returns the current record's "title" value
 * @method string    getUrl()        Returns the current record's "url" value
 * @method integer   getUpdatedBy()  Returns the current record's "updated_by" value
 * @method timestamp getUpdatedAt()  Returns the current record's "updated_at" value
 * @method Tip       setId()         Sets the current record's "id" value
 * @method Tip       setTitle()      Sets the current record's "title" value
 * @method Tip       setUrl()        Sets the current record's "url" value
 * @method Tip       setUpdatedBy()  Sets the current record's "updated_by" value
 * @method Tip       setUpdatedAt()  Sets the current record's "updated_at" value
 * 
 * @package    betterrecipes
 * @subpackage model
 * @author     Rusty Cage <rcage@resolute.com>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseTip extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('tip');
        $this->hasColumn('id', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => true,
             'primary' => true,
             'autoincrement' => true,
             'length' => 4,
             ));
        $this->hasColumn('title', 'string', 255, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 255,
             ));
        $this->hasColumn('url', 'string', 255, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => 255,
             ));
        $this->hasColumn('updated_by', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => true,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => 4,
             ));
        $this->hasColumn('updated_at', 'timestamp', 25, array(
             'type' => 'timestamp',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => 25,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        
    }
}