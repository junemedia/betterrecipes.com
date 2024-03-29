<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('Recipe', 'doctrine');

/**
 * BaseRecipe
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $name
 * @property string $slug
 * @property string $introduction
 * @property string $ingredients
 * @property string $description
 * @property string $servings
 * @property string $preptime
 * @property string $cooktime
 * @property string $totaltime
 * @property string $summary
 * @property string $title_tag
 * @property string $keywords
 * @property string $notes
 * @property string $quick_recipe
 * @property decimal $rating
 * @property integer $rating_count
 * @property string $main_ingredient
 * @property enum $course
 * @property string $origin
 * @property string $instructions
 * @property integer $views
 * @property integer $recommendations
 * @property integer $sponsor_id
 * @property integer $is_active
 * @property integer $user_id
 * @property integer $updated_by_id
 * @property integer $onesite_id
 * @property integer $initial_cat_id
 * @property timestamp $created_at
 * @property timestamp $updated_at
 * @property enum $source
 * @property string $legacy_id
 * @property integer $is_featured
 * @property User $User
 * @property Sponsor $Sponsor
 * @property Doctrine_Collection $CategoryRecipe
 * @property Doctrine_Collection $CollectionRecipe
 * @property Doctrine_Collection $Contestant
 * @property Doctrine_Collection $GroupRecipe
 * @property Doctrine_Collection $LegacyMbRecipe
 * @property Doctrine_Collection $Madeit
 * @property Doctrine_Collection $Photo
 * @property Doctrine_Collection $PollOption
 * @property Doctrine_Collection $Rate
 * @property Doctrine_Collection $RecipeLike
 * @property Doctrine_Collection $Saved
 * @property Doctrine_Collection $UserActions
 * 
 * @method integer             getId()               Returns the current record's "id" value
 * @method string              getName()             Returns the current record's "name" value
 * @method string              getSlug()             Returns the current record's "slug" value
 * @method string              getIntroduction()     Returns the current record's "introduction" value
 * @method string              getIngredients()      Returns the current record's "ingredients" value
 * @method string              getDescription()      Returns the current record's "description" value
 * @method string              getServings()         Returns the current record's "servings" value
 * @method string              getPreptime()         Returns the current record's "preptime" value
 * @method string              getCooktime()         Returns the current record's "cooktime" value
 * @method string              getTotaltime()        Returns the current record's "totaltime" value
 * @method string              getSummary()          Returns the current record's "summary" value
 * @method string              getTitleTag()         Returns the current record's "title_tag" value
 * @method string              getKeywords()         Returns the current record's "keywords" value
 * @method string              getNotes()            Returns the current record's "notes" value
 * @method string              getQuickRecipe()      Returns the current record's "quick_recipe" value
 * @method decimal             getRating()           Returns the current record's "rating" value
 * @method integer             getRatingCount()      Returns the current record's "rating_count" value
 * @method string              getMainIngredient()   Returns the current record's "main_ingredient" value
 * @method enum                getCourse()           Returns the current record's "course" value
 * @method string              getOrigin()           Returns the current record's "origin" value
 * @method string              getInstructions()     Returns the current record's "instructions" value
 * @method integer             getViews()            Returns the current record's "views" value
 * @method integer             getRecommendations()  Returns the current record's "recommendations" value
 * @method integer             getSponsorId()        Returns the current record's "sponsor_id" value
 * @method integer             getIsActive()         Returns the current record's "is_active" value
 * @method integer             getUserId()           Returns the current record's "user_id" value
 * @method integer             getUpdatedById()      Returns the current record's "updated_by_id" value
 * @method integer             getOnesiteId()        Returns the current record's "onesite_id" value
 * @method integer             getInitialCatId()     Returns the current record's "initial_cat_id" value
 * @method timestamp           getCreatedAt()        Returns the current record's "created_at" value
 * @method timestamp           getUpdatedAt()        Returns the current record's "updated_at" value
 * @method enum                getSource()           Returns the current record's "source" value
 * @method string              getLegacyId()         Returns the current record's "legacy_id" value
 * @method integer             getIsFeatured()       Returns the current record's "is_featured" value
 * @method User                getUser()             Returns the current record's "User" value
 * @method Sponsor             getSponsor()          Returns the current record's "Sponsor" value
 * @method Doctrine_Collection getCategoryRecipe()   Returns the current record's "CategoryRecipe" collection
 * @method Doctrine_Collection getCollectionRecipe() Returns the current record's "CollectionRecipe" collection
 * @method Doctrine_Collection getContestant()       Returns the current record's "Contestant" collection
 * @method Doctrine_Collection getGroupRecipe()      Returns the current record's "GroupRecipe" collection
 * @method Doctrine_Collection getLegacyMbRecipe()   Returns the current record's "LegacyMbRecipe" collection
 * @method Doctrine_Collection getMadeit()           Returns the current record's "Madeit" collection
 * @method Doctrine_Collection getPhoto()            Returns the current record's "Photo" collection
 * @method Doctrine_Collection getPollOption()       Returns the current record's "PollOption" collection
 * @method Doctrine_Collection getRate()             Returns the current record's "Rate" collection
 * @method Doctrine_Collection getRecipeLike()       Returns the current record's "RecipeLike" collection
 * @method Doctrine_Collection getSaved()            Returns the current record's "Saved" collection
 * @method Doctrine_Collection getUserActions()      Returns the current record's "UserActions" collection
 * @method Recipe              setId()               Sets the current record's "id" value
 * @method Recipe              setName()             Sets the current record's "name" value
 * @method Recipe              setSlug()             Sets the current record's "slug" value
 * @method Recipe              setIntroduction()     Sets the current record's "introduction" value
 * @method Recipe              setIngredients()      Sets the current record's "ingredients" value
 * @method Recipe              setDescription()      Sets the current record's "description" value
 * @method Recipe              setServings()         Sets the current record's "servings" value
 * @method Recipe              setPreptime()         Sets the current record's "preptime" value
 * @method Recipe              setCooktime()         Sets the current record's "cooktime" value
 * @method Recipe              setTotaltime()        Sets the current record's "totaltime" value
 * @method Recipe              setSummary()          Sets the current record's "summary" value
 * @method Recipe              setTitleTag()         Sets the current record's "title_tag" value
 * @method Recipe              setKeywords()         Sets the current record's "keywords" value
 * @method Recipe              setNotes()            Sets the current record's "notes" value
 * @method Recipe              setQuickRecipe()      Sets the current record's "quick_recipe" value
 * @method Recipe              setRating()           Sets the current record's "rating" value
 * @method Recipe              setRatingCount()      Sets the current record's "rating_count" value
 * @method Recipe              setMainIngredient()   Sets the current record's "main_ingredient" value
 * @method Recipe              setCourse()           Sets the current record's "course" value
 * @method Recipe              setOrigin()           Sets the current record's "origin" value
 * @method Recipe              setInstructions()     Sets the current record's "instructions" value
 * @method Recipe              setViews()            Sets the current record's "views" value
 * @method Recipe              setRecommendations()  Sets the current record's "recommendations" value
 * @method Recipe              setSponsorId()        Sets the current record's "sponsor_id" value
 * @method Recipe              setIsActive()         Sets the current record's "is_active" value
 * @method Recipe              setUserId()           Sets the current record's "user_id" value
 * @method Recipe              setUpdatedById()      Sets the current record's "updated_by_id" value
 * @method Recipe              setOnesiteId()        Sets the current record's "onesite_id" value
 * @method Recipe              setInitialCatId()     Sets the current record's "initial_cat_id" value
 * @method Recipe              setCreatedAt()        Sets the current record's "created_at" value
 * @method Recipe              setUpdatedAt()        Sets the current record's "updated_at" value
 * @method Recipe              setSource()           Sets the current record's "source" value
 * @method Recipe              setLegacyId()         Sets the current record's "legacy_id" value
 * @method Recipe              setIsFeatured()       Sets the current record's "is_featured" value
 * @method Recipe              setUser()             Sets the current record's "User" value
 * @method Recipe              setSponsor()          Sets the current record's "Sponsor" value
 * @method Recipe              setCategoryRecipe()   Sets the current record's "CategoryRecipe" collection
 * @method Recipe              setCollectionRecipe() Sets the current record's "CollectionRecipe" collection
 * @method Recipe              setContestant()       Sets the current record's "Contestant" collection
 * @method Recipe              setGroupRecipe()      Sets the current record's "GroupRecipe" collection
 * @method Recipe              setLegacyMbRecipe()   Sets the current record's "LegacyMbRecipe" collection
 * @method Recipe              setMadeit()           Sets the current record's "Madeit" collection
 * @method Recipe              setPhoto()            Sets the current record's "Photo" collection
 * @method Recipe              setPollOption()       Sets the current record's "PollOption" collection
 * @method Recipe              setRate()             Sets the current record's "Rate" collection
 * @method Recipe              setRecipeLike()       Sets the current record's "RecipeLike" collection
 * @method Recipe              setSaved()            Sets the current record's "Saved" collection
 * @method Recipe              setUserActions()      Sets the current record's "UserActions" collection
 * 
 * @package    betterrecipes
 * @subpackage model
 * @author     Rusty Cage <rcage@resolute.com>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseRecipe extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('recipe');
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
        $this->hasColumn('slug', 'string', 100, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => 100,
             ));
        $this->hasColumn('introduction', 'string', null, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => '',
             ));
        $this->hasColumn('ingredients', 'string', null, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => '',
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
        $this->hasColumn('servings', 'string', 150, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 150,
             ));
        $this->hasColumn('preptime', 'string', 150, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 150,
             ));
        $this->hasColumn('cooktime', 'string', 150, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 150,
             ));
        $this->hasColumn('totaltime', 'string', 255, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 255,
             ));
        $this->hasColumn('summary', 'string', 255, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 255,
             ));
        $this->hasColumn('title_tag', 'string', 255, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 255,
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
        $this->hasColumn('notes', 'string', null, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => '',
             ));
        $this->hasColumn('quick_recipe', 'string', 1, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 1,
             ));
        $this->hasColumn('rating', 'decimal', 5, array(
             'type' => 'decimal',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'default' => '0.0000',
             'notnull' => false,
             'autoincrement' => false,
             'length' => 5,
             'scale' => '4',
             ));
        $this->hasColumn('rating_count', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'default' => '0',
             'notnull' => true,
             'autoincrement' => false,
             'length' => 4,
             ));
        $this->hasColumn('main_ingredient', 'string', 100, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 100,
             ));
        $this->hasColumn('course', 'enum', 16, array(
             'type' => 'enum',
             'fixed' => 0,
             'unsigned' => false,
             'values' => 
             array(
              0 => 'desserts',
              1 => 'side dish',
              2 => 'breakfast brunch',
              3 => 'main dish',
              4 => 'appetizer',
              5 => 'beverages',
              6 => 'other',
             ),
             'primary' => false,
             'default' => 'other',
             'notnull' => false,
             'autoincrement' => false,
             'length' => 16,
             ));
        $this->hasColumn('origin', 'string', 150, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 150,
             ));
        $this->hasColumn('instructions', 'string', null, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => '',
             ));
        $this->hasColumn('views', 'integer', 4, array(
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
             'notnull' => false,
             'autoincrement' => false,
             'length' => 4,
             ));
        $this->hasColumn('sponsor_id', 'integer', 4, array(
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
        $this->hasColumn('updated_by_id', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => true,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 4,
             ));
        $this->hasColumn('onesite_id', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 4,
             ));
        $this->hasColumn('initial_cat_id', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
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
        $this->hasColumn('legacy_id', 'string', 40, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 40,
             ));
        $this->hasColumn('is_featured', 'integer', 1, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => true,
             'primary' => false,
             'default' => '0',
             'notnull' => false,
             'autoincrement' => false,
             'length' => 1,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('User', array(
             'local' => 'user_id',
             'foreign' => 'id'));

        $this->hasOne('Sponsor', array(
             'local' => 'sponsor_id',
             'foreign' => 'id'));

        $this->hasMany('CategoryRecipe', array(
             'local' => 'id',
             'foreign' => 'recipe_id'));

        $this->hasMany('CollectionRecipe', array(
             'local' => 'id',
             'foreign' => 'recipe_id'));

        $this->hasMany('Contestant', array(
             'local' => 'id',
             'foreign' => 'recipe_id'));

        $this->hasMany('GroupRecipe', array(
             'local' => 'id',
             'foreign' => 'recipe_id'));

        $this->hasMany('LegacyMbRecipe', array(
             'local' => 'id',
             'foreign' => 'recipe_id'));

        $this->hasMany('Madeit', array(
             'local' => 'id',
             'foreign' => 'recipe_id'));

        $this->hasMany('Photo', array(
             'local' => 'id',
             'foreign' => 'recipe_id'));

        $this->hasMany('PollOption', array(
             'local' => 'id',
             'foreign' => 'recipe_id'));

        $this->hasMany('Rate', array(
             'local' => 'id',
             'foreign' => 'recipe_id'));

        $this->hasMany('RecipeLike', array(
             'local' => 'id',
             'foreign' => 'recipe_id'));

        $this->hasMany('Saved', array(
             'local' => 'id',
             'foreign' => 'recipe_id'));

        $this->hasMany('UserActions', array(
             'local' => 'id',
             'foreign' => 'recipe_id'));
    }
}