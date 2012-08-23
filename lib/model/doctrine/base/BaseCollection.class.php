<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('Collection', 'doctrine');

/**
 * BaseCollection
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property string $tags
 * @property integer $user_id
 * @property integer $sequence
 * @property integer $recommendations
 * @property timestamp $updated_at
 * @property timestamp $created_at
 * @property enum $source
 * @property string $legacy_id
 * @property User $User
 * @property Doctrine_Collection $CollectionRecipe
 * 
 * @method integer             getId()               Returns the current record's "id" value
 * @method string              getName()             Returns the current record's "name" value
 * @method string              getDescription()      Returns the current record's "description" value
 * @method string              getTags()             Returns the current record's "tags" value
 * @method integer             getUserId()           Returns the current record's "user_id" value
 * @method integer             getSequence()         Returns the current record's "sequence" value
 * @method integer             getRecommendations()  Returns the current record's "recommendations" value
 * @method timestamp           getUpdatedAt()        Returns the current record's "updated_at" value
 * @method timestamp           getCreatedAt()        Returns the current record's "created_at" value
 * @method enum                getSource()           Returns the current record's "source" value
 * @method string              getLegacyId()         Returns the current record's "legacy_id" value
 * @method User                getUser()             Returns the current record's "User" value
 * @method Doctrine_Collection getCollectionRecipe() Returns the current record's "CollectionRecipe" collection
 * @method Collection          setId()               Sets the current record's "id" value
 * @method Collection          setName()             Sets the current record's "name" value
 * @method Collection          setDescription()      Sets the current record's "description" value
 * @method Collection          setTags()             Sets the current record's "tags" value
 * @method Collection          setUserId()           Sets the current record's "user_id" value
 * @method Collection          setSequence()         Sets the current record's "sequence" value
 * @method Collection          setRecommendations()  Sets the current record's "recommendations" value
 * @method Collection          setUpdatedAt()        Sets the current record's "updated_at" value
 * @method Collection          setCreatedAt()        Sets the current record's "created_at" value
 * @method Collection          setSource()           Sets the current record's "source" value
 * @method Collection          setLegacyId()         Sets the current record's "legacy_id" value
 * @method Collection          setUser()             Sets the current record's "User" value
 * @method Collection          setCollectionRecipe() Sets the current record's "CollectionRecipe" collection
 * 
 * @package    betterrecipes
 * @subpackage model
 * @author     Rusty Cage <rcage@resolute.com>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseCollection extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('collection');
        $this->hasColumn('id', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => true,
             'primary' => true,
             'autoincrement' => true,
             'length' => 4,
             ));
        $this->hasColumn('name', 'string', 60, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => 60,
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
        $this->hasColumn('tags', 'string', 255, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 255,
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
        $this->hasColumn('sequence', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => true,
             'primary' => false,
             'default' => '0',
             'notnull' => true,
             'autoincrement' => false,
             'length' => 4,
             ));
        $this->hasColumn('recommendations', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => true,
             'primary' => false,
             'default' => '0',
             'notnull' => false,
             'autoincrement' => false,
             'length' => 4,
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
        $this->hasColumn('created_at', 'timestamp', 25, array(
             'type' => 'timestamp',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 25,
             ));
        $this->hasColumn('source', 'enum', 2, array(
             'type' => 'enum',
             'fixed' => 0,
             'unsigned' => false,
             'values' => 
             array(
              0 => 'nw',
              1 => 'br',
              2 => 'mb',
             ),
             'primary' => false,
             'default' => 'nw',
             'notnull' => true,
             'autoincrement' => false,
             'length' => 2,
             ));
        $this->hasColumn('legacy_id', 'string', 20, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 20,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('User', array(
             'local' => 'user_id',
             'foreign' => 'id'));

        $this->hasMany('CollectionRecipe', array(
             'local' => 'id',
             'foreign' => 'collection_id'));
    }
}