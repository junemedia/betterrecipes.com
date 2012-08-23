<div id="mainHeading">
  <h1>Right Rail</h1>
</div>

<? foreach($recipeOverrides as $i => $override): ?>
  <div id="rightrailRecipes" class="rightrail container">
    <div id="subHeading">
      <h2>Top Recipes</h2>
      <form id="rightrailRecipesEdit" action="<?=url_for('rightrail/edit?id='.$override->getId())?>">
        <input type="submit" class="detail btn-grey28" value="Edit" />
      </form>
      <ul>
        <li id="total">Total Recipes Shown on Page: <?= $recipeOverrideInfo['totalRecipes'][$i] ?></li>
        <li id="date">Recipes below are shown from <span class="date"><?= date('m/d/y', strtotime($override->getStartDate()))?></span> to <span class="date"><?= date('m/d/y', strtotime($override->getEndDate()))?></span></li>
      </ul>
    </div>

    <div class="list">
      <ul>
        <? $numItems = 0; ?>
        <? if (count($recipeOverrideInfo['weightedItems'][$i]) > 0): ?>
        <? foreach ($recipeOverrideInfo['weightedItems'][$i] as $index => $item): ?>
          <li>
            <span class="num"><?=$index+1?>.</span>
            <span class="data"><?= $item->getName() ?></span>
          </li>
          <? $numItems++; ?>
        <? endforeach; ?>
      </ul>   
      <? endif; ?>
      <? if ($numItems < $recipeOverrideInfo['totalRecipes'][$i]): ?>
        <span id="msg">Remaining Recipes are automatically populated</span>
      <? endif; ?>      
    </div>
  </div>
<? endforeach; ?>

<form id="newOverride" method="" action="<?=url_for('rightrail/new')?>">
  <input type="submit" class="btn-grey28" value="Add Top Recipe Section" />
</form>