<div class="author-info border-top border-bottom ovhid">

  <p class="fs18 mb10">
  Recipe By: <a href="<?= getUrl('User', array('display_name' => $author->getDisplayName())) ?>" title="<?= $author->getDisplayName() ?>"><?= $author->getDisplayName() ?></a>
  <? if ( $author->getWebsiteName() != '' && $author->getWebsiteAddress() != '' ): ?>
  <br />
  Website: <a href="<?=$author->getWebsiteAddress()?>" target="_blank"><?=$author->getWebsiteName()?></a>
  <? endif; ?>
  </p>
</div><!-- /.author-info -->