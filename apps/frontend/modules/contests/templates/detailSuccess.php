<? include_partial('global/bread_crumbs', compact('bread_crumbs')) ?>
<script>
  $(document).ready(function(){
    var is_current = "<?= $contest->isCurrent() ?>"  
    var is_authenticated = "<?= $sf_user->isAuthenticated() ?>"  
    var is_over = "<?= $contest->isOver() ?>"
    //Show Message in Alert Box
<? if ($msg): ?>
      alert('<?= $msg ?>');
<? endif; ?>
<? if ($sf_user->hasFlash('contestant_id')): ?> 
      addEnteredContest(<?= $sf_user->getFlash('contestant_id') ?>, '<?= $contest->getName() ?>');
<? endif; ?>
    //Redirect if not logged, else show popup
    $("#btnExist").click(function(){
      if (is_current == 1) {
        if (is_authenticated == 1) {
          $(".popup.contestpopup").removeClass('hide');
          $(".popup.contestpopup").css('height', $(document).height());
        } else {
          window.location = "<?= UrlToolkit::getDomainUri() . url_for('@contests_enter_contest?id=' . $contest->getId()) ?>";
        } 
      } else if (is_over == 1) { 
        alert('This contest has already ended.');
      } else { 
        alert('This contest has not started yet.');
      } 
    });
    $("#btnCreate").click(function(){
      if (is_current == 1) { 
        window.location = "<?= getUrl('@add_recipe?contest=' . $contest->getId()) ?>";
      } else if (is_over == 1) { 
        alert('This contest has already ended.');
      } else { 
        alert('This contest has not started yet.');
      } 
    });
    //Close popup
    $("#closePopup").click(function(){
      $(".popup.contestpopup").addClass('hide');
    }); 
    //Autocomplete
    $("#recipeName").autocomplete({
      minlength: 3,
      source: function (request, response ){
        $.get('<?= url_for('@contests_autocomplete') ?>', { textField : request.term, userId : '<?= $sf_user->isAuthenticated() ? $sf_user->getId() : '' ?>' }, function(data){ 
          response($.map(data, function(item){                  
            return {
              label: item.name,
              value: item.id
            }
          })) }, "json");
      }, 
      select: function(event, ui){
        $("#recipeName").val(ui.item.label);
        $("#recipe_id").val(ui.item.value);
        return false;
      }
    }); 
    //Set values of search textfields 
    var placeholdersID = { recipeName:"Search Recipes by Name"};  
    //Set values of search textfields 
    $.each(placeholdersID, function(id, val) { 
      //Removes text on focus for textfield
      $('#'+id).focus(function(){
        if($(this).val() == val)
          $(this).val('');
      });
      //Replaces textfield with value if still empty
      $('#'+id).blur(function(){
        if ($(this).val() == '')
          $(this).val(val);
      });
    });
    
  });
</script>
<? slot('facebook_meta') ?>
<meta property="og:title" content="<?= Microformat::correct_caps($contest->getName()) ?>" />
<meta property="og:description" content="<?= htmlentities($contest->getDescription(), ENT_QUOTES) ?>" />
<meta property="og:url" content="<?= UrlToolkit::getRoute('contests_detail', array('slug' => $contest->getSlug())) ?>"/>
<meta property="og:type" content="<?= sfConfig::get('app_facebook_appnamespace') ?>:recipe_contest" />
<? end_slot() ?>
<div class="article contests">
  <div id="contest-detail">
    <? include_partial('global/sharebar') ?>
    <p class="title green pb20"><?= $contest->getName() ?></p>
    <div class="main-image imgmask205">
      <img src="<?= $contest->getImgSrc() ?>" height="205" width="280" alt="<?= $contest->getName() ?>" />
    </div>
    <div id="sponsor_<?= $sponsor->getId() ?>"class="sponsor adsponsor">
      <? include_partial('global/adtags/sponsor', compact('sponsor')) ?>
    </div>
    <p><?= $contest->getDescription() ?></p>
    <ul class="mt20 mb20">
      <li>Prize: <?= $contest->getPrize() ?></li>
      <li>End Date: <?= date('m/d/y', strtotime($contest->getEndDate())) ?></li>
      <li><a href="<?= getUrl('@contests_rules?slug=' . $contest->getSlug()) ?>">Official Rules</a></li>
    </ul>
  </div><!-- /#contest-detail -->
  <? if ($contest->isOver() == false && $contest->getIsOpenToPublic()): ?>
    <p class="mb10 clear">Enter Contest Now: <a href="javascript:;" title="Create New Recipe" id="btnCreate" class="btn-grey28 ml20 mr20">Create New Recipe</a><a href="javascript:;" title="Use Existing Recipe" id="btnExist" class="btn-grey28">Use Existing Recipe</a></p>
  <? else: ?>
    <p class="mb10 clear"></p>
  <? endif; ?>
  <div id="contest-tips">
    
    <? if( count(@$contest_tips) > 0): ?>
      <p class="title">Tips and Tricks for Great Food Photos</p>
      <ul id="tips-and-tricks">
        <? foreach($contest_tips as $tip): ?>
          <li class="tip"><a href="<?= $tip->url ?>"><?= $tip->title ?></a></li>
        <? endforeach ?>
      </ul>
    <? endif ?>
  </div>
  <div id="contest-entries">
    <p class="title">View Current Entries</p>
    <? if ($contestants->haveToPaginate()): ?>
      <div class="sorting mt20">
        <ul class="pager hornav">
          <li class="<?= ($contestants->getFirstPage() == $contestants->getPage()) ? 'unavailable' : '' ?>"><a href="<?= getRoute('contests_detail', array('slug' => $contest->getSlug(), 'page' => $contestants->getPreviousPage())) ?>" title="Previous">&laquo;</a></li>
          <? foreach ($contestants->getLinks() as $page): ?>
            <li class="<?= ($page == $contestants->getPage()) ? 'active' : '' ?>"><a href="<?= ($page == $contestants->getPage()) ? '' : getRoute('contests_detail', array('slug' => $contest->getSlug(), 'page' => $page)) ?>" title="Page <?= $page ?>"><?= $page ?></a></li>
          <? endforeach; ?>
          <li class="<?= ($contestants->getLastPage() == $contestants->getPage()) ? 'unavailable' : '' ?>"><a href="<?= getRoute('contests_detail', array('slug' => $contest->getSlug(), 'page' => $contestants->getNextPage())) ?>" title="Next">&raquo;</a></li>
        </ul>
      </div>
    <? endif; ?>
    <ul class="hornav">
      <? if (count($contestants->getResults()) > 0): ?>
        <? foreach ($contestants->getResults() as $i => $c): $recipe = $c->getRecipe() ?>
          <? if ((fmod($i, 4)) == 0): ?> <li class=""><ul class="hornav"> <? endif; ?>
              <li class="<?= ((fmod(($i + 1), 4)) == 0) ? 'last' : 'mb20' ?>">
                <a href="<?= getUrl($recipe) ?>" title="<?= $recipe->getName() ?>" class="imgmask150 mb10">
                  <img src="<?= $recipe->getMainImageSrc() ?>" height="100" width="100" alt="<?= $recipe->getName() ?>" />
                </a>
                <p><a href="<?= getUrl($recipe) ?>" title="<?= $c->getRecipe()->getName() ?>"><?= $c->getRecipe()->getName() ?></a></p>
                <p class="fs11"><a href="<?= getRoute('User', array('display_name' => $recipe->getUser()->getDisplayName())) ?>" title="Recipe Author"><?= $recipe->getUser()->getDisplayName() ?></a></p>
              </li>
              <? if ((fmod(($i + 1), 4)) == 0): ?> </ul></li> <? endif; ?>
        <? endforeach; ?>  
      <? else : ?>
        <p class="mt20 fs14 green">Be the first to enter your recipe into our contest!</p>
      <? endif; ?>
    </ul>
  </div>
</div><!-- /.article -->
<div class="popup hide brdn contestpopup">
  <div class="recipeboxpopup brdn">
    <a href="javascript:;" id="closePopup"></a>
    <p class="title green pb20 brdn">Enter Recipe</p>
    <p class="sub brdn fs12">Search for one of your recipes to enter in this contest</p>
    <form method="post" id="existingRecipeForm" name="existingRecipeForm" action="<?= UrlToolkit::getDomainUri() . url_for('@contests_enter_contest?id=' . $contest->getId()) ?>">
      <input type="hidden" id="recipe_id" name="recipe_id" />
      <input type="text" id="recipeName" name="recipeName" value="Search Recipes by Name" />
      <input type="submit" class="btn-grey28" value="ENTER NOW" />
    </form>
  </div>
</div>
<? include_partial('global/right_rail/right_rail') ?>
<? include_partial('opengraph/facebook_login_modal') ?>