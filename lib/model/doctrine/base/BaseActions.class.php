<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('Actions', 'doctrine');

/**
 * BaseActions
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property enum $action_type
 * @property string $action_description
 * @property string $action_message
 * @property timestamp $created_at
 * @property timestamp $updated_at
 * @property Doctrine_Collection $UserActions
 * 
 * @method integer             getId()                 Returns the current record's "id" value
 * @method enum                getActionType()         Returns the current record's "action_type" value
 * @method string              getActionDescription()  Returns the current record's "action_description" value
 * @method string              getActionMessage()      Returns the current record's "action_message" value
 * @method timestamp           getCreatedAt()          Returns the current record's "created_at" value
 * @method timestamp           getUpdatedAt()          Returns the current record's "updated_at" value
 * @method Doctrine_Collection getUserActions()        Returns the current record's "UserActions" collection
 * @method Actions             setId()                 Sets the current record's "id" value
 * @method Actions             setActionType()         Sets the current record's "action_type" value
 * @method Actions             setActionDescription()  Sets the current record's "action_description" value
 * @method Actions             setActionMessage()      Sets the current record's "action_message" value
 * @method Actions             setCreatedAt()          Sets the current record's "created_at" value
 * @method Actions             setUpdatedAt()          Sets the current record's "updated_at" value
 * @method Actions             setUserActions()        Sets the current record's "UserActions" collection
 * 
 * @package    betterrecipes
 * @subpackage model
 * @author     Rusty Cage <rcage@resolute.com>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseActions extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('actions');
        $this->hasColumn('id', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => true,
             'primary' => true,
             'autoincrement' => true,
             'length' => 4,
             ));
        $this->hasColumn('action_type', 'enum', 7, array(
             'type' => 'enum',
             'fixed' => 0,
             'unsigned' => false,
             'values' => 
             array(
              0 => 'recipe',
              1 => 'contest',
              2 => 'poll',
             ),
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 7,
             ));
        $this->hasColumn('action_description', 'string', 255, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => 255,
             ));
        $this->hasColumn('action_message', 'string', 500, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => 500,
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
        $this->hasMany('UserActions', array(
             'local' => 'id',
             'foreign' => 'action_id'));
    }
}