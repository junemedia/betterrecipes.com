<? foreach($recipes->getResults() as $r): ?>          
  <li class="all-copy">
    <p><a href="<?= getUrl($r) ?>" title="<?= $r->getName() ?>"><?=$r->getName()?></a></p>
    <p><?= $r->getDescription()?></p>
    <p class="fs11"><?= date('m/d/Y h:i A', strtotime($r->getCreatedAt())) ?></p>
  </li>                               
<? endforeach; ?> 

<? if ($recipes->haveToPaginate()): ?>
  	<? $currentPage = $recipes->getPage() ?>

	<? if ($currentPage < $recipes->getLastPage()): ?>
  <li class="pagination">
  <? $route = url_for('@cook_profile_recipes_paginate'); ?>
  	<a onclick="ajaxPaginateUserRecipes('#list', '<?=$route?>', '<?=$recipes->getNextPage()?>', '<?=$userId?>')" title="Load more entries" href="javascript:;" style="cursor:pointer;">&gt;&gt; Load more entries</a>
  </li>
  <? endif; ?>

<? endif; ?>
