<? include_partial('global/bread_crumbs', compact('my_group', 'bread_crumbs')) ?>
<div class="article">
  <? include_partial('cooks/user_links', compact('user', 'my_profile')) ?>
  <div id="public-profile">
    <div class="main-image">
      <img src="<?=$user->getProfileImg()?>" height="205" width="280" alt="<?=$user->getDisplayName()?>" />
    </div>
    <h3 class="title green ml320">
	  <?=$user->getDisplayName()?>
    </h3>
    <p class="ml320 clri"><? if($user->getLocCity() != '') { echo $user->getLocCity().','; } ?> <? if($user->getLocState() != '') { echo $user->getLocState(); } ?></p>
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
  <div style="clear:both;"></div>  
  <div>
    <p class="title">My Recipes</p>      
    <div class="sorting">
      <? if ($recipes->haveToPaginate()): ?>
        <ul class="pager hornav">           
          <? $currentPage = $recipes->getPage() ?>
          <? if ($currentPage == 1): ?><li class="unavailable"><? else: ?><li><? endif; ?>
            <a href="<?=getRoute('@cook_profile_recipes?subdir='.$user->getSubdir().'&page='.$recipes->getPreviousPage())?>">&laquo;</a>
          </li>
          <? $links = $recipes->getLinks(); foreach ($links as $page): ?>
		  <?=($page == $recipes->getPage()) ? '<li class="active"><a>'.$page.'</a></li>' : '<li><a href="'.getRoute('@cook_profile_recipes?subdir='.$user->getSubdir().'&page='.$page).'">'.$page.'</a></li>' ?>
		  <? endforeach ?>
          <? if ($currentPage == $recipes->getCurrentMaxLink()): ?><li class="unavailable"><? else: ?><li><? endif; ?>
			<a href="<?=getRoute('@cook_profile_recipes?subdir='.$user->getSubdir().'&page='.$recipes->getNextPage())?>">&raquo;</a>
		  </li>
        </ul>
      <? endif; ?>
      </div><!-- /.sorting -->
      <ul class="border-bottom">
        <? foreach($recipes->getResults() as $r): ?>          
          <li>
            <p><a href="<?= getUrl($r) ?>" title="<?= $r->getName() ?>"><?=$r->getName()?></a></p>
            <p><?= $r->getDescription()?></p>
            <p class="fs11"><?= date('m/d/Y h:i A', strtotime($r->getCreatedAt())) ?></p>
          </li>                               
        <? endforeach; ?> 
      </ul>
    
  </div><!-- /#groups --> 
</div><!-- /.section -->
<? include_partial('global/right_rail/right_rail_loggedin', compact('groups', 'friends', 'contentId', 'comments', 'user_id', 'profile', 'my_profile')) ?>