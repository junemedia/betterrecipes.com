<script>
  function sortSubcategories(){
    $("#sort_subcategories").load("<?= url_for('@sort_subcategories') ?>", $("#sort_subcategories").serialize());  
  }
</script>
<? include_partial('global/bread_crumbs', compact('bread_crumbs')) ?>
<div id="mainHeading">
  <h1>Recipe Category - <?= $category->getName() ?></h1>
</div>

<div id="categoryContainer" class="container">
  <div id="subHeading">
    <h2>General Category Details</h2><a href="<?= UrlToolkit::getUrl($category, array('mode' => 'preview')) ?>" title="Preview '<?= $category->getName() ?>'" target="_blank" class="lp150">Preview "<?= $category->getName() ?>"</a>
    <form id="recipeSearch" action="<?= url_for('categories/edit?id=' . $category->getId()) ?>">
      <input type="submit" class="detail btn-grey28" value="Edit" />
    </form>
  </div>
  <div class="img">
    <img src="<?= $category->getImgSrc() ?>" alt="Category Image" /> 
  </div>
  <div class="list">
    <ul>
      <li><span class="label">Description</span><span class="data"><?= $category->getDescription() ?></span></li>
      <li><span class="label">Title Tag</span><span class="data"><?= $category->getTitleTag() ?></span></li>
      <li><span class="label">Meta Description</span><span class="data"><?= $category->getSummary() ?></span></li>
      <li><span class="label">Key Words</span><span class="data"><?= $category->getKeywords() ?></span></li>
    </ul>      
  </div>
</div>
<form id="sort_subcategories">
  <? include_partial('subcategories', compact('category')) ?>
</form>
<div id="favoriteRecipesContainer" class="container overrideSection">
  <div id="subHeading">
    <h2>Favorite Recipes</h2>
    <form id="favoriteRecipesContainerEdit" action="<?= url_for('categories/edit?id=' . $category->getId()) ?>">
      <input type="submit" class="detail btn-grey28" value="Edit" />
    </form>
    <ul>
      <li id="total">Total Recipes Shown on Page: <?= isset($favoriteRecipesTotal) ? $favoriteRecipesTotal : "5"; ?></li>
      <? if (isset($favoriteRecipes)): ?>
        <li id="date">Recipes below are shown from <span class="date"><?= date('m/d/y', strtotime($favoriteRecipes->getStartDate())) ?></span> to <span class="date"><?= date('m/d/y', strtotime($favoriteRecipes->getEndDate())) ?></span></li>
      <? endif; ?>
    </ul>
  </div>
  <div class="list">
    <ul>
      <? $numItems = 0; ?>
      <? if (isset($items) && count($items) > 0): ?>
        <? foreach ($items as $i => $item): ?>
          <li>
            <span class="num"><?= $i + 1 ?>. </span>
            <span class="data"><?= $item->getName() ?></span>
          </li>
          <? $numItems++; ?>
        <? endforeach; ?>
      </ul>   
    <? endif; ?>
    <? if ((isset($favoriteRecipesTotal) && $numItems < $favoriteRecipesTotal) || !isset($favoritRecipesTotal)) : ?>
      <span id="msg">Remaining Recipes are automatically populated</span>
    <? endif; ?>      
  </div>
</div>

<div id="favoriteArticlesContainer" class="container overrideSection">
  <div id="subHeading">
    <h2>How To Stories</h2>
    <form id="favoriteArticlesContainerEdit" action="<?= url_for('categories/edit?id=' . $category->getId()) ?>">
      <input type="submit" class="detail btn-grey28" value="Edit" />
    </form>
    <ul>
      <li id="total">Total Articles Shown on Page: <?= isset($favoriteArticlesTotal) ? $favoriteArticlesTotal : "5"; ?></li>
      <? if (isset($favoriteArticles)): ?>
        <li id="date">Articles below are shown from <span class="date"><?= date('m/d/y', strtotime($favoriteArticles->getStartDate())) ?></span> to <span class="date"><?= date('m/d/y', strtotime($favoriteArticles->getEndDate())) ?></span></li>
      <? endif; ?>
    </ul>
  </div>
  <div class="list">
    <ul>
      <? $numItems = 0; ?>
      <? if (isset($articles) && count($articles) > 0): ?>
        <? foreach ($articles as $i => $article): ?>
          <li>
            <span class="num"><?= $i + 1 ?>. </span>
            <span class="data"><?= $article->getName() ?></span>
          </li>
          <? $numItems++; ?>
        <? endforeach; ?>
      </ul>   
    <? endif; ?>
    <? if ((isset($favoriteArticlesTotal) && $numItems < $favoriteArticlesTotal) || !isset($favoriteArticlesTotal)) : ?>
      <span id="msg">Remaining Articles are automatically populated</span>
    <? endif; ?>      
  </div>
</div>