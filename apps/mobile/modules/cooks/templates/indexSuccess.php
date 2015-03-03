<div class="cooks-detail">
	<p class="header"><span class="green">Cooks</span></p>
  <p class="just-copy">Whether you're looking for a friend who's already a member of the Mixing Bowl community or simply want to find a kindred soul to swap recipes and cooking tips with, you can do both here. Here at Mixing Bowl, food and friends are made fresh daily!</p>
</div>

<div class="featured-cook img100left pt10 pb10 ovhid">
	<span class="img-wrap"><img src="/img/m/img-group5.jpg" height="100" width="100" alt="Group Name" /></span>
  <div class="desc">
    <p class="fs15 green">Featured [Cook Name]</p>
    <p>[COOK DESCRIPTION]</p>
  </div>
</div>


<div class="active-cooks">
	<? if(isset($cooks) && sizeof($cooks)>0): ?>
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
      <a href="<?=getRoute('User', array('subdir' => $cooks['items'][$i]['username']))?>" class="img-mask"><img src="<?=$cooks['items'][$i]['avatar']?>" height="75" width="75" alt="<?=$cooks['items'][$i]['display_name']?>" /></a>
      <div class="desc">
      	<p><a href="<?=getRoute('User', array('subdir' => $cooks['items'][$i]['username']))?>" title="<?=$cooks['items'][$i]['display_name']?>"><?=$cooks['items'][$i]['display_name']?></a></p>
      </div>
    </li>
    <? endfor; ?>
  </ul>
  <? endif; ?>
</div>