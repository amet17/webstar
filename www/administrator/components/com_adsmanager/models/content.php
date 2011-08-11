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
class AdsmanagerModelContent extends JModel
{
	function getContent($contentid,$onlyPublished = true) {
		$sql = "SELECT a.*, p.name as parent, p.id as parentid, c.name as cat, c.id as catid,u.username as user ".
			" FROM #__adsmanager_ads as a ".
			" INNER JOIN #__adsmanager_adcat as adcat ON adcat.adid = a.id ".
			" LEFT JOIN #__users as u ON a.userid = u.id ".
			" INNER JOIN #__adsmanager_categories as c ON adcat.catid = c.id ".
			" LEFT JOIN #__adsmanager_categories as p ON c.parent = p.id ";
    
  		$sql .= " WHERE a.id = ".(int)$contentid;
  		
  		if ($onlyPublished == true)
			$sql .= " AND c.published = 1 ";
			
		if (function_exists("updateQuery")) {
			updateQuery($sql);
		}
			
    	$this->_db->setQuery($sql);
    	$contents = $this->_db->loadObjectList();
    	
    	if (count($contents) > 0) {
    		$content = $contents[0];
    		$content->cats = array();
    		$content->catsid = array();
    		foreach($contents as $key => $c) {
    			$cat->parentid = $c->parentid;
    			$cat->parent = $c->parent;
    			$cat->cat = $c->cat;
    			$cat->catid = $c->catid;
    			$content->cats[] = $cat;
    			$content->catsid[] = $c->catid;
    		}
    		return $content;
    	}
    	else
    		return null;			
    }
    
	function _recurseSearch ($rows,&$list,$catid){
		if(isset($rows))
		{
			foreach($rows as $row) {
				if ($row->parent == $catid)
				{
					$list[]= $row->id;
					$this->_recurseSearch($rows,$list,$row->id);
				} 
			}
		}
	}
    
    function _getSQLFilter($filters){
   		 /* Filters */
    	$search = "";
    	if (isset($filters))
    	{
	    	foreach($filters as $key => $filter)
	    	{
	    		if ($search == "")
	    			$temp = " WHERE ";
	    		else
	    			$temp = " AND ";
	    		switch($key)
	    		{
	    			case 'category':
	    				$catid = $filter;
	    				$this->_db->setQuery( "SELECT c.id, c.name,c.parent ".
						" FROM #__adsmanager_categories as c ".
						 "WHERE c.published = 1 ORDER BY c.parent,c.ordering");
						 
						$listcats = $this->_db->loadObjectList();
						$list[] = $catid;
						$this->_recurseSearch($listcats,$list,$catid);
						$listids = implode(',', $list);
	    				$search .= $temp."c.id IN ($listids) ";break;
	    			case 'user':
	    				$search .= $temp."u.id = ".(int)$filter;break;
	    			case 'username':
	    				$search .= $temp."u.username LIKE '%".$this->_db->getEscaped($filter,true)."%'";break;
	    			case 'publish':
	    				$search .= $temp."a.published = ".(int)$filter;break;
	    			case 'fields':
	    				$search .= $temp.$filter;break;
	    			case 'search':
	    				$filter = JString::strtolower($filter);
	    				$search .= $temp."(LOWER(a.ad_headline) LIKE '%".$this->_db->getEscaped($filter,true)."%' OR LOWER(a.ad_text) LIKE '%".$this->_db->getEscaped($filter,true)."%')";break;
	    		}
	    	}
    	}
    	return $search;
    }
    
	function getContents($filters = null,$limitstart=null,$limit=null,$filter_order=null,$filter_order_Dir=null,$admin=0)
    {
    	$sql = "SELECT a.*, p.name as parent, p.id as parentid, c.name as cat, c.id as catid,u.username as user ".
			" FROM #__adsmanager_ads as a ".
			" INNER JOIN #__adsmanager_adcat as adcat ON adcat.adid = a.id ".
			" LEFT JOIN #__users as u ON a.userid = u.id ".
			" INNER JOIN #__adsmanager_categories as c ON adcat.catid = c.id ".
			" LEFT JOIN #__adsmanager_categories as p ON c.parent = p.id ";
    
  		$sql .= $this->_getSQLFilter($filters);
    	
    	$sql .= " GROUP BY a.id ORDER BY $filter_order $filter_order_Dir ";
    	
    	if (($admin == 0)&&(function_exists("updateQueryWithReorder")))
    		updateQueryWithReorder($sql);
    		
    	$this->_db->setQuery($sql,$limitstart,$limit);
    	$products = $this->_db->loadObjectList();
    	
		return $products;	
    }
    
	function getNbContents($filters = null)
    {
    	$sql = "SELECT a.id ".
			" FROM #__adsmanager_ads as a ".
			" INNER JOIN #__adsmanager_adcat as adcat ON adcat.adid = a.id ".
			" LEFT JOIN #__users as u ON a.userid = u.id ".
			" INNER JOIN #__adsmanager_categories as c ON adcat.catid = c.id ".
			" LEFT JOIN #__adsmanager_categories as p ON c.parent = p.id ";
    
  		/* Filters */
    	$sql .= $this->_getSQLFilter($filters);

    	$sql .= " GROUP BY a.id";

    	$this->_db->setQuery($sql);
    	
    	$result = $this->_db->loadObjectList();
    	$nb = count($result);
		return $nb;	
    }
    
	function increaseHits($contentid)
    {
		$sql = "UPDATE #__adsmanager_ads SET views = LAST_INSERT_ID(views+1) WHERE id = ".(int)$contentid;
		$this->_db->setQuery($sql);
		$this->_db->query();
    }
    
    function getLatestContents($nbcontents,$sort_type=0,$catselect="no")
    {
		switch($sort_type)
		{
			/* Popular */
			case 2:
				$order_sql = "ORDER BY a.views DESC,a.date_created DESC ,a.id DESC ";
				break;
				
			/* Random */
			case 1:
				$order_sql = "ORDER BY RAND() ";
				break;
				
			/* Latest */
			case 0: 
			default:
				$order_sql = "ORDER BY a.date_created DESC ,a.id DESC ";
				break;
		}
		
		$cat_query = "";
		switch($catselect)
		{
			case "no";
				break;
			
			case "-1":
				$catid = JRequest::getInt('catid', 0 );
				$this->_db->setQuery( "SELECT c.id, c.name,c.parent ".
								 " FROM #__adsmanager_categories as c ".
								 " WHERE c.published = 1 ORDER BY c.parent,c.ordering");			 
				$listcats = $this->_db->loadObjectList();
				//List	
				$list = array();
				$list[] = $catid;
				$this->_recurseSearch($listcats,$list,$catid);
				$listids = implode(',', $list);
				if (($catid != 0)&&($catid != -1))
				{
					$cat_query = "adcat.catid IN ($listids) AND ";
				}
				break;
			default:
				$cat_query = "adcat.catid = $catselect AND ";
				break;
		}
		
		$sql =  " SELECT a.*,p.id as parentid,p.name as parent,c.id as catid, c.name as cat,u.username as user ".
			    " FROM #__adsmanager_ads as a ".
				" INNER JOIN #__adsmanager_adcat as adcat ON adcat.adid = a.id ".
				" LEFT JOIN #__users as u ON a.userid = u.id ".
				" INNER JOIN #__adsmanager_categories as c ON adcat.catid = c.id ".
				" LEFT JOIN #__adsmanager_categories as p ON c.parent = p.id ".
				" WHERE $cat_query c.published = 1 and a.published = 1 GROUP BY a.id $order_sql LIMIT 0, $nbcontents";

		if (function_exists("updateQuery"))
    		updateQuery($sql);
    		
    	$this->_db->setQuery($sql);
    	
		$contents = $this->_db->loadObjectList();
		return $contents;
    }
	
	function getNbContentsOfUser($userid) {
		$this->_db->setQuery("SELECT count(*) FROM #__adsmanager_ads as a WHERE a.userid =".(int)$userid  );
		$nb = $this->_db-> loadResult();
		return $nb;
	}
    
	function renewContent($contentid,$ad_duration)
	{		
		$this->_db->setQuery( "UPDATE #__adsmanager_ads SET expiration_date = DATE_ADD(expiration_date, INTERVAL ".$ad_duration." DAY), date_created = CURDATE(),recall_mail_sent=0 WHERE id=".(int)$contentid." and recall_mail_sent = 1");
		$this->_db->query();
	}
	
	function sendExpirationEmail($content,$itemid,$conf)
	{
		if ($content->email) {
			$baseurl = JURI::base();
			$link = JRoute::_($baseurl."/index.php?option=com_adsmanager&view=expiration&id=".$content->id."&Itemid=".$itemid);
			$body = $conf->recall_text;
			$body .= sprintf(JText::_('ADSMANAGER_EXPIRATION_MAIL_BODY'),$content->ad_headline,$conf->recall_time,$link,$link);
			
			$config	= &JFactory::getConfig();
			$from		= $config->getValue('mailfrom');
			$fromname	= $config->getValue('fromname');
			$sitename	= $config->getValue('sitename');
			
			// Send the e-mail to Administrator
			if (!JUtility::sendMail($from, $fromname, $content->email, $sitename." / ".JText::_('ADSMANAGER_EXPIRATION_MAIL'),$body,1))
			{
				$this->setError(JText::_('ADSMANAGER_ERROR_SENDING_MAIL'));
				return false;
			}
		}
	}
	
	function manage_expiration($itemid,$plugins,$conf)
	{
		if ($conf->expiration == 1)
		{
			if ($conf->recall == 1)
			{
				$this->_db->setQuery( "SELECT id,email,ad_headline FROM #__adsmanager_ads WHERE DATE_SUB(expiration_date, INTERVAL ".$conf->recall_time." DAY) < CURDATE() AND recall_mail_sent = 0");
				$contents = $this->_db->loadObjectList();
				
				if (isset($contents))
				{
					foreach($contents as $content)
					{
						$this->sendExpirationEmail($content,$itemid,$conf);
					}
				}
				$this->_db->setQuery( "UPDATE #__adsmanager_ads SET recall_mail_sent = 1 WHERE DATE_SUB(expiration_date, INTERVAL ".$conf->recall_time." DAY) < CURDATE() AND recall_mail_sent = 0");
				$this->_db->query();

				$this->_db->setQuery( "SELECT id FROM #__adsmanager_ads WHERE recall_mail_sent = 1 AND expiration_date < CURDATE()");
				$idsarray = $this->_db->loadResultArray();
				if (isset($idsarray) && count($idsarray) > 0) {
					foreach($idsarray as $id)
					{
						$content =& JTable::getInstance('content', 'AdsmanagerTable');
						$content->delete($id,$conf,$plugins);
					}
				}
			}	
			else
			{		
				$this->_db->setQuery( "SELECT id FROM #__adsmanager_ads WHERE expiration_date < CURDATE()");
				$idsarray = $this->_db->loadResultArray();
				if (isset($idsarray) && count($idsarray) > 0) {
					foreach($idsarray as $id)
					{
						$content =& JTable::getInstance('content', 'AdsmanagerTable');
						$content->delete($id,$conf,$plugins);
					}
				}
			}
		}
		$last_cron_date = date("Ymd");
		$Fnm = JPATH_BASE .'/components/com_adsmanager/cron.php';
	    jimport( 'joomla.filesystem.file' );
	    $content = '<?php $last_cron_date='.$last_cron_date.';?>';
		JFile::write( $Fnm, $content );
	}
	
	function getListOrder($order,&$filter_order,&$filter_order_Dir)
    {
	    if ($order != 0)
		{
			$this->_db->setQuery( "SELECT f.name,f.sort_direction,f.type FROM #__adsmanager_fields AS f WHERE f.fieldid=".(int)$order." AND f.published = 1" );
			$sort = $this->_db->loadObject();
			if (($sort->type == "number")||($sort->type == "price")) {
				$filter_order = "a.".$sort->name." * 1";
				$filter_order_Dir= $sort->sort_direction;
			}
			else {
				$filter_order = "a.".$sort->name;
				$filter_order_Dir= $sort->sort_direction;
			}
		}
		else 
		{
			$filter_order = "a.date_created DESC ,a.id ";
			$filter_order_Dir= "DESC";
		}
		
    }
}