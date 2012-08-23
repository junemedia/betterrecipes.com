<? if ($edit == false): ?>
  <div id="slidesSection">
    <ul class="slides">
      <? if (isset($slides)): ?>
        <? foreach ($slides as $s): ?>
          <li class="noSort">
            <? if (is_null($slide_img = $s->getImgSrc())): ?>
              <div class="slides-no-image">NO IMAGE</div>
            <? else: ?>
              <img src="<?= $slide_img ?>" alt="<?= $s->getName() ?>"/>
            <? endif; ?>
            <div class="title"><?= Utilities::truncateHtml($s->getName(), '36') ?></div>
          </li>    
        <? endforeach; ?>
      <? endif; ?>
    </ul>
  </div>
<? endif; ?>
<script>

  $(document).ready(function(){  
    //Textfield placeholders
    var placeholders = { recipeName:"Get Recipe By ID" };
    //Set values of search textfields 
    $.each(placeholders, function(key, val) { 
      //Removes text on focus for textfield
      $('input[name='+key+']').focus(function(){
        if($(this).val() == val)
          $(this).val('');
      });
      //Replaces textfield with value if still empty
      $('input[name='+key+']').blur(function(){
        if ($(this).val() == '')
          $(this).val(val);
      });
    });    
    
    //Autocomplete
    $("#recipeName").autocomplete({
      minlength: 3,
      source: function (request, response ){
        $.get('<?= url_for('slideshows/autocomplete') ?>', { textField : request.term }, function(data){ 
          response($.map(data, function(item){                  
            return {
              label: item.name,
              value: item.id
            }
          })) }, "json");
      }, 
      select: function(event, ui){
        $("#recipeName").val(ui.item.label);
        $("#addRecipeInputId").val(ui.item.value);
        return false;
      }
    }); 
    
    //Add A New Slide
    $("#addNewSlide").submit(function(){      
      //Get Form Elements
      var $form = $("#addNewSlide"),
      slideshowId = <?= $slideshowId ?>,
      recipeId = $form.find('#addRecipeInputId').val();
      //Ajax call to sorted slides section
      $("#slidesSection").load('<?= url_for('slideshows/addSlide') ?>', { recipeId: recipeId, slideshowPhotoId: <?= is_null($slideshow->getPhotoId()) ? 0 : $slideshow->getPhotoId() ?>, slideshowId: slideshowId });
      return false;
    });  
   
    //Editing Slides Modal Box    
    $(".editSlide").click(function(){
      $("#edit").load("<?= url_for('slideshows/slideInfo') ?>", { slideId: $(this).attr("id"), slideshowId: <?= $slideshowId ?> });      
      $("#edit").dialog({ autoOpen: false, title:"Edit Slide", height:200, modal:true});
      $("#edit").css("display", "block");      
      $("#edit").dialog('open');
      $("#edit").css({"width" : "540px", "height" : "270px"});
      $(".ui-dialog").css({"width" : "600px", "height" : "350px", "position" : "fixed", "margin-top" : "-150px"});     
      return false;
    });

    $("#cancelEdit").click(function(){
      $("#edit").dialog('close');
      return false;
    });
    
  });	  
</script>
<? if ($edit): ?>
  <div id="slideFilter" class="filterRow">
    <div class="filter"> 
      <form method="post" action="" id="addNewSlide">
        <span>Add a Slide</span>
        <input type="hidden" name="slideshowId" value="<?= $slideshowId ?>"/>
        <input type="hidden" id="addRecipeInputId" name="addRecipeInputId" value="-1"/>
        <input type="text" name="recipeName" id="recipeName" />
        <input type="submit" class="submit" id="submitAddSlide" value="Add"/>
      </form>
    </div>
  </div>
  <div id="slidesSection">
    <? include_partial('slidesSection', array('slides' => $slides, 'slideshowPhotoId' => $slideshow->getPhotoId(), 'slideshowId' => $slideshowId)); ?>
  </div>
  <div id="edit">
    <? include_partial('slidesForm') ?>
  </div>
<? endif; ?>