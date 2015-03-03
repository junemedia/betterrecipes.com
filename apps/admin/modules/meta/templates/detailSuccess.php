<? include_partial('global/bread_crumbs', compact('bread_crumbs')) ?>
<div id="mainHeading">
  <h1>"<?= $meta->getName() ?>" meta data</h1>
</div>
<div id="articleContainer" class="container small">
  <div id="subHeading">
    <h2>General Details</h2>
    <input type="submit" class="detail btn-grey28 flri" value="Edit" onclick="window.location.href='<?= url_for('meta/edit?id=' . $meta->getId()) ?>'" />
  </div>
  <div class="list">
    <ul>
      <li><span class="label">Name</span><span class="data"><?= $meta->getName() ?></span></li>
      <li><span class="label">Slug</span><span class="data"><?= $meta->getSlug() ?></span></li>
      <li><span class="label">Title</span><span class="data"><?= $meta->getTitle() ?></span></li>
      <li><span class="label">Description</span><span class="data"><?= $meta->getDescription() ?></span></li>
      <li><span class="label">Keywords</span><span class="data"><?= $meta->getKeywords() ?></span></li>
      <li><span class="label">Date Added</span><span class="data"><?= date('m/d/y  g:sa', strtotime($meta->getCreatedAt())) ?></span></li>
      <li><span class="label">Date Edited</span><span class="data"><?= date('m/d/y  g:sa', strtotime($meta->getUpdatedAt())) ?></span></li>
      <li><span class="label">Created By</span><span class="data"><?= $meta->getUser()->getDisplayName() ?></span></li>
      <li><span class="label">Status</span><span class="data"><?= ($meta->getIsActive() == 1) ? "Active" : "Inactive" ?></span></li>
    </ul>      
  </div>
</div> 