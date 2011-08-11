<?php
/**
 * @package		AdsManager
 * @copyright	Copyright (C) 2010-2011 JoomPROD.com. All rights reserved.
 * @license		GNU/GPL
 */

defined('_JEXEC') or die();

class AdsmanagerTableCategory extends JTable
{
	var $id = null;
	var $parent = null;
	var $name = null;
	var $description = null;
	var $ordering = null;
	var $published = 1;
			
    function __construct(&$db)
    {
    	parent::__construct( '#__adsmanager_categories', 'id', $db );
    }
    
    function save($post,$files,$conf,$model)
    {
    	$app = &JFactory::getApplication();
		
		// image2 delete
		if ( $post['cb_image'] == "delete") {
			$pict = JPATH_SITE."/images/com_adsmanager/categories/".$this->id."cat.jpg";
			if ( file_exists( $pict)) {
				unlink( $pict);
			}
			$pict = JPATH_SITE."/images/com_adsmanager/categories/".$this->id."cat_t.jpg";
			if ( file_exists( $pict)) {
				unlink( $pict);
			}
		}
								
		if (isset( $files['cat_image'])) {
			if ( $files['cat_image']['size'] > $conf->max_image_size) {
				$app->redirect("index.php?option=com_adsmanager&c=categories", JText::_('ADSMANAGER_IMAGETOOBIG'));
				return;
			}
		}
	
		// image1 upload
		if (isset( $files['cat_image']) and !$files['cat_image']['error'] ) {
			$path= JPATH_SITE."/images/com_adsmanager/categories/";
			$model->createImageAndThumb($files['cat_image']['tmp_name'],
										$this->id."cat.jpg",
										$this->id."cat_t.jpg",
										$conf->cat_max_width,
										$conf->cat_max_height,
										$conf->cat_max_width_t,
										$conf->cat_max_height_t,
										"",
										$path,
										$files['cat_image']['name']);
		}	
    }
    
    function delete($id) {
    	$app = &JFactory::getApplication();

		$this->_db->setQuery("SELECT * FROM #__adsmanager_categories \nWHERE id != ".(int)$id." AND parent = ".(int)$id);
		if ($this->_db->loadResult()) 
		{
			$app->redirect("index.php?option=com_adsmanager&c=categories", JText::_('ADSMANAGER_DELETE_CATEGORY_SELECT_CHIDLS'));
		}
		$this->_db->setQuery("DELETE FROM #__adsmanager_categories \nWHERE id = ".(int)$id);
		$this->_db->query();

		$this->_db->setQuery( "SELECT a.id FROM #__adsmanager_ads as a ".
							 "LEFT JOIN #__adsmanager_adcat as adcat ON adcat.adid = a.id ".
							 "WHERE adcat.catid = ".(int)$id);
		
		$idsarray = $this->_db->loadResultArray();
		if (isset($idsarray))
		{
			$content =& JTable::getInstance('content', 'AdsmanagerTable');
			
			foreach($idsarray as $adid)
			{
				$content->delete($adid);
			}
		}
    }
}
	