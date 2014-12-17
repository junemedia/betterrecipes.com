<?php header("Content-Type: text/css");?>

<?php $styles = array();?>
<?php foreach ($_GET as $skey => $sval) : ?>
	<?php $styles[$skey] = urldecode($sval);?>
<?php endforeach;?>

<?php 
IF ($styles['width_temp']) {
	$styles['width'] = $styles['width_temp'];
}
IF ($styles['height_temp']) {
	$styles['height'] = $styles['height_temp'];
}
IF ($styles['navbuttons'] == 0) { $navright = '../images/right-sq.png';$navleft = '../images/left-sq.png'; }
ELSEIF ($styles['navbuttons'] == 1) { $navright = '../images/right-rd.png';$navleft = '../images/left-rd.png'; }
ELSEIF ($styles['navbuttons'] == 2) { $navright = '../images/right-pl.png';$navleft = '../images/left-pl.png'; }

?>
#slideshow-wrap {width:<?php echo( (int) $styles['width']); ?>px;display:block;}
#slideshow-wrap * {margin:0;padding:0;}
#gs-fullsize {position:relative;z-index:1;overflow:hidden;width:<?php echo( (int) $styles['width']) ?>px;height:<?php echo( (int) $styles['height']); ?>px;}
#information {position:absolute;bottom:0;width:<?php echo( (int) $styles['width']) ?>px;height:0;color:#FFF;overflow:hidden;z-index:200;opacity:.7;filter:alpha(opacity=70);}
#information h3 {color:#FFF;padding:4px 8px 3px;font-size:14px;}
#information p {color:#FFF;padding:0 8px 8px;}
#image {width:<?php echo( (int) $styles['width']); ?>px;}
#image img {height:<?php echo( (int) $styles['height']); ?>px;}
<?php if (empty($styles['resizeimages']) || $styles['resizeimages'] == "Y") : ?>
.slide-node img {width:<?php echo( (int) $styles['width']); ?>px;height:auto;}
#image img {position:absolute;border:none;width:<?php echo( (int) $styles['width']); ?>px;height:auto;}
<?php else : ?>
#image img {position:absolute;border:none;width:auto;}<?php endif;?> 
<?php if (empty($styles['resizeimages2']) || $styles['resizeimages2'] == "Y") : ?>
#image img#tall {position:absolute;border:none;width:auto;height:<?php echo( (int) $styles['height']); ?>px;}
.slide-node img {width:auto;height:<?php echo( (int) $styles['height']); ?>px;margin:0 auto;}
<?php endif;?>
.inav {position:absolute;width:13%;height:<?php echo( (int) $styles['height']); ?>px;cursor:pointer;z-index:150;}
#iprev {left:1px;background:url(<?php echo($navleft);?>) left center no-repeat;}
#inext {right:0;background:url(<?php echo($navright);?>) right center no-repeat;}
#imglink {position:absolute;top:0;left: <?php echo ((int) $styles['width']*0.25);?>px;height:<?php echo( (int) $styles['height']); ?>px;width: <?php if ($styles['width_temp']): echo ((int) $styles['width_temp']*0.5);else: echo ((int) $styles['width']*0.5);endif;?>px;z-index:5000;opacity:.0;filter:alpha(opacity=0);background: #FFF;}
/*.linkhover*/
#imglink:hover {background:url('../images/link.gif') center center no-repeat;opacity:.4;filter:alpha(opacity=40)}
#slideleft {float:left;width:20px;height:81px;background:url('../images/scroll-left.gif') center center no-repeat; }
#slideleft:hover {background-color:#666;}
#slideright {float:right;width:20px;height:81px;background: url('../images/scroll-right.gif') center center no-repeat;}
#slideright:hover {background-color:#aaa;}
.galslider {margin:0!important;list-style-type: none;display:none}
