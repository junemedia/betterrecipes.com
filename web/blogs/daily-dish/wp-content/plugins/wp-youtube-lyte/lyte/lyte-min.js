(function(e){var t=document;var n="https";e.te=function(){if(!r){var r=1;lts=e.getElementsByClassName("lyMe","div");for(var s=0,o=lts.length;s<o;s+=1){p=lts[s];vid=p.id.substring(4);if(mOs===null){cN=p.className.replace(/lyMe/,"lyte")+" lP";p.className=cN;sprite=bU+"lytesprite.png";e.addCss(".lyte .ctrl, .lyte .Rctrl, .lyte .Lctrl, .lyte .play { background-image: url("+sprite+"); }");if(cN.indexOf("audio")===-1){bgId="lyte_"+vid;thumb=t.getElementById(bgId).getAttribute("data-src");if(thumb!==""){bgCss="#"+bgId+" { background-image: url("+thumb+"); }";e.addCss(bgCss)}else{scr=t.createElement("script");scr.src=n+"://gdata.youtube.com/feeds/api/playlists/"+vid+"?v=2&alt=json-in-script&callback=ly.parsePL&fields=id,entry";scr.type="text/javascript";t.getElementsByTagName("head")[0].appendChild(scr)}}p.onclick=e.play}else{e.play(p.id)}}}var r=""};e.parsePL=function(t){thumb=t.feed.entry[0].media$group.media$thumbnail[1].url;if(n=="https"&&thumb.indexOf("https"==-1)){thumb=thumb.replace("http://","https://")}t_id=t.feed.id.$t.match(/:playlist:(PL[a-zA-Z0-9_]+)/);id="lyte_"+t_id[1];bgCss="#"+id+" { background-image: url("+thumb+"); }";e.addCss(bgCss)};e.getQ=function(e){qsa="";if(rqs=e.className.match(/qsa_(.*)\s/,"$1"))qsa=rqs[1].replace(/\\([\&\=\?])/g,"$1");return qsa};e.play=function(r){if(typeof r==="string"){tH=t.getElementById(r);aP=0}else{tH=this;tH.onclick="";aP=1}vid=tH.id.substring(4);hidef=0;if(tH.className.indexOf("hidef")!==-1){hidef="1&vq=hd720"}if(tH.className.indexOf("playlist")===-1){eU=n+"://www.youtube.com/embed/"+vid+"?"}else{eU=n+"://www.youtube.com/embed/videoseries?list="+vid+"&"}qsa=e.getQ(tH);if(tH.className.indexOf("audio")!==-1&&aP==1){qsa+="&autohide=0";aHgh="438";aSt="position:relative;top:-400px;"}else if(tH.className.indexOf("audio")!==-1&&aP==0){tH.parentNode.style.height="";tH.style.height="";aHgh=tH.clientHeight;aSt="height:"+aHgh+"px !important;"}else{aHgh=tH.clientHeight;aSt=""}tH.innerHTML='<iframe id="iF_'+vid+'" width="'+tH.clientWidth*2+'" height="'+aHgh+'" src="'+eU+"autoplay="+aP+"&controls=1&wmode=opaque&rel=0&egm=0&iv_load_policy=3&hd="+hidef+qsa+'" frameborder="0" style="'+aSt+'" allowfullscreen></iframe>';if(typeof tH.firstChild.getAttribute("kabl")=="string")tH.innerHTML="Please check Karma Blocker's config.";if(aP==0){window.addEventListener("orientationchange",function(){t.getElementById(r).width=t.getElementById(r).parentNode.clientWidth},false)}};e.getElementsByClassName=function(e,n,r){if(t.getElementsByClassName){getElementsByClassName=function(e,n,r){r=r||t;var i=r.getElementsByClassName(e),s=n?new RegExp("\\b"+n+"\\b","i"):null,o=[],u;for(var a=0,f=i.length;a<f;a+=1){u=i[a];if(!s||s.test(u.nodeName)){o.push(u)}}return o}}else if(t.evaluate){getElementsByClassName=function(e,n,r){n=n||"*";r=r||t;var i=e.split(" "),s="",o="http://www.w3.org/1999/xhtml",u=t.documentElement.namespaceURI===o?o:null,a=[],f,l;for(var c=0,h=i.length;c<h;c+=1){s+="[contains(concat(' ', @class, ' '), ' "+i[c]+" ')]"}try{f=t.evaluate(".//"+n+s,r,u,0,null)}catch(p){f=t.evaluate(".//"+n+s,r,null,0,null)}while(l=f.iterateNext()){a.push(l)}return a}}else{getElementsByClassName=function(e,n,r){n=n||"*";r=r||t;var i=e.split(" "),s=[],o=n==="*"&&r.all?r.all:r.getElementsByTagName(n),u,a=[],f;for(var l=0,c=i.length;l<c;l+=1){s.push(new RegExp("(^|\\s)"+i[l]+"(\\s|$)"))}for(var h=0,p=o.length;h<p;h+=1){u=o[h];f=false;for(var v=0,m=s.length;v<m;v+=1){f=s[v].test(u.className);if(!f){break}}if(f){a.push(u)}}return a}}return getElementsByClassName(e,n,r)};e.addCss=function(e){var n=t.createElement("style");n.type="text/css";if(n.styleSheet){n.styleSheet.cssText=e}else{n.appendChild(document.createTextNode(e))}t.getElementsByTagName("head")[0].appendChild(n)}})(window.ly=window.ly||{});(function(){var e=window;var t=document;if(e.addEventListener){e.addEventListener("load",ly.te,false);t.addEventListener("DomContentLoaded",function(){setTimeout("ly.te()",750)},false)}else{e.onload=ly.te;setTimeout("ly.te()",1e3)}})()
