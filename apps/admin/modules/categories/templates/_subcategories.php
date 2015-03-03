<script>
  $(document).ready(function() {
    $("#accordion").sortable().accordion();
<? if (isset($sorted)): ?>
          alert("Subcategories are succesfully sorted.");
<? endif; ?>
      });
</script>
<input type="hidden" name="category_id" value="<?= $category->getId() ?>" />
<div id="subcategoriesContainer" class="container">
  <div id="subHeading">
    <h2>Subcategories</h2>
    <input type="button" class="accordion btn-grey28 right" value="Sort" onclick="sortSubcategories()" />
  </div>
  <ul id="accordion">
    <? foreach ($category->getChildren(array('order_by' => 'sequence')) as $subcategory): ?>
      <li>
        <h3><span class="subcatName"><?= $subcategory->getName() ?></span></h3>            
        <div class="subcategory">
          <a href="<?= UrlToolkit::getUrl($subcategory, array('mode' => 'preview')) ?>" title="Preview '<?= $subcategory->getName() ?>'" target="_blank" class="lp150">Preview "<?= $subcategory->getName() ?>"</a>
          <input type="hidden" name="subcategory_ids[]" value="<?= $subcategory->getId() ?>" />
          <input type="button" class="accordion btn-grey28" value="Edit" onclick="window.location.href='<?= url_for('categories/edit?id=' . $subcategory->getId()) ?>'" />
          <div class="img">
            <img src="<?= $subcategory->getImgSrc() ?>" alt="Category Image" /> 
          </div>
          <div class="list">
            <ul>
              <li><span class="label">Description</span><span class="data"><?= $subcategory->getDescription() ?></span></li>
              <li><span class="label">Title Tag</span><span class="data"><?= $subcategory->getTitleTag() ?></span></li>
              <li><span class="label">Meta Description</span><span class="data"><?= $subcategory->getSummary() ?></span></li>
              <li><span class="label">Key Words</span><span class="data"><?= $subcategory->getKeywords() ?></span></li>
            </ul>            
          </div>          
        </div>
      </li>
    <? endforeach; ?>
  </ul>
</div>