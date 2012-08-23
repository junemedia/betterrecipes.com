<? if(isset($cooks['items'])): ?>
<div id="popular-cooks">
    <p class="title">Popular Cooks</p>
    <p>Meet some of the friendly food-lovers who make Better Recipes the place for recipe sharing. Click on a photo or name to learn more about a cook, see what they’ve been posting, or invite them to connect.</p>
    <ul class="mt20">
	<? for($i = 0; $i < count($cooks['items']); $i++): ?>
      <li class="mb20">
      	<a href="<?=getRoute('User', array('subdir' => $cooks['items'][$i]['username']))?>" title="<?=$cooks['items'][$i]['display_name']?>" class="imgmask100 mb10">
          <img src="<?=$cooks['items'][$i]['avatar']?>" />
        </a>
        <p><a href="<?=getRoute('User', array('subdir' => $cooks['items'][$i]['username']))?>"><?=$cooks['items'][$i]['display_name']?></a></p>
      </li>
    <? endfor; ?>
    </ul>
    <p class="cta-more"><a href="<?=getRoute('@search', array('page' => 'member'))?>" title="See more popular cooks" class="purple">see more&raquo;</a></p>
</div><!-- /#popular-cooks -->
<? endif; ?>
