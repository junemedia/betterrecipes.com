<? if (count($slides) > 0): ?>
  <ul id="slidesshowthumbs"<? if ($showall): ?> class="display-none"<? endif; ?>>
    <? foreach ($slides as $key => $slide): ?>
      <li class="slide">
        <img src="<?= $slide->getImgSrc() ?>" width="135px" alt="Recipe Title" />
        <p class="mt10"><a onclick="goToSlide(<?= $key ?>)" title="Recipe Title"><?= $slide->getName() ?></a></p>
      </li>
    <? endforeach; ?>
  </ul>
<? endif; ?>