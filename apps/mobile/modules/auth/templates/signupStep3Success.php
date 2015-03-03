<div class="article registration">
  <? //include_component('static', 'topper') ?>
	<p class="title green">Welcome
  <? if ($referrer): ?>
  	<a class="btn-grey28 flri mb10" href="<?= $referrer ?>">Go to site</a>
  <? endif ?></p>
  <p class="summary mb20 clear">Welcome to Better Recipes.com Below is a list of recommended recipes, and groups to help get you started Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
  
  <? if (isset($popgroups['items'])): ?>
  <div id="popular-groups">
      <p class="title">Recommended Groups for you</p>
      <p>Groups are the best places to meet like-minded chefs who share your lifestyle and cooking interests</p>
      <ul>
      	<? for($i = 0; $i < count($popgroups['items']); $i++): ?>
        <li>
        	<a href="<?=getRoute('@group_detail', array('category' => $popgroups['items'][$i]['category'], 'slug' => $popgroups['items'][$i]['slug']))?>" title="<?=$popgroups['items'][$i]['group_display_name']?>" class="imgmask150">
	            <img src="<?=$popgroups['items'][$i]['group_photo']?>" height="150" width="150" alt="<?=$popgroups['items'][$i]['group_display_name']?>" />
	        </a>
              <p><a href="<?=getRoute('@group_detail', array('category' => $popgroups['items'][$i]['category'], 'slug' => $popgroups['items'][$i]['slug']))?>" title=""><img src="/img/img-popgroups-arrow.png" height="23" width="8" /><?=Utilities::truncateHtml($popgroups['items'][$i]['group_display_name'], 20)?><br />
              <span>(<?=$popgroups['items'][$i]['num_members']?> members)</span></a></p>
              <div></div>
          </li>
          <? endfor; ?>
      </ul>
      <p class="cta-more"><a href="<?=getRoute('@search', array('page' => 'group'))?>" title="See more popular groups" class="purple">see more&raquo;</a></p>
  </div><!-- /#popular-groups -->
  <? endif; ?>
  
  
  
  
<!--  <div id="contest-entries">
    <p class="title">Recipe Contests</p>
    <p class="mb20">Based on your preferences, these are some recipes we think you will like. Enjoy!</p>
      <ul class="hornav">
          <li>
            <div class="star"></div>
              <img src="/img/img-mycontest1.jpg" height="100" width="100" alt="Recipe Name" />
              <p><a href="#" title="Contest Name">Contest Name</a></p>
          </li>
          <li>
              <div class="star"></div>
              <img src="/img/img-mycontest1.jpg" height="100" width="100" alt="Recipe Name" />
              <p><a href="#" title="Contest Name">Contest Name</a></p>
          </li>
          <li class="winner">
            <div class="star"></div>
              <img src="/img/img-mycontest1.jpg" height="100" width="100" alt="Recipe Name" />
              <p>WINNER!</p>
              <p><a href="#" title="Contest Name">Contest Name</a></p>
              
          </li>
          <li>
            <div class="star"></div>
              <img src="/img/img-mycontest1.jpg" height="100" width="100" alt="Recipe Name" />
              <p><a href="#" title="Contest Name">Contest Name</a></p>
          </li>
          <li class="last">
            <div class="star"></div>
              <img src="/img/img-mycontest1.jpg" height="100" width="100" alt="Recipe Name" />
              <p><a href="#" title="Contest Name">Contest Name</a></p>
          </li>
      </ul>
      <p class="cta-more"><a href="#" title="See more populare groups" class="purple">see more&raquo;</a></p>
  </div> /#contest-entries 
  -->
  
  <? if (@$recipes): ?>
  <div id="popular-recipes">
    <p class="title">Most Popular Recipes</p>
      <ul>
      	<? foreach ($recipes as $recipe): ?>
        <li>
            <p class="mt10"><a href="<?= getUrl($recipe) ?>" title="<?= $recipe->getName() ?>"><?= Utilities::truncateHtml($recipe->getName(), 45) ?></a></p>
              <? if ($recipe->getDescription() != ''): ?><p><span><?=$recipe->getDescription() ?></span></p><? endif; ?>
          </li>
        <? endforeach; ?>
      </ul>
      <p class="cta-more"><a href="<?=getRoute('@search', array('page' => 'Recipe'))?>" title="See more popular recipes" class="purple">see more&raquo;</a></p>
  </div><!-- /#popular-recipes -->
  <? endif; ?>
  
  
</div><!-- /.article -->