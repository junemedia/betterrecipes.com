<? slot('gpt') ?>

unitValues: {
                	channel: 'Homepage', /* Set to the top level category id, if applicable */
                
                	parent: '', /* Set to the secondary level category id, if applicable */
                
                	child: '' /* Set to the tertiary level category id, if applicable */
                
            },
            pageTargetingValues: { /* Additional key-values can be added to this section if needed */
            		id: '<?php echo md5($sf_request->getUri())?>', /* Set to a page-specific unique id*/
                	type: '', /* Set the content type ( 'category', 'recipe', 'slideshow', etc.) */
                	search: '' /* On search results, set to the search term */
                
            }


<? end_slot() ?>

<div class="article homepage">
  <? include_partial('featured_contents', compact('hpWonder')) ?>
  <? if ($sf_user->isAuthenticated() && $sf_user->getFbId() && $sf_user->getRegSourceAttribute('auth_token')): ?>
    <div id="friends-activity">
      <? include_component('opengraph', 'recipesByFriends', array('friends' => $friends, 'limit' => 15)) ?>
    </div><!-- /#todays-poll -->
    <div class="clear-both"></div>
  <? endif; ?>
  <div id="trending-recipes">
    <? include_component('opengraph', 'trendingRecipes', array('limit' => 15)) ?>
  </div><!-- /#trending-recipes -->
  <div class="clear-both"></div>
  <?
  /*
  <div id="todays-poll">
    <? include_partial('vote', compact('poll')) ?>
  </div><!-- /#todays-poll -->
  <div class="clear-both"></div>
  */
  ?>
  
  <div id="featuredBlogger">
  	<? //include_partial('featured_blogger', compact('featured_blogger')) ?>
  </div><!-- // #featuredBlogger -->
  <div class="clear-both"></div>
  
  <? include_partial('featured_contests') ?>
  <div class="clear-both"></div>
  <? include_partial('editorials', compact('categoryWonder')) ?>
  
  <?
  /* MBR-57 -> Remove
  <p class="title">Trending Food</p>
  <div id="trendingFood">
    <script type='text/javascript'>
    var _CI = _CI || {};
    (function() {
    var script = document.createElement('script');
    ref = document.getElementsByTagName('script')[0];
    _CI.counter = (_CI.counter) ? _CI.counter + 1 : 1;
    document.write('<div id="_CI_widget_');
    document.write(_CI.counter+'"></div>');
    script.type = 'text/javascript';
    script.src = 'http://widget.crowdignite.com/widgets/26045?_ci_wid=_CI_widget_'+_CI.counter;
    script.async = true;
    ref.parentNode.insertBefore(script, ref);
    })(); </script>
  </div>
  */
  ?>
  
  <? include_partial('opengraph/facebook_login_modal') ?>
</div><!-- /.article -->
<? include_partial('global/right_rail/right_rail') ?>
<div class="clear-both"></div>