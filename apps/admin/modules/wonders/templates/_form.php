<? $wonder = $form->getObject() ?>

<script>
  $(document).ready(function(){
    $("#is_active_chkbox").change(function(){
      if($(this).attr("checked")){
        $("#wonders_active").val(1);
      } else {
        $("#wonders_active").val(0);
      }
    });  
    
    $("#is_homepage_featured_chkbox").change(function(){
      if($(this).attr("checked")){
        $("#wonders_homepage_featured").val(1);
      } else {
        $("#wonders_homepage_featured").val(0);
      }
    });  
      
  });
</script>

<form action="<?= url_for('wonders/' . ($wonder->isNew() ? 'create' : 'update') . (!$wonder->isNew() ? '?id=' . $wonder->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
<? //var_dump($form); ?>

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
	        <?= $form['slot_one_title']->renderError() ?>
	        <?= $form['slot_one_title']->renderLabel() ?>      
	        <?= $form['slot_one_title'] ?>
	      </div>
	      
	      <div class="field small">
	        <?= $form['slot_one_url']->renderError() ?>
	        <?= $form['slot_one_url']->renderLabel() ?>      
	        <?= $form['slot_one_url'] ?>
	      </div>
	      
	      <div class="field small">
	        <?= $form['slot_one_img']->renderError() ?>
	        <?= $form['slot_one_img']->renderLabel() ?>      
	        <?= $form['slot_one_img'] ?>
	        <? if ( $wonder->getSlotOneImg() != '' ): ?>
	        	<a href="<?= $wonder->getImgSrc('one'); ?>" target="_blank">View Existing Image</a>
	        <? endif; ?>
	      </div>
	      
	      <hr style="margin:20px 0;" />
	      
	      <div class="field small">
	        <?= $form['slot_two_title']->renderError() ?>
	        <?= $form['slot_two_title']->renderLabel() ?>      
	        <?= $form['slot_two_title'] ?>
	      </div>
	      
	      <div class="field small">
	        <?= $form['slot_two_url']->renderError() ?>
	        <?= $form['slot_two_url']->renderLabel() ?>      
	        <?= $form['slot_two_url'] ?>
	      </div>
	      
	      <div class="field small">
	        <?= $form['slot_two_img']->renderError() ?>
	        <?= $form['slot_two_img']->renderLabel() ?>      
	        <?= $form['slot_two_img'] ?>
	        <? if ( $wonder->getSlotTwoImg() != '' ): ?>
	        	<a href="<?= $wonder->getImgSrc('two'); ?>" target="_blank">View Existing Image</a>
	        <? endif; ?>
	      </div>
	      
	      <hr style="margin:20px 0;" />
	      
	      <div class="field small">
	        <?= $form['slot_three_title']->renderError() ?>
	        <?= $form['slot_three_title']->renderLabel() ?>      
	        <?= $form['slot_three_title'] ?>
	      </div>
	      
	      <div class="field small">
	        <?= $form['slot_three_url']->renderError() ?>
	        <?= $form['slot_three_url']->renderLabel() ?>      
	        <?= $form['slot_three_url'] ?>
	      </div>
	      
	      <div class="field small">
	        <?= $form['slot_three_img']->renderError() ?>
	        <?= $form['slot_three_img']->renderLabel() ?>      
	        <?= $form['slot_three_img'] ?>
	        <? if ( $wonder->getSlotThreeImg() != '' ): ?>
	        	<a href="<?= $wonder->getImgSrc('three'); ?>" target="_blank">View Existing Image</a>
	        <? endif; ?>
	      </div>
	      
	      <hr style="margin:20px 0;" />
	      
	      <div class="field small">
	        <?= $form['slot_four_title']->renderError() ?>
	        <?= $form['slot_four_title']->renderLabel() ?>      
	        <?= $form['slot_four_title'] ?>
	      </div>
	      
	      <div class="field small">
	        <?= $form['slot_four_url']->renderError() ?>
	        <?= $form['slot_four_url']->renderLabel() ?>      
	        <?= $form['slot_four_url'] ?>
	      </div>
	      
	      <div class="field small">
	        <?= $form['slot_four_img']->renderError() ?>
	        <?= $form['slot_four_img']->renderLabel() ?>      
	        <?= $form['slot_four_img'] ?>
	        <? if ( $wonder->getSlotFourImg() != '' ): ?>
	        	<a href="<?= $wonder->getImgSrc('four'); ?>" target="_blank">View Existing Image</a>
	        <? endif; ?>
	      </div>
	      
	      <hr style="margin:20px 0;" />
	      
	      <div class="field small">
	        <?= $form['slot_five_title']->renderError() ?>
	        <?= $form['slot_five_title']->renderLabel() ?>      
	        <?= $form['slot_five_title'] ?>
	      </div>
	      
	      <div class="field small">
	        <?= $form['slot_five_url']->renderError() ?>
	        <?= $form['slot_five_url']->renderLabel() ?>      
	        <?= $form['slot_five_url'] ?>
	      </div>
	      
	      <div class="field small">
	        <?= $form['slot_five_img']->renderError() ?>
	        <?= $form['slot_five_img']->renderLabel() ?>      
	        <?= $form['slot_five_img'] ?>
	        <? if ( $wonder->getSlotFiveImg() != '' ): ?>
	        	<a href="<?= $wonder->getImgSrc('five'); ?>" target="_blank">View Existing Image</a>
	        <? endif; ?>
	      </div>
	      
	      <hr style="margin:20px 0;" />
	      
	      <div class="field small">
	        <?= $form['active']->renderError() ?>
	        <?= $form['active']->renderLabel() ?>      
	        <?= $form['active'] ?>
	        <input type="checkbox" id="is_active_chkbox" name="is_active_chkbox"<? if ($form['active']->getValue() == 1): ?> checked<? endif; ?> >
	      </div>
	      
	      <div class="field small">
	        <?= $form['homepage_featured']->renderError() ?>
	        <?= $form['homepage_featured']->renderLabel() ?>      
	        <?= $form['homepage_featured'] ?>
	        <input type="checkbox" id="is_homepage_featured_chkbox" name="is_homepage_featured_chkbox"<? if ($form['homepage_featured']->getValue() == 1): ?> checked<? endif; ?> >
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