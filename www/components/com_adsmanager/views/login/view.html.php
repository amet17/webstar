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
class AdsmanagerViewLogin extends JView
{
	function display($tpl = null)
	{
		$app = &JFactory::getApplication();

		$user		= JFactory::getUser();
		$pathway	= $app->getPathway();
		$document	= JFactory::getDocument();
		$configurationmodel		= $this->getModel("configuration");
		
		// Get the parameters of the active menu item
		$menus	= JSite::getMenu();
		$menu    = $menus->getActive();
		
		$conf = $configurationmodel->getConfiguration();
				
		$validate = JHTML::_( 'form.token' );
		
		$link_login = JRoute::_("index.php");
		
		$version = new JVersion;
        $joomla = $version->getShortVersion();
        
        //		$image = JPATH_BASE .'/images/stories/key.jpg';
        if(substr($joomla,0,3) == '1.6'){
        	// key.jpg isn't part of Joomla 1.6
        	$image = NULL;
        }else{
        	// key.jpg is part of Joomla! 1.5
			$image = JURI::base().'images/stories/key.jpg';
		}
        
		$this->assignRef('image',$image);
		
        if(substr($joomla,0,3) == '1.6'){
            //joomla 1.6 format          
            $special = '<input type="hidden" name="task" value="user.login" />';
            $special .= '<input type="hidden" name="option" value="com_users" />';
        } else {    
            //joomla 1.5 format
            $special = '<input type="hidden" name="task" value="login" />';
            $special .= '<input type="hidden" name="option" value="com_user" />';            
        }
        
        $this->assignRef('version',$joomla);
		  
		$return = JRoute::_("index.php?option=com_adsmanager&Itemid=".$this->get('Itemid'));
		$return = base64_encode( $return );  

		$this->assignRef('validate',$validate);
		$this->assignRef('link_login',$link_login);
		$this->assignRef('special',$special);
		$this->assignRef('return',$return);
		
		if ($conf->comprofiler > 0)
		{
			$link_lostpassword = JRoute::_("index.php?option=com_comprofiler&task=lostPassword");
			$link_create = JRoute::_("index.php?option=com_comprofiler&task=registers");
		}
		else
		{
			if(substr($joomla,0,3) == '1.6'){
				$link_lostpassword = JRoute::_("index.php?option=com_users&view=reset");
				$link_create = JRoute::_("index.php?option=com_users&view=registration");
			} else {   
				$link_lostpassword = JRoute::_("index.php?option=com_user&view=reset");
				$link_create = JRoute::_("index.php?option=com_user&view=register");
			}
		}
		
		$this->assignRef('link_lostpassword',$link_lostpassword);
		$this->assignRef('link_create',$link_create);
		
		$document->setTitle( JText::_('ADSMANAGER_PAGE_TITLE'));

		parent::display($tpl);
	}
}
