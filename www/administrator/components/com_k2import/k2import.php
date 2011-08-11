<?php
 
/**
 * K2import entry point for K2import Component
 * 
 * @package    K2import
 * @link http://www.individual-it.net
 * @license		GNU/GPL
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

// Require the base controller
require_once (JPATH_COMPONENT.DS.'controller.php');
require_once(JPATH_COMPONENT.DS.'helper.php');

//Create a new toolbar:
jimport ('joomla.html.toolbar');
$toolbar = new JToolbar('toolbar');

//Add the Jix button path & load the upload button type:
$toolbar->addButtonPath(JPATH_COMPONENT.DS.'button');
$button = & $toolbar->loadButtonType('Upload', true);



// Require specific controller if requested
if($controller = JRequest::getVar('controller')) {
	require_once (JPATH_COMPONENT.DS.'controllers'.DS.$controller.'.php');
}

// Create the controller
$classname	= 'K2importController'.$controller;
$controller = new $classname();

// Perform the Request task
$controller->execute( JRequest::getVar('task'));

// Redirect if set by the controller
$controller->redirect();

?>
