<? if ($category): ?>
  <p style="display:none;" class="title mb10">Popular Blog posts</p>
  <div id="pop_blog_posts">
    <?
      $memcache = new Memcache();
      $memcache->connect('mmc', 11211);
      $blogs = $memcache->get('br_pop_blogs_' . md5($category->getSlug()));
    ?>
    <? foreach( $blogs as $blog ): ?>
      <div class="blog_post">
        <a href="<?= $blog['guid'] ?>" class="blog_post_img mb5">
          <img class="mb5" src="<?= $blog['picture'] ?>" alt="<?= $blog['title'] ?>" />
        </a>
        <p class="mb5">
          <a href="<?= $blog['guid'] ?>"><?= $blog['title'] ?></a>
        </p>
        <p class="blog_post_date">
          Written on: <?= date( 'M d, Y \a\t g:i a ', strtotime($blog['date']) ) ?>
        </p>
      </div><!-- /blog_post -->
    <? endforeach ?>
    <? $memcache->close(); ?>
  </div><!-- /#pop_stories -->
<? endif ?>