<? slot('gpt') ?>

unitValues: {
                	channel: 'contest', /* Set to the top level category id, if applicable */
                
                	parent: 'past winners', /* Set to the secondary level category id, if applicable */
                
                	child: '' /* Set to the tertiary level category id, if applicable */
                
            },
            pageTargetingValues: { /* Additional key-values can be added to this section if needed */
            		id: '<?php echo md5($sf_request->getUri())?>', /* Set to a page-specific unique id*/
                	type: 'contest', /* Set the content type ( 'category', 'recipe', 'slideshow', etc.) */
                	search: '' /* On search results, set to the search term */
                
            }


<? end_slot() ?>

display<? include_partial('global/bread_crumbs', compact('bread_crumbs')) ?>

<div class="article contests">
  <div id="contest-detail">
    <? include_partial('global/sharebar') ?>
    <p class="title green">Past Winners</p>
    <div class="sorting mt20">
      <? if ($pastWinners->haveToPaginate()): ?>
        <ul class="pager hornav">
          <li class="unavailable"><a href="<?= getRoute('contests_past_winners', array('page' => $pastWinners->getPreviousPage())) ?>" title="Previous">&laquo;</a></li>
          <? foreach ($pastWinners->getLinks() as $page): ?>
            <li class="<?= ($page == $pastWinners->getPage()) ? 'active' : '' ?>"><a href="<?= ($page == $pastWinners->getPage()) ? '' : getRoute('contests_past_winners', array('page' => $page)) ?>" title="Page <?= $page ?>"><?= $page ?></a></li>
          <? endforeach; ?>
          <li><a href="<?= getRoute('contests_past_winners', array('page' => $pastWinners->getNextPage())) ?>" title="Next">&raquo;</a></li>
        </ul>
      <? endif; ?>
    </div>
    <ul class="hornav">
      <? foreach ($pastWinners->getResults() as $i => $winner): $recipe = $winner->getRecipe();
        if ($i % 6 == 0) {
          echo '<li class="row wauto"><ul class="hornav">';
        }
        ?>
        <li class="mb20 w100 <?= ((fmod(($i + 1), 6)) == 0) ? 'last' : 'mr10' ?>">
          <a href="<?= getUrl($recipe) ?>" title="<?= $recipe->getName() ?>" class="imgmask100 mb10">
            <img src="<?= $recipe->getMainImageSrc() ?>" height="100" width="100" alt="<?= $recipe->getName() ?>" />
          </a>
          <p><a href="<?= getUrl($recipe) ?>" title="<?= $recipe->getName() ?>"><?= $recipe->getName() ?></a></p>
          <p class="fs11"><a href="<?= getRoute('cook_profile', array('display_name' => $winner->getUser()->getDisplayName())) ?>" title="Recipe Author"><?= $winner->getUser()->getDisplayName() ?></a></p>
        </li>
  <? if ($i % 6 == 5) {
    echo '</ul></li>';
  } ?>
<? endforeach; ?>

    </ul>
  </div>
</div><!-- /.article -->

<? include_partial('global/right_rail/right_rail') ?>