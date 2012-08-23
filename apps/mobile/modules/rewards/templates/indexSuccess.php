<div class="rewards-detail pb10">
	<p class="header"><span class="green">Rewards</span></p>
  <p class="just-copy pb10">Mixing Bowl Rewards are our way of thanking you for all your help as we work together to make Better Recipes the premier spot for recipe swapping and social sharing around food. You can earn points and badges for site activity, rising through the kitchen ranks by participating in polls, quizzes, photo sharing, recipe posting commenting, and more. So what's stopping you? Start earning points today!</p>
</div><!-- /.rewards-detail -->


<div class="rewards-info">
	<? if (isset($badges) && $badges['total'] > 0): ?>
  <p class="header"><span class="green">BADGES &amp; TROPHIES</span></p>
  
  <ul class="img50left divider shiftimg10">
    <? for ($i = 0; $i < count($badges['items']); $i++): ?>
    <li>
      <span class="img-wrap"><img width="75" height="75" src="<?= $badges['items'][$i]['img_100'] ?>" alt="<?= $badges['items'][$i]['name'] ?>" title="Recive this badge after earning <?= $badges['items'][$i]['required_points'] ?> points!" /></span>
      <p class="desc"><?= $badges['items'][$i]['name'] ?></p>
    </li>
    <? endfor; ?>
  </ul>
  <? endif; ?>
  
  <p class="all-image just-copy pb10">
    <img src="/img/loyalty_points.jpg" alt="Loyalty Rewards Program" />
  </p>	
  <div class="active-cooks">
    <? if(isset($cooks['items']) && sizeof($cooks['items'])>0): ?>
    <p class="header"><span class="green">MOST ACTIVE COOKS</span></p>
    <ul class="img75left divider">
			<? for($i = 0; $i < count($cooks['items']); $i++): ?>
      <?
      if( ($i + 1) % 3 == 0){
      echo '<li class="last">';
      } else {
      echo '<li>';
      }
      ?>
        <a href="<?=getRoute('User', array('subdir' => $cooks['items'][$i]['username']))?>" class="img-wrap"><img src="<?=$cooks['items'][$i]['avatar']?>" height="75" width="75" alt="<?=$cooks['items'][$i]['display_name']?>" /></a>
        <div class="desc">
          <p><a href="<?=getRoute('User', array('subdir' => $cooks['items'][$i]['username']))?>" title="<?=$cooks['items'][$i]['display_name']?>"><?=$cooks['items'][$i]['display_name']?></a></p>
        </div>
      </li>
      <? endfor; ?>
    </ul>
    <? endif; ?>
  </div><!-- /.active-cooks -->
</div><!-- /.rewards-info -->