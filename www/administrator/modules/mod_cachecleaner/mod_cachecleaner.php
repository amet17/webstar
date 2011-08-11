<?php
/**
 * Main Module File
 * Does all the magic!
 *
 * @package     Cache Cleaner
 * @version     1.9.4
 *
 * @author      Peter van Westen <peter@nonumber.nl>
 * @link        http://www.nonumber.nl
 * @copyright   Copyright © 2011 NoNumber! All Rights Reserved
 * @license     http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

// No direct access
defined( '_JEXEC' ) or die();

/**
* Module that cleans cache
*/

// return if NoNumber! Elements plugin is not installed
jimport( 'joomla.filesystem.file' );
if ( !JFile::exists( JPATH_PLUGINS.DS.'system'.DS.'nonumberelements'.DS.'nonumberelements.php' ) ) {
	return;
}

// return if NoNumber! Elements plugin is not enabled
$nnep = JPluginHelper::getPlugin( 'system', 'nonumberelements' );
if ( !isset( $nnep->name ) ) {
	return;
}

// Include the syndicate functions only once
require_once dirname(__FILE__).DS.'cachecleaner'.DS.'helper.php';

require JModuleHelper::getLayoutPath( 'mod_cachecleaner'.DS.'cachecleaner' );