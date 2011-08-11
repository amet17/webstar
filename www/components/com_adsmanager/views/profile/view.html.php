<?php
/**
 * @package		AdsManager
 * @copyright	Copyright (C) 2010-2011 JoomPROD.com. All rights reserved.
 * @license		GNU/GPL
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );

jimport('joomla.application.component.view');

require_once(JPATH_BASE."/components/com_adsmanager/helpers/field.php");

/**
 * @package		Joomla
 * @subpackage	Contacts
 */
class AdsmanagerViewProfile extends JView
{
	function display($tpl = null)
	{
		$app = &JFactory::getApplication();

		$user		= JFactory::getUser();
		$pathway	= $app->getPathway();
		$document	= JFactory::getDocument();
		
		$usermodel	    = &$this->getModel( "user" );
		$configurationmodel	= &$this->getModel( "configuration" );
		
		
		$userid = $user->id;
		
		if ($userid == "0") {
	    	$app->redirect( "index.php?option=com_adsmanager&view=login&Itemid=".$this->get("Itemid"), "" );
			//adsmanager_html::loginpage($_SERVER['REQUEST_URI'],$conf->comprofiler);	  	  
	    }
	    else
	    { 	
	    	$conf = $configurationmodel->getConfiguration();
			if ($conf->comprofiler > 0)
			{
				$app->redirect( "index.php?option=com_comprofiler&task=userDetails&Itemid=".$this->get("Itemid"), "" );
			}
			else
			{
				$fields = $usermodel->getProfileFields();
				$user = $usermodel->getProfile($userid);	
				$this->assignRef('fields',$fields);	
				$this->assignRef('user',$user);	
			}
		}
		
		$document->setTitle( JText::_('ADSMANAGER_PAGE_TITLE'));
		
		parent::display($tpl);
	}
}
