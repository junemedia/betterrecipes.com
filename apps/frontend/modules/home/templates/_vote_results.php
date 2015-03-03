<div id="vote-bar" style="width:320px;background:none;">
<ul>
	<li style="width:200px;margin:0;">Voting Results:</li>
	<? foreach($result->getPollOption() as $v): ?>
		<? $pct = ( $v->getVotes() == 0 ) ? 0 : round(( $v->getVotes() / $result->getTotalVotes() ) * 100); ?>
    	<li style="width:200px;margin:0;"><?= $v->getOptionTitle() ?> - <span><?= $pct ?>%</span></li>
    <? endforeach; ?>
</ul> 
</div>
