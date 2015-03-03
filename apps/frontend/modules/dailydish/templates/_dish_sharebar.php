<div id="dailydish-sharebar" class="border-bottom">
	<div id="inlinesharebar"></div>
  <? /* <div class="su-hack"><script src="http://www.stumbleupon.com/hostedbadge.php?s=1"></script></div> */ ?>
</div>
<script>
  $(document).ready(function(){
    brmb.gigya.sharebar({ 'target':'inlinesharebar', params:{shareButtons:/* [ {provider: 'Stumbleupon'} ] */ [
                {
                    provider: 'facebook-like'
                }
								, {
                    provider: 'Stumbleupon'
										, enableCount: true
                }
                , {
                    provider: 'google-plusone'
                }
                , {
                    provider: 'share'
                    , enableCount: false
                }
                , {
                    provider: 'share'
                    , iconImgUp: '/img/facebook.png'
                    , enableCount: false
                    , iconOnly: true
                }
                , {
                    provider: 'Twitter'
                    , iconImgUp: '/img/twitter.png'
                    , enableCount: false
                    , iconOnly: true
                }
                , {
                    provider: 'email'
                    , iconImgUp: '/img/email.png'
                    , enableCount: false
                    , iconOnly: true
                }
            ]
						} });
		// brmb.gigya.sharebar();
  });
</script>