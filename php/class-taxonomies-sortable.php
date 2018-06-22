<?php
/**
 * Plugin base class.
 *
 * @package taxonomies-sortable
 * @author Enrico Sorcinelli
 */

// Check running WordPress instance.
if ( ! defined( 'ABSPATH' ) ) {
	header( 'HTTP/1.1 404 Not Found' );
	exit();
}

/**
 * Class Taxonomies_Sortable.
 */
class Taxonomies_Sortable {

	/**
	 * Plugin constrctor arguments.
	 *
	 * @var array
	 */
	private $settings = array();

	/**
	 * Plugin options.
	 *
	 * @var array
	 */
	private $plugin_options;

	/**
	 * Prefix used for options and postmeta fields, DOM IDs and DB tables.
	 *
	 * @var string
	 */
	private static $prefix = 'taxonomies_sortable_plugin_';

	/**
	 * Singleton instance.
	 *
	 * @var object Instance of this class.
	 */
	public static $instance;

	/**
	 * Plugin class constructor.
	 *
	 * @param array $args {
	 *     Array of arguments for constructor.
	 *
	 *     @type boolean $debug Default `false`.
	 * }
	 *
	 *  @return object
	 */
	public function __construct( $args = array() ) {

		$this->settings = wp_parse_args( $args, array(
			'debug' => false,
		), $args );

		$this->plugin_options = $this->getPluginOptions();

		// Load plugin text domain.
		load_plugin_textdomain( 'taxonomies-sortable', false, dirname( plugin_basename( __FILE__ ) ) . '/../languages/' );

		// Check and load needed components.
		$this->requireComponents();

		// Create plugin admin object.
		if ( is_admin() ) {
			$this->_admin = new \Taxonomies_Sortable\Admin( array(
				'prefix'         => self::$prefix,
				'plugin_options' => $this->plugin_options,
				'debug'          => $this->settings['debug'],
			));
		}

		// Add sort filter for sortable taxonomies.
		add_filter( 'wp_get_object_terms_args', array( $this, 'wpGgetOobjectTermsArgsFilter' ), 10, 3 );

		// Make taxonomies sortable.
		add_filter( 'register_taxonomy_args', array( $this, 'makeTaxonomiesSortable' ), 10, 2 );
	}

	/**
	 * Get the singleton instance of this class.
	 *
	 * @param array $args Constructor arguments.
	 *
	 * @return object
	 */
	public static function get_instance( $args = array() ) {
		if ( ! ( self::$instance instanceof self ) ) {
			self::$instance = new self( $args );
		}
		return self::$instance;
	}

	/**
	 * This function will include core files before the theme's functions.php
	 * file has been excecuted.
	 *
	 * @return void
	 */
	public function requireComponents() {

		// Plugin classes.
		if ( ! class_exists( 'Plugin_Utils' ) ) {
			require_once TAXONOMIES_SORTABLE_PLUGIN_BASEDIR . '/php/class-plugin-utils.php';
		}
		if ( is_admin() ) {
			require_once TAXONOMIES_SORTABLE_PLUGIN_BASEDIR . '/php/class-taxonomies-sortable-admin.php';
		}
	}

	/**
	 * Filter adding sortable arguments when registering taxonomy.
	 *
	 * @param array  $args     Taxonomy registration arguments.
	 * @param string $taxonomy Taxonomy name.
	 *
	 * @return array
	 */
	public function makeTaxonomiesSortable( $args, $taxonomy ) {

		if ( in_array( $taxonomy, $this->plugin_options['taxonomies'], true ) ) {
			$args['sortable'] = true;
		}
		if ( isset( $args['sortable'] ) && true === $args['sortable'] ) {
			$args['sort'] = true;
		}
		else {
			$args['sortable'] = false;
		}

		// In order to force wp_get_object_terms() loop in wp-includes/taxonomy.php:1975.
		$args['args']['_tax'] = $taxonomy;

		return $args;
	}

	/**
	 * Filter applied to set term meta order (see https://core.trac.wordpress.org/ticket/35925).
	 *
	 * @param array   $args       Query arguments.
	 * @param integer $object_ids Object ID.
	 * @param array   $taxonomies Taxonomies.
	 *
	 * @return array
	 */
	public function wpGgetOobjectTermsArgsFilter( $args, $object_ids, $taxonomies ) {

		$t = get_taxonomy( $taxonomies[0] );
		if ( isset( $t->sortable ) && true === $t->sortable ) {
			$args['orderby'] = 'term_order';
		}
		else {
			unset( $args['orderby'] );
		}

		return $args;
	}

	/**
	 * Plugin uninstall hook.
	 * Delete wp_options entries only when plugin deactivated and deleted.
	 *
	 * @return void
	 */
	public static function pluginUninstall() {
		$options = get_option( self::$prefix . 'general_settings', true );
		if ( isset( $options['delete'] ) && $options['delete'] ) {
			delete_option( self::$prefix . 'general_settings' );
		}
	}

	/**
	 * Get plugin options settings.
	 *
	 * @return array
	 */
	private function getPluginOptions() {
		$settings = wp_parse_args(
			get_option( self::$prefix . 'general_settings', array() ),
			array(
				'taxonomies'             => array(),
				'remove_plugin_settings' => false,
			)
		);

		/**
		 * Filter taxonomies to make sortable.
		 *
		 * @param array $taxonomies Taxonomies sortable.
		 *
		 * @return array
		 */
		$settings['taxonomies'] = apply_filters( 'taxonomies_sortable', $settings['taxonomies'] );

		return $settings;
	}
}
