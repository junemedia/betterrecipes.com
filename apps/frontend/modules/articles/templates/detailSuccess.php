<? slot('gpt') ?>

unitValues: {
                	channel: 'Recipe', /* Set to the top level category id, if applicable */
                
                	parent: '', /* Set to the secondary level category id, if applicable */
                
                	child: '' /* Set to the tertiary level category id, if applicable */
                
            },
            pageTargetingValues: { /* Additional key-values can be added to this section if needed */
            		id: '<?php echo md5($sf_request->getUri())?>', /* Set to a page-specific unique id*/
                	type: 'story', /* Set the content type ( 'category', 'recipe', 'slideshow', etc.) */
                	search: '' /* On search results, set to the search term */
                
            }


<? end_slot() ?>

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