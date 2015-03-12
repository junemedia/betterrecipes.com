<div id="sidebar-ourbest">
  <!--INFOLINKS_OFF-->
  <p class="title">Our Best Recipe Collections<?php //echo $ob_title;?></p>
  <!--INFOLINKS_ON-->
  <? if (@$ob_recipes): ?>
    <ul>
      <? //foreach ($ob_recipes as $recipe): 

		//$recipe = $ob_recipes[mt_rand(0,4)];
	  ?>
        <li>
			<div class="ourbest_image">
				<a href="<?= getUrl($ob_recipe) ?>" title="<?= $ob_recipe->getName() ?>"><img style="width:300px; height:250px;" src="<?= $ob_recipe->getMainImageSrc() ?>"/></a></a>
			</div>
          <p><a href="<?= getUrl($ob_recipe) ?>" title="<?= $ob_recipe->getName() ?>"><?= Utilities::truncateHtml($ob_recipe->getName(), 45) ?></a></p>
        </li>
      <?// endforeach; ?>
    </ul>
  <? endif; ?>
</div><!-- /#sidebar-recipes -->
