<? if (isset($poll) && sizeof($poll) > 0): ?>
<!--
  <p class="title">Trending recipes</p>
  <div id="top-trending">
      <ul>
        <? foreach ($poll->getPollOption() as $key => $item): ?>
          <? //$poll_option = Doctrine_Core::getTable('PollOption')->find($item['option_id']); ?>
          <li>
            <div class="img-mask">
              <img src="<?= $item->getPhoto()->getImgSrc() ?>" height="150" alt="<?= $item->getOptionTitle() ?>"/>
            </div>
            <p class="rec_title"><a href="<?= getUrl($item->getRecipe()) ?>"><?= $item->getOptionTitle() ?></a></p>
          </li>
        <? endforeach; ?>
      </ul>
  </div>
 --> 
<? endif; ?>