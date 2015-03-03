<div class="wrap">
<div id="icon-options-general" class="icon32"><br></div>
<h2>FaceBook Recommendations Settings</h2>

<form method="POST" action="">
 
	<table border="0" class="form-table">
		<thead>
		</thead>
		<tr>
			<td width=120>Domain</td>
			<td><input type="text" name="like[domain]" size="20" value="<?php echo $like[domain]; ?>"></td>
		</tr>
		<tr>
			<td width=100>Height</td>
			<td>
			<input type="text" value="<?php echo $like['height']; ?>" name="like[height]" size="11"> 
			px</td>
		</tr>
		<tr>
			<td>Width</td>
			<td><input type="text" value="<?php echo $like['width']; ?>" name="like[width]" size="11"> px</td>
		</tr>
		<tr>
			<td>Show Header</td>
			<td><input type="checkbox" name="like[showheader]"  <?php if($like[showheader]=='1') echo 'checked'; ?>  value="1"></td>
		</tr>
		<tr>
			<td>Font</td>
			<td><select id="param_font" name="like[font]" size="1">
			<option selected="1"></option>
			<option value="arial"  <?php if($like[font]=='arial') echo 'selected'; ?> >arial</option>
			<option value="lucida grande"  <?php if($like[font]=='lucida grande') echo 'selected'; ?> >lucida grande</option>
			<option value="segoe ui"  <?php if($like[font]=='segoe ui') echo 'selected'; ?> >segoe ui</option>
			<option value="tahoma"  <?php if($like[font]=='tahoma') echo 'selected'; ?> >tahoma</option>
			<option value="trebuchet ms"  <?php if($like[font]=='trebuchet ms') echo 'selected'; ?> >trebuchet ms</option>
			<option value="verdana"  <?php if($like[font]=='verdana') echo 'selected'; ?> >verdana</option>
			</select>
			</td>
		</tr>
		<tr>
			<td>Color Scheme</td>
			<td><select id="param_colorscheme" name="like[colorscheme]" size="1"><option selected="1" value="light">light</option><option value="dark" <?php if($like[colorscheme]=='dark') echo 'selected'; ?>>dark</option></select></td>
		</tr>
		<tr>
			<td>Border Color</td>
			<td><input type="text" name="like[bordercolor]" value="<?php echo $like[bordercolor]; ?>" size="14"></td>
		</tr>
		<tr>
			<td colspan="2"><input class="button-primary" type="submit" value="Submit" name="B1"> <input class="button-secondary" type="reset" value="Reset" name="B2"></td>
		</tr>
	</table>
	 
</form>

</div>
&nbsp;<p> 
To add
recommendation plugin go to <a href="widgets.php">Widgets</a>
and Drag and Drop <code>`<b>FB Recommendations</b>`</code> widget on your sidebar. Or just cal the 
following functions anywhere you want to show the plugin:<br>
<code>&lt;?php FB_Recommendations(); ?&gt;</code>

</p>
<p>&nbsp;</p>
