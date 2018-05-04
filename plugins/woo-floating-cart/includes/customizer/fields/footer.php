<?php
Kirki::add_field( self::$config_id, array(
	'settings' => self::field_id('cart_checkout_button_bg_color'),
	'section'  => self::section_id('footer'),
	'label'    => esc_html__( 'Cart Checkout Button Bg Color', 'woo-floating-cart' ),
	'type'     => 'multicolor',
	'priority' => 10,
	'choices'     => array(
        'link'    => esc_attr__( 'Color', 'woo-floating-cart' ),
        'hover'   => esc_attr__( 'Hover', 'woo-floating-cart' )
    ),
	'default'     => array(
        'link'    => '#2c97de',
        'hover'   => '#2c97de'
    ),
	'transport'=>'auto',
	'output' => array(
		array(
			'choice'   => 'link',
			'element'  => '.woofc-inner a.woofc-checkout',
			'property' => 'background',
		),
		array(
			'choice'   => 'hover',
			'element'  => array('.woofc-no-touchevents .woofc-inner a.woofc-checkout:hover', '.woofc-touchevents .woofc-inner a.woofc-checkout:focus'),
			'property' => 'background',
		)
	)
));

Kirki::add_field( self::$config_id, array(
	'settings' => self::field_id('cart_checkout_button_text_color'),
	'section'  => self::section_id('footer'),
	'label'    => esc_html__( 'Cart Checkout Button Text Color', 'woo-floating-cart' ),
	'type'     => 'multicolor',
	'priority' => 10,
	'choices'     => array(
        'link'    => esc_attr__( 'Color', 'woo-floating-cart' ),
        'hover'   => esc_attr__( 'Hover', 'woo-floating-cart' )
    ),
	'default'     => array(
        'link'    => '#ffffff',
        'hover'   => '#ffffff'
    ),
	'transport'=>'auto',
	'output' => array(
		array(
			'choice'   => 'link',
			'element'  => '.woofc-cart-open .woofc-inner a.woofc-checkout',
			'property' => 'color',
		),
		array(
			'choice'   => 'hover',
			'element'  => array('.woofc-no-touchevents .woofc-cart-open .woofc-inner a.woofc-checkout:hover', '.woofc-touchevents .woofc-cart-open .woofc-inner a.woofc-checkout:focus'),
			'property' => 'color',
		)
	)
));


Kirki::add_field( self::$config_id, array(
	'settings'    => self::field_id('cart_checkout_link'),
	'section'     => self::section_id('footer'),
	'label'       => esc_html__( 'Cart Checkout Action', 'woo-floating-cart' ),
	'type'        => 'radio-buttonset',
	'choices'     => array(
		'checkout'	  => esc_attr__( 'Go to Checkout Page', 'woo-floating-cart' ),
		'cart'  => esc_attr__( 'Go to Cart Page', 'woo-floating-cart' )
	),
	'default'     => 'checkout',
	'priority'    => 10
));
