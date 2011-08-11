<?php
/**
 * @package		AdsManager
 * @copyright	Copyright (C) 2010-2011 JoomPROD.com. All rights reserved.
 * @license		GNU/GPL
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );

jimport('joomla.application.component.controller');
jimport( 'joomla.filesystem.folder' );
jimport( 'joomla.filesystem.file' );

/**
 * Content Component Controller
 *
 * @package		Joomla
 * @subpackage	Content
 * @since 1.5
 */
class AdsmanagerControllerPlugins extends JController
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
		$this->_view->setLayout("listplugins");
		$this->_view->display();
	}
	
	function remove()
	{
		jimport( 'joomla.filesystem.folder' );
		$app = &JFactory::getApplication();
		
		$cid = JRequest::getVar('cid');
		if (!is_array($cid) || count($cid) < 1) {
			$app->redirect( "index.php?option=com_adsmanager&c=plugins", '' );
		}
		
		foreach($cid as $pluginname)
		{
			$plugins = array();
			$path = JPATH_SITE."/images/com_adsmanager/plugins/$pluginname";
			
			require_once($path."/plug.php");
			foreach($plugins as $plug)
			{
				$plug->uninstall();
			}
		
			if ($pluginname != "")
				JFolder::delete($path);
		}
		
		$cache =& JFactory::getCache( 'com_adsmanager');
		$cache->clean();
		
		$app->redirect("index.php?option=com_adsmanager&c=plugins", "");
	}
	
	function upload()
	{
		$app = &JFactory::getApplication();
	
		// Check that the zlib is available
		if(!extension_loaded('zlib')) {
			$app->redirect( "index.php?option=com_adsmanager&c=plugins", "The installer can't continue before zlib is installed" );
		}
	
		$userfile = JRequest::getVar( 'userfile', null,"FILES" ); //$_FILES
		$name = substr ( $userfile['name'], 0 , strpos($userfile['name'],'.')); 
		if (eregi( '.zip$', $userfile['name'] )) {
			// Extract functions
			
			jimport( 'joomla.filesystem.archive' );
			$zip =& JArchive::getAdapter('zip');
			$ret = $zip->extract($userfile['tmp_name'], JPATH_SITE."/images/com_adsmanager/plugins/".$name);	
			if($ret != true) {
				JError::raiseError( 500, 'Extract Error' );
				return false;
			}
		} else {
			JError::raiseError( 500, 'Extract Error' );
			return false;
		}
		
		if (file_exists(JPATH_SITE."/images/com_adsmanager/plugins/".$name."/plug.php")) {
			require_once(JPATH_SITE."/images/com_adsmanager/plugins/".$name."/plug.php");
			foreach($plugins as $plug)
			{
				$plug->install();
			}
		} else {
			JFolder::delete(JPATH_SITE."/images/com_adsmanager/plugins/".$name);
			JError::raiseError( 500, 'This is not an adsmanager plugin' );
			return false;
		}
		
		$app->redirect( "index.php?option=com_adsmanager&c=plugins","");
	}
}
