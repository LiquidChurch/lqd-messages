/**
 * Liquid Messages Video
 *
 * @type {*|{}}
 */
window.GCVideoModal = window.GCVideoModal || {};

(function(window, document, $, app, undefined) {
	'use strict';

	app.cache = function() {
		app.$ = {};
		app.$.overlay = $(document.getElementById( 'lqdm-video-overlay' ));
		app.$.body = $(document.body);
		app.$.modals = $( '.lqdm-msgs-modal' );
	};

	app.clickOpenModal = function(evt) {
		evt.preventDefault();
		var sermonId = $(this).data( 'sermonid' );

		app.showVideo(sermonId);
	};

	app.showVideo = function(sermonId) {
		app.$.overlay.fadeIn( 'fast' );

		var $video = app.$.modals
            .filter('#lqdm-sermons-video-'+ sermonId)
            .removeClass('gcinvisible');

		$video
            .find('.lqdm-sermons-video-container')
            .html($video.find('.tmpl-videoModal').html())
            .fitVids();

		$video.css({
            'margin-top' : -Math.floor(parseInt($video.outerHeight() * 0.6)),
        });
	};

	app.closeModals = function() {
		app.$.overlay.fadeOut();
		app.$.modals
            .addClass('gcinvisible')
            .find('.lqdm-sermons-video-container')
            .empty();
	};

	$(app.init);
})(window, document, jQuery, window.GCVideoModal);
