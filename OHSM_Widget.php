<?php

//Create the ohsm widget

class ohsm_widget extends WP_Widget {

        
	public $get_resp_btn_label;
	
	public $ohsm_site_nav_menus;
	
   
    //constuctor
    
    function __construct (){
                
        $this->name = __('OH Sliding Menu', 'wp_widget_plugin');        
      
		$this->get_resp_btn_label = get_option('ohsm_responsive_btn_label');
		
		$this->ohsm_site_nav_menus = get_terms( 'nav_menu', array( 'hide_empty' => true ) );	
        
        parent::__construct (false, $this->name);
		
    }

        // widget form creation
        function form($instance) { 
            // Check values
            if ($instance) {
                $title = esc_attr($instance['title']);
                $text = esc_attr($instance['text']);
				$noshow = esc_attr($instance['noshow']);				
				$menuTypeRadio = esc_attr($instance['menuTypeRadio']);
				$ohsm_menuName = esc_attr($instance['ohsm_menuName']);
				$ohsm_exclude_ids = esc_attr($instance['ohsm_exclude_ids']);
				
            } else {
                $title = '';
                $text = '';
				$noshow = '';				
				$menuTypeRadio = 'type2';
				$ohsm_menuName = '';
				$ohsm_exclude_ids = '';
            } 

			?>
			
            <p>
                <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Widget Title', 'ohsm_widget_plugin'); ?></label>
                <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
            </p>
			<p>
				<?php echo "<h4>" . __('Select the type of the sidebar menu:', 'ohsm_widget_plugin') . "</h4>";?>        
				<input id="<?php echo $this->get_field_id('menuTypeRadio'); ?>" type="radio" name="<?php echo $this->get_field_name('menuTypeRadio'); ?>" value="type2" <?php if($menuTypeRadio == "type2") {echo "checked";}?>
				onclick="document.getElementById('<?php echo $this->get_field_id('ohsm_exclude_ids'); ?>').readOnly = false; document.getElementById('<?php echo $this->get_field_id('ohsm_menu_select'); ?>').disabled = true;"/> Pages menu 
				<br/>
				
				<input id="<?php echo $this->get_field_id('menuTypeRadio'); ?>" type="radio" name="<?php echo $this->get_field_name('menuTypeRadio'); ?>" value="type1" <?php if($menuTypeRadio == "type1") {echo "checked";}?>
				onclick="document.getElementById('<?php echo $this->get_field_id('ohsm_exclude_ids'); ?>').readOnly = true; document.getElementById('<?php echo $this->get_field_id('ohsm_menu_select'); ?>').disabled = false;"/> Custom menu 
				<br/>			
			</p>
			<p>
			
			<?php
			echo "<h4>" . __('Select the name of the Custom sidebar menu:', 'ohsm_widget_plugin') . "</h4>";
			?>
				<select name="<?php echo $this->get_field_name('ohsm_menuName'); ?>" id="<?php echo $this->get_field_id('ohsm_menu_select'); ?>" <?php 
				
				if ($menuTypeRadio == "type2"){
					
					echo esc_attr("disabled");                
				}
				
				?>>
					<option>-- Select a menu --</option>
				<?php  foreach($this->ohsm_site_nav_menus as $menu)

					{
					$opt_val = $menu->name;
					?>
					<option <?php if($ohsm_menuName == $opt_val) {echo esc_attr('selected');}?> value="<?php echo esc_attr($opt_val);?>"> 
					<?php echo _e($opt_val);?>  
					</option>
				<?php }?>
				</select><br/>
			
			</p>
			
			<p>
				<?php
				echo "<h4>" . __('IDs excluded from the Pages menu:', 'ohsm_widget_plugin') . "</h4>";
				?>
				<input autocomplete="off" class="widefat" type="text" name="<?php echo $this->get_field_name('ohsm_exclude_ids'); ?>" id="<?php echo $this->get_field_id('ohsm_exclude_ids'); ?>" <?php 
				
				if ($menuTypeRadio == "type1"){
					
					echo esc_attr("readonly");                
				}
				?>
				value="<?php echo esc_attr($ohsm_exclude_ids);?>"/>
				<p><strong><i>(<?php _e("Comma separated ids of pages you want to exclude from the Pages menu. Ex.: 2,3,4", "ohsm_widget_plugin");?>)</i></strong></p>
			</p>          
			
			<p> 
			    <strong><label for="<?php echo $this->get_field_id('noshow'); ?>"><?php _e('DO NOT show widget on the following pages or posts: ', 'ohsm_widget_plugin'); ?></label></strong>
                <input autocomplete="off" class="widefat" id="<?php echo $this->get_field_id('noshow'); ?>" name="<?php echo $this->get_field_name('noshow'); ?>" type="text" value="<?php echo esc_attr($noshow); ?>" />
				<p><strong><i><?php _e('(Comma separated page or post IDs. Ex.: 2,3,4)', 'ohsm_widget_plugin'); ?></i></strong></p>
			</p>
			
			<?php 

			
	}
		
    // widget update
    function update($new_instance, $old_instance) {
      
	  $instance = $old_instance;
      // Fields
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['text'] = strip_tags($new_instance['text']);
	
		
		//Start ohsm_menuName validation for existing menu and revert fallback to pages if menu does not existing
		if($new_instance['menuTypeRadio'] == 'type1'){
		$ohsm_navs = array();
		foreach($this->ohsm_site_nav_menus as $ohsm_site_nav => $ohsm_site_nav_menu_name){
			$ohsm_navs[] = $ohsm_site_nav_menu_name->name;
		}
			if(is_array($ohsm_navs) && array_search($new_instance['ohsm_menuName'], $ohsm_navs) !== false){			

				$instance['menuTypeRadio'] = strip_tags($new_instance['menuTypeRadio']);
				$instance['ohsm_menuName'] = strip_tags($new_instance['ohsm_menuName']);
				
			} else {
				
					$instance['ohsm_menuName'] = '';
					
					$instance['menuTypeRadio'] = strip_tags('type2');	
					
					add_action('in_widget_form', 'ohsm_menu_warn');
			}
		
					function ohsm_menu_warn(){
						
					echo "<div class='notice notice-warning'><p><strong>";						
					_e('Nav menu does not exist or you did not select a menu from the list. Reverted to Pages menu.<br> To dismiss this notice just refresh the page.', 'ohsm_widget_plugin');				 
					echo "</p></strong></div>"; 
					}	
		}
		else{
			$instance['menuTypeRadio'] = strip_tags($new_instance['menuTypeRadio']);
			$instance['ohsm_menuName'] = strip_tags($new_instance['ohsm_menuName']);
		}
		//Start noshow validation for non-digit chars and remove the non digit chars
		
		if(preg_match("/[a-z\.]/",$new_instance['noshow'])) {
			
			add_action('in_widget_form', 'noshow_error_warn');
		}
			function noshow_error_warn(){
				
				echo "<div class='notice notice-warning'><p><strong>";						
				_e('Please use only comma separated numeric characters, no decimals, in the "DO NOT show widget on ..." box!<br><br> Unwanted characters have been removed. To dismiss this notice just refresh the page.', 'ohsm_widget_plugin');				 
				echo "</p></strong></div>"; 
			}
		
		$noshow_arr = explode(',', $new_instance['noshow']);
		
		foreach ($noshow_arr as $key => $value){
			
		if(ctype_digit($value)){
						
				$noshow_arr[$key] = $value;		
			
			}
			else {
				
				unset($noshow_arr[$key]);	
								
				}				
		
		} 
			$new_instance['noshow'] = implode(',',$noshow_arr);
			$instance['noshow'] = strip_tags($new_instance['noshow']);
		
	
		//End noshow validation
		
		//Start ohsm_exclude_ids validation for non-digit chars and remove the non digit chars
		
		if(preg_match("/[a-z\.]/",$new_instance['ohsm_exclude_ids'])) {
			
			add_action('in_widget_form', 'ohsm_exclude_ids_arr_error_warn');
		}
			function ohsm_exclude_ids_arr_error_warn(){
				
			echo "<div class='notice notice-warning'><p><strong>";				
			_e('Please use only comma separated numeric characters, no decimals, in the "IDs excluded from the Pages menu" box!<br><br> Unwanted characters have been removed. To dismiss this notice just refresh the page.', 'ohsm_widget_plugin');			 
			echo "</p></strong></div>"; 
			}
		$ohsm_exclude_ids_arr = explode(',',$new_instance['ohsm_exclude_ids']);
		
		foreach ($ohsm_exclude_ids_arr as $ex_key => $ex_value){
			
			if(ctype_digit($ex_value)){
				
				$ohsm_exclude_ids_arr[$ex_key] = $ex_value;				
			}
			else {				
					unset($ohsm_exclude_ids_arr[$ex_key]);			
							
			}
		} 
			$new_instance['ohsm_exclude_ids'] = implode(',',$ohsm_exclude_ids_arr);
			$instance['ohsm_exclude_ids'] = strip_tags($new_instance['ohsm_exclude_ids']);
			
		//End ohsm_exclude_ids validation 				
	  
     return $instance;
    }
    
   
    // widget display
    function widget($args, $instance) {
    
	extract( $args );
	//echo "<pre>"; print_r($instance); echo "</pre>";
			
        $title = apply_filters('widget_title', $instance['title']);
        $text = $instance['text'];
		$menuTypeRadio = $instance['menuTypeRadio'];
		$ohsm_menuName = $instance['ohsm_menuName'];
		$ohsm_exclude_ids = $instance['ohsm_exclude_ids'];		
		$noshow = $instance['noshow'];
		       
        $navbar_hidden_btns = '<button class="ohsm_navButton">
                                    <span>'. $this->get_resp_btn_label .'</span>
                                    </button>
                                    <br>';        
        $nav_start = '<nav class="ohsm_nav">';
        echo $before_widget . $navbar_hidden_btns. $nav_start;
        // Display the widget
        
        // Check if title is set
        if ( $title ) {
           echo  $before_title . $title . $after_title; 
        }

        // Check if menuTypeRadio is set
        if( $menuTypeRadio ) {

           if($menuTypeRadio == "type1" && is_nav_menu($ohsm_menuName)){ //Fallsback to Pages menu if nav menu has been deleted
			
           wp_nav_menu( 
                   array( 
                       'menu' => $ohsm_menuName, 
                       'menu_class' => 'menu ohsm_req ' . $args['widget_id'], 
                       'menu_id' => 'ohsm_req',
                       'walker' => new Walker_ohsm_Menu()
                       ));                      
           }
           
           else {
               
           wp_page_menu(
                   array(
                    'title_li' => '',
                    'show_home' => 0,
                    'menu_order' => 'menu_order',
                    'exclude' => $ohsm_exclude_ids,
                    'before' => '<ul class="menu ohsm_req ' . $args['widget_id'] . '" id="ohsm_req">', 
                    'after' => '</ul>',
                    'walker' => new Walker_ohsm_Menu_Pages()
                       ));
           
           }
        }
 
        echo $after_widget . "</nav>";
   
	}
    }
     // Register ohsm widget
    	function register_ohsm_widget (){
						
			register_widget("ohsm_widget");
		}
	add_action('widgets_init', 'register_ohsm_widget');	
    

