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
 * Spam killer Component skuser Model
 *
 * @package		Joomla
 * @subpackage	Spam killer
 * @since 1.5
 */
class SpamkillerModelSkuser extends JModel
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
		$row = & JTable::getInstance('Spamkiller', 'Table') ;			
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
		$sql = 'SELECT * FROM #__sk_users WHERE id='.$this->_id;
		$this->_db->setQuery($sql);			
		$this->_data = $this->_db->loadObject();
	}	
	/**
	 * Publish or unpublish a item
	 *
	 * @param int $id
	 * @param int $state
	 */
	function publish($cid) {
		$cids = implode(',', $cid) ;		
		$sql = 'UPDATE #__sk_users SET block=0 WHERE id IN ('.$cids .' )';		
		$this->_db->setQuery($sql);
		$this->_db->query() ;		
		$sql = 'SELECT user_id FROM #__sk_users WHERE id IN ('.$cids.')';
		$this->_db->setQuery($sql) ;
		$userIds = $this->_db->loadResultArray();
		$sql = 'UPDATE #__users SET block = 0 WHERE id IN ('.implode(',', $userIds) .' )';		
		$this->_db->setQuery($sql);
		$this->_db->query() ;							
		return true ;
	}
	/**
	 * Delete the selected user
	 *
	 */
	function delete($cid) {
		$cids = implode(',', $cid) ;		
		$sql = 'UPDATE #__sk_users SET hide=1 WHERE id IN ('.$cids .' )';		
		$this->_db->setQuery($sql);
		$this->_db->query() ;
		return true ;
	}
}