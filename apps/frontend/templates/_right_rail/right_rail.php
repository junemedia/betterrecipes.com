<div class="sidebar">
  <ul class="mb-nav">
    <li class="add"><a href="<?= getUrl('@add_recipe') ?>" title="Add a recipe">add a recipe</a><li>
  </ul>
  <div id="rr_user_area" class="mt0"></div>
  <div class="ad300x250">
    <? include_partial('global/adtags/300x250') ?>
  </div><!-- /.ad300x250 -->
  <? include_component('recipes', 'rr_recipes', compact('rr_recipes')) ?>
  
  <div id="vswContainer"><? //include_partial('global/right_rail/vsw') ?></div><!-- // #vswContainer -->
  <? include_partial('global/right_rail/contest') ?>
  
  <div id="sponsor">
    <? include_component('adtags', 'kelloggs_rr') ?>
  </div><!-- /#sponsor -->
</div><!-- /.sidebar -->
<div class="clearfix"></div>
