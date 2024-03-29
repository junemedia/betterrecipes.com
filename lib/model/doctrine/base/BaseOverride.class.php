<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('Override', 'doctrine');

/**
 * BaseOverride
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property enum $module
 * @property integer $category_id
 * @property integer $is_global
 * @property integer $is_mobile
 * @property timestamp $start_date
 * @property timestamp $end_date
 * @property integer $user_id
 * @property timestamp $created_at
 * @property timestamp $updated_at
 * @property Category $Category
 * @property User $User
 * @property Doctrine_Collection $PositionCount
 * @property Doctrine_Collection $Weight
 * 
 * @method integer             getId()            Returns the current record's "id" value
 * @method enum                getModule()        Returns the current record's "module" value
 * @method integer             getCategoryId()    Returns the current record's "category_id" value
 * @method integer             getIsGlobal()      Returns the current record's "is_global" value
 * @method integer             getIsMobile()      Returns the current record's "is_mobile" value
 * @method timestamp           getStartDate()     Returns the current record's "start_date" value
 * @method timestamp           getEndDate()       Returns the current record's "end_date" value
 * @method integer             getUserId()        Returns the current record's "user_id" value
 * @method timestamp           getCreatedAt()     Returns the current record's "created_at" value
 * @method timestamp           getUpdatedAt()     Returns the current record's "updated_at" value
 * @method Category            getCategory()      Returns the current record's "Category" value
 * @method User                getUser()          Returns the current record's "User" value
 * @method Doctrine_Collection getPositionCount() Returns the current record's "PositionCount" collection
 * @method Doctrine_Collection getWeight()        Returns the current record's "Weight" collection
 * @method Override            setId()            Sets the current record's "id" value
 * @method Override            setModule()        Sets the current record's "module" value
 * @method Override            setCategoryId()    Sets the current record's "category_id" value
 * @method Override            setIsGlobal()      Sets the current record's "is_global" value
 * @method Override            setIsMobile()      Sets the current record's "is_mobile" value
 * @method Override            setStartDate()     Sets the current record's "start_date" value
 * @method Override            setEndDate()       Sets the current record's "end_date" value
 * @method Override            setUserId()        Sets the current record's "user_id" value
 * @method Override            setCreatedAt()     Sets the current record's "created_at" value
 * @method Override            setUpdatedAt()     Sets the current record's "updated_at" value
 * @method Override            setCategory()      Sets the current record's "Category" value
 * @method Override            setUser()          Sets the current record's "User" value
 * @method Override            setPositionCount() Sets the current record's "PositionCount" collection
 * @method Override            setWeight()        Sets the current record's "Weight" collection
 * 
 * @package    betterrecipes
 * @subpackage model
 * @author     Rusty Cage <rcage@resolute.com>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseOverride extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('override');
        $this->hasColumn('id', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => true,
             'primary' => true,
             'autoincrement' => true,
             'length' => 4,
             ));
        $this->hasColumn('module', 'enum', 9, array(
             'type' => 'enum',
             'fixed' => 0,
             'unsigned' => false,
             'values' => 
             array(
              0 => 'recipe',
              1 => 'category',
              2 => 'article',
              3 => 'slideshow',
             ),
             'primary' => false,
             'default' => 'recipe',
             'notnull' => true,
             'autoincrement' => false,
             'length' => 9,
             ));
        $this->hasColumn('category_id', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => true,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 4,
             ));
        $this->hasColumn('is_global', 'integer', 1, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => true,
             'primary' => false,
             'default' => '0',
             'notnull' => true,
             'autoincrement' => false,
             'length' => 1,
             ));
        $this->hasColumn('is_mobile', 'integer', 1, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => true,
             'primary' => false,
             'default' => '0',
             'notnull' => true,
             'autoincrement' => false,
             'length' => 1,
             ));
        $this->hasColumn('start_date', 'timestamp', 25, array(
             'type' => 'timestamp',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => 25,
             ));
        $this->hasColumn('end_date', 'timestamp', 25, array(
             'type' => 'timestamp',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => 25,
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
        $this->hasOne('Category', array(
             'local' => 'category_id',
             'foreign' => 'id'));

        $this->hasOne('User', array(
             'local' => 'user_id',
             'foreign' => 'id'));

        $this->hasMany('PositionCount', array(
             'local' => 'id',
             'foreign' => 'override_id'));

        $this->hasMany('Weight', array(
             'local' => 'id',
             'foreign' => 'override_id'));
    }
}