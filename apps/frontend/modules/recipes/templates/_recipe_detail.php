<script>
  $(document).ready(function() {
    $("#modal_div").dialog({modal: true, autoOpen: false, draggable: false, resizeable: false});
    $("#submitVote").submit(function(event){
      event.preventDefault();
      submitVote();
    });
    //Close Captcha Popup Box
    $("#closePopup").click(function(){
      $(".popup").addClass('hide');
    });
    $('#main-footer .wrapper').css({"padding-bottom":"100px"});
    $.get("<?= url_for('@view_recipe?id=' . $recipe->getId()) ?>");
    updateVoteStatus();
    toggleRate();
  });
  
  function toggleRate(){
    $("#rating_boxes").mouseover(function(){
      $("#rating_main").hide();
      $("#rating_top").show();
    });    
    $("#rating_boxes").mouseout(function(){
      $("#rating_top").hide();
      $("#rating_main").show();
    });
  }
  function submitVote(){
    $.post("<?= url_for('@recipe_contest_vote') ?>", $("#submitVote").serialize(), function(data){
      if(data.success){
        $("#vote_msg").hide();
        $("#captcha_container").hide();
        $("#vote_sharebar_container").show();
        updateVoteStatus(); 
        // call function to submit the vote as user action
        addVotedRecipeContest($('#recipeId').val(), $('#recipeName').val(), $('#contestantId').val(), $('#contestUrl').val());
      } else {
        ACPuzzle.reload();
        $("#vote_msg").show();
      }
    });
  }
  function updateVoteStatus() {
    $.getJSON("<?= url_for('@update_vote_status' . '?recipe_id=' . $recipe->getId()) ?>", function(data) {
      if(data["is_voted"]){
        $("#vote_button_container").html("<span title=\"VOTE\" class=\"opac50 cursDef\">VOTE</span>");
        recipeVoteOmniture();
      } else { 
        $("#vote_button_container").html("<a title=\"VOTE\" id=\"vote\">VOTE</a>");
        $("#vote").click(function(){
          $(".popup").removeClass('hide');
          $(".popup").css('height', $(document).height());
          $(".popup .recipeboxpopup").css('top', $(window).scrollTop() + 300);
        });
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
    $("#rating_container").load("<?= url_for('recipes/rate') ?>", {id:<?= $recipe->getId() ?>, rating:rating}, 
    function() {toggleRate();
    });
  }    
<? if ($sf_user->isAuthenticated()): ?>
    function addToSaved() {
      $(".save_button").load(
      "<?= url_for('recipes/addtosaved') ?>", 
      {id:<?= $recipe->getId() ?>},
      function() {
        if ( $('#savedModal').length > 0 ) {
          $('#savedModal').show();
        }
        $.post(
        '/opengraph/addSaved', 
        { recipe_id: <?= $recipe->getId() ?>, recipe_title: '<?= addslashes($recipe->getName()) ?>', recipe_url: '<?= getUrl($recipe) ?>' },
        function(data) {
          if (data) {
            // launch activity completed box
            openActivityCompleted(data.id);
          }
        }, "json"
      ); 
      }
    );
    }
<? endif; ?>
</script>
<? if (!empty($msg)): ?>
  <p class="error pb20"><?= !empty($msg) ? $msg : '' ?></p>
<? endif ?>
<? if (!empty($currentContest)): ?>
  <div id="vote-box">
    <p>RANK: #<?= $currentContest->getRank() ?> in: <?= $currentContest->getContest()->getName() ?>!</p>
    <ul class="hornav">
      <li id="vote_button_container" class="cta-vote"><span title="VOTE" class="opac50 cursDef">VOTE</span></li>
      <? if ($recipePrev): ?> <li class="previous nav"><a href="<?= UrlToolkit::getUrl($recipePrev) ?>" title="">PREVIOUS</a></li><? endif; ?>
      <? if ($recipePrev && $recipeNext): ?>  <li class="nav gray"> | </li><? endif; ?>
      <? if ($recipeNext): ?> <li class="next nav last"><a href="<?= UrlToolkit::getUrl($recipeNext) ?>" title="">NEXT</a></li><? endif; ?>
    </ul>
  </div><!-- /#vote-box -->
<? endif; ?>
<? include_partial('recipe_sharebar', compact('recipe', 'is_saved')) ?>
<div class="popup hide brdn contestpopup">
  <div class="recipeboxpopup brdn captchapopup">
    <a id="closePopup"></a>
    <div id="captcha_container">
      <form method="post" id="submitVote" name="captchaform" action="<?= url_for('@recipe_contest_vote') ?>" enctype="multipart/form-data">
        <input type="hidden" name="captcha" value="captcha" />
        <input type="hidden" id="recipeId" name="recipeId" value="<?= $recipe->getId() ?>" />  
        <input type="hidden" id="recipeName" name="recipeName" value="<?= $recipe->getName() ?>" />  
        <? if (!empty($currentContest)): ?>
          <input type="hidden" id="contestId" name="contestId" value="<?= $currentContest->getContest()->getId() ?>" />
          <input type="hidden" id="contestantId" name="contestantId" value="<?= $currentContest->getId() ?>" />
          <input type="hidden" id="contestUrl" name="contestUrl" value="<?= getRoute('contests_detail', array('slug' => $currentContest->getContest()->getSlug())) ?>" />
        <? endif; ?>    
        <p class="captcha">Please verify your vote by answering the question below and then pressing the<br/> "Submit My Vote" button.</p>
        <?= AdCopy::getSolveMediaHtml(sfConfig::get('app_adcopy_challenge_key')) //outputs the widget echo captcha_image()?>  
        <input type="submit" id="vote_submit_btn" class="btn-grey28 mt10" value="SUBMIT VOTE" />
        <p class="error pt10 hidden" id="vote_msg">Incorrect Security Code! Please try again</p>
      </form>
    </div>
    <div id="vote_sharebar_container" class="hidden">
      <? include_partial('post_vote_sharebar') ?>
    </div>
  </div>
</div>
<div class="p402_premium">  
  <div id="recipe-detail" itemscope itemtype="http://data-vocabulary.org/Recipe">
    <div class="recipeHeader">
      <div class="utility">
        <ul>
          <li style="padding-top:5px;">
            <a class="grey" href="#" onclick="emailRecipe()" title="email this recipe">Email</a>
          </li>
          <li style="padding-top:5px;">|</li>
          <li style="padding-top:5px;">
            <a class="grey" href="?print" title="Print this recipe" target="_blank" rel="<?= $recipe->getId() ?>|<?= $recipe->getName() ?>|<?= getUrl($recipe) ?>" <? if ($sf_user->isAuthenticated()): ?> id="printRecipeBtn" <? endif; ?>>Print</a>
          </li>
          <li style="padding-top:5px;">|</li>
          <li style="padding-top:5px;">
            <? if ($recipe->getUserId() != $sf_user->getAttribute('id')): ?>
              <span class="save_button"><? include_partial('save_recipe', compact('is_saved')) ?></span>
            <? endif; ?>
          </li>
          <li style="margin-left: 15px;">
            <? if ($sf_user->isAuthenticated()): ?>
              <? if (!$is_made): ?>
                <div id="madeContainer">
                  <a class="graphic-button" onclick="addToMadeThis(<?= $recipe->getId() ?>, '<?= urlencode($recipe->getName()) ?>', '<?= getUrl($recipe) ?>')">Made This!</a>
                  <div class="madeMoreFeatures" style="display:none;">
                    <a href="javascript:;" onclick="addToRecommend(<?= $recipe->getId() ?>, '<?= urlencode($recipe->getName()) ?>', '<?= getUrl($recipe) ?>')">I recommend this</a>
                  </div><!-- // madeMoreFeatures -->
                </div><!-- // madeContainer -->
              <? else: ?>
                <div id="madeContainer">
                  <a class="graphic-button" onclick="$('.madeMoreFeatures').show();">Made</a>
                  <div class="madeMoreFeatures" style="display:none;">
                    <a onclick="addToRecommend(<?= $recipe->getId() ?>, '<?= urlencode($recipe->getName()) ?>', '<?= getUrl($recipe) ?>')">I recommend this</a>
                  </div><!-- // madeMoreFeatures -->
                </div><!-- // madeContainer -->
              <? endif; ?>
            <? else: ?>
              <div id="madeContainer">
                <a class="graphic-button" href="<?= getSigninUri($sf_request->getParameter('referrer', $sf_request->getUri())) ?>">Made</a>
              </div><!-- // madeMoreFeatures -->
            <? endif; ?>
          </li>
        </ul>
        <? if ($sf_user->isAuthenticated()): ?>
          <div id="savedModalContainer">
            <?php include_component('opengraph', 'userSavedNotMade') ?>
          </div><!-- // savedModalContainer -->
        <? endif; ?>
      </div><!-- // utility -->
      <h3 class="title green" itemprop="name" id="recipe_title"><?= Microformat::correct_caps($recipe->getName()) ?></h3>
      <? $recipe_user = $recipe->getUser() ?>
      <? $recipe_user_active = $recipe_user->getSubdir() && $recipe_user->getSubdir() != '' && $recipe_user->getIsActive() == 1 ?>
      <? if ($recipe_user_active): ?>
        <p>Submitted by: <a href="<?= getUrl('User', array('display_name' => $recipe_user->getDisplayName())) ?>" title="Recipe Author" itemprop="author"><?= $recipe_user->getDisplayName() ?></a>
          <a href="/search?recipeOwner=<?= $recipe_user->getDisplayName() ?>&term=*&PageType=Recipe" title="Recipe Author">(see all recipes)</a>
          <? if ( $recipe_user->getWebsiteName() != '' && $recipe_user->getWebsiteAddress() != '' ): ?>
          	| website: <a href="<?=$recipe_user->getWebsiteAddress()?>" target="_blank"><?=$recipe_user->getWebsiteName()?></a>
          <? endif; ?>
          <? if ($origin = $recipe->getOrigin()): ?>
            | Source: <span title="Recipe Source"><?= $origin ?></span>
          <? endif; ?>
        </p>
      <? else: ?>
        <p>Submitted by: <?= $recipe_user->getDisplayName() ?>
        	<? if ( $recipe_user->getWebsiteName() != '' && $recipe_user->getWebsiteAddress() != '' ): ?>
          	| website: <a href="<?=$recipe_user->getWebsiteAddress()?>" target="_blank"><?=$recipe_user->getWebsiteName()?></a>
          <? endif; ?>

          <? if ($origin = $recipe->getOrigin()): ?>
            | Source: <span title="Recipe Source"><?= $origin ?></span>
          <? endif; ?>
        </p>
      <? endif; ?>
    </div><!-- // recipeHeader -->
    <div class="images p402_hide">
      <div class="main-image" style="position:relative;">
        <? if ($recipe->hasPhoto() && $main_img = $recipe->getMainImage()): ?>
        	<div id="pinButtonMain"><a onclick="pin_this(event, 'http://pinterest.com/pin/create/button/?url=<?=getUrl($recipe)?>&media=<?=getDomainUri().$recipe->getMainImageSrc()?>&description=<?=$recipe->getName()?>');"><img src="/img/pinit_button.png" /></a></div>
        	<div id="mainImg"></div>
          <script>
            function displayPhotos() {
              $("#modal_div").dialog("open");
              $("#modal_div").dialog("option", {"title": "<?= addslashes( $recipe->getName() ) ?> Photos", "width": 600, "height": 450});
              $("#modal_iframe").attr("src","/recipes/photos/recipe_id/<?= $recipe->getId() ?>");
              return false;
            }
          </script>      
        <? endif; ?>
        <img itemprop="photo" src="<?= $recipe->getMainImageSrc() ?>" alt="<?= $recipe->getName() ?>" />
        <? if (@$is_saved): ?>
        <? else: ?>
          <div style="position:absolute;top:194px;left:0;display:none;" id="saveRecipeHover"><a <? if ($sf_user->isAuthenticated()): ?>onclick="addToSaved()"<? else: ?>href="<?= getSigninUri($sf_request->getUri()) ?>"<? endif; ?> title="Add recipe to my recipebox" onclick="addToSaved()"><img src="/img/save_recipe_hover.png" /></a></div>
        <? endif; ?>
      </div>
      <p><a <? if ($sf_user->isAuthenticated()): ?>onclick="addPhoto()"<? else: ?>href="<?= getSigninUri($sf_request->getUri()) ?>"<? endif; ?> title="Add a photo">Add a Photo</a><? if (isset($main_img)): ?>  | <a onclick="displayPhotos()" title="View All Photos">View All Photos</a><? endif; ?></p>
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
      <div class="addrate"><a href="#write_review">Comment (<fb:comments-count href=<?= $sf_request->getUri() ?>></fb:comments-count>) </a></div>
      <? include_partial('rating', array('rating' => $recipe->getRating(), 'user_rating' => @$user_rating)) ?>
      <div id="rating_container">
        <? if ($recipe->getRating() > 0): ?>
          <span class="microformat" itemprop="review" itemscope itemtype="http://data-vocabulary.org/Review-aggregate">
            <span itemprop="rating"><?= round($recipe->getRating(), 1) ?></span>
            <span itemprop="count"><?= $recipe->getRatingCount() ?></span>
          </span>
        <? endif; ?>
      </div>
      <p class="summary mb10"><span itemprop="summary" id="recipe_description"><?= SearchReplace::run($recipe->getIntroduction()) ?></span></p>
      <? if ($sf_user->isAuthenticated() && $sf_user->getAttribute('id') == $recipe->getUserId()): ?>
        <p class="w100 mt20 mb20"><a href="<?= getUrl('@edit_recipe', array('id' => $recipe->getId())) ?>" title="<?= $recipe->getName() ?>" class="btn-purple28">Edit Recipe</a></p>
      <? endif; ?>
      </ul>    
      <? if ($sf_user->isAuthenticated() && $sf_user->getFbId()): ?>
        <div id="activityRecipeDetailContainer">
          <?php include_component('opengraph', 'activityRecipeDetail', array('recipe_id' => $recipe->getId())) ?>
        </div><!-- // activityRecipeDetailContainer -->
      <? endif ?>
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
        <time class="microformat" style="display:none;" itemprop="prepTime" datetime="<?= $preptime ?>"><?= Microformat::duration_to_pretty($preptime) ?></time>
      <? endif; ?>
      <? if ($recipe->getCooktime() && $recipe->getCooktime() != ''): ?>
        <li>Cook Time: <?= $recipe->getCooktime() ?></li>
      <? endif; ?>
      <? if ($cooktime): ?>
        <time class="microformat" style="display:none;" itemprop="cookTime" datetime="<?= $cooktime ?>"><?= Microformat::duration_to_pretty($cooktime) ?></time>
      <? endif; ?>
      <? if ($recipe->getTotaltime() && $recipe->getTotaltime() != ''): ?>
        <li class="last">Total Time: <?= $recipe->getTotaltime() ?></li>
      <? endif; ?>
      <? if ($totaltime): ?>
        <time class="microformat" style="display:none;" itemprop="totalTime" datetime="<?= $totaltime ?>"><?= Microformat::duration_to_pretty($totaltime) ?></time>
      <? endif; ?>
    </ul>
    <p class="title">Ingredients:</p>
    <p class="lh25"><?= SearchReplace::run(Microformat::tableIngredients($recipe->getIngredients())) ?></p>
    
    
    <? /* insert Mulu Ad Code */ ?>
    <div id="mbox_loader" data-charity="51ae3c7f739dd386ff000001" data-color_code="640968" data-footer="Buying any of these items will benefit:" data-headline="Make it at home" data-layout="better_recipes"></div> 
    <script src="http://mulu-assets.s3.amazonaws.com/mbox_loader.js"></script> 
    
    
    <p class="title mt35">Directions:</p>
    <div class="instructions" itemprop="instructions"><?= SearchReplace::run(Microformat::parseInstructions($recipe->getInstructions())) ?></div>
    <? if ($notes = @$recipe->getNotes()): ?>
      <p class="title mt20">Helpful Tips:</p>
      <p><?= SearchReplace::run($recipe->getNotes()) ?></p>
    <? endif; ?>
    <? if ($recipe_user_active): ?>
      <? include_partial('author', array('author' => $recipe->getUser())) ?>
    <? endif; ?>
    <div id="modal_div"><iframe id="modal_iframe" width="100%" height="100%" marginWidth="0" marginHeight="0" frameBorder="0" scrolling="auto"></iframe></div>
  </div><!-- /#recipe-detail -->
</div>
<script type="text/javascript"> 
  try { _402_Show(); } catch(e) {} 
</script>
<? slot('facebook_meta') ?>
<meta property="og:title" content="<?= Microformat::correct_caps($recipe->getName()) ?>" />
<meta property="og:description" content="<?= htmlentities($recipe->getIntroduction(), ENT_QUOTES) ?>" />
<meta property="og:url" content="<?= UrlToolkit::getUrl($recipe) ?>"/>
<meta property="og:type" content="<?= sfConfig::get('app_facebook_appnamespace') ?>:recipe" />
<? foreach (PhotoTable::getRecipePhotos($recipe->getId()) as $photo): ?>
  <meta property="og:image" content="<?= 'http://' . $_SERVER['HTTP_HOST'] . $photo->getImgSrc() ?>" />
<? endforeach; ?>
<? end_slot() ?>