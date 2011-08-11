<?php
/**
 * @version		1.0
 * @package		Joomla
 * @subpackage	Spamkiller
 * @author  Tuan Pham Ngoc
 * @copyright	Copyright (C) 2010 Ossolution Team
 * @license		GNU/GPL, see LICENSE.php
 */
/** ensure this file is being included by a parent file */
defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );
/**
 * Change the db structure of the previous version
 *
 */
function com_install( ) {
	$db = & JFactory::getDBO();	
	//Load config config data	
	$sql = 'SELECT COUNT(*) FROM #__sk_configs';
	$db->setQuery($sql) ;
	$total = $db->loadResult();
	if (!$total) {
		jimport('joomla.filesystem.file') ;
		$configSql = JPATH_ADMINISTRATOR.DS.'components'.DS.'com_spamkiller'.DS.'config.spamkiller.sql' ;
		$sql = JFile::read($configSql) ;
		$queries = $db->splitSql($sql);
		if (count($queries)) {
			foreach ($queries as $query) {
			if ($query != '' && $query{0} != '#') {
					$db->setQuery($query);
					$db->query();						
				}	
			}
		}
	}	
}