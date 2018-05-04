<?php
Kirki::add_field( self::$config_id, array(
	'settings'    => self::field_id('trigger_event_type'),
	'section'     => self::section_id('trigger'),
	'label'       => esc_html__( 'Trigger Event Type', 'woo-floating-cart' ),
	'type'        => 'radio-buttonset',
	'choices'     => array(
		'vclick'	  => esc_attr__( 'Click Only', 'woo-floating-cart' ),
		'mouseenter'  => esc_attr__( 'Mouse Over Or Click', 'woo-floating-cart' )
	),
	'default'     => 'vclick',
	'priority'    => 10
));

Kirki::add_field( self::$config_id, array(
	'settings'    => self::field_id('trigger_hover_delay'),
	'section'     => self::section_id('trigger'),
	'label'       => esc_html__( 'Mouse Over delay before trigger (ms)', 'woo-floating-cart' ),
	'type'        => 'slider',
	'choices'     => array(
		'min'  => '0',
		'max'  => '1500',
		'step' => '10',
	),
	'priority'    	=> 10,
	'default'	  	=> 200,
	'active_callback'    => array(
		array(
			'setting'  => self::field_id('trigger_event_type'),
			'operator' => '==',
			'value'    => 'mouseenter',
		),
	)
));

Kirki::add_field( self::$config_id, array(
	'settings'    => self::field_id('trigger_hide_view_cart'),
	'section'     => self::section_id('trigger'),
	'label'       => esc_html__( 'Hide WooCommerce View Cart Link after trigger', 'woo-floating-cart' ),
	'type'        => 'toggle',
	'default'     => '0',
	'priority'    => 10
));

Kirki::add_field( self::$config_id, array(
	'settings'    => self::field_id('trigger_icon_type'),
	'section'     => self::section_id('trigger'),
	'label'       => esc_html__( 'Trigger Icon Type', 'woo-floating-cart' ),
	'type'        => 'radio-buttonset',
	'choices'     => array(
		'image' => esc_attr__( 'Image / SVG', 'woo-floating-cart' ),
		'font' 	=> esc_attr__( 'Font Icon', 'woo-floating-cart' )
	),
	'default'     => 'image',
	'priority'    => 10,
	'js_vars' => array(
		array(
			'element'  => '.woofc-trigger',
			'function' =>'class',
			'prefix'   => 'woofc-icontype-'
		)
	),

));

Kirki::add_field( self::$config_id, array(
	'settings' => self::field_id('cart_trigger_icon'),
	'section'  => self::section_id('trigger'),
	'label'    => esc_html__( 'Cart Trigger Icon', 'woo-floating-cart' ),
	'type'     => 'woofcicons',
	'choices'  => array('types' => array('cart')),
	'priority' => 10,
	'default'  => 'woofcicon-groceries-store',
	'transport'=>'postMessage',
	'js_vars' => array(
		array(
			'element'  => '.woofc-trigger-cart-icon',
			'function' =>'class'
		)
	),
	'active_callback'    => array(
		array(
			'setting'  => self::field_id('trigger_icon_type'),
			'operator' => '==',
			'value'    => 'font',
		),
	)
));

Kirki::add_field( self::$config_id, array(
	'settings' => self::field_id('cart_trigger_close_icon'),
	'section'  => self::section_id('trigger'),
	'label'    => esc_html__( 'Cart Trigger Close Icon', 'woo-floating-cart' ),
	'type'     => 'woofcicons',
	'choices'  => array('types' => array('close')),
	'priority' => 10,
	'default'  => 'woofcicon-close-2',
	'transport'=>'postMessage',
	'js_vars' => array(
		array(
			'element'  => '.woofc-trigger-close-icon',
			'function' =>'class'
		)
	),
	'active_callback'    => array(
		array(
			'setting'  => self::field_id('trigger_icon_type'),
			'operator' => '==',
			'value'    => 'font',
		),
	)
));

Kirki::add_field( self::$config_id, array(
	'settings' 		=> self::field_id('cart_trigger_icon_image'),
	'section'     	=> self::section_id('trigger'),
	'label'    		=> esc_html__( 'Cart Trigger Icon Image', 'woo-floating-cart' ),
	'type'        	=> 'image',
	'default'  		=> self::$parent->plugin_url('public/assets/img', 'open.svg'),
	'priority'    	=> 10,
	'transport'	 	=>'auto',
	'output' 		=> array(
		array(
			'element'  => '.woofc-trigger.woofc-icontype-image .woofc-trigger-cart-icon',
			'property' => 'background-image',
		)
	),
	'active_callback'    => array(
		array(
			'setting'  => self::field_id('trigger_icon_type'),
			'operator' => '==',
			'value'    => 'image',
		),
	)
));

Kirki::add_field( self::$config_id, array(
	'settings' 		=> self::field_id('cart_trigger_close_icon_image'),
	'section'     	=> self::section_id('trigger'),
	'label'    		=> esc_html__( 'Cart Trigger Close Icon Image', 'woo-floating-cart' ),
	'type'        	=> 'image',
	'default'  		=> self::$parent->plugin_url('public/assets/img', 'close.svg'),
	'priority'    	=> 10,
	'transport'	 	=>'auto',
	'output' 		=> array(
		array(
			'element'  => '.woofc-trigger.woofc-icontype-image .woofc-trigger-close-icon',
			'property' => 'background-image',
		)
	),
	'active_callback'    => array(
		array(
			'setting'  => self::field_id('trigger_icon_type'),
			'operator' => '==',
			'value'    => 'image',
		),
	)
));


Kirki::add_field( self::$config_id, array(
	'settings' => self::field_id('cart_trigger_bg_color'),
	'section'  => self::section_id('trigger'),
	'label'    => esc_html__( 'Cart Trigger Bg Color', 'woo-floating-cart' ),
	'type'     => 'color',
	'priority' => 10,
	'default'  => '#ffffff',
	'transport'=>'auto',
	'output' => array(
		array(
			'element'  => '.woofc-trigger',
			'property' => 'background',
		)
	)
));

Kirki::add_field( self::$config_id, array(
	'settings' => self::field_id('cart_trigger_hover_bg_color'),
	'section'  => self::section_id('trigger'),
	'label'    => esc_html__( 'Cart Trigger Hover Bg Color', 'woo-floating-cart' ),
	'type'     => 'color',
	'priority' => 10,
	'default'  => '#ffffff',
	'transport'=>'auto',
	'output' => array(
		array(
			'element'  => array('.woofc-no-touchevents .woofc:not(.woofc-cart-open) .woofc-trigger:hover', '.woofc-touchevents .woofc:not(.woofc-cart-open) .woofc-trigger:focus'),
			'property' => 'background',
		)
	)
));

Kirki::add_field( self::$config_id, array(
	'settings' => self::field_id('cart_trigger_active_bg_color'),
	'section'  => self::section_id('trigger'),
	'label'    => esc_html__( 'Cart Trigger Active Bg Color', 'woo-floating-cart' ),
	'type'     => 'color',
	'priority' => 10,
	'default'  => '#ffffff',
	'transport'=>'auto',
	'output' => array(
		array(
			'element'  => '.woofc-cart-open .woofc-trigger',
			'property' => 'background',
		)
	)
));

Kirki::add_field( self::$config_id, array(
	'settings' => self::field_id('counter_bg_color'),
	'section'  => self::section_id('trigger'),
	'label'    => esc_html__( 'Product Counter Bg Color', 'woo-floating-cart' ),
	'type'     => 'color',
	'priority' => 10,
	'default'  => '#e94b35',
	'transport'=>'auto',
	'output' => array(
		array(
			'element'  => '.woofc-trigger .woofc-count',
			'property' => 'background',
		)
	)
));

Kirki::add_field( self::$config_id, array(
	'settings' => self::field_id('counter_text_color'),
	'section'  => self::section_id('trigger'),
	'label'    => esc_html__( 'Product Counter Text Color', 'woo-floating-cart' ),
	'type'     => 'color',
	'priority' => 10,
	'default'  => '#fff',
	'transport'=>'auto',
	'output' => array(
		array(
			'element'  => '.woofc-trigger .woofc-count',
			'property' => 'color',
		)
	)
));