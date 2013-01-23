<?php
/* note: this is the original 300x250 ad tag (prior to being replaced by the YieldBot Ad Tag)

<!-- *** start of right side ad *** -->
<script language="JavaScript" type="text/javascript">
  document.write('<scr'+'ipt language="JavaScript" src="http://a.collective-media.net/adj/betterrecipes.mdp.com/' + adchannelid + ';channel=' + adchannelid + ';parent=' + adparentid + ';child1=' + adchild1id + ';site=betterrecipes;id=' + adid + ';tile=2;sz=300x600,300x250;ord=' + ord + '?" type="text/javascript"></scr'+'ipt>');
</script>	
<script>
  <!--
  if ((!document.images && navigator.userAgent.indexOf('Mozilla/2.') >= 0) || navigator.userAgent.indexOf("WebTV") >= 0) {
    jump='<a href="http://a.collective-media.net/jump/betterrecipes.mdp.com/' + adchannelid + ';channel=' + adchannelid + ';parent=' + adparentid + ';child1=' + adchild1id + ';site=betterrecipes;id=' + adid + ';tile=2;sz=300x600,300x250;ord=' + ord + '? target="_top">';
    src='<img src=http://a.collective-media.net/ad/betterrecipes.mdp.com/' + adchannelid + ';channel=' + adchannelid + ';parent=' + adparentid + ';child1=' + adchild1id + ';site=betterrecipes;id=' + adid + ';tile=2;sz=300x600,300x250;ord=' + ord + '?></a>';
    document.write(jump);
    document.write(src);
  }
  //-->
</script>
<noscript>
<!-- for non javascript browsers and Netscape 2.x -->
<a href=http://a.collective-media.net/jump/betterrecipes.mdp.com/;channel=;parent=;site=betterrecipes;id=;tile=2;sz=300x600,300x250;ord=123456789? target="_top">
   <img src=http://a.collective-media.net/ad/betterrecipes.mdp.com/;channel=;parent=;site=betterrecipes;id=;tile=2;sz=300x600,300x250;ord=123456789? border="0"></a>
</noscript>
<!-- *** end of right side ad *** -->

*/
?>

<!-- *** start of right side ad *** -->
<!-- Yieldbot Ad Tag begin (example only) -->
<script type="text/javascript">
var ybotq = ybotq || [];
ybotq.push(['psn', 'd45f']); //pin
ybotq.push(function () {
var ord = Math.floor(Math.random()*9999999999);
var url = "http://a.collective-media.net/adj/betterrecipes.mdp.com/S1;channel="+window.adchannelid+";parent="+window.adparentid+";site=betterrecipes;child1="+window.adchild1id+";id="+window.adid+";ybot_ad=n;gender=0;age=0000;income=00;genderage=0_0000;ageincome=0000_00;genderincome=0_00;user=0_0000_00;type=slideshow;!category=pop;dcopt=ist;cmn=mn;tile=2;sz=300x250,300x600;ord=" + ord + "?";
var slot = yieldbot.slot_available('300x250');
if (slot) {
url = url.replace('ybot_ad=n', 'ybot_ad=y;ybot_slot=' + slot);
}
document.write('<scr'+'ipt type="text/javascript" language="javascript" src="' + url + '"></scr'+'ipt>');
});
if (!ybotq.framework) {
document.write('<scr'+'ipt type="text/javascript" src="http://cdn.yb0t.com/js/yieldbot.intent.js"></scr'+'ipt>');
}
</script>
<!-- Yieldbot Ad Tag end -->
<noscript>
<!-- for non javascript browsers and Netscape 2.x -->
<a href=http://a.collective-media.net/jump/betterrecipes.mdp.com/;channel=;parent=;site=betterrecipes;id=;cmn=mn;tile=2;sz=300x600,300x250;ord=123456789? target="_top">
   <img src=http://a.collective-media.net/ad/betterrecipes.mdp.com/;channel=;parent=;site=betterrecipes;id=;cmn=mn;tile=2;sz=300x600,300x250;ord=123456789? border="0"></a>
</noscript>
<!-- *** end of right side ad *** -->