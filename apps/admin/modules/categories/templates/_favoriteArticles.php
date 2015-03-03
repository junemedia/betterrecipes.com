<script>
  $(document).ready(function(){
    //Sortable Weighted Items
    $("#sortableArticles").sortable();

    //Delete Recipe Item
    $(".deleteArticle").click(function(){
      var answer = confirm("Are you sure you want to delete this item?");
      if (answer){
        var itemId = $(this).attr("id").replace('delete', '');
        $("#articles").load('<?= url_for('categories/deleteFavArticle') ?>', { itemId: itemId, overrideId : <?= $overrideId ?> });
      }
    });
  });
</script>
<span><?= !empty($errorArticle) ? "$errorArticle" : "" ?></span>
<? if (count($weightedArticles) > 0): ?>
  <ul class="sortableNums">
    <? foreach ($weightedArticles as $i => $w): ?>
      <li><span class="num"><?= $i + 1 ?>.</span></li>
    <? endforeach; ?>    
  </ul>
  <ul id="<?= (count($weightedArticles) > 1) ? "sortableArticles" : "" ?>" class="items">
    <? foreach ($weightedArticles as $w): ?>
      <li>
        <input type="hidden" name="article_ids[]" value="<?= $w->getId() ?>" />
        <span class="data"><?= $w->getName() ?></span>
        <a href="" id="delete<?= $w->getId() ?>" class="deleteArticle"><span class="deleteWeightedItem"></span></a>
      </li>
    <? endforeach; ?>        
  </ul>
<? endif; ?>