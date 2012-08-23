<div id="gigya-post-vote-wrapper">
  <p class="vote-title fs18  green mb10">Thanks for your Vote!</p>
  <p class="vote-summary">Don't forget! Help get more votes for your photo by sharing with your friends.</p>
  <p class="tac">Share your Vote</p>
  <div id="gigya-post-vote" class="gigya">
    <script type="text/javascript">
      $(document).ready(function(){
        setTimeout(
        function() {
          var ua = new gigya.services.socialize.UserAction(); 
          ua.setTitle($("#recipe_title").text());
          ua.setDescription($("#recipe_description").text());
          ua.setLinkBack(window.location.href);
          brmb.gigya.sharebar({ 'target':'gigya-post-vote', params:{ 
              userAction:ua,
              shareButtons:/* [ {provider: 'Stumbleupon'} ] */ [
                {
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
              ]}
          });
        },
        1000
      );
        //CSS Modifications
        $("#gigya-post-vote img").css("width", "50px!important");
      });
    </script>
  </div>
</div>