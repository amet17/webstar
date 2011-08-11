/**
 * Javascript file for template: AdminPraise (1)
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
	abd_top.include( document.getElement( 'div#tools' ) );
	abd_top.include( document.getElement( 'div#topmenu' ) );

	/* Add elements (in desired order) to abd_toggle_top that will show in top on 'dock to bottom' option */
	abd_toggle_top.include( document.getElement( 'div.header' ) );
	abd_toggle_top.include( document.getElement( 'ul#submenu' ) );
	abd_toggle_top.include( document.getElement( 'div#toolbar' ) );

	/* Add elements (in desired order) to abd_toggle_bottom that will show in bottom on 'dock to bottom' option */
	abd_toggle_bottom.include( document.getElement( 'div.header' ) );
	abd_toggle_bottom.include( document.getElement( 'ul#submenu' ) );
	abd_toggle_bottom.include( document.getElement( 'div#toolbar' ) );

	/* Add elements (in desired order) to abd_bottom */
});