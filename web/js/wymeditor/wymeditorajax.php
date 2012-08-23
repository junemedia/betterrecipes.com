<?php
/* Where should the images be saved? Use a trailing slash */
//$target	= '/images/';
$target = '/mnt/hgfs/Websites/betterrecipes/web/uploads/';
/* You shouldn;t have to modify anything else */
$resarr	= array();
$type	= $_GET['type'];
if ($type=='afbeeldingen') {
	$handle=opendir($target);
	$i=0;
	while (false!==($file = readdir($handle))) {
		if(substr($file,-3,3)=='jpg'||substr($file,-3,3)=='png'||substr($file,-3,3)=='gif') {
			$resarr[$i]['url']	= 'bestanden/'.$file;
			$resarr[$i]['naam']	= $file;
			$i++;
		}
	}
}
else if ($type=='bestand') {
	$naam = strtolower(basename($_FILES['bestand']['name']));
	$naam = str_replace(' ', '-', $naam);
	if(move_uploaded_file($_FILES['bestand']['tmp_name'], $target.$naam)) {
		echo 'here '.$naam;
		$resarr[0]	= array('naam'=>$naam,'url'=>$naam);
		echo "document.lm_imgform.wym_src.value='".$target."'/".$naam."';\n";
	} else{
		echo 'alert("Upload error");'."\n";
		die();
	}
}
else {
	die();
}
echo "var ddl = document.getElementById('lm_select');\n";
foreach($resarr as $item) {
	echo "var theOption = new Option;\n";
	echo "theOption.text 	= '".$item['naam']."';\n";
	echo "theOption.value	= '/".$item['url']."';\n";
	echo "ddl.add(theOption,null);\n";
}