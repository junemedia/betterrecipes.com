<?php
// create custom plugin settings menu
add_action('admin_menu', 'mts_create_menu');

function mts_create_menu() {
	add_options_page('Mobile Theme Switcher Settings', 'Mobile Theme Switcher', 'administrator', __FILE__, 'mts_settings_page');
	add_action('admin_init', 'register_mysettings');
}


function register_mysettings() {
	register_setting('mts-settings-group', 'mobile_theme');
}

function mts_settings_page() {
	
	$mobileTheme 	= get_option('mobile_theme');
	$ipadTheme		= get_option('ipad_theme');
	$androidTheme	= get_option('android_theme');
	
	$themeList 		= get_themes();
	$themeNames 	= array_keys($themeList); 
	$defaultTheme 	= get_current_theme();
	natcasesort($themeNames);
?>
<div class="wrap">
<h2>Mobile Theme Switcher Plugin</h2>
<p><strong>DO NOT UPDATE</strong> this plugin.  It has been modified to work with edge-caching</p>
<form method="post" action="options.php">
    <?php settings_fields( 'mts-settings-group' ); ?>
    <table class="form-table">
        <tr valign="top">
        <th scope="row">Mobile Theme:</th>
        <td>
        	<select name="mobile_theme"  />
     <?php 
      foreach ($themeNames as $themeName) {              
          if (($mobileTheme == $themeName) || (($mobileTheme == '') && ($themeName == $defaultTheme))) {
              echo '<option value="' . $themeName . '" selected="selected">' . htmlspecialchars($themeName) . '</option>';
          } else {
              echo '<option value="' . $themeName . '">' . htmlspecialchars($themeName) . '</option>';
          }
      }
     ?>
        	</select>
        </td>
        </tr>
    </table>
    
    <p class="submit">
    <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
    </p>

</form>
</div>
<?php } ?>
