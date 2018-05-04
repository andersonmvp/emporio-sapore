<?php

function woo_floating_cart_template($slug, $vars = array(), $return = false) {

	$plugin = woo_floating_cart();	
	$plugin_path = $plugin->plugin_path('public');
	$template_path = $plugin->template_path();
	$debug_mode = defined('WOOFC_TEMPLATE_DEBUG_MODE') && WOOFC_TEMPLATE_DEBUG_MODE;
	
	$template = '';

	// Look in yourtheme/woo-floating-cart/slug.php
	if ( empty($template) && ! $debug_mode ) {
		
		$template = locate_template( array( $template_path . "{$slug}.php" ) );
	}
	
	// Get default slug.php
	if ( empty($template) && file_exists( $plugin_path . "templates/{$slug}.php" ) ) {
		$template = $plugin_path . "templates/{$slug}.php";
	}
	
	// Allow 3rd party plugins to filter template file from their plugin.
	$template = apply_filters( 'woo_floating_cart_template', $template, $slug );

	if ( $template ) {
		extract($vars);
		
		if(!$return) {
			require($template);
		}else{
			ob_start();
			require($template);
			$output = ob_get_contents(); 
			ob_end_clean();
			return $output;
		}	
	}
}

function woofc_class() {
	
	$classes = array('woofc');
	
	$position = woofc_option('position', 'bottom-right');
	$counter_position = woofc_option('counter_position', 'top-left');
	$keep_visible_on_empty = woofc_option('visible_on_empty', false);
	$visibility = woofc_option('visibility', 'show-on-all');

	if(!empty($position)) {
		$classes[] = 'woofc-pos-'.$position;
	}

	if(!empty($counter_position)) {
		$classes[] = 'woofc-counter-pos-'.$counter_position;
	}
		
	if(!empty($keep_visible_on_empty)) {
		$classes[] = 'woofc-force-visible';
	}

	if(!empty($visibility)) {
		$classes[] = 'woofc-'.$visibility;
	}

	if(WC()->cart->is_empty()) {
		$classes[] = 'woofc-empty';
	}

	$classes = apply_filters('woofc_container_class', $classes);
	
	echo implode(' ', $classes);
}

function woofc_attributes() {
	
	$attributes = array(
		'data-position' 		=> woofc_option('position', 'bottom-right'),
		'data-triggerevent' 	=> woofc_option('trigger_event_type', 'vclick'),
		'data-hoverdelay' 		=> woofc_option('trigger_hover_delay', 0),
		'data-flytocart' 		=> woofc_option('flytocart_animation', '1'),
		'data-flyduration'		=> woofc_option('flytocart_animation_duration', '650'),
		'data-shaketrigger' 	=> woofc_option('shake_trigger', 'vertical'),
		'data-opencart-onadd'	=> woofc_option('open_cart_on_product_add', '0'),
		'data-loadingtimeout' 	=> woofc_option('loading_timeout', 100)
	);
	
	$attributes = apply_filters('woofc_container_attributes', $attributes);

	$data_string = '';
	foreach($attributes as $key => $value) {
		$data_string .= ' '.$key.'="'.esc_attr($value).'"';
	}

	echo $data_string;
}

function woofc_trigger_cart_icon_class() {
	
	$classes = array('woofc-trigger-cart-icon');
	
	$icon_type = woofc_option('trigger_icon_type', 'image');
	
	if($icon_type == 'font') {
		
		$icon = woofc_option('cart_trigger_icon');
		
		if(!empty($icon)) {
			$classes[] = $icon;
		}
	}

	$classes = apply_filters('woofc_trigger_cart_icon_class', $classes);
	
	echo implode(' ', $classes);	
}

function woofc_trigger_close_icon_class() {

	$classes = array('woofc-trigger-close-icon');
	
	$icon_type = woofc_option('trigger_icon_type', 'image');
	
	if($icon_type == 'font') {
		
		$icon = woofc_option('cart_trigger_close_icon');
		
		if(!empty($icon)) {
			$classes[] = $icon;
		}
	}

	$classes = apply_filters('woofc_trigger_close_icon_class', $classes);
	
	echo implode(' ', $classes);	
}

function woofc_get_spinner() {
	
	if(isset($_POST['customized']) && is_object($_POST['customized'])) {
		$customized = $_POST['customized'];
		if(!empty($customized->woofc["loading_spinner"])) {
			return $customized->woofc["loading_spinner"];
		}
	}
	return woofc_option('loading_spinner', '7-three-bounce');	
}

function woofc_spinner_html($return = false, $wrapSpinner = true) {
	
	$spinner_class = 'woofc-spinner';
	$spinner_type = woofc_get_spinner();
	
	if(empty($spinner_type)) {
		if($return) {
			return "";
		}	
	}

	switch($spinner_type) {
		
		case '1-rotating-plane':
		
			$spinner = '<div class="'.esc_attr($spinner_class).' woofc-spinner-rotating-plane"></div>';
			break;
		  
		case '2-double-bounce':
		
			$spinner = '
			<div class="'.esc_attr($spinner_class).' woofc-spinner-double-bounce">
		        <div class="woofc-spinner-child woofc-spinner-double-bounce1"></div>
		        <div class="woofc-spinner-child woofc-spinner-double-bounce2"></div>
		    </div>';
			break;
		
		case '3-wave':
		
			$spinner = '
			<div class="'.esc_attr($spinner_class).' woofc-spinner-wave">
		        <div class="woofc-spinner-rect woofc-spinner-rect1"></div>
		        <div class="woofc-spinner-rect woofc-spinner-rect2"></div>
		        <div class="woofc-spinner-rect woofc-spinner-rect3"></div>
		        <div class="woofc-spinner-rect woofc-spinner-rect4"></div>
		        <div class="woofc-spinner-rect woofc-spinner-rect5"></div>
		    </div>';
			break;
		
		case '4-wandering-cubes':
		
			$spinner = '
			<div class="'.esc_attr($spinner_class).' woofc-spinner-wandering-cubes">
		        <div class="woofc-spinner-cube woofc-spinner-cube1"></div>
		        <div class="woofc-spinner-cube woofc-spinner-cube2"></div>
		    </div>';
			break;
		
		case '5-pulse':
		
			$spinner = '<div class="'.esc_attr($spinner_class).' woofc-spinner-spinner-pulse"></div>';
			break;
		
		case '6-chasing-dots':
		
			$spinner = '
			<div class="'.esc_attr($spinner_class).' woofc-spinner-chasing-dots">
		        <div class="woofc-spinner-child woofc-spinner-dot1"></div>
		        <div class="woofc-spinner-child woofc-spinner-dot2"></div>
		    </div>';
			break;
		
		case '7-three-bounce':
		
			$spinner = '
			<div class="'.esc_attr($spinner_class).' woofc-spinner-three-bounce">
		        <div class="woofc-spinner-child woofc-spinner-bounce1"></div>
		        <div class="woofc-spinner-child woofc-spinner-bounce2"></div>
		        <div class="woofc-spinner-child woofc-spinner-bounce3"></div>
		    </div>';
			break;
		
		case '8-circle':
		
			$spinner = '
			<div class="'.esc_attr($spinner_class).' woofc-spinner-circle">
		        <div class="woofc-spinner-circle1 woofc-spinner-child"></div>
		        <div class="woofc-spinner-circle2 woofc-spinner-child"></div>
		        <div class="woofc-spinner-circle3 woofc-spinner-child"></div>
		        <div class="woofc-spinner-circle4 woofc-spinner-child"></div>
		        <div class="woofc-spinner-circle5 woofc-spinner-child"></div>
		        <div class="woofc-spinner-circle6 woofc-spinner-child"></div>
		        <div class="woofc-spinner-circle7 woofc-spinner-child"></div>
		        <div class="woofc-spinner-circle8 woofc-spinner-child"></div>
		        <div class="woofc-spinner-circle9 woofc-spinner-child"></div>
		        <div class="woofc-spinner-circle10 woofc-spinner-child"></div>
		        <div class="woofc-spinner-circle11 woofc-spinner-child"></div>
		        <div class="woofc-spinner-circle12 woofc-spinner-child"></div>
		    </div>';
			break;
		
		case '9-cube-grid':
		
			$spinner = '
			<div class="'.esc_attr($spinner_class).' woofc-spinner-cube-grid">
		        <div class="woofc-spinner-cube woofc-spinner-cube1"></div>
		        <div class="woofc-spinner-cube woofc-spinner-cube2"></div>
		        <div class="woofc-spinner-cube woofc-spinner-cube3"></div>
		        <div class="woofc-spinner-cube woofc-spinner-cube4"></div>
		        <div class="woofc-spinner-cube woofc-spinner-cube5"></div>
		        <div class="woofc-spinner-cube woofc-spinner-cube6"></div>
		        <div class="woofc-spinner-cube woofc-spinner-cube7"></div>
		        <div class="woofc-spinner-cube woofc-spinner-cube8"></div>
		        <div class="woofc-spinner-cube woofc-spinner-cube9"></div>
		    </div>';
			break;
			
		case '10-fading-circle':
		
			$spinner = '
			<div class="'.esc_attr($spinner_class).' woofc-spinner-fading-circle">
		        <div class="woofc-spinner-circle1 woofc-spinner-circle"></div>
		        <div class="woofc-spinner-circle2 woofc-spinner-circle"></div>
		        <div class="woofc-spinner-circle3 woofc-spinner-circle"></div>
		        <div class="woofc-spinner-circle4 woofc-spinner-circle"></div>
		        <div class="woofc-spinner-circle5 woofc-spinner-circle"></div>
		        <div class="woofc-spinner-circle6 woofc-spinner-circle"></div>
		        <div class="woofc-spinner-circle7 woofc-spinner-circle"></div>
		        <div class="woofc-spinner-circle8 woofc-spinner-circle"></div>
		        <div class="woofc-spinner-circle9 woofc-spinner-circle"></div>
		        <div class="woofc-spinner-circle10 woofc-spinner-circle"></div>
		        <div class="woofc-spinner-circle11 woofc-spinner-circle"></div>
		        <div class="woofc-spinner-circle12 woofc-spinner-circle"></div>
		    </div>';
			break;
		
		case '11-folding-cube':
		
			$spinner = '
			<div class="'.esc_attr($spinner_class).' woofc-spinner-folding-cube">
		        <div class="woofc-spinner-cube1 woofc-spinner-cube"></div>
		        <div class="woofc-spinner-cube2 woofc-spinner-cube"></div>
		        <div class="woofc-spinner-cube4 woofc-spinner-cube"></div>
		        <div class="woofc-spinner-cube3 woofc-spinner-cube"></div>
		    </div>';
			break;
			
		case 'loading-text':
			
			$spinner = '<div class="'.esc_attr($spinner_class).' woofc-spinner-loading-text">'.esc_html__('Loading...', 'woo-floating-cart').'</div>';	
			break;
	}
	
	$spinner = '<div class="woofc-spinner-inner">'.$spinner.'</div>';
	
	if($wrapSpinner) {
		$spinner = '<div class="woofc-spinner-wrap">'.$spinner.'</div>';
	}	
	
	if($return) {
		return $spinner;
	}
	
	echo $spinner;
}

function woofc_checkout_link() {
	
	$checkout_link = woofc_option('cart_checkout_link', 'checkout');
	
	if($checkout_link == 'checkout') {
	
		$link = wc_get_checkout_url();
		
	}else{
		
		$link = wc_get_cart_url();
	}
	
	return apply_filters('woo_floating_cart_checkout_link', $link);
}

function woofc_checkout_label() {
	
	$checkout_link = woofc_option('cart_checkout_link', 'checkout');
	
	if($checkout_link == 'checkout') {
	
		$label = esc_html__('Checkout', 'woo-floating-cart');
		
	}else{
		
		$label = esc_html__('Cart', 'woo-floating-cart');
	}	
	
	return $label;
}

function woofc_checkout_total() {

	return strip_tags(apply_filters('woo_floating_cart_checkout_total', WC()->cart->get_cart_subtotal()));
}

function woofc_item_product(&$cart_item, $cart_item_key) {
	
	return apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
}

function woofc_item_permalink(&$product, &$cart_item, $cart_item_key) {
	
	return esc_url(apply_filters( 'woocommerce_cart_item_permalink', $product->is_visible() ? $product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key ));
}

function woofc_item_title(&$product, &$cart_item, $cart_item_key) {
	
	return apply_filters( 'woocommerce_cart_item_name', $product->get_title(), $cart_item, $cart_item_key );
}

function woofc_item_image(&$product, &$cart_item, $cart_item_key) {
	
	return apply_filters( 'woocommerce_cart_item_thumbnail', $product->get_image(), $cart_item, $cart_item_key );
}

function woofc_item_price(&$product, &$cart_item, $cart_item_key) {
	
	$qty = woofc_item_qty($cart_item, $cart_item_key);
	return strip_tags(apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $product, $qty ), $cart_item, $cart_item_key ));
}

function woofc_item_qty(&$cart_item, $cart_item_key) {
	
	return strip_tags(apply_filters( 'woocommerce_widget_cart_item_quantity', $cart_item['quantity'], $cart_item, $cart_item_key ));
}

function woofc_get_cart_item($car_item_key) {
	
	$cart_content = WC()->cart->get_cart();
	if(!empty($cart_content[$car_item_key])) {
		return $cart_content[$car_item_key];
	}
	return null;
}
	
function woofc_item_attributes(&$cart_item) {
	
	$display_type = woofc_option('cart_product_attributes_display', 'list');
	$hide_attribute_label = (bool)woofc_option('cart_product_attributes_hide_label', 0);
	
	$class = array('woofc-variation');
	$class[] = 'woofc-variation-'.$display_type;
	
	$class = implode(' ', $class);
	
	$html = '';
	$item_data = array();
	if ( $cart_item['data']->is_type( 'variation' ) && is_array( $cart_item['variation'] ) ) {
      	foreach ( $cart_item['variation'] as $name => $value ) {
			if(!is_string($value)) {
				continue;	
			}
			
			$taxonomy = wc_attribute_taxonomy_name( str_replace( 'attribute_pa_', '', urldecode( $name ) ) );

	        // If this is a term slug, get the term's nice name
	        if ( taxonomy_exists( $taxonomy ) ) {
	          $term = get_term_by( 'slug', $value, $taxonomy );
	          if ( ! is_wp_error( $term ) && $term && $term->name ) {
	            $value = $term->name;
	          }
	          $label = wc_attribute_label( $taxonomy );
	
	        // If this is a custom option slug, get the options name.
	        } else {
	          $value = apply_filters( 'woocommerce_variation_option_name', $value );
	          $label = wc_attribute_label( str_replace( 'attribute_', '', $name ), $cart_item['data'] );
	        }

	        $item_data[] = array(
	          'key'   => $label,
	          'value' => $value,
	        );
	    }
	}
	
	// Filter item data to allow 3rd parties to add more to the array
    $item_data = apply_filters( 'woocommerce_get_item_data', $item_data, $cart_item );

    // Format item data ready to display
    foreach ( $item_data as $key => $data ) {
      	// Set hidden to true to not display meta on cart.
	  	if ( ! empty( $data['hidden'] ) ) {
        	unset( $item_data[ $key ] );
			continue;
      	}
	  	$key     = ! empty( $data['key'] ) ? $data['key'] : $data['name'];
	  	$display = ! empty( $data['display'] ) ? $data['display'] : $data['value'];
	  	$display = strip_tags($display);
      
      	$html .= '<dl class="'.esc_attr($class).'">';
		if($hide_attribute_label) {
			$html .= '	<dt>'.ucfirst(wp_kses_post( $display )).'</dt>';
		}else{
			$html .= '	<dt>'.esc_html( $key ).':</dt><dd>'.ucfirst(wp_kses_post( $display )).'</dd>';
		}	
		$html .= '</dl>';
		
    }       

	return apply_filters('woo_floating_cart_attributes', $html);
}

function woofc_get_echo_function($function_name, $params) {
	
	if(!function_exists($function_name)) {
		return '';
	}
	
	extract($params);
	
	ob_start();
    $function_name();
    return ob_get_clean();
}

function woofc_get_variation_data_from_variation_id( $item_id ) {
    $_product = new WC_Product_Variation( $item_id );
    $variation_data = $_product->get_variation_attributes();
    return $variation_data;
}

function woofc_option($id, $default = '') {
	
	if(!class_exists('Woo_Floating_Cart_Customizer')) {
		return $default;
	}
	return Woo_Floating_Cart_Customizer::get_option($id);
}

function woofc_is_action($action) {
	
	if(!empty($_GET['woofcaction']) && $_GET['woofcaction'] == $action) {
		return true;
	}
	return false;
}
