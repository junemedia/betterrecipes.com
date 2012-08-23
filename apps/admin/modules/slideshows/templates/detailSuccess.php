<? include_partial('global/bread_crumbs', compact('bread_crumbs')) ?>
<div id="mainHeading">
  <h1><?= $slideshow->getName() ?></h1>
</div>
<div id="slideshowContainer" class="container small">
  <div id="subHeading">
    <h2>General Details</h2><a href="<?= UrlToolkit::getUrl($slideshow, array('mode' => 'preview')) ?>" title="Preview '<?= $slideshow->getName() ?>'" target="_blank" class="lp150">Preview "<?= $slideshow->getName() ?>"</a>
    <form id="recipeSearch" action="<?= url_for('slideshows/edit?id=' . $slideshow->getId()) ?>">
      <input type="submit" class="detail btn-grey28" value="Edit" />
    </form>
  </div>
  <div class="list">
    <ul>
      <li><span class="label">Category</span><span class="data"><?= $slideshow->getCategoryName() ?></span></li>
      <li><span class="label">Slideshow Title</span><span class="data"><?= $slideshow->getName() ?></span></li>
      <li><span class="label descript">Slideshow Description</span><span class="data descript"><?= $slideshow->getDescription() ?></span></li>
      <li><span class="label">Start Date</span><span class="data"><?= date('m/d/y', strtotime($slideshow->getStartDate())) ?></span></li>
      <li><span class="label">End Date</span><span class="data"><?= date('m/d/y', strtotime($slideshow->getEndDate())) ?></span></li>
      <li><span class="label">Title Tag</span><span class="data"><?= $slideshow->getTitleTag() ?></span></li>
      <li><span class="label">Meta Description</span><span class="data"><?= $slideshow->getSummary() ?></span></li>
      <li><span class="label">Keywords</span><span class="data"><?= $slideshow->getKeywords() ?></span></li>
      <li><span class="label">Status</span><span class="data"><?= ($slideshow->getIsActive() == 1) ? "Active" : "Inactive" ?></span></li>
    </ul>      
  </div>
</div> 
<div id="recipeSidebarSponsor" class="container sidebar sponsor">
  <div id="subHeading">
    <h3>Sponsor</h3>
    <p class="text">Current Sponsor:</p>
    <? $sponsorId = $slideshow->getSponsorId(); ?>
    <p id="currentSponsor"><?= isset($sponsorId) ? $slideshow->getSponsor()->getName() : "None" ?></p>
    <form id="recipeSearch" action="<?= url_for('slideshows/edit?id=' . $slideshow->getId()) ?>">
      <input type="submit" class="sidebar btn-grey28" value="Edit" />
    </form>
  </div>
</div>
<div id="slidesContainer" class="container slides">
  <div id="subHeading">
    <h2>Slides</h2>
    <form id="recipeSearch2" action="<?= url_for('slideshows/edit?id=' . $slideshow->getId()) ?>">
      <input type="submit" class="sidebar btn-grey28" value="Edit" />
    </form>
  </div>
  <? include_partial('slides', array('edit' => false, 'slideshow' => $slideshow, 'slides' => $slides)) ?>
</div>