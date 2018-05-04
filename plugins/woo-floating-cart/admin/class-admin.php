<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://xplodedthemes.com
 * @since      1.0.0
 *
 * @package    Woo_Floating_Cart
 * @subpackage Woo_Floating_Cart/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Woo_Floating_Cart
 * @subpackage Woo_Floating_Cart/admin
 * @author     XplodedThemes <helpdesk@xplodedthemes.com>
 */
class Woo_Floating_Cart_Admin {

	/**
	 * Core class reference.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      obj    core    Core Class
	 */
	private $core;
	
	public $default_section = 'license';


	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param    obj    $core    Plugin core class.
	 */
	public function __construct( &$core ) {

		$this->core = $core;
		
		$this->sections = array(
			'license' => esc_html('License', 'woo-floating-cart'),
			'changelog' => esc_html__( 'Change Log', 'woo-floating-cart' ),
			'support' => esc_html__( 'Support', 'woo-floating-cart' ),
			'shop' => esc_html__( 'Shop', 'woo-floating-cart' ),
		);
		
		if(defined('WOOFC_LITE')) {
			array_shift($this->sections);
			$this->sections['fullversion'] = esc_html__( 'Buy Full Version', 'woo-floating-cart' );
		}	
				
		if(!empty($_GET['section'])) {
			$this->section = esc_html($_GET['section']);
		}else{
			$this->section = key(array_slice($this->sections, 0, 1));
		}
	
	}

	function admin_body_class( $classes ) {
		
		$screen = get_current_screen();
		
		if(!empty($screen) && strpos($screen->base, $this->core->plugin_slug()) !== false) {
	    	$classes .= ' '.$this->core->plugin_slug('admin');
	    }
	    
	    return $classes;
	}	
	
	/**
	 * Check if woocommerce is activated, error if not
	 *
	 * @since    1.0.0
	 */
	public function woocommerce_missing_notice() {
		
		if ( ! class_exists( 'WooCommerce' ) ) {
			
			$class = 'notice notice-error';
			$message = sprintf( 
				__( '<strong>%1$s</strong> plugin requires %2$s to be installed and active.', 'woo-floating-cart' ), 
				$this->core->plugin_name(),
				'<a target="_blank" href="https://en-ca.wordpress.org/plugins/woocommerce/">WooCommerce</a>'
			);
			printf( '<div class="%1$s"><p>%2$s</p></div>', $class, $message ); 
			
			deactivate_plugins( $this->core->plugin_file() );
		} 
	}

    
	/**
	 * Redirect to plugin page after activation
	 */
	 
    public function activation_redirect()
    {
		if (get_option('woofc_activation_redirect', false)) {
			
        	delete_option('woofc_activation_redirect');
        	
        	if ( class_exists( 'WooCommerce' ) ) {
				exit(wp_redirect($this->core->plugin_admin_url()));
			}
    	}
    }
    
	/**
	 * Deactivate the lite version if activated along the full version.
	 */
	 	
	public function check_upgraded() {
	
	  	if ( defined('WOOFC_LITE') && defined('WOOFC_PRO')) {
		  	
		  	require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
	     	deactivate_plugins( plugin_basename( WOOFC_LITE_PLUGIN ));
	     	wp_redirect($this->core->plugin_admin_url('', array('woofcaction' => 'upgraded')));
	     	exit;
	     	
	  	}
	}	

	/**
	 * Check id upgrade succeeded and show message
	 */
	 	
	public function upgrade_success() {
	
	  	if(woofc_is_action('upgraded')) {
		  	
		  	add_action( 'admin_notices', array($this, 'upgrade_success_notice' ));
	  	}
	}	
	
	/**
	 * Show upgrade succeeded notice
	 */
	 
	function upgrade_success_notice() {
	    ?>
	    <div class="notice notice-success is-dismissible woofc-notice">
	        <p>
		        <?php echo sprintf(esc_html__( 'Thank you for upgrading %s to Full Version!', 'woo-floating-cart' ), '<strong>'.$this->core->plugin_name().'</strong>'); ?>
				&nbsp; | &nbsp;&nbsp;<a href="<?php echo esc_url(Woo_Floating_Cart_Customizer::customizer_link());?>"><?php echo esc_html__('Start Customizing', 'woo-floating-cart'); ?></a>
			</p>
	    </div>
	    <?php
	}
	
	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Woo_Floating_Cart_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Woo_Floating_Cart_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->core->plugin_slug(), $this->core->plugin_url( 'admin' ) . 'assets/css/admin.css', array(), $this->core->plugin_version(), 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Woo_Floating_Cart_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Woo_Floating_Cart_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->core->plugin_slug(), $this->core->plugin_url( 'admin' ) . 'assets/js/admin'.$this->core->script_suffix.'.js', array( 'jquery' ), $this->core->plugin_version(), false );

	}
	
	function action_link( $links ) {
		
		if(defined('WOOFC_LITE')) {
			return $links;
		}
		
		if(!$this->core->license()->isActivated()) {
			$link_label = esc_html__('Activate License', 'woo-floating-cart');
			$link_style = "color: #a00;";
		}else{
			$link_label = esc_html__('License Activated', 'woo-floating-cart');
			$link_style = "color: green;";
		}	
		
		$links[] = '<a style="'.esc_attr($link_style).'" href="'. esc_url( $this->core->plugin_admin_url() ) .'">'.$link_label.'</a>';
		return $links;
	}
	
	public function settings_menu() {
		
		add_menu_page( 'Woo Floating Cart', 'Woo Floating Cart', 'manage_options', $this->core->plugin_slug(), array($this, 'settings_page'), 'dashicons-cart' );
		
		foreach($this->sections as $id => $section) {
			if($id == $this->default_section) {
				add_submenu_page( $this->core->plugin_slug(), $section, $section, 'manage_options', $this->core->plugin_slug(), array($this, 'settings_page'));
			}else{
	
				add_submenu_page( $this->core->plugin_slug(), $section, $section, 'manage_options', $this->core->plugin_slug($id), function() use ($id) {
					$this->section = $id;
					$this->settings_page();
				});
			}	
		}
	}
	

	public function settings_page() {
		
		if ( !current_user_can( 'manage_options' ) )  {
			wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
		}
		
		include 'partials/class-admin.php';
	}

	public function show_nav() {
		
		echo '<h2 class="nav-tab-wrapper">';
		
		foreach($this->sections as $id => $section) {
			
			$active = '';
			if($this->is_section($id)) {
				$active = ' nav-tab-active';
			}
			echo '<a href="'.$this->get_section_url($id).'" class="nav-tab'.$active.'">'.$section.'</a>';
		}
		
		echo '</h2>';
	}
	
	public function show_section() {
		
		include( $this->core->plugin_path('admin/partials/sections/', $this->section.'.php'));
	}
	
	public function is_section($section) {
		
		return $this->section === $section;
	}
		

	public function get_url() {
		
		return esc_url($this->core->plugin_admin_url());
	}
	
	public function get_section_id() {
		
		return $this->section;
	}
	
	public function get_section_title() {
		
		return $this->sections[$this->section];
	}
		
	public function get_section_url($section = '', $args = array()) {
		
		if($section == $this->default_section) {
			$section = '';
		}	
		return esc_url($this->core->plugin_admin_url($section, $args));
	}

	function write_changelog() {
	
		global $wp_filesystem;

		$plugin_id = dirname( plugin_basename( $this->core->plugin_file() ) );
		$transient_key = $this->core->plugin_slug('changelog');
		$readme_file = $this->core->plugin_path(null, 'readme.txt');

		if ( false === ( $value = get_transient( $transient_key ) ) || !empty($_GET['nocache']) || !file_exists($readme_file)) {
			
			$changelog = $this->get_changelog('text');
	
			if(!empty($changelog)) {
						
				if( empty( $wp_filesystem ) ) {
				  	require_once( ABSPATH .'/wp-admin/includes/file.php' );
				  	WP_Filesystem();
				}
	
				$readme_lines = array();
				$readme_data = $wp_filesystem->get_contents_array($readme_file);
				foreach($readme_data as $line)
				{
					array_push($readme_lines, $line);
					
					if(strpos($line, '== Changelog ==') !== false)
					{
						break;
					}
				}
				
				$readme_content = implode("", $readme_lines);
				$readme_content .= "\r\n".$changelog;
		
				if($wp_filesystem->put_contents($readme_file, $readme_content,  (0777 & ~ umask()))) {
					
					set_transient($transient_key, time());
				}
			}
		}

	}

	public function get_changelog($format = 'html') {
		
		$changelog_file = $this->core->plugin_path('admin/data', 'changelog.php');
	
		if(!file_exists($changelog_file)) {
			return "";
		}
		
		ob_start(); 
		
		$changelog = include($changelog_file);
		
		// ----------------------------------------------------------------
		
		if(!empty($changelog)): 
			
			if($format == 'text'):
			
				$output = '';
				foreach($changelog as $update) {
		
					$output .= '= V.'.$update["version"].' - '.$update["date"]." =\r\n";
					
					foreach($update["changes"] as $key => $_update) {
						
						if(is_array($_update)) {
							foreach($_update as $item) {
								$output .= '- '.strip_tags(str_replace("<br>", "\r\n  ", $item))."\r\n";
							}
						}else{
							$output .= '- '.strip_tags(str_replace("<br>", "\r\n  ", $_update))."\r\n";
						}		
					}
					$output .= "\r\n";
				}
				echo $output;
		
		
			elseif($format == 'envato'):?>
		
				<?php 
				$output = "\n";
				
				foreach($changelog as $update) {
		
					$output .= '<h4>V.'.$update["version"].' - <em>'.$update["date"].'</em></h4>'."\r\n";
					$output .= '<ul>'."\r\n";
					
					foreach($update["changes"] as $key => $_update) {
						
						if(is_array($_update)) {
							
							foreach($_update as $item) {
								$output .= "\t".'<li>'.$item.'</li>'."\r\n";
							}
							
						}else{
							$output .= "\t".'<li>'.$_update.'</li>'."\r\n";
						}		
					}
					
					$output .= '</ul>'."\r\n";
				}
				echo $output;
				?>
						
			<?php else: ?>	
		
				<div class="woofc-changelog">	
				
					<?php foreach($changelog as $update): ?>
				
						<h4>V.<?php echo $update["version"]; ?> - <em><?php echo $update["date"]; ?></em></h4>
						<ul>
						<?php foreach($update["changes"] as $key => $_update): ?>
						
							<?php if(is_array($_update)): ?>
							
								<?php foreach($_update as $item): ?>
								
									<li><span class="update-type <?php echo ($key); ?>"><?php echo ucfirst($key); ?></span> <span class="update-txt"><?php echo ($item); ?></span></li>
									
								<?php endforeach; ?>
								
							<?php else: ?>
									
								<li><span class="update-type <?php echo ($key); ?>"><?php echo ($key); ?></span> <span class="update-txt"><?php echo ($_update); ?></span></li>
									
							<?php endif; ?>
							
						<?php endforeach; ?>
						</ul>
						
					<?php endforeach; ?>
				</div>
				
			<?php endif;
				
		endif;
		
		return ob_get_clean();	

	}
	
	public function get_shop_products() {

		$api_url = 'http://xplodedthemes.com/api/products.php?format=html&exclude='.$this->core->plugin_slug();
		$shop_html = $this->get_remote_content($api_url);
		
		return $shop_html;
	}

	private function get_remote_content( $url, $json_decode = false ) {
		
		$cache_key = md5($url);
		
		$content = get_site_transient( $cache_key );

		if ( $content === false || !empty($_GET['nocache']) !== null ) {
	
			$response = wp_remote_get( $url, array( 'sslverify' => false ) );

			// Stop here if the is an error.
			if ( is_wp_error( $response ) ) {
				
				$content = '';
				
				// Set temporary transient.
				set_site_transient($cache_key, $content, MINUTE_IN_SECONDS );
				
			}else{
		
				// Retrieve data from the body and decode json format.
				$content = wp_remote_retrieve_body( $response );

				set_site_transient($cache_key, $content, DAY_IN_SECONDS );
			}	
	
		}
	
		if($json_decode) {
			$content = json_decode($content , true );
		}
				
		return $content;
	}				
}
