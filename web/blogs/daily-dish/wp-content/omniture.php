<?php

    $GTM_ACCOUNTS = array(
        "www.bhg.com"                  => "GTM-WMWB88",
        "www.parents.com"              => "GTM-PT434V",
        "www.recipe.com"               => "GTM-KHJS23",
        "www.fitnessmagazine.com"      => "GTM-P328DB",
        "www.familycircle.com"         => "GTM-MHSQB3",
        "www.rachaelraymag.com"        => "GTM-W76K69",
        "www.diyadvice.com"            => "GTM-WBB8HB",
        "www.allpeoplequilt.com"       => "GTM-T82L3P",
        "www.midwestliving.com"        => "GTM-NNQQ4G",
        "www.traditionalhome.com"      => "GTM-KL57ZH",
        "www.livingthecountrylife.com" => "GTM-W9PJ7R",
        "www.more.com"                 => "GTM-52GC5C",
        "www.woodmagazine.com"         => "GTM-KGGK47",
    );

    $gtmId = @$GTM_ACCOUNTS[$servername] ? $GTM_ACCOUNTS[$servername] : $GTM_ACCOUNTS['www.recipe.com'];

?>

<!-- Google Tag Manager -->
<script>

var dataLayerEntry = {};

<?php if (is_category()): ?>
// category
dataLayerEntry['Page Name'] = "Blogs:<?=bloginfo('name')?>:<?=single_cat_title('')?>";

<?php elseif (is_day()): ?>
// day archive page
dataLayerEntry['Page Name'] ="Blogs:<?=bloginfo('name')?>:<?=the_time('l, F jS, Y')?>";

<?php elseif (is_month()): ?>
// month archive page
dataLayerEntry['Page Name'] ="Blogs:<?=bloginfo('name')?>:<?=the_time('F, Y')?>";

<?php elseif (is_year()): ?>
// year archive page
dataLayerEntry['Page Name'] ="Blogs:<?=bloginfo('name')?>:<?=the_time('Y')?>";

<?php elseif (is_search()): ?>
// search results
dataLayerEntry['Page Name'] ="Blogs:<?=bloginfo('name')?>:Search:<?=the_search_query()?>";

<?php elseif (isset($_GET['paged']) && !empty($_GET['paged'])): ?>
// paged result, not first page
dataLayerEntry['Page Name'] ="Blogs:Post:<?=bloginfo('name')?>";

<?php elseif (strcmp($wp_query->is_page, "1") == 0): ?>
// first page
dataLayerEntry['Page Name'] = "Blogs:<?=bloginfo('name')?>:Post:<?=the_title()?>";

<?php elseif (is_tag()): ?>
// archive page
dataLayerEntry['Page Name'] = "Blogs:<?=bloginfo('name')?>:<?=single_cat_title('')?>";

<?php elseif (is_single()): ?>
// single post page
dataLayerEntry['Page Name'] = "Blogs:<?=bloginfo('name')?>:<?=trim(str_replace("&raquo;", "", wp_title("", false)))?>";
dataLayerEntry['Author'] = "<?=get_the_author()?>";

<?php elseif (is_author()): ?>
// author page
dataLayerEntry['Page Name'] = "Blogs:<?=bloginfo('name')?>:Posts by <?=get_the_author()?>";
dataLayerEntry['Author'] = "<?=get_the_author()?>";

<?php elseif (is_front_page() || is_home()): ?>
// home page
dataLayerEntry['Page Name'] = "Blogs:<?=bloginfo('name')?>";

<?php endif?>

<?php if (@$_GET['psrc']): ?>
dataLayerEntry['Internal Campaign']="<?=$_GET['psrc']?>";
<?php elseif (@$_GET['socsrc']): ?>
dataLayerEntry['Social Campaign']="<?=$_GET['socsrc']?>";
<?php elseif (@$_GET['esrc']): ?>
dataLayerEntry['Email Campaign']="<?=$_GET['esrc']?>";
<?php elseif (@$_GET['did']): ?>
dataLayerEntry['External Campaign']="<?=$_GET['did']?>";
<?php elseif (@$_GET['ordersrc']): ?>
dataLayerEntry['External Campaign']="<?=$_GET['ordersrc']?>";
<?php elseif (@$_GET['sssdmh']): ?>
dataLayerEntry['External Campaign']="<?=$_GET['sssdmh']?>";
<?php endif?>

<?php if ($servername == "www.parents.com"): ?>
dataLayerEntry['Content Type'] = "Blog";
<?php endif?>

dataLayerEntry['Channel'] = "Blogs";
dataLayerEntry['Category'] = "Community";
dataLayerEntry['Content ID']="blog:<?=esc_url(the_guid())?>";
dataLayerEntry['Hash ID'] = "";
dataLayerEntry['event'] = "pageview";

(window.dataLayer = window.dataLayer || []).push(dataLayerEntry);

</script>

<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src='//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);})(window,document,'script','dataLayer','<?=$gtmId?>');</script>

<noscript><iframe src="//www.googletagmanager.com/ns.html?id=<?php echo $gtmAccountId ?>" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager -->
