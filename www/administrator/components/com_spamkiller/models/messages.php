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
 * Spam Killer Component messages Model
 *
 * @package		Joomla
 * @subpackage	Spam Killer
 * @since 1.5
 */
class SpamkillerModelMessages extends JModel
{
	/**
	 * messages data array
	 *
	 * @var array
	 */
	var $_data = null;
	/**
	 * messages total
	 *
	 * @var integer
	 */
	var $_total = null;

	/**
	 * Pagination object
	 *
	 * @var object
	 */
	var $_pagination = null;

	/**
	 * Constructor
	 *
	 * @since 1.5
	 */
	function __construct()
	{
		parent::__construct();

		global $mainframe, $option;

		// Get the pagination request variables
		$limit		= $mainframe->getUserStateFromRequest( 'global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int' );
		$limitstart	= $mainframe->getUserStateFromRequest( $option.'.limitstart', 'limitstart', 0, 'int' );

		// In case limit has been changed, adjust limitstart accordingly
		$limitstart = ($limit != 0 ? (floor($limitstart / $limit) * $limit) : 0);

		$this->setState('limit', $limit);
		$this->setState('limitstart', $limitstart);
	}

	/**
	 * Method to get collections data
	 *
	 * @access public
	 * @return array
	 */
	function getData()
	{
		// Lets load the content if it doesn't already exist
		if (empty($this->_data))
		{
			$query = $this->_buildQuery();//echo $query;
			$this->_data = $this->_getList($query, $this->getState('limitstart'), $this->getState('limit'));					
		}
		return $this->_data;
	}

	/**
	 * Method to get the total number of item
	 *
	 * @access public
	 * @return integer
	 */
	function getTotal()
	{
		// Lets load the content if it doesn't already exist
		if (empty($this->_total))
		{	
			$where = $this->_buildContentWhere() ;
			$sql  = 'SELECT COUNT(id) FROM #__sk_messages AS a INNER JOIN #__fb_messages AS c ON a.user_id = c.id '.$where ;
			$this->_db->setQuery($sql);
			$this->_total = $this->_db->loadResult();
		}
		return $this->_total;
	}
	/**
	 * Method to get a pagination object for the collection
	 *
	 * @access public
	 * @return integer
	 */
	function getPagination()
	{
		// Lets load the content if it doesn't already exist
		if (empty($this->_pagination))
		{
			jimport('joomla.html.pagination');
			$this->_pagination = new JPagination( $this->getTotal(), $this->getState('limitstart'), $this->getState('limit') );
		}

		return $this->_pagination;
	}
	/**
	 * Build the select clause
	 *
	 * @return string
	 */
	function _buildQuery()
	{
		// Get the WHERE and ORDER BY clauses for the query
		$where		= $this->_buildContentWhere();
		$orderby	= $this->_buildContentOrderBy();		
		$query = ' SELECT a.* ,b.subject, d.message, b.hold, c.username FROM #__sk_messages AS a '
		        .' INNER JOIN #__fb_messages AS b ON a.message_id = b.id '
		        .' INNER JOIN #__users AS c ON b.userid = c.id '
		        .' INNER JOIN #__fb_messages_text AS d ON b.id = d.mesid '
			. $where			
			. $orderby
		;		
		return $query;
	}
	/**
	 * Build order by clause for the select command
	 *
	 * @return string order by clause
	 */
	function _buildContentOrderBy()
	{
		global $mainframe, $option;
		$filter_order		= $mainframe->getUserStateFromRequest( $option.'messages_filter_order',		'filter_order',		'c.username',	'cmd' );
		$filter_order_Dir	= $mainframe->getUserStateFromRequest( $option.'filter_order_Dir',	'filter_order_Dir',	'',				'word' );		
		$orderby = ' ORDER BY '.$filter_order.' '.$filter_order_Dir;		
		return $orderby;
	}
	/**
	 * Build the where clause
	 *
	 * @return string
	 */
	function _buildContentWhere()
	{
		global $mainframe, $option;
		$db					=& JFactory::getDBO();		
		$search				= $mainframe->getUserStateFromRequest( $option.'search',			'search',			'',				'string' );
		$search				= JString::strtolower( $search );					
		$where = array();			
		if ($search) {
			$where[] =  ' LOWER(c.username) LIKE '.$db->Quote( '%'.$db->getEscaped( $search, true ).'%', false )					   
						;		
		}		    	
		$where 		= ( count( $where ) ? ' WHERE '. implode( ' AND ', $where ) : '' );
		return $where;
	}	
}