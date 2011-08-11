<?php
/**
 * @version		1.0
 * @package		Joomla
 * @subpackage	Spam Killers
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
 * @subpackage	Spam Killers
 * @since 1.5
 */

class SpamkillerViewConfig extends JView{
	function display($tpl = null){		
		$config = & $this->get('Data');	
		$lists['send_email_to_user'] = JHTML::_('select.booleanlist', 'send_email_to_user', '', $config->send_email_to_user);
		$lists['send_email_to_administrator'] = JHTML::_('select.booleanlist', 'send_email_to_administrator', '', $config->send_email_to_administrator);
		$lists['add_to_trusted_list'] = JHTML::_('select.booleanlist', 'add_to_trusted_list', '', $config->add_to_trusted_list);		
		$lists['add_to_block_list'] = JHTML::_('select.booleanlist', 'add_to_block_list', '', $config->add_to_block_list);		
		$lists['block_spammer'] = JHTML::_('select.booleanlist', 'block_spammer', '', $config->block_spammer);						
		$this->assignRef('config', $config) ;
		$this->assignRef('lists', $lists) ;
		parent::display($tpl);			
	}
}