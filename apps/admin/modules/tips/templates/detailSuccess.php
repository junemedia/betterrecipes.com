<? include_partial('global/bread_crumbs', compact('bread_crumbs')) ?>
<div id="mainHeading">
  <h1><?= $article->getName() ?></h1>
</div>
<div id="articleContainer" class="container small">
  <div id="subHeading">
    <h2>General Details</h2><a href="<?= UrlToolkit::getUrl($article, array('mode' => 'preview')) ?>" title="Preview '<?= $article->getName() ?>'" target="_blank" class="lp150">Preview "<?= $article->getName() ?>"</a>
    <form id="recipeSearch" action="<?= url_for('articles/edit?id=' . $article->getId()) ?>">
      <input type="submit" class="detail btn-grey28" value="Edit" />
    </form>
  </div>
  <div class="list">
    <ul>
      <li><span class="label">Category</span><span class="data"><?= $article->getCategory()->getName() ?></span></li>
      <li><span class="label">Article</span><span class="data"><?= $article->getName() ?></span></li>
      <li><span class="label descript">Article Description</span><span class="data descript"><?= $article->getDescription() ?></span></li>
      <li><span class="label">Image</span><span class="data img"><img src="<?= $article->getImgSrc('200x200') ?>" alt="<?= $article->getName() ?>" /></span></li>
      <li><span class="label">Date Added</span><span class="data"><?= date('m/d/y', strtotime($article->getCreatedAt())) ?></span></li>
      <li><span class="label">Title Tag</span><span class="data"><?= $article->getTitleTag() ?></span></li>
      <li><span class="label">Meta Description</span><span class="data"><?= $article->getSummary() ?></span></li>
      <li><span class="label">Keywords</span><span class="data"><?= $article->getKeywords() ?></span></li>
      <li><span class="label">Status</span><span class="data"><?= ($article->getIsActive() == 1) ? "Active" : "Inactive" ?></span></li>
    </ul>      
  </div>
</div> 
<div id="articleSidebarSponsor" class="container sidebar sponsor">
  <div id="subHeading">
    <h3>Sponsor</h3>
    <p class="text">Current Sponsor:</p>
    <? $sponsorId = $article->getSponsorId(); ?>
    <p id="currentSponsor"><?= isset($sponsorId) ? $article->getSponsor()->getName() : "None" ?></p>
    <form id="recipeSearch" action="<?= url_for('articles/edit?id=' . $article->getId()) ?>">
      <input type="submit" class="sidebar btn-grey28" value="Edit" />
    </form>
  </div>
</div>
<div id="articleBodyContainer" class="container">
  <div id="subHeading">
    <h2>Article Body Content</h2>  
    <form id="recipeSearch" action="<?= url_for('articles/edit?id=' . $article->getId()) ?>">
      <input type="submit" class="detail btn-grey28" value="Edit" />
    </form>
  </div>
  <div class="content">
    <p class="data"><?= $article->getContent() ?></p>
  </div>
</div>