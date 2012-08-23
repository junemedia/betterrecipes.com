<div id="recipe-sharebar" class="border-bottom">
  <div id="inlinesharebar"></div>
  <? if (isset($category) && $category->getSlug()=='lowcarb'): ?>
    <div class="flri">
      <? include_partial('global/adtags/120x60') ?>
    </div>
  <? endif; ?>
</div>
<script>
  $(document).ready(function(){
    brmb.gigya.sharebar();
  });
</script>