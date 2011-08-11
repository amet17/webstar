<?php
/**
 * @package		AdsManager
 * @copyright	Copyright (C) 2010-2011 JoomPROD.com. All rights reserved.
 * @license		GNU/GPL
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );

jimport('joomla.application.component.view');

require_once(JPATH_BASE."/components/com_adsmanager/helpers/field.php");

/**
 * @package		Joomla
 * @subpackage	Contacts
 */
class AdsmanagerViewSearch extends JView
{
	function display($tpl = null)
	{
		$app = &JFactory::getApplication();

		$user		= JFactory::getUser();
		$pathway	= $app->getPathway();
		$document	= JFactory::getDocument();
		
		$catmodel	= &$this->getModel( "category" );
		$fieldmodel	    = &$this->getModel( "field" );
		$configurationmodel	= &$this->getModel( "configuration" );
		
		$uri =& JFactory::getURI();
		$this->requestURL =& $uri->toString();

		// Get the parameters of the active menu item
		$menus	= JSite::getMenu();
		$menu    = $menus->getActive();
		
		$conf = $configurationmodel->getConfiguration();
		
		$catid = JRequest::getInt( 'catid',	0 );
	
		$searchfields = $fieldmodel->getSearchFields($catid);
		
		$this->assignRef('searchfields',$searchfields);
		$this->assignRef('catid',$catid);
		
		$tree = $catmodel->getCatTree();
		$this->assignRef('cats',$tree);
		
		$document->setTitle(JText::_('ADSMANAGER_PAGE_TITLE').JText::_('ADSMANAGER_ADVANCED_SEARCH'));
		
		$field_values = $fieldmodel->getFieldValues();
		
		$plugins = $fieldmodel->getPlugins();
		$field = new JHTMLAdsmanagerField($conf,$field_values,"2",$plugins,$this->get("Itemid"),$this->get("baseurl"));
		$this->assignRef('field',$field);
		
		parent::display($tpl);
	}
	
	function selectCategories($id, $level, $children,&$catid,$root_allowed,$link,$current_cat_only =0) {
		if (@$children[$id]) {
			foreach ($children[$id] as $row) {
				if (($root_allowed == 1)||(!@$children[$row->id])) {
					if ($current_cat_only == 0)
					{?>
					<option value="<?php echo JRoute::_("$link&catid=".$row->id); ?>" <?php if ($row->id == $catid) { echo "selected='selected'"; } ?>>
					<?php echo $level.$row->name; ?>
					</option>
					<?php 
					}
					else if ($row->id == $catid)
					{
						echo $level.$row->name;
					}
				}
				$this->selectCategories($row->id, $level.$row->name." >> ", $children,$catid,$root_allowed,$link,$current_cat_only);
			}
		}
	}
}
