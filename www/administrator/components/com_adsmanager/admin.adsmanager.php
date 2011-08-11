<?php
/**
 * @package		AdsManager
 * @copyright	Copyright (C) 2010-2011 JoomPROD.com. All rights reserved.
 * @license		GNU/GPL
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

// Make sure the user is authorized to view this page
$user = & JFactory::getUser();
/*if (!$user->authorize( 'com_adsmanager', 'manage' )) {
    $app = &JFactory::getApplication();
	$app->redirect('index.php', JText::_('ALERTNOTAUTH'));
}*/

// Component Helper
jimport('joomla.application.component.helper');

if ( file_exists( JPATH_SITE. "/components/com_paidsystem/api.paidsystem.php")) 
{
	require_once(JPATH_SITE . "/components/com_paidsystem/api.paidsystem.php");
}

$controllerName = JRequest::getCmd( 'c', 'configuration' );

require_once( JPATH_COMPONENT.DS.'controllers'.DS.$controllerName.'.php' );
$controllerName = 'AdsmanagerController'.$controllerName;

// Create the controller
$controller = new $controllerName();

if(version_compare(JVERSION,'1.6.0','>=')){
	JHtml::_('behavior.framework');
	JSubMenuHelper::addEntry(JText::_('COM_ADSMANAGER_CONFIGURATION'), 'index.php?option=com_adsmanager&amp;c=configuration');
	JSubMenuHelper::addEntry(JText::_('COM_ADSMANAGER_FIELDS'), 'index.php?option=com_adsmanager&amp;c=fields');
	JSubMenuHelper::addEntry(JText::_('COM_ADSMANAGER_COLUMNS'), 'index.php?option=com_adsmanager&amp;c=columns');
	JSubMenuHelper::addEntry(JText::_('COM_ADSMANAGER_AD_DISPLAY'), 'index.php?option=com_adsmanager&amp;c=positions');
	JSubMenuHelper::addEntry(JText::_('COM_ADSMANAGER_CATEGORIES'), 'index.php?option=com_adsmanager&amp;c=categories');
	JSubMenuHelper::addEntry(JText::_('COM_ADSMANAGER_CONTENTS'), 'index.php?option=com_adsmanager&amp;c=contents');
	JSubMenuHelper::addEntry(JText::_('COM_ADSMANAGER_PLUGINS'), 'index.php?option=com_adsmanager&amp;c=plugins');
	JSubMenuHelper::addEntry(JText::_('COM_ADSMANAGER_FIELD_IMAGES'), 'index.php?option=com_adsmanager&amp;c=fieldimages');
	JSubMenuHelper::addEntry(JText::_('COM_ADSMANAGER_TOOLS'), 'index.php?option=com_adsmanager&amp;c=tools');
}	
		
// Perform the Request task
$controller->execute(JRequest::getCmd('task', null));
$controller->redirect();
