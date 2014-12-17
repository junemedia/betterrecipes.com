<?php 
	$styler = array();
	$styler = $this -> get_option('styles');
	$pID = $GLOBALS['post']->ID;
        $nav = stripslashes($nav);
        
        if ($this->debugging == true) {
            echo $align;
            echo "<br/>width: ".$w;
            echo "<br/>nav: ".$nav;
            echo "<br/>pID".$pID;
            
        }
        
	if (!empty($align)) {
                $pID = $GLOBALS['post']->ID;
		$align_temp = $this -> get_option('align_temp');
		if (!is_array($align_temp)) { $align_temp = array(); }
		$align_temp[$pID] = $align;
		array_push($align_temp, $align_temp[$pID]);
		$this -> update_option('align_temp', $align_temp);
	}
        if (!empty( $nav )) {
                $pID = $GLOBALS['post']->ID;
		$nav_temp = $this -> get_option('nav_temp');
		if (!is_array($nav_temp)) { $nav_temp = array(); }
		$nav_temp[$pID] = $nav;
		array_push($nav_temp, $nav_temp[$pID]);
		$this -> update_option('nav_temp', $nav_temp);
//                echo ($nav);
        }
	if (!empty($w) || !empty($width)) {
		if ($width) { $w = $width; }
		$width_temp = $this -> get_option('width_temp');
		$pID = $GLOBALS['post']->ID;
		$width_temp[$pID] = $w;
		if (!is_array($width_temp)) { $width_temp = array(); }
		array_push($width_temp, $width_temp[$pID]);
		$this -> update_option('width_temp', $width_temp);
                $wid = $this->get_option('width_temp');
	}
	else {
/*		$width_temp = $styles['width'];
		$pID = $GLOBALS['post']->ID;
		if (!is_array($width_temp)) { $width_temp = array(); }
		array_push($width_temp, $width_temp[$pID]);*/
//		$this -> update_option('width_temp', $width_temp);
		//$this -> update_option('width_temp', null);
		$styler['width_temp'] = null;
		$this -> update_option('styles', $styler);
	}
	if (!empty($h) || !empty($height)) {
		if ($height) { $h = $height; }
		$height_temp = $this -> get_option('height_temp');
		$pID = $GLOBALS['post']->ID;
		$height_temp[$pID] = $h;
		if (!is_array($height_temp)) { $height_temp = array(); }
		array_push($height_temp, $height_temp[$pID]);
		$this -> update_option('height_temp', $height_temp);
	}
//	else {
		/*$height_temp = $styles['height'];
		$pID = $GLOBALS['post']->ID;
		if (!is_array($height_temp)) { $height_temp = array(); }
		array_push($height_temp, $height_temp[$pID]);*/
		//$this -> update_option('height_temp', $height_temp);
		//$this -> update_option('height_temp', null);
//	}
?>