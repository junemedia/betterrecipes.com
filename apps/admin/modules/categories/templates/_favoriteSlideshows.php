<script>
  $(document).ready(function(){
    //Sortable Weighted Items
    $("#sortableSlideshows").sortable();

    //Delete Recipe Item
    $(".deleteSlideshow").click(function(){
      var answer = confirm("Are you sure you want to delete this item?");
      if (answer){
        var itemId = $(this).attr("id").replace('delete', '');
        $("#slideshows").load('<?= url_for('categories/deleteFavSlideshow') ?>', { itemId: itemId, overrideId : <?= $overrideId ?> });
      }
    });
  });
</script>
<span><?= !empty($errorSlideshow) ? "$errorSlideshow" : "" ?></span>
<? if (count($weightedSlideshows) > 0): ?>
  <ul class="sortableNums">
    <? foreach ($weightedSlideshows as $i => $w): ?>
      <li><span class="num"><?= $i + 1 ?>.</span></li>
    <? endforeach; ?>    
  </ul>
  <ul id="<?= (count($weightedSlideshows) > 1) ? "sortableSlideshows" : "" ?>" class="items">
    <? foreach ($weightedSlideshows as $w): ?>
      <li>
        <input type="hidden" name="slideshow_ids[]" value="<?= $w->getId() ?>" />
        <span class="data"><?= $w->getName() ?></span>
        <a href="" id="delete<?= $w->getId() ?>" class="deleteSlideshow"><span class="deleteWeightedItem"></span></a>
      </li>
    <? endforeach; ?>        
  </ul>
<? endif; ?>