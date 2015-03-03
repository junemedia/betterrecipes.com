<? if (isset($friends) && sizeof($friends) > 0): ?>
 
 
  <p class="header">My Friends Activity</p>
  <? if ($friends->haveToPaginate()): ?>
    <div class="pagination">
      <div class="nbResults"><?= $friends->getPage() ?> - <?= count($friends->getLinks()) ?> of <?= $friends->getNbResults() ?></div>
      <div class="sorting shift-right">
        <p class="pager arrows going-to-make">
          <? if ($friends->getPreviousPage() == $friends->getPage()): ?>
            <img src="/img/arrow-grey-previous.png" />
          <? else: ?>
            <a onclick="friendRibbon(<?= $friends->getPreviousPage() ?>, 10)"><img src="/img/arrow-purple-previous.png" /></a>
          <? endif; ?>
          <? if ($friends->getNextPage() == $friends->getPage()): ?>
            <img src="/img/arrow-grey-next.png" />
          <? else: ?>
            <a onclick="friendRibbon(<?= $friends->getNextPage() ?>, 10)"><img src="/img/arrow-purple-next.png" /></a>
          <? endif; ?>
        </p>
      </div>
    </div>
  <? endif; ?>
  
  
  <div id="friends_bar">
    <? foreach ($friends as $f): ?>
      <ul>
        <li class="users">
          <? // fetch activities per friend ?>
          <? $activity = UserActionsTable::getFbUserActivity(array('page_no' => 1, 'results_per_page' => 5, 'fb_user_id' => $f->getFbUserId())); ?>
          <? if (isset($activity)): ?> 
            <img class="friend-avatar" src='<?= $f->getUser()->getAvatarSrc() ?>'>
          <? else: ?>
            <img src='<?= $f->getUser()->getAvatarSrc() ?>'>
          <? endif; ?>
          <? if (isset($activity)): ?>
            <div class="friend_activity_list">
              <div class="tooltip-container"><img class="tooltip-arrow" src="/img/tooltip-arrow.png" /></div>
              <ul class="activity-list">
                <p class="name"><?= $f->getUser()->getFirstName() ?> <?= $f->getUser()->getLastName() ?>'s Activity</p>
                <? foreach ($activity as $a): ?>
                  <li>
                    <? if (!is_null($recipe = $a->getRecipe())) : ?>
                      <a class="img" href="<?= getUrl($recipe) ?>" title="<?= $recipe->getName() ?>">
                        <img src="<?= $recipe->getMainImageSrc() ?>" />
                      </a>
                      <div class="info">
                        <p class="big"><a href="<?= getUrl($recipe) ?>" title="<?= $recipe->getName() ?>"><?= Utilities::truncateHtml($a->getMessage(), 30) ?></a></p>
                        <p class="small"><?= Utilities::showDate($a->getCreatedAt()) ?></p>
                      </div><!-- // info -->
                    <? endif; ?>
                  </li>          
                <? endforeach; ?>
              </ul>
            </div>
          <? endif; ?>
        </li>
      </ul>
    <? endforeach; ?>
  </div><!-- // friends_bar -->
  <div style="clear:left;"></div>
<? endif; ?>