<?php
/**
 * Class Plugin_Utils
 *
 * @package taxonomies-sortable
 * @author Enrico Sorcinelli
 */
class Plugin_Utils {

	/**
	 * Check for AJAX request.
	 *
	 * @return boolean
	 */
	public static function isAjaxRequest() {

		if (
			( ! empty( $_SERVER['HTTP_X_REQUESTED_WITH'] ) && strtolower( $_SERVER['HTTP_X_REQUESTED_WITH'] ) === 'xmlhttprequest' )
			|| ( defined( 'DOING_AJAX' ) && DOING_AJAX )
		) {
				return true;
		}

		return false;
	}

	/**
	 * Call a template. Return also value returned from `include`.
	 *
	 * @param string|array $template Path of file to include (include_path),
	 *                               function or class method.
	 * @param array|null   $params   Associative array that you could use
	 *                               inside template. Use `$params{key}` in the
	 *                               template to refer to the specific `key`.
	 *
	 * @return mixed
	 */
	public static function includeTemplate( $template, $params = array() ) {

		// WP globals.
		global $wp_query, $wp_style, $wp_registered_sidebars, $sidebars_widgets, $wp_registered_widgets, $posts, $post, $wp_did_header, $wp_rewrite, $wpdb, $wp_version, $wp, $id, $comment, $user_ID;

		// Check for a callable template (function/class method).
		if ( is_callable( $template ) ) {
			return call_user_func( $template, $params );
		}

		// Consider template a file.
		return include( $template );
	}

	/**
	 * Call a template by buffering output (like `sprintf`).
	 *
	 * @param string $template Path of file to include (include_path).
	 * @param array  $params   Hash array that you could use inside template.
	 *                         Use `$params{key}` in access to refer to the
	 *                         specific `key`.
	 *
	 * @return mixed Return all standard output generated by template or the
	 *               value returned by template if it doesn't return a scalar
	 *               (i.e an object).
	 */
	public function sincludeTemplate( $template, $params = array() ) {

		// WP globals.
		global $wp_query, $wp_style, $wp_registered_sidebars, $sidebars_widgets, $wp_registered_widgets, $posts, $post, $wp_did_header, $wp_rewrite, $wpdb, $wp_version, $wp, $id, $comment, $user_ID;

		ob_start();

		// Check for a callable template (function/class method).
		if ( is_callable( $template ) ) {
			$ret = call_user_func( $template, $params );
		}
		else {
			$ret = include( $template );
		}

		$stdout = ob_get_clean();

		// Include fails.
		if ( false === $ret ) {
			return $ret;
		}

		// Checks return type.
		return ( is_scalar( $ret ) || null === $ret ) ? $stdout : $ret;
	}

	/**
	 * Returns true if `$regex` is a valid regular expression pattern.
	 *
	 * @param mixed $regex Regex to be tested.
	 *
	 * @return boolean
	 */
	public static function isRegex( $regex = null ) {

		// Pattern is broken.
		if ( @preg_match( $regex, null ) === false ) {
			return false;
		}

		// Pattern is valid.
		return true;
	}

}
