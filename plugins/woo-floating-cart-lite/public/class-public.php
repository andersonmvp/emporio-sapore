<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://xplodedthemes.com
 * @since      1.0.0
 *
 * @package    Woo_Floating_Cart
 * @subpackage Woo_Floating_Cart/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Woo_Floating_Cart
 * @subpackage Woo_Floating_Cart/public
 * @author     XplodedThemes <helpdesk@xplodedthemes.com>
 */
class Woo_Floating_Cart_Public {

	/**
	 * Core class reference.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      obj    core    Core Class
	 */
	private $core;


	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param    obj    $core    Plugin core class
	 */
	public function __construct( &$core ) {

		$this->core = $core;
		
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Woo_Floating_Cart_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Woo_Floating_Cart_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_register_style('woofcicons', $this->core->plugin_url( 'public' ) . 'assets/css/woofcicons.css', array(), $this->core->plugin_version(), 'all' );
		wp_enqueue_style('woofcicons');

		wp_register_style( $this->core->plugin_slug(), $this->core->plugin_url( 'public' ) . 'assets/css/woo-floating-cart.css', array(), $this->core->plugin_version(), 'all' );
		wp_enqueue_style( $this->core->plugin_slug());

		if(is_rtl()) {
			wp_register_style( $this->core->plugin_slug('rtl'), $this->core->plugin_url( 'public' ) . 'assets/css/rtl.css', array($this->core->plugin_slug()), $this->core->plugin_version(), 'all' );
			wp_enqueue_style( $this->core->plugin_slug('rtl'));
		}
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Woo_Floating_Cart_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Woo_Floating_Cart_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		// LOAD WOOCOMMERCE DEPENDENCIES
		$wc_suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
		$wc_ajax_cart_enabled    = 'yes' === get_option( 'woocommerce_enable_ajax_add_to_cart' );
		$wc_assets_path          = str_replace( array( 'http:', 'https:' ), '', WC()->plugin_url() ) . '/assets/';
		$wc_frontend_script_path = $wc_assets_path . 'js/frontend/';
		
		if ( $wc_ajax_cart_enabled ) {
			wp_enqueue_script( 'wc-add-to-cart', $wc_frontend_script_path . 'add-to-cart' . $wc_suffix . '.js' );
		}
		wp_enqueue_script( 'wc-cart-fragments', $wc_frontend_script_path . 'cart-fragments' . $wc_suffix . '.js', array( 'jquery', 'jquery-cookie' ) );
		
		// LOAD VENDORS
		wp_enqueue_script("jquery-effects-core");
		wp_enqueue_script( $this->core->plugin_slug('jquery.ajaxqueue'), $this->core->plugin_url( 'public' ) . 'assets/vendors/jquery.ajaxqueue'.$this->core->script_suffix.'.js', array( 'jquery' ), $this->core->plugin_version(), false );
		wp_enqueue_script( $this->core->plugin_slug('jquery.touch'), $this->core->plugin_url( 'public' ) . 'assets/vendors/jquery.touch'.$this->core->script_suffix.'.js', array( 'jquery' ), $this->core->plugin_version(), false );
        wp_enqueue_script( $this->core->plugin_slug('cookie'), $this->core->plugin_url( 'public' ) . 'assets/vendors/js.cookie'.$this->core->script_suffix.'.js', array( 'jquery' ), $this->core->plugin_version(), false );
		
		// MAIN SCRIPT
		wp_register_script( $this->core->plugin_slug(), $this->core->plugin_url( 'public' ) . 'assets/js/woo-floating-cart'.$this->core->script_suffix.'.js', array( 'jquery', 'wc-cart-fragments' ), $this->core->plugin_version(), false );
		
		$vars = array(
			'ajaxurl' => admin_url('admin-ajax.php'),
			'litemode' => defined('WOOFC_LITE'),
			'lang' => array(
				'min_qty_required' => esc_html__('Min quantity required', 'woo-floating-cart'),
				'max_stock_reached' => esc_html__('Stock limit reached', 'woo-floating-cart')
			)
		);
		
		wp_localize_script( $this->core->plugin_slug(), 'WOOFC', $vars );
		wp_enqueue_script($this->core->plugin_slug());
	}

	function add_to_cart($cart_item_key, $product_id, $quantity, $variation_id, $variation, $cart_item_data) {

		WC()->session->set( 'woofc_last_added', $cart_item_key);

		return $cart_item_key;		
	}
	
	function add_to_cart_fragments($fragments) {
		
		WC()->cart->calculate_totals();
		
		$list = woo_floating_cart_template('parts/cart/list', array(), true);
		$total = woofc_checkout_total();
		$count = WC()->cart->get_cart_contents_count();
		
		$fragments['woofc'] = array(
			'subtotal' => $total,
			'total_items' => $count,
		);	
		
		if(empty($_COOKIE['woofc_last_removed'])) {
			$fragments['.woofc-list'] = $list;
		}
		$fragments['.woofc-checkout span.amount'] = '<span class="amount">'.$total.'</span>';
		$fragments['.woofc-count li:nth-child(1)'] = '<li>'.$count.'</li>';
		$fragments['.woofc-count li:nth-child(2)'] = '<li>'.($count + 1).'</li>';
				
		return $fragments;
	}

	function remove_cart_item($cart_item_key, $wc_cart) {
		
		$position = array_search($cart_item_key, array_keys($wc_cart->cart_contents));
		WC()->session->set( 'woofc_removed_position', $position);
		
		WC()->cart->calculate_totals();
	}
	
	function cart_item_restored($cart_item_key, $wc_cart) {

		$position = WC()->session->get( 'woofc_removed_position');
		
		$restored_item = $wc_cart->cart_contents[$cart_item_key];
		
		$bundled_product = false;
		if(function_exists('wc_pb_is_bundled_cart_item')) {
			$bundled_product = true;
		}

		if(!$bundled_product) {
			
			unset($wc_cart->cart_contents[$cart_item_key]);
			
			$new_cart_contents = array();
			$i = 0;
			$repositioned = false;
			foreach($wc_cart->cart_contents as $key => $item) {
				
				if($i == $position) {
					$new_cart_contents[$cart_item_key] = $restored_item;
					$repositioned = true;
				}
				
				$new_cart_contents[$key] = $item;
				$i++;
			}
			
			if(!$repositioned) {
				$new_cart_contents[$cart_item_key] = $restored_item;
			}
			
			$wc_cart->cart_contents = $new_cart_contents;
		}
		
		WC()->session->__unset( 'woofc_removed_position');
		
		WC()->cart->calculate_totals();
	}
		
	function ajax_update_cart() {
		
		$error = false;
		
		$type = filter_var($_POST['type'], FILTER_SANITIZE_STRING);
		$cart_item_key = filter_var($_POST['cart_item_key'], FILTER_SANITIZE_STRING);

		$cart_item = null;
		$cart_item_qty = null;
		$cart_item_price = null;
		$product = null;
		$product_item = null;
		
		if($type == 'update' && !empty($cart_item_key)) {
		
			$cart_item_qty = intval($_POST['cart_item_qty']);  
			WC()->cart->set_quantity($cart_item_key, $cart_item_qty, true); 
			
		}else if($type == 'add') {
			
			$cart_item_key = WC()->session->get( 'woofc_last_added');

		}else if($type == 'remove' && !empty($cart_item_key)) {
			
			WC()->cart->remove_cart_item($cart_item_key); 
			WC()->session->set( 'woofc_last_removed', $cart_item_key);
			WC()->session->set( 'woofc_last_undo', null);
			
		}else if($type == 'undo' && !empty($cart_item_key)) {
			
			WC()->cart->restore_cart_item($cart_item_key);
			WC()->session->set( 'woofc_last_undo', $cart_item_key);
			WC()->session->set( 'woofc_last_removed', null);

		}else{
			
			$error = true;
		}

		$response = array(
			'error' => $error,
			'type' => $type
		);

		wp_send_json($response);
	}

	public function render() {

		woo_floating_cart_template('minicart');
	}	
}
