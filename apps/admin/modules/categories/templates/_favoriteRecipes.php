<script>
  $(document).ready(function(){
    //Sortable Weighted Items
    $("#sortable").sortable();

    //Delete Recipe Item
    $(".delete").click(function(){
      var answer = confirm("Are you sure you want to delete this item?");
      if (answer){
        var itemId = $(this).attr("id").replace('delete', '');
        $("#items").load('<?=url_for('categories/deleteFavRecipe')?>', { itemId: itemId, overrideId : <?=$overrideId?> });
      }
    });
  });
</script>
<span><?= !empty($error) ? "$error" : "" ?></span>
  <? if (count($weightedItems) > 0): ?>
      <ul  class="sortableNums">
        <? foreach($weightedItems as $i => $w): ?>
          <li><span class="num"><?=$i+1?>.</span></li>
        <? endforeach; ?>    
      </ul>
      <ul id="<?= (count($weightedItems) > 1) ? "sortable" : "" ?>" class="items">
        <? foreach($weightedItems as $w): ?>
          <li>
            <input type="hidden" name="item_ids[]" value="<?= $w->getId() ?>" />
            <span class="data"><?= $w->getName() ?></span>
            <a href="" id="delete<?= $w->getId()?>" class="delete"><span class="deleteWeightedItem"></span></a>
          </li>
        <? endforeach; ?>        
      </ul>
 <? endif; ?>