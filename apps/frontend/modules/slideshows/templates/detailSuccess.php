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
    
   
<!-- begin media.net 4 -->
<script id="mNCC" language="javascript">  medianet_width='656';  medianet_height= '175';  medianet_crid='132274854';  </script>  <script id="mNSC" src="http://contextual.media.net/nmedianet.js?cid=8CU52X6SM" language="javascript"></script> 
<!-- end media.net -->

<div class="OUTBRAIN" data-src="<?= getUrl($slideshow) ?>" data-widget-id="AR_4" data-ob-template="BetterRecipes"></div>
<script type="text/javascript" async="async" src="http://widgets.outbrain.com/outbrain.js"></script>


    
    
    <? include_partial('recipes_slideshows', compact('recipes', 'slideshows', 'category')) ?>
  </div><!-- /#slideshow -->  
  
  
</div><!-- /.section -->
<? include_partial('right_rail', compact('rr_recipes')) ?>