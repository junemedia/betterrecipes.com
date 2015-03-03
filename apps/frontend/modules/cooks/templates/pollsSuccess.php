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
<? include_component('cooks', 'badges', array('blog_id' => $user->getBlogId(), 'class' => 'hornav flare ml320 pt20 ovhid')) ?>	 

	<? if (isset($points) && sizeof($points)>0): ?>
    	<p class="interests ml320 ovhid">
    		Points earned: <strong><?=$points['points']?></strong>
    	</p>
    <? endif; ?>
    
  </div><!-- /#group-detail -->

    <? //var_dump($groups['items'])?>
  <div style="clear:both;"></div>  
  <div id="groups">
    <p class="title">My Polls</p>
        <? if ($polls_pager != ''): ?>      
      <div class="sorting">
        <ul class="pager hornav">
          <? if ($polls_pager->haveToPaginate()): ?>
            <? $currentPage = $polls_pager->getPage() ?>            	
            <? if ($currentPage == 1): ?><li class="unavailable"><? else: ?><li><? endif; ?>
              <a href="<?= UrlToolkit::getDomainUri() . url_for(array('module' => 'cooks', 'action' => 'polls', 'subdir' => $user->getSubdir(), 'page' => $polls_pager->getPreviousPage())) ?>">&laquo;</a>
            </li>			    
            <? $links = $polls_pager->getLinks();
            foreach ($links as $page): ?> 
              <?= ($page == $polls_pager->getPage()) ? '<li class="active"><a>' . $page . '</a></li>' : '<li><a href="' . url_for(array('module' => 'cooks', 'action' => 'polls', 'subdir' => $user->getSubdir(), 'page' => $page)) . '">' . $page . '</a></li>' ?>
            <? endforeach ?>
    <? if ($currentPage == $polls_pager->getCurrentMaxLink()): ?><li class="unavailable"><? else: ?><li><? endif; ?>
              <a href="<?= UrlToolkit::getDomainUri() . url_for(array('module' => 'cooks', 'action' => 'polls', 'subdir' => $user->getSubdir(), 'page' => $polls_pager->getNextPage())) ?>">&raquo;</a>
            </li>			      
        <? endif; ?>
        </ul>
      </div><!-- /.sorting -->
      <ul class="border-bottom">
  <? foreach ($polls as $i): ?>
          <li class="ovhid clear">
            <p><a class="clear flle mr20" href="<?= getRoute('@group_detail_polls_detail', array('category' => $i['category'], 'slug' => $i['group_slug'], 'poll_slug' => $i['poll_slug'], 'id' => $i['poll_id'])) ?>" title="<?= $i['title'] ?>"><?= $i['title'] ?></a></p>
            <p class="meta clear flle mr20"><span><?= $i['num_votes'] ?></span>  Votes</p>
            <p class="fs11 clear flle mr20">by: <a href="<?= getRoute('User', array('subdir' => $i['subdir'])) ?>" title="<?= $i['display_name'] ?>"><?= $i['display_name'] ?></a></p>
          </li>
  <? endforeach; ?>                
      </ul>             

<? endif; ?>
  </div><!-- /#groups -->
</div><!-- /.section -->
<? include_partial('global/right_rail/right_rail_loggedin', compact('groups', 'friends', 'contentId', 'comments', 'user_id', 'profile', 'my_profile')) ?>