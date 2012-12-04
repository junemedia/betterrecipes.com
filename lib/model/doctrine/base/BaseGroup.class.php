<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('Group', 'doctrine');

/**
 * BaseGroup
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property integer $blog_id
 * @property integer $forum_id
 * @property integer $category_id
 * @property string $group_slug
 * @property integer $sponsor_id
 * @property Category $Category
 * @property Sponsor $Sponsor
 * @property Doctrine_Collection $GroupRecipe
 * 
 * @method integer             getId()          Returns the current record's "id" value
 * @method integer             getBlogId()      Returns the current record's "blog_id" value
 * @method integer             getForumId()     Returns the current record's "forum_id" value
 * @method integer             getCategoryId()  Returns the current record's "category_id" value
 * @method string              getGroupSlug()   Returns the current record's "group_slug" value
 * @method integer             getSponsorId()   Returns the current record's "sponsor_id" value
 * @method Category            getCategory()    Returns the current record's "Category" value
 * @method Sponsor             getSponsor()     Returns the current record's "Sponsor" value
 * @method Doctrine_Collection getGroupRecipe() Returns the current record's "GroupRecipe" collection
 * @method Group               setId()          Sets the current record's "id" value
 * @method Group               setBlogId()      Sets the current record's "blog_id" value
 * @method Group               setForumId()     Sets the current record's "forum_id" value
 * @method Group               setCategoryId()  Sets the current record's "category_id" value
 * @method Group               setGroupSlug()   Sets the current record's "group_slug" value
 * @method Group               setSponsorId()   Sets the current record's "sponsor_id" value
 * @method Group               setCategory()    Sets the current record's "Category" value
 * @method Group               setSponsor()     Sets the current record's "Sponsor" value
 * @method Group               setGroupRecipe() Sets the current record's "GroupRecipe" collection
 * 
 * @package    betterrecipes
 * @subpackage model
 * @author     Rusty Cage <rcage@resolute.com>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseGroup extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('group');
        $this->hasColumn('id', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => true,
             'primary' => true,
             'autoincrement' => false,
             'length' => 4,
             ));
        $this->hasColumn('blog_id', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => true,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 4,
             ));
        $this->hasColumn('forum_id', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => true,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 4,
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
        $this->hasColumn('group_slug', 'string', 255, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 255,
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

        $this->hasMany('GroupRecipe', array(
             'local' => 'id',
             'foreign' => 'group_id'));
    }
}