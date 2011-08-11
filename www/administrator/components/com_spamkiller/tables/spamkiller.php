<?php
/**
 * @version		1.0
 * @package		Joomla
 * @subpackage	Spam Killer
 * @author  Tuan Pham Ngoc
 * @copyright	Copyright (C) 2010 Ossolution Team
 * @license		GNU/GPL, see LICENSE.php
 */
defined('_JEXEC') or die('Restricted access');
/**
* jos_sk_users table class
*
* @package		Joomla
* @subpackage	spam killers
* @since 1.5
*/
class TableSpamkiller extends JTable
{
	/**
	 * Primary Key
	 *
	 * @var int
	 */
	var $id = null;
	/**
	 * Name of the Subaru email
	 *
	 * @var string
	 */
	var $user_id = null;	
	/**
	 * block
	 * @var tinyint
	 */
	var $block = 0;
	
	/**
	 * Constructor
	 *
	 * @param object Database connector object
	 * @since 1.5
	 */
	function __construct(& $db) {
		parent::__construct('#__sk_users', 'id', $db);
	}
}
class ConfigSpamkiller extends JTable
{
	/**
	 * Primary Key
	 *
	 * @var int
	 */
	var $id = null;
	/**
	 * Name of the Subaru email
	 *
	 * @var string
	 */
	var $config_key = null;	
	/**
	 * description of the category  
	 * @var string
	 */
	var $config_value = null;
		/**
	 * Constructor
	 *
	 * @param object Database connector object
	 * @since 1.5
	 */
	function __construct(& $db) {
		parent::__construct('#__sk_configs', 'id', $db);
	}
}
class MessagesSpamkiller extends JTable
{
	/**
	 * Primary Key
	 *
	 * @var int
	 */
	var $id = null;
	/**
	 * Name of the Subaru email
	 *
	 * @var string
	 */
	var $message_id = null;	
		/**
	 * Constructor
	 *
	 * @param object Database connector object
	 * @since 1.5
	 */
	function __construct(& $db) {
		parent::__construct('#__sk_messages', 'id', $db);
	}
}

