<? include_partial('group_info', compact('my_group', 'group', 'blog_id', 'active', 'is_sponsor', 'sponsor')) ?>

<? //include_partial('jumpnav') ?>

<? include_partial('link_people'); ?>
<? include_partial('link_discussions'); ?>
<? include_partial('link_recipes'); ?>
<? include_partial('link_polls'); ?>        	
<div id="photos"> 
  <p class="header"><span class="green">PHOTOS</span></p>  
  <!-- sort options -->
  <? if (isset($photos) && sizeof($photos) > 0): ?>
  <p class="sort-options tabbednav"> 
  <a href="javascript:;" style="cursor:pointer;" onclick="ajaxPaginatePhotosSort('#photos-list', '<?= url_for('@group_paginate_photos') ?>', '1', '<?= $group['subdir'] ?>', 'views')" title="Sort by most popular" <?
  if ($sortby == 'views' || !$sortby) {
  echo 'class="active"';
  }
  ?> >Most Popular</a>  |  
  <a href="javascript:;" style="cursor:pointer;" onclick="ajaxPaginatePhotosSort('#photos-list', '<?= url_for('@group_paginate_photos') ?>', '1', '<?= $group['subdir'] ?>',  'date')" title="Sort by date" <?
  if ($sortby == 'date') {
  echo 'class="active"';
  }
  ?>>Most Recent</a></p>
  </p>
  <? endif; ?>
  <? if (count($photos) > 0): ?> 
  <ul class="img100left"> 
  	<? include_partial('group_photos', compact('sortby', 'blog_id', 'photos', 'photos_pager', 'group')) ?>
  </ul>     
  <? else: ?>
  <p class="just-copy pt10 pb10">This group has not uploaded any photos</p>
	<? endif; ?>   	
</div>
<? include_partial('link_videos'); ?>