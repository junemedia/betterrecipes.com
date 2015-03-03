<? slot('gpt') ?>

unitValues: {
                	channel: 'MixingBowl', /* Set to the top level category id, if applicable */
                
                	parent: '', /* Set to the secondary level category id, if applicable */
                
                	child: '' /* Set to the tertiary level category id, if applicable */
                
            },
            pageTargetingValues: { /* Additional key-values can be added to this section if needed */
            		id: '<?php echo md5($sf_request->getUri())?>', /* Set to a page-specific unique id*/
                	type: 'RecipeBox', /* Set the content type ( 'category', 'recipe', 'slideshow', etc.) */
                	search: '' /* On search results, set to the search term */
                
            }


<? end_slot() ?>

<script>
  function getUrl(order_by){
    url = "<?= getDomainUri() . url_for('@myrecipebox?folder=' . $sf_request->getParameter('folder', 'all') . '&order_by=orderby&page_no=' . $sf_request->getParameter('page_no', 1)) ?>";
    return url.replace('orderby',order_by);
  } 
  function getMoveRecipeUrl(recipe_id, from){
    url = "<?= getDomainUri() . url_for('@move_recipe?recipe=recipe_id&from=from_folder') ?>";
    return url.replace('recipe_id',recipe_id).replace('from_folder',from);
  } 
  $(document).ready(function() {
    $("#modal_div").dialog({modal: true, autoOpen: false, draggable: false, resizeable: false});
  });
  function addFolder() {
    $("#modal_div").dialog("open").dialog("option", {"title": "Create a Folder", "width": 380, "height": 700});
    $("#modal_iframe").attr("src","<?= getDomainUri() . url_for('@add_collection') ?>");
    return false;
  }
  function moveRecipe(url, action) {
    $("#modal_div").dialog("open").dialog("option", {"title": action+" Recipe", "width": 380, "height": 300});
    $("#modal_iframe").attr("src",url);
    return false;
  }
  function deleteSavedRecipe(recipe_id) {
    url = "<?= getDomainUri() . url_for('@delete_saved_recipe?recipe=recipe_id') ?>";
    $("#modal_div").dialog("open").dialog("option", {"title": "Delete Saved Recipe", "width": 500, "height": 250});
    $("#modal_iframe").attr("src",url.replace('recipe_id',recipe_id));
    return false;
  }
<? if ($folder): ?>
    function deleteCollectionRecipe(recipe_id) {
      url = "<?= getDomainUri() . url_for('@delete_collection_recipe?recipe=recipe_id&folder=' . $folder->getId()) ?>";
      $("#modal_div").dialog("open").dialog("option", {"title": "Delete Recipe from Folder", "width": 380, "height": 300});
      $("#modal_iframe").attr("src",url.replace('recipe_id',recipe_id));
      return false;
    }
    function editFolder() {
      $("#modal_div").dialog("open").dialog("option", {"title": "Edit \"<?= $folder->getName() ?>\"", "width": 380, "height": 300, "class": "test-class"});
      $("#modal_iframe").attr("src","<?= getDomainUri() . url_for('@edit_collection?folder=' . $folder->getId()) ?>");
      return false;
    }
    function deleteFolder() {
      $("#modal_div").dialog("open").dialog("option", {"title": "Delete <?= $folder->getName() ?>", "width": 380, "height": 300});
      $("#modal_iframe").attr("src","<?= getDomainUri() . url_for('@delete_collection?folder=' . $folder->getId()) ?>");
      return false;
    }
<? endif; ?>  
</script>
<div id="modal_div"><iframe id="modal_iframe" width="100%" height="100%" marginWidth="0" marginHeight="0" frameBorder="0" scrolling="auto"></iframe></div>
<div id="recipe-box" class="article horflip">
  <p class="title green">My Recipe Box</p>
  <p class="mb20">Save the recipes you've posted and new favorites from your Better Recipes friends -- in your Recipe Box to make meal planning and prep a snap. "All My Recipes" shows everything you've saved, and you can add new folders to help organize things. You can remove recipes from your folders, or delete a folder, without the recipes vanishing from your Recipe Box.</p>
  <div class="relative">
    <p>
      <?php
      if ($folder) {
        echo $folder->getName();
      } else {
        switch ($sf_request->getParameter('folder')) {
          case 'all' :
            echo 'All My Recipes';
            break;
          case 'personal' :
            echo 'My Personal Recipes';
            break;
          case 'saved' :
            echo 'Recipes I\'ve Saved';
            break;
          case 'made' :
            echo 'Recipes I\'ve Made';
            break;
        }
      }
      ?>
      <br />
      <? if ($folder): ?>
        <span class="fs11"><a title="Edit Folder" onclick="editFolder()">Edit</a> | <a title="Delete Folder" onclick="deleteFolder()">Delete</a></span>
      <? endif; ?>
    </p>
    <div class="sorting topright">
      <? if ($recipes->haveToPaginate()): ?>
        <? include_partial('paginator', compact('recipes')) ?>
      <? endif; ?>      
      <label for="sorting">Sort By:</label>
      <select name="sorting" onchange="window.location.href=getUrl(this.value);">
        <option value="date-desc" <? if ($sf_request->getParameter('order_by', 'date-desc') == 'date-desc'): ?> selected<? endif; ?>>Date - Newest first</option>
        <option value="date-asc" <? if ($sf_request->getParameter('order_by', 'date-desc') == 'date-asc'): ?> selected<? endif; ?>>Date Oldest first</option>
        <option value="rating-desc" <? if ($sf_request->getParameter('order_by', 'date-desc') == 'rating-desc'): ?> selected<? endif; ?>>Rating - Highest first</option>
        <option value="rating-asc" <? if ($sf_request->getParameter('order_by', 'date-desc') == 'rating-asc'): ?> selected<? endif; ?>>Rating - Lowest first</option>
        <option value="name-asc" <? if ($sf_request->getParameter('order_by', 'date-desc') == 'name-asc'): ?> selected<? endif; ?>>Alphabetical - A to Z</option>
        <option value="name-desc" <? if ($sf_request->getParameter('order_by', 'date-desc') == 'name-desc'): ?> selected<? endif; ?>>Alphabetical - Z to A</option>
      </select>
    </div>
  </div>
  <div id="recipeBoxContainer" class="border-bottom mt20 clearfix">
    <? if (count($recipes) > 0): ?>
      <? foreach ($recipes as $recipe): ?>
        <? $saved = UserActionsTable::getSavedRecipe($sf_user->getId(), $recipe->getId()); ?>
        <? $made = UserActionsTable::getMadeRecipe($sf_user->getId(), $recipe->getId()); ?>
        <? $liked = RecipeLikeTable::getLike($sf_user->getId(), $recipe->getId()); ?>
        <div id="recipe-box-container">
          <div>
            <a title="<?= $recipe->getName() ?>" href="<?= getUrl($recipe) ?>"><img class="img-w150" src="<?= $recipe->getMainImageSrc() ?>" /></a>
          </div>
          <p class="mb10"><a href="<?= getUrl($recipe) ?>" title="<?= $recipe->getName() ?>"><?= $recipe->getName() ?></a></p>
          <p>
            <? if ($saved): ?>
              <span class="fs11">Saved: <?= date('m/d/y', strtotime($saved->getCreatedAt())) ?></span>
            <? endif; ?>
            <br/>
            <? if ($made): ?>
              <span class="fs11">
                Made: <?= date('m/d/y', strtotime($made->getCreatedAt())) ?> 
                <? if ($liked): ?>
                  - <? if ($liked->getIsLiked() == 1): ?> liked it!<? else: ?> didn't like it<? endif; ?>
                <? endif; ?>
              </span>
            <? else: ?>
              <a class="graphic-button" href="javascript:;" onclick="savedRecipeMade(this, <?= $recipe->getId() ?>, '<?= urlencode($recipe->getName()) ?>', '<?= getUrl($recipe) ?>')">Made This!</a>
            <? endif; ?>
          </p>
          <p class="fs11 mt10">
            <? //        <a href="#" title="Email Recipe">Email</a> | ?> 
            <? if ($folder): ?>
              <a title="Remove this recipe from <?= $folder->getName() ?>" onclick="deleteCollectionRecipe(<?= $recipe->getId() ?>)">Remove from Folder</a>
              | <a title="Move this recipe to a folder" onclick="moveRecipe(getMoveRecipeUrl(<?= $recipe->getId() ?>,<?= $folder->getId() ?>),'Move')">Move to Folder</a>
            <? else: ?>
              <? if ($sf_request->getParameter('folder') != 'personal'): ?>
                <a title="Remove this recipe from your recipe box" onclick="deleteSavedRecipe(<?= $recipe->getId() ?>)">Remove from Recipe Box</a>
              <? endif; ?>
              <? if ($sf_request->getParameter('folder') != 'personal' && count($folders) > 0): ?>
                |   
              <? endif; ?>
              <? if (count($folders) > 0): ?>
                <a title="Copy this recipe to a folder" onclick="moveRecipe(getMoveRecipeUrl(<?= $recipe->getId() ?>, 'saved'),'Copy')">Copy to Folder</a>
              <? endif; ?>
            <? endif; ?>
            <? //        | <a href="#" title="Enter this recipe in a contest">Enter in Contest</a>   ?>
          </p>
        </div>
      <? endforeach; ?>
    <? else: ?>
      <li>
        <p>
          No recipes
        </p>
      </li>    
    <? endif; ?>    
  </div><!-- // recipeBoxContainer -->
  <div class="sorting">
    <? if ($recipes->haveToPaginate()): ?>
      <? include_partial('paginator', compact('recipes')) ?>
    <? endif; ?>
  </div>
</div><!-- /.article -->
<? include_partial('folders', compact('folders', 'saved_recipe_count', 'personal_recipe_count', 'made_recipe_count', 'viewed')) ?>
<div class="clear"></div>
