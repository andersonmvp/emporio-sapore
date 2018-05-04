<?php
Kirki::add_field( self::$config_id, array(
	'settings'    => self::field_id('position'),
	'section'     => self::section_id('general'),
	'label'    	  => esc_html__( 'Trigger / Cart Position', 'woo-floating-cart' ),
	'type'        => 'radio',
	'priority'    => 10,
	'choices'     => array(
		'top-left' => esc_html__( 'Top Left', 'woo-floating-cart' ),
		'top-right'  => esc_html__( 'Top Right', 'woo-floating-cart' ),
		'bottom-left' => esc_html__( 'Bottom Left', 'woo-floating-cart' ),
		'bottom-right'  => esc_html__( 'Bottom Right', 'woo-floating-cart' )
	),
	'transport'=>'postMessage',
	'js_vars'   => array(
		array(
			'element'  => '.woofc',
			'function' => 'class',
			'prefix' => 'woofc-pos-'
		),
		array(
			'element'  => '.woofc',
			'function' => 'html',
			'attr' => 'data-position'
		)
	),	
	'default'     => 'bottom-right'
));

Kirki::add_field( self::$config_id, array(
	'settings'    => self::field_id('counter_position'),
	'section'     => self::section_id('general'),
	'label'    	  => esc_html__( 'Product Counter Position', 'woo-floating-cart' ),
	'type'        => 'radio',
	'priority'    => 10,
	'choices'     => array(
		'top-left' => esc_html__( 'Top Left', 'woo-floating-cart' ),
		'top-right'  => esc_html__( 'Top Right', 'woo-floating-cart' ),
		'bottom-left' => esc_html__( 'Bottom Left', 'woo-floating-cart' ),
		'bottom-right'  => esc_html__( 'Bottom Right', 'woo-floating-cart' )
	),
	'transport'	=>'postMessage',
	'js_vars'   => array(
		array(
			'element'  => '.woofc',
			'function' => 'class',
			'prefix' => 'woofc-counter-pos-'
		)
	),
	'default'   => 'top-left'
));
				
Kirki::add_field( self::$config_id, array(
	'settings'    	=> self::field_id('hoffset'),
	'section'     	=> self::section_id('general'),
	'label'       	=> esc_html__( 'Horizontal Offset', 'woo-floating-cart' ),
	'type'        	=> 'slider',
	'choices'     => array(
		'min'  => '0',
		'max'  => '300',
		'step' => '1',
	),
	'priority'    	=> 10,
	'default'	  	=> '20',
	'transport'		=>'auto',
	'output'   	=> array(
		array(
			'element'  => '.woofc-inner',
			'property' => 'margin-left',
			'value_pattern' => '$px'
		),
		array(
			'element'  => '.woofc-inner',
			'property' => 'margin-right',
			'value_pattern' => '$px'
		),
		array(
			'element'  => '.woofc-inner',
			'property' => 'max-width',
			'value_pattern' => 'calc(100vw - ($px * 2))'
		)
	)
));

Kirki::add_field( self::$config_id, array(
	'settings'    	=> self::field_id('voffset'),
	'section'     	=> self::section_id('general'),
	'label'       	=> esc_html__( 'Vertical Offset', 'woo-floating-cart' ),
	'type'        	=> 'slider',
	'choices'     => array(
		'min'  => '0',
		'max'  => '300',
		'step' => '1',
	),
	'default'	  	=> '20',
	'priority'    	=> 10,
	'transport'		=>'auto',
	'output'   	=> array(
		array(
			'element'  => '.woofc-inner',
			'property' => 'margin-top',
			'value_pattern' => '$px'
		),
		array(
			'element'  => '.woofc-inner',
			'property' => 'margin-bottom',
			'value_pattern' => '$px'
		),
		array(
			'element'  => '.woofc-inner',
			'property' => 'max-height',
			'value_pattern' => 'calc(100vh - ($px * 2))'
		),
		array(
			'element'  => '.admin-bar .woofc-inner',
			'property' => 'max-height',
			'value_pattern' => 'calc(100vh - (($px * 2)) - 46px)'
		),
		array(
			'element'  => '.admin-bar .woofc-inner',
			'property' => 'max-height',
			'value_pattern' => 'calc(100vh - (($px * 2)) - 32px)',
			'media_query' => '@media (min-width: 783px)',
		)
	)
));

Kirki::add_field( self::$config_id, array(
	'settings'    	=> self::field_id('cart_width'),
	'section'     	=> self::section_id('general'),
	'label'       	=> esc_html__( 'Cart Width', 'woo-floating-cart' ),
	'type'        	=> 'slider',
	'choices'     => array(
		'min'  => '340',
		'max'  => '1000',
		'step' => '5',
	),
	'default'	  	=> '440',
	'priority'    	=> 10,
	'transport'		=>'auto',
	'output'   	=> array(
		array(
			'element'  => '.woofc-inner',
			'property' => 'width',
			'value_pattern' => '$px'
		)
	)
));

Kirki::add_field( self::$config_id, array(
	'settings'    	=> self::field_id('cart_height'),
	'section'     	=> self::section_id('general'),
	'label'       	=> esc_html__( 'Cart Height', 'woo-floating-cart' ),
	'type'        	=> 'slider',
	'choices'     => array(
		'min'  => '240',
		'max'  => '1000',
		'step' => '5',
	),
	'default'	  	=> '400',
	'priority'    	=> 10,
	'transport'		=>'auto',
	'output'   	=> array(
		array(
			'element'  => '.woofc-inner',
			'property' => 'height',
			'value_pattern' => '$px'
		)
	)
));


Kirki::add_field( self::$config_id, array(
	'settings'    	=> self::field_id('border_radius'),
	'section'     	=> self::section_id('general'),
	'label'       	=> esc_html__( 'Border Radius', 'woo-floating-cart' ),
	'type'        	=> 'slider',
	'choices'     => array(
		'min'  => '0',
		'max'  => '35',
		'step' => '1',
	),
	'default'	  	=> '6',
	'priority'    	=> 10,
	'transport'		=>'auto',
	'output'   	=> array(
		array(
			'element'  => '.woofc-inner .woofc-header',
			'property' => 'border-radius',
			'value_pattern' => '$px $px 0 0'
		),
		array(
			'element'  => '.woofc-inner .woofc-wrapper, .woofc-trigger',
			'property' => 'border-radius',
			'value_pattern' => '$px'
		),	
		array(
			'element'  => array('.woofc-cart-open.woofc-pos-top-right .woofc-trigger', '.woofc-cart-open.woofc-pos-bottom-right .woofc-trigger', '.woofc-pos-top-right .woofc-inner .woofc-body', '.woofc-pos-bottom-right .woofc-inner .woofc-body'),
			'property' => 'border-radius',
			'value_pattern' => '0 0 $px 0'
		),	
		array(
			'element'  => array('.woofc-cart-open.woofc-pos-top-left .woofc-trigger', '.woofc-cart-open.woofc-pos-bottom-left .woofc-trigger', '.woofc-pos-top-left .woofc-inner .woofc-body', '.woofc-pos-bottom-left .woofc-inner .woofc-body'),
			'property' => 'border-radius',
			'value_pattern' => '0 0 0 $px'
		),				
		array(
			'element'  => '.woofc-inner .woofc-footer',
			'property' => 'border-radius',
			'value_pattern' => '$px'
		),
		array(
			'element'  => '.woofc-cart-open .woofc-inner .woofc-footer',
			'property' => 'border-radius',
			'value_pattern' => '0 0 $px $px'
		)
	)
));

Kirki::add_field( self::$config_id, array(
	'settings'    => self::field_id('flytocart_animation'),
	'section'     => self::section_id('general'),
	'label'       => esc_html__( 'Enable Fly To Cart animation', 'woo-floating-cart' ),
	'type'        => 'toggle',
	'default'     => '1',
	'priority'    => 10
));

Kirki::add_field( self::$config_id, array(
	'settings'    => self::field_id('flytocart_animation_duration'),
	'section'     => self::section_id('general'),
	'label'       => esc_html__( 'Fly To Cart animation Duration (ms)', 'woo-floating-cart' ),
	'type'        => 'slider',
	'choices'     => array(
		'min'  => '300',
		'max'  => '2000',
		'step' => '10',
	),
	'priority'    	=> 10,
	'default'	  	=> 650,
	'transport'		=>'postMessage',
	'js_vars'   	=> array(
		array(
			'element'  => '.woofc',
			'function' => 'html',
			'attr' => 'data-flyduration'
		)
	)
));

Kirki::add_field( self::$config_id, array(
	'settings'    => self::field_id('shake_trigger'),
	'section'     => self::section_id('general'),
	'label'    	  => esc_html__( 'Shake Trigger after adding products', 'woo-floating-cart' ),
	'type'        => 'radio',
	'priority'    => 10,
	'choices'     => array(
		'' => esc_html__( 'No Shake', 'woo-floating-cart' ),
		'horizontal'  => esc_html__( 'Horizontal Shake', 'woo-floating-cart' ),
		'vertical' => esc_html__( 'Vertical Shake', 'woo-floating-cart' ),
	),
	'default'     => 'vertical',
	'transport'=>'postMessage',
	'js_vars'   => array(
		array(
			'element'  => '.woofc',
			'function' => 'html',
			'attr' => 'data-shaketrigger'
		)
	)
));

Kirki::add_field( self::$config_id, array(
	'settings'    => self::field_id('open_cart_on_product_add'),
	'section'     => self::section_id('general'),
	'label'    	  => esc_html__( 'Open cart after adding products', 'woo-floating-cart' ),
	'type'        => 'radio',
	'priority'    => 10,
	'choices'     => array(
		'0' => esc_html__( 'No', 'woo-floating-cart' ),
		'1'  => esc_html__( 'Yes', 'woo-floating-cart' )
	),
	'default'     => '0',
	'transport'=>'postMessage',
	'js_vars'   => array(
		array(
			'element'  => '.woofc',
			'function' => 'html',
			'attr' => 'data-opencart-onadd'
		)
	)
));

Kirki::add_field( self::$config_id, array(
	'settings'    => self::field_id('loading_spinner'),
	'section'     => self::section_id('general'),
	'label'    	  => esc_html__( 'Loading Spinner', 'woo-floating-cart' ),
	'type'        => 'radio',
	'priority'    => 10,
	'choices'     => array(
		'0' => esc_html__('No Spinner', 'woo-floating-cart'),
		'1-rotating-plane' => esc_html__('Rotating Plane', 'woo-floating-cart'),
		'2-double-bounce' => esc_html__('Double Bounce', 'woo-floating-cart'),
		'3-wave' => esc_html__('Wave', 'woo-floating-cart'),
		'4-wandering-cubes' => esc_html__('Wandering Cubes', 'woo-floating-cart'),
		'5-pulse' => esc_html__('Pulse', 'woo-floating-cart'),
		'6-chasing-dots' => esc_html__('Chasing Dots', 'woo-floating-cart'),
		'7-three-bounce' => esc_html__('Three Bounce', 'woo-floating-cart'),
		'8-circle' => esc_html__('Circle', 'woo-floating-cart'),
		'9-cube-grid' => esc_html__('Cube Grid', 'woo-floating-cart'),
		'10-fading-circle' => esc_html__('Fading Circle', 'woo-floating-cart'),
		'11-folding-cube' => esc_html__('Folding Cube', 'woo-floating-cart'),
		'loading-text' => esc_html__('Boring Loading Text', 'woo-floating-cart')
	),
	'default'     => '7-three-bounce',
	'partial_refresh' => array(
		'cart_spinner' => array(
			'selector'        => '.woofc-spinner-wrap',
			'render_callback' => function() {
				return woofc_spinner_html(true, false);
			},
		)
	)
));

Kirki::add_field( self::$config_id, array(
	'settings'    => self::field_id('loading_spinner_color'),
	'section'     => self::section_id('general'),
	'label'    	  => esc_html__( 'Loading Spinner Color', 'woo-floating-cart' ),
	'type'     => 'color',
	'priority' => 10,
	'default'  => '#2c97de',
	'transport'=>'auto',
	'output' => array(
		array(
			'element'  => array(
				'.woofc-spinner-rotating-plane',
				'.woofc-spinner-double-bounce .woofc-spinner-child',
				'.woofc-spinner-wave .woofc-spinner-rect',
				'.woofc-spinner-wandering-cubes .woofc-spinner-cube',
				'.woofc-spinner-spinner-pulse',
				'.woofc-spinner-chasing-dots .woofc-spinner-child',
				'.woofc-spinner-three-bounce .woofc-spinner-child',
				'.woofc-spinner-circle .woofc-spinner-child:before',
				'.woofc-spinner-cube-grid .woofc-spinner-cube',
				'.woofc-spinner-fading-circle .woofc-spinner-circle:before',
				'.woofc-spinner-folding-cube .woofc-spinner-cube:before',
			),	
			'property' => 'background-color',
		),
		array(
			'element' => '.woofc-spinner-loading-text',
			'property' => 'color',
		)
	)
));

Kirki::add_field( self::$config_id, array(
	'settings'  => self::field_id('loading_overlay_color'),
	'section'   => self::section_id('general'),
	'label'    	=> esc_html__( 'Loading Overlay Color', 'woo-floating-cart' ),
	'type'      => 'color',
	'priority' 	=> 10,
	'default'  	=> 'rgba(255,255,255,0.5)',
	'transport'	=>'auto',
	'output' 	=> array(
		array(
			'element'  => '.woofc-spinner-wrap',
			'property' =>'background-color',	
		)
	)
));

Kirki::add_field( self::$config_id, array(
	'settings'    => self::field_id('loading_timeout'),
	'section'     => self::section_id('general'),
	'label'    	  => esc_html__( 'Loading Spinner Extra Delay (ms)', 'woo-floating-cart' ),
	'type'        => 'slider',
	'choices'     => array(
		'min'  => '0',
		'max'  => '2000',
		'step' => '10',
	),
	'priority'    	=> 10,
	'default'	  	=> 300,
	'transport'		=>'postMessage',
	'js_vars'   	=> array(
		array(
			'element'  => '.woofc',
			'function' => 'html',
			'attr' => 'data-loadingtimeout'
		)
	)
));