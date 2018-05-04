<?php
/*
  Plugin Name: Checkout Address Autocomplete for WooCommerce
  Description: Allows your customers to autocomplete billing and shipping addresses on the checkout page using the Google Maps API.
  Author: eCreations
  Author URI: https://www.ecreations.net
  Plugin URI: https://www.ecreations.net
  Text Domain: checkout-address-autocomplete-for-woocommerce
  Version: 1.9.6
  Requires at least: 3.0.0
  Tested up to: 4.9.5
 */

// Load plugin if WooCommerce plugin is activated, then check if API key has been saved

function ecr_addrac_init () {
  if (class_exists( 'WooCommerce' )) {
    if( get_option( 'ecr_addrac_key' ) ) {
      add_action('wp_footer', 'ecr_addrac_scripts');
    }else{
      add_action( 'admin_notices', 'ecr_addrac_missing_key_notice' );
    }
  }else{
    add_action( 'admin_notices', 'ecr_addrac_missing_wc_notice' );
  }
}
add_action( 'init', 'ecr_addrac_init' );

// Load Frontend Javascripts

function ecr_addrac_scripts() {
    if(is_checkout() || is_account_page()){
        if(get_option('ecr_force_enqueue_gmap')==true){
          wp_enqueue_script('google-autocomplete', 'https://maps.googleapis.com/maps/api/js?v=3&libraries=places&key='.get_option( 'ecr_addrac_key' ));
          wp_enqueue_script('rp-autocomplete', plugin_dir_url( __FILE__ ) . 'autocomplete.js');
        }else{
          google_maps_script_loader();
        }
    }
  }


function google_maps_script_loader() {
    global $wp_scripts; $gmapsenqueued = false;
    foreach ($wp_scripts->queue as $key) {
      if(array_key_exists($key, $wp_scripts->registered)) {
        $script = $wp_scripts->registered[$key];
        if (preg_match('#maps\.google(?:\w+)?\.com/maps/api/js#', $script->src)) {
          $gmapsenqueued = true;
        }
      }
    }

    if (!$gmapsenqueued) {
        wp_enqueue_script('google-autocomplete', 'https://maps.googleapis.com/maps/api/js?v=3&libraries=places&key='.get_option( 'ecr_addrac_key' ));
    }
    wp_enqueue_script('rp-autocomplete', plugin_dir_url( __FILE__ ) . 'autocomplete.js');
}

// Admin Error Messages

function ecr_addrac_missing_wc_notice() {
  ?>
  <div class="error notice">
      <p><?php _e( 'You need to install and activate WooCommerce in order to use Checkout Address Autocomplete WooCommerce!', 'checkout-address-autocomplete-for-woocommerce' ); ?></p>
  </div>
  <?php
}

function ecr_addrac_missing_key_notice() {
  ?>
  <div class="update-nag notice">
      <p><?php _e( 'Please <a href="options-general.php?page=ecr_addrac">enter your Google Maps Javascript API Key</a> in order to use Checkout Address Autocomplete for WooCommerce!', 'checkout-address-autocomplete-for-woocommerce' ); ?></p>
  </div>
  <?php
}

// Admin Settings Menu

function ecr_addrac_menu(){
  add_options_page( 'Checkout Address Autocomplete for WooCommerce',
                'Checkout Address Autocomplete', 
                'manage_options', 
                'ecr_addrac', 
                'ecr_addrac_page', 
                'dashicons-location', 
                101 );
  add_action( 'admin_init', 'update_ecr_addrac' );
}
add_action( 'admin_menu', 'ecr_addrac_menu' );

// Admin Settings Page

function ecr_addrac_page(){
?>
<div class="wrap">
  <h1>Checkout Address Autocomplete for WooCommerce</h1>
  <p>Paste your API key below and click "Save Changes" in order to enable the address autocomplete dropdown on the WooCommerce checkout page.</p>
  <p><a href="https://developers.google.com/maps/documentation/javascript/get-api-key" target="_blank">Click here to get your API Key &raquo;</a></p>
  <form method="post" action="options.php">
    <?php settings_fields( 'ecr-addrac-settings' ); ?>
    <?php do_settings_sections( 'ecr-addrac-settings' ); ?>
    <table class="form-table">
      <tr valign="top">
      <th scope="row">Google Maps Javascript<br />API Key:</th>
      <td><input type="text" name="ecr_addrac_key" value="<?php echo get_option( 'ecr_addrac_key' ); ?>"/></td>
      </tr>
      <tr valign="top">
      <th scope="row">Force Enqueue<br />Google Maps JS:</th>
      <td><input type="checkbox" name="ecr_force_enqueue_gmap" value="true" <?php if(get_option('ecr_force_enqueue_gmap')==true)echo 'checked'; ?>/></td>
      </tr>
    </table>
    <?php submit_button(); ?>
  </form>
</div>
<?php
}

// Save Plugin Settings (API Key)

function update_ecr_addrac() {
  register_setting( 'ecr-addrac-settings', 'ecr_addrac_key' );
  register_setting( 'ecr-addrac-settings', 'ecr_force_enqueue_gmap' );
}
