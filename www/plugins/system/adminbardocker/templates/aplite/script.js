/**
 * Javascript file for template: APLite
 *
 * @package     AdminBar Docker
 * @version     1.4.7
 *
 * @author      Peter van Westen <peter@nonumber.nl>
 * @link        http://www.nonumber.nl
 * @copyright   Copyright © 2011 NoNumber! All Rights Reserved
 * @license     http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

window.addEvent( 'domready', function() {
	/* Add elements (in desired order) to abd_top */
	abd_top.include( document.getElement( 'div#module-status' ) );

	/* Add elements (in desired order) to abd_toggle_top that will show in top on 'dock to bottom' option */
	abd_toggle_top.include( document.getElement( 'div#ap-header' ) );
	abd_toggle_top.include( document.getElement( 'div#ap-submenu' ) );
	abd_toggle_top.include( document.getElement( 'div#ap-title' ) );

	/* Add elements (in desired order) to abd_toggle_bottom that will show in bottom on 'dock to bottom' option */
	abd_toggle_bottom.include( document.getElement( 'div#ap-title' ) );
	abd_toggle_bottom.include( document.getElement( 'div#ap-header' ) );
	abd_toggle_bottom.include( document.getElement( 'div#ap-submenu' ) );

	/* Add elements (in desired order) to abd_bottom */
});