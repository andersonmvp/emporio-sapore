<?php
	
$default_font = 'Source Sans Pro';	

Kirki::add_field( self::$config_id, array(
	'settings'    => self::field_id('typo_counter'),
	'section'     => self::section_id('typography'),
	'label'       => esc_attr__( 'Product Counter Typography', 'woo-floating-cart' ),
	'type'        => 'typography',
	'default'     => array(
		'font-family'    => $default_font,
		'variant'        => '700',
		'font-size'      => '15px',
		'subsets'        => array( 'latin-ext' )
	),
	'priority'    => 10,
	'transport'   => 'auto',
	'output'      => array(
		array(
			'element' => '.woofc-trigger .woofc-count',
		),
	)
));

Kirki::add_field( self::$config_id, array(
	'settings'    => self::field_id('typo_header_title'),
	'section'     => self::section_id('typography'),
	'label'       => esc_attr__( 'Header Title Typography', 'woo-floating-cart' ),
	'type'        => 'typography',
	'default'     => array(
		'font-family'    => $default_font,
		'variant'        => '700',
		'font-size'      => '16px',
		'letter-spacing' => '1.4px',
		'subsets'        => array( 'latin-ext' ),
		'text-transform' => 'uppercase'
	),
	'priority'    => 10,
	'transport'   => 'auto',
	'output'      => array(
		array(
			'element' => '.woofc-inner .woofc-title',
		),
	)
));

Kirki::add_field( self::$config_id, array(
	'settings'    => self::field_id('typo_header_undo_msg'),
	'section'     => self::section_id('typography'),
	'label'       => esc_attr__( 'Header Undo Message Typography', 'woo-floating-cart' ),
	'type'        => 'typography',
	'default'     => array(
		'font-family'    => $default_font,
		'variant'        => '700',
		'font-size'      => '10px',
		'letter-spacing' => '1.4',
		'subsets'        => array( 'latin-ext' ),
		'text-transform' => 'uppercase'
	),
	'priority'    => 10,
	'transport'   => 'auto',
	'output'      => array(
		array(
			'element' => '.woofc-inner .woofc-undo',
		),
	)
));

Kirki::add_field( self::$config_id, array(
	'settings'    => self::field_id('typo_header_error_msg'),
	'section'     => self::section_id('typography'),
	'label'       => esc_attr__( 'Header Error Message Typography', 'woo-floating-cart' ),
	'type'        => 'typography',
	'default'     => array(
		'font-family'    => $default_font,
		'variant'        => '700',
		'font-size'      => '10px',
		'letter-spacing' => '1.4',
		'subsets'        => array( 'latin-ext' ),
		'text-transform' => 'uppercase'
	),
	'priority'    => 10,
	'transport'   => 'auto',
	'output'      => array(
		array(
			'element' => '.woofc-inner .woofc-cart-error',
		),
	)
));

Kirki::add_field( self::$config_id, array(
	'settings'    => self::field_id('typo_header_no_products_msg'),
	'section'     => self::section_id('typography'),
	'label'       => esc_attr__( 'Header No Products Message Typography', 'woo-floating-cart' ),
	'type'        => 'typography',
	'default'     => array(
		'font-family'    => $default_font,
		'variant'        => 'regular',
		'font-size'      => '12px',
		'letter-spacing' => '1.4',
		'text-align' 	 => 'left',
		'subsets'        => array( 'latin-ext' ),
		'text-transform' => 'none'
	),
	'priority'    => 10,
	'transport'   => 'auto',
	'output'      => array(
		array(
			'element' => '.woofc-empty .woofc-inner .woofc-no-product',
		),
	)
));

Kirki::add_field( self::$config_id, array(
	'settings'    => self::field_id('typo_product_title'),
	'section'     => self::section_id('typography'),
	'label'       => esc_attr__( 'Product Title / Price Typography', 'woo-floating-cart' ),
	'type'        => 'typography',
	'default'     => array(
		'font-family'    => $default_font,
		'variant'        => '700',
		'font-size'      => '18px',
		'letter-spacing' => '0',
		'subsets'        => array( 'latin-ext' ),
		'text-transform' => 'capitalize'
	),
	'priority'    => 10,
	'transport'   => 'auto',
	'output'      => array(
		array(
			'element' => array('.woofc-inner .woofc-product-title','.woofc-inner .woofc-price'),
			'media_query' => '@media (min-width: 480px)',
		),
		array(
			'element' => array('.woofc-inner .woofc-product-title','.woofc-inner .woofc-price'),
			'media_query' => '@media (max-width: 479px)',
			'value_pattern' => array(
				'font-size' => 'calc($ * 0.75)'
			)	
		),
	)
));

Kirki::add_field( self::$config_id, array(
	'settings'    => self::field_id('typo_product_attributes_labels'),
	'section'     => self::section_id('typography'),
	'label'       => esc_attr__( 'Product Attributes Label Typography', 'woo-floating-cart' ),
	'type'        => 'typography',
	'default'     => array(
		'font-family'    => $default_font,
		'variant'        => '600',
		'font-size'      => '10px',
		'letter-spacing' => '0',
		'subsets'        => array( 'latin-ext' ),
		'text-transform' => 'capitalize'
	),
	'priority'    => 10,
	'transport'   => 'auto',
	'output'      => array(
		array(
			'element' => '.woofc-inner .woofc-product-variations dl dt',	
		),
	)
));

Kirki::add_field( self::$config_id, array(
	'settings'    => self::field_id('typo_product_attributes_values'),
	'section'     => self::section_id('typography'),
	'label'       => esc_attr__( 'Product Attributes Values Typography', 'woo-floating-cart' ),
	'type'        => 'typography',
	'default'     => array(
		'font-family'    => $default_font,
		'variant'        => 'regular',
		'font-size'      => '10px',
		'letter-spacing' => '0',
		'subsets'        => array( 'latin-ext' ),
		'text-transform' => 'capitalize'
	),
	'priority'    => 10,
	'transport'   => 'auto',
	'output'      => array(
		array(
			'element' => '.woofc-inner .woofc-product-variations dl dd',	
		),
	)
));

Kirki::add_field( self::$config_id, array(
	'settings'    => self::field_id('typo_product_action_link'),
	'section'     => self::section_id('typography'),
	'label'       => esc_attr__( 'Product Remove Link Typography', 'woo-floating-cart' ),
	'type'        => 'typography',
	'default'     => array(
		'font-family'    => $default_font,
		'variant'        => 'regular',
		'font-size'      => '14px',
		'letter-spacing' => '0',
		'subsets'        => array( 'latin-ext' ),
		'text-transform' => 'capitalize'
	),
	'priority'    => 10,
	'transport'   => 'auto',
	'output'      => array(
		array(
			'element' => '.woofc-inner .woofc-actions',
			'media_query' => '@media (min-width: 480px)',
		),
		array(
			'element' => '.woofc-inner .woofc-actions',
			'media_query' => '@media (max-width: 479px)',
			'value_pattern' => array(
				'font-size' => 'calc($ * 0.85)'
			)	
		),
	)
));


Kirki::add_field( self::$config_id, array(
	'settings'    => self::field_id('typo_product_quantity_input'),
	'section'     => self::section_id('typography'),
	'label'       => esc_attr__( 'Product Quantity Input Typography', 'woo-floating-cart' ),
	'type'        => 'typography',
	'default'     => array(
		'font-family'    => $default_font,
		'variant'        => 'regular',
		'font-size'      => '14px',
		'letter-spacing' => '1.2px',
		'subsets'        => array( 'latin-ext' )
	),
	'priority'    => 10,
	'transport'	  => 'auto',
	'output'      => array(
		array(
			'element' => '.woofc-inner .woofc-quantity input',
			'media_query' => '@media (min-width: 480px)',
		),
		array(
			'element' => '.woofc-inner .woofc-quantity input',
			'media_query' => '@media (max-width: 479px)',
			'value_pattern' => array(
				'font-size' => 'calc($ * 0.85)'
			)	
		),
	)
));

Kirki::add_field( self::$config_id, array(
	'settings'    => self::field_id('typo_footer_checkout_button'),
	'section'     => self::section_id('typography'),
	'label'       => esc_attr__( 'Footer Checkout Button Typography', 'woo-floating-cart' ),
	'type'        => 'typography',
	'default'     => array(
		'font-family'    => $default_font,
		'variant'        => '600italic',
		'font-size'      => '24px',
		'letter-spacing' => '0',
		'subsets'        => array( 'latin-ext' ),
		'text-transform' => 'none'
	),
	'priority'    => 10,
	'transport'   => 'auto',
	'output'      => array(
		array(
			'element' => '.woofc-inner a.woofc-checkout',
			'media_query' => '@media (min-width: 480px)',
		),
		array(
			'element' => '.woofc-inner a.woofc-checkout',
			'media_query' => '@media (max-width: 479px)',
			'value_pattern' => array(
				'font-size' => 'calc($ * 0.75)'
			)	
		),
	)
));