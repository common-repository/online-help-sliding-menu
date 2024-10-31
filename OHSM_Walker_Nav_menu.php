<?php

//Extend Walker Nav Menu by adding ohsm icons

class Walker_ohsm_Menu extends Walker_Nav_Menu {
        
        

    public function start_lvl( &$output, $depth = 0, $args = array() ) {
	                if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
	                        $t = '';
	                        $n = '';                                
	                } else {
	                        $t = "\t";
	                        $n = "\n";
	                }
	                $indent = str_repeat( $t, $depth );
                        $ohsm_style = " style='display:none;'";
	                // Default class.
	                $classes = array( 'ohsm-sub-menu sub-menu' );
	
	                $class_names = join( ' ', apply_filters( 'nav_menu_submenu_css_class', $classes, $args, $depth ) );
	                $class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';
	
	                $output .= "{$n}{$indent}<ul$class_names {$ohsm_style}'>{$n}";
	        }
                
    public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
   
		if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
                        $t = '';
	                $n = '';                          
                } else {
                	$t = "\t";
			$n = "\n";
		}
         
		$indent = ( $depth ) ? str_repeat( $t, $depth ) : '';
                
                $ohsm_icons_file = "<span id='icons'><span style='visibility: hidden;' class='glyphicon glyphicon-menu-right'>&nbsp;</span><span id='folder' class='glyphicon glyphicon-file'>&nbsp;</span></span>";
                $ohsm_icons_folder = "<span id='icons'><span id='sign' class='glyphicon glyphicon-menu-right'>&nbsp;</span><span id='folder' class='glyphicon glyphicon-folder-close'>&nbsp;</span></span>";
                
		$classes = empty( $item->classes ) ? array() : (array) $item->classes;
		$classes[] = 'ohsm-menu-item menu-item-' . $item->ID;

	
		$args = apply_filters( 'nav_menu_item_args', $args, $item, $depth );


		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args, $depth ) );
		$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';


		$id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args, $depth );
		$id = $id ? ' id="' . esc_attr( $id ) . '"' : '';
                
                if ( $this->has_children ){
		$output .=  $indent . '<li' . $id . $class_names .'>';
                }
                
                else {
                $output .=  $indent . '<li' . $id . $class_names .'>';
                }
		$atts = array();
		$atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
		$atts['target'] = ! empty( $item->target )     ? $item->target     : '';
		$atts['rel']    = ! empty( $item->xfn )        ? $item->xfn        : '';
		$atts['href']   = ! empty( $item->url )        ? $item->url        : '';


		$atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );

		$attributes = '';
		foreach ( $atts as $attr => $value ) {
			if ( ! empty( $value ) ) {
				$value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
				$attributes .= ' ' . $attr . '="' . $value . '"';
			}
		}

		/** This filter is documented in wp-includes/post-template.php */
		$title = apply_filters( 'the_title', $item->title, $item->ID );


		$title = apply_filters( 'nav_menu_item_title', $title, $item, $args, $depth );
                
		$item_output = $args->before;
              
                
                if ( $this->has_children ){
                    $item_output .= '<a'. $attributes .'>' . $ohsm_icons_folder;
                }
                else {
		$item_output .= '<a'. $attributes .'>' . $ohsm_icons_file;
                }
		$item_output .= $args->link_before . $title . $args->link_after;
		$item_output .= '</a>';
		$item_output .= $args->after;
                
		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );              
              
	}            
    }

