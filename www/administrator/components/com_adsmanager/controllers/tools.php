<?php
/**
 * @package		AdsManager
 * @copyright	Copyright (C) 2010-2011 JoomPROD.com. All rights reserved.
 * @license		GNU/GPL
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );

jimport('joomla.application.component.controller');

/**
 * Content Component Controller
 *
 * @package		Joomla
 * @subpackage	Content
 * @since 1.5
 */
class AdsmanagerControllerTools extends JController
{
var $_view = null;
	var $_model = null;
	
	function init()
	{
		// Set the default view name from the Request
		$this->_view = $this->getView("admin",'html');
	}
	
	function display()
	{
		$this->init();
		$this->_view->setLayout("tools");
		$this->_view->display();
	}
	
	function installjoomfish($option)
	{
		$app = &JFactory::getApplication();
		
		if(file_exists(JPATH_SITE . "/administrator/components/com_joomfish/contentelements/")){
			$error = 0;
			
			@copy(JPATH_SITE . "/administrator/components/com_adsmanager/joomfish/adsmanager_ads.xml",JPATH_SITE . "/administrator/components/com_joomfish/contentelements/adsmanager_ads.xml");
				
			@copy(JPATH_SITE . "/administrator/components/com_adsmanager/joomfish/adsmanager_categories.xml",JPATH_SITE . "/administrator/components/com_joomfish/contentelements/adsmanager_categories.xml");
	
			@copy(JPATH_SITE . "/administrator/components/com_adsmanager/joomfish/adsmanager_columns.xml",JPATH_SITE . "/administrator/components/com_joomfish/contentelements/adsmanager_columns.xml");
				
			@copy(JPATH_SITE . "/administrator/components/com_adsmanager/joomfish/adsmanager_config.xml",JPATH_SITE . "/administrator/components/com_joomfish/contentelements/adsmanager_config.xml");
				
			@copy(JPATH_SITE . "/administrator/components/com_adsmanager/joomfish/adsmanager_fields.xml",JPATH_SITE . "/administrator/components/com_joomfish/contentelements/adsmanager_fields.xml");
			
			@copy(JPATH_SITE . "/administrator/components/com_adsmanager/joomfish/adsmanager_field_values.xml",JPATH_SITE . "/administrator/components/com_joomfish/contentelements/adsmanager_field_values.xml");
			
				
			$app->redirect( "index.php?option=com_adsmanager&c=tools", JText::_('ADSMANAGER_INSTALL_SUCCESSFULL'));
		}
		else
		{
			$app->redirect( "index.php?option=com_adsmanager&c=tools", JText::_('ADSMANAGER_ERROR_INSTALL'));
		}
	}
	
	function installsef($option)
	{
		$app = &JFactory::getApplication();
		
		if(file_exists(JPATH_SITE . "/components/com_sef/sef_ext/")){
			if(!file_exists(JPATH_SITE . "/components/com_sef/sef_ext/com_adsmanager.php"))
			{
				@copy(JPATH_SITE . "/administrator/components/com_adsmanager/sef/com_adsmanager.php",JPATH_SITE . "/components/com_sef/sef_ext/com_adsmanager.php");
				$app->redirect( "index.php?option=com_adsmanager&c=tools", JText::_('ADSMANAGER_INSTALL_SUCCESSFULL'));
			}
			else
			{
				$app->redirect( "index.php?option=com_adsmanager&c=tools", JText::_('ADSMANAGER_ALREADY_INSTALL'));
			}	
		}
		else
		{
			$app->redirect( "index.php?option=com_adsmanager&c=tools", JText::_('ADSMANAGER_ERROR_INSTALL'));
		}
	}
}
