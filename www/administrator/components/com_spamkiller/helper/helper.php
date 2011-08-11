<?php
/**
 * @version		1.0
 * @package		Joomla
 * @subpackage	Spam Killer
 * @author  Tuan Pham Ngoc
 * @copyright	Copyright (C) 2010 Ossolution Team
 * @license		GNU/GPL, see LICENSE.php
 */
class SpamkillerHelper {
	
	/**
	 * Get configuration data and store in config object
	 *
	 * @return object
	 */
	function getConfig($nl2br = true) {
		$db = & JFactory::getDBO();
		$config = new stdClass ;
		$sql = 'SELECT * FROM #__sk_configs';
		$db->setQuery($sql);
		$rows = $db->loadObjectList();
		for ($i = 0 , $n = count($rows); $i < $n; $i++) {
			$row = $rows[$i];
			$key = $row->config_key;
			$value = stripslashes($row->config_value);
			if ($nl2br)
				$value = nl2br($value); 
			$config->$key = $value;	
		}
		return $config;
	}
	/**
	 * Get specify config value
	 *
	 * @param string $key
	 */
	function getConfigValue($key) {
		$db = & JFactory::getDBO() ;
		$sql = 'SELECT config_value FROM #__sk_configs WHERE config_key="'.$key.'"';
		$db->setQuery($sql) ;
		return $db->loadResult();
	}	
	/**
	 * Get Itemid of Joom Donation
	 *
	 * @return int
	 */
	function getItemid() {
		$db = & JFactory::getDBO();
		$sql = "SELECT id FROM #__menu WHERE link LIKE '%index.php?option=com_spamkiller%'";
		$db->setQuery($sql) ;
		$itemId = $db->loadResult();		
		if (!$itemId) {
			global $Itemid ;
			if ($Itemid == 1)
				$itemId = 999999 ;
			else 
				$itemId = $Itemid ;	
		}			
		return $itemId ;	
	}

	function getAdminId() {
		$db = & JFactory::getDBO() ;
		$sql = 'SELECT id FROM #__users WHERE gid=25 AND block=0 ORDER BY id LIMIT 1' ;
		$db->setQuery($sql) ;
		return $db->loadResult();	
	}
}
?>