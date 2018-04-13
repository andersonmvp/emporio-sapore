<?php
/**
 * Shipping Calculator
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/shipping-calculator.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.2.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( 'no' === get_option( 'woocommerce_enable_shipping_calc' ) || ! WC()->cart->needs_shipping() ) {
	return;
}

wp_enqueue_script( 'wc-country-select' );

do_action( 'woocommerce_before_shipping_calculator' ); ?>

<form class="woocommerce-shipping-calculator" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">

	<h4 class="woocommerce-block-title mg-top-0"><?php _e( 'Calculate Shipping', 'g5plus-april' ); ?></h4>

	<section class="shipping-calculator-form">

	<p class="form-row form-row-wide" id="calc_shipping_country_field">
			<select name="calc_shipping_country" id="calc_shipping_country" class="country_to_state" rel="calc_shipping_state">
				<option value=""><?php _e( 'Select a country&hellip;', 'g5plus-april' ); ?></option>
				<?php
					foreach ( WC()->countries->get_shipping_countries() as $key => $value ) {
						echo '<option value="' . esc_attr( $key ) . '"' . selected( WC()->customer->get_shipping_country(), esc_attr( $key ), false ) . '>' . esc_html( $value ) . '</option>';
					}
				?>
			</select>
	</p>



		
		
		<?php if ( apply_filters( 'woocommerce_shipping_calculator_enable_postcode', true ) ) : ?>

			<p class="form-row form-row-wide" id="calc_shipping_postcode_field">
				<input type="text" class="input-text" value="<?php echo esc_attr( WC()->customer->get_shipping_postcode() ); ?>" placeholder="<?php esc_attr_e( 'Postcode / ZIP', 'g5plus-april' ); ?>" name="calc_shipping_postcode" id="calc_shipping_postcode" />
			</p>

		<?php endif; ?>

		<p><button type="submit" name="calc_shipping" value="1" class="button"><?php _e( 'Update Totals', 'g5plus-april' ); ?></button></p>

		<?php wp_nonce_field( 'woocommerce-cart' ); ?>
	</section>
</form>

<?php do_action( 'woocommerce_after_shipping_calculator' ); ?>
