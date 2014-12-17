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
      $(obj).parents("li").load("<?= url_for('articles/updateActive')?>", {articleId:articleId, active:activeUpdate});      
    else 
      obj.checked = checked;      
  }
</script>

  
  <div id="mainHeading">
  <h1>Article</h1>
  <a href="<?php echo url_for('articles/new') ?>">Add Article</a>
</div>

<!-- Filtering for URL -->
<? $currentFilter = ( $sf_params->has('articleName') ) ? '&articleName='.$sf_params->get('articleName') : ''; ?>
<? $currentFilterSort = $currentFilter; ?>
<? $currentFilterSort .= ( $sf_params->has('sort') ) ? '&sort='.$sf_params->get('sort') : ''; ?>
<? $currentFilterSort .= ( $sf_params->has('sortDir') ) ? '&sortDir='.$sf_params->get('sortDir') : ''; ?>
<!-- End Filtering for URL -->

<!-- Article Filtering -->
<div id="articlesFilter" class="filterRow big"> 
  <div class="filter">
    <form method="get" action="<?= url_for('@articles_index')?>">
      <input type="text" name="articleName" id="articleName" class="filterInput" id="articlesNameInput" value="<?= !empty($articleName) ? $articleName : 'Article Name' ?>"/>
      <input type="submit" class="submit" id="articlesNameSubmit" value="Filter" />
    </form>
  </div>
</div>
<!-- End Article Filtering -->

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

<!-- Article Headings -->
<div id="articlesHeadings" class="headings big row">
  <ul>
    <li><span class="name <? if ($sort == 'name') { echo ($sortDir == 'ASC') ? "asc" : "desc"; } ?>"><?= link_to('Article Name', '@articles_index?page=1'.$currentFilter.'&sort=name&sortDir='.getSortDirection($sf_params->get('sortDir')), 'class=name') ?></span></li>
    <li><span class="author <? if ($sort == 'author') { echo ($sortDir == 'ASC') ? "asc" : "desc"; } ?>"><?= link_to('Author', '@articles_index?page=1'.$currentFilter.'&sort=author&sortDir='.getSortDirection($sf_params->get('sortDir')), 'class=author') ?></span></li>
    <li><span class="dateAdded <? if (($sort == 'date') || (!isset($sort))) { echo ($sortDir == 'ASC' || (!isset($sort))) ? "asc" : "desc"; } ?>"><?= link_to('Date Added', '@articles_index?page=1'.$currentFilter.'&sort=date&sortDir='.getSortDirection($sf_params->get('sortDir')), 'class=dateAdded') ?></span></li>
    <li><span class="sponsor <? if ($sort == 'sponsor') { echo ($sortDir == 'ASC') ? "asc" : "desc"; } ?>"><?= link_to('Sponsor', '@articles_index?page=1'.$currentFilter.'&sort=sponsor&sortDir='.getSortDirection($sf_params->get('sortDir')), 'class=sponsor') ?></span></li>
    <li><span class="active <? if ($sort == 'active') { echo ($sortDir == 'ASC') ? "asc" : "desc"; } ?>"><?= link_to('Active', '@articles_index?page=1'.$currentFilter.'&sort=active&sortDir='.getSortDirection($sf_params->get('sortDir')), 'class=active') ?></span></li>
  </ul>
</div> 
<!-- End Article Headings -->

<!-- Article Results -->
<? $i = 0; ?>
<? foreach ($pager->getResults() as $i => $article): ?>
  <ul id="articlesRows" class="results">
    <li class="row <?= ($i % 2) == 0 ? "even" : "odd"; ?> big" id="<?= $article->getId() ?>">
      <span class="name"><a href="<?= url_for('articles/detail?id=' . $article->getId()) ?>"><?= $article->getName() ?></a></span>
      <span class="author"><?= $article->getUser()->getDisplayName() ?></span>
      <span class="dateAdded"><?= date('m-d-y g:sa', strtotime($article->getCreatedAt())) ?></span>
      <span class="sponsor">
        <? if(is_null($article->getSponsorId())) { ?>
          <a onclick="addSponsor(this, '<?= url_for('articles/addSponsor') ?>')">Add</a>
        <? } else { ?>
          <?= $article->getSponsor()->getName() ?>
        <? } ?>
      </span>
      <span class="active">
        <input type="checkbox" id="active" value="<?= ($article->getIsActive() == 1) ? "1" : "0"; ?>" <?= $article->getIsActive() ? "checked='checked'" : ""; ?> onchange="changeActive(this)" />
      </span>
    </li>
  </ul>
<? endforeach; ?>
<!-- End Article Results -->
  
  <!-- Bottom Pagination -->
<div class="paginationRow">
  <? if ($pager->haveToPaginate()): ?>
    <div class="pagination">
      <div class="pagination_link">
        <?= link_to('<<', '@articles_index?page=' . $pager->getPreviousPage()) ?>
      </div>
      <? $links = $pager->getLinks() ?>
      <? foreach ($links as $page): ?>   
        <div class="pagination_link">
        <?= ($page == $pager->getPage()) ? $page : link_to($page, '@articles_index?page=' . $page)?> 
        </div>
      <? endforeach; ?>
      <div class="pagination_link">
        <?= link_to('>>', '@articles_index?page=' . $pager->getNextPage()) ?>
      </div>
    </div>
<? endif; ?>
</div>
<!-- End Pagination -->
