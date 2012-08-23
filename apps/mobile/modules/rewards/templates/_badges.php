<? if ($render): ?>
<ul class="mini_badges">
  <? if ($badge_count): ?>
  <? foreach ($badges as $badge): ?>
  <li><img width="20" height="20" src="<?= $badge['img_50'] ?>" alt="<?= $badge['name'] ?>" title="<?= $badge['name'] ?>" /></li>
  <? endforeach ?>
  <? endif ?>
</ul>
<? endif ?>
