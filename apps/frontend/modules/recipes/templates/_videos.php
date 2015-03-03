<? if (isset($videos) && sizeof($videos) > 0): ?>
<div id="top-videos">
<p class="title">Top <?= $category->getName() ?> Videos</p>
<ul class="imgleft">
<? for ($i = 0; $i < count($videos['items']); $i++): ?>
<li>
<a href="<?=getRoute('@video_detail', array('slug' => $videos['items'][$i]['video_slug'], 'id' => $videos['items'][$i]['video_id']))?>" title="<?= $videos['items'][$i]['title'] ?>" class="imgmask75"><img src="<?= $videos['items'][$i]['preview_url'] ?>" alt="<?= $videos['items'][$i]['title'] ?>" /></a>
<p><a href="<?=getRoute('@video_detail', array('slug' => $videos['items'][$i]['video_slug'], 'id' => $videos['items'][$i]['video_id']))?>" title="<?= $videos['items'][$i]['title'] ?>"><?= $videos['items'][$i]['title'] ?></a></p>
<p class="fs11">by <a href="<?=getRoute('User', array('subdir' => $videos['items'][$i]['username']))?>" title="<?= $videos['items'][$i]['username'] ?>"><?= $videos['items'][$i]['display_name'] ?></a></p>
</li>
<? endfor; ?>
</ul>
<p class="cta-more"><a href="<?=getRoute('@search', array('page' => 'video'))?>" title="See more popular videos" class="purple">see more&raquo;</a></p>
</div><!-- /#top-videos -->
<? endif; ?>