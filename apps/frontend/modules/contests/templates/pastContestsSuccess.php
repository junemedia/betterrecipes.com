<? slot('gpt') ?>

unitValues: {
                	channel: 'contest', /* Set to the top level category id, if applicable */
                
                	parent: 'past contests', /* Set to the secondary level category id, if applicable */
                
                	child: '' /* Set to the tertiary level category id, if applicable */
                
            },
            pageTargetingValues: { /* Additional key-values can be added to this section if needed */
            		id: '<?php echo md5($sf_request->getUri())?>', /* Set to a page-specific unique id*/
                	type: 'contest', /* Set the content type ( 'category', 'recipe', 'slideshow', etc.) */
                	search: '' /* On search results, set to the search term */
                
            }


<? end_slot() ?>

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
        <? if($c->getSlideshowUrl() != ''): ?>
        	<a href="<?=$c->getSlideshowUrl()?>" title="<?= $c->getName() ?>" class="imgmask100 mb10">
            <img src="<?= $c->getImgSrc() ?>" height="100" width="100" alt="<?= $c->getName() ?>" />
          </a>
          <p><a href="<?=$c->getSlideshowUrl()?>" title="<?= $c->getName() ?>"><?= $c->getName() ?></a></p>

        <? else: ?>
          <a href="<?= getRoute('contests_detail', array('slug' => $c->getSlug())) ?>" title="<?= $c->getName() ?>" class="imgmask100 mb10">
            <img src="<?= $c->getImgSrc() ?>" height="100" width="100" alt="<?= $c->getName() ?>" />
          </a>
          <p><a href="<?= getRoute('contests_detail', array('slug' => $c->getSlug())) ?>" title="<?= $c->getName() ?>"><?= $c->getName() ?></a></p>
         <? endif; ?>
        </li>
        <? if($i % 6 == 5 ){ echo '</ul></li>';} ?>
      <? endforeach; ?>
    </ul>
  </div>
</div><!-- /.article -->

<? include_partial('global/right_rail/right_rail') ?>