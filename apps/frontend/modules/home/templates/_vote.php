<? if (isset($poll) && $poll && (sizeof($poll) > 0)): ?>
  <p class="title">Today's Poll</p>
  <p><?= $poll->getPollTitle() ?></p>
  <div id="result-bar">
    <ul>
      <? foreach ($poll->getPollOption() as $key => $item): ?>
        <? //$poll_option = Doctrine_Core::getTable('PollOption')->find($item['option_id']); ?>
        <li>
          <div class="img-mask">
            <img src="<?= $item->getPhoto()->getImgSrc() ?>" height="100" alt="<?= $item->getOptionTitle() ?>"/>
          </div>
          <p class="rec_votebtn"><a class="vote" onclick="castVoteFeatured('/home/castvote', '#result-bar', '<?= $poll->getId() ?>', '<?= $item->getId() ?>', '<?= urlencode($item->getOptionTitle()) ?>', '<?= urlencode($poll->getPollTitle()) ?>');" title="Vote Button">VOTE</a></p>
          <p class="rec_title"><a href="<?= getUrl($item->getRecipe()) ?>"><?= $item->getOptionTitle() ?></a></p>
        </li>
      <? endforeach; ?>
    </ul>
  </div>
<? endif; ?>
