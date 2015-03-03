<? if (isset($recipeFriends)): ?>
  <p class="header">My Friends Activity</p>
  <div id="friends_bar">
    <? foreach ($recipeFriends as $r): ?>
      <ul>
        <li class="users">
          <? // fetch activities per friend ?>
          <? $activity = UserActionsTable::getFbUserActivity(array('page_no' => 1, 'results_per_page' => 4, 'fb_user_id' => $r->getFbUserId())); ?>
          <? // note: replace with each person's FB Avatar ?>
          <img class="friend-avatar" src="<?= $r->getUser()->getAvatarSrc() ?>">
          <? if (isset($activity)): ?>
            <ul class="activity-list">
              <li class="header">
                <p class="header"><?= $r->getUser()->getFirstName() ?> <?= $r->getUser()->getLastName() ?>'s Activity</p>
              </li>
              <? foreach ($activity as $a): ?>
                <li>
                  <p>
                    <? if (!is_null($recipe = $a->getRecipe())) : ?>
                    <div class="thumb-container">
                      <a href="<?= getUrl($recipe) ?>" title="<?= $recipe->getName() ?>">
                        <img class="recipe-thumb" src="<?= $recipe->getMainImageSrc() ?>" />
                      </a>          
                    </div>
                  <? endif; ?>
                  <a href="<?= getUrl($recipe) ?>" title="<?= $recipe->getName() ?>">
                    <strong><?= $a->getMessage() ?></strong><br />
                    <?= Utilities::showDate($a->getCreatedAt()) ?>
                  </a>
                  </p>
                </li>          
              <? endforeach; ?>
            </ul>
          <? endif; ?>
        </li>
      </ul>
    <? endforeach; ?>
  </div>
  <div class="clear-both"></div>
  <div id="friend_activity_list">
    <img class="tooltip-arrow" src="/img/tooltip-arrow.png" />
    <ul></ul>
  </div>
<? else: ?>
 <input type="button"
    onclick="sendRequestViaMultiFriendSelector(); return false;"
    value="Invite Friends"
  />
<? endif; ?>