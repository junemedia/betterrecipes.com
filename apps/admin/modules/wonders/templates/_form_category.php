<? $wonder = $form->getObject() ?>
<script>
	$(document).ready(function(){
	    $("#is_active_chkbox").change(function(){
	      if($(this).attr("checked")){
	        $("#category_wonders_is_active").val(1);
	      } else {
	        $("#category_wonders_is_active").val(0);
	      }
	    });        
  });
  function updateSubcat(type, catid){
  	switch (type) {
	 	case 1 :
	 		$("#category_wonders_slot_one_subcat_one").load("<?= url_for('wonders/updateSubcategory') ?>", {catid:catid});
	 		$("#category_wonders_slot_one_subcat_two").load("<?= url_for('wonders/updateSubcategory') ?>", {catid:catid});
	 	break; 
	 	case 2 :
	 		$("#category_wonders_slot_two_subcat_one").load("<?= url_for('wonders/updateSubcategory') ?>", {catid:catid});
	 		$("#category_wonders_slot_two_subcat_two").load("<?= url_for('wonders/updateSubcategory') ?>", {catid:catid});
	 	break; 
	 	case 3 :
	 		$("#category_wonders_slot_three_subcat_one").load("<?= url_for('wonders/updateSubcategory') ?>", {catid:catid});
	 		$("#category_wonders_slot_three_subcat_two").load("<?= url_for('wonders/updateSubcategory') ?>", {catid:catid});
	 	break; 
	 	case 4 :
	 		$("#category_wonders_slot_four_subcat_one").load("<?= url_for('wonders/updateSubcategory') ?>", {catid:catid});
	 		$("#category_wonders_slot_four_subcat_two").load("<?= url_for('wonders/updateSubcategory') ?>", {catid:catid});
	 	break; 	
  	}
    
  }
  
</script>

<form action="<?= url_for('wonders/' . ($wonder->isNew() ? 'create_category' : 'update_category') . (!$wonder->isNew() ? '?id=' . $wonder->getId() : '')) ?>" method="post">

<? if (!$wonder->isNew()): ?>
    <input type="hidden" name="sf_method" value="put" />
<? endif; ?>

<div id="articleContainer" class="container small edit">
  	<h2>General Details</h2>	
  	 <?php echo $form->renderHiddenFields(false) ?>
    <?php echo $form->renderGlobalErrors() ?>
    
    <div id="articles" class="fields small">
    
          <div class="field small">
	        <?= $form['title']->renderError() ?>
	        <?= $form['title']->renderLabel() ?>      
	        <?= $form['title'] ?>
	      </div>
	      
	      <hr style="margin:20px 0;" />
	      
	      <div class="field small">
	        <?= $form['slot_one_cat_id']->renderError() ?>
	        <?= $form['slot_one_cat_id']->renderLabel() ?>      
	        <?= $form['slot_one_cat_id'] ?>
	      </div>
	      
	      <div class="field small">
	        <?= $form['slot_one_subcat_one']->renderError() ?>
	        <?= $form['slot_one_subcat_one']->renderLabel() ?>      
	        <?= $form['slot_one_subcat_one'] ?>
	      </div>
	      
	      <div class="field small">
	        <?= $form['slot_one_subcat_two']->renderError() ?>
	        <?= $form['slot_one_subcat_two']->renderLabel() ?>      
	        <?= $form['slot_one_subcat_two'] ?>
	      </div>
	      
	      <div class="field small">
	        <?= $form['slot_one_description']->renderError() ?>
	        <?= $form['slot_one_description']->renderLabel() ?>      
	        <?= $form['slot_one_description'] ?>
	      </div>
	      
	      <hr style="margin:20px 0;" />
	      
	      <div class="field small">
	        <?= $form['slot_two_cat_id']->renderError() ?>
	        <?= $form['slot_two_cat_id']->renderLabel() ?>      
	        <?= $form['slot_two_cat_id'] ?>
	      </div>
	      
	      <div class="field small">
	        <?= $form['slot_two_subcat_one']->renderError() ?>
	        <?= $form['slot_two_subcat_one']->renderLabel() ?>      
	        <?= $form['slot_two_subcat_one'] ?>
	      </div>
	      
	      <div class="field small">
	        <?= $form['slot_two_subcat_two']->renderError() ?>
	        <?= $form['slot_two_subcat_two']->renderLabel() ?>      
	        <?= $form['slot_two_subcat_two'] ?>
	      </div>
	      
	      <div class="field small">
	        <?= $form['slot_two_description']->renderError() ?>
	        <?= $form['slot_two_description']->renderLabel() ?>      
	        <?= $form['slot_two_description'] ?>
	      </div>
	      
	      <hr style="margin:20px 0;" />
	      
	      <div class="field small">
	        <?= $form['slot_three_cat_id']->renderError() ?>
	        <?= $form['slot_three_cat_id']->renderLabel() ?>      
	        <?= $form['slot_three_cat_id'] ?>
	      </div>
	      
	      <div class="field small">
	        <?= $form['slot_three_subcat_one']->renderError() ?>
	        <?= $form['slot_three_subcat_one']->renderLabel() ?>      
	        <?= $form['slot_three_subcat_one'] ?>
	      </div>
	      
	      <div class="field small">
	        <?= $form['slot_three_subcat_two']->renderError() ?>
	        <?= $form['slot_three_subcat_two']->renderLabel() ?>      
	        <?= $form['slot_three_subcat_two'] ?>
	      </div>
	      
	      <div class="field small">
	        <?= $form['slot_three_description']->renderError() ?>
	        <?= $form['slot_three_description']->renderLabel() ?>      
	        <?= $form['slot_three_description'] ?>
	      </div>
	      
	      <hr style="margin:20px 0;" />
	      
	      <div class="field small">
	        <?= $form['slot_four_cat_id']->renderError() ?>
	        <?= $form['slot_four_cat_id']->renderLabel() ?>      
	        <?= $form['slot_four_cat_id'] ?>
	      </div>
	      
	      <div class="field small">
	        <?= $form['slot_four_subcat_one']->renderError() ?>
	        <?= $form['slot_four_subcat_one']->renderLabel() ?>      
	        <?= $form['slot_four_subcat_one'] ?>
	      </div>
	      
	      <div class="field small">
	        <?= $form['slot_four_subcat_two']->renderError() ?>
	        <?= $form['slot_four_subcat_two']->renderLabel() ?>      
	        <?= $form['slot_four_subcat_two'] ?>
	      </div>
	      
	      <div class="field small">
	        <?= $form['slot_four_description']->renderError() ?>
	        <?= $form['slot_four_description']->renderLabel() ?>      
	        <?= $form['slot_four_description'] ?>
	      </div>
	      
	      <hr style="margin:20px 0;" />
	      
	      <div class="field small">
	        <?= $form['is_active']->renderError() ?>
	        <?= $form['is_active']->renderLabel() ?>      
	        <?= $form['is_active'] ?>
	        <input type="checkbox" id="is_active_chkbox" name="is_active_chkbox"<? if ($form['is_active']->getValue() == 1): ?> checked<? endif; ?> >
	      </div>
    
    	  <div class="field small">
	        <div class="action small flri">
	          <a href="<?php echo url_for('wonders/index') ?>">Cancel</a>
	          &nbsp;&nbsp;or&nbsp;&nbsp;
	          <input type="submit" class="submit btn-grey28" value="Save" />
	        </div>
	      </div>

	      
  	</div><!-- //articles -->
  	
  </div><!-- //articleContainer -->

</form>