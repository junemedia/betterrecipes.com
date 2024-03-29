<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('TipContest', 'doctrine');

/**
 * BaseTipContest
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $tip_id
 * @property integer $contest_id
 * @property Contest $Contest
 * @property Tip $Tip
 * 
 * @method integer    getTipId()      Returns the current record's "tip_id" value
 * @method integer    getContestId()  Returns the current record's "contest_id" value
 * @method Contest    getContest()    Returns the current record's "Contest" value
 * @method Tip        getTip()        Returns the current record's "Tip" value
 * @method TipContest setTipId()      Sets the current record's "tip_id" value
 * @method TipContest setContestId()  Sets the current record's "contest_id" value
 * @method TipContest setContest()    Sets the current record's "Contest" value
 * @method TipContest setTip()        Sets the current record's "Tip" value
 * 
 * @package    betterrecipes
 * @subpackage model
 * @author     Rusty Cage <rcage@resolute.com>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseTipContest extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('tip_contest');
        $this->hasColumn('tip_id', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => true,
             'primary' => true,
             'autoincrement' => false,
             'length' => 4,
             ));
        $this->hasColumn('contest_id', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => true,
             'primary' => true,
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

        $this->hasOne('Tip', array(
             'local' => 'tip_id',
             'foreign' => 'id'));
    }
}