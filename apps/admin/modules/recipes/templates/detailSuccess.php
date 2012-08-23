<? include_partial('global/bread_crumbs', compact('bread_crumbs')) ?>
<div id="mainHeading">
  <h1><?= $recipe->getName() ?></h1>
</div>
<div id="recipeContainer" class="container small">
  <div id="subHeading">
    <h2>General Details</h2><a href="<?= UrlToolkit::getUrl($recipe, array('mode' => 'preview')) ?>" title="Preview '<?= $recipe->getName() ?>'" target="_blank" class="lp150">Preview "<?= $recipe->getName() ?>"</a>
    <form id="recipeSearch" action="<?= url_for('recipes/edit?id=' . $recipe->getId()) ?>">
      <input type="submit" class="detail btn-grey28" value="Edit" />
    </form>
  </div>
  <div class="list">
    <ul>
      <li><span class="label">Slug</span><span class="data"><?= $recipe->getSlug(); ?></span></li>
      <li>
        <span class="label"><?= count($recipe->getRecipeCategories()) > 1 ? 'Categories' : 'Category' ?></span>
        <span class="data">
          <ul id="subcategories" class="category_list">
            <? if ($recipe->hasCategory()): ?>
              <? include_partial('categories', compact('recipe')) ?>
            <? else: ?>
              <li><span class="error">NO CATEGORY - FIX ME!</span></li>
            <? endif; ?>
          </ul>        
        </span>
      </li>
      <li><span class="label">Submitted By</span><span class="data"><?= $recipe->getUser()->getDisplayName(); ?></span></li>
      <li><span class="label">Date Added</span><span class="data"><?= date('m/d/y', strtotime($recipe->getCreatedAt())) ?></span></li>
      <li>
        <span class="label">Images</span>
        <div id="images" class="data">
          <span class="data"><a href="<?= url_for("@recipephotos_index?recipe_id=" . $recipe->getId()) ?>">View Photo Images</a></span>
        </div>
      </li>
      <li><span class="label">Source</span><span class="data"><?= $recipe->getOrigin() ?></span></li>
      <li>
        <span class="label">Prep time</span><span class="data subdata"><?= $recipe->getPreptime() ?></span>
        <span class="label">Cook time</span><span class="data subdata"><?= $recipe->getCooktime() ?></span>
      </li>
      <li>
        <span class="label">Total time</span><span class="data subdata"><?= $recipe->getTotaltime() ?></span>
        <span class="label">Servings</span><span class="data subdata"><?= $recipe->getOrigin() ?></span>
      </li>
      <li><span class="label">Introduction</span><span class="data"><?= $recipe->getIntroduction() ?></span></li>
      <li><span class="label">Ingredients</span><span class="data"><?= $recipe->getIngredients() ?></span></li>
      <li><span class="label">Directions</span><span class="data"><?= $recipe->getInstructions() ?></span></li>
      <li><span class="label">Notes</span><span class="data"><?= $recipe->getNotes() ?></span></li>
      <li><span class="label">Title Tag</span><span class="data"><?= $recipe->getTitleTag() ?></span></li>
      <li><span class="label">Meta Description</span><span class="data"><?= $recipe->getSummary() ?></span></li>
      <li><span class="label">Keywords</span><span class="data"><?= $recipe->getKeywords() ?></span></li>
    </ul>
  </div>
</div>

<script type="text/javascript">
  /*
  $(document).ready(function(){
    $("#submitContest").submit(function() {
      var contestId = $("#selectContests option:selected").val();
      $("#contests").load("<? //= url_for('recipes/updateContests')          ?>", {contestId:contestId});
    });
    
    
  });
   */
  
</script>

<!--<div id="recipeSidebarContest" class="container sidebar">
  <div id="subHeading">
    <h3>Contests</h3>
  </div>
  <p class="text">Current Entered in:</p>
  <div id="contests">
<? //= $recipe->getName();//Contest()->getName(); ?>
<? //include_partial('contests', array('contests' => $contests)) ?>
  </div>
  <p class="text">Enter This Recipe in a Contest:</p>
  <form id="submitContest" method="post" action="">
    <select id="selectContests">      
      <option val="" >-- Enter in Contest --</option>
<? //foreach ($contests as $c): ?>      
      <option value="<? //= $c->getId()          ?>"><? //= $c->getName()          ?></option>
<? //endforeach; ?>
    </select> 
    <input type="submit" name="submit" id="submit" class="submit" value="Enter" />
  </form>
</div>-->
<div id="recipeSidebarSponsor" class="container sidebar sponsor">
  <div id="subHeading">
    <h3>Sponsor</h3>
    <p class="text">Current Sponsor:</p>
    <? $sponsorId = $recipe->getSponsorId(); ?>
    <p id="currentSponsor"><?= isset($sponsorId) ? $recipe->getSponsor()->getName() : "None" ?></p>
    <form id="recipeSearch" action="<?= url_for('recipes/edit?id=' . $recipe->getId()) ?>">
      <input type="submit" class="sidebar btn-grey28" value="Edit" />
    </form>
  </div>
</div>