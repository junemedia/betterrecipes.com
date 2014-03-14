function refreshVsw() {
	if ( $('#vsw-container').length > 0 ) {
		$('#vsw-container').load("/adtags/refresh?tagname=vsw");
	}
}

function refreshAdtags(location){
  refreshAd728x90(location);
}
function refreshAd728x90(location){
  if($(".ad728x90").length > 0){
    try{
      $(".ad728x90").writeCapture().load("/adtags/refresh?tagname=728x90",refreshAd300x250(location));
    }
    catch(err){
      refreshAd300x250(location);
    }
  } else {
    refreshAd300x250(location);
  }
} 
function refreshAd300x250(location){
  if($(".ad300x250").length > 0){
    try{
      $(".ad300x250").writeCapture().load("/adtags/refresh?tagname=300x250",refreshAd1000x45(location));
    }
    catch(err){
      refreshAd1000x45(location);
    }
  } else {
    refreshAd1000x45(location);
  }
}
function refreshAd1000x45(location){
  if(location == 'all'){
    if($(".ad1000x45").length > 0){
      try{
        $(".ad1000x45").writeCapture().load("/adtags/refresh?tagname=1000x45",refreshAdsweeps(location));
      }
      catch(err){
        refreshAdsweeps(location);
      }
    } else {
      refreshAdsweeps(location);
    }
  }
}
function refreshAdsweeps(){
  if($(".adsweeps").length > 0){
    try{
      $(".adsweeps").writeCapture().load("/adtags/refresh?tagname=sweeps",refreshAdsponsor());
    }
    catch(err){
      refreshAdsponsor();
    }
  } else {
    refreshAdsponsor();
  }
}
function refreshAdsponsor(){
  if($(".adsponsor").length > 0){
    try{
      sponsor_id_parts = $(".adsponsor").attr('id').split('_');
      $(".adsponsor").writeCapture().load("/adtags/refresh?tagname=sponsor&spid="+sponsor_id_parts[1],refreshNextAdtag());
    }
    catch(err){
      refreshNextAdtag();
    }
  } else {
    refreshNextAdtag();
  }
}
// Replace the following function name with the adtag
function refreshNextAdtag(){
//    if($(".adnexttag").length > 0){
//        try{
//            $(".adnexttag").writeCapture().load("/adtags/refresh?tagname=nexttag",refreshNextAdTag());
//        }
//        catch(err){
//            refreshNextAdTag();
//        }
//    } else {
//        refreshNextAdTag();
//    }
}