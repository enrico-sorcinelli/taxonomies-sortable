<?php
/**
 * Credit template part.
 *
 * @package taxonomies-sortable
 */

?>
			<div id="postbox-container-1" class="postbox-container">
				<div class="postbox" id="taxonomies-sortable-credits">
					<h3 class="hndle"><?php /* translators: */ echo esc_html( sprintf( __( 'Taxonomies Sortable %s', 'taxonomies-sortable' ), TAXONOMIES_SORTABLE_PLUGIN_VERSION ) ); ?></h3>
					<div class="inside">
						<h4><?php esc_html_e( 'Changelog', 'taxonomies-sortable' ); ?></h4>
						<p>
							<?php esc_html_e( 'What\'s new in', 'taxonomies-sortable' ); ?>
							<a href="https://github.com/enrico-sorcinelli/taxonomies-sortable/releases"><?php /* translators: */ echo esc_html( sprintf( __( 'version %s', 'taxonomies-sortable' ), TAXONOMIES_SORTABLE_PLUGIN_VERSION ) ); ?></a>.
						</p>
						<h4><?php esc_html_e( 'Support', 'taxonomies-sortable' ); ?></h4>
						<p>
							<span class="dashicons dashicons-email-alt"></span>
							<a href="https://github.com/enrico-sorcinelli/taxonomies-sortable/issues"><?php esc_html_e( 'Support/issues', 'taxonomies-sortable' ); ?></a>.
						</p>
						<div class="author">
							<i><span><?php esc_html_e( 'Taxonomies Sortable', 'taxonomies-sortable' ); ?> <?php esc_html_e( 'by', 'taxonomies-sortable' ); ?> Enrico Sorcinelli</span><br>
							&copy; <?php echo esc_html( date( __( 'Y', 'taxonomies-sortable' ) ) ); ?></i>
						</div>
					</div>
				</div>
			</div>
