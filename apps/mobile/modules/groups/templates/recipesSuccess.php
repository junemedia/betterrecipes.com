<? include_partial('group_info', compact('my_group', 'group', 'blog_id', 'active', 'is_sponsor', 'sponsor')) ?>

<? //include_partial('jumpnav') ?>
<? include_partial('link_people'); ?>
<? include_partial('link_discussions'); ?>
<div id="recipes"> 
  <p class="header"><span class="green">RECIPES</span></p>
  <p class="tabbednav">
    <a href="javascript:;" onclick="ajaxPaginateRecipesSort('#recipes', '<?= url_for(@group_paginate_recipes) ?>', '1', '<?= $group['subdir'] ?>', '<?= $group_cat ?>', 'views')" title="Sort by most popular" <? if ($sortby == 'views' || !$sortby || ($sf_request->getParameter('sort') == 'pop')) {
    echo 'class="active"';
    } ?> >Most Popular</a>  
    |  <a href="javascript:;" onclick="ajaxPaginateRecipesSort('#recipes', '<?= url_for(@group_paginate_recipes) ?>', '1', '<?= $group['subdir'] ?>', '<?= $group_cat ?>', 'date')" title="Sort by date" <? if ($sortby == 'date') {
    echo 'class="active"';
    } ?>>Most Recent</a>
  </p>
  <? // if (count($recipes) > 0): ?> 
  <ul class="divider">
    <? include_partial('group_recipes', compact('my_group', 'pager', 'group', 'blog_id', 'group_cat', 'sortby')) ?>
  </ul>
  <? /* else: ?>
  <p class="just-copy pt10 pb10">This group has not created any recipes</p>
	<? endif; */ ?>
</div><!-- /#recipes -->
<? include_partial('link_polls'); ?>
<? include_partial('link_photos'); ?>
<? include_partial('link_videos'); ?>