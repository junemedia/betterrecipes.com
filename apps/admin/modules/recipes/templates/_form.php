<script>
  function updateSubcategory(catid){
    $("#subcategory").load("<?= url_for('recipes/updateSubcategory') ?>", {catid:catid, recipe_id:<?= $form->getObject()->getId() ?>});
  };
  function updateCategory(subcat_id){
    $("#selected_categories").load("<?= url_for('recipes/updateRecipe') ?>", {subcat_id:subcat_id, recipe_id:<?= $form->getObject()->getId() ?>}, resetCategories());
  };
  function removeCategory(cat_recipe_id){
    if(confirm("Are you sure?")){
      $("#selected_categories").load("<?= url_for('recipes/removeCategory') ?>", {id:cat_recipe_id}, resetCategories());
    }
  }  
  function resetCategories(){
    $("#main_categories").val('');
    updateSubcategory(0);
  }  
</script>
<form action="<?= url_for('recipes/' . ($form->getObject()->isNew() ? 'create' : 'edit') . (!$form->getObject()->isNew() ? '?id=' . $form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
  <?= $form->renderHiddenFields() ?>
  <?= $form->renderGlobalErrors() ?>
  <div id="recipes" class="fields small">
    <div class="field small">  
      <label for="subcategories">Add Category</label>
      <select name="main_categories" id="main_categories" class="sub_categories" onchange="updateSubcategory($(this).val())">
        <option value="" selected>-- Maincategory --</option>  
        <? foreach ($maincategories as $maincategory): ?>
          <option value="<?= $maincategory->getId() ?>"><?= $maincategory->getName() ?></option>
        <? endforeach; ?>
      </select>      
    </div>
    <div id="subcategory" class="field small lp150">  
      <? include_partial('subcategory', array('subcategories' => null)) ?>
    </div>
    <div class="field small">
      <ul id="selected_categories" class="data lp150">
        <? include_partial('categories', array('recipe' => $form->getObject(), 'edit' => 1)) ?>
      </ul>        
    </div>
    <div class="field small">  
      <?= $form['name']->renderError() ?>
      <?= $form['name']->renderLabel() ?>      
      <?= $form['name'] ?>
    </div>
    <div class="field small">  
      <?= $form['slug']->renderError() ?>
      <?= $form['slug']->renderLabel() ?>      
      <?= $form['slug'] ?>
    </div>
    <div class="field small">
      <label for="submitted">Submitted By</label>
      <span class="data"><?= $form->getObject()->getUser()->getDisplayName(); ?></span>
    </div>
    <div class="field small">
      <label for="dateAdded">Date Added</label>
      <span class="data"><?= date('m/d/y', strtotime($form->getObject()->getCreatedAt())) ?></span>
    </div>
    <div class="field small">
      <label for="images">Images</label>
      <div id="images">
        <span class="data"><a href="<?= url_for("@recipephotos_index?recipe_id=" . $form->getObject()->getId()) ?>">Image Editing</a></span>   
      </div>
    </div> 
    <div class="field small">
      <?= $form['origin']->renderError() ?>
      <?= $form['origin']->renderLabel() ?>      
      <?= $form['origin'] ?>
    </div> 
    <div class="field subfield left small">
      <?= $form['preptime']->renderError() ?>
      <?= $form['preptime']->renderLabel() ?>      
      <?= $form['preptime'] ?>
    </div> 
    <div class="field subfield right small">
      <?= $form['cooktime']->renderError() ?>
      <?= $form['cooktime']->renderLabel() ?>      
      <?= $form['cooktime'] ?>
    </div> 
    <div class="field subfield left small">
      <?= $form['totaltime']->renderError() ?>
      <?= $form['totaltime']->renderLabel() ?>      
      <?= $form['totaltime'] ?>
    </div> 
    <div class="field subfield right small">
      <?= $form['servings']->renderError() ?>
      <?= $form['servings']->renderLabel() ?>      
      <?= $form['servings'] ?>
    </div>  
    <div class="field small">
      <?= $form['introduction']->renderError() ?>
      <?= $form['introduction']->renderLabel() ?>      
      <?= $form['introduction'] ?>
    </div>
    <div class="field small">
      <?= $form['ingredients']->renderError() ?>
      <?= $form['ingredients']->renderLabel() ?>      
      <?= $form['ingredients'] ?>
    </div>
    <div class="field small">
      <?= $form['instructions']->renderError() ?>
      <?= $form['instructions']->renderLabel() ?>      
      <?= $form['instructions'] ?>
    </div>
    <div class="field small">
      <?= $form['notes']->renderError() ?>
      <?= $form['notes']->renderLabel() ?>      
      <?= $form['notes'] ?>
    </div>
    <div class="field small">
      <?= $form['title_tag']->renderError() ?>
      <?= $form['title_tag']->renderLabel() ?>      
      <?= $form['title_tag'] ?>
    </div>
    <div class="field small">
      <?= $form['summary']->renderError() ?>
      <?= $form['summary']->renderLabel() ?>      
      <?= $form['summary'] ?>
    </div>
    <div class="field small">
      <?= $form['keywords']->renderError() ?>
      <?= $form['keywords']->renderLabel() ?>      
      <?= $form['keywords'] ?>
    </div>      
    <div class="field small">
      <div class="action small">
        <a href="<?php echo url_for('recipes/index') ?>">Cancel</a>
        &nbsp;&nbsp;or&nbsp;&nbsp;
        <input type="submit" class="submit btn-grey28" value="Save" />
      </div>
    </div>
  </div>
</form>
