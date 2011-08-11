<?php
/**
* @author Martin Herbst - http://www.mherbst.de
* @email webmaster@mherbst.de
* @package Xmap
* @license GNU/GPL
* @description Xmap plugin for K2 component
*
* Changes:
* + 0.51   2009/08/21  Do not show deleted items resp. categories
* + 0.60   2009/08/21  New options "Show K2 Items" added
* # 0.65   2009/09/28  Correct modification date now shown in XML sitemap 
* # 0.66   2009/10/07  Small bugfix to avoid PHP Notice:  Undefined variable
* # 0.67   2010/01/30  Small bugfix to avoid PHP warnings in case of null returned from queries
* + 0.80   2010/02/07  Support of new features of K2 2.2
* + 0.81   2010/02/19  Modified date was not correct for all items
* + 0.85   2010/04/11  New option to avoid duplicate items
*                      Change the date format if used together with SEFServiceMap
* # 0.86   2010/05/24  Expired items are no longer contained in the site map
* # 0.86   2010/05/24  Expired items are no longer contained in the site map
*                      Warnings regarding undefined properties solved
* # 0.90   2010/08/14  User rights are now taken into account (reported by http://walplanet.com)
* # 0.91   2010/08/21  Bugfix: wrong SQL statement created 
* # 0.92   2010/10/13  Fixed a bug if last users or last categories has no entries
* + 0.93   2010/11/28  Add support for Google News sitemap
*/

defined( '_VALID_MOS' ) or defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

/** Adds support for K2  to Xmap */
class xmap_com_k2 
{
	static $maxAccess = 0;
	/** Get the content tree for this kind of content */
	function getTree( &$xmap, &$parent, &$params ) 
	{
		$tag=null;
		$limit=null;
		$id = null;
		$link_query = parse_url( $parent->link );
		parse_str( html_entity_decode($link_query['query']), $link_vars);
		parse_str(str_replace("\n", "&", $parent->params), $parm_vars);
	
		$option = xmap_com_k2::getParam($link_vars,'option',"");
		if ($option != "com_k2")
			return;

		$view = xmap_com_k2::getParam($link_vars,'view',"");
		$showMode = xmap_com_k2::getParam($params, 'showk2items', "always");
		if (xmap_com_k2::getParam($params,'suppressdups', 'yes') == "yes")
			$suppressDups = true;
		else
			$suppressDups = false;
		
		if ($showMode == "never" || ($showMode == "xml" && $xmap->view == "html") || ($showMode == "html" && $xmap->view == "xml"))			
			return;

		if ($view == "item")   // for Items the sitemap already contains the correct reference
		{
			$xmap->IDS = $xmap->IDS."|".xmap_com_k2::getParam($link_vars, 'id', $id);
			return;
		}

		if ($xmap->view == "xml")
			self::$maxAccess = 0;   // XML sitemaps will only see content for guests
		else
			self::$maxAccess = xmap_com_k2::getMaxAccess();

			switch(xmap_com_k2::getParam($link_vars,'task',""))
		{
			case "user":
				$ids = explode("|", xmap_com_k2::getParam($link_vars, 'id', $id));	
				$mode = "single user";
				break;
			case "tag":
				$tag = xmap_com_k2::getParam($link_vars, 'tag',"");			
				$ids = explode("|", xmap_com_k2::getParam($parm_vars, 'categoriesFilter',""));
				$mode = "tag";
				break;
			case "category":
				if (xmap_com_k2::getParam($params,'subcategories',"yes") == "yes")
					$suppressSub = "0";
				else
					$suppressSub = "1";
				$ids = explode("|", xmap_com_k2::getParam($link_vars, 'id',""));
				$mode = "category";
				break;	
			case "":
				switch(xmap_com_k2::getParam($link_vars,'layout',""))
				{
					case "category":
						$suppressSub = xmap_com_k2::getParam($parm_vars, 'catCatalogMode',"");	
						$ids = explode("|", xmap_com_k2::getParam($parm_vars, 'categories',$id));
						$mode = "categories";
						break;
					case "latest":
						$limit = xmap_com_k2::getParam($parm_vars, 'latestItemsLimit', "");
						if (xmap_com_k2::getParam($parm_vars, 'source', "") == "0")
						{
							$ids = explode("|", xmap_com_k2::getParam($parm_vars, 'userIDs', ""));	
							$mode = "latest user";
						}
						else
						{
							$ids = explode("|", xmap_com_k2::getParam($parm_vars, 'categoryIDs',$id));
							$mode = "latest category";
						}
						break;
					default:
						return;
				}
				break;
			default:
				return;
		}
		$priority 					= 	xmap_com_k2::getParam($params,'priority',$parent->priority);
		$changefreq 				= 	xmap_com_k2::getParam($params,'changefreq',$parent->changefreq);
		if ($priority  == '-1')
			$priority 				= 	$parent->priority;
		if ($changefreq  == '-1')
			$changefreq 			= 	$parent->changefreq;

		$params['priority'] 		= 	$priority;
		$params['changefreq'] 		= 	$changefreq;
		
		$db = &JFactory::getDBO();
		xmap_com_k2::processTree($db, $xmap, $parent, $params, $mode, $ids, $tag, $limit, $suppressSub, $suppressDups);

		return;
	}

	function collectByCat($db, $catid, &$allrows)
	{
		if (trim($catid) == "") // in this case something strange went wrong
			return;
		$query = "select id,title,alias,UNIX_TIMESTAMP(created) as created, UNIX_TIMESTAMP(modified) as modified, metakey from  #__k2_items where "
								."published = 1 and trash = 0 and (publish_down =  \"0000-00-00\" OR publish_down > NOW()) "
								."and catid = ".$catid. " order by 1 desc";
		$db->setQuery($query);
		$rows = $db->loadObjectList();
		if ($rows == null)
			return;
		$allrows = array_merge($allrows, $rows);
		
		foreach ($rows as $row)
		{
			$query = "select id, name, alias  from #__k2_categories where published = 1 and trash = 0 and parent = ".$catid." order by id";
			$db->setQuery($query);
			$rows = $db->loadObjectList();
			if ($rows == null)
				$rows = array();

			foreach ($rows as $row)
			{
				xmap_com_k2::collectByCat($db, $row->id, $allrows);
			}
		}
	}
	
	function processTree($db, &$xmap, &$parent, &$params, $mode, $ids, $tag, $limit, $suppressSub, $suppressDups)
	{
		if (isset($params['publishup']) && $params['publishup'] == "no") {
			$publishup = "and (publish_up =  \"0000-00-00\" OR publish_up < NOW())";
			} else {$publishup="";}
		
		$baseQuery = "select id,title,alias,UNIX_TIMESTAMP(created) as created, UNIX_TIMESTAMP(modified) as modified, metakey from  #__k2_items where "
									."published = 1 and trash = 0 and (publish_down =  \"0000-00-00\" OR publish_down > NOW()) ".$publishup." and "
									."access <= ".self::$maxAccess." and ";
		switch($mode)
		{
			case "single user":
				$query = $baseQuery."created_by = ".$ids[0]." order by 1 DESC ";
				$db->setQuery($query);
				$rows = $db->loadObjectList();
				break;
			case "tag":
				$query = "SELECT c.id, title, alias, UNIX_TIMESTAMP(c.created) as created, UNIX_TIMESTAMP(c.modified) as modified FROM #__k2_tags a, #__k2_tags_xref b, #__k2_items c where " 										."c.published = 1 and c.trash = 0 and (c.publish_down =  \"0000-00-00\" OR c.publish_down > NOW()) "
										 ."and a.Name = '".$tag."' and a.id =  b.tagId and c.id = b.itemID and c.access <= ".self::$maxAccess;
				if ($ids[0] != "")
					$query .= "and c.catid in (".implode(",", $ids).")";
				$query .= " order by 1 DESC ";
				$db->setQuery($query);
				$rows = $db->loadObjectList();
				break;
			case "category":
				$query = $baseQuery."catid = ".$ids[0]." order by 1 DESC ";
				$db->setQuery($query);
				$rows = $db->loadObjectList();
				break;
			case "categories":
				if ($suppressSub == "1")
				{
					$query = $baseQuery."catid in (".implode(",", $ids).") order by 1 DESC ";
					$db->setQuery($query);
					$rows = $db->loadObjectList ();
				}
				else 
				{
					$rows = array();
					foreach($ids as $id)
					{
						$allrows = array();
						xmap_com_k2::collectByCat($db, $id, $allrows);
						$rows = array_merge($rows, $allrows);
					}		
				}
				break;
			case "latest user":
				$rows = array();
				foreach ($ids as $id)
				{
					$query = $baseQuery."created_by = ".$id." order by 1 DESC LIMIT ".$limit;
					$db->setQuery($query);
					$res = $db->loadObjectList();
					if ($res != null)
						$rows = array_merge($rows, $res);
				}
				break;
			case "latest category":
				$rows = array();
				foreach ($ids as $id)
				{
					$query = $baseQuery."catid = ".$id." order by 1 DESC LIMIT ".$limit;
					$db->setQuery($query);
					$res = $db->loadObjectList();
					if ($res != null)
						$rows = array_merge($rows, $res);
				}
				break;
			default:
				return;
		}
		$sef = ($_REQUEST['option'] == "com_sefservicemap");

		$xmap->changeLevel(1);
		$node = new stdclass ();
		$node->id = $parent->id;

		if ($rows == null)
			$rows = array();
		foreach ($rows as $row ) 
		{
			if ($suppressDups && isset($xmap->IDS) && strstr($xmap->IDS, "|".$row->id))
			{
			}
			else 
			{
				if ($xmap->isNews && ($row->modified ? $row->modified : $row->created) > ($xmap->now - (2 * 86400))) 
				{
					$node->newsItem = 1;
					$node->keywords = $row->metakey;
				}
				else 
				{
					$node->newsItem = 0;
					$node->keywords = "";
				}
				$xmap->IDS .= "|".$row->id;
				$node->browserNav = $parent->browserNav;
				$node->pid = $row->id;
				$node->uid = $parent->uid . 'item' . $row->id;
				$node->modified = ($row->modified ? $row->modified : $row->created);
				if ($sef)
					$node->modified = date('Y-m-d',$node->modified);
				$node->name = $row->title;
				$node->priority = $params['priority'];
				$node->changefreq = $params['changefreq'];

				$node->link = 'index.php?option=com_k2&view=item&id='.$row->id.':'.$row->alias;
				$node->expandible = false;
				$node->tree = array ();
				$xmap->printNode($node);
			}
		}
		
		if ($mode == "category" && $suppressSub == "0")
		{
			$query = "select id, name, alias  from #__k2_categories where published = 1 and trash = 0 and parent = ".$ids[0]
								." and access <= ".self::$maxAccess." order by id";
			$db->setQuery($query);
			$db->setQuery($query);
			$rows = $db->loadObjectList();
			if ($rows == null)
				$rows = array();

			foreach ($rows as $row)
			{
				if ($suppressDups && strstr($xmap->IDS, "|c".$row->id))
				{
				}
				else
				{
					if ($xmap->isNews && ($row->modified ? $row->modified : $row->created) > ($xmap->now - (2 * 86400))) 
					{
						$node->newsItem = 1;
						$node->keywords = $row->metakey;
					}
					else 
					{
						$node->newsItem = 0;
						$node->keywords = "";
					}
					$xmap->IDS .= "|c".$row->id;
					$node->browserNav = $parent->browserNav;
					$node->pid = $row->id;
					$node->uid = $parent->uid.'item'.$row->id;
					$node->name = $row->name;
					$node->modified = (isset($row->modified) ? $row->modified : (isset($row->created) ? $row->created : null));
					if ($sef)
						$node->modified = date('Y-m-d',$node->modified);
					
					$node->priority = $params['priority'];
					$node->changefreq = $params['changefreq'];
					$node->link = 'index.php?option=com_k2&view=itemlist&task=category&id='.$row->id.':'.$row->alias;
					$node->expandible = true;
					$node->tree = array ();
					$xmap->printNode($node);
					
					$newID = array();
					$newID[0] = $row->id;
					xmap_com_k2::processTree($db, $xmap, $parent, $params, $mode, $newID, "", "", "0", $suppressDups);
				}
			} 
		}
		$xmap->changeLevel (-1);
	}
	function &getParam($arr, $name, $def) 
	{
		$var 		= 	JArrayHelper::getValue( $arr, $name, $def, '' );
		return $var;
	}
	
	function getMaxAccess()
	{
		$user =& JFactory::getUser();
		if ($user->guest)
			return 0;
		if (strtolower($user->usertype) == "registered")
			return 1;
		// All others are allowed to see entries with authorization "Special"
		return 2;
	}
}
?>