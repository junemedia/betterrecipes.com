<? session_cache_limiter('nocache'); ?>
<? include_partial('global/bread_crumbs', compact('bread_crumbs')) ?>
<? if (isset($omniParams)): ?>
  <script>
    $(document).ready(function(){
      s.pageName = s.eVar9 = '<?= $omniParams['pageName'] ?>';
      s.server = 'www.betterrecipes.com';
      s.channel = 'Recipe';
      s.prop1 = '<?= $omniParams['prop1'] ?>';
      s.prop2 = '<?= $omniParams['prop2'] ?>';
      s.prop7 = s.eVar24 = <?= $omniParams['prop7'] ?>;
      s.prop11 = '<?= $omniParams['prop11'] ?>';
      s.prop18 = 'betterrecipes';
      s.prop19 = 'Food';
      s.prop20 = '<?= $omniParams['prop20'] ?>';
      s.eVar14 = 'Recipe';
      s.t();
    });
  </script>
<? endif ?>
<div class="article has-breadcrumbs">
  <? // include_partial('contest') ?>
  <? include_partial('recipe_detail', compact('recipe', 'is_saved', 'is_made', 'user_rating', 'currentContest', 'recipeNext', 'recipePrev', 'showVoteButton', 'showPopup', 'msg')) ?>
  <a name="write_review"></a>
  <div id="recipe-comments" class="clear mt20">
    <fb:comments href="<?= $sf_request->getUri() ?>" num_posts="5" width="660"></fb:comments>
  </div><!-- /#recipe-comments -->
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
</div><!-- /.section -->
<? include_partial('global/right_rail/right_rail') ?>
<? include_partial('opengraph/facebook_login_modal') ?>