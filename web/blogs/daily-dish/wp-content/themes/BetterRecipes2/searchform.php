<h2 class="widgettitle">Search <?php bloginfo('name'); ?></h2>
<form method="get" id="searchform" action="<?php bloginfo('url'); ?>/">
 <input type="text" value="<?php the_search_query(); ?>" name="s" id="s" value="Search" onFocus="this.value=''" />
 <input type="submit" id="searchsubmit" value="Search" />
</form>
