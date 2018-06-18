<?php
/**
 * Plugin Taxonomies Sortable
 *
 * @package taxonomies-sortable
 */

/**
 * Plugin Name: Taxonomies Sortable
 * Plugin URI:  https://github.com/enrico-sorcinelli/taxonomies-sortable
 * Description: A WordPress Taxonomies Sortable
 * Author:      Enrico Sorcinelli
 * Author URI:  https://github.com/enrico-sorcinelli/taxonomies-sortable
 * Text Domain: taxonomies-sortable
 * Domain Path: /languages/
 * Version:     0.0.1
 * License:     GPLv2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */

// Check running WordPress instance.
if ( ! defined( 'ABSPATH' ) ) {
	header( 'HTTP/1.1 404 Not Found' );
	exit();
}

if ( ! class_exists( 'Taxonomies_Sortable' ) ) {

	// Plugins constants.
	define( 'TAXONOMIES_SORTABLES_PLUGIN_VERSION', '0.0.1' );
	define( 'TAXONOMIES_SORTABLES_PLUGIN_DBVERSION', '2017080401' );
	define( 'TAXONOMIES_SORTABLES_PLUGIN_BASEDIR', dirname( __FILE__ ) );
	define( 'TAXONOMIES_SORTABLES_PLUGIN_BASEURL', plugin_dir_url( __FILE__ ) );

	// Enable debug prints on error_log (only when WP_DEBUG is true).
	if ( ! defined( 'TAXONOMIES_SORTABLES_PLUGIN_DEBUG' ) ) {
		define( 'TAXONOMIES_SORTABLES_PLUGIN_DEBUG', false );
	}

	require_once TAXONOMIES_SORTABLES_PLUGIN_BASEDIR . '/php/class-taxonomies-sortable.php';

	/**
	 * Init the plugin.
	 *
	 * Define TAXONOMIES_SORTABLES_PLUGIN_DEBUG to false in your <i>wp-config.php</i> to disable
	 *
	 * @return void
	 */
	function taxonomies_sortables_plugin_init() {

		if ( defined( 'TAXONOMIES_SORTABLES_PLUGIN_AUTOENABLE' ) && TAXONOMIES_SORTABLES_PLUGIN_AUTOENABLE === false ) {
			return;
		}

		// Instantiate plugin class and add it to the set of globals.
		$GLOBALS['taxonomies_sortable_plugin'] = Taxonomies_Sortable::get_instance( array( 'debug' => TAXONOMIES_SORTABLES_PLUGIN_DEBUG && WP_DEBUG ) );
	}

	// Activate the plugin once all plugin have been loaded.
	add_action( 'plugins_loaded', 'taxonomies_sortables_plugin_init' );

	// Activation/Deactivation/Uninstall hooks.
	register_activation_hook( __FILE__, array( 'Taxonomies_Sortable', 'pluginActivation' ) );
	register_deactivation_hook( __FILE__, array( 'Taxonomies_Sortable', 'pluginDeactivation' ) );
	register_uninstall_hook( __FILE__, array( 'Taxonomies_Sortable', 'pluginUninstall' ) );
}
