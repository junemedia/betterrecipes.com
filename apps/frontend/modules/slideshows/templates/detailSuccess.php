<? slot('gpt') ?>

unitValues: {
                	channel: 'recipe', /* Set to the top level category id, if applicable */
                
                	parent: '', /* Set to the secondary level category id, if applicable */
                
                	child: '' /* Set to the tertiary level category id, if applicable */
                
            },
            pageTargetingValues: { /* Additional key-values can be added to this section if needed */
            		id: '<?php echo md5($sf_request->getUri())?>', /* Set to a page-specific unique id*/
                	type: 'slideshow', /* Set the content type ( 'category', 'recipe', 'slideshow', etc.) */
                	search: '' /* On search results, set to the search term */
                
            }


<? end_slot() ?>

<? include_partial('global/bread_crumbs', compact('bread_crumbs')) ?>
<div class="article">
  <div id="slideshow-wrap">
    <? if ($slideshow->getSponsorId()): ?>
      <? $sponsor = $slideshow->getSponsor() ?>
      <div id="sponsor_<?= $sponsor->getId() ?>"class="sponsor adsponsor">
        <? include_partial('global/adtags/sponsor', compact('sponsor')) ?>
      </div>
    <? endif; ?>
    <? if ($sf_user->isAuthenticated()): ?>
      <? include_partial('thumbnails', compact('slides', 'showall')) ?>
    <? endif; ?>
    <? include_partial('slideshow', compact('slideshow', 'slides', 'showall')) ?>
    <? include_partial('groups', compact('groups')) ?>
    <? include_partial('recipes_slideshows', compact('recipes', 'slideshows', 'category')) ?>
  </div><!-- /#slideshow -->                    
</div><!-- /.section -->
<? include_partial('right_rail', compact('rr_recipes')) ?>