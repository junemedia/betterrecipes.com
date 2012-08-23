<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('ContestPeriod', 'doctrine');

/**
 * BaseContestPeriod
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property date $week_start_date
 * @property date $week_end_date
 * @property integer $contest_id
 * @property integer $unofficial_winner_id
 * @property integer $official_winner_id
 * @property integer $editor_winner_id
 * @property integer $is_active
 * @property integer $user_id
 * @property timestamp $created_at
 * @property timestamp $updated_at
 * @property integer $week_offset
 * @property Contest $Contest
 * @property User $User
 * @property Doctrine_Collection $Contestant
 * 
 * @method integer             getId()                   Returns the current record's "id" value
 * @method date                getWeekStartDate()        Returns the current record's "week_start_date" value
 * @method date                getWeekEndDate()          Returns the current record's "week_end_date" value
 * @method integer             getContestId()            Returns the current record's "contest_id" value
 * @method integer             getUnofficialWinnerId()   Returns the current record's "unofficial_winner_id" value
 * @method integer             getOfficialWinnerId()     Returns the current record's "official_winner_id" value
 * @method integer             getEditorWinnerId()       Returns the current record's "editor_winner_id" value
 * @method integer             getIsActive()             Returns the current record's "is_active" value
 * @method integer             getUserId()               Returns the current record's "user_id" value
 * @method timestamp           getCreatedAt()            Returns the current record's "created_at" value
 * @method timestamp           getUpdatedAt()            Returns the current record's "updated_at" value
 * @method integer             getWeekOffset()           Returns the current record's "week_offset" value
 * @method Contest             getContest()              Returns the current record's "Contest" value
 * @method User                getUser()                 Returns the current record's "User" value
 * @method Doctrine_Collection getContestant()           Returns the current record's "Contestant" collection
 * @method ContestPeriod       setId()                   Sets the current record's "id" value
 * @method ContestPeriod       setWeekStartDate()        Sets the current record's "week_start_date" value
 * @method ContestPeriod       setWeekEndDate()          Sets the current record's "week_end_date" value
 * @method ContestPeriod       setContestId()            Sets the current record's "contest_id" value
 * @method ContestPeriod       setUnofficialWinnerId()   Sets the current record's "unofficial_winner_id" value
 * @method ContestPeriod       setOfficialWinnerId()     Sets the current record's "official_winner_id" value
 * @method ContestPeriod       setEditorWinnerId()       Sets the current record's "editor_winner_id" value
 * @method ContestPeriod       setIsActive()             Sets the current record's "is_active" value
 * @method ContestPeriod       setUserId()               Sets the current record's "user_id" value
 * @method ContestPeriod       setCreatedAt()            Sets the current record's "created_at" value
 * @method ContestPeriod       setUpdatedAt()            Sets the current record's "updated_at" value
 * @method ContestPeriod       setWeekOffset()           Sets the current record's "week_offset" value
 * @method ContestPeriod       setContest()              Sets the current record's "Contest" value
 * @method ContestPeriod       setUser()                 Sets the current record's "User" value
 * @method ContestPeriod       setContestant()           Sets the current record's "Contestant" collection
 * 
 * @package    betterrecipes
 * @subpackage model
 * @author     Rusty Cage <rcage@resolute.com>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseContestPeriod extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('contest_period');
        $this->hasColumn('id', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => true,
             'primary' => true,
             'autoincrement' => true,
             'length' => 4,
             ));
        $this->hasColumn('week_start_date', 'date', 25, array(
             'type' => 'date',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => 25,
             ));
        $this->hasColumn('week_end_date', 'date', 25, array(
             'type' => 'date',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => 25,
             ));
        $this->hasColumn('contest_id', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => true,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 4,
             ));
        $this->hasColumn('unofficial_winner_id', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => true,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 4,
             ));
        $this->hasColumn('official_winner_id', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => true,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 4,
             ));
        $this->hasColumn('editor_winner_id', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => true,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 4,
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
        $this->hasColumn('week_offset', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => 4,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Contest', array(
             'local' => 'contest_id',
             'foreign' => 'id'));

        $this->hasOne('User', array(
             'local' => 'user_id',
             'foreign' => 'id'));

        $this->hasMany('Contestant', array(
             'local' => 'contest_id',
             'foreign' => 'contest_id'));
    }
}