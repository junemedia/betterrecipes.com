<select name="Slide[section]">
	<?php echo esc_attr($this -> Slide -> data -> section); ?>	
  	<option <?php echo ((int) $this -> Slide -> data -> section == '1') ? 'selected="selected"' : ''; ?> value="1">Custom 1</option>

	<?php 
        $slidenum = $this->get_option('custslide');
        for ($i = 2; $i <= $slidenum; $i++) { ?>

		<option <?php echo ((int) $this -> Slide -> data -> section == $i) ? 'selected="selected"' : ''; ?> value="<?php echo($i) ?>">Custom <?php echo($i) ?></option>
	<?php } ?>
</select>