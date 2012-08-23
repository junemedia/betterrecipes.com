<? include_partial('global/bread_crumbs', compact('bread_crumbs')) ?>
<div id="mainHeading">
  <h1>Recipe Category - <?= $form->getObject()->getName() ?></h1><a href="<?= UrlToolkit::getUrl($form->getObject(), array('mode' => 'preview')) ?>" title="Preview '<?= $form->getObject()->getName() ?>'" target="_blank">Preview "<?= $form->getObject()->getName() ?>"</a>
</div>

<div id="categoryContainer" class="container edit">
  <h2>General Content</h2>
  <?php include_partial('form', array('form' => $form)) ?>
</div>

<script>
  $(document).ready(function(){
    
    //Datepicker Calendar
    $(".datepicker").datepicker({
      showOn: "button",
      buttonImage: "/img/calendar.png",
      buttonImageOnly: true
    });
    
    //Change hidden date fields when new date is chosen
    $("#startDate.datepicker").change(function(){
      $("#overrideModule #override_start_date").val($("#startDate").val());
    });
    $("#endDate.datepicker").change(function(){
      $("#overrideModule #override_end_date").val($("#endDate").val());
    });
    $("#startDateArticles.datepicker").change(function(){
      $("#articleOverrideModule #override_start_date").val($("#startDateArticles").val());
    });
    $("#endDateArticles.datepicker").change(function(){
      $("#articleOverrideModule #override_end_date").val($("#endDateArticles").val());
    });
  
    //Autocomplete - Fav Recipes
    $("#addRecipeInput").autocomplete({
      minlength: 3,
      source: function (request, response ){
        $.get('<?= url_for('categories/autocomplete') ?>', { textField : request.term }, function(data){ 
          response($.map(data, function(item){                  
            return {
              label: item.name,
              value: item.id
            }
          })) }, "json");
      }, 
      select: function(event, ui){
        $("#addRecipeInput").val(ui.item.label);
        $("#addRecipeInputId").val(ui.item.value);
        return false;
      }
    });
    //Autocomplete - Fav Articles
    $("#addArticleInput").autocomplete({
      minlength: 3,
      source: function (request, response ){
        $.get('<?= url_for('categories/autocompleteArticles') ?>', { textField : request.term }, function(data){ 
          response($.map(data, function(item){                  
            return {
              label: item.name,
              value: item.id
            }
          })) }, "json");
      }, 
      select: function(event, ui){
        $("#addArticleInput").val(ui.item.label);
        $("#addArticleInputId").val(ui.item.value);
        return false;
      }
    });
    
    //Add Recipe    
    $("#addRecipeBtn").click(function(){
      var recipes = <?= count($weightedItems) ?>;
      var totalRecipes = <?= $favoriteRecipesTotal ?>;
      if (recipes >= totalRecipes){
        alert("You must increase the number total number of recipes shown on each page to add a new recipe.");
      } else {
        $("#items").load('<?= url_for('categories/addRecipe') ?>', { overrideId : <?= $favRecipesForm->getObject()->getId() ?>, itemId : $("#addRecipeInputId").val(), rank : recipes});
      }      
    });   
    //Add Article  
    $("#addArticleBtn").click(function(){
      var articles = <?= count($weightedArticles) ?>;
      var totalArticles = <?= $favoriteArticlesTotal ?>;
      if (articles >= totalArticles){
        alert("You must increase the number total number of articles shown on each page to add a new article.");
      } else {
        $("#articles").load('<?= url_for('categories/addArticle') ?>', { overrideId : <?= $favArticlesForm->getObject()->getId() ?>, itemId : $("#addArticleInputId").val(), rank : articles});
      }      
    });   
    
  }); 
</script>
<div id="rightrailEdit" class="container overrideEditSection">
  <div id="subHeading">
    <h2>Favorite Recipes</h2>
  </div> 
  <form id="overrideModule" class="overrideModuleEdit" method="post" action="<?= url_for('categories/updateFavRecipes?id='.$favRecipesForm->getObject()->getId()) ?>">
    <?= $favRecipesForm->renderHiddenFields() ?>
    <?= $favRecipesForm->renderGlobalErrors() ?>
    <? //= link_to('Delete', 'rightrail/delete?id='.$form->getObject()->getId(), array('method' => 'delete', 'confirm' => 'Are you sure?', 'id' => 'deleteRecipe')) ?>
    <span class="total">Total Recipes Shown on Page:</span>
    <select class="label totalRecipes" name="totalRecipes">
      <? for ($i = 0; $i <= 15; $i++): ?>
        <option value="<?= $i ?>" <? if ($favoriteRecipesTotal == $i)
        echo "Selected" ?>><?= $i ?></option>
              <? endfor; ?>
    </select>       
    <div class="date">
      <span class="label">Show the recipes below from</span>
      <input type="text" id="startDate" class="datepicker" name="startDate" readonly="readonly" value="<?= date('m/d/y', strtotime($favRecipesForm->getObject()->getStartDate())) ?>" />
      <span class="label to"> to </span>
      <input type="text" id="endDate" class="datepicker" name="endDate" readonly="readonly"value="<?= date('m/d/y', strtotime($favRecipesForm->getObject()->getEndDate())) ?>" />
    </div>
    <div id="addRecipe" class="addAuto">      
      <label>Add Recipe</label>
      <input type="hidden" id="addRecipeInputId" name="addRecipeInputId" value="-1"/>
      <input type="text" id="addRecipeInput" class="autoInput" name="addRecipeInput" />
      <input type="button" class="autoBtn btn-grey28" id="addRecipeBtn" name="addRecipeBtn" value="Add" />
    </div>
    <div id="items">
      <? include_partial('favoriteRecipes', array('weightedItems' => $weightedItems, 'overrideId' => $favRecipesForm->getObject()->getId())); ?>
    </div>
    <div class="action">
      <a href="<?php echo url_for('categories/index') ?>">Cancel</a>
      &nbsp;&nbsp;or&nbsp;&nbsp;
      <input type="submit" class="btn-grey28" id="save" name="save" value="Save" />
    </div>
  </form>
</div>

<div id="articleEdit" class="container overrideEditSection">
  <div id="subHeading">
    <h2>How To Stories</h2>
  </div> 
  <form id="articleOverrideModule" class="overrideModuleEdit" method="post" action="<?= url_for('categories/updateFavArticles?id='.$favArticlesForm->getObject()->getId()) ?>">
    <?= $favArticlesForm->renderHiddenFields() ?>
    <?= $favArticlesForm->renderGlobalErrors() ?>
    <? //= link_to('Delete', 'rightrail/delete?id='.$form->getObject()->getId(), array('method' => 'delete', 'confirm' => 'Are you sure?', 'id' => 'deleteRecipe')) ?>
    <span class="total">Total Articles Shown on Page:</span>
    <select class="totalRecipes label" name="totalArticles">
      <? for ($i = 0; $i <= 15; $i++): ?>
        <option value="<?= $i ?>" <? if ($favoriteArticlesTotal == $i)
        echo "Selected" ?>><?= $i ?></option>
              <? endfor; ?>
    </select>       
    <div class="date">
      <span class="label">Show the recipes below from</span>
      <input type="text" id="startDateArticles" class="datepicker" name="startDateArticles" readonly="readonly" value="<?= date('m/d/y', strtotime($favArticlesForm->getObject()->getStartDate())) ?>" />
      <span class="label to"> to </span>
      <input type="text" id="endDateArticles" class="datepicker" name="endDateArticles" readonly="readonly"value="<?= date('m/d/y', strtotime($favArticlesForm->getObject()->getEndDate())) ?>" />
    </div>
    <div id="addArticle" class="addAuto">      
      <label>Add Article</label>
      <input type="hidden" id="addArticleInputId" name="addArticleInputId" value="-1"/>
      <input type="text" id="addArticleInput" class="autoInput" name="addArticleInput" />
      <input type="button" class="autoBtn btn-grey28" id="addArticleBtn" name="addArticleBtn" value="Add" />
    </div>
    <div id="articles">
      <? include_partial('favoriteArticles', array('weightedArticles' => $weightedArticles, 'overrideId' => $favArticlesForm->getObject()->getId()));  ?>
    </div>
    <div class="action">
      <a href="<? //= url_for('categories/index')    ?>">Cancel</a>
      &nbsp;&nbsp;or&nbsp;&nbsp;
      <input type="submit" class="btn-grey28" id="save" name="save" value="Save" />
    </div>
  </form>
</div>