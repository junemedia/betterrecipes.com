<? if (isset($photos) && sizeof($photos) > 0): ?>
<div id="top-photos">
<p class="title">Top <?= $category->getName() ?> Photos</p>
<ul class="imgleft">
<? for ($i = 0; $i < count($photos['items']); $i++): ?>
<li>
<a href="<?=getRoute('@photo_detail', array('slug' => $photos['items'][$i]['photo_slug'], 'id' => $photos['items'][$i]['photo_id']))?>" title="<?= $photos['items'][$i]['caption'] ?>" class="imgmask75"><img src="<?= $photos['items'][$i]['thumb_url'] ?>" alt="<?= $photos['items'][$i]['caption'] ?>" /></a>
<p><a href="<?=getRoute('@photo_detail', array('slug' => $photos['items'][$i]['photo_slug'], 'id' => $photos['items'][$i]['photo_id']))?>" title="<?= $photos['items'][$i]['caption'] ?>" title="<?= $photos['items'][$i]['caption'] ?>"><?= $photos['items'][$i]['caption'] ?></a></p>
<p class="fs11">by <a href="<?=getRoute('User', array('subdir' => $photos['items'][$i]['username']))?>" title="<?= $photos['items'][$i]['username'] ?>"><?= $photos['items'][$i]['display_name'] ?></a></p>
</li>
<? endfor; ?>
</ul>
<p class="cta-more"><a href="<?=getRoute('@search', array('page' => 'photo'))?>" title="See more popular photos" class="purple">see more&raquo;</a></p>
</div><!-- /#top-photos -->
<? endif; ?>