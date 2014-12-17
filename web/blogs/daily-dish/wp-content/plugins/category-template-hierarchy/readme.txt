=== Category Template Hierarchy ===
Contributors: eddiemoya
Donate link: http://eddiemoya.com
Tags: plugin, theme development, theme, template, hierarchy, category, template hierarchy, subcategory, parent category, child category, parent category, category template
Requires at least: 3.0
Tested up to: 3.3.1
Stable tag: trunk

Adds parent-category.php, child-category.php, and child-category-{slug|id} 
templates to the hierarchy and conditional tags to match.

== Description ==

Adds several new templates to the template hierarchy:

* child-of-category-{slug}.php
* category-{slug}.php
* child-of-category-{id}.php
* category-{term_id}.php
* parent-category.php
* child-category.php
* category.php
* archive.php
* index.php

This greatly extends the native hierarchy of theme templates with regard to 
categories. Theme developers can now easily create separate templates for 
categories with children, with parents, and children of specific parents.

Additionally makes available four (4) new conditional template tags:

* is_child_category();
* is_parent_category();
* is_child_of_category();
* is_parent_of_category();

These functions are available for use in any theme or plugin as along as this 
plugin is active. For detailed documentation of these functions see the 
'Developer Notes: Conditional Tags' section of this readme file.

Note: This plugin does not actually create parent-category.php, child-category.php 
or any of their related templates - rather it modifies the native [template hierarchy](http://codex.wordpress.org/Template_Hierarchy)
to allow theme developers to create specific templates for parent and child categories.

== Developer Notes: Template Hierarchy ==

What follows are is the modified list of templates available for category pages. 
These expand upon the native [Template Hierarchy](http://codex.wordpress.org/Template_Hierarchy#Visual_Overview).

* child-of-category-{slug}.php
* category-{slug}.php
* child-of-category-{id}.php
* category-{term_id}.php
* parent-category.php
* child-category.php
* category.php
* archive.php
* index.php
  
The parent and child templates only become available if the current category is 
a parent or a child respectively.

Note: This plugin does not actually create parent-category.php, child-category.php 
or any of their related templates - rather it modifies the native [template hierarchy](http://codex.wordpress.org/Template_Hierarchy)
to allow theme developers to create specific templates for parent and child categories.


== Developer Notes: Conditional Tags ==

With this plugin comes two additional [conditional tags](http://codex.wordpress.org/Conditional_Tags) 
which behave much like any other in WordPress. In a similar fashion to how one 
might use [is_category()](http://codex.wordpress.org/Function_Reference/is_category) or [cat_is_ancestory_of()](http://codex.wordpress.org/Function_Reference/cat_is_ancestor_of), 
developers may, with this plugin, use the following functions:

* is_parent_category()
* is_child_category()
* is_child_of_category()
* is_parent_of_category()



= Description (part 1) =
The `is_parent_category()` and `is_child_category()` conditional tags check if 
the page being displayed (or passed as an argument) is of a category that has 
children (e.g. is a parent category)  has a parent (is a child), respectively. 
They are boolean functions, meaning they return either TRUE or FALSE.

= Usage =
`
<?php is_parent_category( $category ); ?>
<?php is_child_category( $category ); ?>
`

= Parameters =

$category (integer/string/object) (optional) Category ID, Category Slug, Category Object. Default: Current Category

Note: Unlike is_category(), these functions will not take arrays of categories or category titles. I'll work on that. Sorry.

= Return Values =
(boolean) True on success, false on failure.

= Examples =
`
is_parent_category()
is_child_category()
// When any parent/child category archive page is being displayed

is_parent_category( '9' );
is_child_category( '9' );
// When the archive page for Category 9 is being displayed AND its a parent/child.

is_parent_category( 'blue-cheese' );
is_child_category( 'blue-cheese' );
// When the archive page for the Category with Category Slug "blue-cheese" is being displayed AND its a parent/child.
`


= Description (part 2) =
The `is_parent_of_category()` and `is_child_of_category()` conditional tags 
check if a given category has a parent or child relationship to the current 
category or a category passed as its second parameter. They are 
boolean functions, meaning they return either TRUE or FALSE.

= Usage =
`
<?php is_parent_of_category($child_category, $parent_category, $direct_descendant); ?>
<?php is_child_of_category($parent_category, $child_category, $direct_descendant);?>
`

= Parameters =
(object/string/integer) (required) Category of the would-be parent/child respectively.
(object/string/integer) (optional) Category of the would-be child/parent respectfully. Default: Current Category
(boolean) (optional) Whether or not the child should be a direct child of the parent. Default: True
 * 


= Return Values =
 (boolean) If the $direct_descendant flag set to true, function returns true if the child is a direct descendant of the parent, if child is no direct it will return false. If $direct_descendant is set to false it will return the same results as cat_is_ancestor_of().


= Examples =
The following function will return True...

`
is_child_of_category(0);
// When a top level category is being displayed, zero being the parent id value for top level categories (e.g. categories with no parents).

is_child_of_category(12);
// When the current category is a direct child of the category whose ID is '12'.

is_child_of_category('tv-shows')
// When the current category is a direct child of the category with the slug 'tv-shows' (can also be category ID's).

is_child_of_category('tv-shows', 'dexter');
// When the category with slug 'dexter' is a direct child of the category with the slug 'tv-shows' (can also be category ID's). This may come in handy when manipulating categories while not in a category template.

is_child_of_category('tv-shows', 'dexter', false);
// When the category with the slug 'dexter' is a descendant of the category 'tv-shows' at any level. (uses cat_is_ancestor_of())

is_child_of_category('tv-shows', null, false);
// When the current category is a descendant of the 'tv-shows' category at any level. (uses cat_is_ancestor_of())

is_parent_of_category(13);
// When the current category is the direct parent of a category with the ID '13'.

is_parent_of_category('dexter');
// When the current category is the direct parent of the category with the slug 'dexter'.
`


== Backward Compatibility ==
 
The changes this plugin makes to the template hierarchy are significantly different 
from that in 1.0.5 and before. If you prefer to use that version please find it 
in the Older Versions in the WordPress plugins directory, it is tagged as 1.0.5.

While I do not actively support to QA the older version, I would gladly take a 
look at any future bugs that crop up and are reported.

== Installation ==

1. Upload `plugin-name.php` to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress


== Frequently Asked Questions ==

= Do you have any Frequently Asked Questions? =

No.

= Why not? =

Because I only just recently released the plugin. I feel that I've done a decent 
job of documentation, so I can't guess what people may ask on this broadly 
applicable plugin.

= Can I ask you a question =

Please do! Feel free to ask on the tools provided right in the WordPress plugin 
directory, or on my website [eddiemoya.com](http://eddiemoya.com/).

= I liked the old hierarchy, with parent-category-{slug|id}.php and child-category-{slug|id}.php, where can I find that? =

The last version that used the old hierarchical model was 1.0.5, it was tagged 
as such and can be found in the WordPress directory by looking for Older Versions.

= You just said you have no frequently asked questions, wasn't that just a frequently asked question? =

Nope, no one has actually asked, just anticipating.

= What does the narwhal do at midnight? =

Bacon.

== Upgrade Notice ==

= 1.3.2.1 = 
Important Update: v1.3.2 did not save correctly - v1.3.2.1 includes: Bug Fixes: 1. Fixed missing 'category.php' template, and fixed missing `category-{slug}.php` and `category-{id}` if category was neither parent or child.


= 1.3.2 = 
Important update: Bug Fixes: 1. Fixed missing 'category.php' template, and fixed missing `category-{slug}.php` and `category-{id}` if category was neither parent or child.

= 1.3.1 =
Important Update - Bug Fix: Missing 'category.php' template fixed.

= 1.3 =
Multiple Bug Fixes - [Fixed] global scope variables not being available in scope, and fixed bug where plugin was interfering with other non-category parts of the native Template Hierarchy. See changelog for details.

= 1.2 =
Performance: Minor changes for `is_child_of_category_()` and `is_parent_of_category()`, no behavior change for either

= 1.1.1 =
Bug fix 'print_pre' error fixed.

= 1.1 =
Upgrade immediately - New hierarchy, better, more reliable functionality.

= 1.0.5 =
Please upgrade to 1.0.5 - Packaging problem fixed. Several basic bug fixes

= 1.0.3 =
Please upgrade to 1.0.3. is_parent_category() and is_child_category() bugs fixed.

= 1.0.2 =
Please upgrade to 1.0.2. Bugs in 1.0.1 and below may cause some category templates to map incorrectly.

= 1.0.1 =
Please upgrade to 1.0.1. Bugs in 1.0 may cause a white screen.

== Changelog ==

= 1.3.2.1 =
* Changes made in 1.3.2 were not properly checked in - this version is a re-release of 1.3.2 - apologies for the inconvenience.
 
= 1.3.2 =
* Bug: [FIXED] `category-slug.php` and `category-id.php` were being excluded from the list of templates if the current category was neither a parent or a child.

= 1.3.1 =
* Bug: [FIXED] Plugin was not finding 'category.php' when it was available.

= 1.3 =
* Bug: [FIXED] Template Hierarchy manipulation was interfering with other parts of the native Template Hierarchy, now uses 'category_template' filter instead of 'template_redirect'.
* Bug: [FIXED] Child and Parent categories were not pulling $post and other normal globals into scope during the loop.
* Minor Logic Change: `is_child_of_category()` and `is_parent_of_category` now check specifically for `$category_parent->parent` and `$parent_category->term_id`, because the way it was before, honestly did not make much sense. 

= 1.2 =
* Performance enhancement: Added a simple check to `is_child_of_category_()` and `is_parent_of_category()` to return false if empty, before bothering to check if there are relationships. Prevents a PHP notice caused by attempting to get the property of a non-object - this would occur when either function is called and the page is not a category at all.

= 1.1.1 =
* Fixed 'print_pre' bug caused by a debugging function which I failed to remove when debugging was completed.

= 1.1 =
* Completely restructured the hierarchical modifications this plugin creates.
* Added child-of-category-{slug}.php and child-of-category-{id}.php templates
* Added is_child_of_category() and is_parent_of_category() functions.
* Removed child-category-{slug}.php, child-category-{id}.php, parent-category-{slug}.php, parent-category-{id}.php because they aren't very useful and just dont fit into the cool crowd.
* Fixed all known bugs, and a few that were not known.

= 1.0.5 =
* First actually stable release
* Packaging problem fixed - the plugin was incorrectly packaged, such that it failed on activation.
* Fixed several other very bad bugs

= 1.0.3 =
* Fixed problems with the is_parent_category() and is_child_category() functions where they returned `null` if called from a non-category page. 
* Removed the 'happy accident' wherein a category which is both a parent and a child results in a hierarchy based on parent-child-categroy.php. This reveals a more important problem which I plan to fix for version 1.1.
* Fixed a silly bug. Misspelled `is_numberic` rather than `is_numeric`.
* Removed unnecessary `exit`.

= 1.0 =
* Initial commit.
