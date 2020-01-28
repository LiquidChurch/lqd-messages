/**
 * LiquidChurch Functionality
 *
 * Licensed under the GPLv2+ license.
 */

window.LiquidChurchFunctionality = window.LiquidChurchFunctionality || {};

( function( window, document, $, plugin ) {
	var $c = {};

	plugin.init = function() {
		plugin.cache();
		plugin.bindEvents();
	};

	plugin.cache = function() {
		$c.window = $( window );
		$c.body = $( document.body );
	};

	plugin.bindEvents = function() {
	};

	$( plugin.init );
}( window, document, jQuery, window.LiquidChurchFunctionality ) );
