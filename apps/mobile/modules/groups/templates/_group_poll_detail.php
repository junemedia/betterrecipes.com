<? $slug = '&slug=' . $sf_params->get('slug'); ?>
<? $poll_slug = '&poll_slug=' . $sf_params->get('poll_slug'); ?>
<? $id = '&id=' . $sf_params->get('id') ?>

<p class="header"><span class="green">POLL DETAIL</span></p>
<!-- POLL INFO START -->
<? if (isset($poll) && sizeof($poll) > 0): ?>
<p class="just-copy"><?= $poll['title'] ?></p>
<p class="fs11 just-copy">by <a href="<?= getRoute('User', array('subdir' => $poll['subdir'])) ?>" title="<?= $poll['display_name'] ?>"><?= $poll['display_name'] ?></a> | <? if ($poll['num_votes'] != '') { echo $poll['num_votes']; } else { echo '0'; } ?> Votes</p>
<? include_partial('polls/vote', compact('poll')) ?>
<? endif; ?>
<!-- POLL INFO END -->
            	
            	
           