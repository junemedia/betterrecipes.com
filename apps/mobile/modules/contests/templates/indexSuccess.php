<div class="contest-detail pb10 pt10 all-copy">
	<p class="fs15 green">Recipe Contests</p>
  <p class="">Think you have a prize-winning dish? Enter your original recipe in one of our recipe contests or vote for someone else's. We have weekly and monthly recipe contests for cooks of all skill levels.</p>
</div><!-- /.contest-detail -->


<? if (count($activeContests) > 0): ?>
<ul class="active-contests img75left pb10 pt10 divider">
	<? foreach ($activeContests as $i => $contest): ?>
		<li>
      <? if ($contest->getImgSrc()): ?>
        <a href="<?= (!is_null($contest->getLeadingContestant())) ? getUrl($contest->getLeadingContestant()->getRecipe()) : getUrl('@contests_detail?slug='.$contest->getSlug()) ?>" title="View Entries" class="img-wrap"><img src="<?= $contest->getImgSrc() ?>" alt="<?= $contest->getName() ?>" width="100" height="100" /></a>
      <? endif; ?>
      <div class="desc">
      	<p class="fs15 green"><a href="<?= getRoute('contests_detail', array('slug' => $contest->getSlug())) ?>"><?= $contest->getName() ?></a></p>
        <p><?= $contest->getDescription() ?></p>
        <div class="sponsor"><? include_partial('global/adtags/sponsor', array('sponsor' => $contest->getSponsor())) ?></div>
        <a href="<?= (!is_null($contest->getLeadingContestant())) ? getUrl($contest->getLeadingContestant()->getRecipe()) : getUrl('@contests_detail?slug='.$contest->getSlug()) ?>" title="View Entries" class="gray-btn clear">VIEW ENTRIES</a>
      </div>      
		</li>
	<? endforeach; ?>
</ul><!-- /.active-contests -->
<? endif; ?>


<div class="winners-gallery">
	<p class="header"><span class="green">WINNERS GALLERY</span></p>
  <ul class="img75left divider">
		<? foreach ($contestWinners->getResults() as $i => $winner): ?>
    <li>
    <a href="<?= getUrl($winner->getRecipe()) ?>" title="<?= $winner->getRecipe()->getName() ?>" class="img-wrap">
      <img src="<?= ($winner->getRecipe()->hasPhoto()) ? $winner->getRecipe()->getPrimaryImageSrc() : '/img/recipe-img-placeholder-thumb.jpg' ?>" height="75" width="75" alt="<?= $winner->getRecipe()->getName() ?>" />
    </a>
    <p><a href="<?= getUrl($winner->getRecipe()) ?>" title="<?= $winner->getRecipe()->getName() ?>"><?= $winner->getRecipe()->getName() ?></a></p>
    <p class="fs11">By: <a href="<?= getRoute('cook_profile', array('subdir' => $winner->getUser()->getSubdir())) ?>" title="<?= $winner->getUser()->getDisplayName() ?>"><?= $winner->getUser()->getDisplayName() ?></a></p>
    </li>
    <? endforeach; ?>
    <li class="pagination"><a href="<?= url_for('@contests_past_winners') ?>">View more winners</a></li>
  </ul>
</div><!-- /.recipebox -->



<!-- Past Contests -->
<? if (count($previous_contests) > 0): ?>
	<div class="past-contests">
		<p class="header"><span class="green">Past Contests</span></p>
  <ul class="img75left divider">
	<? foreach ($previous_contests as $i => $contest): ?>
		<li>
      <? if ($contest->getImgSrc()): ?>
        <a href="<?= (!is_null($contest->getLeadingContestant())) ? getUrl($contest->getLeadingContestant()->getRecipe()) : getUrl('@contests_detail?slug='.$contest->getSlug()) ?>" title="View Entries" class="img-wrap"><img src="<?= $contest->getImgSrc() ?>" alt="<?= $contest->getName() ?>" width="100" height="100" /></a>
      </a>
      <? endif; ?>
      <div class="desc">
      <p class="fs15 green"><a href="<?= getRoute('contests_detail', array('slug' => $contest->getSlug())) ?>"><?= $contest->getName() ?></a></p>
        <p><?= $contest->getDescription() ?></p>
        <div class="sponsor"><? include_partial('global/adtags/sponsor', array('sponsor' => $contest->getSponsor())) ?></div>
        <a href="<?= (!is_null($contest->getLeadingContestant())) ? getUrl($contest->getLeadingContestant()->getRecipe()) : getUrl('@contests_detail?slug='.$contest->getSlug()) ?>" title="View Entries" class="gray-btn">VIEW ENTRIES</a>
      </div>
		</li>
	<? endforeach; ?>
		<li class="pagination"><a href="<?= url_for('@contests_past_contests') ?>" class="">view past contests</a></li>
  </ul>
</div><!-- /.past-contests -->
<? endif; ?>