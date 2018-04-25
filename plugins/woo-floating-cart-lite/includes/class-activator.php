<?php

/**
 * Fired during plugin activation
 *
 * @link       http://xplodedthemes.com
 * @since      1.0.0
 *
 * @package    Woo_Floating_Cart
 * @subpackage Woo_Floating_Cart/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Woo_Floating_Cart
 * @subpackage Woo_Floating_Cart/includes
 * @author     XplodedThemes <helpdesk@xplodedthemes.com>
 */
class Woo_Floating_Cart_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		
		add_option('woofc_activation_redirect', true);
	}

}
