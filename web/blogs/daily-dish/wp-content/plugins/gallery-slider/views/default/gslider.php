<?php 
if (!empty($slides)) : 
?>
<script type="text/javascript">
	var jsSlideshow = new Array();
</script>
<?php 
	if ($frompost) : 
		foreach ($slides as $single) :    
			$full_image_href2 = wp_get_attachment_image_src($single -> ID, 'full', false);
			$slideshow[] = $full_image_href2;
			?>
			<script type="text/javascript">
				jsSlideshow.push("<?php echo($full_image_href2[0]); ?>");
			</script>		
			<?php
		endforeach;
	else :
		foreach ($slides as $single) :    
			$full_image_href = GS_UPLOAD_URL .'/'. basename($single -> image_url);
			$slideshow[] = $full_image_href;
			?>
			<script type="text/javascript">
				jsSlideshow.push("<?php echo($full_image_href); ?>");
			</script>		
			<?php
		endforeach;	
	endif;
	
	$style = $this -> get_option('styles');
	$lightbox = $this -> get_option('lightbox');
	if ($this -> get_option('autoslide') == "Y"):
		$autospeed = $this -> get_option('autospeed');
	endif;
	
	if ($style['width_temp']) :	$width = $style['width_temp'];	else : $width = $style['width'];endif;
	if ($style['height_temp']) :	$height = $style['height_temp'];	else : $height = $style['height'];endif;
?>
	<style>
		#loading {
			position:relative;top:<?php echo(($height/2)-10);?>px;left:<?php echo(($width/2)-10);?>px;z-index:1104;
		}
	</style>
    
	<div id="slideshow-wrap">
    	<div id="gs-fullsize">
        <div id="iprev" class="inav" title="Previous Image"></div>
        <div id="inext" class="inav" title="Next Image"></div>
		<img id="loading" alt="" src="<?php echo(GS_PLUGIN_URL)?>/images/spinner.gif"/>
        
        
		<?php if ($frompost) : ?>
            <ul id="slidecustom" class="galslider">
                <?php foreach ($slideshow as $slider) : ?>       
                    <li>
                    	<?PHP if ($lightbox == "Y") : ?>
                        	<a rel="lightbox" href="<?php echo $slider[0]; ?>">
						<?PHP endif; ?>
                    		<img src="<?php echo $slider[0]; ?>" alt="" />
                        <?PHP if ($lightbox == "Y") : ?></a><?PHP endif; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
            
            <script type="text/javascript">
			//jsSlideshow[0];
			jQuery.preLoadImages(
				[jsSlideshow[0],jsSlideshow[1],jsSlideshow[2]],function(){			
					jQuery('#loading').css("display", "none");
					jQuery('#slidecustom').ulslide({
                         width: <?php echo($width); ?>,
                         affect: '<?php echo($this -> get_option('affect')); ?>',
                         duration: <?php echo($this -> get_option('duration')); ?>,
                         height: 440,
                         bnext: '#inext',
                         bprev: '#iprev',
                         axis: '<?php echo($this -> get_option('axis')); ?>',
                         direction: '<?php echo($this -> get_option('direction')); ?>',
                         preload : 'true',
						 autoslide: <?PHP if ($autospeed): echo($autospeed); else: echo('false'); endif?>
                      });
				}
			);
            </script>      
            <?php else : ?>
            <ul id="slidecustom" class="galslider">
                <?php foreach ($slides as $slider) : ?>       
                    <li>
                  		<?php if ($slider -> uselink == "Y" && !empty($slider -> link)) : ?>

							<a href="<?php echo $slider -> link; ?>" title="<?php echo $slider -> title; ?>">
                            	
						<?php elseif ($lightbox == "Y") : ?>
                        	<a rel="lightbox" href="<?php echo $full_image_href2[0]; ?>">
						<?PHP endif; ?>
                    	<img src="<?php echo get_bloginfo('wpurl'); ?>/wp-content/uploads/<?php echo $this -> plugin_name; ?>/<?php echo basename($slider -> image_url); ?>" alt="<?php echo $slider -> description;  ?>" />
                        <?PHP if ($lightbox == "Y" || $slider -> uselink == "Y") : ?></a><?PHP endif; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
            <script type="text/javascript">
			jsSlideshow[0];
			jQuery.preLoadImages(
				[jsSlideshow[0],jsSlideshow[1],jsSlideshow[2]],function(){			
					jQuery('#loading').css("display", "none");
					jQuery('#slidecustom').css("display", "block");
					jQuery('#slidecustom').ulslide({
                         width: <?php echo($width); ?>,
                         affect: '<?php echo($this -> get_option('affect')); ?>',
                         duration: <?php echo($this -> get_option('duration')); ?>,
                         height: 440,
                         bnext: '#inext',
                         bprev: '#iprev',
                         axis: '<?php echo($this -> get_option('axis')); ?>',
                         direction: '<?php echo($this -> get_option('direction')); ?>',
                         preload : 'true',
						 autoslide: <?PHP if ($autospeed): echo($autospeed); else: echo('false'); endif?>
                      });
				}
			);

			/*jQuery('#slidecustom').ready(function() {
				jQuery('.galslider').css("display", "none");
				jQuery('#loading').css("display", "none");
			});*/
			
            </script>
        <?php endif; ?>
        </div>
        <script type="text/javascript">
     		jQuery(document).ready(function() {
				jQuery(window).keyup(function (event) {
					if (event.keyCode == 37) {
						jQuery('#iprev').click();
					}
					if (event.keyCode == 39) {
						jQuery('#inext').click();
					}
				});
			});
		</script>
    </div>
<!--<img style="height:75px;" src="<?php echo $this -> Html -> image_url($this -> Html -> thumbname(basename($slide -> image_url))); ?>" alt="<?php echo $this -> Html -> sanitize($slide -> title); ?>" />-->
<?php endif; ?>