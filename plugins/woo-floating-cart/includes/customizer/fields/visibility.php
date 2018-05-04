<?php
$pages = get_pages(); 
$pages_options = array();
foreach ( $pages as $page ) {
	$pages_options[$page->ID] = $page->post_title;
}
  
Kirki::add_field( self::$config_id, array(
	'settings'    => self::field_id('hidden_on_pages'),
	'section'     => self::section_id('visibility'),
	'label'    	  => esc_html__( 'Hide cart on these pages', 'woo-floating-cart' ),
	'type'        => 'select',
	'multiple' 	  => 999,
	'choices'     => $pages_options,
	'priority'    => 10,
	'default'     => ''
));

Kirki::add_field( self::$config_id, array(
	'settings'    => self::field_id('visible_on_empty'),
	'section'     => self::section_id('visibility'),
	'label'       => esc_html__( 'Keep visible on empty', 'woo-floating-cart' ),
	'type'        => 'toggle',
	'default'     => '0',
	'priority'    => 10
));

Kirki::add_field( self::$config_id, array(
	'settings'    => self::field_id('visibility'),
	'section'     => self::section_id('visibility'),
	'label'       => esc_html__( 'Device Visibility', 'woo-floating-cart' ),
	'type'        => 'radio',
	'choices'     => array(
		'show-on-mobile-only' 		=> esc_attr__( 'Show on mobile only', 'woo-floating-cart' ),
		'show-on-tablet-desktop' 	=> esc_attr__( 'Show on tablet and desktop', 'woo-floating-cart' ),
		'show-on-desktop-only' 		=> esc_attr__( 'Show on desktop only', 'woo-floating-cart' ),
		'show-on-all' 				=> esc_attr__( 'Show on all', 'woo-floating-cart' ),
	),
	'default'     => 'show-on-all',
	'priority'    => 10
));

