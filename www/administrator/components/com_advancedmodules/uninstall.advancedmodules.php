<?php
/**
 * Uninstallation File
 * Performs some extra tasks when uninstalling the component
 *
 * @package     Advanced Module Manager
 * @version     1.19.0
 *
 * @author      Peter van Westen <peter@nonumber.nl>
 * @link        http://www.nonumber.nl
 * @copyright   Copyright © 2011 NoNumber! All Rights Reserved
 * @license     http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

// No direct access
defined( '_JEXEC' ) or die();

$ext = 'advancedmodules';

// Delete plugin files
$file = JPATH_PLUGINS.DS.'system'.DS.$ext.'php';
if( JFile::exists( $file ) ) {
	JFile::delete( $file );
}
$file = JPATH_PLUGINS.DS.'system'.DS.$ext.'xml';
if( JFile::exists( $file ) ) {
	JFile::delete( $file );
}
$folder = JPATH_PLUGINS.DS.'system'.DS.'advancedmodules';
if( JFolder::exists( $folder ) ) {
	JFolder::delete( $folder );
}

// Delete plugin language files
$lang_folder = JPATH_ADMINISTRATOR.DS.'language';
$languages = JFolder::folders( $lang_folder );
foreach ( $languages as $lang ) {
	$file = $lang_folder.DS.$lang.DS.$lang.'.plg_system_'.$ext.'.ini';
	if( JFile::exists( $file ) ) {
		JFile::delete( $file );
	}
	$file = $lang_folder.DS.$lang.DS.$lang.'.plg_system_'.$ext.'.sys.ini';
	if( JFile::exists( $file ) ) {
		JFile::delete( $file );
	}
}