<?php
/**
 * Plugin administration class.
 *
 * @package taxonomies-sortable
 * @author Enrico Sorcinelli
 */

namespace Taxonomies_Sortable;

// Check running WordPress instance.
if ( ! defined( 'ABSPATH' ) ) {
	header( 'HTTP/1.1 404 Not Found' );
	exit();
}
/**
 * Admin interface class.
 *
 * @package taxonomies-sortable
 * @author Enrico Sorcinelli
 */
class Admin {

	/**
	 * Admin pages name.
	 *
	 * @var array
	 */
	private $admin_pages = array();

	/**
	 * Prefix.
	 *
	 * @var string
	 */
	private $prefix;

	/**
	 * Plugin options.
	 *
	 * @var array
	 */
	private $plugin_options;

	/**
	 * Construct the plugin.
	 *
	 * @param array $args {
	 *     Array of arguments for constructor.
	 *
	 *     @type string  $prefix
	 *     @type boolean $debug  Default `false`.
	 * }
	 *
	 * @return object
	 */
	public function __construct( $args = array() ) {

		// Set object property.
		$this->debug = isset( $args['debug'] ) ? $args['debug'] : false;
		foreach ( array( 'prefix', 'plugin_options' ) as $property ) {
			$this->$property = $args[ $property ];
		}

		// This plugin only runs in admin, but we need it initialized on init.
		add_action( 'init', array( $this, 'init' ) );
	}

	/**
	 * Initialize the plugin: setup menu, settings, add filters, actions,
	 * scripts, styles and so on.
	 *
	 * @return void
	 */
	public function init() {

		if ( ! is_admin() ) {
			return;
		}

		// Menu settings.
		add_action( 'admin_menu', array( $this, 'setupMenu' ), '10' );

		// Forms settings.
		add_action( 'admin_init', array( $this, 'setupSettings' ), '10' );
	}

	/**
	 * Setup admin menu.
	 *
	 * @return void
	 */
	public function setupMenu() {

		$admin_menu_capability = is_super_admin() ? 'manage_options' : 'taxonomies_sortable_plugin_manage_options';

		/**
		 * Filter to allow display plugin settings page.
		 *
		 * @param boolean $display_setting_page Default `true`.
		 *
		 * @return boolean
		 */
		if ( apply_filters( 'taxonomies_sortable_admin_settings', true ) ) {
			$this->admin_pages['general_settings'] = add_options_page( __( 'Taxonomies Sortable settings', 'taxonomies-sortable' ), __( 'Taxonomies Sortable', 'taxonomies-sortable' ), 'manage_options', $this->prefix . 'general_settings', array( $this, 'pageGeneralSettings' ) );
		}
	}

	/**
	 * Setup admin (register settings, enqueue ie JavaScript, CSS, add filters &
	 * actions, ...).
	 *
	 * @return void
	 */
	public function setupSettings() {

		global $wp_version;

		// Enqueue JS/CSS only for non AJAX requests.
		if ( ! \Plugin_Utils::isAjaxRequest() ) {

			// Screens where to enqueue assets.
			$admin_pages = array_merge( array( 'post.php', 'post-new.php' ), array_values( $this->admin_pages ) );

			// Add CSS to post pages.
			foreach ( $admin_pages as $page ) {
				add_action( 'admin_print_styles-' . $page, array( $this, 'loadCSS' ), 10, 0 );
				add_action( 'admin_print_scripts-' . $page, array( $this, 'loadJavaScript' ), 10, 0 );
			}
		}

		// Register settings.
		register_setting( $this->prefix . 'general-settings', $this->prefix . 'general_settings', array( $this, 'checkGeneralSettings' ) );
	}

	/**
	 * Check general settings.
	 *
	 * @param mixed $settings Settings values.
	 *
	 * @return array
	 */
	public function checkGeneralSettings( $settings ) {

		return $settings;
	}

	/**
	 * Load CSS files.
	 *
	 * @return void
	 */
	public function loadCSS() {

		global $post_type;

		wp_enqueue_style(
			$this->prefix . 'css',
			TAXONOMIES_SORTABLE_PLUGIN_BASEURL . 'assets/css/admin.css',
			array()
		);
	}

	/**
	 * Load JavaScript files.
	 *
	 * @return void
	 */
	public function loadJavaScript() {

		global $post_type;

		wp_enqueue_script(
			$this->prefix . 'js',
			TAXONOMIES_SORTABLE_PLUGIN_BASEURL . 'assets/js/admin.js',
			array(),
			TAXONOMIES_SORTABLE_PLUGIN_VERSION,
			false
		);

		// Get sortable taxonomies for current post type.
		$tax_objs = get_object_taxonomies( $post_type, 'objects' );

		$sortable_taxonomies = array();
		foreach ( $tax_objs as $taxonomy ) {
			if ( ! $taxonomy->hierarchical && isset( $taxonomy->sortable ) && $taxonomy->sortable ) {
				$sortable_taxonomies[] = '#' . $taxonomy->name . '.tagsdiv';
			}
		}

		// Localization.
		wp_localize_script( $this->prefix . 'js', $this->prefix . 'i18n', array(
			'_plugin_url' => TAXONOMIES_SORTABLE_PLUGIN_BASEURL,
			'msgs'        => array(),
			'taxonomies'  => $sortable_taxonomies,
		) );
	}

	/**
	 * General settings admin page callback.
	 *
	 * @return void
	 */
	public function pageGeneralSettings() {

		\Plugin_Utils::includeTemplate( TAXONOMIES_SORTABLE_PLUGIN_BASEDIR . '/php/adminpages/general-settings.php', array(
			'prefix'   => $this->prefix,
			'settings' => $this->plugin_options,
		) );
	}
}
