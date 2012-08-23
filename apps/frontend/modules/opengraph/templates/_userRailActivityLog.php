<? if (@$activity && sizeof($activity) > 0): ?>
  <p class="header">My Activity</p>
  <? if ($activity->haveToPaginate()): ?>
    <div class="sorting shift-right">
      <p class="pager arrows my-activity">
        <? if ($activity->getPreviousPage() == $activity->getPage()): ?>
          <img src="/img/arrow-grey-previous.png" />
        <? else: ?>
          <a onclick="userRailActivityLog(<?= $activity->getPreviousPage() ?>, 5)"><img src="/img/arrow-purple-previous.png" /></a>
        <? endif; ?>
        <? if ($activity->getNextPage() == $activity->getPage()): ?>
          <img src="/img/arrow-grey-next.png" />
        <? else: ?>
          <a onclick="userRailActivityLog(<?= $activity->getNextPage() ?>, 5)"><img src="/img/arrow-purple-next.png" /></a>
        <? endif; ?>
      </p>
    </div>
  <? endif; ?>
  <hr />
  <ul>
    <? foreach ($activity as $a): ?>
      <? if (!is_null($recipe = $a->getRecipe())) : ?>
        <li>
          <p>
          <div class="thumb-container">
            <a href="<?= getUrl($recipe) ?>" title="<?= $recipe->getName() ?>">
              <img class="recipe-thumb" src="<?= $recipe->getMainImageSrc() ?>" />
              <img class="delete-activity" src="/img/delete-activity.png" onclick="deleteActivityLog(this, <?= $a->getId() ?>)" />
            </a>          
          </div>
          <a href="<?= getUrl($recipe) ?>" title="<?= $recipe->getName() ?>">
            <strong><?= $a->getMessage() ?></strong><br />
            <?= Utilities::showDate($a->getCreatedAt()) ?>
          </a>
          </p>
        </li>
      <? endif; ?>
    <? endforeach; ?>
  </ul>
<? else: ?>
  <p>Your activity log is currently empty.</p>
<? endif; ?>