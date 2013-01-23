<? include_partial('global/bread_crumbs', compact('bread_crumbs')) ?>
<div class="article contests">
  <div id="contest-detail">
    <? include_partial('global/sharebar') ?>
    <p class="title green">Recipe Contests</p>
    <p class="w500">Think you have a prize-winning dish? Enter your original recipe in one of our recipe contests or vote for someone else's. We have weekly and monthly recipe contests for cooks of all skill levels. Enter now for a chance to win!</p>
  </div>
  <!--
      <div class="mb20">
        <a href="http://win.betterrecipes.com/?psrc=DS1107BRSP4739R0827"><img src="/img/rec_600x400_4439_11summerDailySweep_2.jpg"/></a>
      </div>
  -->
  <? if (count($activeContests) > 0): ?>
    <div id="featured-contests" class="mb20">
      <ul class="border-bottom">
        <? foreach ($activeContests as $i => $contest): ?>
          <li class="ovhid <?= (($i + 1) == count($activeContests)) ? 'last no-border' : '' ?>" <?= (($i + 1) == count($activeContests)) ? 'id="no-border"' : '' ?>>
            <? if ($contest->getImgSrc()): ?>
              <a href="<?= getRoute('contests_detail', array('slug' => $contest->getSlug())) ?>" title="<?= $contest->getName() ?>" class="imgmask100">
                <img src="<?= $contest->getImgSrc() ?>" alt="<?= $contest->getName() ?>" />
              </a>
            <? endif; ?>
            <div id="sponsor_<?= $contest->getSponsor()->getId() ?>"class="sponsor adsponsor">
              <? include_partial('global/adtags/sponsor', array('sponsor' => $contest->getSponsor())) ?>
            </div>
            <p class="title"><?= $contest->getName() ?></p>
            <p class="ml120 mb10"><?= $contest->getDescription() ?></p>
            <p class="ml120">
              <? if ($contest->getIsOpenToPublic()): ?>
                <a href="<?= getRoute('contests_detail', array('slug' => $contest->getSlug())) ?>" title="ENTER NOW!" class="btn-grey28 mr20">ENTER NOW!</a>
              <? endif; ?>
              <a href="<?= getRoute('contests_detail', array('slug' => $contest->getSlug())) ?><?//= (!is_null($contest->getLeadingContestant())) ? getUrl($contest->getLeadingContestant()->getRecipe()) : getUrl('@contests_detail?slug=' . $contest->getSlug()) ?>" title="View Entries" class="btn-grey28">View Entries</a>
            </p>
          </li>
        <? endforeach; ?>
      </ul>
    </div>
  <? endif; ?>
  <div id="contest-entries" class="contest-winners">
    <p class="title green">Winners Gallery</p>
    <? /*
      <div class="sorting mt20">
      <?  if ($contestWinners->haveToPaginate()): ?>
      <ul class="pager hornav">
      <li class="unavailable"><a href="<?= getRoute('contests', array('page' => $contestWinners->getPreviousPage())) ?>" title="Previous">&laquo;</a></li>
      <? foreach ($contestWinners->getLinks() as $page): ?>
      <li class="<?= ($page == $contestWinners->getPage()) ? 'active' : '' ?>"><a href="<?= ($page == $contestWinners->getPage()) ? '' : getRoute('contests', array('page' => $page)) ?>" title="Page <?= $page ?>"><?= $page ?></a></li>
      <? endforeach; ?>
      <li><a href="<?= getRoute('contests', array('page' => $contestWinners->getNextPage())) ?>" title="Next">&raquo;</a></li>
      </ul>
      <? endif; ?>
      </div>
     */ ?>
    <ul>
      <?
      foreach ($contestWinners->getResults() as $i => $winner): $recipe = $winner->getRecipe();
        if ($i % 6 == 0) {
          echo '<li class="row wauto"><ul class="hornav ovhid">';
        }
        ?>
        <li class="mb20 <?= ((fmod(($i + 1), 6)) == 0) ? 'mr0' : 'mr10' ?>">
          <a href="<?= getUrl($recipe) ?>" title="<?= $recipe->getName() ?>" class="imgmask100 mb10">
            <img src="<?= $recipe->getMainImageSrc() ?>" height="100" width="100" alt="<?= $recipe->getName() ?>" />
          </a>
          <p><a href="<?= getUrl($recipe) ?>" title="<?= $recipe->getName() ?>"><?= $recipe->getName() ?></a></p>
          <p class="fs11"><a href="<?= getRoute('User', array('display_name' => $winner->getUser()->getDisplayName())) ?>" title="Recipe Author"><?= $winner->getUser()->getDisplayName() ?></a></p>
        </li>
        <?
        if ($i % 6 == 5) {
          echo '</ul></li>';
        }
        ?>
      <? endforeach; ?>
    </ul>
    <? /*
      <div class="sorting mt10">
      </div>
     */ ?>
    <a href="<?= url_for('@contests_past_winners') ?>" class="flri clear">view more winners</a>
  </div>
  <!-- Past Contests -->
  <? if (count($previous_contests) > 0): ?>
    <div id="featured-contests" class="mb20 clear">
      <p class="title green mb20">Past Contests</p>
      <ul>
        <? foreach ($previous_contests as $i => $contest): ?>
          <li class="ovhid <?= (($i + 1) == count($previous_contests)) ? 'last no-border' : '' ?>" <?= (($i + 1) == count($previous_contests)) ? 'id="no-border"' : '' ?>>
            <? if ($contest->getImgSrc()): ?>
              <a href="<?= getRoute('contests_detail', array('slug' => $contest->getSlug())) ?>" title="<?= $contest->getName() ?>" class="imgmask100">
                <img src="<?= $contest->getImgSrc() ?>" alt="<?= $contest->getName() ?>" />
              </a>
            <? endif; ?>
            <div id="sponsor_<?= $contest->getSponsor()->getId() ?>"class="sponsor adsponsor">
              <? include_partial('global/adtags/sponsor', array('sponsor' => $contest->getSponsor())) ?>
            </div>
            <p class="title"><?= $contest->getName() ?></p>
            <p class="ml120 mb10"><?= $contest->getDescription() ?></p>
            <p class="ml120"><a href="<?= getRoute('contests_detail', array('slug' => $contest->getSlug())) ?>" title="View Entries" class="btn-grey28">View Entries</a></p>
          </li>
        <? endforeach; ?>
      </ul>
      <a href="<?= url_for('@contests_past_contests') ?>" class="flri">view past contests</a>
    </div>
  <? endif; ?>
  <!-- End Past Contests -->
</div><!-- /.article -->
<? include_partial('global/right_rail/right_rail') ?>
<? include_partial('opengraph/facebook_login_modal') ?>