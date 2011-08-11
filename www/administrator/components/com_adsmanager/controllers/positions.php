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
class AdsmanagerControllerPositions extends JController
{
	function init()
	{
		// Set the default view name from the Request
		$this->_view = $this->getView("admin",'html');

		// Push a model into the view
		$this->_model = $this->getModel( "position");
		if (!JError::isError( $this->_model )) {
			$this->_view->setModel( $this->_model, true );
		}
	}
	
	function display()
	{
		$this->init();
		
		$fieldmodel	  = $this->getModel("field");
		$this->_view->setModel( $fieldmodel );
		
		$this->_view->setLayout("position");
		$this->_view->display();
	}
}
