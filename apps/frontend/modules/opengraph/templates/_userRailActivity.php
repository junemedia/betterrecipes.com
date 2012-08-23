<? if (@$activity && sizeof($activity) > 0): ?>
  <p class="header">Going to make</p>
  <? if ($activity->haveToPaginate()): ?>
    <div class="pagination">
      <div class="sorting shift-right">
        <p class="pager arrows going-to-make">
          <? if ($activity->getPreviousPage() == $activity->getPage()): ?>
            <img src="/img/arrow-grey-previous.png" />
          <? else: ?>
            <a onclick="userRailActivity(<?= $activity->getPreviousPage() ?>, 3)"><img src="/img/arrow-purple-previous.png" /></a>
          <? endif; ?>
          <? if ($activity->getNextPage() == $activity->getPage()): ?>
            <img src="/img/arrow-grey-next.png" />
          <? else: ?>
            <a onclick="userRailActivity(<?= $activity->getNextPage() ?>, 3)"><img src="/img/arrow-purple-next.png" /></a>
          <? endif; ?>
        </p>
      </div>
    </div>
  <? endif; ?>
  <ul class="activity-list">
    <? foreach ($activity as $k => $a): ?>
      <? if (!is_null($recipe = $a->getRecipe())) : ?>
        <li<? if ($k == 2): ?> class="last"<? endif; ?>>
          <p>
          <div class="thumb-container">
            <a href="<?= getUrl($recipe) ?>" title="<?= $recipe->getName() ?>">
              <img class="recipe-thumb" src="<?= $recipe->getMainImageSrc() ?>" />
              <img class="delete-activity" src="/img/delete-activity.png" onclick="deleteActivityLog(this, <?= $a->getId() ?>)" />
            </a>
          </div>
          <a href="<?= getUrl($recipe) ?>" title="<?= $recipe->getName() ?>"><?= Utilities::truncateHtml($recipe->getName(), 45) ?></a>
          </p>
        </li>
      <? endif; ?>
    <? endforeach; ?>
  </ul>
<? endif; ?>