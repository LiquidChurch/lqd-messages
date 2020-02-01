/**
 * LiquidChurch Admin Functionality
 *
 * Licensed under the GPLv2+ license.
 */

window.LiquidChurchAdmin = window.LiquidChurchAdmin || {};

( function (window, document, $, LiquidChurchAdmin) { // TODO: Do we need LiquidChurchAdmin parameter?

    $( "#tabs" ).tabs().addClass( "ui-tabs-vertical ui-helper-clearfix" );
    $( "#tabs li" ).removeClass( "ui-corner-top" ).addClass( "ui-corner-left" );

}(window, document, jQuery, LiquidChurchAdmin) );
