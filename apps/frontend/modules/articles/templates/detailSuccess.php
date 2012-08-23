<? include_partial('global/bread_crumbs', compact('bread_crumbs')) ?>
<div class="article">
	<? include_partial("article_sharebar"); ?>
  <? if ($article->getSponsorId()): ?>
    <? $sponsor = $article->getSponsor() ?>
    <div id="sponsor_<?= $sponsor->getId() ?>"class="sponsor adsponsor">
      <? include_partial('global/adtags/sponsor', compact('sponsor')) ?>
    </div>
  <? endif; ?>
  <div id="article-detail">
    <h3 class="title green"><?= $article->getName() ?></h3>
    <p><?= $article->getDescription() ?></p>
    <?= $article->getContent() ?>
  </div><!-- /#article-detail -->
</div><!-- /.section -->
<? include_partial('global/right_rail/right_rail', compact('rr_recipes')) ?>