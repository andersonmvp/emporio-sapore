<?php
	
Kirki::add_field( self::$config_id, array(
	'settings' => self::field_id('cart_body_bg_color'),
	'section'  => self::section_id('list'),
	'label'    => esc_html__( 'Cart Body Bg Color', 'woo-floating-cart' ),
	'type'     => 'color',
	'priority' => 10,
	'default'  => '',
	'transport'=>'auto',
	'output' => array(
		array(
			'element'  => '.woofc-inner .woofc-body',
			'property' => 'background-color',
		)
	)
));

Kirki::add_field( self::$config_id, array(
	'settings' => self::field_id('cart_body_text_color'),
	'section'  => self::section_id('list'),
	'label'    => esc_html__( 'Cart Body Text Color', 'woo-floating-cart' ),
	'type'     => 'color',
	'priority' => 10,
	'default'  => '#666666',
	'transport'=>'auto',
	'output' => array(
		array(
			'element'  => '.woofc-inner .woofc-body',
			'property' => 'color',
		)
	)
));


Kirki::add_field( self::$config_id, array(
	'settings' => self::field_id('cart_product_title_color'),
	'section'  => self::section_id('list'),
	'label'    => esc_html__( 'Cart Product Title Color', 'woo-floating-cart' ),
	'type'     => 'multicolor',
	'priority' => 10,
	'choices'     => array(
        'link'    => esc_attr__( 'Color', 'woo-floating-cart' ),
        'hover'   => esc_attr__( 'Hover', 'woo-floating-cart' )
    ),
	'default'     => array(
        'link'    => '#2b3e51',
        'hover'   => '#2c97de'
    ),
	'transport'=>'auto',
	'output' => array(
		array(
			'choice'   => 'link',
			'element'  => array('.woofc-inner .woofc-product-title a', '.woofc-inner .woofc-product-title > span'),
			'property' => 'color',
		),
		array(
			'choice'   => 'hover',
			'element'  => array('.woofc-no-touchevents .woofc-inner .woofc-product-title a:hover', '.woofc-touchevents .woofc-inner .woofc-product-title a:focus'),
			'property' => 'color',
		)
	)
));

Kirki::add_field( self::$config_id, array(
	'settings' => self::field_id('cart_product_price_color'),
	'section'  => self::section_id('list'),
	'label'    => esc_html__( 'Cart Product Price Color', 'woo-floating-cart' ),
	'type'     => 'color',
	'priority' => 10,
	'default'  => '',
	'transport'=>'auto',
	'output' => array(
		array(
			'element'  => '.woofc-inner .woofc-price',
			'property' => 'color',
		)
	)
));



Kirki::add_field( self::$config_id, array(
	'settings' => self::field_id('cart_product_delete_color'),
	'section'  => self::section_id('list'),
	'label'    => esc_html__( 'Cart Product Remove Color', 'woo-floating-cart' ),
	'type'     => 'multicolor',
	'priority' => 10,
	'choices'     => array(
        'link'    => esc_attr__( 'Color', 'woo-floating-cart' ),
        'hover'   => esc_attr__( 'Hover', 'woo-floating-cart' )
    ),
	'default'     => array(
        'link'    => '#2b3e51',
        'hover'   => '#2c97de'
    ),
	'transport'=>'auto',
	'output' => array(
		array(
			'choice'   => 'link',
			'element'  => '.woofc-inner .woofc-delete-item',
			'property' => 'color',
		),
		array(
			'choice'   => 'hover',
			'element'  => array('.woofc-no-touchevents .woofc-inner .woofc-delete-item:hover', '.woofc-touchevents .woofc-inner .woofc-delete-item:focus'),
			'property' => 'color',
		)
	)
));

	
Kirki::add_field( self::$config_id, array(
	'settings' => self::field_id('cart_product_qty_plus_minus_color'),
	'section'  => self::section_id('list'),
	'label'    => esc_html__( 'Cart Product Qty Plus Minus Color', 'woo-floating-cart' ),
	'type'     => 'multicolor',
	'priority' => 10,
	'choices'     => array(
        'link'    => esc_attr__( 'Color', 'woo-floating-cart' ),
        'hover'   => esc_attr__( 'Hover', 'woo-floating-cart' )
    ),
	'default'     => array(
        'link'    => '#808B94',
        'hover'   => '#2c97de'
    ),
	'transport'=>'auto',
	'output' => array(
		array(
			'choice'   => 'link',
			'element' => '.woofc-inner .woofc-quantity .woofc-quantity-button',
			'property' => 'color',
		),
		array(
			'choice'   => 'hover',
			'element'  => array('.woofc-no-touchevents .woofc-inner .woofc-quantity .woofc-quantity-button:hover', '.woofc-touchevents .woofc-inner .woofc-quantity .woofc-quantity-button:focus'),
			'property' => 'color',
		)
	)
));


Kirki::add_field( self::$config_id, array(
	'settings' => self::field_id('cart_product_qty_input_color'),
	'section'  => self::section_id('list'),
	'label'    => esc_html__( 'Cart Product Qty Input Color', 'woo-floating-cart' ),
	'type'     => 'color',
	'priority' => 10,
	'default'  => '',
	'transport'=>'auto',
	'output' => array(
		array(
			'element'  => '.woofc-inner .woofc-quantity input',
			'property' => 'color',
		)
	)
));

Kirki::add_field( self::$config_id, array(
	'settings' => self::field_id('cart_product_qty_plus_minus_size'),
	'section'  => self::section_id('list'),
	'label'    => esc_html__( 'Cart Product Qty Plus Minus Size', 'woo-floating-cart' ),
	'type'     => 'slider',
	'choices'     => array(
		'min'  => '10',
		'max'  => '18',
		'step' => '1',
	),
	'default'  => '10',
	'priority' => 10,
	'transport'=>'auto',
	'output'   => array(
		array(
			'element' => '.woofc-inner .woofc-quantity .woofc-quantity-button',
			'property' => 'font-size',
			'media_query' => '@media (min-width: 480px)',
			'value_pattern' => '$px'
		),
		array(
			'element' => '.woofc-inner .woofc-quantity .woofc-quantity-button',
			'property' => 'font-size',
			'media_query' => '@media (max-width: 479px)',
			'value_pattern' => 'calc($px * 0.85)'
		)
	)
));

Kirki::add_field( self::$config_id, array(
	'settings' => self::field_id('cart_product_qty_input_size'),
	'section'  => self::section_id('list'),
	'label'    => esc_html__( 'Cart Product Qty Input Size', 'woo-floating-cart' ),
	'type'     => 'slider',
	'choices'     => array(
		'min'  => '10',
		'max'  => '24',
		'step' => '1',
	),
	'default'  => '16',
	'priority' => 10,
	'transport'=>'auto',
	'output'   => array(
		array(
			'element'  => '.woofc-inner .woofc-quantity input',
			'property' => 'font-size',
			'media_query' => '@media (min-width: 480px)',
			'value_pattern' => '$px'
		),
		array(
			'element'  => '.woofc-inner .woofc-quantity input',
			'property' => 'font-size',
			'media_query' => '@media (max-width: 479px)',
			'value_pattern' => 'calc($px * 0.85)'
		)
	)
));

Kirki::add_field( self::$config_id, array(
	'settings'    => self::field_id('cart_product_show_bundled_products'),
	'section'  	  => self::section_id('list'),
	'label'       => esc_html__( 'Show Bundled Products Items', 'woo-floating-cart' ),
	'type'        => 'toggle',
	'default'     => '1',
	'priority'    => 10,
	'transport'	  =>'postMessage'
));

Kirki::add_field( self::$config_id, array(
	'settings'    => self::field_id('cart_product_show_composite_products'),
	'section'  	  => self::section_id('list'),
	'label'       => esc_html__( 'Show Composite Products Items', 'woo-floating-cart' ),
	'type'        => 'toggle',
	'default'     => '1',
	'priority'    => 10,
	'transport'	  =>'postMessage'
));

Kirki::add_field( self::$config_id, array(
	'settings'    => self::field_id('cart_product_show_attributes'),
	'section'  	  => self::section_id('list'),
	'label'       => esc_html__( 'Show Variable Product Attributes', 'woo-floating-cart' ),
	'type'        => 'toggle',
	'default'     => '0',
	'priority'    => 10,
	'transport'	  =>'postMessage'
));

Kirki::add_field( self::$config_id, array(
	'settings'    => self::field_id('cart_product_attributes_display'),
	'section'  	  => self::section_id('list'),
	'label'       => esc_html__( 'Product Attributes Display Type', 'woo-floating-cart' ),
	'type'        => 'radio-buttonset',
	'choices'     => array(
		'list'	  => esc_attr__( 'List', 'woo-floating-cart' ),
		'inline'  => esc_attr__( 'Inline', 'woo-floating-cart' )
	),
	'default'     => 'list',
	'priority'    => 10,
	'active_callback'    => array(
		array(
			'setting'  => self::field_id('cart_product_show_attributes'),
			'operator' => '==',
			'value'    => '1',
		),
	),
	'transport'=>'postMessage',
	'js_vars' => array(
		array(
			'element'  => '.woofc-variation',
			'function' => 'class',
			'prefix' => 'woofc-variation-'
		)
	)
));

Kirki::add_field( self::$config_id, array(
	'settings'    => self::field_id('cart_product_attributes_hide_label'),
	'section'  => self::section_id('list'),
	'label'       => esc_html__( 'Hide attribute labels, show values only', 'woo-floating-cart' ),
	'type'        => 'radio-buttonset',
	'choices'     => array(
		'0'  => esc_attr__( 'No', 'woo-floating-cart' ),
		'1'	  => esc_attr__( 'Yes', 'woo-floating-cart' ),
	),
	'default'     => '0',
	'priority'    => 10,
	'active_callback'    => array(
		array(
			'setting'  => self::field_id('cart_product_show_attributes'),
			'operator' => '==',
			'value'    => '1',
		),
	),
	'transport'=>'postMessage'
));

Kirki::add_field( self::$config_id, array(
	'settings'    => self::field_id('cart_product_attributes_color'),
	'section'  => self::section_id('list'),
	'label'    => esc_html__( 'Cart Product Attributes Color', 'woo-floating-cart' ),
	'type'     => 'color',
	'priority' => 10,
	'default'  => '#666666',
	'transport'=>'auto',
	'output' => array(
		array(
			'element' => array('.woofc-inner .woofc-product-attributes dl'),	
			'property' => 'color',
		)
	),
	'active_callback'    => array(
		array(
			'setting'  => self::field_id('cart_product_show_attributes'),
			'operator' => '==',
			'value'    => '1',
		),
	)
));