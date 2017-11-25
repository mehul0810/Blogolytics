<?php
/**
 * Create Settings for Blogolytics using API
 *
 * @since 1.0.0
 */
if ( ! class_exists('Blogolytics_Admin_Settings' ) ):

	class Blogolytics_Admin_Settings {

		/**
		 * Blogolytics Settings variable.
		 *
		 * @since  1.0.0
		 * @access private
		 *
		 * @var $blogolytics_settings
		 */
		private $blogolytics_settings;

		/**
		 * Blogolytics_Admin_Settings constructor.
		 *
		 * @since 1.0.0
		 */
		function __construct() {
			$this->blogolytics_settings = new Blogolytics_Admin_Settings_API;

			add_action( 'admin_init', array( $this, 'admin_init' ) );
			add_action( 'admin_menu', array( $this, 'admin_menu' ) );
		}

		function admin_init() {

			// Set Sections and Fields.
			$this->blogolytics_settings->set_sections( $this->get_settings_sections() );
			$this->blogolytics_settings->set_fields( $this->get_settings_fields() );

			// Initialize Settings.
			$this->blogolytics_settings->admin_init();
		}

		function admin_menu() {
			add_options_page( __( 'Blogolytics', 'blogolytics' ), __( 'Blogolytics', 'blogolytics' ), 'delete_posts', 'blogolytics_settings', array( $this, 'blogolytics_settings_page') );
		}

		function get_settings_sections() {
			$sections = array(
				array(
					'id'    => 'blogolytics_connection',
					'title' => __( 'Connection', 'blogolytics' ),
					'desc'  => __( 'Establish Connection between your website and Google Analytics.', 'blogolytics' ),
				),
				array(
					'id'    => 'blogolytics_tracking',
					'title' => __( 'Tracking', 'blogolytics' ),
					'desc'  => __( 'Track Additional Events from the list.', 'blogolytics' ),
				),

			);

			// Display Scroll Depth Settings, only if it is enabled!
			if( 'on' === blogolytics_get_option( 'tracking', 'scroll_depth' ) ) {
				$sections[] = array(
					'id'    => 'blogolytics_scroll_depth',
					'title' => __( 'Scroll Depth', 'blogolytics' ),
					'desc'  => __( 'Play around with Scroll Depth Settings as per your need.', 'blogolytics' ),
				);
			}

			// Display Active Time Settings, only if it is enabled!
			if( 'on' === blogolytics_get_option( 'tracking', 'active_time' ) ) {
				$sections[] = array(
					'id'    => 'blogolytics_active_time',
					'title' => __( 'Active Time', 'blogolytics' ),
					'desc'  => __( 'Play around with Active Time Settings as per your need.', 'blogolytics' ),
				);
			}

			// Display Screen Time Settings, only if it is enabled!
			if( 'on' === blogolytics_get_option( 'tracking', 'screen_time' ) ) {
				$sections[] = array(
					'id'    => 'blogolytics_screen_time',
					'title' => __( 'Screen Time', 'blogolytics' ),
					'desc'  => __( 'Play around with Screen Time Settings as per your need.', 'blogolytics' ),
				);
			}

			return $sections;
		}

		/**
		 * Returns all the settings fields
		 *
		 * @return array settings fields
		 */
		function get_settings_fields() {
			$settings_fields = array(
				'blogolytics_connection' => array(
					array(
						'name'              => 'tracking_code',
						'label'             => __( 'Tracking Code', 'blogolytics' ),
						'desc'              => __( 'Place your unique Google Analytics Tracking code. <a href="" target="_blank">How to generate Google Analytics Tracking Code.</a>', 'blogolytics' ),
						'placeholder'       => __( 'E.G: UA-xxxxxxxx-n', 'blogolytics' ),
						'type'              => 'text',
						'default'           => '',
						'sanitize_callback' => 'sanitize_text_field'
					),
				),
				'blogolytics_tracking' => array(
					array(
						'name'              => 'scroll_depth',
						'label'             => __( 'Scroll Depth', 'blogolytics' ),
						'desc'              => __( 'Enable this option to track scroll depth of a page. <a href="" target="_blank">Why you should track Scroll Depth?</a>', 'blogolytics' ),
						'placeholder'       => '',
						'type'              => 'checkbox',
						'default'           => '',
						'sanitize_callback' => ''
					),
					array(
						'name'              => 'active_time',
						'label'             => __( 'Active Time', 'blogolytics' ),
						'desc'              => __( 'Enable this option to measure active time on a page. <a href="" target="_blank">Why you should measure active time?</a>', 'blogolytics' ),
						'placeholder'       => '',
						'type'              => 'checkbox',
						'default'           => '',
						'sanitize_callback' => ''
					),
					array(
						'name'              => 'screen_time',
						'label'             => __( 'Screen Time', 'blogolytics' ),
						'desc'              => __( 'Enable this option to track which portion of the page is viewed maximum time. <a href="" target="_blank">What is Screen Time and Why you should measure it?</a>', 'blogolytics' ),
						'placeholder'       => '',
						'type'              => 'checkbox',
						'default'           => '',
						'sanitize_callback' => ''
					),
				),
			);

			return $settings_fields;
		}

		/**
		 * Blogolytics Setting Page.
		 *
		 * @since 1.0.0
		 */
		function blogolytics_settings_page() {
			echo '<div class="wrap">';
			echo '<h2>' . __( 'Blogolytics Settings', 'blogolytics' ) . '</h2>';
			$this->blogolytics_settings->show_navigation();
			$this->blogolytics_settings->show_forms();

			echo '</div>';
		}

		/**
		 * Get all the pages
		 *
		 * @return array page names with key value pairs
		 */
		function get_pages() {
			$pages = get_pages();
			$pages_options = array();
			if ( $pages ) {
				foreach ($pages as $page) {
					$pages_options[$page->ID] = $page->post_title;
				}
			}

			return $pages_options;
		}

	}
endif;
new Blogolytics_Admin_Settings();