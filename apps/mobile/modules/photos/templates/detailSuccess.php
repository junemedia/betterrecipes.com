<? if ($photo): ?>
<div class="photo-detail">
  <p class="header"><span class="green"><?= $photo['caption'] ?></span></p>
	<span class="img-wrap"><img src="<?= $photo['photo_url'] ?>" width="<?= $photo['width'] ?>" height="<?= $photo['height'] ?>" /></span>
  <p class="fs11 just-copy">by: <a href="<?= getRoute('User', array('subdir' => $photo['username'])) ?>"><?= $photo['display_name'] ?></a> @ <?= $photo['date_created'] ?></p>

<? include_partial("photo_sharebar"); ?>

<? if ($sponsored): ?>
<div class="sponsor adsponsor">
<? include_partial('global/adtags/sponsor', compact('sponsor')) ?>
</div>
<? endif; ?>

<div class="badge20"><? include_component('cooks', 'badges', array('blog_id' => $photo['user_blog_id'], 'class' => 'hor-list')) ?></div>

</div>
<? endif; ?>
<p class="header"><span class="green">COMMENTS</span></p>
<div id="comments">
  <ul class="img50left">
		<? if (sizeof($comments) > 0): ?>
    <? include_partial('global/comments', compact('comments', 'comments_pager', 'contentId')) ?>
    <? endif; ?>
  </ul>
</div><!-- /#comments -->


