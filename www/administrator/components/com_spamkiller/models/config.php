<?php
/**
 * @version		1.0
 * @package		Joomla
 * @subpackage	Spam Killer
 * @author  Tuan Pham Ngoc
 * @copyright	Copyright (C) 2010 Ossolution Team
 * @license		GNU/GPL, see LICENSE.php
 */
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );
jimport('joomla.application.component.model');
/**
 * Spamkiller Component Config Model
 *
 * @package		Joomla
 * @subpackage	Spamkillers
 * @since 1.5
 */
class SpamkillerModelConfig extends JModel
{
	/**
	 * Containing all config data,  store in an object with key, value
	 *
	 * @var object
	 */
	var $_data = null;
	
	function __construct() {
		parent::__construct();
	}
	
	/**
	 * Get configuration data
	 *
	 */
	function getData() {
		if (empty($this->_data)) {
			$config = new stdClass ;
			$sql = 'SELECT config_key, config_value FROM #__sk_configs';
			$this->_db->setQuery($sql);
			$rows = $this->_db->loadObjectList();
			if (count($rows)) {
				for ($i = 0, $n = count($rows); $i < $n; $i++) {
					$row = $rows[$i];
					$key = $row->config_key;
					$value = $row->config_value;
					$config->$key = stripslashes($value);						
				}	
			} else {
				$config->special_user_ids = null ;
				$config->akismet_api_key = null ;
				$config->send_email_to_user = null ;
				$config->send_email_to_administrator = null ;
				$config->admin_email_subject = null ;
				$config->admin_email_body = null ;
				$config->user_email_subject = null ;
				$config->user_email_body = null ;
				$config->add_to_trusted_list = null ;
				$config->add_to_block_list = null ;
				$config->block_spammer = null ;						 																															
			}
			$this->_data = $config;		
		}			
		return $this->_data ;
	}
	
	/**
	 * Store the configuration data
	 *
	 * @param array $post
	 */
	
	function store($data) {
		$sql = 'TRUNCATE TABLE #__sk_configs';
		$this->_db->setQuery($sql);
		$this->_db->query();
		foreach ($data as $key=>$value) {
			$configKey = $this->_db->Quote($key);
			$configValue = $this->_db->Quote($value);
			$sql = 'INSERT INTO #__sk_configs (config_key, config_value) VALUES('.$configKey.','.$configValue.')';			
			$this->_db->setQuery($sql);
			if (!$this->_db->query())
				return false;			
		}
		return true;
	}
}