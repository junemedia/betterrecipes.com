<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('Saved', 'doctrine');

/**
 * BaseSaved
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property integer $recipe_id
 * @property integer $user_id
 * @property Recipe $Recipe
 * @property User $User
 * 
 * @method integer getId()        Returns the current record's "id" value
 * @method integer getRecipeId()  Returns the current record's "recipe_id" value
 * @method integer getUserId()    Returns the current record's "user_id" value
 * @method Recipe  getRecipe()    Returns the current record's "Recipe" value
 * @method User    getUser()      Returns the current record's "User" value
 * @method Saved   setId()        Sets the current record's "id" value
 * @method Saved   setRecipeId()  Sets the current record's "recipe_id" value
 * @method Saved   setUserId()    Sets the current record's "user_id" value
 * @method Saved   setRecipe()    Sets the current record's "Recipe" value
 * @method Saved   setUser()      Sets the current record's "User" value
 * 
 * @package    betterrecipes
 * @subpackage model
 * @author     Rusty Cage <rcage@resolute.com>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseSaved extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('saved');
        $this->hasColumn('id', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => true,
             'primary' => true,
             'autoincrement' => true,
             'length' => 4,
             ));
        $this->hasColumn('recipe_id', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => true,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => 4,
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
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Recipe', array(
             'local' => 'recipe_id',
             'foreign' => 'id'));

        $this->hasOne('User', array(
             'local' => 'user_id',
             'foreign' => 'id'));
    }
}