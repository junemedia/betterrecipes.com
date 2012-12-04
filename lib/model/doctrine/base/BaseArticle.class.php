<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('Article', 'doctrine');

/**
 * BaseArticle
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property string $slug
 * @property string $summary
 * @property string $content
 * @property string $image
 * @property string $keywords
 * @property string $title_tag
 * @property integer $category_id
 * @property integer $sponsor_id
 * @property integer $views
 * @property integer $is_active
 * @property integer $user_id
 * @property timestamp $created_at
 * @property timestamp $updated_at
 * @property Category $Category
 * @property Sponsor $Sponsor
 * @property User $User
 * 
 * @method integer   getId()          Returns the current record's "id" value
 * @method string    getName()        Returns the current record's "name" value
 * @method string    getDescription() Returns the current record's "description" value
 * @method string    getSlug()        Returns the current record's "slug" value
 * @method string    getSummary()     Returns the current record's "summary" value
 * @method string    getContent()     Returns the current record's "content" value
 * @method string    getImage()       Returns the current record's "image" value
 * @method string    getKeywords()    Returns the current record's "keywords" value
 * @method string    getTitleTag()    Returns the current record's "title_tag" value
 * @method integer   getCategoryId()  Returns the current record's "category_id" value
 * @method integer   getSponsorId()   Returns the current record's "sponsor_id" value
 * @method integer   getViews()       Returns the current record's "views" value
 * @method integer   getIsActive()    Returns the current record's "is_active" value
 * @method integer   getUserId()      Returns the current record's "user_id" value
 * @method timestamp getCreatedAt()   Returns the current record's "created_at" value
 * @method timestamp getUpdatedAt()   Returns the current record's "updated_at" value
 * @method Category  getCategory()    Returns the current record's "Category" value
 * @method Sponsor   getSponsor()     Returns the current record's "Sponsor" value
 * @method User      getUser()        Returns the current record's "User" value
 * @method Article   setId()          Sets the current record's "id" value
 * @method Article   setName()        Sets the current record's "name" value
 * @method Article   setDescription() Sets the current record's "description" value
 * @method Article   setSlug()        Sets the current record's "slug" value
 * @method Article   setSummary()     Sets the current record's "summary" value
 * @method Article   setContent()     Sets the current record's "content" value
 * @method Article   setImage()       Sets the current record's "image" value
 * @method Article   setKeywords()    Sets the current record's "keywords" value
 * @method Article   setTitleTag()    Sets the current record's "title_tag" value
 * @method Article   setCategoryId()  Sets the current record's "category_id" value
 * @method Article   setSponsorId()   Sets the current record's "sponsor_id" value
 * @method Article   setViews()       Sets the current record's "views" value
 * @method Article   setIsActive()    Sets the current record's "is_active" value
 * @method Article   setUserId()      Sets the current record's "user_id" value
 * @method Article   setCreatedAt()   Sets the current record's "created_at" value
 * @method Article   setUpdatedAt()   Sets the current record's "updated_at" value
 * @method Article   setCategory()    Sets the current record's "Category" value
 * @method Article   setSponsor()     Sets the current record's "Sponsor" value
 * @method Article   setUser()        Sets the current record's "User" value
 * 
 * @package    betterrecipes
 * @subpackage model
 * @author     Rusty Cage <rcage@resolute.com>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseArticle extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('article');
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
        $this->hasColumn('description', 'string', null, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => '',
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
        $this->hasColumn('summary', 'string', 255, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 255,
             ));
        $this->hasColumn('content', 'string', null, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => '',
             ));
        $this->hasColumn('image', 'string', 150, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 150,
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
        $this->hasColumn('title_tag', 'string', 255, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 255,
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
        $this->hasColumn('sponsor_id', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => true,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 4,
             ));
        $this->hasColumn('views', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => true,
             'primary' => false,
             'default' => '0',
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
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Category', array(
             'local' => 'category_id',
             'foreign' => 'id'));

        $this->hasOne('Sponsor', array(
             'local' => 'sponsor_id',
             'foreign' => 'id'));

        $this->hasOne('User', array(
             'local' => 'user_id',
             'foreign' => 'id'));
    }
}