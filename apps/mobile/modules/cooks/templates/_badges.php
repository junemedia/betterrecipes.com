<? if ($render): ?>
<p class="header clear"><span class="green">Badges &amp; Trophies</span><span class="all">(<?= $badge_count ?>)</span></p>
<ul class="<?= ($class ? $class : 'hornav flare ovhid') ?>">  
  <? if ($badge_count): ?>
  <? foreach ($badges as $badge): ?>
  <li><img src="<?= $badge['img_50'] ?>" style="margin-left: 5px;" alt="<?= $badge['name'] ?>" title="<?= $badge['name'] ?>" /></li>
  <? endforeach ?>
  <? endif ?>
</ul>
<? endif ?>
