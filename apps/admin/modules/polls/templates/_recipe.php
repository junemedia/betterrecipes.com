<ul class="recipe-images">
  <li class="title">
    <?= $recipe->getName() ?>
  </li>
  <? if ($photos = $recipe->getPhoto()): ?>
    <? foreach ($photos as $key => $photo): ?>
      <li>
        <img src="<?= $photo->getImgSrc('400x300') ?>" height="100" alt="<?= $photo->getName() ?>"/><br/>
        <label>Image <?= $key + 1 ?></label>
        <input type="checkbox" value="<?= $photo->getId() ?>" class="image-checkbox" onclick="selectImage(this)"<? if ($key == 0): ?> checked="checked" <? endif; ?>/>
      </li>
    <? endforeach; ?>
  <? endif; ?>
</ul><br/>
<div class="clearfix">
  <a onclick="updateOptions(this)">Replace Recipe <? if (count($photos) > 0): ?> and Image<? endif; ?></a>
  <input type="hidden" class="recipe-id" value="<?= $recipe->getId() ?>" />
</div>
