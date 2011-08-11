/**
 * Main JavaScript file
 *
 * @package     AdminBar Docker
 * @version     1.4.7
 *
 * @author      Peter van Westen <peter@nonumber.nl>
 * @link        http://www.nonumber.nl
 * @copyright   Copyright © 2011 NoNumber! All Rights Reserved
 * @license     http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

var all_scripts = document.getElementsByTagName("script");
if ( all_scripts.length ) {
	var nn_script = all_scripts[all_scripts.length-1].src.replace( '.js', '' );
	mt_version = ( MooTools.version < 1.2 ) ? '11' : '12';
	if ( mt_version ) {
		document.write('<script src="'+nn_script+'_mt'+mt_version+'.js" type="text/JavaScript"><\/script>');
	}
}