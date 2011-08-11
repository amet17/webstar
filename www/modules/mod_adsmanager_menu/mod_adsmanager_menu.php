<?php
// no direct access
defined('_JEXEC') or die( 'Restricted access' );

require_once(JPATH_BASE.'/administrator/components/com_adsmanager/models/category.php');

function displayMenuCats($id, $level, &$children,$itemid,$current_list,$displaynumads) {
	global $cur_template;
	if (@$children[$id]) {
		foreach ($children[$id] as $row) {
			 ?>
			 <li>
			 <?php
			 $link = JRoute::_("index.php?option=com_adsmanager&view=list&catid=".$row->id."&Itemid=$itemid");
			 if ($displaynumads == 1)
			 {
				echo '<a href="'.$link.'" ><span>'.$row->name.' ('.$row->num_ads.')</span></a>';	
			 }
			 else
			 {
				echo '<a href="'.$link.'" ><span>'.$row->name.'</span></a>';
			 }
			 if (@$current_list[count($current_list) - 1 -$level] == $row->id)
			 {
			 	echo "<ul>";
				displayMenuCats($row->id, $level+1, $children,$itemid,$current_list,$displaynumads);
				echo "</ul>";
			 }
			 ?>
			 </li>
			 <?php
		}
	}
}

/****************************************************/
$catid = JRequest::getInt('catid', -1 );
$displaynumads = $params->def('displaynumads',1);
$itemid = intval($params->get( 'default_itemid', JRequest::getInt('Itemid', 0 ) )) ;

$catmodel  = new AdsmanagerModelCategory();
$cats = $catmodel->getCatTree(true,true,$nbcontents);

$cc = $catmodel->getCategories();
$orderlist = array();
// first pass - collect children
foreach ($cc as $v ) {
	$orderlist[$v->id] = $v;
}

$current_list[] = $catid;
if ($catid != -1)
{
	$current = $catid;
	while((isset($orderlist[$current])) && ($orderlist[$current]->parent != 0))
	{
			$current_list[] = $orderlist[$current]->parent;
			$current = $orderlist[$current]->parent;
	}
}

$lang = JFactory::getLanguage();
$lang->load("com_adsmanager");

$user = JFactory::getUser();

$link_front = JRoute::_("index.php?option=com_adsmanager&view=front&Itemid=$itemid");
$link_write_ad = JRoute::_("index.php?option=com_adsmanager&task=write&Itemid=$itemid");
$link_show_profile = JRoute::_("index.php?option=com_adsmanager&view=profile&Itemid=$itemid");
$link_show_user = JRoute::_("index.php?option=com_adsmanager&view=list&user=".$user->id."&Itemid=$itemid");
$link_show_rules = JRoute::_("index.php?option=com_adsmanager&view=rules&Itemid=$itemid");
$link_show_all = JRoute::_("index.php?option=com_adsmanager&view=list&Itemid=$itemid");

require(JModuleHelper::getLayoutPath('mod_adsmanager_menu'));