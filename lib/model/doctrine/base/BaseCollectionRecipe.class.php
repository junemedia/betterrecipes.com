<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('CollectionRecipe', 'doctrine');

/**
 * BaseCollectionRecipe
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property integer $collection_id
 * @property integer $recipe_id
 * @property integer $sequence
 * @property Collection $Collection
 * @property Recipe $Recipe
 * 
 * @method integer          getId()            Returns the current record's "id" value
 * @method integer          getCollectionId()  Returns the current record's "collection_id" value
 * @method integer          getRecipeId()      Returns the current record's "recipe_id" value
 * @method integer          getSequence()      Returns the current record's "sequence" value
 * @method Collection       getCollection()    Returns the current record's "Collection" value
 * @method Recipe           getRecipe()        Returns the current record's "Recipe" value
 * @method CollectionRecipe setId()            Sets the current record's "id" value
 * @method CollectionRecipe setCollectionId()  Sets the current record's "collection_id" value
 * @method CollectionRecipe setRecipeId()      Sets the current record's "recipe_id" value
 * @method CollectionRecipe setSequence()      Sets the current record's "sequence" value
 * @method CollectionRecipe setCollection()    Sets the current record's "Collection" value
 * @method CollectionRecipe setRecipe()        Sets the current record's "Recipe" value
 * 
 * @package    betterrecipes
 * @subpackage model
 * @author     Rusty Cage <rcage@resolute.com>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseCollectionRecipe extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('collection_recipe');
        $this->hasColumn('id', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => true,
             'primary' => true,
             'autoincrement' => true,
             'length' => 4,
             ));
        $this->hasColumn('collection_id', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => true,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
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
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Collection', array(
             'local' => 'collection_id',
             'foreign' => 'id'));

        $this->hasOne('Recipe', array(
             'local' => 'recipe_id',
             'foreign' => 'id'));
    }
}