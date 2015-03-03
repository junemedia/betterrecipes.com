<div id="recipe-category" style="min-height:auto;">
<?
/*
* as per MERBETTERR-17 * 
  <div class="imgmask200 bordshad flle mr20">
    <img src="<?= $category->getImgSrc() ?>" alt="<?= $category->getName() ?>" />
  </div>
*/
//print_r($category);
?>
  <h3 class="title green mb10" style="position: relative; margin-bottom: 20px!important;"><span style="width: 295px; display: inline-block;"><?= $category->getName() ?></span><a href="<?= getUrl('@add_recipe') ?>" title="Upload a recipe" class="btn-grey28 flri mb10 ml10" style="position: absolute; top: 0px; right: 0px;">UPLOAD A RECIPE</a></h3>
  <p class="mb20 clri summary"><?= $category->getDescription() ?></p>
  <? if ($children = @$category->getSelectedChildren()): ?>
    <ul class="hornav mt20 mb20">
      <? foreach ($children as $child): ?>
        <li><a href="<?= getUrl($child) ?>" title="Subcategory"><?= $child->getName() ?></a></li>
      <? endforeach; ?>          
    </ul>
  <? endif; ?>
</div><!-- /#group-detail -->
