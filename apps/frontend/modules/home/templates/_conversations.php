<? if (isset($conversations['items'])): ?>
<div id="top-discussions">
    <p class="title">MOST RECENT Conversations</p>
    <ul class="border-bottom">
	<? for($i = 0; $i < count($conversations['items']); $i++): ?>
		<?
		$params = array(
							'category' => $conversations['items'][$i]['category'],
							'slug' => $conversations['items'][$i]['group_slug'],
							'title' => $conversations['items'][$i]['slug'],
							'id' => $conversations['items'][$i]['thread_id']
						);
		?>
		<li>
			<p>
				<a href="<?=getRoute('@group_detail_discussions_detail', $params)?>">
					<?= $conversations['items'][$i]['title'] ?>
				</a>
			</p>
			<p><?= Utilities::truncateHtml($conversations['items'][$i]['first_post_content'], 80, '') ?></p>
			<p>Posted by: <a href="<?=getRoute('User', array('subdir' => $conversations['items'][$i]['username']))?>"><?=$conversations['items'][$i]['display_name']?></a></p>
		</li>
	<? endfor; ?>
	</ul>
    <p class="cta-more"><a href="<?=getRoute('@search', array('page' => 'discussion'))?>" title="See more discussions" class="purple">see more&raquo;</a></p>
</div><!-- /#top-discussions -->
<? endif; ?>
