<div class="cook-detail">
	<p class="header"><span class="green">USER PROFILE</span></p>
	<img src="<?= $user->getProfileImg() ?>" height="100" width="100" alt="<?= $user->getDisplayName() ?>" class="main-img" />
  <div class="desc pb10">
  	<p class="green fs15"><?= $user->getDisplayName() ?></p>
    <p>
    <?
    if ($user->getLocCity() != '') {
			echo '<span class="green">Location:</span><br />';
      echo $user->getLocCity() . ',';
    }
    ?> <?
    if ($user->getLocState() != '') {
      echo $user->getLocState();
    }
    ?>
    </p>
    <? if ($user->getAboutMe()): ?>
    	<p><span class="green">About Me:</span><br /><?= $user->getAboutMe() ?></p>
    <? endif; ?>   
  </div><!-- /.desc -->
	<? if (($interests = $user->getInterests()) && $interests->count()): ?>
  <p class="header clear"><span class="green"><? // = ($my_profile ? 'My' : $user->getDisplayName()) ?> Interests:</span></p>
  <ul class="pl10 pr10 pb10">
		<? foreach ($interests as $interest): ?>
    <li><?= $interest->getName() ?></li>
    <? endforeach; ?>
  </ul>
  <? endif; ?>
  <? include_component('cooks', 'badges', array('blog_id' => $user->getBlogId(), 'class' => '')) ?>
  
  <?php 
  /* as per ET # 6383, please remove points
  <? if (isset($points) && sizeof($points)>0): ?>
  <p class="points">Points earned: <strong><?=$points['points']?></strong></p>
  <? endif; ?>
  */
  ?>
</div><!-- /.grp-detail -->