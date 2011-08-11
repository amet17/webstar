/**
 * Main JavaScript file
 *
 * @package     Cache Cleaner
 * @version     1.9.4
 *
 * @author      Peter van Westen <peter@nonumber.nl>
 * @link        http://www.nonumber.nl
 * @copyright   Copyright © 2011 NoNumber! All Rights Reserved
 * @license     http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

var cachecleaner_fx = false;
var cachecleaner_delay = false;

window.addEvent( 'domready', function()
{
	document.getElement( '#cachecleaner' ).addEvent( 'click', function( event ) {
		var event = new Event( event );
		cachecleaner_load( event.control );
		return false;
	});

	new Element( 'span', {
		'id': 'cachecleaner_msg',
		'styles': { 'opacity': 0 }
	} )
	.injectInside( document.body )
	.addEvent( 'click', function(){ cachecleaner_show_end() } );
	cachecleaner_fx = new Fx.Styles( document.getElement( '#cachecleaner_msg' ), { wait: false } );
	cachecleaner_delay = false;
} );

var cachecleaner_load = function( purge )
{
	var params = 'cleancache=1&break=1';
	if ( purge ) {
		params += '&purge=1'
	}

	cachecleaner_show_start();
	var myXHR = new XHR( {
			method: 'get',
			onSuccess: function( data ) {
				var classname = 'warning';
				if( data.length > 100 ) {
					classname = 'failure';
					document.getElement( '#cachecleaner_msg' ).setHTML( cachecleaner_msg_inactive ).addClass( classname );
					cachecleaner_show_end( 4000 );
				} else {
					if ( data.charAt(0) == '+' ) {
						data = data.substring( 1, data.length );
						classname = 'success';
					}
					document.getElement( '#cachecleaner_msg' ).setHTML( data ).addClass( classname );
					cachecleaner_show_end( 2000 );
				}
			},
			onFailure: function() {
				document.getElement( '#cachecleaner_msg' ).setHTML( cachecleaner_msg_failure ).addClass( 'failure' );
				cachecleaner_show_end( 2000 );
			}
		} );
	myXHR.send( cachecleaner_root+'/index.php?'+params );
};

var cachecleaner_show_start = function()
{
	document.getElement( '#cachecleaner_msg' )
	.setHTML( '<img src="'+cachecleaner_root+'/modules/mod_cachecleaner/cachecleaner/images/loading.gif" alt=\"\" /> '+cachecleaner_msg )
	.removeClass( 'success' ).removeClass( 'failure' )
	.addClass( 'visible' );

	$clear( cachecleaner_delay );
	cachecleaner_fx.stop();
	cachecleaner_fx.start({
		'opacity': 0.8,
		'duration': 400
	});
};

var cachecleaner_show_end = function( delay )
{
	if ( delay ) {
		cachecleaner_delay = ( function(){ cachecleaner_show_end(); } ).delay( delay );
	} else {
		$clear( cachecleaner_delay );
		cachecleaner_fx.stop();
		cachecleaner_fx.start({
			'opacity': 0,
			'duration': 1600
		});
	}
};