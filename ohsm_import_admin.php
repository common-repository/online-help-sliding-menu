<?php defined('ABSPATH') or die('No script kiddies please!');

if (current_user_can('manage_options')) {

	if (isset($_POST['ohsm_hidden_1'])){
		//Form data sent
		//Check nonce for action: ohsm_form_1_submit
		
		if(wp_verify_nonce( $_POST['ohsm_hidden_1'], 'ohsm_form_1_submit' )){
		
					
			//Set the status of the Bootstrap option checkbox
			if(isset($_POST['bst_on'])){
				$ohsm_bstOn = "on";
				update_option ('ohsm_BstON', $ohsm_bstOn);
			} else {
				$ohsm_bstOn = "off";
				update_option ('ohsm_BstON', $ohsm_bstOn);
			}
							
			//Set the label for the button that hides/shows the menu on responsive displays
			if(isset($_POST['ohsm_resp_menu_btn_label'])){
					$ohsm_responsive_btn_label_get = sanitize_text_field($_POST['ohsm_resp_menu_btn_label']);
					
					//Add default label if input text is deleted
						if ($ohsm_responsive_btn_label_get == '') {
							$ohsm_responsive_btn_label_get = 'SHOW/HIDE MENU';
						}
						
						update_option ('ohsm_responsive_btn_label', $ohsm_responsive_btn_label_get);
			}
			
			if(isset($_POST['ohsm_css'])) {
				
				$ohsm_custom_css = strip_tags($_POST['ohsm_css']);
				
				update_option('ohsm_custom_css', $ohsm_custom_css);
				
			}
//Declare initial css for display
$ohsm_initial_custom_css = 
'/*Online Help Sliding Menu INITIAL CSS*/

ul.ohsm_req, ul.ohsm_req ul {

	list-style-type: none;

}

ul.ohsm_req li::before {
		
	content: none;
}

ul.ohsm_req li.active > a {
		
	font-weight:bold;
	text-decoration: underline;
}';
					//Show the settings saved info
					?>
					<div class="updated"><p><strong><?php _e('Settings saved.', 'ohsm_widget_plugin'); ?></strong></p></div>
					<?php
		} else {
			
			echo __('Nonce verification failed!', 'nonce_verif_fail');
			exit;
		}
	}else {

		//Normal page display	
//Declare initial css for display
$ohsm_initial_custom_css = 
'/*Online Help Sliding Menu INITIAL CSS*/

ul.ohsm_req, ul.ohsm_req ul {

	list-style-type: none;

}

ul.ohsm_req li::before {
		
	content: none;
}

ul.ohsm_req li.active > a {
		
	font-weight:bold;
	text-decoration: underline;
}';		
		//Check if initial css is set and add default if option is missing from db
		$ohsm_custom_css = get_option('ohsm_custom_css');
		
		if(!$ohsm_custom_css){
			
			$ohsm_custom_css_added = add_option('ohsm_custom_css', strip_tags($ohsm_initial_custom_css)); // Add option with default css in db
			$ohsm_custom_css = get_option('ohsm_custom_css');
			if (!$ohsm_custom_css_added) {
			?>
			<div class="error"><p><strong><?php _e('Initial custom css option (ohsm_custom_css) missing from the Options table in your database.','ohsm_widget_plugin'); ?></strong></p></div>
			<?php
			}
			
		}
			

		//Check the current state of the Boostrasp css option
		$ohsm_bstOn = get_option ('ohsm_BstOn');
		
		//Make sure the option exists in the db, if not, try to add
		if (!$ohsm_bstOn) {
			
			$ohsm_bstOn_added = add_option('ohsm_BstOn', 'off'); //Add option in db; default is off
			$ohsm_bstOn = get_option ('ohsm_BstOn');
			if (!$ohsm_bstOn_added) {
			?>
			<div class="error"><p><strong><?php _e('Bootstrap option (ohsm_BstOn) missing from the Options table in your database.', 'ohsm_widget_plugin'); ?></strong></p></div>
			<?php
			}
		}
		
		//Check the responsive btn lable
		$ohsm_responsive_btn_label_get = get_option ('ohsm_responsive_btn_label');
		
		if (!$ohsm_responsive_btn_label_get || $ohsm_responsive_btn_label_get == '') {
			
			$ohsm_responsive_btn_label_get = 'SHOW/HIDE MENU';
			update_option('ohsm_responsive_btn_label', $ohsm_responsive_btn_label_get); //Add option in db; default is: SHOW/HIDE MENU
			$ohsm_responsive_btn_label_get = get_option ('ohsm_responsive_btn_label');
		}
	}
	?>

	<style type="text/css">
	/*CodeMirror settings*/

		div.CodeMirror {
			
			min-height: 600px!important;
			
		}
	</style>
	<div class="wrap">

		<?php
		
		if ($ohsm_bstOn == "on"){
			
			$ohsm_bst_checked = "checked";
						
		} else {
			
			$ohsm_bst_checked = "";
			
		}
		
		echo "<h2>" . __('Online Help Sliding Menu Setup', 'ohsm_widget_plugin') . "</h2>"; 
		
		$ohsm_site_nav_menus = get_terms( 'nav_menu', array( 'hide_empty' => true ) );?>
		   
		<div style="float:right">
		<table>
		<tr>
		<td style="text-align: center; margin: 1px; padding: 3px 5px;">
		<strong>PayPal Donation</strong>
		</td>
		<tr>
		<td>
		<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
			<input type="hidden" name="cmd" value="_s-xclick">
			<input type="hidden" name="hosted_button_id" value="8VQG8Y8SDZW8E">
			<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
			<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
		</form>
		</td>
		</tr>
		</table>
		</div>
		
		<hr>
		<form method="POST">
		<table>


		<tr>
			<td><p><?php  echo "<strong>" . _e('Enable BootstrapCSS from CDN?', 'ohsm_widget_plugin') . "</strong>"; ?> 
					
					<input type="checkbox" name="bst_on" value="bst_on" <?php echo esc_attr($ohsm_bst_checked); ?>/></p>
				
					<p><i>(<?php echo __("Some sections of this plugin might require BootstrapCSS to function. If you don't yet use BootstrapCSS on your website and you have any issues with the menu, try to select this checkbox.", "ohsm_widget_plugin");?>
					)</i></p>
			</td>
		</tr>
			<td>
				<p><?php  echo "<strong>" . _e('Add custom CSS rules:', 'ohsm_widget_plugin') . "</strong>"; ?></p>
			</td>
		<tr style="vertical-align:top">
			<td width=50%>
				<textarea id='ohsm-css' name='ohsm_css' rows='30' cols='50'><?php echo $ohsm_custom_css;?></textarea>
			</td>
			<td width=50% style='padding-left:20px'>
			<textarea readonly rows='18' cols='50' style='resize:none;'><?php echo $ohsm_initial_custom_css;?></textarea>	
			</td>
		</tr>
		
		<tr>
			<td>
				<p class="submit">
					<input type="submit" name="Submit" value="<?php _e('Save menu settings', 'ohsm_widget_plugin') ?>" />
				</p>
				<?php wp_nonce_field ('ohsm_form_1_submit', 'ohsm_hidden_1', true, true ); ?>
			</td>
		</tr>
		
	  </table>
	  
	  </form>

		<hr>
		<!-- CSS custom styling -->
		
		<?php 

		
		echo "<h4>" . _e("Menus with many pages may require an increased value for the MAX_INPUT_VARS PHP variable. Increase this value or check with your hosting provider to get this value increased.", "ohsm_widget_plugin") . "</h4>";?>
		
		<form method="POST">
		<table>
		<tr>
			<td>
			<?php 
			
			if (isset($_POST['ohsm_hidden_3'])){
				
				if(wp_verify_nonce( $_POST['ohsm_hidden_3'], 'ohsm_form_3_submit' )){
			
				echo "<div class='updated'><p><strong>" . __("Current value of the MAX_INPUT_VARS variable is: ", "ohsm_widget_plugin") ."</strong>".  ini_get('max_input_vars'). "</p></div>";
				
				} else {				
					echo _e('Nonce verification failed!', 'ohsm_widget_plugin');
					exit;
				}
			}
			
			?>
			</td>
		</tr>
		<tr>
			<td>
				<p class="submit">
					<input type="submit" name="ohsm_hidden_3" value="<?php _e('View MAX_INPUT_VARS value', 'ohsm_widget_plugin') ?>" />
				</p>
				<?php wp_nonce_field ('ohsm_form_3_submit', 'ohsm_hidden_3', true, true ); ?>
			</td>
		</tr>
		
		</table>
		
		</form>
		
	</div>
<?php } else {

	echo __('You do not have sufficient rights!', 'ohsm_widget_plugin');
	exit;
} 	