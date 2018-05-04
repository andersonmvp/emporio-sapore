<?php

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Woo Floating Cart Kirki Options Class.
 */
class Woo_Floating_Cart_Customizer {

	public static $parent;
	public static $config_id = 'woofc';
	public static $options = null;
	public static $path;
	
	/**
	 * Class constructor
	 */
	public function __construct($parent) {
		
		/**
		 * Exit early if Kirki does not exist or is not installed and activated.
		 */
		if ( ! class_exists( 'Kirki' ) ) {
			return;
		}
		
		self::$parent = $parent;
		self::$path = dirname(__FILE__);
		
		self::add_config();
		self::add_panels();
		self::add_sections();
		self::add_fields();
		
		add_action( 'customize_controls_enqueue_scripts', array(__CLASS__, 'customizer_styles' ));
		add_filter( 'wp_check_filetype_and_ext', array(__CLASS__, 'check_filetype_and_ext'), 10, 4 );
		add_filter( 'upload_mimes', array(__CLASS__, 'allow_myme_types'), 1, 1);
		
		if(!defined('WOOFC_LITE')) {
			add_filter( 'plugin_action_links_' . plugin_basename( self::$parent->plugin_file() ), array(__CLASS__, 'action_link' ));
			add_action( 'admin_menu', array(__CLASS__, 'customizer_menu' ));
		}	
	}

	public static function customizer_link() {
		
		return admin_url('customize.php?autofocus[panel]='.self::$config_id);
	}
	
	public static function action_link( $links ) {
		
		$links[] = '<a href="'. esc_url( self::customizer_link() ) .'">'.esc_html__('Customize', 'woo-floating-cart').'</a>';
		return $links;
	}

	public static function customizer_menu() {
		
		add_submenu_page( self::$parent->plugin_slug(), esc_html__('Customize', 'woo-floating-cart'), esc_html__('Customize', 'woo-floating-cart'), 'manage_options', self::$parent->plugin_slug('customize'), array(__CLASS__, 'customizer_redirect'));
	}
	
	public static function customizer_redirect() {
		
		wp_redirect(self::customizer_link());
		exit;
	}
	
	/**
	 * Kirki Config
	 */
	public static function add_config() {

		Kirki::add_config( self::$config_id, array(
		    'capability'    => 'edit_theme_options',
		    'option_type'   => 'option',
		    'option_name'	=> self::$config_id	    
		));	
	}

	/**
	 * Add panels to Kirki.
	 */
	public static function add_panels() {

		Kirki::add_panel( self::$config_id, array(
		    'priority'    => 130,
		    'title'       => esc_html__( 'Woo Floating Cart', 'woo-floating-cart' ),
		    'icon' => 'dashicons-cart'
		));
	}

	/**
	 * Add sections to Kirki.
	 */
	public static function add_sections() {

		Kirki::add_section( 
			self::section_id('general'), 
			array(
			    'title'          => esc_html__( 'General', 'woo-floating-cart'),
			    'panel'          => self::$config_id, 
			    'priority'       => 160,
			    'capability'     => 'edit_theme_options',
			    'icon' 			 => 'dashicons-admin-generic'
			)
		);

		Kirki::add_section( 
			self::section_id('visibility'), 
			array(
			    'title'          => esc_html__( 'Visibility', 'woo-floating-cart'),
			    'panel'          => self::$config_id, 
			    'priority'       => 160,
			    'capability'     => 'edit_theme_options',
			    'icon' 			 => 'dashicons-visibility'
			)
		);
				
		Kirki::add_section( 
			self::section_id('typography'), 
			array(
			    'title'          => esc_html__( 'Typography', 'woo-floating-cart'),
			    'panel'          => self::$config_id, 
			    'priority'       => 160,
			    'capability'     => 'edit_theme_options',
			    'icon' 			 => 'dashicons-editor-bold'
			)
		);
		
		Kirki::add_section( 
			self::section_id('trigger'), 
			array(
			    'title'          => esc_html__( 'Cart Trigger', 'woo-floating-cart'),
			    'panel'          => self::$config_id, 
			    'priority'       => 160,
			    'capability'     => 'edit_theme_options',
			    'icon' 			 => 'dashicons-external'
			)
		);
		
		Kirki::add_section( 
			self::section_id('header'), 
			array(
			    'title'          => esc_html__( 'Cart Header', 'woo-floating-cart'),
			    'panel'          => self::$config_id, 
			    'priority'       => 160,
			    'capability'     => 'edit_theme_options',
			    'icon'			 => 'dashicons-arrow-up-alt2'
			)
		);
		
		Kirki::add_section( 
			self::section_id('list'), 
			array(
			    'title'          => esc_html__( 'Cart List', 'woo-floating-cart'),
			    'panel'          => self::$config_id, 
			    'priority'       => 160,
			    'capability'     => 'edit_theme_options',
			    'icon'			 => 'dashicons-feedback'
			)
		);
		
		Kirki::add_section( 
			self::section_id('footer'), 
			array(
			    'title'          => esc_html__( 'Cart Footer', 'woo-floating-cart'),
			    'panel'          => self::$config_id, 
			    'priority'       => 160,
			    'capability'     => 'edit_theme_options',
			    'icon'			 => 'dashicons-arrow-down-alt2'
			)
		);

	}

	/**
	 * Add fields to Kirki.
	 */
	public static function add_fields() {
		
		// General Settings.
		
		require_once self::$path . '/fields/general.php';
		require_once self::$path . '/fields/visibility.php';
		require_once self::$path . '/fields/typography.php';
		require_once self::$path . '/fields/trigger.php';
		require_once self::$path . '/fields/header.php';
		require_once self::$path . '/fields/list.php';
		require_once self::$path . '/fields/footer.php';

	}
	
	public static function section_id($id) {
		
		return self::$config_id.'_'.$id;
	}
	
	public static function field_id($id) {
		
		return $id;
	}

	public static function get_option($id, $default = null) {

		$value = Kirki::get_option( self::$config_id, $id );
		if($value === false && $default !== null) {
			$value = $default;
		}
	
		return $value;
	}
	
	
	public static function customizer_styles() {
		
		wp_enqueue_style( self::$config_id.'-customizer-styles', self::$parent->plugin_url(). 'includes/customizer/assets/css/customizer.css', array(), self::$parent->plugin_version());
	}

	// Allow SVG
	public static function check_filetype_and_ext($data, $file, $filename, $mimes) {
	
	  global $wp_version;
	  if ( $wp_version <= '4.7.1' ) {
	     return $data;
	  }
	
	  $filetype = wp_check_filetype( $filename, $mimes );
	
	  return [
	      'ext'             => $filetype['ext'],
	      'type'            => $filetype['type'],
	      'proper_filename' => $data['proper_filename']
	  ];
	
	}

	public static function allow_myme_types($mime_types){

		$mime_types['svg'] = 'image/svg+xml'; //Adding svg extension
		$mime_types['svgz'] = 'image/svg+xml';

		return $mime_types;

	}
				
} // End Class
	
