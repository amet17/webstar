<?php
/**
* @author Guillermo Vargas, http://joomla.vargas.co.cr
* @email guille@vargas.co.cr
* @version $Id: adsmanager.plugin.php 78 2007-11-12 01:07:17Z root $
* @package Xmap
* @license GNU/GPL
* @description Xmap plugin for AdsManager Component
*/

defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

$tmp = new Xmap_AdsManager;
XmapPlugins::addPlugin( $tmp );

/** Add support for AdsManager categories and ads to Xmap */
class Xmap_AdsManager {

	// Set to 0 if you don't want to show the number of item for each category
	var $show_ads = 1;

	/** Return true if this plugin handles this content */
	function isOfType( &$xmap, &$parent ) {
		if ( strpos($parent->link, 'option=com_adsmanager') ) {
			return true;
		}
		return false;
	}

	/** Get the content tree for this kind of content */
	function &getTree( &$xmap, &$parent ) {
		global $database;
		$catid=0;
		if ( strpos($parent->link, 'page=show_category') ) {
			$link_query = parse_url( $parent->link );
			parse_str( html_entity_decode($link_query['query']), $link_vars );
			$catid = intval(mosGetParam($link_vars,'catid',0));
		}
		
		$database->setQuery( "SELECT * FROM #__adsmanager_config");
		$database->loadObject($conf);

		return $this->getCategories($xmap,$parent,$conf,$catid);
	}

	function &getCategories ( &$xmap, &$parent, &$conf, $catid=0 ) {
		global $database,$mosConfig_absolute_path,$mosConfig_lang,$my;

		$list = array();

		$query = "SELECT * FROM #__adsmanager_categories WHERE `published`=1 and parent=$catid";
		$database->setQuery($query);
		$rows = $database->loadAssocList();

		$coma='';
		$catids='';
		foreach($rows as $row) {
			$node = new stdclass;
			$node->id = $parent->id;
			$node->browserNav = $parent->browserNav;
			$node->name = $row['name'];
			$node->modified = $xmap->now;
			$node->link = 'index.php?option=com_adsmanager&amp;page=show_category&amp;catid='.$row['id'].'&amp;text_search=&amp;order=0&amp;expand=0&amp;Itemid='.$parent->id;
			$node->pid = $row['parent'];	// parent id
			$node->priority = $parent->priority;
			$node->changefreq = $parent->changefreq;
			$node->tree = $this->getCategories ( $xmap, $parent, $conf, $row['id']);
			$list[] = $node;
			$coma=',';
    		}

		if ( $this->show_ads ) {
			$query = "SELECT id,name,ad_headline FROM #__adsmanager_ads WHERE `published`=1 and category = $catid";
			$database->setQuery($query);
			$rows = $database->loadAssocList();

			foreach ( $rows as $row ) {
				$node = new stdclass;
				$node->id = $parent->id;
				$node->browserNav = $parent->browserNav;
				$node->name = $row['ad_headline'];
				$node->modified = $xmap->now;
				$node->link = 'index.php?option=com_adsmanager&amp;page=show_ad&amp;adid='.$row['id'].'&amp;catid='.$catid.'&amp;Itemid='.$parent->id;
				$node->priority = $parent->priority;
				$node->changefreq = $parent->changefreq;
				$node->tree = array();
				$list[] = $node;
    			}
		}

		return $list;
	}
}
