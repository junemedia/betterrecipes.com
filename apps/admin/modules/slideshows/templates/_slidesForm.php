<script>
  $(document).ready(function(){
    $("#submitEditSlide").click(function(){
      //Get Form Elements
     // var $form = $("#editSlideForm"),
         // slideshowId = $form.find('input[name="slideshowId"]').val(),
          //slideId = $form.find('input[name="slideId"]').val(),
          //slideTitle = $form.find('input[name="slideTitle"]').val(),
          //slideContent = $form.find('textarea[name="slideContent"]').val(), 
          //url = $form.attr('action');
      //var slideshowId = '<?//= !empty($slideshowId) ? $slideshowId : ""; ?>';
      //$("#slidesSection").load( url, { slideshowId:slideshowId, slideId: slideId, slideTitle: slideTitle, slideContent:slideContent });
      //Close Modal Box
      $("#edit").dialog('close');
    });
  });
</script>
<? if (!empty($slideForm)): ?>
  <form method="post" action="<?= url_for('slideshows/editSlide?id='.$slideForm->getObject()->getId())?>" id="editSlideForm" >
    <?= $slideForm->renderHiddenFields(false) ?>
    <?= $slideForm->renderGlobalErrors() ?>
    <?= $slideForm['name']->renderError() ?>
    <?= $slideForm['name']->renderLabel() ?>      
    <?= $slideForm['name'] ?>
    <?= $slideForm['content']->renderError() ?>
    <?= $slideForm['content']->renderLabel() ?>      
    <?= $slideForm['content'] ?>
    <div class="action small">
      <a href="" id="cancelEdit">Cancel</a>
      &nbsp;&nbsp;or&nbsp;&nbsp;
      <input type="submit" class="btn-grey28" id="submitEditSlide" value="Save" />
    </div>
  </form>
<? endif; ?>
