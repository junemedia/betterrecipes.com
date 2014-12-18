<?php $styles = $this -> get_option('styles'); ?>
<table class="form-table">
	<tbody>
		<tr>
			<th><label for="styles.navbuttons"><?php _e('Navigational Buttons', $this -> plugin_name); ?></label></th>
			<td>
                <select name="styles[navbuttons]">
                    <option <?php echo (empty($styles['navbuttons']) || $styles['navbuttons'] == "0") ? 'selected="selected"' : ''; ?> value="0" />Box </option> <?php _e('Box', $this -> plugin_name); ?>
                    <option <?php echo ($styles['navbuttons'] == "1") ? 'selected="selected"' : ''; ?> value="1" />Circle</option> <?php _e('Circle', $this -> plugin_name); ?>
                    <option <?php echo ($styles['navbuttons'] == "2") ? 'selected="selected"' : ''; ?> value="2" />Simple</option> <?php _e('Simple', $this -> plugin_name); ?>
                    
                </select>        
				<span class="howto"><?php _e('Choose your nav buttons for left and right transitioning', $this -> plugin_name); ?></span>
			</td>
		</tr>
		<tr>
			<th><label for="styles.resizeimages"><?php _e('Resize Images (width)', $this -> plugin_name); ?></label></th>
			<td>
				<label><input <?php echo (empty($styles['resizeimages']) || $styles['resizeimages'] == "Y") ? 'checked="checked"' : ''; ?> type="radio" name="styles[resizeimages]" value="Y" id="styles.resizeimages_Y" /> <?php _e('Yes', $this -> plugin_name); ?></label>
				<label><input <?php echo ($styles['resizeimages'] == "N") ? 'checked="checked"' : ''; ?> type="radio" name="styles[resizeimages]" value="N" id="styles.resizeimages_N" /> <?php _e('No', $this -> plugin_name); ?></label>
				<span class="howto"><?php _e('should images be resized proportionally to fit the width of the slideshow area', $this -> plugin_name); ?></span>
			</td>
		</tr>
		<tr>
			<th><label for="styles.resizeimages2"><?php _e('Resize Images (height)', $this -> plugin_name); ?></label></th>
			<td>
				<label><input <?php echo (empty($styles['resizeimages2']) || $styles['resizeimages2'] == "Y") ? 'checked="checked"' : ''; ?> type="radio" name="styles[resizeimages2]" value="Y" id="styles.resizeimages_Y" /> <?php _e('Yes', $this -> plugin_name); ?></label>
				<label><input <?php echo ($styles['resizeimages2'] == "N") ? 'checked="checked"' : ''; ?> type="radio" name="styles[resizeimages2]" value="N" id="styles.resizeimages2_N" /> <?php _e('No', $this -> plugin_name); ?></label>
				<span class="howto"><?php _e('should images be resized proportionally to fit the height of the slideshow area', $this -> plugin_name); ?></span>
			</td>
		</tr>
		<tr>
			<th><label for="styles.width"><?php _e('Gallery Width', $this -> plugin_name); ?></label></th>
			<td>
				<input style="width:45px;" id="styles.width" type="text" name="styles[width]" value="<?php echo $styles['width']; ?>" /> <?php _e('px', $this -> plugin_name); ?>
				<span class="howto"><?php _e('width of the slideshow gallery', $this -> plugin_name); ?></span>
			</td>
		</tr>
		<tr>
			<th><label for="styles.height"><?php _e('Gallery Height', $this -> plugin_name); ?></label></th>
			<td>
				<input style="width:45px;" id="styles.height" type="text" name="styles[height]" value="<?php echo $styles['height']; ?>" /> <?php _e('px', $this -> plugin_name); ?>
				<span class="howto"><?php _e('height of the slideshow gallery', $this -> plugin_name); ?></span>
			</td>
		</tr>
		<tr>
			<th><label for="styles.border"><?php _e('Slideshow Border', $this -> plugin_name); ?></label></th>
			<td>
				<input type="text" name="styles[border]" value="<?php echo $styles['border']; ?>" id="styles.border" style="width:145px;" />
			</td>
		</tr>
		<tr>
			<th><label for="styles.background"><?php _e('Slideshow Background', $this -> plugin_name); ?></label></th>
			<td>
				<input type="text" name="styles[background]" value="<?php echo $styles['background']; ?>" id="styles.background" style="width:65px;" />
			</td>
		</tr>
        <!--
		<tr>
			<th><label for="styles.infobackground"><?php _e('Information Background', $this -> plugin_name); ?></label></th>
			<td>
				<input type="text" name="styles[infobackground]" value="<?php echo $styles['infobackground']; ?>" id="styles.infobackground" style="width:65px;" />
			</td>
		</tr>
		<tr>
			<th><label for="styles.infocolor"><?php _e('Information Text Color', $this -> plugin_name); ?></label></th>
			<td>
				<input type="text" name="styles[infocolor]" value="<?php echo $styles['infocolor']; ?>" id="styles.infocolor" style="width:65px;" />
			</td>
		</tr>
        -->
	</tbody>
</table>