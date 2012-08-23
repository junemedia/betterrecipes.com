<div class="article">
  <div id="slideshow-wrap">
    <? if ($slideshow->getSponsorId()): ?>
      <? $sponsor = $slideshow->getSponsor() ?>
      <div id="sponsor_<?= $sponsor->getId() ?>"class="sponsor adsponsor">
        <? include_partial('global/adtags/sponsor', compact('sponsor')) ?>
      </div>
    <? endif; ?>
    <? include_partial('slideshow', compact('slideshow', 'slides')) ?>
  </div><!-- /#slideshow -->                    
</div><!-- /.section -->