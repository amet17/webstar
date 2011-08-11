<?php
/**
 * Main Administrator Component File
 * This defines what controller to use and what task to execute.
 *
 * @package     NoNumber! Extension Manager
 * @version     2.4.7
 *
 * @author      Peter van Westen <peter@nonumber.nl>
 * @link        http://www.nonumber.nl
 * @copyright   Copyright © 2011 NoNumber! All Rights Reserved
 * @license     http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

// No direct access
defined( '_JEXEC' ) or die();

$lang =& JFactory::getLanguage();
if ( $lang->getTag() != 'en-GB' ) {
	// Loads English language file as fallback (for undefined stuff in other language file)
	$lang->load( 'com_nonumbermanager', JPATH_ADMINISTRATOR, 'en-GB' );
}
$lang->load( 'com_nonumbermanager', JPATH_ADMINISTRATOR, null, 1 );

jimport( 'joomla.filesystem.file' );
$mainframe =& JFactory::getApplication();

// return if NoNumber! Elements plugin is not installed
if ( !JFile::exists( JPATH_PLUGINS.DS.'system'.DS.'nonumberelements'.DS.'nonumberelements.php' ) ) {
	$mainframe->set( '_messageQueue', '' );
	$mainframe->enqueueMessage( JText::_( 'NNEM_NONUMBER_ELEMENTS_PLUGIN_NOT_INSTALLED' ), 'error' );
	return;
}

// give notice if NoNumber! Elements plugin is not enabled
$nnep = JPluginHelper::getPlugin( 'system', 'nonumberelements' );
if ( !isset( $nnep->name ) ) {
	$mainframe->set( '_messageQueue', '' );
	$mainframe->enqueueMessage( JText::_( 'NNEM_NONUMBER_ELEMENTS_PLUGIN_NOT_ENABLED' ), 'notice' );
	return;
}

// load the NoNumber! Elements language file
if ( $lang->getTag() != 'en-GB' ) {
	// Loads English language file as fallback (for undefined stuff in other language file)
	$lang->load( 'plg_system_nonumberelements', JPATH_ADMINISTRATOR, 'en-GB' );
}
$lang->load( 'plg_system_nonumberelements', JPATH_ADMINISTRATOR, null, 1 );

// Place install messages
$session =& JFactory::getSession();
$msgs = JRequest::getVar( 'msgs', '', 'default', 'none', 4 );
if ( $msgs != '' && !( strpos( $msgs, '<dl id="system' ) === false ) ) {
	$session->set( 'application.nn_msgs', $msgs );
	header('Location: index.php?option=com_nonumbermanager');
	exit();
}
$msgs = $session->get( 'application.nn_msgs' );
if ( !( strpos( $msgs, 'Remote Server connection failed' ) === false ) ) {
	$msgs .= '<dl id="system-message"><dt class="notice">'.JText::_( 'Notice' ).'</dt><dd class="notice message fade"><ul><li>'
		.JText::_( 'NNEM_ERROR_CANNOT_DOWNLOAD_FILE' )
		.'</li></ul></dd></dl>';
}
echo $msgs;
$session->set( 'application.nn_msgs', '' );

// Version check
require_once JPATH_PLUGINS.DS.'system'.DS.'nonumberelements'.DS.'helpers'.DS.'versions.php';
$versions = NNVersions::instance();
$version = '';
$xml = JApplicationHelper::parseXMLInstallFile( JPATH_ADMINISTRATOR.DS.'components'.DS.'com_nonumbermanager'.DS.'nonumbermanager.xml' );
if ( $xml && isset( $xml['version'] ) ) {
	$version = $xml['version'];
}

// Set the controller page
require_once JPATH_COMPONENT.DS.'controllers'.DS.'default'.'.php';

// Create a new class of classname and set the default task: display
$controller = new NoNumberManagerController( array( 'default_task'=>'display' ) );

// Perform the Request task
$controller->execute( JRequest::getCmd( 'task' ) );

// Redirect if set by the controller
$controller->redirect();

// Place Commercial License Code check
echo '<p style="text-align:center;">'.JText::_( 'NONUMBER_EXTENSION_MANAGER' );
if ( $version ) {
	echo ' v'.$version;
}
echo ' - '.JText::_( 'COPYRIGHT' ).' (C) 2011 NoNumber! '.JText::_( 'ALL_RIGHTS_RESERVED' ).'</p>';