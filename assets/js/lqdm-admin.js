/**
 * Liquid Messages Admin Functionality
 */

window.LiquidChurchAdmin = window.LiquidChurchAdmin || {};

( function( window, document, $, cmb, plugin ) {

	plugin.init = function() {
		var media = cmb.media;
		var box = document.getElementById( plugin.id + '_repeat' );
		var $group;

		plugin.selectFile = function() {
			var selection = media.frames[ media.field ].state().get( 'selection' );
			var attachment = selection.first().toJSON();
			var ext = attachment.filename ? attachment.filename.split( '.' ).pop() : 'unknown';
			var type = attachment.type || ext;

			if ( 'application' === type ) {
				switch ( ext ) {
					case 'pdf':
					case 'zip':
						type = ext;
						break;
					default:
				}
			}

			$group.find( '.cmb-type-text' ).last().find( '.regular-text' ).val( type );
		};

		plugin.setupTypeListener = function( $row ) {
			var frameID = $row.find( '.cmb2-upload-file' ).attr( 'id' );

			$group = $row.closest( '.cmb-nested.cmb-field-list' );

			setTimeout( function() {
				var frame = media.frames[ frameID ];

				if ( frame && ! frame.setResourceType ) {
					frame.setResourceType = true;
					frame.on( 'select', plugin.selectFile );
				}
			}, 500 );
		};

		plugin.clickButton = function() {
			if ( $.contains( box, this ) ) {
				plugin.setupTypeListener( $( this ).closest( '.cmb-td' ) );
			}
		};

		cmb.metabox().on( 'click', '.cmb2-upload-button', plugin.clickButton );
	};

	$( plugin.init );
}( window, document, jQuery, window.CMB2, window.LiquidChurchAdmin ) );
