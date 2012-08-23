<? $is_new_form = $form->getObject()->isNew(); ?>
<script>
  function updateSubcategory(catid){
    $("#recipe_sub_category").load("<?= url_for('recipes/updateSubcategory') ?>", {catid:catid});
  }
<? if ($is_new_form): ?>
    $(document).ready(function() {
      if(window.location.hash=='#saved'){
        $("#recipe_content").html('<p class="mr75 ml0">You session has expired. Please use the "Edit" button on recipe view page to make any changes</p>');
      }
    });
<? endif; ?>
</script>
<div class="article" id="recipe_content">
  <h3 class="title green ml0">Create Recipe</h3>
  <p class="mr75 ml0">Enter your favorite recipe now to share with your groups, friends and family!</p>
  <? if (count($form->getErrorSchema()->getErrors())): ?>
    <p class="error_list">Please fill out all required fields and click save.</p>
  <? endif ?>
  <form onsubmit="addEnteredContestNewRecipe();" id="newRecipeUpload" action="<?= getDomainUri() . url_for('recipes/' . ($is_new_form ? 'new' : 'edit') . (!$is_new_form ? '?id=' . $form->getObject()->getId() : '')) ?>" method="post" <? $form->isMultipart() and print 'enctype="multipart/form-data" ' ?> class="standard-form">
    <? if (!$is_new_form): ?>
      <input type="hidden" name="sf_method" value="put" />
    <? endif; ?>
    <?= '<fieldset>' . $form->renderGlobalErrors() . '</fieldset>' ?>
    <fieldset>
      <?= $form['name']->renderLabel() ?>
      <?= $form['name']->renderError() ?>
      <?= $form['name'] ?>
      <span class="required">*</span>
    </fieldset>
    <fieldset>
      <?= $form['introduction']->renderLabel() ?>
      <?= $form['introduction']->renderError() ?>
      <?= $form['introduction'] ?>
      <span class="required">*</span>
    </fieldset>
    <fieldset>
      <?= $form['origin']->renderLabel() ?>
      <?= $form['origin']->renderError() ?>
      <?= $form['origin'] ?>
    </fieldset>
    <fieldset class="doublewide ovhid">
      <fieldset class="first" >
        <?= $form['preptime']->renderLabel() ?>
        <?= $form['preptime']->renderError() ?>
        <?= $form['preptime'] ?>
      </fieldset>
      <fieldset class="last second">
        <?= $form['cooktime']->renderLabel() ?>
        <?= $form['cooktime']->renderError() ?>
        <?= $form['cooktime'] ?>
      </fieldset>
    </fieldset>
    <fieldset class="doublewide ovhid">
      <fieldset class="first" >
        <?= $form['totaltime']->renderLabel() ?>
        <?= $form['totaltime']->renderError() ?>
        <?= $form['totaltime'] ?>
      </fieldset>
      <fieldset class="last second">
        <?= $form['servings']->renderLabel() ?>
        <?= $form['servings']->renderError() ?>
        <?= $form['servings'] ?>
      </fieldset>
    </fieldset>
    <fieldset>
      <?= $form['ingredients']->renderLabel() ?>
      <?= $form['ingredients']->renderError() ?>
      <?= $form['ingredients'] ?>
      <span class="required">*</span>
    </fieldset>
    <fieldset>
      <?= $form['instructions']->renderLabel() ?>
      <?= $form['instructions']->renderError() ?>
      <?= $form['instructions'] ?>
      <span class="required">*</span>
    </fieldset>
    <fieldset>
      <?= $form['notes']->renderLabel() ?>
      <?= $form['notes']->renderError() ?>
      <?= $form['notes'] ?>
    </fieldset>
    <? if ($is_new_form): ?>
      <input type="hidden" name="contest" value="<?= $sf_request->getParameter('contest', 0) ?>" />
      <fieldset>
        <?= $form['main_category']->renderLabel() ?>
        <?= $form['main_category']->renderError() ?>
        <?= $form['main_category'] ?>
        <span class="required">*</span>
      </fieldset>
      <fieldset>
        <?= $form['sub_category']->renderLabel() ?>
        <?= $form['sub_category']->renderError() ?>
        <?= $form['sub_category'] ?>
        <span class="required">*</span>
      </fieldset>
    <? endif; ?>    
    <fieldset>
      <?= $form['keywords']->renderLabel() ?>
      <?= $form['keywords']->renderError() ?>
      <?= $form['keywords'] ?>
      <span class="required">*</span>
      <p class="fs11">Enter tags and keywords separated with commas</p>
    </fieldset>
    <? if ($is_new_form): ?>
      <p class="legend ttupp">Image Information:</p>
      <fieldset>
        <?= $form['photo']['name']->renderLabel() ?>
        <?= $form['photo']['name']->renderError() ?>
        <?= $form['photo']['name'] ?>
      </fieldset>
      <fieldset>
        <?= $form['photo']['description']->renderLabel() ?>
        <?= $form['photo']['description']->renderError() ?>
        <?= $form['photo']['description'] ?>
      </fieldset>
      <fieldset>
        <?= $form['photo']['image']->renderLabel() ?>
        <?= $form['photo']['image']->renderError() ?>
        <?= $form['photo']['image'] ?>
      </fieldset>  
      <fieldset>
        <?= $form['contests']->renderLabel() ?>
        <?= $form['contests']->renderError() ?>
        <?= $form['contests'] ?>
      </fieldset>
    <? endif; ?>    
    <fieldset>
      <? if (!$is_new_form): ?>
        <? $recipe = $form->getObject() ?>
        <fieldset>
          <p>
            Your recipe has been uploaded under <?= $recipe->getFirstCategory()->getParent()->getName() ?> / <?= $recipe->getFirstCategory()->getName() ?>
          </p>  
          <p>
            <a href="<?= getUrl($recipe) ?>" title="<?= $recipe->getName() ?>">View your recipe</a>
          </p>
        </fieldset> 
      <? endif; ?>      
      <?= $form->renderHiddenFields(false) ?>
      <span class="ml180"><span class="purple">*</span> are required fields</span> 
      <input type="submit" value="Save" class="btn-grey28" onclick="window.location.hash = 'saved'"/>
      <? if ($is_new_form): ?>
        <a title="Cancel" class="cta-cancel" onclick="if(confirm('Are you sure you want to cancel? Your recipe data will be lost and your recipe will not be saved.')){javascript:location.reload(true);}">Cancel</a>
      <? else: ?>
        <a title="Cancel" class="cta-cancel" onclick="if(confirm('Are you sure you want to cancel? Your recipe data will be lost and your recipe will not be saved.')){javascript:location.href='<?= getUrl($form->getObject()) ?>';}">Cancel</a>
      <? endif; ?>
    </fieldset>

  </form>
</div><!-- /.article -->
<div class="sidebar"></div>
<div class="clear"></div>