<?php
/**
 * @package		AdsManager
 * @copyright	Copyright (C) 2010-2011 JoomPROD.com. All rights reserved.
 * @license		GNU/GPL
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );

jimport('joomla.application.component.view');

/**
 * @package		Joomla
 * @subpackage	Contacts
 */
class AdsmanagerViewList extends JView
{
	function display()
	{
		$app = &JFactory::getApplication();

		$user		= JFactory::getUser();
		$pathway	= $app->getPathway();
		$document	= JFactory::getDocument();
		$contentmodel	= &$this->getModel( "content" );
		$catmodel	= &$this->getModel( "category" );
		$configurationmodel	= &$this->getModel( "configuration" );
		
		$uri =& JFactory::getURI();
		$this->requestURL =& $uri->toString();

		// Get the parameters of the active menu item
		$menus	= JSite::getMenu();
		$menu    = $menus->getActive();
		
		$conf = $configurationmodel->getConfiguration();
		
		if ($conf->show_rss == 0)
			return;
		
		$catid = JRequest::getInt( 'catid',	0 );
		if ($catid != "0") {
			$category = $catmodel->getCategory($catid);
			$category->img = $this->get('baseurl').'/images/com_adsmanager/categories/'.$catid.'cat_t.jpg';
		}
		else
		{
			$category->name = JText::_("ADSMANAGER_ALL_ADS");
			$category->description = "";
			$category->img = "";
		}
		
		$filters = array();
		$filters['publish'] =  1;
		
		if ($catid != 0)
			$filters['category'] = $catid;
			
		$listuser = JRequest::getInt( 'user',	0 );
		if ($listuser != 0) {
			$filters['user'] = $listuser;
			$category->name = JText::_('ADSMANAGER_LIST_USER_TEXT')." ".$user->username;
		}
		
		//$this->assignRef('list_description',$category->description);
		
		//$this->assignRef('contents',$contents);
		
		$document->setTitle( JText::_('ADSMANAGER_PAGE_TITLE'). $category->name );
		$document->setDescription("");
		
		$contents = $contentmodel->getContents($filters,0, 20,"a.date_created DESC ,a.id ","DESC");
		
		jimport('joomla.document.feed.feed');
		
		foreach($contents as $row)
		{
		// load individual item creator class
			$item = new JFeedItem();
			$item->title 		= $row->ad_headline;
			$item->link 		= JRoute::_('index.php?option=com_adsmanager&view=details&catid='.$row->catid.'&id='.$row->id."&Itemid=".$this->get("Itemid"));
			$item->description 	= $row->ad_text;
			$item->date			= $row->date_created;
			$item->category   	= $row->parent." / ".$row->cat;
			$item->author		= $author;
			// loads item info into rss array
			$document->addItem( $item );
		}
	}
}
