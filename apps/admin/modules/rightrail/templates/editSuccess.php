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
      $("#override_start_date").val($("#startDate").val());
      //$.post('<?=url_for('rightrail/autocomplete')?>', function(data){ debug(data); }, "json");
    });
    $("#endDate.datepicker").change(function(){
      $("#override_end_date").val($("#endDate").val());
    });
  
    //Autocomplete
    $("#addRecipeInput").autocomplete({
          minlength: 3,
          source: function (request, response ){
              $.get('<?=url_for('rightrail/autocomplete')?>', { textField : request.term }, function(data){ 
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
    
    //Add Recipe
    $("#addRecipeBtn").click(function(){
      var recipes = <?= count($weightedItems) ?>;
      var totalRecipes = <?= $totalRecipes ?>;
      if (recipes >= totalRecipes){
        alert("You must increase the number total number of recipes shown on each page to add a new recipe.");
      } else {
       $("#items").load('<?=url_for('rightrail/addRecipe')?>', { overrideId : <?= $form->getObject()->getId()?>, itemId : $("#addRecipeInputId").val(), rank : recipes});
      }      
    });        
    
  }); 
</script>
<div id="mainHeading">
  <h1>Right Rail</h1>
</div>
<div id="rightrailEdit" class="container">
  <div id="subHeading">
    <h2 id="test" >Top Recipes</h2>
  </div> 
  <form id="overrideModule" method="post" action="<?=url_for('rightrail/update?id='.$form->getObject()->getId()) ?>">
    <?= $form->renderHiddenFields() ?>
    <?= $form->renderGlobalErrors() ?>
    <?= link_to('Delete', 'rightrail/delete?id='.$form->getObject()->getId(), array('method' => 'delete', 'confirm' => 'Are you sure?', 'id' => 'deleteRecipe')) ?>
    <span id="total">Total Recipes Shown on Page:</span>
    <select id="totalRecipes" name="totalRecipes" class="label">
      <? for ($i=0; $i <=15; $i++): ?>
        <option value="<?=$i?>" <? if($totalRecipes == $i) echo "Selected"?>><?=$i?></option>
      <? endfor; ?>
    </select>       
    <div id="date">
      <span class="label">Show the recipes below from</span>
      <input type="text" id="startDate" class="datepicker" name="startDate" readonly="readonly" value="<?= date('m/d/y', strtotime($form->getObject()->getStartDate()))?>" />
      <span class="label to"> to </span>
      <input type="text" id="endDate" class="datepicker" name="endDate" readonly="readonly"value="<?= date('m/d/y', strtotime($form->getObject()->getEndDate()))?>" />
    </div>
    <div id="addRecipe">      
      <label>Add Recipe</label>
      <input type="hidden" id="addRecipeInputId" name="addRecipeInputId" value="-1"/>
      <input type="text" id="addRecipeInput" name="addRecipeInput" />
      <input type="button" class="btn-grey28" id="addRecipeBtn" name="addRecipeBtn" value="Add" />
    </div>
    <div id="items">
      <? include_partial('recipes', array('weightedItems' => $weightedItems))?>
    </div>
    
    <div class="action">
    <a href="<?php echo url_for('rightrail/index') ?>">Cancel</a>
    &nbsp;&nbsp;or&nbsp;&nbsp;
    <input type="submit" class="btn-grey28" id="save" name="save" value="Save" />
  </div>
    
  </form>

</div>
  
