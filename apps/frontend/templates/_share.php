<div id="sharebar" <? $dailydish = substr($_SERVER['PATH_INFO'], 1, 17); if( $dailydish == 'blogs/daily-dish/'){echo 'class="hide_stumble"';} ?>>
	<div class="wrapper">
    <img class="br_logo" src="/img/br_logo_no_tagline.png"/>
  	<form id="ft-search" action="<?= getDomainUri().'/search' ?>" method="get">
      <input type="text" value="Search for recipe" name="term" onFocus="clearText(this)" onBlur="clearText(this)" /><input type="submit" value="SEARCH" class="btn-grey28" />
      <input type="hidden" name="PageType" value="Recipe" />
    </form>
    <div id="gigya-footer" class="gigya">
      <script type="text/javascript">
        $(document).ready(function(){
          setTimeout(
            function() {
              brmb.gigya.sharebar({'target':'gigya-footer'});
            },
            1000
          );
        });
      </script>
    </div>
<? /*    <ul class="hornav social">
        <li>FOLLOW US:</li>
        <li><a href="http://www.facebook.com/betterrecipes" title="Follow us on Facebook" class="cta-fb" target="_blank">Facebook</a></li>
        <li class="bdrt"><a href="http://www.twitter.com/betterrecipes" title="Follow us on Twitter" class="cta-tw" target="_blank">Twitter</a></li>
      </ul><!-- /social nav -->
*/ ?>
    <p class="flri mr30"><a href="#" title="Close the Sharebar" class="close_sharebar">[-] Close</a></p>
  </div><!-- /.wrapper --> 
</div><!-- /#sharebar -->
<div id="show_sharebar">
	<p><a href="#" title="Show the sharebar">[+] Open Sharebar</a></p>
</div><!-- /.show_sharebar -->