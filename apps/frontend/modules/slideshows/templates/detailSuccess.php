<? include_partial('global/bread_crumbs', compact('bread_crumbs')) ?>
<div class="article">
  <div id="slideshow-wrap">
    <? if ($slideshow->getSponsorId()): ?>
      <? $sponsor = $slideshow->getSponsor() ?>
      <div id="sponsor_<?= $sponsor->getId() ?>"class="sponsor adsponsor">
        <? include_partial('global/adtags/sponsor', compact('sponsor')) ?>
      </div>
    <? endif; ?>
    <? if ($sf_user->isAuthenticated()): ?>
      <? include_partial('thumbnails', compact('slides', 'showall')) ?>
    <? endif; ?>
    <? include_partial('slideshow', compact('slideshow', 'slides', 'showall')) ?>
    <? include_partial('groups', compact('groups')) ?>
    <? include_partial('recipes_slideshows', compact('recipes', 'slideshows', 'category')) ?>
  </div><!-- /#slideshow -->                    
</div><!-- /.section -->
<? include_partial('right_rail', compact('rr_recipes')) ?>