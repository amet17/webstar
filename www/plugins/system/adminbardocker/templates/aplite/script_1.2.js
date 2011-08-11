/**
 * Javascript file for template: APLite (MooTools 1.2 compatible)
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
	abd_top.include( document.getElement( 'div#module-status' ) );
	abd_top.include( document.getElement( 'div#ap-header' ) );
	abd_top.include( document.getElement( 'div#ap-submenu' ) );
	abd_top.include( document.getElement( 'div#ap-title' ) );

	/* Add only the elements for the 'dock to bottom' option (in desired order) to abd_bottom */
	abd_bottom.include( document.getElement( 'div#ap-title' ) );
	abd_bottom.include( document.getElement( 'div#ap-header' ) );
	abd_bottom.include( document.getElement( 'div#ap-submenu' ) );
});