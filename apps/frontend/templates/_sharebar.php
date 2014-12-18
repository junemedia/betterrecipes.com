<div id="recipe-sharebar" class="mt10 border-bottom">
  <div id="inlinesharebar"<? if (isset($slideshow)): ?> class="flle"<? endif; ?>></div>
  <? if (isset($slideshow)): ?>
    <!--
	<a href="<?= url_for('@slideshow_print?regSource=8292&slug=' . $slideshow->getSlug()) ?>" id="slidesshowprintbtn" title="Print this recipe" class="btn-grey28 flle" target="_blank">Print Recipe</a>
    -->
	<div class="view-thumbnails">
      <? if ($sf_user->isAuthenticated()): ?>
        <a id="view_thumbnails"><? if ($showall): ?>view all<? else: ?>hide<? endif; ?> thumbnails</a>
      <? else: ?>
	  <!--
        <a href="<?= url_for('@slideshow_all?regSource=8292&slug=' . $slideshow->getSlug()) ?>" onclick="appendPageNo(this)">view all thumbnails</a>
		-->
      <? endif; ?>
    </div>
  <? endif; ?>
</div>
<script>
  $(document).ready(function(){
    brmb.gigya.sharebar();
  });
</script>