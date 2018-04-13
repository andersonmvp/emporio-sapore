<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

if (!class_exists('GSF_Inc_Helper')) {
	class GSF_Inc_Helper {
		private static $_instance;
		public static function getInstance()
		{
			if (self::$_instance == NULL) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}

		/**
		 * Create field object from field type
		 *
		 * @param $type
		 * @return GSF_Field
		 */
		public function createField($type) {
			$class_name = str_replace('_', ' ', $type);
			$class_name = ucwords($class_name);
			$class_name = str_replace(' ', '_', $class_name);
			$class_name = 'GSF_Field_' . $class_name;
			if (class_exists($class_name)) {
				return new $class_name();
			}
			return null;
		}

		public function setFieldPrefix($prefix) {
			$GLOBALS['gsf_field_prefix'] = $prefix;
		}

		public function getFieldPrefix() {
			return isset($GLOBALS['gsf_field_prefix']) ? $GLOBALS['gsf_field_prefix'] : '';
		}

		/**
		 * Set field layout
		 * @param $layout
		 */
		public function setFieldLayout($layout) {
			if (!in_array($layout, array('inline', 'full'))) {
				$layout = 'inline';
			}
			$GLOBALS['gsf_field_layout'] = $layout;
		}

		/**
		 * Get field layout
		 * @return string
		 */
		public function getFieldLayout() {
			if (!isset($GLOBALS['gsf_field_layout'])) {
				$GLOBALS['gsf_field_layout'] = 'inline';
			}
			return $GLOBALS['gsf_field_layout'];
		}

		/**
		 * Get template
		 * @param $slug
		 * @param $args
		 */
		public function getTemplate($slug, $args = array()) {
			if ($args && is_array($args)) {
				extract($args);
			}
			$located = GSF()->pluginDir($slug . '.php');
			if (!file_exists($located)) {
				_doing_it_wrong(__FUNCTION__, sprintf('<code>%s</code> does not exist.', $slug), '1.0');

				return;
			}
			include($located);
		}

		/**
		 * Get plugin assets url
		 * @param $file
		 * @return string
		 */
		public function getAssetUrl($file) {
			if (!file_exists(GSF()->pluginDir($file)) || (defined('SCRIPT_DEBUG') && SCRIPT_DEBUG)) {
				$ext = explode('.', $file);
				$ext = end($ext);
				$normal_file = preg_replace('/((\.min\.css)|(\.min\.js))$/', '', $file);
				if ($normal_file != $file) {
					$normal_file = untrailingslashit($normal_file) . ".{$ext}";
					if (file_exists(GSF()->pluginDir($normal_file))) {
						return GSF()->pluginUrl(untrailingslashit($normal_file));
					}
				}
			}
			return GSF()->pluginUrl(untrailingslashit($file));
		}

		public function renderFields(&$config, &$values) {
			$list_section = array();
			if (isset($config['section'])) {
				foreach ($config['section'] as &$section) {
					$list_section[] = array(
						'id'    => $section['id'],
						'title' => $section['title'],
						'icon'  => isset($section['icon']) ? $section['icon'] : 'dashicons-admin-generic',
					);
				}
			}
			$this->getTemplate('admin/templates/meta-start', array(
				'list_section' => $list_section
			));

			if (!empty($config)) {
				if (isset($config['section'])) {
					?>
					<?php foreach ($config['section'] as &$section): ?>
						<div id="section_<?php echo esc_attr($section['id'])?>" class="gsf-section-container">
							<h4 class="gsf-section-title">
								<i class="gsf-section-title-icon <?php echo isset($section['icon']) ? esc_attr($section['icon']) : 'dashicons dashicons-admin-generic' ; ?>"></i>
								<span><?php echo esc_html($section['title']); ?></span>
								<span class="gsf-section-title-toggle"></span>
							</h4>
							<div class="gsf-section-inner">
								<?php if (isset($section['fields'])): ?>
									<?php $this->renderSubFields($section['fields'], $values) ?>
								<?php endif;?>
							</div>
						</div><!-- /.gsf-section-container  -->
					<?php endforeach;?>
				<?php
				} else {
					$this->renderSubFields($config['fields'], $values);
				}
			}

			$this->getTemplate('admin/templates/meta-end');
		}

		public function renderSubFields(&$fields, &$values) {
			foreach ($fields as &$config) {
				$type = isset($config['type']) ? $config['type'] : '';
				if (empty($type)) {
					continue;
				}
				$id = isset($config['id']) ? $config['id'] : '';
				$field = $this->createField($config['type']);
				$field->_setting = &$config;
				if (in_array($type, array('group', 'row'))) {
					$field->_value = $values;
				}
				else {
					if (!empty($id)) {
						$field->_value = isset($values[$id]) ? $values[$id] : null;
					}
					else {
						$field->_value = null;
					}
				}

				$field->render();
			}
		}

		/**
		 * Get Config Keys
		 *
		 * @param $configs
		 * @return array
		 */
		public function getConfigKeys(&$configs) {
			$field_keys = array();
			if (isset($configs['section'])) {
				foreach ($configs['section'] as $section) {
					if (isset($section['fields'])) {
						$field_keys = array_merge($field_keys, $this->getConfigFieldKeys($section['fields']));
					}
				}
			} else {
				if (isset($configs['fields'])) {
					$field_keys = array_merge($field_keys, $this->getConfigFieldKeys($configs['fields']));
				}
			}
			return $field_keys;
		}

		private function getConfigFieldKeys(&$fields) {
			$field_keys = array();
			foreach ($fields as $field) {
				if (!isset($field['type'])) {
					continue;
				}
				$field_type = $field['type'];

				switch ($field_type) {
					case 'row':
					case 'group':
						$field_keys = array_merge($field_keys, $this->getConfigFieldKeys($field['fields']));
						break;
					default:
						if (!isset($field['id'])) {
							break;
						}
						$field_obj = $this->createField($field_type);
						$field_obj->_setting = $field;
						$field_keys[$field['id']] = array(
							'type' => $field_type,
							'empty_value' => $field_obj->getEmptyValue()
						);
						break;
				}
			}
			return $field_keys;
		}

		public function getConfigDefault(&$configs, $current_section = '') {
			$field_default = array();
			if (!empty($current_section)) {
				if (isset($configs['section'])) {
					foreach ($configs['section'] as $section) {
						if ('section_' . $section['id'] == $current_section) {
							if (isset($section['fields'])) {
								$field_default = array_merge($field_default, $this->getConfigDefaultField($section['fields']));
							}
						}
					}
				}
			}
			else {
				if (isset($configs['section'])) {
					foreach ($configs['section'] as $section) {
						if (isset($section['fields'])) {
							$field_default = array_merge($field_default, $this->getConfigDefaultField($section['fields']));
						}
					}
				} else {
					if (isset($configs['fields'])) {
						$field_default = array_merge($field_default, $this->getConfigDefaultField($configs['fields']));
					}
				}
			}
			return $field_default;
		}

		private function getConfigDefaultField(&$fields) {
			$field_default = array();
			foreach ($fields as $field) {
				if (!isset($field['type'])) {
					continue;
				}
				$field_type = $field['type'];

				switch ($field_type) {
					case 'row':
					case 'group':
						$field_default = array_merge($field_default, $this->getConfigDefaultField($field['fields']));
						break;
					default:
						if (!isset($field['id'])) {
							break;
						}
						$field_obj = $this->createField($field_type);
						$field_obj->_setting = $field;
						$field_default[$field['id']] = $field_obj->getFieldDefault();
						break;
				}
			}
			return $field_default;
		}

		/**
		 * Get list sidebars
		 *
		 * @return array
		 */
		public function getSidebars()
		{
			$sidebars = array();
			if (is_array($GLOBALS['wp_registered_sidebars'])) {
				foreach ($GLOBALS['wp_registered_sidebars'] as $sidebar) {
					$sidebars[$sidebar['id']] = ucwords($sidebar['name']);
				}
			}
			return $sidebars;
		}

		/**
		 * Get listing menu
		 *
		 * @return array
		 */
		public function getMenus()
		{
			$user_menus = get_categories(array(
				'taxonomy'   => 'nav_menu',
				'hide_empty' => false,
				'orderby'    => 'name',
				'order'      => 'ASC'
			));
			$menus = array();
			foreach ($user_menus as $menu) {
				$menus[$menu->term_id] = $menu->name;
			}

			return $menus;
		}

		/**
		 * Get listing taxonomies
		 *
		 * @param array $params
		 * @return array
		 */
		public function getTaxonomies($params = array())
		{
			$args = array(
				'orderby' => 'name',
				'order'   => 'ASC',
				'hide_empty' => false,
			);
			if (!empty($params)) {
				$args = array_merge($args, $params);
			}

			$categories = get_categories($args);
			$taxs = array();
			foreach ($categories as $cate) {
				$taxs[$cate->term_id] = $cate->name;
			}

			return $taxs;
		}

		/**
		 * Get listing post
		 *
		 * @param array $params
		 * @return array
		 */
		public function getPosts($params = array())
		{
			$args = array(
				'numberposts' => 20,
				'orderby' => 'post_title',
				'order'   => 'ASC',
			);
			if (!empty($params)) {
				$args = array_merge($args, $params);
			}
			$posts = get_posts($args);
			$ret_posts = array();
			foreach ($posts as $post) {
				$ret_posts[$post->ID] = $post->post_title;
			}

			return $ret_posts;
		}

		/**
		 * Render selected attribute
		 *
		 * @param $value
		 * @param $current
		 */
		public function theSelected($value, $current) {
			echo ((is_array($current) && in_array($value, $current)) || (!is_array($current) && ($value == $current))) ? 'selected="selected"' : '';
		}

		/**
		 * Render checked attribute
		 *
		 * @param $value
		 * @param $current
		 */
		public function theChecked($value, $current) {
			echo ((is_array($current) && in_array($value, $current)) || (!is_array($current) && ($value == $current))) ? 'checked="checked"' : '';
		}

		/**
		 * Get attachment id by url
		 *
		 * @param $url
		 * @return int
		 */
		public function getAttachmentIdByUrl($url) {
			global $wpdb;
			$attachment = $wpdb->get_col($wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE guid='%s';", $url));
			if (!empty($attachment)) {
				return $attachment[0];
			}

			return 0;
		}

		/**
		 * Get framework nonce verify key
		 * @return mixed|void
		 */
		public function getNonceVerifyKey() {
			return apply_filters('gsf_nonce_verify_key', 'GSF_SMART_FRAMEWORK_VERIFY');
		}

		/**
		 * Get framework nonce value
		 * @return string
		 */
		public function getNonceValue() {
			return wp_create_nonce($this->getNonceVerifyKey());
		}

		public function getFontIcons() {
			return apply_filters('gsf_font_icon_config', array(
				'fontawesome' => array(
					'label' => esc_html__('Font Awesome','april-framework'),
					'iconGroup' => json_decode('[{"id":"new","title":"41 New Icons in 4.7","icons":["fa fa-address-book","fa fa-address-book-o","fa fa-address-card","fa fa-address-card-o","fa fa-bandcamp","fa fa-bath","fa fa-bathtub","fa fa-drivers-license","fa fa-drivers-license-o","fa fa-eercast","fa fa-envelope-open","fa fa-envelope-open-o","fa fa-etsy","fa fa-free-code-camp","fa fa-grav","fa fa-handshake-o","fa fa-id-badge","fa fa-id-card","fa fa-id-card-o","fa fa-imdb","fa fa-linode","fa fa-meetup","fa fa-microchip","fa fa-podcast","fa fa-quora","fa fa-ravelry","fa fa-s15","fa fa-shower","fa fa-snowflake-o","fa fa-superpowers","fa fa-telegram","fa fa-thermometer","fa fa-thermometer-0","fa fa-thermometer-1","fa fa-thermometer-2","fa fa-thermometer-3","fa fa-thermometer-4","fa fa-thermometer-empty","fa fa-thermometer-full","fa fa-thermometer-half","fa fa-thermometer-quarter","fa fa-thermometer-three-quarters","fa fa-times-rectangle","fa fa-times-rectangle-o","fa fa-user-circle","fa fa-user-circle-o","fa fa-user-o","fa fa-vcard","fa fa-vcard-o","fa fa-window-close","fa fa-window-close-o","fa fa-window-maximize","fa fa-window-minimize","fa fa-window-restore","fa fa-wpexplorer"]},{"id":"web-application","title":"Web Application Icons","icons":["fa fa-address-book","fa fa-address-book-o","fa fa-address-card","fa fa-address-card-o","fa fa-adjust","fa fa-american-sign-language-interpreting","fa fa-anchor","fa fa-archive","fa fa-area-chart","fa fa-arrows","fa fa-arrows-h","fa fa-arrows-v","fa fa-asl-interpreting","fa fa-assistive-listening-systems","fa fa-asterisk","fa fa-at","fa fa-audio-description","fa fa-automobile","fa fa-balance-scale","fa fa-ban","fa fa-bank","fa fa-bar-chart","fa fa-bar-chart-o","fa fa-barcode","fa fa-bars","fa fa-bath","fa fa-bathtub","fa fa-battery","fa fa-battery-0","fa fa-battery-1","fa fa-battery-2","fa fa-battery-3","fa fa-battery-4","fa fa-battery-empty","fa fa-battery-full","fa fa-battery-half","fa fa-battery-quarter","fa fa-battery-three-quarters","fa fa-bed","fa fa-beer","fa fa-bell","fa fa-bell-o","fa fa-bell-slash","fa fa-bell-slash-o","fa fa-bicycle","fa fa-binoculars","fa fa-birthday-cake","fa fa-blind","fa fa-bluetooth","fa fa-bluetooth-b","fa fa-bolt","fa fa-bomb","fa fa-book","fa fa-bookmark","fa fa-bookmark-o","fa fa-braille","fa fa-briefcase","fa fa-bug","fa fa-building","fa fa-building-o","fa fa-bullhorn","fa fa-bullseye","fa fa-bus","fa fa-cab","fa fa-calculator","fa fa-calendar","fa fa-calendar-check-o","fa fa-calendar-minus-o","fa fa-calendar-o","fa fa-calendar-plus-o","fa fa-calendar-times-o","fa fa-camera","fa fa-camera-retro","fa fa-car","fa fa-caret-square-o-down","fa fa-caret-square-o-left","fa fa-caret-square-o-right","fa fa-caret-square-o-up","fa fa-cart-arrow-down","fa fa-cart-plus","fa fa-cc","fa fa-certificate","fa fa-check","fa fa-check-circle","fa fa-check-circle-o","fa fa-check-square","fa fa-check-square-o","fa fa-child","fa fa-circle","fa fa-circle-o","fa fa-circle-o-notch","fa fa-circle-thin","fa fa-clock-o","fa fa-clone","fa fa-close","fa fa-cloud","fa fa-cloud-download","fa fa-cloud-upload","fa fa-code","fa fa-code-fork","fa fa-coffee","fa fa-cog","fa fa-cogs","fa fa-comment","fa fa-comment-o","fa fa-commenting","fa fa-commenting-o","fa fa-comments","fa fa-comments-o","fa fa-compass","fa fa-copyright","fa fa-creative-commons","fa fa-credit-card","fa fa-credit-card-alt","fa fa-crop","fa fa-crosshairs","fa fa-cube","fa fa-cubes","fa fa-cutlery","fa fa-dashboard","fa fa-database","fa fa-deaf","fa fa-deafness","fa fa-desktop","fa fa-diamond","fa fa-dot-circle-o","fa fa-download","fa fa-drivers-license","fa fa-drivers-license-o","fa fa-edit","fa fa-ellipsis-h","fa fa-ellipsis-v","fa fa-envelope","fa fa-envelope-o","fa fa-envelope-open","fa fa-envelope-open-o","fa fa-envelope-square","fa fa-eraser","fa fa-exchange","fa fa-exclamation","fa fa-exclamation-circle","fa fa-exclamation-triangle","fa fa-external-link","fa fa-external-link-square","fa fa-eye","fa fa-eye-slash","fa fa-eyedropper","fa fa-fax","fa fa-feed","fa fa-female","fa fa-fighter-jet","fa fa-file-archive-o","fa fa-file-audio-o","fa fa-file-code-o","fa fa-file-excel-o","fa fa-file-image-o","fa fa-file-movie-o","fa fa-file-pdf-o","fa fa-file-photo-o","fa fa-file-picture-o","fa fa-file-powerpoint-o","fa fa-file-sound-o","fa fa-file-video-o","fa fa-file-word-o","fa fa-file-zip-o","fa fa-film","fa fa-filter","fa fa-fire","fa fa-fire-extinguisher","fa fa-flag","fa fa-flag-checkered","fa fa-flag-o","fa fa-flash","fa fa-flask","fa fa-folder","fa fa-folder-o","fa fa-folder-open","fa fa-folder-open-o","fa fa-frown-o","fa fa-futbol-o","fa fa-gamepad","fa fa-gavel","fa fa-gear","fa fa-gears","fa fa-gift","fa fa-glass","fa fa-globe","fa fa-graduation-cap","fa fa-group","fa fa-hand-grab-o","fa fa-hand-lizard-o","fa fa-hand-paper-o","fa fa-hand-peace-o","fa fa-hand-pointer-o","fa fa-hand-rock-o","fa fa-hand-scissors-o","fa fa-hand-spock-o","fa fa-hand-stop-o","fa fa-handshake-o","fa fa-hard-of-hearing","fa fa-hashtag","fa fa-hdd-o","fa fa-headphones","fa fa-heart","fa fa-heart-o","fa fa-heartbeat","fa fa-history","fa fa-home","fa fa-hotel","fa fa-hourglass","fa fa-hourglass-1","fa fa-hourglass-2","fa fa-hourglass-3","fa fa-hourglass-end","fa fa-hourglass-half","fa fa-hourglass-o","fa fa-hourglass-start","fa fa-i-cursor","fa fa-id-badge","fa fa-id-card","fa fa-id-card-o","fa fa-image","fa fa-inbox","fa fa-industry","fa fa-info","fa fa-info-circle","fa fa-institution","fa fa-key","fa fa-keyboard-o","fa fa-language","fa fa-laptop","fa fa-leaf","fa fa-legal","fa fa-lemon-o","fa fa-level-down","fa fa-level-up","fa fa-life-bouy","fa fa-life-buoy","fa fa-life-ring","fa fa-life-saver","fa fa-lightbulb-o","fa fa-line-chart","fa fa-location-arrow","fa fa-lock","fa fa-low-vision","fa fa-magic","fa fa-magnet","fa fa-mail-forward","fa fa-mail-reply","fa fa-mail-reply-all","fa fa-male","fa fa-map","fa fa-map-marker","fa fa-map-o","fa fa-map-pin","fa fa-map-signs","fa fa-meh-o","fa fa-microchip","fa fa-microphone","fa fa-microphone-slash","fa fa-minus","fa fa-minus-circle","fa fa-minus-square","fa fa-minus-square-o","fa fa-mobile","fa fa-mobile-phone","fa fa-money","fa fa-moon-o","fa fa-mortar-board","fa fa-motorcycle","fa fa-mouse-pointer","fa fa-music","fa fa-navicon","fa fa-newspaper-o","fa fa-object-group","fa fa-object-ungroup","fa fa-paint-brush","fa fa-paper-plane","fa fa-paper-plane-o","fa fa-paw","fa fa-pencil","fa fa-pencil-square","fa fa-pencil-square-o","fa fa-percent","fa fa-phone","fa fa-phone-square","fa fa-photo","fa fa-picture-o","fa fa-pie-chart","fa fa-plane","fa fa-plug","fa fa-plus","fa fa-plus-circle","fa fa-plus-square","fa fa-plus-square-o","fa fa-podcast","fa fa-power-off","fa fa-print","fa fa-puzzle-piece","fa fa-qrcode","fa fa-question","fa fa-question-circle","fa fa-question-circle-o","fa fa-quote-left","fa fa-quote-right","fa fa-random","fa fa-recycle","fa fa-refresh","fa fa-registered","fa fa-remove","fa fa-reorder","fa fa-reply","fa fa-reply-all","fa fa-retweet","fa fa-road","fa fa-rocket","fa fa-rss","fa fa-rss-square","fa fa-s15","fa fa-search","fa fa-search-minus","fa fa-search-plus","fa fa-send","fa fa-send-o","fa fa-server","fa fa-share","fa fa-share-alt","fa fa-share-alt-square","fa fa-share-square","fa fa-share-square-o","fa fa-shield","fa fa-ship","fa fa-shopping-bag","fa fa-shopping-basket","fa fa-shopping-cart","fa fa-shower","fa fa-sign-in","fa fa-sign-language","fa fa-sign-out","fa fa-signal","fa fa-signing","fa fa-sitemap","fa fa-sliders","fa fa-smile-o","fa fa-snowflake-o","fa fa-soccer-ball-o","fa fa-sort","fa fa-sort-alpha-asc","fa fa-sort-alpha-desc","fa fa-sort-amount-asc","fa fa-sort-amount-desc","fa fa-sort-asc","fa fa-sort-desc","fa fa-sort-down","fa fa-sort-numeric-asc","fa fa-sort-numeric-desc","fa fa-sort-up","fa fa-space-shuttle","fa fa-spinner","fa fa-spoon","fa fa-square","fa fa-square-o","fa fa-star","fa fa-star-half","fa fa-star-half-empty","fa fa-star-half-full","fa fa-star-half-o","fa fa-star-o","fa fa-sticky-note","fa fa-sticky-note-o","fa fa-street-view","fa fa-suitcase","fa fa-sun-o","fa fa-support","fa fa-tablet","fa fa-tachometer","fa fa-tag","fa fa-tags","fa fa-tasks","fa fa-taxi","fa fa-television","fa fa-terminal","fa fa-thermometer","fa fa-thermometer-0","fa fa-thermometer-1","fa fa-thermometer-2","fa fa-thermometer-3","fa fa-thermometer-4","fa fa-thermometer-empty","fa fa-thermometer-full","fa fa-thermometer-half","fa fa-thermometer-quarter","fa fa-thermometer-three-quarters","fa fa-thumb-tack","fa fa-thumbs-down","fa fa-thumbs-o-down","fa fa-thumbs-o-up","fa fa-thumbs-up","fa fa-ticket","fa fa-times","fa fa-times-circle","fa fa-times-circle-o","fa fa-times-rectangle","fa fa-times-rectangle-o","fa fa-tint","fa fa-toggle-down","fa fa-toggle-left","fa fa-toggle-off","fa fa-toggle-on","fa fa-toggle-right","fa fa-toggle-up","fa fa-trademark","fa fa-trash","fa fa-trash-o","fa fa-tree","fa fa-trophy","fa fa-truck","fa fa-tty","fa fa-tv","fa fa-umbrella","fa fa-universal-access","fa fa-university","fa fa-unlock","fa fa-unlock-alt","fa fa-unsorted","fa fa-upload","fa fa-user","fa fa-user-circle","fa fa-user-circle-o","fa fa-user-o","fa fa-user-plus","fa fa-user-secret","fa fa-user-times","fa fa-users","fa fa-vcard","fa fa-vcard-o","fa fa-video-camera","fa fa-volume-control-phone","fa fa-volume-down","fa fa-volume-off","fa fa-volume-up","fa fa-warning","fa fa-wheelchair","fa fa-wheelchair-alt","fa fa-wifi","fa fa-window-close","fa fa-window-close-o","fa fa-window-maximize","fa fa-window-minimize","fa fa-window-restore","fa fa-wrench"]},{"id":"accessibility","title":"Accessibility Icons","icons":["fa fa-american-sign-language-interpreting","fa fa-asl-interpreting","fa fa-assistive-listening-systems","fa fa-audio-description","fa fa-blind","fa fa-braille","fa fa-cc","fa fa-deaf","fa fa-deafness","fa fa-hard-of-hearing","fa fa-low-vision","fa fa-question-circle-o","fa fa-sign-language","fa fa-signing","fa fa-tty","fa fa-universal-access","fa fa-volume-control-phone","fa fa-wheelchair","fa fa-wheelchair-alt"]},{"id":"hand","title":"Hand Icons","icons":["fa fa-hand-grab-o","fa fa-hand-lizard-o","fa fa-hand-o-down","fa fa-hand-o-left","fa fa-hand-o-right","fa fa-hand-o-up","fa fa-hand-paper-o","fa fa-hand-peace-o","fa fa-hand-pointer-o","fa fa-hand-rock-o","fa fa-hand-scissors-o","fa fa-hand-spock-o","fa fa-hand-stop-o","fa fa-thumbs-down","fa fa-thumbs-o-down","fa fa-thumbs-o-up","fa fa-thumbs-up"]},{"id":"transportation","title":"Transportation Icons","icons":["fa fa-ambulance","fa fa-automobile","fa fa-bicycle","fa fa-bus","fa fa-cab","fa fa-car","fa fa-fighter-jet","fa fa-motorcycle","fa fa-plane","fa fa-rocket","fa fa-ship","fa fa-space-shuttle","fa fa-subway","fa fa-taxi","fa fa-train","fa fa-truck","fa fa-wheelchair","fa fa-wheelchair-alt"]},{"id":"gender","title":"Gender Icons","icons":["fa fa-genderless","fa fa-intersex","fa fa-mars","fa fa-mars-double","fa fa-mars-stroke","fa fa-mars-stroke-h","fa fa-mars-stroke-v","fa fa-mercury","fa fa-neuter","fa fa-transgender","fa fa-transgender-alt","fa fa-venus","fa fa-venus-double","fa fa-venus-mars"]},{"id":"file-type","title":"File Type Icons","icons":["fa fa-file","fa fa-file-archive-o","fa fa-file-audio-o","fa fa-file-code-o","fa fa-file-excel-o","fa fa-file-image-o","fa fa-file-movie-o","fa fa-file-o","fa fa-file-pdf-o","fa fa-file-photo-o","fa fa-file-picture-o","fa fa-file-powerpoint-o","fa fa-file-sound-o","fa fa-file-text","fa fa-file-text-o","fa fa-file-video-o","fa fa-file-word-o","fa fa-file-zip-o"]},{"id":"spinner","title":"Spinner Icons","icons":["fa fa-circle-o-notch","fa fa-cog","fa fa-gear","fa fa-refresh","fa fa-spinner"]},{"id":"form-control","title":"Form Control Icons","icons":["fa fa-check-square","fa fa-check-square-o","fa fa-circle","fa fa-circle-o","fa fa-dot-circle-o","fa fa-minus-square","fa fa-minus-square-o","fa fa-plus-square","fa fa-plus-square-o","fa fa-square","fa fa-square-o"]},{"id":"payment","title":"Payment Icons","icons":["fa fa-cc-amex","fa fa-cc-diners-club","fa fa-cc-discover","fa fa-cc-jcb","fa fa-cc-mastercard","fa fa-cc-paypal","fa fa-cc-stripe","fa fa-cc-visa","fa fa-credit-card","fa fa-credit-card-alt","fa fa-google-wallet","fa fa-paypal"]},{"id":"chart","title":"Chart Icons","icons":["fa fa-area-chart","fa fa-bar-chart","fa fa-bar-chart-o","fa fa-line-chart","fa fa-pie-chart"]},{"id":"currency","title":"Currency Icons","icons":["fa fa-bitcoin","fa fa-btc","fa fa-cny","fa fa-dollar","fa fa-eur","fa fa-euro","fa fa-gbp","fa fa-gg","fa fa-gg-circle","fa fa-ils","fa fa-inr","fa fa-jpy","fa fa-krw","fa fa-money","fa fa-rmb","fa fa-rouble","fa fa-rub","fa fa-ruble","fa fa-rupee","fa fa-shekel","fa fa-sheqel","fa fa-try","fa fa-turkish-lira","fa fa-usd","fa fa-won","fa fa-yen"]},{"id":"text-editor","title":"Text Editor Icons","icons":["fa fa-align-center","fa fa-align-justify","fa fa-align-left","fa fa-align-right","fa fa-bold","fa fa-chain","fa fa-chain-broken","fa fa-clipboard","fa fa-columns","fa fa-copy","fa fa-cut","fa fa-dedent","fa fa-eraser","fa fa-file","fa fa-file-o","fa fa-file-text","fa fa-file-text-o","fa fa-files-o","fa fa-floppy-o","fa fa-font","fa fa-header","fa fa-indent","fa fa-italic","fa fa-link","fa fa-list","fa fa-list-alt","fa fa-list-ol","fa fa-list-ul","fa fa-outdent","fa fa-paperclip","fa fa-paragraph","fa fa-paste","fa fa-repeat","fa fa-rotate-left","fa fa-rotate-right","fa fa-save","fa fa-scissors","fa fa-strikethrough","fa fa-subscript","fa fa-superscript","fa fa-table","fa fa-text-height","fa fa-text-width","fa fa-th","fa fa-th-large","fa fa-th-list","fa fa-underline","fa fa-undo","fa fa-unlink"]},{"id":"directional","title":"Directional Icons","icons":["fa fa-angle-double-down","fa fa-angle-double-left","fa fa-angle-double-right","fa fa-angle-double-up","fa fa-angle-down","fa fa-angle-left","fa fa-angle-right","fa fa-angle-up","fa fa-arrow-circle-down","fa fa-arrow-circle-left","fa fa-arrow-circle-o-down","fa fa-arrow-circle-o-left","fa fa-arrow-circle-o-right","fa fa-arrow-circle-o-up","fa fa-arrow-circle-right","fa fa-arrow-circle-up","fa fa-arrow-down","fa fa-arrow-left","fa fa-arrow-right","fa fa-arrow-up","fa fa-arrows","fa fa-arrows-alt","fa fa-arrows-h","fa fa-arrows-v","fa fa-caret-down","fa fa-caret-left","fa fa-caret-right","fa fa-caret-square-o-down","fa fa-caret-square-o-left","fa fa-caret-square-o-right","fa fa-caret-square-o-up","fa fa-caret-up","fa fa-chevron-circle-down","fa fa-chevron-circle-left","fa fa-chevron-circle-right","fa fa-chevron-circle-up","fa fa-chevron-down","fa fa-chevron-left","fa fa-chevron-right","fa fa-chevron-up","fa fa-exchange","fa fa-hand-o-down","fa fa-hand-o-left","fa fa-hand-o-right","fa fa-hand-o-up","fa fa-long-arrow-down","fa fa-long-arrow-left","fa fa-long-arrow-right","fa fa-long-arrow-up","fa fa-toggle-down","fa fa-toggle-left","fa fa-toggle-right","fa fa-toggle-up"]},{"id":"video-player","title":"Video Player Icons","icons":["fa fa-arrows-alt","fa fa-backward","fa fa-compress","fa fa-eject","fa fa-expand","fa fa-fast-backward","fa fa-fast-forward","fa fa-forward","fa fa-pause","fa fa-pause-circle","fa fa-pause-circle-o","fa fa-play","fa fa-play-circle","fa fa-play-circle-o","fa fa-random","fa fa-step-backward","fa fa-step-forward","fa fa-stop","fa fa-stop-circle","fa fa-stop-circle-o","fa fa-youtube-play"]},{"id":"brand","title":"Brand Icons","icons":["fa fa-500px","fa fa-adn","fa fa-amazon","fa fa-android","fa fa-angellist","fa fa-apple","fa fa-bandcamp","fa fa-behance","fa fa-behance-square","fa fa-bitbucket","fa fa-bitbucket-square","fa fa-bitcoin","fa fa-black-tie","fa fa-bluetooth","fa fa-bluetooth-b","fa fa-btc","fa fa-buysellads","fa fa-cc-amex","fa fa-cc-diners-club","fa fa-cc-discover","fa fa-cc-jcb","fa fa-cc-mastercard","fa fa-cc-paypal","fa fa-cc-stripe","fa fa-cc-visa","fa fa-chrome","fa fa-codepen","fa fa-codiepie","fa fa-connectdevelop","fa fa-contao","fa fa-css3","fa fa-dashcube","fa fa-delicious","fa fa-deviantart","fa fa-digg","fa fa-dribbble","fa fa-dropbox","fa fa-drupal","fa fa-edge","fa fa-eercast","fa fa-empire","fa fa-envira","fa fa-etsy","fa fa-expeditedssl","fa fa-fa","fa fa-facebook","fa fa-facebook-f","fa fa-facebook-official","fa fa-facebook-square","fa fa-firefox","fa fa-first-order","fa fa-flickr","fa fa-font-awesome","fa fa-fonticons","fa fa-fort-awesome","fa fa-forumbee","fa fa-foursquare","fa fa-free-code-camp","fa fa-ge","fa fa-get-pocket","fa fa-gg","fa fa-gg-circle","fa fa-git","fa fa-git-square","fa fa-github","fa fa-github-alt","fa fa-github-square","fa fa-gitlab","fa fa-gittip","fa fa-glide","fa fa-glide-g","fa fa-google","fa fa-google-plus","fa fa-google-plus-circle","fa fa-google-plus-official","fa fa-google-plus-square","fa fa-google-wallet","fa fa-gratipay","fa fa-grav","fa fa-hacker-news","fa fa-houzz","fa fa-html5","fa fa-imdb","fa fa-instagram","fa fa-internet-explorer","fa fa-ioxhost","fa fa-joomla","fa fa-jsfiddle","fa fa-lastfm","fa fa-lastfm-square","fa fa-leanpub","fa fa-linkedin","fa fa-linkedin-square","fa fa-linode","fa fa-linux","fa fa-maxcdn","fa fa-meanpath","fa fa-medium","fa fa-meetup","fa fa-mixcloud","fa fa-modx","fa fa-odnoklassniki","fa fa-odnoklassniki-square","fa fa-opencart","fa fa-openid","fa fa-opera","fa fa-optin-monster","fa fa-pagelines","fa fa-paypal","fa fa-pied-piper","fa fa-pied-piper-alt","fa fa-pied-piper-pp","fa fa-pinterest","fa fa-pinterest-p","fa fa-pinterest-square","fa fa-product-hunt","fa fa-qq","fa fa-quora","fa fa-ra","fa fa-ravelry","fa fa-rebel","fa fa-reddit","fa fa-reddit-alien","fa fa-reddit-square","fa fa-renren","fa fa-resistance","fa fa-safari","fa fa-scribd","fa fa-sellsy","fa fa-share-alt","fa fa-share-alt-square","fa fa-shirtsinbulk","fa fa-simplybuilt","fa fa-skyatlas","fa fa-skype","fa fa-slack","fa fa-slideshare","fa fa-snapchat","fa fa-snapchat-ghost","fa fa-snapchat-square","fa fa-soundcloud","fa fa-spotify","fa fa-stack-exchange","fa fa-stack-overflow","fa fa-steam","fa fa-steam-square","fa fa-stumbleupon","fa fa-stumbleupon-circle","fa fa-superpowers","fa fa-telegram","fa fa-tencent-weibo","fa fa-themeisle","fa fa-trello","fa fa-tripadvisor","fa fa-tumblr","fa fa-tumblr-square","fa fa-twitch","fa fa-twitter","fa fa-twitter-square","fa fa-usb","fa fa-viacoin","fa fa-viadeo","fa fa-viadeo-square","fa fa-vimeo","fa fa-vimeo-square","fa fa-vine","fa fa-vk","fa fa-wechat","fa fa-weibo","fa fa-weixin","fa fa-whatsapp","fa fa-wikipedia-w","fa fa-windows","fa fa-wordpress","fa fa-wpbeginner","fa fa-wpexplorer","fa fa-wpforms","fa fa-xing","fa fa-xing-square","fa fa-y-combinator","fa fa-y-combinator-square","fa fa-yahoo","fa fa-yc","fa fa-yc-square","fa fa-yelp","fa fa-yoast","fa fa-youtube","fa fa-youtube-play","fa fa-youtube-square"]},{"id":"medical","title":"Medical Icons","icons":["fa fa-ambulance","fa fa-h-square","fa fa-heart","fa fa-heart-o","fa fa-heartbeat","fa fa-hospital-o","fa fa-medkit","fa fa-plus-square","fa fa-stethoscope","fa fa-user-md","fa fa-wheelchair","fa fa-wheelchair-alt"]}]')
				),
			));
		}
	}
}