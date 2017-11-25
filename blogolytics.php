<?php
/**
 * Plugin Name: Blogolytics
 * Plugin URI: https://www.mehulgohil.in/blogolytics/
 * Description: The most robust, flexible, and light-weight Google Analytics plugin to track the pageviews and required events of visitors.
 * Author: Mehul Gohil
 * Author URI: https://www.mehulgohil.in/
 * Version: 1.0.0
 * Text Domain: blogolytics
 * Domain Path: /languages
 * GitHub Plugin URI: https://github.com/mehul0810/Blogolytics
 *
 * Blogolytics is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * any later version.
 *
 * Blogolytics is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Blogolytics. If not, see <https://www.gnu.org/licenses/>.
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Blogolytics' ) ) :

	/**
	 * Main class of Blogolytics.
	 *
	 * @since 1.0.0
	 */
	final class Blogolytics {

		/**
		 * Create an Instance
		 *
		 * @since  1.0.0
		 * @access protected
		 */
		protected static $_instance;

		/**
		 * Main Instance
		 *
		 * @since  1.0.0
		 * @access public
		 *
		 * @return Instance of Blogolytics
		 */
		public static function instance() {
			if ( is_null( self::$_instance ) ) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}

		/**
		 * Create a Constructor.
		 *
		 * @since 1.0.0
		 */
		public function __construct() {
			$this->define_constants();
			$this->includes();
			$this->initialize_hooks();

		}

		/**
		 * Hook into actions and filters.
		 *
		 * @since  1.0.0
		 */
		private function initialize_hooks() {
			add_action( 'plugins_loaded', array( $this, 'initialize_core' ), 0 );
		}
		/**
		 * Initialize Core
		 *
		 * @since 1.0.0
		 */
		public function initialize_core() {

			// Set up localization.
			$this->load_textdomain();

		}

		/**
		 * Throw error on object clone
		 *
		 * @since  1.0.0
		 * @access public
		 *
		 * @return void
		 */
		public function __clone() {
			// Cloning instances of the class is forbidden.
			_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'blogolytics' ), '1.0' );
		}

		/**
		 * Disable unserializing of the class
		 *
		 * @since  1.0.0
		 * @access public
		 *
		 * @return void
		 */
		public function __wakeup() {
			// Unserializing instances of the class is forbidden.
			_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'blogolytics' ), '1.0' );
		}

		/**
		 * Setup plugin constants
		 *
		 * @since  1.0.0
		 * @access private
		 *
		 * @return void
		 */
		private function define_constants() {

			// Plugin version.
			if ( ! defined( 'BLOGOLYTICS_VERSION' ) ) {
				define( 'BLOGOLYTICS_VERSION', '1.0.0' );
			}

			// Plugin Folder Path.
			if ( ! defined( 'BLOGOLYTICS_PLUGIN_DIR' ) ) {
				define( 'BLOGOLYTICS_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
			}

			// Plugin Folder URL.
			if ( ! defined( 'BLOGOLYTICS_PLUGIN_URL' ) ) {
				define( 'BLOGOLYTICS_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
			}

			// Plugin Root File.
			if ( ! defined( 'BLOGOLYTICS_PLUGIN_FILE' ) ) {
				define( 'BLOGOLYTICS_PLUGIN_FILE', __FILE__ );
			}

			// Minimum PHP version required.
			if ( ! defined( 'BLOGOLYTICS_REQUIRED_PHP_VERSION' ) ) {
				define( 'BLOGOLYTICS_REQUIRED_PHP_VERSION', '5.3' );
			}
		}

		/**
		 * Include required files
		 *
		 * @since  1.0.0
		 * @access private
		 *
		 * @return void
		 */
		private function includes() {

			require_once BLOGOLYTICS_PLUGIN_DIR . 'includes/scripts.php';
			require_once BLOGOLYTICS_PLUGIN_DIR . 'includes/functions.php';

			if( is_admin() ) {
				require_once BLOGOLYTICS_PLUGIN_DIR . 'admin/class-admin-settings.php';
				require_once BLOGOLYTICS_PLUGIN_DIR . 'admin/admin-settings.php';
			}

		}

		/**
		 * Loads the plugin language files.
		 *
		 * @since  1.0.0
		 * @access public
		 *
		 * @return void
		 */
		public function load_textdomain() {

			// Set filter for languages directory
			$mgsga_lang_dir = dirname( plugin_basename( MGSGA_PLUGIN_FILE ) ) . '/languages/';
			$mgsga_lang_dir = apply_filters( 'blogolytics_languages_directory', $mgsga_lang_dir );

			// Traditional WordPress plugin locale filter.
			$locale = is_admin() && function_exists( 'get_user_locale' ) ? get_user_locale() : get_locale();
			$locale = apply_filters( 'plugin_locale', $locale, 'blogolytics' );

			unload_textdomain( 'blogolytics' );
			load_textdomain( 'blogolytics', WP_LANG_DIR . '/blogolytics/blogolytics-' . $locale . '.mo' );
			load_plugin_textdomain( 'blogolytics', false, $mgsga_lang_dir );

		}

	}

endif;


/**
 * Power up Blogolytics instance.
 *
 * @since  1.0.0
 * @return object
 */
function Blogolytics() {
	return Blogolytics::instance();
}

// Call the Blogolytics function to initialize plugin.
Blogolytics();