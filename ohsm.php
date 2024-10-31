<?php 
/*
Plugin Name: Online Help Sliding Menu
Plugin URI: 
Description: Transform a normal sidebar menu (custom or pages list) into a responsive online help style sliding menu and style it with custom CSS
Version: 1.3
Author: Fabian Balaceanu
Licence: GPLv2
*/
defined('ABSPATH') or die('No script kiddies please!');

define( 'ohsm_URL',     plugin_dir_url( __FILE__ )  );

define( 'ohsm_PATH',    plugin_dir_path( __FILE__ ) );

define( 'ohsm_VERSION', '1.3'                     );

//Include core ohsm files        
        
function ohsm_core() {
    
    include (ohsm_PATH . 'OHSM_Walker_Nav_menu.php');
    include (ohsm_PATH . 'OHSM_Walker_Pages.php');
    include (ohsm_PATH . 'OHSM_Widget.php');
    
}

ohsm_core();

//Include options page files and add action

function ohsm_admin() {
    include (ohsm_PATH . 'ohsm_import_admin.php');
}
function ohsm_admin_actions() {

  add_options_page("Online Help Sliding Menu", "Online Help Sliding Menu", "manage_options", "OHSMSetup", "ohsm_admin"); 
}
 
add_action('admin_menu', 'ohsm_admin_actions');

/*
	Create default options
*/

function ohsm_default_settings () {

//Build default OHSM options on plugin activation for the first time
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
		
	if(!get_option('ohsm_custom_css')){
		add_option('ohsm_custom_css',strip_tags($ohsm_initial_custom_css));
	}	
	if(!get_option ('ohsm_BstOn')) {
		add_option('ohsm_BstOn', 'off');
	}
	if(!get_option ('ohsm_responsive_btn_label')) {
		add_option('ohsm_responsive_btn_label', 'SHOW/HIDE MENU');
	}
	
}
register_activation_hook( __FILE__ , 'ohsm_default_settings');
/*
    Loads the ohsm js.
*/

function load_ohsm_js() {

    
$ohsm_get_bst_state = get_option ('ohsm_BstOn');

    if($ohsm_get_bst_state == "on") {

        wp_register_script('load_bootstrap_js-ohsm', ohsm_URL . 'js/bootstrap/3.3.6/bootstrap.min.js',array('jquery'),'', false);
        wp_enqueue_script('load_bootstrap_js-ohsm');
        
        //Exception in this function for Bootstrap CSS - other css scripts registered and enqueued with other function
        wp_register_style( 'bootstrap-ohsm', ohsm_URL . 'css/bootstrap/3.3.6/bootstrap.min.css' );
        wp_enqueue_style('bootstrap-ohsm');

    }

        wp_register_script('load_menuFunctions',  ohsm_URL . 'js/OnlineHelpSlidingMenu.js',array('jquery'),'', true);
        wp_enqueue_script('load_menuFunctions');

    
}

add_action( 'wp_enqueue_scripts', 'load_ohsm_js');


if(isset($_GET['page']) && $_GET['page'] == 'OHSMSetup'){					
add_action( 'admin_enqueue_scripts', function() {

    // Enqueue code editor and settings for manipulating CSS.
	if(function_exists('wp_enqueue_code_editor')){
    $settings = wp_enqueue_code_editor( array( 'type' => 'text/css' ) );
 
    // Bail if user disabled CodeMirror.
    if ( false === $settings ) {
        return;
    }
 
    wp_add_inline_script(
        'code-editor',
        sprintf(
            'jQuery( function() { wp.codeEditor.initialize( "ohsm-css", %s ); } );',
            wp_json_encode( $settings )
        )
    );
	}
} );
}
/*
 * End of loading ohsm js.
 */ 

/*
    Loads the ohsm stylesheets
*/ 
   
function ohsm_styles_method() {

wp_enqueue_style( 'OnlineHelpSlidingMenu', ohsm_URL . 'css/menuItems.css' );

$ohsm_css_data = get_option('ohsm_custom_css');

wp_add_inline_style( 'OnlineHelpSlidingMenu', $ohsm_css_data );

}

add_action( 'wp_enqueue_scripts', 'ohsm_styles_method', '11' );

/*
 * End of loading ohsm stylesheets.
 */ 
 

// Hide widget on pages/posts based on ID
	
	function ohsm_sidebars_output($sidebars_widgets){
		
		$ohsm_widgets_arr = get_option('widget_ohsm_widget'); // get all instances of ohsm widgets
		$ohsm_sidebar_locations = get_option('sidebars_widgets');// get all sidebars

		if ( ! is_admin() && is_array($ohsm_widgets_arr) ) {	
			
			foreach($ohsm_widgets_arr as $ohsm_key => $ohsm_value){	
			
				$ohsm_noshow_arr = explode(',',$ohsm_widgets_arr[$ohsm_key]['noshow']);
				
				if(in_array(get_the_ID(),$ohsm_noshow_arr)){
					
					$ohsm_noshow_widget_id = 'ohsm_widget-'.$ohsm_key;
					
					foreach($ohsm_sidebar_locations as $ohsm_sidebar_location => $ohsm_loc){

						if(is_array($ohsm_loc) && in_array($ohsm_noshow_widget_id, $ohsm_loc)){
							
							if(count($ohsm_sidebar_locations[$ohsm_sidebar_location]) < 2){
								
								if($ohsm_sidebar_location !== ''){
								
									unset($sidebars_widgets[$ohsm_sidebar_location]); //hide sidebar that shows the ohsm widget, if no other widgets are present on that sidebar
						
								}
								
							} else {
								
								if(is_array($ohsm_loc)){
								
									foreach($ohsm_loc as $ohsm_widget_key => $ohsm_widget_key_value) {								
										
										if($ohsm_loc[$ohsm_widget_key] == $ohsm_noshow_widget_id){
	
											unset($sidebars_widgets[$ohsm_sidebar_location][$ohsm_widget_key]); //hide the ohsm widget from the sidebar, if other widgets are present on that sidebar
										
										}
									}
								}
							}									
						}
							
					}
				}
			}
		}	
		
		return $sidebars_widgets;

	}

	add_filter( 'sidebars_widgets', 'ohsm_sidebars_output' );
	
	function ohsm_check_nav_menus() {
	$ohsm_widgets_arr = get_option('widget_ohsm_widget'); // get all instances of ohsm widgets
	
		if ( is_admin()&& is_array($ohsm_widgets_arr)) {
		
			foreach($ohsm_widgets_arr as $ohsm_widget => $ohsm_widget_settings)
			{
				if(!is_nav_menu($ohsm_widget_settings['ohsm_menuName']) && is_numeric($ohsm_widget) && $ohsm_widget_settings['ohsm_menuName'] != ''){
					echo "<div class='error notice-warning'><p>";						
					_e('<strong>Error:</strong> The selected custom menu for Online Help Sliding Menu widget: "<strong>' .$ohsm_widget_settings['title']. '</strong>" no longer exists. The <strong>Pages</strong> menu is now displayed on the frontend instead.<br><br> 
					Please select another custom menu!', 'ohsm_widget_plugin');				 
					echo "</p></div>"; 
				}
			}			
		}
	}
	add_action('admin_notices','ohsm_check_nav_menus');
	
	