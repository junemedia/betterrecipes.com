<h2 class="widgettitle">Blog Search <!-- <?php bloginfo('name'); ?> --></h2>
<form method="get" id="searchform" action="<?php bloginfo('url'); ?>/">
 <input type="text" value="<?php the_search_query(); ?>" name="s" id="s" value="Search" onFocus="this.value=''" />
 <!-- <input type="submit" id="searchsubmit" value="Search" /> -->
 <input type="image" title="Search" alt="Search" class="searchButton" src="http://images.meredith.com/betterrecipes/images/template/buttons/search.gif" id="blgsrchbut">
</form>
