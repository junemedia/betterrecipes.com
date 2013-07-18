<script>

  function changeActive(obj){
    //Flip checked value 
    var checked = !obj.checked;
    if (checked){
      msg = "Are you sure you would like to make this inactive?";
      activeUpdate = 0;
    } else {
      msg = "Are you sure you would like to make this Active?";
      activeUpdate = 1;
    }
    var article = $(obj).parents("li");
    var articleId = $(obj).parents("li").attr("id");
    
    //Recipe is Active - Change to inactive if user confirms
    var answer = confirm(msg);
    
    if (answer)      
      //Ajax to update active status
      $(obj).parents("li").load("<?= url_for('tips/updateActive')?>", {articleId:articleId, active:activeUpdate});      
    else 
      obj.checked = checked;      
  }
</script>

  
  <div id="mainHeading">
  <h1>Tip</h1>
  <a href="<?php echo url_for('tips/new') ?>">Add Tip</a>
</div>

<!-- Filtering for URL -->
<? $currentFilter = ( $sf_params->has('tipTitle') ) ? '&tipTitle='.$sf_params->get('tipTitle') : ''; ?>
<? $currentFilterSort = $currentFilter; ?>
<? $currentFilterSort .= ( $sf_params->has('sort') ) ? '&sort='.$sf_params->get('sort') : ''; ?>
<? $currentFilterSort .= ( $sf_params->has('sortDir') ) ? '&sortDir='.$sf_params->get('sortDir') : ''; ?>
<!-- End Filtering for URL -->

<!-- Tip Filtering -->
<div id="tipsFilter" class="filterRow big"> 
  <div class="filter">
    <form method="get" action="<?= url_for('@tips_index')?>">
      <input type="text" name="tipTitle" id="tipTitle" class="filterInput" value="<?= !empty($tipTitle) ? $tipTitle : 'Tip Title' ?>"/>
      <input type="submit" class="submit" id="tipTitleSubmit" value="Filter" />
    </form>
  </div>
</div>
<!-- End Tip Filtering -->

<? //Sort Method to change the sorting direction
function getSortDirection($sortDir){
   if (!is_null($sortDir)){
       if ($sortDir == 'ASC')
         return 'DESC';
       else
         return 'ASC';
     } else 
         return "ASC";
   }
?>

<!-- Tip Headings -->
<div id="tipsHeadings" class="headings big row">
  <ul>
    <li><span class="title <? if ($sort == 'title') { echo ($sortDir == 'ASC') ? "asc" : "desc"; } ?>"><?= link_to('Title', '@tips_index?page=1'.$currentFilter.'&sort=title&sortDir='.getSortDirection($sf_params->get('sortDir')), 'class=title') ?></span></li>
    <li><span class="url <? if ($sort == 'url') { echo ($sortDir == 'ASC') ? "asc" : "desc"; } ?>"><?= link_to('Url', '@tips_index?page=1'.$currentFilter.'&sort=url&sortDir='.getSortDirection($sf_params->get('sortDir')), 'class=url') ?></span></li>
  </ul>
</div> 
<!-- End Tip Headings -->

<!-- Tip Results -->
<? $i = 0; ?>
<? foreach ($pager->getResults() as $i => $tip): ?>
  <ul id="tipsRows" class="results">
    <li class="row <?= ($i % 2) == 0 ? "even" : "odd"; ?> big" id="<?= $tip->getId() ?>">
      <span class="title"><a href="<?= url_for('tips/detail?id=' . $tip->getId()) ?>"><?= $tip->getName() ?></a></span>
      <span class="url"><?= $tip->getUser()->getDisplayName() ?></span>
      <span class="active">
        <input type="checkbox" id="active" value="<?= ($tip->getIsActive() == 1) ? "1" : "0"; ?>" <?= $tip->getIsActive() ? "checked='checked'" : ""; ?> onchange="changeActive(this)" />
      </span>
    </li>
  </ul>
<? endforeach; ?>
<!-- End Tip Results -->
  
  <!-- Bottom Pagination -->
<div class="paginationRow">
  <? if ($pager->haveToPaginate()): ?>
    <div class="pagination">
      <div class="pagination_link">
        <?= link_to('<<', '@tips_index?page=' . $pager->getPreviousPage()) ?>
      </div>
      <? $links = $pager->getLinks() ?>
      <? foreach ($links as $page): ?>   
        <div class="pagination_link">
        <?= ($page == $pager->getPage()) ? $page : link_to($page, '@tips_index?page=' . $page)?> 
        </div>
      <? endforeach; ?>
      <div class="pagination_link">
        <?= link_to('>>', '@tips
          _index?page=' . $pager->getNextPage()) ?>
      </div>
    </div>
<? endif; ?>
</div>
<!-- End Pagination -->
