<div id="recipe-sharebar" class="mt10 border-bottom" style="display:none;">
  <div id="inlinesharebar" <? if (isset($slideshow)): ?>class="flle"<? endif; ?>></div>
  <? if (isset($slideshow)): ?>
    <div class="view-thumbnails">
    <? if ($sf_user->isAuthenticated()): ?>
      <a id="view_thumbnails"><? if ($showall): ?>view all<? else: ?>hide<? endif; ?> thumbnails</a>
    <? endif; ?>
    </div>
  <? endif; ?>
</div>

<script>
  $(document).ready(function () {
    brmb.gigya.sharebar();
  });
</script>
