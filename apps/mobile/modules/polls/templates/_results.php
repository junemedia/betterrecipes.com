<ul>
	<li>Voting Results:</li>
	<? for ($i = 0; $i < count($result['items']); $i++): ?>
    	<li><?=$result['items'][$i]['name']?> - <span><?=$result['items'][$i]['percent']?>%</span></li>
    <? endfor; ?>
</ul> 
<? if (isset($tracker)): ?>
<script><?= $tracker->renderJsTrack() ?></script>
<? endif; ?>
