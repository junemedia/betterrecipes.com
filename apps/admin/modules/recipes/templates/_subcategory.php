<select name="sub_categories" id="sub_categories" class="sub_categories" onchange="updateCategory($(this).val())">
  <option value="">-- Subcategory --</option>  
  <? foreach ($subcategories as $subcategory): ?>
    <option value="<?= $subcategory->getId() ?>" <?= (isset($subCat) && $subCat == $subcategory->getId()) ? "Selected" : "" ?>><?= $subcategory->getName() ?></option>
  <? endforeach; ?>
</select>