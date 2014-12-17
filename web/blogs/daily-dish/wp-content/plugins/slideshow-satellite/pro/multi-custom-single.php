<select name="section">
	<?php echo esc_attr($this -> Slide -> data -> section); ?>	
        <option value="All">All</option>
  
	<?php 
        $slidenum = $this->get_option('custslide');
        for ($i = 1; $i <= $slidenum; $i++) { ?>
		<option <?php echo ((int) $_GET['single'] == $i) ? 'selected="selected"' : ''; ?> value="<?php echo($i) ?>">Custom <?php echo($i) ?></option>
	<?php } ?>
</select>