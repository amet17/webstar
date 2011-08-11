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
jimport( 'joomla.application.component.view');
/**
 * HTML View class for Spam Killers component
 *
 * @static
 * @package		Joomla
 * @subpackage	Spam Killer
 * @since 1.5
 */
class SpamkillerViewSkusers extends JView
{

	function display($tpl = null)
	{		
		global $mainframe, $option;			 					
		$filter_order		= $mainframe->getUserStateFromRequest( $option.'skusers_filter_order',		'filter_order',		'a.id',	'cmd' );
		$filter_order_Dir	= $mainframe->getUserStateFromRequest( $option.'filter_order_Dir',	'filter_order_Dir',	'',				'word' );										
		$search				= $mainframe->getUserStateFromRequest( $option.'search',			'search',			'',				'string' );
		$search				= JString::strtolower( $search );				
		$lists['search'] = $search;					
		$items		= & $this->get( 'Data'); //echo $items;	
		$pagination = & $this->get( 'Pagination' );		
		$lists['order_Dir'] = $filter_order_Dir;
		$lists['order'] = $filter_order;				
		$this->assignRef('lists',		$lists);
		$this->assignRef('items',		$items);
		$this->assignRef('pagination',	$pagination);
		parent::display($tpl);				
	}
}