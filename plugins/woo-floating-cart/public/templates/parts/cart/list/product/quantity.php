<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the cart list product item quantity.
 *
 * This template can be overridden by copying it to yourtheme/woo-floating-cart/parts/cart/list/product/quantity.php.
 *
 * Available global vars: $product, $cart_item, $cart_item_key
 *
 * HOWEVER, on occasion we will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * @link       http://xplodedthemes.com
 * @since      1.0.8
 *
 * @package    Woo_Floating_Cart
 * @subpackage Woo_Floating_Cart/public/templates/parts
 */
 
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
} 
?>

<span class="woofc-quantity">

	<?php
	if ( $product->is_sold_individually() ) {

		echo sprintf( '<input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key );
		
	} else {
		
		echo sprintf( 
			'<input type="number" name="cart[%s][qty]" value="%s" step="1" min="0" max="%s" />', 
			$cart_item_key, 
			woofc_item_qty($cart_item, $cart_item_key),
			$product->backorders_allowed() || $product->get_stock_quantity() === null ? '99999' : $product->get_stock_quantity()
		);
		
		echo '	
	  	<span class="woofc-quantity-changer">
	    	<span class="woofc-quantity-button woofc-quantity-up"><i class="woofcicon-flat-plus"></i></span>
			<span class="woofc-quantity-button woofc-quantity-down"><i class="woofcicon-flat-minus"></i></span>  
		</span>';
	
	}
	?>

</span>
