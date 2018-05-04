<?php

Kirki::add_field( self::$config_id, array(
	'settings' => self::field_id('cart_header_bg_color'),
	'section'  => self::section_id('header'),
	'label'    => esc_html__( 'Cart Header Bg Color', 'woo-floating-cart' ),
	'type'     => 'color',
	'priority' => 10,
	'default'  => '#ffffff',
	'transport'=>'auto',
	'output' => array(
		array(
			'element'  => '.woofc-inner .woofc-header',
			'property' => 'background',
		)
	)
));

Kirki::add_field( self::$config_id, array(
	'settings' => self::field_id('cart_header_bottom_border_color'),
	'section'  => self::section_id('header'),
	'label'    => esc_html__( 'Cart Header Bottom Border Color', 'woo-floating-cart' ),
	'type'     => 'color',
	'priority' => 10,
	'default'  => '#e6e6e6',
	'transport'=>'auto',
	'output' => array(
		array(
			'element'  => '.woofc-inner .woofc-header',
			'property' => 'border-color',
		)
	)
));

Kirki::add_field( self::$config_id, array(
	'settings' => self::field_id('cart_header_title_color'),
	'section'  => self::section_id('header'),
	'label'    => esc_html__( 'Cart Header Title Color', 'woo-floating-cart' ),
	'type'     => 'color',
	'priority' => 10,
	'default'  => '#181818',
	'transport'=>'auto',
	'output' => array(
		array(
			'element'  => '.woofc-inner .woofc-title',
			'property' => 'color',
		)
	)
));

Kirki::add_field( self::$config_id, array(
	'settings' => self::field_id('cart_header_undo_color'),
	'section'  => self::section_id('header'),
	'label'    => esc_html__( 'Cart Header Undo Msg Color', 'woo-floating-cart' ),
	'type'     => 'color',
	'priority' => 10,
	'default'  => '#808b97',
	'transport'=>'auto',
	'output' => array(
		array(
			'element'  => '.woofc-inner .woofc-undo',
			'property' => 'color',
		)
	)
));

Kirki::add_field( self::$config_id, array(
	'settings' => self::field_id('cart_header_undo_link_color'),
	'section'  => self::section_id('header'),
	'label'    => esc_html__( 'Cart Header Undo Link Color', 'woo-floating-cart' ),
	'type'     => 'multicolor',
	'priority' => 10,
	'choices'     => array(
        'link'    => esc_attr__( 'Color', 'woo-floating-cart' ),
        'hover'   => esc_attr__( 'Hover', 'woo-floating-cart' )
    ),
	'default'     => array(
        'link'    => '#2b3e51',
        'hover'   => '#2b3e51'
    ),
	'transport'=>'auto',
	'output' => array(
		array(
			'choice'   => 'link',
			'element'  => '.woofc-inner .woofc-undo a',
			'property' => 'color',
		),
		array(
			'choice'   => 'hover',
			'element'  => array('.woofc-no-touchevents .woofc-inner .woofc-undo a:hover', '.woofc-touchevents .woofc-inner .woofc-undo a:focus'),
			'property' => 'color',
		)
	)
));


Kirki::add_field( self::$config_id, array(
	'settings' => self::field_id('cart_header_error_color'),
	'section'  => self::section_id('header'),
	'label'    => esc_html__( 'Cart Header Error Msg Color', 'woo-floating-cart' ),
	'type'     => 'color',
	'priority' => 10,
	'default'  => '#dd3333',
	'transport'=>'auto',
	'output' => array(
		array(
			'element'  => '.woofc-inner .woofc-cart-error',
			'property' => 'color',
		)
	)
));
