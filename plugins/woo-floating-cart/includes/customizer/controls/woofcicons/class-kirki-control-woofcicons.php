<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Kirki_Control_Woofcicons' ) && class_exists('Kirki_Control_Base')) {


	/**
	 * Dashicons control (modified radio).
	 */
	class Kirki_Control_Woofcicons extends Kirki_Control_Base {

		/**
		 * The control type.
		 *
		 * @access public
		 * @var string
		 */
		public $type = 'woofcicons';


		/**
		 * Enqueue control related scripts/styles.
		 *
		 * @access public
		 */
		public function enqueue() {
			
			$plugin = woo_floating_cart();
			wp_enqueue_style( 'woofcicons', $plugin->plugin_url('public/assets/css', 'woofcicons.css'), array(), '1.0.0');
			wp_enqueue_style( 'kirki-woofcicons', plugin_dir_url(__FILE__).'css/woofcicons.css', array(), '1.0.0');
			wp_enqueue_script( 'kirki-woofcicons', plugin_dir_url(__FILE__).'js/woofcicons.js', array(), '1.0.0');
		}
		
		
		/**
		 * Refresh the parameters passed to the JavaScript via JSON.
		 *
		 * @access public
		 */
		public function to_json() {
			
			$icons = false;

			if(!empty($this->choices) && !empty($this->choices['types']) && is_array($this->choices['types'])) {
				
				$types = $this->choices['types'];
				$icons = array();
				foreach($types as $type) {
					$icons = array_merge($icons, self::get_icons($type));
				}
				$this->choices = $icons;
			} 
			
			parent::to_json();
			
			if($icons === false) {
				$this->json['icons'] = self::get_icons();
			}
		}

		/**
		 * An Underscore (JS) template for this control's content (but not its container).
		 *
		 * Class variables for this control class are available in the `data` JS object;
		 * export custom variables by overriding {@see Kirki_Customize_Control::to_json()}.
		 *
		 * @see WP_Customize_Control::print_template()
		 *
		 * @access protected
		 */
		protected function content_template() {
			?>
			<# if ( data.tooltip ) { #>
				<a href="#" class="tooltip hint--left" data-hint="{{ data.tooltip }}"><span class='woofcicons woofcicons-info'></span></a>
			<# } #>
			<# if ( data.label ) { #>
				<span class="customize-control-title">{{ data.label }}</span>
			<# } #>
			<# if ( data.description ) { #>
				<span class="description customize-control-description">{{{ data.description }}}</span>
			<# } #>
			<div class="icons-wrapper">
				<# if ( 'undefined' !== typeof data.choices && 1 < _.size( data.choices ) ) { #>
					<# for ( key in data.choices ) { #>
						<input {{{ data.inputAttrs }}} class="woofcicons-select" type="radio" value="{{ key }}" name="_customize-woofcicons-radio-{{ data.id }}" id="{{ data.id }}_{{ key }}" {{{ data.link }}}<# if ( data.value === key ) { #> checked="checked"<# } #>>
							<label for="{{ data.id }}_{{ key }}">
								<span class="{{ data.choices[ key ] }}"></span>
							</label>
						</input>
					<# } #>
				<# } else { #>
				
					<h4>Cart Icons</h4>
					<# for ( key in data.icons['cart'] ) { #>
						<input {{{ data.inputAttrs }}} class="woofcicons-select" type="radio" value="{{ data.icons['cart'][ key ] }}" name="_customize-woofcicons-radio-{{ data.id }}" id="{{ data.id }}_{{ data.icons['cart'][ key ] }}" {{{ data.link }}}<# if ( data.value === data.icons['cart'][ key ] ) { #> checked="checked"<# } #>>
							<label for="{{ data.id }}_{{ data.icons['cart'][ key ] }}">
								<span class="{{ data.icons['cart'][ key ] }}"></span>
							</label>
						</input>
					<# } #>
					
					<h4>Close Icons</h4>
					<# for ( key in data.icons['close'] ) { #>
						<input {{{ data.inputAttrs }}} class="woofcicons-select" type="radio" value="{{ data.icons['close'][ key ] }}" name="_customize-woofcicons-radio-{{ data.id }}" id="{{ data.id }}_{{ data.icons['close'][ key ] }}" {{{ data.link }}}<# if ( data.value === data.icons['close'][ key ] ) { #> checked="checked"<# } #>>
							<label for="{{ data.id }}_{{ data.icons['close'][ key ] }}">
								<span class="{{ data.icons['close'][ key ] }}"></span>
							</label>
						</input>
					<# } #>
					
				<# } #>
			</div>
			<?php
		}
		
			
		public function render_content() {
			echo 'laaaaaaa';
			self::print_template();
		}
		
		public static function get_icons($type = null) {
			
			$icons = array(
				
				'cart' => array(
					'woofcicon-bag' => 'woofcicon-bag',
					'woofcicon-bag-1' => 'woofcicon-bag-1',
					'woofcicon-bag-2' => 'woofcicon-bag-2',
					'woofcicon-bag-3' => 'woofcicon-bag-3',
					'woofcicon-bag-4' => 'woofcicon-bag-4',
					'woofcicon-bag-5' => 'woofcicon-bag-5',
					'woofcicon-bag-6' => 'woofcicon-bag-6',
					'woofcicon-basket' => 'woofcicon-basket',
					'woofcicon-basket-1' => 'woofcicon-basket-1',
					'woofcicon-basket-2' => 'woofcicon-basket-2',
					'woofcicon-basket-3' => 'woofcicon-basket-3',
					'woofcicon-basket-supermarket' => 'woofcicon-basket-supermarket',
					'woofcicon-business' => 'woofcicon-business',
					'woofcicon-business-1' => 'woofcicon-business-1',
					'woofcicon-business-2' => 'woofcicon-business-2',
					'woofcicon-cart' => 'woofcicon-cart',
					'woofcicon-cart-1' => 'woofcicon-cart-1',
					'woofcicon-cart-2' => 'woofcicon-cart-2',
					'woofcicon-cart-3' => 'woofcicon-cart-3',
					'woofcicon-cart-4' => 'woofcicon-cart-4',
					'woofcicon-cart-5' => 'woofcicon-cart-5',
					'woofcicon-cart-6' => 'woofcicon-cart-6',
					'woofcicon-cart-7' => 'woofcicon-cart-7',
					'woofcicon-commerce' => 'woofcicon-commerce',
					'woofcicon-commerce-1' => 'woofcicon-commerce-1',
					'woofcicon-commerce-10' => 'woofcicon-commerce-10',
					'woofcicon-commerce-11' => 'woofcicon-commerce-11',
					'woofcicon-commerce-12' => 'woofcicon-commerce-12',
					'woofcicon-commerce-13' => 'woofcicon-commerce-13',
					'woofcicon-commerce-14' => 'woofcicon-commerce-14',
					'woofcicon-commerce-2' => 'woofcicon-commerce-2',
					'woofcicon-commerce-3' => 'woofcicon-commerce-3',
					'woofcicon-commerce-4' => 'woofcicon-commerce-4',
					'woofcicon-commerce-5' => 'woofcicon-commerce-5',
					'woofcicon-commerce-6' => 'woofcicon-commerce-6',
					'woofcicon-commerce-7' => 'woofcicon-commerce-7',
					'woofcicon-commerce-8' => 'woofcicon-commerce-8',
					'woofcicon-commerce-9' => 'woofcicon-commerce-9',
					'woofcicon-empty-shopping-cart' => 'woofcicon-empty-shopping-cart',
					'woofcicon-food' => 'woofcicon-food',
					'woofcicon-full-items-inside-a-shopping-bag' => 'woofcicon-full-items-inside-a-shopping-bag',
					'woofcicon-groceries' => 'woofcicon-groceries',
					'woofcicon-groceries-store' => 'woofcicon-groceries-store',
					'woofcicon-interface' => 'woofcicon-interface',
					'woofcicon-market' => 'woofcicon-market',
					'woofcicon-market-1' => 'woofcicon-market-1',
					'woofcicon-market-2' => 'woofcicon-market-2',
					'woofcicon-market-3' => 'woofcicon-market-3',
					'woofcicon-market-4' => 'woofcicon-market-4',
					'woofcicon-online-shopping-cart' => 'woofcicon-online-shopping-cart',
					'woofcicon-restaurant' => 'woofcicon-restaurant',
					'woofcicon-shop' => 'woofcicon-shop',
					'woofcicon-shop-1' => 'woofcicon-shop-1',
					'woofcicon-shop-2' => 'woofcicon-shop-2',
					'woofcicon-shop-3' => 'woofcicon-shop-3',
					'woofcicon-shop-4' => 'woofcicon-shop-4',
					'woofcicon-shop-5' => 'woofcicon-shop-5',
					'woofcicon-shopping' => 'woofcicon-shopping',
					'woofcicon-shopping-1' => 'woofcicon-shopping-1',
					'woofcicon-shopping-bag' => 'woofcicon-shopping-bag',
					'woofcicon-shopping-bag-1' => 'woofcicon-shopping-bag-1',
					'woofcicon-shopping-bag-2' => 'woofcicon-shopping-bag-2',
					'woofcicon-shopping-bag-3' => 'woofcicon-shopping-bag-3',
					'woofcicon-shopping-bag-4' => 'woofcicon-shopping-bag-4',
					'woofcicon-shopping-bag-5' => 'woofcicon-shopping-bag-5',
					'woofcicon-shopping-bag-6' => 'woofcicon-shopping-bag-6',
					'woofcicon-shopping-basket' => 'woofcicon-shopping-basket',
					'woofcicon-shopping-basket-1' => 'woofcicon-shopping-basket-1',
					'woofcicon-shopping-basket-2' => 'woofcicon-shopping-basket-2',
					'woofcicon-shopping-basket-3' => 'woofcicon-shopping-basket-3',
					'woofcicon-shopping-basket-4' => 'woofcicon-shopping-basket-4',
					'woofcicon-shopping-basket-5' => 'woofcicon-shopping-basket-5',
					'woofcicon-shopping-basket-6' => 'woofcicon-shopping-basket-6',
					'woofcicon-shopping-basket-7' => 'woofcicon-shopping-basket-7',
					'woofcicon-shopping-basket-8' => 'woofcicon-shopping-basket-8',
					'woofcicon-shopping-basket-button' => 'woofcicon-shopping-basket-button',
					'woofcicon-shopping-cart' => 'woofcicon-shopping-cart',
					'woofcicon-shopping-cart-1' => 'woofcicon-shopping-cart-1',
					'woofcicon-shopping-cart-10' => 'woofcicon-shopping-cart-10',
					'woofcicon-shopping-cart-2' => 'woofcicon-shopping-cart-2',
					'woofcicon-shopping-cart-3' => 'woofcicon-shopping-cart-3',
					'woofcicon-shopping-cart-4' => 'woofcicon-shopping-cart-4',
					'woofcicon-shopping-cart-5' => 'woofcicon-shopping-cart-5',
					'woofcicon-shopping-cart-6' => 'woofcicon-shopping-cart-6',
					'woofcicon-shopping-cart-7' => 'woofcicon-shopping-cart-7',
					'woofcicon-shopping-cart-8' => 'woofcicon-shopping-cart-8',
					'woofcicon-shopping-cart-9' => 'woofcicon-shopping-cart-9',
					'woofcicon-shopping-cart-of-checkered-design' => 'woofcicon-shopping-cart-of-checkered-design',
					'woofcicon-shopping-purse-icon' => 'woofcicon-shopping-purse-icon',
					'woofcicon-store' => 'woofcicon-store',
					'woofcicon-supermarket-basket' => 'woofcicon-supermarket-basket',
					'woofcicon-tool' => 'woofcicon-tool',
					'woofcicon-tool-1' => 'woofcicon-tool-1',
					'woofcicon-tool-2' => 'woofcicon-tool-2',
					'woofcicon-tool-3' => 'woofcicon-tool-3',
				),
				'close' => array(
					'woofcicon-delete' => 'woofcicon-delete',
					'woofcicon-delete-1' => 'woofcicon-delete-1',
					'woofcicon-delete-2' => 'woofcicon-delete-2',
					'woofcicon-delete-3' => 'woofcicon-delete-3',					
					'woofcicon-cross' => 'woofcicon-cross',
					'woofcicon-cross-1' => 'woofcicon-cross-1',
					'woofcicon-close' => 'woofcicon-close',
					'woofcicon-close-1' => 'woofcicon-close-1',
					'woofcicon-close-2' => 'woofcicon-close-2',
					'woofcicon-close-3' => 'woofcicon-close-3',
					'woofcicon-close-4' => 'woofcicon-close-4',
					'woofcicon-close-5' => 'woofcicon-close-5',
					'woofcicon-close-7' => 'woofcicon-close-7',
					'woofcicon-circle' => 'woofcicon-circle',
					'woofcicon-close-6' => 'woofcicon-close-6',
					'woofcicon-close-8' => 'woofcicon-close-8',
					'woofcicon-close-9' => 'woofcicon-close-9',
					'woofcicon-arrow' => 'woofcicon-arrow',
					'woofcicon-arrows' => 'woofcicon-arrows',
					'woofcicon-arrows-1' => 'woofcicon-arrows-1',
					'woofcicon-arrows-10' => 'woofcicon-arrows-10',
					'woofcicon-arrows-11' => 'woofcicon-arrows-11',
					'woofcicon-arrows-2' => 'woofcicon-arrows-2',
					'woofcicon-arrows-3' => 'woofcicon-arrows-3',
					'woofcicon-arrows-4' => 'woofcicon-arrows-4',
					'woofcicon-arrows-5' => 'woofcicon-arrows-5',
					'woofcicon-arrows-6' => 'woofcicon-arrows-6',
					'woofcicon-arrows-7' => 'woofcicon-arrows-7',
					'woofcicon-arrows-8' => 'woofcicon-arrows-8',
					'woofcicon-arrows-9' => 'woofcicon-arrows-9'			
				),
				'plus' => array(
					'woofcicon-add-1' => 'woofcicon-add-1',
					'woofcicon-add' => 'woofcicon-add',
					'woofcicon-plus' => 'woofcicon-plus',
					'woofcicon-plus-1' => 'woofcicon-plus-1',
					'flaticon-woofcicon-flat-plus' => 'flaticon-woofcicon-flat-plus',				
				),
				'minus' => array(
					'woofcicon-substract' => 'woofcicon-substract',
					'woofcicon-substract-1' => 'woofcicon-substract-1',
					'woofcicon-minus' => 'woofcicon-minus',
					'woofcicon-minus-1' => 'woofcicon-minus-1',	
					'flaticon-woofcicon-flat-minus' => 'flaticon-woofcicon-flat-minus',				
				)
			);	
			
			if(!empty($type) && !empty($icons[$type])) {
				return $icons[$type];	
			}	
			
			return $icons;
		}
		
	}
}
