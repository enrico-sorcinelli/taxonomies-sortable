/**
 * @file This file contains Taxonomies Sortable JavaScript
 * @author Enrico Sorcinelli
 * @version 1.0.1
 * @title Taxonomies Sortable
 */

// Make all in a closure.
;( function ( $ ) {

	$( document ).ready( function() {

		// Post screen.
		var tagDelimiter = ( window.tagsSuggestL10n && window.tagsSuggestL10n.tagDelimiter ) || ',';

		// Add sortable UI.
		if ( 'object' === typeof( taxonomies_sortable_plugin_i18n.taxonomies ) ) {
			$( taxonomies_sortable_plugin_i18n.taxonomies.join( ',' ) ).each( function() {
				var $wrapper = $( this ).find( '.tagchecklist' ),
					$the_tags = $( this ).find( '.the-tags' );
				$wrapper.sortable( {
					items: '>li',
					stop: function ( event, ui ) {
						var new_tags = [];
						$( 'li', $wrapper ).each( function( i ) {
							var $button = $( 'button.ntdelbutton', this );
							$button.attr( 'id', $button.attr( 'id' ).replace( /\d+$/, i ) );
							new_tags.push( $( $( this ).contents()[2] ).text() );
						} );
						$the_tags.val( array_unique_noempty( new_tags ).join( tagDelimiter ) );
					}
				} );
			} );
		}

		// Tab managements.
		$( document ).ready( function() {
			$( '.nav-tab-wrapper.taxonomies-sortable a' ).on( 'click', function () {
				$( '.nav-tab.taxonomies-sortable' ).removeClass( 'nav-tab-active' );
				$( this ).addClass( 'nav-tab-active' );
				$( 'section.taxonomies-sortable' ).hide();
				$( 'section.taxonomies-sortable' ).eq( $( this ).index() ).show();
				return false;
			});
		})

	})

} )( jQuery );
