<? $counter = 1; ?>
<? foreach ($groups as $g): ?>
	<? if($counter % 3 == 1){ echo '<li class="row"><ul><li class="first">'; } else if ($counter % 3 == 0){ echo '<li class="last">'; } else { echo '<li>'; } ?>
    <a href="<?= getRoute('@group_detail', array('category' => $g['category'], 'slug' => $g['slug'])) ?>" title="<?= $g['group_display_name'] ?>" class="img-wrap"><img src="<?= $g['group_photo'] ?>" alt="<?= $g['group_display_name'] ?>" width="75" height="75" /></a>
    <p><a href="<?= getRoute('@group_detail', array('category' => $g['category'], 'slug' => $g['slug'])) ?>" title="<?= $g['group_display_name'] ?>"><?= $g['group_display_name'] ?></a></p>
    <p class="fs11 gray"><?= $g['group_desc_small'] ?></p>
  <? if($counter % 3 == 1){ echo '</li>'; } else if ($counter % 3 == 0){ echo '</li></ul></li>'; } else { echo '</li>'; } ?>
  <? $counter++; ?>                               
<? endforeach; ?> 

<? if ($groups_pager->haveToPaginate()): ?>
<? $currentPage = $groups_pager->getPage() ?>

<? if ($currentPage < $groups_pager->getLastPage()): ?>
<li class="pagination">
<? $route = url_for('@cook_profile_groups_paginate'); ?>
  <a onclick="ajaxPaginateUserGroups('#list', '<?=$route?>', '<?=$groups_pager->getNextPage()?>', '<?=$userId?>')" title="Load more entries" href="javascript:;" style="cursor:pointer;">&gt;&gt; Load more entries</a>
</li>
<? endif; ?>

<? endif; ?>