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
    });
    $("#endDate.datepicker").change(function(){
      $("#override_end_date").val($("#endDate").val());
    });
  }) 
</script>
<div id="mainHeading">
  <h1>Right Rail</h1>
</div>

<div id="rightrailEdit" class="container">
  <div id="subHeading">
    <h2>Top Recipes</h2>
  </div> 
  <form id="overrideModule" method="post" action="<?=url_for('rightrail/create')?>">
    <?= $form->renderHiddenFields() ?>
    <?= $form->renderGlobalErrors() ?>
    <span id="total">Total Recipes Shown on Page:</span>
    <select id="totalRecipes" name="totalRecipes" class="label">
      <? for ($i=0; $i <=15; $i++): ?>
        <option value="<?=$i?>" <? if ($i == 5) echo "Selected" ?>><?=$i?></option>
      <? endfor; ?>
    </select>
    
    <div id="date">
      <span class="label">Show the recipes below from</span>
      <input type="text" id="startDate" class="datepicker" name="startDate" readonly="readonly" value="" />
      <span class="label to"> to </span>
      <input type="text" id="endDate" class="datepicker" name="endDate" readonly="readonly"value="" />
    </div>
   
    <div class="action">
    <a href="<?php echo url_for('rightrail/index') ?>">Cancel</a>
    &nbsp;&nbsp;or&nbsp;&nbsp;
    <input type="submit" class="btn-grey28" id="save" value="Save" />
  </div>
    
  </form>

</div>
  
