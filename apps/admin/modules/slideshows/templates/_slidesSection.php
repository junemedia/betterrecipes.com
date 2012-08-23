<script>  
  $(function(){
    
    //Sorting Slides
    $("#sortable").sortable();
    
    //Delete a Slide
    $(".delete").click(function(){
      var answer = confirm("Are you sure you want to delete this slide?");
      if (answer) {
        var recipeId = $(this).attr("id").replace('delete', '');     
        $("#slidesSection").load('<?= url_for('slideshows/deleteSlide') ?>', { recipeId: recipeId, slideshowPhotoId: <?= is_null($slideshowPhotoId) ? 0 : $slideshowPhotoId ?>, slideshowId: <?= $slideshowId ?> });
      }   
      return false;
    });
    
    //Set Slideshow Primary Photo
    $(".primaryPhoto").click(function(){
      var slideId = $(this).attr("id").replace('photo', '');
      $("#slidesSection").load('<?= url_for('slideshows/updateSlideshowPhoto') ?>', { slideId: slideId, slideshowId: <?= $slideshowId ?> });
      return false;
    });
   
  });
</script>
<form method="post" id="submitSlides" action="<?= url_for('slideshows/slidesUpdate?slideshow_id=' . $slideshowId) ?>">
  <span id="error"><?= !empty($error) ? $error : ""; ?><?= ($sf_params->get('slide_error')) ? "Please enter a valid slide title and description" : ""; ?></span>

  <ul id="<?= count($slides) > 1 ? "sortable" : "" ?>" class="slides">
    <? foreach ($slides as $s): ?>
      <li>
        <a href="" id="delete<?= $s->getId() ?>" class="delete"><span class="deleteSlide"></span></a>
        <input type="hidden" name="slides_ids[]" value="<?= $s->getId() ?>" />
        <? if (is_null($slide_img = $s->getImgSrc())): ?>
          <div class="slides-no-image">NO IMAGE</div>
        <? else: ?>
          <img src="<?= $slide_img ?>" alt="<?= $s->getName() ?>"/>
        <? endif; ?>
        <div class="title"><?= Utilities::truncateHtml($s->getName(), '36') ?></div>
        <? if ($slideshowPhotoId == $s->getMediumId()) { ?>
          <span class="primaryPhoto">Set Primary Photo</span>
        <? } else { ?>
          <a href="" id="photo<?= $s->getId() ?>" class="primaryPhoto" >Set Primary Photo</a>
        <? } ?>
        <a href="" id="<?= $s->getId() ?>" class="editSlide" >Edit</a>
      </li>    
    <? endforeach; ?>
  </ul>
  <div class="long">
    <div class="action">
      <a href="<?php echo url_for('slideshows/index') ?>">Cancel</a>
      &nbsp;&nbsp;or&nbsp;&nbsp;
      <input type="submit" class="btn-grey28" value="Save" />
    </div>
  </div>
</form>