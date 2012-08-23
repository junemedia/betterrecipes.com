<? include_partial('global/bread_crumbs', compact('my_group', 'bread_crumbs')) ?>
<div class="article">
  <? include_partial('cooks/user_links', compact('user', 'my_profile')) ?>
  <div id="public-profile">
    <div class="main-image">
      <img src="<?= $user->getProfileImg() ?>" height="205" width="280" alt="<?= $user->getDisplayName() ?>" />
    </div>
    <h3 class="title green ml320">
      <?= $user->getDisplayName() ?>
    </h3>
    <p class="ml320 clri"><?
      if ($user->getLocCity() != '') {
        echo $user->getLocCity() . ',';
      }
      ?> <?
      if ($user->getLocState() != '') {
        echo $user->getLocState();
      }
      ?></p>
    <? if ($user->getAboutMe()): ?>
      <p class="ml320"><span><?= $user->getAboutMe() ?></span></p>
    <? endif ?>
    <? if (($interests = $user->getInterests()) && $interests->count()): ?>
      <p class="fs14 ttupp mt20 ml320"><?= ($my_profile ? 'My' : $user->getDisplayName()) ?> Interests</p>
      <ul class="hornav interests ml320 ovhid">
        <? foreach ($interests as $interest): ?>
          <li><?= $interest->getName() ?></li>
        <? endforeach ?>
      </ul>
    <? endif ?>
    <? if (isset($points) && sizeof($points) > 0): ?>
      <p class="interests ml320 ovhid">
        Points earned: <strong><?= $points['points'] ?></strong>
      </p>
    <? endif; ?>
  </div><!-- /#group-detail -->
  <div style="clear:both;"></div>  
  <div id="groups">
    <p class="title">My Saved Recipes</p>
    <div class="sorting">
      <? if ($recipes->haveToPaginate()): ?>
        <ul class="pager hornav">           
          <? $currentPage = $recipes->getPage() ?>
          <? if ($currentPage == 1): ?><li class="unavailable"><? else: ?><li><? endif; ?>
            <a href="<?= UrlToolkit::getDomainUri() . url_for(array('module' => 'cooks', 'action' => 'savedRecipes', 'subdir' => $user->getSubdir(), 'page' => $recipes->getPreviousPage())) ?>">&laquo;</a>
          </li>
          <?
          $links = $recipes->getLinks();
          foreach ($links as $page):
            ?>
            <? if ($page == $recipes->getPage()) { ?>
              <li class="active"><a><?= $page ?></a></li>
            <? } else { ?>
              <li><a href="<?= UrlToolkit::getDomainUri() . url_for(array('module' => 'cooks', 'action' => 'savedRecipes', 'subdir' => $user->getSubdir(), 'page' => $page)) ?>"><?= $page ?></a></li> 
            <? } ?>
          <? endforeach ?>
          <? if ($currentPage == $recipes->getCurrentMaxLink()): ?><li class="unavailable"><? else: ?><li><? endif; ?>
            <a href="<?= UrlToolkit::getDomainUri() . url_for(array('module' => 'cooks', 'action' => 'savedRecipes', 'subdir' => $user->getSubdir(), 'page' => $recipes->getNextPage())) ?>">&raquo;</a>
          </li>
        </ul>
      <? endif; ?>
    </div><!-- /.sorting -->
    <ul class="border-bottom">
      <? foreach ($recipes->getResults() as $r): ?>          
        <li class="clear flle w660">
          <p><a class="clear flle mr20" href="<?= getUrl($r) ?>" title="<?= $r->getName() ?>"><?= $r->getName() ?></a></p>
          <p class="meta clear flle mr20"><span><?= $r->getDescription() ?></span></p>
          <p class="fs11 clear flle mr20"><?= date('m/d/Y h:i A', strtotime($r->getCreatedAt())) ?></p>
        </li>                               
      <? endforeach; ?> 
    </ul>
  </div>
</div><!-- /.section -->
<? include_partial('global/right_rail/right_rail_loggedin', compact('groups', 'friends', 'contentId', 'comments', 'user_id', 'profile', 'my_profile')) ?>