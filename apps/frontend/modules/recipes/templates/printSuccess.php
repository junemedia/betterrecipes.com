<img alt="BetterRecipes : better recipes - better meals" src="/img/logo-betterrecipes.png">
<div id="recipe-detail" itemscope itemtype="http://data-vocabulary.org/Recipe">
  <div class="header">
    <p><a href="javascript:;" title="Return to site" id="btn_back">« Back</a> | <a href="javascript:;" id="btn_print">Print <img src="http://images.meredith.com/bhg/images/tmp/mi/print.gif" alt="" /></a> | <a href="javascript:;" id="print_8x11">Page</a> | <a href="javascript:;" id="print_3x5">3x5</a> | <a href="javascript:;" id="print_4x6">4x6</a></p>
    <p class="italic">Select a size and use your browser's print button to print the page. </p>
  </div>
  <div class="images">
    <div class="main-image">
      <img itemprop="photo" src="<?= $recipe->getMainImageSrc() ?>" alt="<?= $recipe->getName() ?>" />
    </div>
  </div><!-- /.images -->
  <? if ($recipe->getSponsorId()): ?>
    <? $sponsor = $recipe->getSponsor() ?>
    <div id="sponsor_<?= $sponsor->getId() ?>"class="sponsor adsponsor">
      <? include_partial('global/adtags/sponsor', compact('sponsor')) ?>
    </div>
  <? endif; ?>
  <div class="recipe-meta pb20">
    <span class="microformat" itemprop="published" datetime="<?= date('Y-m-d', strtotime($recipe->getCreatedAt())) ?>"><?= date('Y-m-d', strtotime($recipe->getCreatedAt())) ?></span>
    <span class="microformat" itemprop="recipeType"><?= ucwords($recipe->getCourse()) ?></span>
    <h3 class="title green" itemprop="name"><?= Microformat::correct_caps($recipe->getName()) ?></h3>
    <p class="summary mb10"><span itemprop="summary"><?= $recipe->getIntroduction() ?></span></p>
    <ul class="author-meta first">
      <? $recipe_user = $recipe->getUser() ?>
      <? $recipe_user_active = $recipe_user->getSubdir() && $recipe_user->getSubdir() != '' && $recipe_user->getIsActive() == 1 ?>
      <? if ($recipe_user_active): ?>
        <li>Submitted by: <a href="<?= getUrl($recipe_user) ?>" title="Recipe Author" itemprop="author"><?= $recipe_user->getDisplayName() ?></a></li>
        <li>See all recipes from: <a href="<?= getUrl($recipe_user) ?>" title="Recipe Author"><?= $recipe_user->getDisplayName() ?></a></li>
      <? else: ?>
        <li>Submitted by: <?= $recipe_user->getDisplayName() ?></li>
        <li>See all recipes from: <?= $recipe_user->getDisplayName() ?></li>
      <? endif; ?>
    </ul>
    <ul class="author-meta">
      <? if (isset($img_user)): ?>
        <? $img_user_active = $img_user->getSubdir() && $img_user->getSubdir() != '' && $img_user->getIsActive() == 1 ?>
        <? if ($img_user_active): ?>
          <li>Photo by: <a href="<?= getUrl($img_user) ?>" title="Recipe Author" itemprop="author"><?= $img_user->getDisplayName() ?></a></li>
        <? else: ?>
          <li>Photo by: <?= $img_user->getDisplayName() ?></li>
        <? endif; ?>      
      <? endif; ?>
      <? if ($origin = $recipe->getOrigin()): ?>
        <li>Recipe Source: <span title="Recipe Source"><?= $origin ?></span></li>
      <? endif; ?>
    </ul>             
  </div><!-- /.recipe-meta -->
  <ul class="hornav meal-info">
    <? list($preptime, $cooktime, $totaltime) = Microformat::times($recipe); ?>
    <? if ($recipe->getServings() && $recipe->getServings() != ''): ?>
      <li>Servings: <span itemprop="yield"><?= $recipe->getServings() ?></span></li>
    <? endif; ?>
    <? if ($recipe->getPreptime() && $recipe->getPreptime() != ''): ?>
      <li>Prep Time: <?= $recipe->getPreptime() ?></li>
    <? endif; ?>
    <? if ($preptime): ?>
      <time class="microformat" itemprop="prepTime" datetime="<?= $preptime ?>"><?= Microformat::duration_to_pretty($preptime) ?></time>
    <? endif; ?>
    <? if ($recipe->getCooktime() && $recipe->getCooktime() != ''): ?>
      <li>Cook Time: <?= $recipe->getCooktime() ?></li>
    <? endif; ?>
    <? if ($cooktime): ?>
      <time class="microformat" itemprop="cookTime" datetime="<?= $cooktime ?>"><?= Microformat::duration_to_pretty($cooktime) ?></time>
    <? endif; ?>
    <? if ($recipe->getTotaltime() && $recipe->getTotaltime() != ''): ?>
      <li class="last">Total Time: <?= $recipe->getTotaltime() ?></li>
    <? endif; ?>
    <? if ($totaltime): ?>
      <time class="microformat" itemprop="totalTime" datetime="<?= $totaltime ?>"><?= Microformat::duration_to_pretty($totaltime) ?></time>
    <? endif; ?>
  </ul>
  <p class="title">Ingredients:</p>
  <p class="lh25"><?= Microformat::tableIngredients($recipe->getIngredients()) ?></p>
  <p class="title mt35">Directions:</p>
  <div class="instructions" itemprop="instructions"><?= Microformat::parseInstructions($recipe->getInstructions()) ?></div>
  <? if ($notes = @$recipe->getNotes()): ?>
    <p class="title mt20">Helpful Tips:</p>
    <p><?= $recipe->getNotes() ?></p>
  <? endif; ?>
  <? if ($recipe_user_active): ?>
    <? include_partial('author', array('author' => $recipe->getUser())) ?>
  <? endif; ?>
  <div id="modal_div"><iframe id="modal_iframe" width="100%" height="100%" marginWidth="0" marginHeight="0" frameBorder="0" scrolling="auto"></iframe></div>
</div><!-- /#recipe-detail -->
<? slot('facebook_meta') ?>
<meta property="og:title" content="<?= Microformat::correct_caps($recipe->getName()) ?>" />
<meta property="og:description" content="<?= htmlentities($recipe->getIntroduction(), ENT_QUOTES) ?>" />
<meta property="og:url" content="<?= UrlToolkit::getUrl($recipe) ?>"/>
<meta property="og:type" content="<?= sfConfig::get('app_facebook_appnamespace') ?>:recipe" />
<?
// Bring in all of the photos for this recipe
/**
 * This is just the main image
 * <meta property="og:image" content="<?= isset($main_img) ? 'http://'.$_SERVER['HTTP_HOST'].$main_img->getImgSrc() : 'http://'.$_SERVER['HTTP_HOST'].'/img/recipe-img-placeholder.jpg' ?>" />
 */
$photos = PhotoTable::getRecipePhotos($recipe->getId());
?>
<? foreach ($photos as $photo): ?>
  <meta property="og:image" content="<?= 'http://' . $_SERVER['HTTP_HOST'] . $photo->getImgSrc() ?>" />
<? endforeach; ?>
<? end_slot() ?>
<script type="text/javascript">
  $('#print_3x5').click(function(){
    $('body').css({"width":"288px"});
  });
  $('#print_4x6').click(function(){
    $('body').css({"width":"384px"});
  });
  $('#print_8x11').click(function(){
    $('body').css({"width":"485px"});
  });
  $('#btn_print').click(function(){
    window.print();
  });
  $("#btn_back").click(function(){
    window.close();
  });
  $(document).ready(function() {
    updateVoteStatus();
  });  
  function updateVoteStatus() {
    $.getJSON("<?= url_for('@update_vote_status' . '?recipe_id=' . $recipe->getId()) ?>", function(data) {
      if(data["is_voted"]){
        s.pageName=s.eVar9= s.pageName + ':voted';
      }
      s.t();
    });
  }
</script>
<p class="copyright">www.betterrecipes.com &copy; Copyright 2011, Meredith Corporation. All Rights Reserved.</p>