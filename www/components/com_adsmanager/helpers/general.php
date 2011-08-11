<?php
/**
 * @package		AdsManager
 * @copyright	Copyright (C) 2010-2011 JoomPROD.com. All rights reserved.
 * @license		GNU/GPL
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

/**
 * Content Component HTML Helper
 *
 * @static
 * @package		Joomla
 * @subpackage	Content
 * @since 1.5
 */
class JHTMLAdsmanagerGeneral
{
	var $catid;
	var $comprofiler;
	var $itemid;
	var $user;
	
	function __construct($catid,$comprofiler,$user,$itemid)
	{
		$this->catid = $catid;
		$this->comprofiler = $comprofiler;
		$this->itemid = $itemid;
		$this->user = $user;
	}
	
	function showGeneralLink()
	{	
	?>
		<div id="adsmanager_innermenu">
		<?php 
			if ($this->catid == 0)
				$link_write_ad = JRoute::_("index.php?option=com_adsmanager&task=write&Itemid=".$this->itemid);
			else
				$link_write_ad = JRoute::_("index.php?option=com_adsmanager&task=write&catid=$this->catid&Itemid=".$this->itemid);
							
			switch($this->comprofiler)
			{
				case 2: 
					$link_show_profile = JRoute::_("index.php?option=com_comprofiler&task=userDetails&Itemid=".$this->itemid);
					$link_show_user = JRoute::_("index.php?option=com_comprofiler&task=showProfile&tab=AdsManagerTab&Itemid=".$this->itemid);
					break;
				case 1:
					$link_show_profile = JRoute::_("index.php?option=com_comprofiler&task=profile&Itemid=".$this->itemid);
					$link_show_user = JRoute::_("index.php?option=com_adsmanager&view=list&user=".$this->user->id."&Itemid=".$this->itemid);
					break;
				default:
					$link_show_profile = JRoute::_("index.php?option=com_adsmanager&view=profile&Itemid=".$this->itemid);
					$link_show_user = JRoute::_("index.php?option=com_adsmanager&view=list&user=".$this->user->id."&Itemid=".$this->itemid);
					break;
			}
		
			$link_show_rules = JRoute::_("index.php?option=com_adsmanager&view=rules&Itemid=".$this->itemid);
			$link_show_all = JRoute::_("index.php?option=com_adsmanager&view=list&Itemid=".$this->itemid);
			echo '<a href="'.$link_write_ad.'">'.JText::_('ADSMANAGER_MENU_WRITE').'</a> | ';
			echo '<a href="'.$link_show_all.'">'.JText::_('ADSMANAGER_MENU_ALL_ADS').'</a> | ';
			echo '<a href="'.$link_show_profile.'">'.JText::_('ADSMANAGER_MENU_PROFILE').'</a> | ';
			echo '<a href="'.$link_show_user.'">'.JText::_('ADSMANAGER_MENU_USER_ADS').'</a> | ';
			echo '<a href="'.$link_show_rules.'">'.JText::_('ADSMANAGER_MENU_RULES').'</a>';	
		?>
		</div>
		<br/>
	<?php
	}
	
	function endTemplate() {
			
	}
}