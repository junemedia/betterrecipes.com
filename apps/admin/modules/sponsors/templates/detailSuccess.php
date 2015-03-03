<? include_partial('global/bread_crumbs', compact('bread_crumbs')) ?>
<div id="mainHeading">
  <h1><?= $sponsor->getName() ?></h1>
</div>

<div id="sponsorContainer" class="container">
  <div id="subHeading">
    <h2>General Details</h2>
    <form id="recipeSearch" action="<?= url_for('sponsors/edit?id='.$sponsor->getId()) ?>">
      <input type="submit" class="detail btn-grey28" value="Edit" />
    </form>
  </div>
  <div class="list">
    <ul>
      <li><span class="label">Sponsor Name</span><span class="data"><?= $sponsor->getName() ?></span></li>
      <li><span class="label descript">Sponsor Description</span><span class="data descript"><?= $sponsor->getDescription() ?></span></li>
      <li><span class="label">Link</span><span class="data"><a href="<?= $sponsor->getUrl() ?>" target="_blank"><?= $sponsor->getUrl() ?></a></span></li>
      <li><span class="label">Adtag</span><span class="data"><?= $sponsor->getAdtag() ?></span></li>
      <li><span class="label">Status</span><span class="data"><?= ($sponsor->getIsActive() == 1) ? "Active" : "Inactive" ?></span></li>
    </ul>      
  </div>
</div> 