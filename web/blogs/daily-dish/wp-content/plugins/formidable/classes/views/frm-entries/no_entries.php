<?php 
if(!isset($colspan))
$colspan = (isset($form_cols)) ? count($form_cols)+1 : ''; 

$form->options = maybe_unserialize($form->options);

if(isset($form->options['no_save']) and $form->options['no_save']){ ?>
<h3><?php _e('This form is not set to save any entries.', 'formidable') ?></h3>
<p>If you would like entries in this form to be saved, go to the <a href="<?php echo esc_url(admin_url('admin.php?page=formidable') . '&frm_action=settings&id='. $form->id) ?>">form Settings</a> page and uncheck the "Do not store any entries submitted from this form" box.</p> 
<?php    
}else{
?>
    <h3><?php _e("You don't have any entries in this form.", 'formidable') ?><br/> <?php _e('How to publish', 'formidable') ?>:</h3>
    </td></tr>
    <tr class="alternate"><td colspan="<?php echo $colspan ?>">
        <h3><?php _e('Option 1: Generate your shortcode', 'formidable') ?></h3>
        <ol>
        <li><?php _e('Go to your WordPress page or post.', 'formidable') ?></li>
        <li class="alignleft" style="width:45%"><?php _e('Click on the form icon above the content box to open a popup with additional options.', 'formidable') ?><br/>
        <img alt="" src="http://static.strategy11.com.s3.amazonaws.com/insert-shortcode-icon.png" align="none"></li>
        <li class="alignright" style="width:45%"><?php _e('Select your form from the dropdown and check the boxes to show the title and description if desired.', 'formidable') ?><br/>
        <img alt="" src="http://static.strategy11.com.s3.amazonaws.com/insert-form-shortcode.png" align="none"></li>
        <li class="alignright" style="width:45%"><?php _e('Click the "Insert Form" button.', 'formidable') ?></li>
        </ol>
        <div class="clear"></div>
    </td></tr>
    <tr><td colspan="<?php echo $colspan ?>">
        <h3><?php _e('Option 2: Add a Widget', 'formidable') ?></h3>
        <ol class="alignleft" style="margin-right:30px;">
            <li><?php _e('Drag a "Formidable Form" widget into your sidebar.', 'formidable') ?></li>
            <li><?php _e('Select a form from the "Form" drop-down.', 'formidable') ?></li>
            <li><?php _e('Click the "Save" button', 'formidable') ?></li>
        </ol>
        <img src="<?php echo FRM_URL ?>/screenshot-2.png" alt="<?php echo esc_attr(__('Formidable Form Widget', 'formidable')) ?>" title="<?php echo esc_attr(__('Formidable Form Widget', 'formidable')) ?>" height="261" width="252" />
    </td></tr>
    <tr class="alternate"><td colspan="<?php echo $colspan ?>">    
        <h3><?php _e('Option 3: Insert the shortcode or PHP', 'formidable') ?></h3>
        <p><?php _e('Insert the following shortcode in your page, post, or text widget. This will be replaced with your form:', 'formidable') ?><br/>
            <input type="text" style="text-align:center;font-weight:bold;width:500px;" readonly="true" onclick="this.select();" onfocus='this.select();' value='[formidable id=<?php echo $form->id; ?>]' />
        </p>
        <p><?php _e('Show the form with the title and description:', 'formidable') ?><br/>
            <input type="text" style="text-align:center;font-weight:bold;width:500px;" readonly="true" onclick="this.select();" onfocus='this.select();' value='[formidable id=<?php echo $form->id; ?> title=true description=true]' />
        </p>
        
        <p><?php _e('Insert into a theme template file:', 'formidable') ?><br/>
            <input type="text" style="text-align:center;font-weight:bold;width:500px;" readonly="true" onclick="this.select();" onfocus="this.select();" value="echo FrmEntriesController::show_form(<?php echo $form->id; ?>, $key='', $title=true, $description=true);" />
        </p>
<?php } ?>