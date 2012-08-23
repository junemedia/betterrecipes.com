<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('Meta', 'doctrine');

/**
 * BaseMeta
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $name
 * @property string $slug
 * @property string $title
 * @property string $description
 * @property string $keywords
 * @property integer $is_active
 * @property integer $user_id
 * @property timestamp $created_at
 * @property timestamp $updated_at
 * @property User $User
 * 
 * @method integer   getId()          Returns the current record's "id" value
 * @method string    getName()        Returns the current record's "name" value
 * @method string    getSlug()        Returns the current record's "slug" value
 * @method string    getTitle()       Returns the current record's "title" value
 * @method string    getDescription() Returns the current record's "description" value
 * @method string    getKeywords()    Returns the current record's "keywords" value
 * @method integer   getIsActive()    Returns the current record's "is_active" value
 * @method integer   getUserId()      Returns the current record's "user_id" value
 * @method timestamp getCreatedAt()   Returns the current record's "created_at" value
 * @method timestamp getUpdatedAt()   Returns the current record's "updated_at" value
 * @method User      getUser()        Returns the current record's "User" value
 * @method Meta      setId()          Sets the current record's "id" value
 * @method Meta      setName()        Sets the current record's "name" value
 * @method Meta      setSlug()        Sets the current record's "slug" value
 * @method Meta      setTitle()       Sets the current record's "title" value
 * @method Meta      setDescription() Sets the current record's "description" value
 * @method Meta      setKeywords()    Sets the current record's "keywords" value
 * @method Meta      setIsActive()    Sets the current record's "is_active" value
 * @method Meta      setUserId()      Sets the current record's "user_id" value
 * @method Meta      setCreatedAt()   Sets the current record's "created_at" value
 * @method Meta      setUpdatedAt()   Sets the current record's "updated_at" value
 * @method Meta      setUser()        Sets the current record's "User" value
 * 
 * @package    betterrecipes
 * @subpackage model
 * @author     Rusty Cage <rcage@resolute.com>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseMeta extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('meta');
        $this->hasColumn('id', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => true,
             'primary' => true,
             'autoincrement' => true,
             'length' => 4,
             ));
        $this->hasColumn('name', 'string', 100, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => 100,
             ));
        $this->hasColumn('slug', 'string', 255, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => 255,
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
        $this->hasColumn('description', 'string', null, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => '',
             ));
        $this->hasColumn('keywords', 'string', 255, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 255,
             ));
        $this->hasColumn('is_active', 'integer', 1, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => true,
             'primary' => false,
             'default' => '1',
             'notnull' => true,
             'autoincrement' => false,
             'length' => 1,
             ));
        $this->hasColumn('user_id', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => true,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => 4,
             ));
        $this->hasColumn('created_at', 'timestamp', 25, array(
             'type' => 'timestamp',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 25,
             ));
        $this->hasColumn('updated_at', 'timestamp', 25, array(
             'type' => 'timestamp',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 25,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('User', array(
             'local' => 'user_id',
             'foreign' => 'id'));
    }
}