<?php
/**
 * @package		AdsManager
 * @copyright	Copyright (C) 2010-2011 JoomPROD.com. All rights reserved.
 * @license		GNU/GPL
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );

jimport('joomla.application.component.model');
JTable::addIncludePath(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_adsmanager'.DS.'tables');

/**
 * @package		Joomla
 * @subpackage	Contact
 */
class AdsmanagerModelCategory extends JModel
{
	function getCategory($id) {
    	$this->_db->setQuery( "SELECT * FROM #__adsmanager_categories WHERE id = ".(int)$id);
		$cat = $this->_db->loadObject();
		return $cat;
    }
    
	function getCategories($onlyPublished = true) {
		
		if ($onlyPublished == true)
			$published = " c.published = 1 ";
		else
			$published = " 1 ";
    	$this->_db->setQuery( "SELECT c.* FROM #__adsmanager_categories as c ".
							 "WHERE $published ORDER BY c.parent,c.ordering");
		$cats = $this->_db->loadObjectList();
		return $cats;
    }
    
	function getPathList($catid,$itemid=0){
		$cats = $this->getCategories();
		$orderlist = array();
		$list = array();
		if(isset($cats))
		{
			foreach ($cats as $c ) {
				$orderlist[$c->id] = $c;
			}
		
			if (($catid != -1)&&($catid != 0))
			{
				$i=0;
				$list[$i]->text   = $orderlist[$catid]->name;
				$list[$i]->link   = JRoute::_('index.php?option=com_adsmanager&view=list&catid='.$catid.'&Itemid='.$itemid);
				$i++;
		
				$current = $catid;
				
				while($orderlist[$current]->parent != 0)
				{
					$current = $orderlist[$current]->parent;
					$list[$i]->text   = $orderlist[$current]->name;
					$list[$i]->link   = JRoute::_('index.php?option=com_adsmanager&view=list&catid='.$orderlist[$current]->id.'&Itemid='.$itemid);
					$i++;	
				}
			}
		}
		$nb = count($list);
		if ($catid == 0) {
			$list[$nb]->link = JRoute::_('index.php?option=com_adsmanager&view=front&Itemid='.$itemid);
		} else
			$list[$nb]->link = JRoute::_('index.php?option=com_adsmanager&view=list&Itemid='.$itemid);
		$list[$nb]->text = JText::_('ADSMANAGER_ROOT_TITLE');
		
		return $list;
	}
    
    function getSubCats($parentid) {
    	$this->_db->setQuery( "SELECT c.* FROM #__adsmanager_categories as c ".
							 "WHERE c.parent = ".(int)$parentid." AND c.published = 1 ORDER BY c.ordering");
		$cats = $this->_db->loadObjectList();
		return $cats;
    }
    
	function getNbCats($onlyPublished = true)
	{
		if ($onlyPublished == true)
			$published = " c.published = 1 ";
		else
			$published = " 1 ";
			
		$query =  " SELECT count(*) FROM #__adsmanager_categories as c ".
				  " WHERE $published";
		$this->_db->setQuery($query);				 
		$nb = $this->_db->loadResult();
		return $nb;
	}
	
	function getCatTree($onlyPublished = true,$getnbads = false,&$nbcontents=null) {
		
		if ($onlyPublished == true)
			$published = " c.published = 1 ";
		else
			$published = " 1 ";

		$query = " SELECT c.* FROM #__adsmanager_categories as c WHERE $published "
		       . " ORDER BY c.parent,c.ordering,c.id";
		$this->_db->setQuery($query);			 
		$list = $this->_db->loadObjectList(); 
		
		if ($getnbads != null) 
		{		
			$query  = " SELECT ac.catid,ac.adid "
				    . " FROM #__adsmanager_adcat as ac"
				    . " INNER JOIN #__adsmanager_ads as a ON a.id = ac.adid "
				    . " WHERE a.published = 1 ";
			$this->_db->setQuery($query);			 
			$listads = $this->_db->loadObjectList();
			$listadsbycat = array();
			foreach($listads as $ad) {
				if (!isset($listadsbycat[$ad->catid]))
					$listadsbycat[$ad->catid] = array();
				$listadsbycat[$ad->catid][] = $ad->adid;
			}
		}
		  					 
		// establish the hierarchy of the menu
		$tree = array();
		// first pass - collect children
		if(isset($list))
		{
			foreach ($list as $v ) {
				$pt 	= $v->parent;
				$list_temp 	= @$tree[$pt] ? $tree[$pt] : array();
				if (isset($listadsbycat[$v->id]))
					$v->ads = $listadsbycat[$v->id];
				else
					$v->ads = array();
				array_push( $list_temp, $v );
				$tree[$pt] = $list_temp;
			}
		}
		
		if ($getnbads != null) 
		{
			$nbcontents = count($this->calc_nb_ads(0,$tree));	
		}
		
		return $tree;
	}

	function calc_nb_ads($id,&$cats) {
		$ads = array();
		if (@$cats[$id]) {	
			$nb = count($cats[$id]);
			for($i=0;$i < $nb;$i++)
			{
				$cats[$id][$i]->ads = array_unique(array_merge($cats[$id][$i]->ads, $this->calc_nb_ads($cats[$id][$i]->id,$cats)));			
				$cats[$id][$i]->num_ads = count($cats[$id][$i]->ads);		
				$ads = array_unique(array_merge($ads,$cats[$id][$i]->ads));
			}
		}
		return $ads;
	}
	
	function recurseSearch ($rows,&$list,$catid){
		if(isset($rows))
		{
			foreach($rows as $row) {
				if ($row->parent == $catid)
				{
					$list[]= $row->id;
					$this->recurseSearch($rows,$list,$row->id);
				} 
			}
		}
	}
}