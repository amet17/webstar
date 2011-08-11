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
 * Joom Joom spam killer Component skuser Model
 *
 * @package		Joomla
 * @subpackage	Joom spam killer
 * @since 1.5
 */
class SpamkillerModelMessage extends JModel
{
	/**
	 * Items id
	 *
	 * @var int
	 */
	var $_id = null;
	/**
	 * Items data
	 *
	 * @var array
	 */
	var $_data = null;

	/**
	 * Constructor
	 *
	 * @since 1.5
	 */
function __construct()
	{
		parent::__construct();
		$array = JRequest::getVar('cid', array(0), '', 'array');		
		if($array[0])
			$this->setId((int)$array[0]);
	}
	/**
	 * Method to set the skuser identifier
	 *
	 * @access	public
	 * @param	int Registration identifier
	 */
	function setId($id)
	{
		// Set skuser id and wipe data
		$this->_id		= $id;
		$this->_data	= null;
	}
		
	/**
	 * Method to get a skuser
	 *
	 * @since 1.5
	 */
	function &getData()
	{	
		$row = & JTable::getInstance('Spamkiller', 'Messages') ;			
		if (empty($this->_data)) {
			if ($this->_id)
				$row->load((int)$this->_id);					
			}
							
		return $row;
	}

	/**
	 * Load item data
	 *
	 */
	function _loadData() {
		$sql = 'SELECT * FROM #__sk_messages WHERE id='.$this->_id;
		$this->_db->setQuery($sql);			
		$this->_data = $this->_db->loadObject();
	}
	/**
	 * Method to remove  item
	 *
	 * @access	public
	 * @return	boolean	True on success
	 * @since	1.5
	 */
	function delete($cid = array())
	{		
		if (count( $cid ))
		{
			$cids =  implode(',', $cid);					 			 
			$sql = 'DELETE FROM #__sk_messages WHERE id IN ('.$cids.')';
			$this->_db->setQuery($sql);
			$this->_db->query();							
		}
		return true;
	}
	/**
	 * Publish or unpublish a item
	 *
	 * @param int $id
	 * @param int $state
	 */
	function publish($cid) {		
		$config = SpamkillerHelper::getConfig() ;
		$db = & JFactory::getDBO() ;
		$cids = implode(',', $cid) ;		
		$sql = 'SELECT a.*, b.userid FROM #__sk_messages AS a INNER JOIN #__fb_messages AS b ON a.message_id = b.id WHERE a.id IN ('.$cids.')';			
		$db->setQuery($sql) ;
		$rows = $db->loadObjectList() ;
		for ($i = 0 , $n = count($rows) ; $i < $n ; $i++) {
			$row = $rows[$i] ;
			if ($config->add_to_trusted_list) {
				//Check to see whether this user is in block list
				$userId = $row->userid ;
				$sql = 'SELECT COUNT(id) FROM #__sk_users WHERE user_id='.$userId ;
				$db->setQuery($sql) ;
				$total = $db->loadResult();
				if ($total) {
					$sql = 'UPDATE #__sk_users SET block = 0 WHERE user_id='.$userId;						
				} else {
					$sql = "INSERT INTO #__sk_users(id, user_id, block) values (NULL, $userId, 0)";	
				}				 									
				$db->setQuery($sql) ;		
				$db->query();
				//Unlock this user
				$sql = 'UPDATE #__users SET block=0 WHERE id='.$userId ;	
				$db->setQuery($sql) ;
				$db->query();
				//Unhold the message
				$sql = 'UPDATE #__fb_messages SET hold=0 WHERE id='.$row->message_id ;
				$db->setQuery($sql) ;
				$db->query();
			}
		}
		$sql = 'DELETE FROM #__sk_messages WHERE id IN ('.$cids.')' ;
		$db->setQuery($sql) ;
		$db->query();
	}
}