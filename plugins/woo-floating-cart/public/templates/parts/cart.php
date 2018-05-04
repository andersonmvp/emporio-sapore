<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the cart part of the minicart.
 *
 * This template can be overridden by copying it to yourtheme/woo-floating-cart/parts/cart.php.
 *
 * HOWEVER, on occasion we will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * @link       http://xplodedthemes.com
 * @since      1.0.2
 *
 * @package    Woo_Floating_Cart
 * @subpackage Woo_Floating_Cart/public/templates/parts
 */
 
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
} 
?>

<div class="woofc-inner">
	<div class="woofc-wrapper">
		
		<?php woo_floating_cart_template('parts/cart/header'); ?>
		
		<div class="woofc-body">
			
			<?php do_action( 'woofc_before_cart_list' ); ?>
			
			<?php woo_floating_cart_template('parts/cart/list'); ?>
		
			<?php do_action( 'woofc_cart_after_cart_list' ); ?>
			
		</div> <!-- .woofc-body -->

		<?php woo_floating_cart_template('parts/cart/footer'); ?>
		
		<?php woofc_spinner_html(); ?>
		
	</div> <!-- .woofc-wrapper -->
</div> <!-- .woofc-inner -->