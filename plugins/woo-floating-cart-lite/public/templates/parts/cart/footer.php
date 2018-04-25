<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the cart footer.
 *
 * This template can be overridden by copying it to yourtheme/woo-floating-cart/parts/cart/footer.php.
 *
 * HOWEVER, on occasion we will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * @link       http://xplodedthemes.com
 * @since      1.0.6.3
 *
 * @package    Woo_Floating_Cart
 * @subpackage Woo_Floating_Cart/public/templates/parts
 */
 
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
} 
?>

<div class="woofc-footer">
	
	<a href="<?php echo woofc_checkout_link(); ?>" class="woofc-checkout woofc-btn">
		<em>
			<?php echo esc_html__('Checkout', 'woo-floating-cart'); ?> - 
			<span class="amount"><?php echo woofc_checkout_total(); ?></span>
		</em>
	</a>
	
	<?php woo_floating_cart_template('parts/trigger'); ?>
	
</div>
