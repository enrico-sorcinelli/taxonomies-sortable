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
 * Author URI:  https://github.com/enrico-sorcinelli/taxonomies-sortable/graphs/contributors
 * Text Domain: taxonomies-sortable
 * Domain Path: /languages/
 * Version:     1.0.1
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
	define( 'TAXONOMIES_SORTABLE_PLUGIN_VERSION', '1.0.1' );
	define( 'TAXONOMIES_SORTABLE_PLUGIN_BASEDIR', dirname( __FILE__ ) );
	define( 'TAXONOMIES_SORTABLE_PLUGIN_BASEURL', plugin_dir_url( __FILE__ ) );

	// Enable debug prints on error_log (only when WP_DEBUG is true).
	if ( ! defined( 'TAXONOMIES_SORTABLE_PLUGIN_DEBUG' ) ) {
		define( 'TAXONOMIES_SORTABLE_PLUGIN_DEBUG', false );
	}

	require_once TAXONOMIES_SORTABLE_PLUGIN_BASEDIR . '/php/class-taxonomies-sortable.php';

	/**
	 * Init the plugin.
	 *
	 * Define TAXONOMIES_SORTABLE_PLUGIN_AUTOENABLE to `false` in your
	 * _wp-config.php_ to disable.
	 *
	 * @return void
	 */
	function taxonomies_sortable_plugin_init() {

		if ( defined( 'TAXONOMIES_SORTABLE_PLUGIN_AUTOENABLE' ) && TAXONOMIES_SORTABLE_PLUGIN_AUTOENABLE === false ) {
			return;
		}

		// Instantiate plugin class and add it to the set of globals.
		$GLOBALS['taxonomies_sortable_plugin'] = Taxonomies_Sortable::get_instance( array( 'debug' => TAXONOMIES_SORTABLE_PLUGIN_DEBUG && WP_DEBUG ) );
	}

	// Activate the plugin once all plugin have been loaded.
	add_action( 'plugins_loaded', 'taxonomies_sortable_plugin_init' );

	// Uninstall hooks.
	register_uninstall_hook( __FILE__, array( 'Taxonomies_Sortable', 'pluginUninstall' ) );
}
