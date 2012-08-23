<script>
  $(document).ready(function() {
    reloadJsVars();
    $("#feature_on_hp.unfeatured").bind("click", function(){
      var missing_photos = <?= sizeof($pollOptions) ?> - $(".has-image").length;
      if(missing_photos == 0){
        if(confirm("Are you sure that you want to feature this poll on the home page")){
          $.get("<?= url_for('@poll_feature_hp?id=' . $poll->getId()) ?>", function(){$("#feature_on_hp").removeClass("unfeatured").addClass("featured").unbind("click").val("Featured On Homepage")});
        }
      } else {
        message = missing_photos + " poll-option image" + (missing_photos == 1 ? ' is' : 's are') + " missing. Please complete missing the image"  + (missing_photos == 1 ? '' : 's') + " and try again.";
        alert(message);
      }
    });
    
    $('#pollActivation').bind('click', function() {
    	if ( $(this).hasClass('poll_activate') ) {
    		$.post('/admin/polls/toggleActivation', { id: $("#poll_id").val() , active: 1 });
    		$(this).removeClass('poll_activate');
    		$(this).addClass('poll_deactivate');
    		$(this).val('Deactivate Poll');
    	} else {
    		$.post('/admin/polls/toggleActivation', { id: $("#poll_id").val() , active: 0 });
    		$(this).removeClass('poll_deactivate');
    		$(this).addClass('poll_activate');
    		$(this).val('Activate Poll');
    	}
    });
    
  }); 
  
  function loadAutoComplete(obj) {
    var get_recipe_url = "<?= url_for('@poll_get_recipe?id=recipe_id') ?>";
    $(obj).find(".recipe-selector").bind("click", 
    function() {
      if($(this).val() == "Start typing recipe title"){
        $(this).val("");
      }
    }).autocomplete({
      "source": function( request, response ) {
        $.ajax({
          "url": "<?= url_for('@poll_search_recipe') ?>",
          "dataType": "json",
          "data": { "term": request.term },
          "success": function( data ) {
            response( $.map( data, function( item ) {
              return {
                "id": item.id,
                "value": item.name
              }
            }));
          }
        });
      },
      "minLength": 2,
      "select": function( event, ui ) {
        $(obj).find(".recipe-data").load(get_recipe_url.replace("recipe_id", ui.item.id));
      }
    });
  }

  function reloadJsVars() {
    $("a.edit-btn").each(function(){
      $(this).bind("click", function(){ 
        $(".selected").removeClass("selected");
        $("tr.edit").hide();
        tr_elm = $(this).parent().parent();
        tr_elm.addClass("selected");
        tr_edit_elm = tr_elm.next(".edit")
        loadAutoComplete (tr_edit_elm);
        tr_edit_elm.slideDown();
        $("a.cancel-btn").hide();
        $("a.edit-btn").show();
        $(this).hide().parent().find("a.cancel-btn").show();
      });
    })
    $("a.cancel-btn").each(function(){
      $(this).bind("click", function(){ 
        $(".selected").removeClass("selected");
        $("a.cancel-btn").hide();
        $("a.edit-btn").show();
        $("tr.edit").hide();
      });
    });
  }

  function updateOptions(obj) {
    var update_options_url = "<?= url_for('@poll_detail_update?id=recipe_id') ?>";
    $("#options_container").load(update_options_url.replace("recipe_id", $("#poll_id").val()), 
    {
      "id":$("#poll_id").val(),
      "option_id": $(obj).closest("td").find(".option-id").val(),
      "recipe_id": $(obj).parent().find(".recipe-id").val(),
      "photo_id": $("input:checked").length > 0 ? $("input:checked").val() : ""
    });
  }
    
  function selectImage(obj){
    $("input:checked").each(function(){
      if(this != obj){
        $(this).removeAttr("checked");
      }
    });
  } 
  
  function editTitle(obj) {
  	$(obj).parent().find('div').show();
  }
  
  function updateTitle(obj, option_id, id) {
  	$('#options_container').load(
								'/admin/polls/editOptionTitle',
								{ option_id: option_id, title:$(obj).parent().find('.option_title').val(), id: id }
	);
  }
  
</script>



<div id="mainHeading">
  <h1><?= $poll->getPollTitle() ?> (<?= $poll->getTotalVotes() ?> Vote<? if ($poll->getTotalVotes() > 1): ?>s<? endif; ?>)</h1>
  <a href="<?= url_for("@polls_list") ?>">Back to Polls</a>
  <input type="button" class="gray-btn <? if ($hp_featured): ?>featured <? else: ?>unfeatured<? endif; ?>" id="feature_on_hp" value="Feature On Homepage"/> 
  <? if ($poll->getActive() == 0): ?>
  	<input type="button" style="color: #FF0000; float:right; font-weight:bolder; margin: -17px 100px 0 0;" class="gray-btn poll_activate" id="pollActivation"  value="Activate Poll" />
  <? else: ?>
  	<input type="button" style="color: #FF0000; float:right; font-weight:bolder; margin: -17px 100px 0 0;" class="gray-btn poll_deactivate" id="pollActivation"  value="Deactivate Poll" />
  <? endif; ?>
</div>
<div id="options_container">
  <? include_partial('options', compact('poll', 'pollOptions')) ?>
</div>
