<script>
  $(document).ready(function(){
    $("#editWinnerForm").submit(function(){      
      //Get Form Elements
      //var $form = $(this),
      //contestPeriodId = $form.find('input[name="contestPeriodId"]').val(),
      //recipeId = $form.find('input[name="recipeId"]').val(),
      //url = $form.attr('action');
      //$("#contestWinners").load(url, { contestPeriodId:contestPeriodId, recipeId: recipeId, contestId:<? //= $contestId  ?>, winnerType: '<? //= (!empty($winnerType)) ? $winnerType : "";  ?>' });
      //Close Modal Box 
      $("#edit").dialog('close');
      
    }); 
    
    //Autocomplete
    $("#contestRecipeName").autocomplete({
      minlength: 0,
      source: function (request, response ){
        $.get('<?= url_for('contests/autocomplete') ?>', { textField : request.term, contestId: <?= $contestId ?> }, function(data){ 
          response($.map(data, function(item){                  
            return {
              label: item.name,
              value: item.id
            }
          })) }, "json");
      }, 
      select: function(event, ui){
        $("#contestRecipeName").val(ui.item.label);
        $("#recipeId").val(ui.item.value);
        return false;
      }
    }); 
    
    $("#cancelEdit").click(function(){
      $("#edit").dialog('close');
    });
    
    //Set values of automcomplete field
    //
    //Set Starting Value
    var startVal = '<?= !empty($contestWinner) ? addcslashes($contestWinner->getRecipe()->getName(), '\\\'') : 'Search By Recipe Name' ?>';
    $("#contestRecipeName").val(startVal);

    //Removes text on focus for textfield
    $("#contestRecipeName").focus(function(){
      if($(this).val() == startVal)
        $(this).val('');
    });
    //Replaces textfield with value if still empty
    $("#contestRecipeName").blur(function(){
      if ($(this).val() == '')
        $(this).val(startVal);
    });

  });
</script>

<form method="post" action="<?= url_for('contests/editWinner') ?>" id="editWinnerForm" >
  <input type="hidden" name="contestPeriodId" value="<?= $cpId ?>" />
  <input type="hidden" id="recipeId" name="recipeId" value="<?= !empty($contestWinner) ? $contestWinner->getRecipe()->getId() : ''; ?>"/>
  <input type="hidden" id="contestId" name="contestId" value="<?= $contestId ?>"/>
  <input type="hidden" id="winnerType" name="winnerType" value="<?= $winnerType ?>"/>
  <input type="hidden" id="winnerBlogId" name="winnerBlogId" value="<?= !empty($contestWinner) ? $contestWinner->getUser()->getBlogId() : '';?>"/>
  <input type="text" id="contestRecipeName" name="recipeName" value="<?= !empty($contestWinner) ? $contestWinner->getRecipe()->getName() : '' ?> "/>
  <div class="action small">
    <a href="javascript:;" id="cancelEdit">Cancel</a>
    &nbsp;&nbsp;or&nbsp;&nbsp;
    <input type="submit" class="btn-grey28" id="submitUser" value="Save" />
  </div>
</form>
