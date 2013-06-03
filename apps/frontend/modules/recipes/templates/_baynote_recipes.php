<div id="baynote_popular_recipes">
    <p class="title">Your favorite <?= $category->getName() ?></p>
        <?
            $memcache = new Memcache();
            $memcache->connect('mmc', 11211);
            $recipes = $memcache->get('br_pop_recipes_' . md5($category->getSlug()));
        ?>
        <? foreach( $recipes as $recipe ): ?>
            <? if( !isset($recipe['image_url']) ): ?>
                <? $photo = Doctrine_Core::getTable('Recipe')->createQuery('p')->where('p.slug = ?', $recipe['slug'])->fetchOne() ?>
                <? $image_url = $photo->getMainImageSrc(); ?>
            <? else: ?>
                <? $image_url = $recipe['image_url']; ?>
            <? endif ?>
            <div class="activity-container">
                <div class="img-mask bordshad">
                    <a href="<?= $recipe['url'] ?>">
                        <img src="<?= $image_url ?>" alt="recipe_image"/>
                    </a>
                </div>
                <div class="activity-info">
                    <p class="rec_title">
                        <a href="<?= $recipe['url'] ?>"><?= $recipe['title']; ?></a>
                    </p>
                    <p class="rec_desc">
                        <? if(isset($recipe['description']) ): ?>
                            <?
                                // $str = wordwrap( $recipe['description'], 130, '\n' );
                                // $str = explode( '\n', $str );
                                // echo $str[0];
                                $str_limit = 130;
                                $str = $recipe['description'];
                                if (strlen($str) > $str_limit) {
                                    $str = rtrim(preg_replace('/^(.{0,'.$str_limit.'}\w)\b.*$/', '$1', $str), ".\"')").'…';
                                }
                                echo $str;
                            ?>
                        <? else: ?>
                            <? echo ''; ?>
                        <? endif ?>
                    </p>
                </div>
            </div>
        <? endforeach ?>
        <? $memcache->close(); ?>
</div>