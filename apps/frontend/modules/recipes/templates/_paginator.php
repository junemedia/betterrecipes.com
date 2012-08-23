<? $pages = $recent_recipes->getLinks(); ?>
<p class="pager">
  <a onclick="updateRecentRecipes(<?= $recent_recipes->getPreviousPage() ?>)"><<</a>
  <? if ($pages[0] > $recent_recipes->getFirstPage()): ?>
    <a onclick="updateRecentRecipes(<?= $recent_recipes->getFirstPage() ?>)"><?= $recent_recipes->getFirstPage() ?></a> ... 
  <? endif ?>
  <? foreach ($pages as $page): ?>
    <? if ($page == $recent_recipes->getPage()): ?>
      <span><?= $page ?></span>
    <? else: ?>
      <a onclick="updateRecentRecipes(<?= $page ?>)"><?= $page ?></a>
    <? endif; ?>
  <? endforeach ?>
  <? if ($pages[count($pages) - 1] < $recent_recipes->getLastPage()): ?>
    ... <a onclick="updateRecentRecipes(<?= $recent_recipes->getLastPage() ?>)"><?= $recent_recipes->getLastPage() ?></a>
  <? endif ?>
  <a onclick="updateRecentRecipes(<?= $recent_recipes->getNextPage() ?>)">>></a>
</p>