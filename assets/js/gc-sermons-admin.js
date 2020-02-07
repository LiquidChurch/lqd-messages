window.LqdMAdmin = window.LqdMAdmin || {};

( function( window, document, $, app, undefined ) {
	'use strict';

	app.cache = function() {
		app.$ = {};
	};

	// Initialization Function
	app.init = function() {
		app.cache();

		// Take action on events...
		$( document.body )
			.on( 'keyup change', '.check-if-recent input[type="text"]', app.maybeToggle )
			.on( 'change', '#lqdm_sermon_video_url', app.checkDupVideo )
			.on( 'shortcode_button:open', app.showNotRecent );
		$( app.expandTaxonomy );
	};

	// maybeToggle Function
	app.maybeToggle = function( evt ) {
		var $this = $( evt.target );
		var value = $this.val();
		if ( ! value || '0' === value || 0 === value || 'recent' === value ) {
			$this.parents( '.cmb2-metabox' ).find( '.hide-if-not-recent' ).show();
		} else {
			$this.parents( '.cmb2-metabox' ).find( '.hide-if-not-recent' ).hide();
		}
	};

	app.showNotRecent = function() {
		$( '.scb-form-wrap .hide-if-not-recent' ).show();
	};

	app.expandTaxonomy = function(){
		var expandTaxonomy = ['lqdm-series', 'lqdm-speaker', 'lqdm-tag'];
		var expandElem = [];
		$.each(expandTaxonomy, function(i, item) {
			expandElem.push('#link-' + item);
		});
		var temp = expandElem.join(',');
		$(temp).trigger('click');
	};

	app.checkDupVideo = function(){
		var $elem = $(this);
		var data = {
			'action': 'check_sermon_duplicate_video',
			'video_url': $elem.val(),
			'curr_post_id': php_vars.postID,
			'nonce': php_vars.nonce
		};
		$.ajax({
			method: 'POST',
			url: ajaxurl,
			data: data,
			dataType: 'json'
		}).done(function(resp) {
			$(".lqdm-duplicate-notice").remove();
			if(resp.success === false) {
				$(".cmb2-metabox-description").after(resp.data);
			}
		});
	};

	$( app.init );

} )( window, document, jQuery, window.LqdMAdmin );
