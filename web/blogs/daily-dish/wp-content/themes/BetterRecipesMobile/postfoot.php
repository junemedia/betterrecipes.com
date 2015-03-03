    <? if( is_single() ){ ?>
    <?php comments_popup_link('No Comments', '1 Comment', '% Comments'); ?> | <a href="#respond">Post Your Comment</a>
    <? } else { ?>
    <?php comments_popup_link('No Comments', '1 Comment', '% Comments'); ?> | <a href="<?php the_permalink() ?>#respond">Post Your Comment</a>
    <? } ?>
