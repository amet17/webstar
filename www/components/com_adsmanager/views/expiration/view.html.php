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
require_once(JPATH_BASE."/components/com_adsmanager/helpers/general.php");

/**
 * @package		Joomla
 * @subpackage	Contacts
 */
class AdsmanagerViewExpiration extends JView
{
	function display($tpl = null)
	{
		$app = &JFactory::getApplication();

		$user		= JFactory::getUser();
		$pathway	= $app->getPathway();
		$document	= JFactory::getDocument();
		
		$contentmodel	= &$this->getModel( "content" );
		$configurationmodel	= &$this->getModel( "configuration" );
		
		$conf = $configurationmodel->getConfiguration();

		$contentid = JRequest::getInt( 'id',	0 );
		$content = $contentmodel->getContent($contentid);
		
		if (($content == null)||($content->userid != $user->id))
			$app->redirect( 'index.php?option=com_adsmanager&Itemid='.$this->get("Itemid"), "" );
		
		$this->assignRef('content',$content);
		
		$document->setTitle( JText::_('ADSMANAGER_PAGE_EXPIRATION'));

		parent::display($tpl);
	}
}
