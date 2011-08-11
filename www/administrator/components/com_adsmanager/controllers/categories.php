<?php
/**
 * @package		AdsManager
 * @copyright	Copyright (C) 2010-2011 JoomPROD.com. All rights reserved.
 * @license		GNU/GPL
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );

JTable::addIncludePath(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_adsmanager'.DS.'tables');
jimport('joomla.application.component.controller');

/**
 * Content Component Controller
 *
 * @package		Joomla
 * @subpackage	Content
 * @since 1.5
 */
class AdsmanagerControllerCategories extends JController
{
	var $_view = null;
	var $_model = null;
	
	function init()
	{
		// Set the default view name from the Request
		$this->_view = $this->getView("admin",'html');

		// Push a model into the view
		$this->_model = $this->getModel("category");
		if (!JError::isError( $this->_model )) {
			$this->_view->setModel( $this->_model, true );
		}
	}
	
	function display()
	{
		$this->init();
		$this->_view->setLayout("listcategories");
		$this->_view->display();
	}
	
	function edit()
	{
		$this->init();
		$this->_view->setLayout("editcategory");
		$this->_view->display();
	}
	
	function add()
	{
		$this->init();
		$this->_view->setLayout("editcategory");
		$this->_view->display();
	}
	
	function save()
	{
		$app = JFactory::getApplication();
		
		$category =& JTable::getInstance('category', 'AdsmanagerTable');

		// bind it to the table
		if (!$category -> bind(JRequest::get( 'post',JREQUEST_ALLOWHTML ))) {
			return JError::raiseWarning( 500, $category->getError() );
		}
		// store it in the db
		if (!$category -> store()) {
			return JError::raiseWarning( 500, $$category->getError() );
		}	
		
		$model = $this->getModel("configuration");
		$conf = $model->getConfiguration();
		
		$category->save(JRequest::get( 'post' ),JRequest::get( 'files' ),$conf,$this->getModel("adsmanager"));
	
		$cache = & JFactory::getCache('com_adsmanager');
		$cache->clean();
	
		$app->redirect( 'index.php?option=com_adsmanager&c=categories', JText::_('ADSMANAGER_CATEGORY_SAVED') );
	}
	
	function remove()
	{
		$app = &JFactory::getApplication();

		
		$category =& JTable::getInstance('category', 'AdsmanagerTable');
		
		$ids = JRequest::getVar( 'cid', array(0));
		if (!is_array($ids)) {
			$table = array();
			$table[0] = $ids;
			$ids = $table;
		}
		
		foreach($ids as $id){
			$category->delete($id);
		}
		
		$cache =& JFactory::getCache( 'com_adsmanager');
		$cache->clean();
		
		$app->redirect( 'index.php?option=com_adsmanager&c=categories', JText::_('ADSMANAGER_CATEGORY_REMOVED') );
	}
	
	function unpublish()
	{
		$this->_changeState();
	}
	
	function publish()
	{
		$this->_changeState();
	}
	
	function orderdown()
	{
		$this->_changeOrder(1);
	}
	
	function orderup()
	{
		$this->_changeOrder(-1);
	}
	
	function _changeOrder($inc)
	{
		$app = &JFactory::getApplication();

		
		$cid = JRequest::getVar( 'cid', array(), '', 'array' );
		
		if ($cid[0]) {
			$id = $cid[0];
			$row = JTable::getInstance('category', 'AdsmanagerTable');
			$row->load( $id );
			$row->move( $inc, "parent = $row->parent" );
		}
		
		$cache = & JFactory::getCache('com_adsmanager');
		$cache->clean();

		$app->redirect( 'index.php?option=com_adsmanager&c=categories' );
	}
	
	function _changeState()
	{
		$app = &JFactory::getApplication();


		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );

		$cid		= JRequest::getVar( 'cid', array(), '', 'array' );
		$publish	= ( $this->getTask() == 'publish' ? 1 : 0 );

		JArrayHelper::toInteger($cid);

		if (count( $cid ) < 1)
		{
			$action = $publish ? 'publish' : 'unpublish';
			JError::raiseError(500, JText::_( 'Select an item to' .$action, true ) );
		}
		
		$model = $this->getModel( "adsmanager");
		$model->changeState("#__adsmanager_categories","id","published",$publish,$cid);
		
		$cache = & JFactory::getCache('com_adsmanager');
		$cache->clean();
		
		$app->redirect( 'index.php?option=com_adsmanager&c=categories' );
	}	
	
	function saveorder()
	{
		$app = &JFactory::getApplication();


		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );
	
		// Initialize variables
		$cid 	= JRequest::getVar('cid', array(0), 'post', 'array');
		JArrayHelper::toInteger($cid, array(0));
		$total		= count( $cid );
		$order 		= JRequest::getVar( 'order', array(0), 'post', 'array' );
		JArrayHelper::toInteger($order, array(0));
	
		$row = JTable::getInstance('category', 'AdsmanagerTable');

		// update ordering values
		for( $i=0; $i < $total; $i++ ) {
			$row->load( (int) $cid[$i] );
			if ($row->ordering != $order[$i]) {
				$row->ordering = $order[$i];
				if (!$row->store()) {
					JError::raiseError(500, $db->getErrorMsg() );
				}
			}
		}
	
		$cache = & JFactory::getCache('com_adsmanager');
		$cache->clean();
		
		$msg = 'New ordering saved';
		$app->redirect( 'index.php?option=com_adsmanager&c=categories', $msg );
	}
}
