/**
 * Javascript file for template: Khepri (MooTools 1.2 compatible)
 *
 * @package     AdminBar Docker
 * @version     1.1.1a
 *
 * @author      Peter van Westen <peter@nonumber.nl>
 * @link        http://www.nonumber.nl
 * @copyright   Copyright © 2011 NoNumber! All Rights Reserved
 * @license     http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

window.addEvent( 'domready', function() {
	/* Add ALL toolbars (in desired order) to abd_top */
	abd_top.include( document.getElement( 'div#header-box' ) );
	abd_top.include( document.getElement( 'div#toolbar-box' ) );
	abd_top.include( document.getElement( 'div#submenu-box' ) );

	/* Add only the elements for the 'dock to bottom' option (in desired order) to abd_bottom */
	abd_bottom.include( document.getElement( 'div#toolbar-box' ) );
	abd_bottom.include( document.getElement( 'div#submenu-box' ) );
});