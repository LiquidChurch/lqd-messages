/**
 * Liquid Messages Admin Settings Page JavaScript
 *
 * Handles the tabbed user interface.
 */

window.LiquidChurchAdmin = window.LiquidChurchAdmin || {};

( function (window, document, $, LiquidChurchAdmin) {

    $( "#tabs" ).tabs().addClass( "ui-tabs-vertical ui-helper-clearfix" );
    $( "#tabs li" ).removeClass( "ui-corner-top" ).addClass( "ui-corner-left" );

}(window, document, jQuery, LiquidChurchAdmin) );
