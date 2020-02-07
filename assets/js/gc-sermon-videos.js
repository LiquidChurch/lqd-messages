window.LqdMVideoModal = window.LqdMVideoModal || {};

/**
 * @todo Play video when opening
 * @todo Test with local video
 * @todo Add a close icon
 */
( function( window, document, $, app, undefined ) {
	'use strict';

	app.cache = function() {
		app.$ = {};
		app.$.overlay = $( document.getElementById( 'lqdm-video-overlay' ) );
		app.$.body = $( document.body );
		app.$.modals = $( '.lqdm-modal' );
	};

	app.init = function() {
		app.cache();
		if ( 'function' === typeof $.fn.prettyPhoto ) {
			$( '.lqdm-play-button' ).prettyPhoto({
				default_width  : 1100,
				default_height : 619,
				theme          : 'dark_square',
			});

			return;
		}

		$( document ).on( 'keydown', function( evt ) {
			var escapeKey = 27;
			if ( escapeKey === evt.keyCode ) {
				evt.preventDefault();
				app.closeModals();
			}
		} );

		app.$.body
			.on( 'click', '.lqdm-play-button', app.clickOpenModal )
			.on( 'click', '#lqdm-video-overlay', app.closeModals );
	};

	app.clickOpenModal = function( evt ) {
		evt.preventDefault();
		var sermonId = $( this ).data( 'sermonid' );

		app.showVideo( sermonId );
	};

	app.showVideo = function( sermonId ) {
		app.$.overlay.fadeIn( 'fast' );

		var $video = app.$.modals.filter( '#lqdm-video-'+ sermonId ).removeClass( 'lqdm-invisible' );

		$video.find( '.lqdm-video-container' ).html( $video.find( '.tmpl-videoModal' ).html() ).fitVids();

		$video.css({ 'margin-top' : - Math.floor( parseInt( $video.outerHeight() * 0.6 ) ) });
	};

	app.closeModals = function() {
		app.$.overlay.fadeOut();
		app.$.modals.addClass( 'lqdm-invisible' ).find( '.lqdm-video-container' ).empty();
	};

	$( app.init );

} )( window, document, jQuery, window.LqdMVideoModal );
