/**
 * Liquid Messages General Admin Functionality
 *
 * Licensed under the GPLv2+ license.
 */

window.LiquidChurchAdmin = window.LiquidChurchAdmin || {};

// We pass in our cmb and plugin objects.
( function( window, document, $, cmb, plugin ) {
	'use strict';

	plugin.cache = function() {
		plugin.$ = {};
	};

	// Initialization Function
	plugin.init = function() {
		plugin.cache();

		// Take action on events...
		$( document.body )
			.on( 'keyup change', '.check-if-recent input[type="text"]', plugin.maybeToggle )
			.on( 'change', '#gc_sermon_video_url', plugin.checkDupVideo )
			.on( 'shortcode_button:open', plugin.showNotRecent );
		$( plugin.expandTaxonomy );

		var media = cmb.media;
		var box = document.getElementById( plugin.id + '_repeat' ); // Look for repeating fields?
		var $group;

		// maybeToggle Function
		plugin.maybeToggle = function( evt ){
			var $this = $(evt.target);
			var value = $this.val();
			if (!value || '0' === value || 0 === value || 'recent' === value ) {
				$this.parents( '.cmb2-metabox').find( '.hide-if-not-recent').show();
			} else {
				$this.parents( '.cmb2-metabox' ).find( '.hide-if-not-recent' ).hide();
			}
		};

		plugin.showNotRecent = function() {
			$( '.scb-form-wrap .hide-if-not-recent' ).show();
		};

		// Select File
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

		// Setup Type Listener
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

		// Click Button
		plugin.clickButton = function() {
			if ( $.contains( box, this ) ) {
				plugin.setupTypeListener( $( this ).closest( '.cmb-td' ) );
			}
		};

		// Metabox
		cmb.metabox().on( 'click', '.cmb2-upload-button', plugin.clickButton );
	};

	$( plugin.init );
}( window, document, jQuery, window.CMB2, window.LiquidChurchAdmin ) );
