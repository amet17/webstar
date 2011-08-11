<?php
/**
 * @package		AdsManager
 * @copyright	Copyright (C) 2010-2011 JoomPROD.com. All rights reserved.
 * @license		GNU/GPL
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

// Require the com_content helper library
require_once(JPATH_COMPONENT.DS.'controller.php');

// Component Helper
jimport('joomla.application.component.helper');

if ( file_exists( JPATH_BASE. "/components/com_paidsystem/api.paidsystem.php")) 
{
	require_once(JPATH_BASE . "/components/com_paidsystem/api.paidsystem.php");
}

// Create the controller
if(version_compare(JVERSION,'1.6.0','>=')){
	$controller = JController::getInstance('adsmanager');
} else {
	$controller = new AdsmanagerController();
}

// Perform the Request task
$controller->execute(JRequest::getCmd('task'));
 
// Redirect if set by the controller
$controller->redirect();