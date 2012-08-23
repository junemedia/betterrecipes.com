<? include_partial('group_info', compact('my_group', 'group', 'blog_id', 'active', 'is_sponsor', 'sponsor')) ?>

<? //include_partial('jumpnav') ?>

<? include_partial('link_people'); ?>
<? include_partial('link_discussions'); ?>
<? include_partial('link_recipes'); ?>
<? include_partial('link_polls'); ?>
<? include_partial('link_photos'); ?>
<div id="videos">  
  <p class="header"><span class="green">VIDEOS</span></p>
  <!-- sort options -->
  <? if (isset($videos) && sizeof($videos) > 0): ?>
  <p class="sort-options tabbednav">
  <a href="javascript:;" style="cursor:pointer;" onclick="ajaxPaginateVideosSort('#videos-list', '<?= url_for(@group_paginate_videos) ?>', '1', '<?= $group['subdir'] ?>', 'views')" title="Sort by most popular" <?
  if ($sortby == 'views' || !$sortby) {
  echo 'class="active"';
  }
  ?> >Most Popular</a>  |  
  <a href="javascript:;" style="cursor:pointer;" onclick="ajaxPaginateVideosSort('#videos-list', '<?= url_for(@group_paginate_videos) ?>', '1', '<?= $group['subdir'] ?>',  'date')" title="Sort by date" <?
  if ($sortby == 'date') {
  echo 'class="active"';
  }
  ?>>Most Recent</a></p>
  </p>
  <? endif; ?>
  <? if (count($videos) > 0): ?> 
  <ul class="img100left">
		<? include_partial('group_videos', compact('blog_id', 'videos', 'videos_pager', 'group', 'sortby')) ?>
  </ul>
  <? else: ?>
  <p class="just-copy pt10 pb10">This group has not created any videos</p>
	<? endif; ?>       	
</div>
