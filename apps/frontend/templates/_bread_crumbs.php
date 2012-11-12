<? if (@$bread_crumbs): ?>
  <p id="breadcrumbs">
    <? foreach ($bread_crumbs as $title => $url): ?>
      <? if ($url): ?>
        <a href="<?= $url ?>" title="<?= $title ?>"><?= $title ?></a>&nbsp;/
      <? else: ?>
        <? if (in_array($title, array('thanksgiving recipes', 'christmas recipes'))) {$display_adtag = $title;} ?>
        <a title="Current page" class="last"><?= $title ?></a>
    <? endif; ?>
  <? endforeach; ?>
  </p>
  <? if (@$display_adtag == 'christmas recipes'): ?>
    <span style="position:relative; right:120px; bottom:20px;">
      <image src="/uploads/category/christmas.jpg" />
      <script src="http://ad.doubleclick.net/N878/adj/betterrecipes.mdp.com/S1;net=md;u=,md-11469861782_1352404077,11ff8da11386969,md,;channel=S1;parent=cat740170;site=betterrecipes;child1=cat6840001;id=christmas;gender=0;age=0000;income=00;genderage=0_0000;ageincome=0000_00;genderincome=0_00;user=0_0000_00;type=slideshow;!category=pop;!c=rme;tile=3;sz=120x60;cmw=nowl;contx=md;cmd=christmas.betterrecipes.com;btg=;ord=[RANDOM]" language="javascript"></script>
    </span>
  <? endif; ?>
  <? if (@$display_adtag == 'thanksgiving recipes'): ?>
    <span style="position:relative; right:120px; bottom:20px;">
      <image src="/uploads/category/thanksgiving.jpg" />
      <script src="http://ad.doubleclick.net/N878/adj/betterrecipes.mdp.com/S1;net=md;u=,md-11370776331_1352399433,11ff8da11386969,md,;channel=S1;parent=cat740170;site=betterrecipes;child1=cat6840001;id=thanksgiving;gender=0;age=0000;income=00;genderage=0_0000;ageincome=0000_00;genderincome=0_00;user=0_0000_00;type=slideshow;!category=pop;!c=rme;tile=3;sz=120x60;cmw=nowl;contx=md;cmd=thanksgiving.betterrecipes.com;btg=;ord=[RANDOM]" language="javascript"></script>
    </span>
  <? endif; ?>
<? endif; ?>