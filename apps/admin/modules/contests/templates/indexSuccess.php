<div id="mainHeading">
  <h1>Contests</h1>
  <a href="<?= url_for('contests/new') ?>">Add Contest</a>
</div>

<div id="pendingContests" class="container contests">
  <h2>Pending Contests</h2>
  <h3>The following contests are pending and can be edited.</h3>
  <div id="activeHeadings" class="headings row">
    <ul>
      <li><span class="name nosort">Contest Name</span></li>
      <li><span class="startDate nosort">Start Date</span></li>                
      <li><span class="endDate nosort">End Date</span></li>
      <li><span class="sponsor nosort">Sponsor</span></li>
    </ul>
  </div> 
  <ul id="activeRows" class="results">
  <? foreach ($pendingContests as $i => $c): ?>  
    <li class="row <?= ($i % 2) == 0 ? "even" : "odd"; ?> big" id="<?= $c->getId() ?>">
      <span class="name"><a href="<?= url_for('contests/detail?id='.$c->getId()) ?>"><?= $c->getName() ?></a></span>
      <span class="startDate"><?= date('m-d-y', strtotime($c->getStartDate()))?></span>
      <span class="endDate"><?= date('m-d-y', strtotime($c->getEndDate()))?></span>
      <span class="sponsor">
        <? if(is_null($c->getSponsorId())) { ?>
          <a onclick="addSponsor(this, '<?=url_for('contests/addSponsor')?>')">Add</a>
        <? } else { ?>
          <?= $c->getSponsor()->getName() ?>
        <? } ?>
      </span>
    </li>   
  <? endforeach; ?>
  </ul> 
</div>

<div id="activeContests" class="container contests">
  <h2>Active Contests</h2>
  <a href="<?=url_for('contests/sort')?>" class="edit btn-grey28" >Edit</a>
  <h3>The following contests are shown on the Content Page.</h3>
  <div id="activeHeadings" class="headings row">
    <ul>
      <li><span class="name nosort">Contest Name</span></li>
      <li><span class="startDate nosort">Start Date</span></li>                
      <li><span class="endDate nosort">End Date</span></li>
      <li><span class="sponsor nosort" style="width:75px;">Sponsor</span></li>
      <li><span class="sponsor nosort" style="width:75px;">Report</span></li>
    </ul>
  </div> 
  <ul id="activeRows" class="results">
  <? foreach ($activeContests as $i => $c): ?>  
    <li class="row <?= ($i % 2) == 0 ? "even" : "odd"; ?> big" id="<?= $c->getId() ?>">
      <span class="name"><a href="<?= url_for('contests/detail?id='.$c->getId()) ?>"><?= $c->getName() ?></a></span>
      <span class="startDate"><?= date('m-d-y', strtotime($c->getStartDate()))?></span>
      <span class="endDate"><?= date('m-d-y', strtotime($c->getEndDate()))?></span>
      <span class="sponsor">
        <? if(is_null($c->getSponsorId())) { ?>
          <a onclick="addSponsor(this, '<?=url_for('contests/addSponsor')?>')">Add</a>
        <? } else { ?>
          <?= $c->getSponsor()->getName() ?>
        <? } ?>
      </span>
      <span class="sponsor"><a href="<?= url_for('contests/exportcontest?id='.$c->getId()) ?>">Export</a></span>
    </li>   
  <? endforeach; ?>
  </ul> 
</div>

<div id="previousContests" class="container contests">
  <h2>Previous Contests</h2>
  <h3>The following contests are no longer active and cannot be edited.</h3>
  <div id="previousHeadings" class="headings row">
    <ul>
      <li><span class="name nosort">Contest Name</span></li>
      <li><span class="startDate nosort">Start Date</span></li>                
      <li><span class="endDate nosort">End Date</span></li>
      <li><span class="sponsor nosort">Sponsor</span></li>
    </ul>
  </div> 
  <ul id="activeRows" class="results">
  <? foreach ($pager->getResults() as $i => $c): ?>  
    <li class="row <?= ($i % 2) == 0 ? "even" : "odd"; ?> big" id="<?= $c->getId() ?>">
      <? /*<span class="name"><a href="<?= url_for('contests/detail?id='.$c->getId().'&edit=no') ?>"><?= $c->getName() ?></a></span> */ ?>
      <span class="name"><a href="<?= url_for('contests/detail?id='.$c->getId()) ?>"><?= $c->getName() ?></a></span>
      <span class="startDate"><?= date('m-d-y', strtotime($c->getStartDate()))?></span>
      <span class="endDate"><?= date('m-d-y', strtotime($c->getEndDate()))?></span>
      <span class="sponsor"><?= is_null($c->getSponsorId()) ? 'N/A' : $c->getSponsor()->getName(); ?></span>
    </li>   
  <? endforeach; ?>
  </ul> 
  <div class="paginationRow">
  <? if ($pager->haveToPaginate()): ?>
    <div class="pagination">
      <div class="pagination_link">
        <?= link_to('<<', 'contests/index?page='.$pager->getPreviousPage()) ?>
      </div>
      <? $links = $pager->getLinks(); foreach ($links as $page): ?>   
        <div class="pagination_link">
          <?= ($page == $pager->getPage()) ? $page : link_to($page, 'contests/index?page='.$page) ?> 
        </div>
      <? endforeach; ?>
      <div class="pagination_link">
        <?= link_to('>>', 'contests/index?page='.$pager->getNextPage()) ?>
      </div>
    </div>
  <? endif; ?>
  </div>
</div>