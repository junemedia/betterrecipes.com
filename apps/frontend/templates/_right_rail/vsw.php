  
  <div class="vswAdContainer roundedCornerWithWhiteBG" id="vsw">
                <style type="text/css">
                    body div.vsw-ad-rc .vsw-ad-title {color:#2C73BB !important; font-family:Arial !important;}
                    body div.vsw-ad-rc .vsw-ad-text {font-family:Arial !important; font-size:12px !important; color:black !important;}
                    body div.vsw-ad-rc .vsw-ad-domain {font-family:Arial !important; color:black !important; font-size:11px !important;}
                </style>
                <span class="heading2">More Smart Savings</span>
                <div id="ERA_AD_BLOCK"></div>
                <script type="text/javascript">
					//values same as your existing vsw	
                    era_rc = {
                           ERADomain: 'as.vs4food.com',
                           MaxRelatedItems: 4,
                           PubID: 'recipe',
                           BlockID: 'standard',
                           Layout: 'default',
                           ClassName: 'era_ad_block',
                           at: 0
                    };
                </script>
                <script type="text/javascript">
        // <![CDATA[

        function doVswScript() {
        	alert('test');
              var v = 'ERA_AD_BLOCK';
              var sch = (location.protocol == 'https:' ? 'https' : 'http');
              var host = sch == 'http' ? 'as.featurelink.com' : 'secure.featurelink.com';
              var s = document.createElement('script');
              var src = sch + "://" + host + "/ERALinks/era_rl.aspx?elid=" + v;
              for (var p in era_rc) {
                  if (era_rc.hasOwnProperty(p)) {
                      src += decodeURIComponent('%26') + p.toLowerCase() + "=" + encodeURIComponent(era_rc[p]);
                  }
              };
              document.getElementsByTagName("head")[0].appendChild(s);
              s.src = src;
          }
        // ]]>
    </script>



      <script type="text/javascript">
        (function() {
          var js = document.createElement('script');
          js.src = 'http://cdn.yb0t.com/js/yieldbot.intent.js';
          var node = document.getElementsByTagName('script')[0];
          node.parentNode.insertBefore(js, node);
        })();
        var ybotq = ybotq || [];
        ybotq.push(function () {
          yieldbot.defineSlot('300x250_vsw', 'vsw');
          yieldbot.alternateSlot('300x250_vsw',doVswScript);
        });
      </script>
</div>	