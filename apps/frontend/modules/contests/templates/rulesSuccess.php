<? include_partial('global/bread_crumbs', compact('bread_crumbs')) ?>
<div class="article contests">
  <div id="contest-detail">
    <p class="title green pb20">Official Rules</p>
    <p class=""><?= $contest->getRules() ?></p>
  </div>
</div><!-- /.article -->

<? include_partial('global/right_rail/right_rail') ?>