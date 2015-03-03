<table class="form-table">
	<tbody>
		<tr>
			<th><label for="autoslideY"><?php _e('Auto Slide', $this -> plugin_name); ?></label></th>
			<td>
				<label><input onclick="jQuery('#autoslide_div').show();" <?php echo ($this -> get_option('autoslide') == "Y") ? 'checked="checked"' : ''; ?> type="radio" name="autoslide" value="Y" id="autoslideY" /> <?php _e('Yes', $this -> plugin_name); ?></label>
				<label><input onclick="jQuery('#autoslide_div').hide();" <?php echo ($this -> get_option('autoslide') == "N") ? 'checked="checked"' : ''; ?> type="radio" name="autoslide" value="N" id="autoslideN" /> <?php _e('No', $this -> plugin_name); ?></label>
			</td>
		</tr>
		<tr>
			<th><label for="lightboxY"><?php _e('Activate Lightbox', $this -> plugin_name); ?></label></th>
			<td>
				<label><input <?php echo ($this -> get_option('lightbox') == "Y") ? 'checked="checked"' : ''; ?> type="radio" name="lightbox" value="Y" id="lightboxY" /> <?php _e('Yes', $this -> plugin_name); ?></label>
				<label><input <?php echo ($this -> get_option('lightbox') == "N") ? 'checked="checked"' : ''; ?> type="radio" name="lightbox" value="N" id="lightboxN" /> <?php _e('No', $this -> plugin_name); ?></label>
                <span class="howto"><?php _e('You will need to install a lightbox plugin still. We suggest "Lightbox 2"', $this -> plugin_name); ?></span>
			</td>
		</tr>
		<tr>
			<th><label for="transition"><?php _e('Transition Style', $this -> plugin_name); ?></label></th>
			<td>
                <select name="affect">
                    <option <?php echo ($this -> get_option('affect') == "slide") ? 'selected' : ''; ?> value="slide">Slide</option> <?php _e('Slide', $this -> plugin_name); ?>
                    <option <?php echo ($this -> get_option('affect') == "fade") ? 'selected' : ''; ?> value="fade">Fade</option> <?php _e('Fade', $this -> plugin_name); ?>
                </select>
			</td>
		</tr>        
	</tbody>
</table>

<div id="autoslide_div" style="display:<?php echo ($this -> get_option('autoslide') == "Y") ? 'block' : 'none'; ?>;">
	<table class="form-table">
		<tbody>
			<tr>
				<th><label for="autospeed"><?php _e('Auto Speed', $this -> plugin_name); ?></label></th>
				<td>
					<input type="text" style="width:45px;" name="autospeed" value="<?php echo $this -> get_option('autospeed'); ?>" id="autospeed" /> <?php _e('speed', $this -> plugin_name); ?>
				<span class="howto"><?php _e('default:5000 recommended:2000-12000', $this -> plugin_name); ?><br/><?php _e('lower number for quicker length of time between sliding of images', $this -> plugin_name); ?></span>
				</td>
			</tr>
		</tbody>
	</table>
</div>

<table class="form-table">
	<tbody>
		<tr>
			<th><label for="duration"><?php _e('Transition Speed', $this -> plugin_name); ?></label></th>
			<td>
				<input style="width:45px;" type="text" name="duration" value="<?php echo $this -> get_option('duration'); ?>" id="fadespeed" /> <?php _e('duration', $this -> plugin_name); ?>
				<span class="howto"><?php _e('default:700 recommended:300-2000', $this -> plugin_name); ?><br/><?php _e('lower number for quicker transition of images', $this -> plugin_name); ?></span>
			</td>
		</tr>
	</tbody>
</table>