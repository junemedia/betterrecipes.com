<?php $kruxSiteId = array(
'bhg' => 'Hx9xEyWT', 
'divinecaroline' => 'HyuzPae3', 
'dlv' => 'HyfSsqJx', 
'fc' => 'Hxcbek1g', 
'fitness' => 'Hx-jOfl8', 
'lhj' => 'Hx-kFuO5', 
'more' => 'Hx-kJeN4', 
'midwest' => 'Hx-jyMhC', 
'parents' => 'Hx-jYyFN', 
'recipecom' => 'Hx-jU67W', 
'rrmag' => 'Hx-j8JTy', 
'traditionalhome' => 'H1F_wjNl',
'wood' => 'HyfTJT5Z'
);

echo '<script class="kxct" data-id="' . $kruxSiteId[$brand] . '" data-version="async:1.7" type="text/javascript">
window.Krux||((Krux=function(){Krux.q.push(arguments)}).q=[]);
(function(){ var k=document.createElement(\'script\');
k.type=\'text/javascript\';
k.async=true;
var m,src=(m=location.href.match(/\bkxsrc=([^&]+)/))&&decodeURIComponent(m[1]);
k.src = /^https?:\/\/([^\/]+\.)?krxd\.net(:\d{1,5})?\//i.test(src) ? src : src === "disable" ? "" : (location.protocol==="https:"?"https:":"http:")+"//cdn.krxd.net/controltag?confid=' . $kruxSiteId[$brand] . '";
var s=document.getElementsByTagName(\'script\')[0];s.parentNode.insertBefore(k,s); })();
</script>
<script>var brand = "' . $brand . '";</script>';
?>