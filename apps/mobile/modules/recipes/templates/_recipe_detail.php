<script>
  $(document).ready(function() {
    $("#modal_div").dialog({modal: true, autoOpen: false, draggable: false, resizeable: false});
    $('#main-footer .wrapper').css({"padding-bottom":"100px"});
    updateVoteStatus();
  });
    function submitVote(){
      $.get("<?= url_for('@recipe_contest_vote') ?>", {recipeId:<?= $recipe->getId() ?>}, function(){
        updateVoteStatus();    
        $("#vote_message").slideDown();
        setTimeout('$("#vote_message").slideUp()',3000);
      });
    }
    function updateVoteStatus() {
      $.getJSON("<?= url_for('@update_vote_status' . '?recipe_id=' . $recipe->getId()) ?>", function(data) {
        if(data["is_voted"]){
          $("#vote_submit_btn").unbind("click").addClass("inactive");
          recipeVoteOmniture();
        } else {
          $("#vote_submit_btn").bind("click", function() {
            submitVote();
          }).removeClass("inactive");
        }
        fireOmniture();
      });
    }
    function closeMe() {
      $("#modal_div").dialog("close");
      window.location.href = window.location.href;
    }
    function cancelModal() {
      $("#modal_div").dialog("close");
    }
    function addPhoto() {
      $("#modal_div").dialog("open");
      $("#modal_div").dialog("option", {"title": "Add a photo to \"<?= addslashes( $recipe->getName() ) ?>\"", "width": 600, "height": 600});
      $("#modal_iframe").attr("src","<?= url_for('@add_recipe_photo' . '?recipe_id=' . $recipe->getId()) ?>");
      return false;
    }  
    function rate(rating) {
      $("#rating_container").load("<?= url_for('recipes/rate') ?>", {id:<?= $recipe->getId() ?>, rating:rating});
    }  
    function addToSaved() {
      $(".save_button").load("<?= url_for('recipes/addtosaved') ?>", {id:<?= $recipe->getId() ?>});
    }    
</script>
<? if (!empty($currentContest)): ?>
  <div class="vote">
    <p>RANK: # <?= $currentContest->getRank() ?> in: <?= $currentContest->getContest()->getName() ?>!</p>
    <input type="button" class="gray-btn" id="vote_submit_btn" value="VOTE" />
    <ul>
      <? if ($recipePrev): ?><li><a href="<?= UrlToolkit::getUrl($recipePrev) ?>" title="Previous Recipe" class="cta-prev">Previous Recipe</a></li><? endif; ?>
      <? if ($recipeNext): ?><li><a href="<?= UrlToolkit::getUrl($recipeNext) ?>" title="Next Recipe" class="cta-next">Next Recipe</a></li><? endif; ?>
    </ul> 
  </div><!-- /.vote -->
  <div id="vote_message" class="hidden">Thank you for voting</div> 
<? endif; ?>
<div class="header" itemscope itemtype="http://data-vocabulary.org/Recipe">
  <p class="green fs15 title" itemprop="name"><?= Microformat::correct_caps($recipe->getName()) ?></p>
  <div class="left">
    <? if ($recipe->hasPhoto()): ?>
      <script>
        function displayPhotos() {
          $("#modal_div").dialog("open");
          $("#modal_div").dialog("option", {"title": "<?= addslashes( $recipe->getName() ) ?> Photos", "width": 600, "height": 450});
          $("#modal_iframe").attr("src","/recipes/photos/recipe_id/<?= $recipe->getId() ?>");
          return false;
        }
      </script>      
      <?
      $main_img = $recipe->getMainImage();
      $img_user = $main_img->getUser()
      ?>
      <img itemprop="photo" src="<?= $main_img->getImgSrc() ?>" alt="<?= $recipe->getName() ?>" />
    <? else: ?>
      <img src="/img/recipe-img-placeholder.jpg" alt="No Image" />
    <? endif; ?>
    <ul>
      <? if (isset($main_img)): ?><li><a onclick="displayPhotos()" style="cursor:pointer;" title="View all photos from this recipe">>> All Photos</a></li><? endif; ?>
      <? include_partial("recipe_sharebar"); ?>
      <? if ($sf_user->isAuthenticated() && ($recipe->getUserId() != $sf_user->getAttribute('id'))): ?>
        <li class="ml10">
          <span class="save_button">
            <? include_partial('save_recipe', compact('is_saved')) ?>
          </span>
        </li>
      <? endif; ?>
    </ul>
  </div>
  <div class="right">
  	<?php // as per ET # 6380, removed the read more nonesense ?>
  	<?php /*
    <p class="limitcopy-100"><span itemprop="summary"><?= $recipe->getIntroduction() ?></span><a href="javascript:;" title="Read More" id="toggle-copy">... >> Read more</a></p>
    */ 
    ?>
    <p><span itemprop="summary"><?= $recipe->getIntroduction() ?></span></p>
    <ul>
      <? $recipe_user = $recipe->getUser() ?>
      <li>Submitted by: <a href="<?= getUrl($recipe_user) ?>" itemprop="author" title="<?= $recipe_user->getDisplayName() ?>"><?= $recipe_user->getDisplayName() ?></a></li>
      <li>See all recipes from: <a href="<?= getUrl($recipe_user) ?>" title="<?= $recipe_user->getDisplayName() ?>"><?= $recipe_user->getDisplayName() ?></a></li>
      <? if (isset($img_user)): ?>
        <li>Photo by: <a href="<?= getUrl($img_user) ?>" title="<?= $img_user->getDisplayName() ?>"><?= $img_user->getDisplayName() ?></a></li>
      <? endif; ?>
      <? if ($origin = $recipe->getOrigin()): ?>
        <li>Recipe Source: <?= $origin ?></li>
      <? endif; ?>
    </ul>
    <? /* if ($recipe->getRating() > 0): ?>
      <p class="pl0" itemprop="rating">Rating:<span class="rating"><span class="rate<?= round($recipe->getRating(), 1) ?>"></span></span></p>
      <? endif; */ ?>
    <div id="rating_container">
      <? if ($recipe->getRating() > 0): ?>
        <span class="microformat" itemprop="review" itemscope temtype="http://data-vocabulary.org/Review-aggregate">
          <span itemprop="rating"><?= round($recipe->getRating(), 1) ?></span>
          <span itemprop="count"><?= $recipe->getRatingCount() ?></span>
        </span>
      <? endif; ?>
      <? include_partial('rating', array('rating' => $recipe->getRating(), 'user_rating' => @$user_rating)) ?>
    </div>      


    <? /* note: I have no idea what this is cause I don't see it in the main BR site */ ?>
    <? /* <p class="rave">Made it &amp; Loved it!</p> */ ?>
    <? if ($recipe->getSponsorId()): ?>
      <? $sponsor = $recipe->getSponsor() ?>
      <div id="sponsor_<?= $sponsor->getId() ?>"class="sponsor adsponsor">
        <? include_partial('global/adtags/sponsor', compact('sponsor')) ?>
      </div>
    <? endif; ?>
  </div>
</div><!-- /.header -->
<? list($preptime, $cooktime, $totaltime) = Microformat::times($recipe); ?>
<ul class="overview">
  <? if ($recipe->getServings() && $recipe->getServings() != ''): ?><li>Servings: <span itemprop="yield"><?= $recipe->getServings() ?></span></li><? endif; ?>
  <? if ($recipe->getCooktime() && $recipe->getCooktime() != ''): ?><li>Cook TIME: <span><?= $recipe->getCooktime() ?></span></li><? endif; ?>
  <? if ($recipe->getPreptime() && $recipe->getPreptime() != ''): ?><li>Prep TIME: <span><?= $recipe->getPreptime() ?></span></li><? endif; ?>
  <? if ($recipe->getTotaltime() && $recipe->getTotaltime() != ''): ?><li>TOTAL TIME: <span><?= $recipe->getTotaltime() ?></span></li><? endif; ?>
</ul>
<!--
<ul class="ingredients">
  <li><span>Ingredients:</span></li>
    <li>2 4-ounce pasta</li>
    <li>10 ounces fresh asparagus spears, trimmed</li>
    <li>6 ounces tiny new potatoes, cut into 1-inch pieces</li>
    <li>2 tablespoons white or regular balsamic vinegar</li>
    <li>1 teaspoon cooking oil</li>
    <li>1 teaspoon snipped fresh dill or 1/2 teaspoon dried dill</li>
    <li>1/4 teaspoon salt</li>
    <li>1/8 teaspoon ground black pepper</li>
    <li>Fresh dill (optional)</li>
</ul>
-->
<ul class="ingredients">
  <li><span>Ingredients:</span></li>
</ul>
<?= Microformat::tableIngredients($recipe->getIngredients()) ?>
<p class="directions"><span itemprop="instructions">Directions:</span></p>
<div class="all-copy"><?= Microformat::parseInstructions($recipe->getInstructions()) ?></div>
<? if ($notes = @$recipe->getNotes()): ?>
  <p class="tips"><span>Helpful Tips:</span><br />
    <?= $recipe->getNotes() ?>    	
  </p>
<? endif; ?>
<div id="modal_div"><iframe id="modal_iframe" width="100%" height="100%" marginWidth="0" marginHeight="0" frameBorder="0" scrolling="auto"></iframe></div>
</div><!-- /.detail -->
<? slot('facebook_meta') ?>
<meta property="og:title" content="<?= Microformat::correct_caps($recipe->getName()) ?>" />
<meta property="og:description" content="<?= $recipe->getIntroduction() ?>" />
<meta property="og:url" content="<?= UrlToolkit::getUrl($recipe) ?>"/>
<meta property="og:type" content="article" />
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