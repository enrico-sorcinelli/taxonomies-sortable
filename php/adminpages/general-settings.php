<?php
/**
 * Plugin settings option page template.
 *
 * @package taxonomies-sortable
 */

// Get the registered taxonomies.
$registered_taxonomies = get_taxonomies( '', 'objects' );
?>
<div class="wrap">
<h1><?php esc_html_e( 'Taxonomies Sortable settings', 'taxonomies-sortable' ); ?></h1>

	<div id="poststuff">
		<div id="post-body" class="metabox-holder columns-2">

			<div id="postbox-container-2" class="postbox-container">
<form method="post" action="options.php">

<?php settings_fields( $params['prefix'] . 'general-settings' ); ?>
<?php do_settings_sections( $params['prefix'] . 'general-settings' ); ?>

	<h2 class="nav-tab-wrapper wp-clearfix taxonomies-sortable">
		<a class="nav-tab taxonomies-sortable nav-tab-active"><?php esc_html_e( 'Taxonomies', 'taxonomies-sortable' ); ?></a>
		<a class="nav-tab taxonomies-sortable"><?php esc_html_e( 'Options', 'taxonomies-sortable' ); ?></a>
	</h2>

<section class="taxonomies-sortable">
	<table class="form-table">
		<tr>
			<th scope="row"><?php esc_html_e( 'Taxonomies sortable', 'taxonomies-sortable' ); ?></th>
			<td>
				<fieldset id="sortable-taxonomies-fieldset">
<?php
if ( ! empty( $registered_taxonomies ) ) {
	foreach ( (array) $registered_taxonomies as $tax ) {

		// Skip hierarchical and builtin (except of post_tag).
		if ( $tax->hierarchical || ( $tax->_builtin && 'post_tag' !== $tax->name ) ) {
			continue;
		}
?>
					<label for="<?php echo esc_attr( $params['prefix'] . $tax->name ); ?>">
						<input class="taxonomies-sortable" id="<?php echo esc_attr( $params['prefix'] . $tax->name ); ?>" type="checkbox" name="<?php echo esc_attr( $params['prefix'] ); ?>general_settings[taxonomies][]" value="<?php echo esc_attr( $tax->name ); ?>" <?php checked( 1, ! empty( $params['settings']['taxonomies'] ) && in_array( $tax->name, $params['settings']['taxonomies'], true ), true ); ?> />
						<?php echo esc_html( $tax->labels->name ); ?>
					</label>
				<br>
<?php
	}
}
?>
				</fieldset>
				<p class="description"><?php esc_html_e( 'Select non-hierarchical taxonomies to make sortable.', 'taxonomies-sortable' ); ?></p>
			</td>
		<tr>
	</table>
</section>

<section class="taxonomies-sortable">
	<table class="form-table">
		<tr>
			<th scope="row"><?php esc_html_e( 'Plugin settings', 'taxonomies-sortable' ); ?></th>
			<td>
				<p>
					<input name="<?php echo esc_attr( $params['prefix'] . 'general_settings[remove_plugin_settings]' ); ?>" type="checkbox" id="<?php echo esc_attr( $params['prefix'] . 'general_settings_remove_plugin_settings' ); ?>" value="1" <?php checked( 1, empty( $params['settings']['remove_plugin_settings'] ) ? 0 : 1, true ); ?>>
					<label for="<?php echo esc_attr( $params['prefix'] . 'general_settings_remove_plugin_settings' ); ?>"><?php esc_html_e( 'Completely remove options on plugin removal.', 'taxonomies-sortable' ); ?></label>
				</p>
			</td>
		<tr>
	</table>
</section>

<?php submit_button(); ?>
</form>
			</div>
<?php \Plugin_Utils::includeTemplate( TAXONOMIES_SORTABLE_PLUGIN_BASEDIR . '/php/adminpages/credits.php', array( 'prefix' => $params['prefix'] ) ); ?>
		</div><!-- /#post-body -->
	</div><!-- /#poststuff -->
</div><!--/.wrap-->
