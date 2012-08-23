<? //Filtering Results       ?>
<? $urlParams = '?id=' . $contest->getId() ?>
<? $urlCP = '&cp=' . $contestPeriod->getId() ?>
<? $urlPage = '&page=' . $pager->getPage() ?>
<? $urlParamsPC = $urlParams . $urlPage ?>
<? $urlParamsPage = $urlParams . $urlCP ?>
<? //End Filtering Results       ?>
<script>    
    function contestPeriodChange(obj){
        window.location = '<?= url_for('contests/detail' . $urlParamsPC . '&cp=') ?>' + obj.value;
    }
    function updateContestantStatus(obj){
        if(confirm("Are you sure? This will " + (obj.val()=="1" ? "remove the recipe from" : "add the recipe to") + " the contest")){
            obj.parent().load("<?= url_for('contests/updateContestantStatus') ?>", {contestant_id:obj.parent().parent().attr("id"),status:obj.val()});
        }
    }
    $(document).ready(function(){
        $('[type=checkbox]').each(function() {
            if($(this).val() == 1){
                $(this).attr("checked", "checked");
            } else {
                $(this).removeAttr("checked");
            }
        }); 
    });  
</script>
<? include_partial('global/bread_crumbs', compact('bread_crumbs')) ?>
<div id="mainHeading">
    <h1><?= $contest->getName() ?></h1>
</div>
<!-- Contest Details -->
<div id="contestContainer" class="container small">
    <div id="subHeading">
      <h2>General Details</h2><a href="<?= UrlToolkit::getUrl('@contests_detail', array('slug' => $contest->getSlug(), 'mode' => 'preview')) ?>" title="Preview '<?= $contest->getName() ?>'" target="_blank" class="lp150">Preview "<?= $contest->getName() ?>"</a>
        <? if ($edit == true): ?>
            <form id="recipeSearch" action="<?= url_for('contests/edit?id=' . $contest->getId()) ?>">
                <input type="submit" class="detail btn-grey28" value="Edit" />
            </form>
        <? endif; ?>
    </div>
    <div class="list">
        <ul>
            <li><span class="label">Contest Name</span><span class="data"><?= $contest->getName() ?></span></li>
            <li><span class="label">Contest Description</span><span class="data descript"><?= $contest->getDescription() ?></span></li>
            <li><span class="label descript">Image</span><span class="data img"><img class="contestImage" src="<?= $contest->getImgSrc() ?>" alt="<?= $contest->getName() ?>"/></span></li>
            <li><span class="label">Start Date</span><span class="data"><?= date('m/d/Y', strtotime($contest->getStartDate())) ?></span></li>
            <li><span class="label">End Date</span><span class="data"><?= date('m/d/Y', strtotime($contest->getEndDate())) ?></span></li>
            <li><span class="label">Official Rules</span><span class="data"><?= $contest->getRules() ?></span></li>
            <li><span class="label">Prize</span><span class="data"><?= $contest->getPrize() ?></span></li>
            <li><span class="label">Title Tag</span><span class="data"><?= $contest->getTitleTag() ?></span></li>
            <li><span class="label">Meta Description</span><span class="data"><?= $contest->getSummary() ?></span></li>
            <li><span class="label">Keywords</span><span class="data"><?= $contest->getKeywords() ?></span></li>
        </ul>      
    </div>
</div> 
<!-- End Contest Details -->

<!-- Sponsor Sidebar -->
<div id="recipeSidebarSponsor" class="container sidebar sponsor">
    <div id="subHeading">
        <h3>Sponsor</h3>
        <p class="text">Current Sponsor:</p>
        <? $sponsorId = $contest->getSponsorId(); ?>
        <p id="currentSponsor"><?= isset($sponsorId) ? $contest->getSponsor()->getName() : "None" ?></p>
        <? if ($edit == true): ?>
            <form id="recipeSearch" action="<?= url_for('contests/edit?id=' . $contest->getId()) ?>">
                <input type="submit" class="sidebar btn-grey28" value="Edit" />
            </form>
        <? endif; ?>
    </div>
</div>
<!-- End Sponsor Sidebar -->

<!-- Contest Winners Sidebar -->
<div id="contestWinners" class="container sidebar">
    <? include_partial('winners', compact('allContests', 'contestPeriod', 'offset')) ?>
</div>
<!-- End Contest Winners Sidebar -->

<!-- Recipes in Contest -->
<div id="contestBodyContainer" class="container">
    <div id="subHeading">
        <h2>Recipes Entered In This Contest</h2>  
    </div>
    <div id="contestRecipeHeadings" class="headings row detail">
        <ul>
            <li><span class="name nosort">Recipe Name</span></li>
            <li><span class="rating nosort">Rating</span></li>                
            <li><span class="dateAdded nosort">Date Added</span></li>
            <li><span class="user nosort">Submitted By</span></li>
            <li><span class="nosort status">Active</span></li>
        </ul>
    </div> 
    <div class="contestPaginationRow detail">
        <ul id="contestRecipeRows" class="results detail">
            <? foreach ($pager->getResults() as $i => $r): ?>  
                <li class="row <?= ($i % 2) == 0 ? "even" : "odd"; ?> big" id="<?= $r->getId() ?>">
                    <span class="name"><a href="<?= url_for('recipes/detail?id=' . $r->getRecipe()->getId()) ?>"><?= $r->getRecipe()->getName() ?></a></span>
                    <span class="rating">
                        <div id="backgroundRating">
                            <div id="fillRating" style="width:<?= $r->getRecipe()->getRating() * 85 / 5 ?>px"></div>
                        </div>  
                    </span>
                    <span class="dateAdded"><?= date('m-d-y g:sa', strtotime($r->getRecipe()->getCreatedAt())) ?></span>
                    <span class="user"><?= $r->getUser()->getDisplayName() ?></span>
                    <span class="status">
                        <? if ($edit == true): ?>
                            <input type="checkbox" value="<?= $r->getIsActive() ?>" onchange="updateContestantStatus($(this))">
                        <? else: ?>
                            <?= $r->getIsActive() ?>
                        <? endif; ?>
                    </span>
                </li>   
            <? endforeach; ?>
        </ul> 
    </div>
    <!-- Bottom Pagination -->
    <div class="contestPaginationRow">
        <? $currentFilterSort = "" ?>
        <? if ($pager->haveToPaginate()): ?>
            <div class="pagination">
                <div class="pagination_link">
                    <?= link_to('<<', 'contests/detail' . $urlParamsPage . '&page=' . $pager->getPreviousPage()) ?>
                </div>
                <? $links = $pager->getLinks() ?>
                <? foreach ($links as $page): ?>   
                    <div class="pagination_link">
                        <?= ($page == $pager->getPage()) ? $page : link_to($page, 'contests/detail' . $urlParamsPage . '&page=' . $page) ?> 
                    </div>
                <? endforeach; ?>
                <div class="pagination_link">
                    <?= link_to('>>', 'contests/detail' . $urlParamsPage . '&page=' . $pager->getNextPage()) ?>
                </div>
            </div>
        <? endif; ?>
    </div>
    <!-- End Pagination -->
</div>
<!-- End Recipes in Contest -->