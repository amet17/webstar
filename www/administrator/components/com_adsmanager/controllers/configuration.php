<?php
/**
 * @package		AdsManager
 * @copyright	Copyright (C) 2010-2011 JoomPROD.com. All rights reserved.
 * @license		GNU/GPL
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );

jimport('joomla.application.component.controller');
JTable::addIncludePath(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_adsmanager'.DS.'tables');


/**
 * Content Component Controller
 *
 * @package		Joomla
 * @subpackage	Content
 * @since 1.5
 */
class AdsmanagerControllerConfiguration extends JController
{
	function init()
	{
		// Set the default view name from the Request
		$this->_view = $this->getView("admin",'html');

		// Push a model into the view
		$this->_model = $this->getModel( "configuration");
		if (!JError::isError( $this->_model )) {
			$this->_view->setModel( $this->_model, true );
		}
	}
	
	function display()
	{
		$this->init();
		$this->_view->setLayout("configuration");
		$this->_view->display();
	}
	
	function save()
	{
		$app = &JFactory::getApplication();
		
		$conf =& JTable::getInstance('adsconfiguration', 'AdsmanagerTable');

		// bind it to the table
		if (!$conf -> bind(JRequest::get( 'post',JREQUEST_ALLOWHTML  ))) {
			return JError::raiseWarning( 500, $conf->getError() );
		}
		// store it in the db
		if (!$conf -> store()) {
			return JError::raiseWarning( 500, $conf->getError() );
		}	
		
		$cache =& JFactory::getCache( 'com_adsmanager');
		$cache->clean();
	
		$app->redirect( 'index.php?option=com_adsmanager&c=configuration', JText::_('ADSMANAGER_CONFIGURATION_SAVED') );
	}
}
