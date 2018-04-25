<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the cart list product item.
 *
 * This template can be overridden by copying it to yourtheme/woo-floating-cart/parts/cart/list/product.php.
 *
 * Available global vars: $cart_item, $cart_item_key, $product
 * 
 * HOWEVER, on occasion we will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * @link       http://xplodedthemes.com
 * @since      1.0.9.1
 *
 * @package    Woo_Floating_Cart
 * @subpackage Woo_Floating_Cart/public/templates/parts
 */
 
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
} 

$product_id   = $cart_item['product_id'];
$is_variable = woofc_item_attributes($cart_item);
$show_attributes = (bool)woofc_option('cart_product_show_attributes', false);

$classes = array();
$classes[] = 'woofc-product'; 
$classes[] = 'woofc-'.$product->get_type();

if(!empty($is_variable)) {
	$classes[] = 'woofc-variable-product';
}

$hide_product = false;

$bundled_product = false;
if(function_exists('wc_pb_is_bundled_cart_item') && wc_pb_is_bundled_cart_item($cart_item)) {
	$classes[] = 'woofc-bundled-item';
	$bundled_product = true;
	
	if(!empty($cart_item['bundled_by'])) {
		
		$bundled_by_item = woofc_get_cart_item($cart_item['bundled_by']);
		if(!empty($bundled_by_item)) {
			
			if(!empty($bundled_by_item['composite_parent'])) {
				$composite_product = true;
			}
		}
	}
}

$composite_product = false;
if(!empty($cart_item['composite_parent'])) {
	$classes[] = 'woofc-composite-item';
	$composite_product = true;
}

if($show_attributes) {
	$classes[] = 'woofc-show-attributes';
}

$classes = implode(' ', $classes);

$vars = array(
	'product' => $product,
	'cart_item' => $cart_item,
	'cart_item_key' => $cart_item_key
);
?>

<?php
if(!$bundled_product && !$composite_product):
?>

<li class="<?php echo esc_attr($classes); ?>" 
	data-key="<?php echo esc_attr($cart_item_key);?>" 
	data-id="<?php echo esc_attr($product_id);?>"
>

	<div class="woofc-product-image">
		
		<?php 
		woo_floating_cart_template('parts/cart/list/product/thumbnail', $vars); 
		?>
		
	</div>
	
	<div class="woofc-product-details">
		
		<?php 
		woo_floating_cart_template('parts/cart/list/product/title', $vars); 

		woo_floating_cart_template('parts/cart/list/product/price', $vars); 
		
		if(!empty($show_attributes)) {
			
			woo_floating_cart_template('parts/cart/list/product/variations', $vars); 
		}
		?>
		
		<div class="woofc-clearfix"></div>
		
		<?php
			woo_floating_cart_template('parts/cart/list/product/quantity', $vars); 
			woo_floating_cart_template('parts/cart/list/product/actions', $vars); 
		?>
		
	</div>
</li>

<?php
endif;
?>