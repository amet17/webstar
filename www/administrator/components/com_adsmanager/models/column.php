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
class AdsmanagerModelColumn extends JModel
{
	function getColumn($id)
	{
		$query = "SELECT * FROM #__adsmanager_columns WHERE id = ".(int)$id;
		$this->_db->setQuery($query);	 
		$column = $this->_db->loadObject();
		return $column;
	}
	
    function getColumns($catid,$all=false) {
    	$this->_db->setQuery("SELECT c.* ".
							"FROM #__adsmanager_columns as c ".
							"ORDER BY c.ordering ");
    	$columns = $this->_db->loadObjectList();
    	if ($all == true)
    		return $columns;
    		
    	if (isset($columns))
		{
			$licz=0;
			$col = array();
			
			foreach ($columns as $c ) {
				
				if ($c->catsid == ",-1,")				
					array_push( $col, $c );
				else 
				{	
					if ($catid != null) {
						$find = ",".$catid.",";
						if (strstr($c->catsid, $find))
							array_push( $col, $c );
					}
				}
			}
		}
		
		unset($columns);
		$columns = $col;
	
		return $columns;
    }
}