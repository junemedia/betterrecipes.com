<div class="contest-detail pb10 ovhid img100left">
  <p class="header"><span class="green"><?= $contest->getName() ?></span></p>
  <span class="img-wrap"><img src="<?= $contest->getImgSrc() ?>" height="100" width="100" alt="<?= $contest->getName() ?>" /></span>
  <div class="desc">
    <p><?= $contest->getDescription() ?></p>
    <div class="sponsor"><? include_partial('global/adtags/sponsor', compact('sponsor')) ?></div>
    <ul>
      <li>Prize: <?= $contest->getPrize() ?></li>
      <li>End Date: <?= date('m/d/y', strtotime($contest->getEndDate())) ?></li>
      <li><a href="<?= getUrl('@contests_rules?slug='.$contest->getSlug()) ?>">Official Rules</a></li>
    </ul>
  </div>
</div><!-- /.grp-detail -->

<? if (count($contestants->getResults()) > 0): ?>
	<div id="contest-entries">
	    <p class="header"><span class="green">view entries</span></p>
	    <ul class="img75left divider">
	    	<? include_partial('recipeEntries', compact('contestants', 'contestId')) ?>
	    </ul>
	</div><!-- /#recipe-entries -->
<? endif; ?>