<? include_partial('global/bread_crumbs', compact('bread_crumbs')) ?>

<div class="article contests">
  <div id="contest-detail">
    <? include_partial('global/sharebar') ?>
    <p class="title green">Past Contests</p>
    <div class="sorting mt20">
      <? if ($past_contests->haveToPaginate()): ?>
        <ul class="pager hornav">
          <li class="unavailable"><a href="<?= getRoute('contests_past_contests', array('page' => $past_contests->getPreviousPage())) ?>" title="Previous">&laquo;</a></li>
          <? foreach ($past_contests->getLinks() as $page): ?>
            <li class="<?= ($page == $past_contests->getPage()) ? 'active' : '' ?>"><a href="<?= ($page == $past_contests->getPage()) ? '' : getRoute('contests_past_contests', array('page' => $page)) ?>" title="Page <?= $page ?>"><?= $page ?></a></li>
          <? endforeach; ?>
          <li><a href="<?= getRoute('contests_past_contests', array('page' => $past_contests->getNextPage())) ?>" title="Next">&raquo;</a></li>
        </ul>
      <? endif; ?>
    </div>
    <ul class="hornav">
      <? foreach ($past_contests->getResults() as $i => $c):
				if($i % 6 == 0 ){ echo '<li class="row wauto"><ul class="hornav">';} ?>
        <li class="mb20 w100 <?= ((fmod(($i + 1), 6)) == 0) ? 'mr0' : 'mr10' ?>">
          <a href="<?= getRoute('contests_detail', array('slug' => $c->getSlug())) ?>" title="<?= $c->getName() ?>" class="imgmask100 mb10">
            <img src="<?= $c->getImgSrc() ?>" height="100" width="100" alt="<?= $c->getName() ?>" />
          </a>
          <p><a href="<?= getRoute('contests_detail', array('slug' => $c->getSlug())) ?>" title="<?= $c->getName() ?>"><?= $c->getName() ?></a></p>
        </li>
        <? if($i % 6 == 5 ){ echo '</ul></li>';} ?>
      <? endforeach; ?>
    </ul>
  </div>
</div><!-- /.article -->

<? include_partial('global/right_rail/right_rail') ?>