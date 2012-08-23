<? if ($category): ?>
  <p class="title">Popular Stories</p>
  <div id="pop_stories">
    <? $stories = Doctrine_Core::getTable('Article')->getList(array('category_id' => $category->getId())) ?>
    <? foreach( $stories as $story): ?>
      <div class="mr40">
        <div class="header">
          <img src="<?= $story->getImgSrc() ?>" alt="<?= $story->getName() ?>"  />
          <p class="mb10"><a href="<?= getUrl($story) ?>" title="<?= $story->getName() ?>"><?= $story->getName() ?></a></p>
          <p><?= Utilities::truncateHtml($story->getSummary(), 800) ?></p>
        </div><!-- /.header -->
      </div><!-- /.mr40 -->
    <? endforeach ?>
  </div><!-- /#pop_stories -->
<? endif ?>