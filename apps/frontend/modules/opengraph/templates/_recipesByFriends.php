<script>
  $('#top-friends-recipes').cycle({ 
    fx:     'scrollHorz', 
    prev:   '#previous_fr', 
    next:   '#next_fr', 
    timeout: 0
  });   
</script>
<? if (isset($recipeFriends) && sizeof($recipeFriends) > 0): ?>
  <p class="title">Your Friends Activity</p>
  <div class="recipe-slidesshow-container">
    <img src="/img/prev.png" id="previous_fr" class="previous-img" />
    <div id="top-friends-recipes" class="recipe-slidesshow">
      <? foreach ($recipeFriends as $k => $r): $recipe = $r->getRecipe() ?>
        <? if (($k % 3) == 0): ?>
          <div class="img-group">
          <? endif; ?>
          <div class="activity-container">
            <div class="img-mask">
              <a href="<?= getUrl($recipe) ?>" title="<?= $recipe->getName() ?>">
                <img src="<?= $recipe->getMainImageSrc() ?>" alt="<?= $recipe->getName() ?>" />
              </a>
            </div>
            <div class="activity-info">
              <p class="rec_title"><a href="<?= getUrl($recipe) ?>"><?= $recipe->getName() ?></a> </p>
              <? // note: when looping through friends, output each person's first & last name + their avatar ?>
              <? $fr = UserActionsTable::getRecipeByFriendsDetail(array('recipe_id' => $recipe->getId(), 'friends' => $friends)); ?>
              <? if (isset($fr) && sizeof($fr) > 0): ?>
                <ul class="friend-avatars">
                  <? foreach ($fr as $kf => $f): ?>
                    <li class="friend-avatar <? if ($kf == 3): ?> last <? endif; ?>"><img src="<?= $f->getUser()->getAvatarSrc() ?>" ></li>
                    <?
                    if ($kf == 3) {
                      break;
                    }
                    ?>
                  <? endforeach; ?>	
                </ul>
                <p style="height:40px;"> 
                  <a href="http://www.facebook.com/<?= $fr[0]->getFbUserId() ?>">
                    <?= $fr[0]->getUser()->getFirstName() ?> <?= $fr[0]->getUser()->getLastName() ?></a>
                  <? if ($r->popularity == 1): ?>
                    is making this recipe
                  <? elseif ($r->popularity == 2): ?>
                    and 1 other are making this recipe
                  <? elseif ($r->popularity > 2): ?>
                    and <?= ($r->popularity - 1) ?> others are making this recipe
                  <? endif; ?>
                </p> 
              <? endif; ?>
            </div>
          </div>
          <? if (($k % 3) == 2 || ($k + 1) == count($recipeFriends) || $k == 14): ?>
          </div>
        <? endif; ?>
        <?
        if ($k == 14) {
          break;
        }
        ?>
      <? endforeach; ?>
    </div><!-- // top-friends-recipes -->
    <img src="/img/next.png" id="next_fr" class="next-img" />
  </div>
  <div class="clear-both"></div>
<? endif; ?>