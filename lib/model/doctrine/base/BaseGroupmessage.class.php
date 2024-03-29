<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('Groupmessage', 'doctrine');

/**
 * BaseGroupmessage
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $groupid
 * @property integer $messageid
 * @property integer $memberid
 * @property string $reftypeid
 * @property integer $srcgroupid
 * @property timestamp $creationdt
 * @property integer $groupmessagecategoryid
 * @property integer $emailssent
 * @property integer $groupmessageid
 * @property string $parentpath
 * @property string $subject
 * @property string $messagebody
 * @property string $status
 * @property integer $targetgroupid
 * 
 * @method integer      getGroupid()                Returns the current record's "groupid" value
 * @method integer      getMessageid()              Returns the current record's "messageid" value
 * @method integer      getMemberid()               Returns the current record's "memberid" value
 * @method string       getReftypeid()              Returns the current record's "reftypeid" value
 * @method integer      getSrcgroupid()             Returns the current record's "srcgroupid" value
 * @method timestamp    getCreationdt()             Returns the current record's "creationdt" value
 * @method integer      getGroupmessagecategoryid() Returns the current record's "groupmessagecategoryid" value
 * @method integer      getEmailssent()             Returns the current record's "emailssent" value
 * @method integer      getGroupmessageid()         Returns the current record's "groupmessageid" value
 * @method string       getParentpath()             Returns the current record's "parentpath" value
 * @method string       getSubject()                Returns the current record's "subject" value
 * @method string       getMessagebody()            Returns the current record's "messagebody" value
 * @method string       getStatus()                 Returns the current record's "status" value
 * @method integer      getTargetgroupid()          Returns the current record's "targetgroupid" value
 * @method Groupmessage setGroupid()                Sets the current record's "groupid" value
 * @method Groupmessage setMessageid()              Sets the current record's "messageid" value
 * @method Groupmessage setMemberid()               Sets the current record's "memberid" value
 * @method Groupmessage setReftypeid()              Sets the current record's "reftypeid" value
 * @method Groupmessage setSrcgroupid()             Sets the current record's "srcgroupid" value
 * @method Groupmessage setCreationdt()             Sets the current record's "creationdt" value
 * @method Groupmessage setGroupmessagecategoryid() Sets the current record's "groupmessagecategoryid" value
 * @method Groupmessage setEmailssent()             Sets the current record's "emailssent" value
 * @method Groupmessage setGroupmessageid()         Sets the current record's "groupmessageid" value
 * @method Groupmessage setParentpath()             Sets the current record's "parentpath" value
 * @method Groupmessage setSubject()                Sets the current record's "subject" value
 * @method Groupmessage setMessagebody()            Sets the current record's "messagebody" value
 * @method Groupmessage setStatus()                 Sets the current record's "status" value
 * @method Groupmessage setTargetgroupid()          Sets the current record's "targetgroupid" value
 * 
 * @package    betterrecipes
 * @subpackage model
 * @author     Rusty Cage <rcage@resolute.com>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseGroupmessage extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('groupmessage');
        $this->hasColumn('groupid', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => true,
             'autoincrement' => false,
             'length' => 4,
             ));
        $this->hasColumn('messageid', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => true,
             'autoincrement' => false,
             'length' => 4,
             ));
        $this->hasColumn('memberid', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 4,
             ));
        $this->hasColumn('reftypeid', 'string', 1, array(
             'type' => 'string',
             'fixed' => 1,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 1,
             ));
        $this->hasColumn('srcgroupid', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 4,
             ));
        $this->hasColumn('creationdt', 'timestamp', 25, array(
             'type' => 'timestamp',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 25,
             ));
        $this->hasColumn('groupmessagecategoryid', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 4,
             ));
        $this->hasColumn('emailssent', 'integer', 1, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'default' => '0',
             'notnull' => false,
             'autoincrement' => false,
             'length' => 1,
             ));
        $this->hasColumn('groupmessageid', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => 4,
             ));
        $this->hasColumn('parentpath', 'string', null, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => '',
             ));
        $this->hasColumn('subject', 'string', 200, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 200,
             ));
        $this->hasColumn('messagebody', 'string', null, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => '',
             ));
        $this->hasColumn('status', 'string', 1, array(
             'type' => 'string',
             'fixed' => 1,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 1,
             ));
        $this->hasColumn('targetgroupid', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 4,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        
    }
}