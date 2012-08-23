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
    //Meta is Active - Change to inactive if user confirms
    var answer = confirm(msg);
    if (answer){
      d=new Date();
      $.get("<?= url_for('meta/updateActive') ?>", {meta_id:$(obj).parents("li").attr("id"), status:activeUpdate, t:d.getTime()});      
    } else {
      obj.checked = checked;      
    }
  }
</script>
<div id="mainHeading">
  <h1>Landing Page Meta Data</h1>  
</div>
<div id="metaHeadings" class="headings row">
  <ul>
    <li><span class="nosort">Name</span></li>
    <li><span class="nosort">Slug</span></li>
    <li><span class="title nosort">Title</span></li>
    <li><span class="description nosort">Description</span></li>
    <li><span class="keywords nosort">Keywords</span></li>
    <li><span class="edited nosort">Date Edited</span></li>
    <li><span class="active nosort">Active</span></li>
  </ul>
</div>
<ul id="metaRows" class="results">
  <?php foreach ($metas as $key => $meta): ?>
    <li class="row <?= ($key % 2) == 0 ? "even" : "odd"; ?> big" id="<?= $meta->getId() ?>">
      <span><a href="<?= url_for('meta/detail?id=' . $meta->getId()) ?>"><?= $meta->getName() ?></a></span>
      <span><?= $meta->getSlug() ?></span>
      <span class="title"><?= $meta->getTitle() ?></span>
      <span class="description"><?= $meta->getDescription() ?></span>
      <span class="keywords"><?= $meta->getKeywords() ?></span>
      <span class="edited"><?= date('m-d-y g:sa', strtotime($meta->getUpdatedAt())) ?></span>
      <span class="active">
        <input type="checkbox" id="active" value="<?= ($meta->getIsActive() == 1) ? "1" : "0"; ?>" <?= $meta->getIsActive() ? "checked='checked'" : ""; ?> onchange="changeActive(this)" />
      </span>
    </li>
  <?php endforeach; ?>
</ul>