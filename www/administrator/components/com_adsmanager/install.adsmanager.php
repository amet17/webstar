<?php
/**
 * @package		AdsManager
 * @copyright	Copyright (C) 2010-2011 JoomPROD.com. All rights reserved.
 * @license		GNU/GPL
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport( 'joomla.filesystem.file' );

if(!file_exists(JPATH_SITE . "/images/com_adsmanager/")){
	JFolder::create(JPATH_SITE. "/images/com_adsmanager/");
};

if(!file_exists(JPATH_SITE. "/images/com_adsmanager/categories/")){
	JFolder::create(JPATH_SITE. "/images/com_adsmanager/categories/");
};

if(!file_exists(JPATH_SITE. "/images/com_adsmanager/ads/")){
	JFolder::create(JPATH_SITE. "/images/com_adsmanager/ads/");
};

if(!file_exists(JPATH_SITE. "/images/com_adsmanager/email/")){
	JFolder::create(JPATH_SITE. "/images/com_adsmanager/email/");
};

if(!file_exists(JPATH_SITE. "/images/com_adsmanager/files/")){
	JFolder::create(JPATH_SITE. "/images/com_adsmanager/files/");
};

if(!file_exists(JPATH_SITE. "/images/com_adsmanager/fields/")){
	JFolder::create(JPATH_SITE. "/images/com_adsmanager/fields/");
};

if(!file_exists(JPATH_SITE. "/images/com_adsmanager/plugins/")){
	JFolder::create(JPATH_SITE. "/images/com_adsmanager/plugins/");
};

// Schema modification -- BEGIN

$db =& JFactory::getDBO();

   
$db->setQuery("SELECT count(*) FROM `#__adsmanager_fields` WHERE 1");
$total = $db->loadResult();
if ($total == 0)
{
	$sql = " INSERT IGNORE INTO `#__adsmanager_columns` (`id`,`name`,`ordering`,`catsid`,`published`) VALUES "
	     . " (2, 'ADSMANAGER_PRICE', 1, 1), "
	     . " (3, 'ADSMANAGER_CITY', 2, 1), "
	     . " (5, 'ADSMANAGER_STATE', 1, 0);";
	$db->setQuery($sql);
	$result = $db->query();
	
	$sql = " INSERT IGNORE INTO `#__adsmanager_field_values` (`fieldvalueid`,`fieldid`,`fieldtitle`,`fieldvalue`,`ordering`,`sys`) VALUES "
	     . " (1, 8, 'ADSMANAGER_KINDOF2', 1, 1, 0), "
	     . " (2, 8, 'ADSMANAGER_KINDOF1', 2, 2, 0), "
	     . " (3, 9, 'ADSMANAGER_STATE_0', 4, 4, 0),"
	     . " (4, 8, 'ADSMANAGER_KINDOFALL', 0, 0, 0),"
		 . " (5, 9, 'ADSMANAGER_STATE_1', 3, 3, 0),"
		 . " (6, 9, 'ADSMANAGER_STATE_3', 1, 1, 0),"
		 . " (7, 9, 'ADSMANAGER_STATE_2', 2, 2, 0),"
		 . " (8, 9, 'ADSMANAGER_STATE_4', 0, 0, 0);";
	$db->setQuery($sql);
	$result = $db->query();

	$sql = " INSERT IGNORE INTO `#__adsmanager_fields` (`fieldid`, `name`, `title`, `description`, `type`, `maxlength`, `size`, `required`, `ordering`, `cols`, `rows`, `columnid`, `columnorder`, `pos`, `posorder`, `profile`, `cb_field`, `sort`, `sort_direction`, `published`) VALUES "
		 . "(1, 'name', 'ADSMANAGER_FORM_NAME', '', 'text', 50, 35, 1, 0, 0, 0, -1, 5, 5, 1, 1, 41, 0, 'DESC', 1),"
		 . "(2, 'email', 'ADSMANAGER_FORM_EMAIL', '', 'emailaddress', 50, 35, 1, 1, 0, 0, -1, 10, 5, 4, 1, 50, 0, 'DESC', 1),"
		 . "(3, 'ad_city', 'ADSMANAGER_FORM_CITY', '', 'text', 50, 35, 0, 4, 0, 0, 3, 1, 5, 3, 1, 59, 1, 'ASC', 1),"
		 . "(4, 'ad_zip', 'ADSMANAGER_FORM_ZIP', '', 'text', 6, 7, 0, 3, 0, 0, -1, 0, 5, 2, 1, -1, 0, 'ASC', 1),"
		 . "(5, 'ad_headline', 'ADSMANAGER_FORM_AD_HEADLINE', '', 'text', 60, 35, 1, 5, 0, 0, -1, 0, 1, 1, 0, -1, 0, 'DESC', 1),"
		 . "(6, 'ad_text', 'ADSMANAGER_FORM_AD_TEXT', '', 'textarea', 500, 0, 1, 6, 40, 20, -1, 0, 3, 1, 0, -1, 0, 'DESC', 1),"
		 . "(7, 'ad_phone', 'ADSMANAGER_FORM_PHONE1', '', 'number', 50, 35, 0, 2, 0, 0, -1, 0, 5, 1, 1, -1, 0, 'DESC', 1),"
		 . "(8, 'ad_kindof', 'ADSMANAGER_FORM_KINDOF', '', 'select', 0, 0, 1, 7, 0, 0, 5, 0, 2, 1, 0, -1, 0, 'DESC', 1),"
		 . "(9, 'ad_state', 'ADSMANAGER_FORM_STATE', '', 'select', 0, 0, 1, 8, 0, 0, 5, 0, 2, 1, 0, -1, 0, 'DESC', 1),"
		 . "(10, 'ad_price', 'ADSMANAGER_FORM_AD_PRICE', '', 'price', 10, 7, 1, 9, 0, 0, 2, 0, 4, 1, 0, -1, 1, 'DESC', 1);";	
	$db->setQuery($sql);
	$result = $db->query();
	
	$sql = " INSERT IGNORE INTO `#__adsmanager_positions` (`id`,'`name`,`title`) VALUES "
		 . " (1, 'top', 'ADSMANAGER_POSITION_TOP'),"	
		 . " (2, 'subtitle', 'ADSMANAGER_POSITION_SUBTITLE'),"
		 . " (3, 'description', 'ADSMANAGER_POSITION_DESCRIPTION'),"
		 . " (4, 'description2', 'ADSMANAGER_POSITION_DESCRIPTION2'),"
		 . " (5, 'contact', 'ADSMANAGER_POSITION_CONTACT');";
	$db->setQuery($sql);
	$result = $db->query();
	
	$db->setQuery(" ALTER IGNORE TABLE `#__adsmanager_ads` ADD `name` TEXT DEFAULT NULL;");
	$result = $db->query();
	
	$db->setQuery(" ALTER IGNORE TABLE `#__adsmanager_ads` ADD `ad_zip` TEXT DEFAULT NULL;");
	$result = $db->query();
	
	$db->setQuery(" ALTER IGNORE TABLE `#__adsmanager_ads` ADD `ad_city` TEXT DEFAULT NULL;");
	$result = $db->query();
	
	$db->setQuery(" ALTER IGNORE TABLE `#__adsmanager_ads` ADD `ad_phone` TEXT DEFAULT NULL;");
	$result = $db->query();
	
	$db->setQuery(" ALTER IGNORE TABLE `#__adsmanager_ads` ADD `email` TEXT DEFAULT NULL;");	
	$result = $db->query();
	
	$db->setQuery(" ALTER IGNORE TABLE `#__adsmanager_ads` ADD `ad_kindof` TEXT DEFAULT NULL;");	
	$result = $db->query();
	
	$db->setQuery(" ALTER IGNORE TABLE `#__adsmanager_ads` ADD `ad_headline` TEXT DEFAULT NULL;");	
	$result = $db->query();
	
	$db->setQuery(" ALTER IGNORE TABLE `#__adsmanager_ads` ADD `ad_text` TEXT DEFAULT NULL;");	
	$result = $db->query();
	
	$db->setQuery(" ALTER IGNORE TABLE `#__adsmanager_ads` CHANGE `ad_state` `ad_state` TEXT DEFAULT NULL;");	
	$result = $db->query();
	
	$db->setQuery(" ALTER IGNORE TABLE `#__adsmanager_ads` ADD `ad_price` TEXT DEFAULT NULL;");	
	$result = $db->query(); 
	   
	$db->setQuery("ALTER IGNORE TABLE `#__adsmanager_profile` ADD `name` TEXT DEFAULT NULL;");   
	$result = $db->query();
	
	$db->setQuery("ALTER IGNORE TABLE  `#__adsmanager_profile` ADD `ad_zip` TEXT DEFAULT NULL;");	
	$result = $db->query();
	
	$db->setQuery("ALTER IGNORE TABLE `#__adsmanager_profile` ADD `ad_city` TEXT DEFAULT NULL;");	
	$result = $db->query();
	
	$db->setQuery("ALTER TABLE `#__adsmanager_profile` ADD `ad_phone` TEXT NOT NULL;");	
	$result = $db->query();
}

$db->setQuery(" INSERT IGNORE INTO `#__adsmanager_config` VALUES "
		      ." (1, '1.0.1', 20, 2048000, 400, 300, 150, 100, 1,2,1,1,1,1, 'joomprod.com', '<p align=\"center\"><strong>Welcome to Ads Section.</strong></p><p align=\"left\">The better place to sell or buy</p>',0,0,'Inform the users about the rules here...',2,1,0,1,30,1,7,'Add This Text to recall message<br />','default',150,150,30,30,0,-1,0,0,0,1,1,5,1,100)");
$result = $db->query();
?>

<center>
<table width="100%" border="0">
   <tr>
      <td>
      Thank you for using AdsManager (joomprod.com)<br/>
	 <p>
		<em>webmaster@joomprod.com</em>
	 </p>
      </td>
      <td>
         <p>
            <br>
            <br>
            <br>
         </p>
      </td>
   </tr>
</table>
</center>