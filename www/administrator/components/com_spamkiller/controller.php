<?php
/**
 * @version		1.0
 * @package		Joomla
 * @subpackage	Spam Killer
 * @author  Tuan Pham Ngoc
 * @copyright	Copyright (C) 2010 Ossolution Team
 * @license		GNU/GPL, see LICENSE.php
 */
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );
jimport( 'joomla.application.component.controller' );
/**
 * Spam Killer controller
 *
 * @package		Joomla
 * @subpackage	Spam Killer
 * @since 1.5
 */
class SpamkillerController extends JController
{
	/**
	 * Constructor function
	 *
	 * @param array $config
	 */
	function __construct($config = array())
	{
		parent::__construct($config);			
	}
	/**
	 * Display information
	 *
	 */
	function display( )
	{	
		$task = $this->getTask();		
		switch ($task) {				
			case 'show_users':
				JRequest::setVar('view', 'skusers');
				break;	
			case 'show_configs':
				JRequest::setVar('view', 'config');
				break;	
			case 'show_messages':
				JRequest::setVar('view', 'messages');
				break;					
			default:
				JRequest::setVar('view', 'skusers');
				break;					 	 
		}
		parent::display();
	}
   /**
	 * Save the config
	 */
    function save_config(){
		$post = JRequest::get('post',JREQUEST_ALLOWHTML);	
		$model = & $this->getModel('config');
		$ret = $model->store($post);			
		if ($ret){
			$msg = JText::_('Config record saved');
		} else {
			$msg = JText::_('Error saving Config record');
		}
		$this->setRedirect( 'index.php?option=com_spamkiller&task=show_configs', $msg );
	}
	/**
	 * Cancel the Category
	 *
	 */
	function cancel_spamkiller() {		
		$url = 'index.php?option=com_spamkiller';
		$this->setRedirect($url);	
	}
	/**
	 * Remove the selected registration
	 *
	 */
	function remove_skusers() {
		$cid =  JRequest::getVar('cid', array(), 'post');
		JArrayHelper::toInteger($cid);
		$model = & $this->getModel('skuser');
		$ret = $model->delete($cid);
		if ($ret) 
			$msg = JText::_('Spam killers User successfully removed');
		else 
			$msg = JText::_('Error while removing Spam killers User');
		$url = 'index.php?option=com_spamkiller&task=show_skusers';
		$this->setRedirect($url, $msg);							
	}
	/**
	 * block a spam killer user
	 *
	 */
	function skusers_publish() {
		$cid = JRequest::getVar('cid', array(), 'post');
		JArrayHelper::toInteger($cid);		
		$model = & $this->getModel('skuser');
		$model->publish($cid , 1);
		$msg = JText::_('Spam killer user successfully activated');
		$url = 'index.php?option=com_spamkiller&task=show_skusers';
		$this->setRedirect($url, $msg);
	}	
	/**
	 * Publish a spam killer messages
	 *
	 */
	function messages_publish() {
		$cid = JRequest::getVar('cid', array(), 'post');
		JArrayHelper::toInteger($cid);		
		$model = & $this->getModel('message');
		$model->publish($cid , 1);	
		$msg = JText::_('Spam killer user successfully activated');
		$url = 'index.php?option=com_spamkiller&task=show_messages';
		$this->setRedirect($url, $msg);
	}	
  	/**
	 * Remove the selected registration
	 *
	 */
	function remove_messages() {
		$cid =  JRequest::getVar('cid', array(), 'post');
		JArrayHelper::toInteger($cid);
		$model = & $this->getModel('message');		
		$ret = $model->delete($cid);
		if ($ret) 
			$msg = JText::_('Spam killers messages successfully removed');
		else 
			$msg = JText::_('Error while removing Spam killers messages');
		$url = 'index.php?option=com_spamkiller&task=show_messages';
		$this->setRedirect($url, $msg);							
	}     	
    /**
	 * Cancel the registration
	 *
	 */
	function cancel() {		
		$url = 'index.php';
		$this->setRedirect($url);	
	}	
}