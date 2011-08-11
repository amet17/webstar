<?php
/**
 * @version		$Id: item.php 502 2010-06-24 20:33:42Z joomlaworks $
 * @package		K2
 * @author		JoomlaWorks http://www.joomlaworks.gr
 * @copyright	Copyright (c) 2006 - 2010 JoomlaWorks, a business unit of Nuevvo Webware Ltd. All rights reserved.
 * @license		GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 */

// no direct access
defined('_JEXEC') or die('Restricted access');


$id = JRequest::getInt('id');

$db = &JFactory::getDBO();
$jnow = &JFactory::getDate();
$now = $jnow->toMySQL();
$nullDate = $db->getNullDate();

$sql = "SELECT i.*, c.name as categoryname,c.id as categoryid, c.alias as categoryalias,
 c.params as categoryparams

 FROM #__k2_items as i
 LEFT JOIN #__k2_categories AS c ON c.id = i.catid
 WHERE i.published = 1
 AND i.access <= 0
 AND i.trash = 0
 AND c.published = 1
 AND c.access <= 0
 AND c.trash = 0
 AND ( i.publish_up = ".$db->Quote($nullDate)." OR i.publish_up <= ".$db->Quote($now)." )
 AND ( i.publish_down = ".$db->Quote($nullDate)." OR i.publish_down >= ".$db->Quote($now)." )
 AND c.id IN (SELECT cc.catid 	 FROM #__k2_items cc WHERE id=".$id.")
 ORDER BY i.created ASC
 ";
$db->setQuery($sql);
$rows = $db->loadObjectList();

 //print_r($rows);
//print count($rows);
$number = 0;
for($i=0; $i<count($rows); $i++)
{
	$item = $rows[$i];
	if($item->id==$id) $number = $i;
}
$arr = array();
for($i=$number; $i<count($rows);$i++)
{
	$item = $rows[$i];
	$query = "SELECT * FROM #__k2_categories WHERE id=".(int)$item->catid;
	$db->setQuery($query, 0, 1);
	$category = $db->loadObject();
	$item->category=$category;
    $link = K2HelperRoute::getItemRoute($item->id.':'.urlencode($item->alias),$item->catid.':'.urlencode($item->category->alias));
	$item->link=urldecode(JRoute::_($link));
    $arr[] = '<a class="itemNext" href="'.$item->link.'" title="'.$item->title.'" >'.$item->title.'</a>';
}

for($i=0; $i<$number;$i++)
{
	$item = $rows[$i];
	$query = "SELECT * FROM #__k2_categories WHERE id=".(int)$item->catid;
	$db->setQuery($query, 0, 1);
	$category = $db->loadObject();
	$item->category=$category;
    $link = K2HelperRoute::getItemRoute($item->id.':'.urlencode($item->alias),$item->catid.':'.urlencode($item->category->alias));
	$item->link=urldecode(JRoute::_($link));
    $arr[] = '<a class="itemNext" href="'.$item->link.'" title="'.$item->title.'" >'.$item->title.'</a>';
}
for($i=1; $i<3; $i++)
{
	print $arr[$i]  ;
}

?>
