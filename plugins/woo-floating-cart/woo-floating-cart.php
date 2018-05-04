<?php
/*
 * Woo Floating Cart
 *	
 * Plugin Name: Woo Floating Cart
 * Plugin URI: http://xplodedthemes.com/products/woo-floating-cart/
 * Description: An Interactive Floating Cart for WooCommerce that slides in when the user decides to buy an item. Fully customizable right from WordPress Customizer with Live Preview. Products, quantities and prices are updated instantly via Ajax.
 * Version: 1.1.2
 * Author: XplodedThemes
 * Author URI: http://www.xplodedthemes.com
 * Requires at least: 3.8
 * Tested up to: 4.9.4
 *
 * Text Domain: woo-floating-cart
 * Domain Path: /languages/
 *
 * @package	Woo_Floating_Cart
 * @author  XplodedThemes <helpdesk@xplodedthemes.com>
 * @since 	1.0.0
 *
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 */
 
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}
	
if ( ! defined( 'WOOFC_VERSION' ) ) {
	define('WOOFC_VERSION', '1.1.2');
}	

if ( ! defined( 'WOOFC_MARKET' ) ) {
	
	$market = 'edd';
	
	if(strpos($market, 'XT_MARKET') !== false) {
		$market = 'edd';
	}
	
	define('WOOFC_MARKET', $market);
}	

// Detect Lite or Full version
$woofc_lite = !is_dir(plugin_dir_path( __FILE__ ) . 'includes/customizer');

if(!$woofc_lite && !defined( 'WOOFC_PRO' )) {
	
	define('WOOFC_PRO', true);
	define('WOOFC_PRO_PLUGIN', __FILE__);
	
}else if($woofc_lite && !defined( 'WOOFC_LITE' )){
	
	define('WOOFC_LITE', true);
	define('WOOFC_LITE_PLUGIN', __FILE__);
}

// Load plugin if no other instances are loaded
if(!class_exists('Woo_Floating_Cart')) {

	/**
	 * The code that runs during plugin activation.
	 * This action is documented in includes/class-activator.php
	 */
	
	function woo_floating_cart_activate() {
		require_once plugin_dir_path( __FILE__ ) . 'includes/class-activator.php';
		Woo_Floating_Cart_Activator::activate();
	}
	register_activation_hook( __FILE__, 'woo_floating_cart_activate' );
	
	
	/**
	 * The code that runs during plugin deactivation.
	 * This action is documented in includes/class-deactivator.php
	 */
	
	function woo_floating_cart_deactivate() {
		require_once plugin_dir_path( __FILE__ ) . 'includes/class-deactivator.php';
		Woo_Floating_Cart_Deactivator::deactivate();
	}
	register_deactivation_hook( __FILE__, 'woo_floating_cart_deactivate' );
	

	/**
	 * Deactivate the lite version if activated along the full version.
	 */
	 	
	function woo_floating_cart_check_upgraded() {
	
	  	if ( defined('WOOFC_LITE') && defined('WOOFC_PRO')) {
		  	require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
	     	deactivate_plugins( plugin_basename( WOOFC_LITE_PLUGIN ));
	  	}
	}
	add_action( 'plugins_loaded', 'woo_floating_cart_check_upgraded', 1 );
	
	/**
	 * Global functions used to access multiple class public methods.
	 */
	require plugin_dir_path( __FILE__ ) . 'includes/global-functions.php';
	
	/**
	 * The core plugin class that is used to define internationalization,
	 * admin-specific hooks, and public-facing site hooks.
	 */
	require plugin_dir_path( __FILE__ ) . 'includes/class-core.php';
	
	/**
	 * Begins execution of the plugin.
	 *
	 * Since everything within the plugin is registered via hooks,
	 * then kicking off the plugin from this point in the file does
	 * not affect the page life cycle.
	 *
	 * @since    1.0.0
	 */
	function woo_floating_cart() {
		
		return Woo_Floating_Cart::instance(__FILE__, WOOFC_VERSION);
	}
	woo_floating_cart();
}
