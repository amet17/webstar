<?php
/**
 * @package		AdsManager
 * @copyright	Copyright (C) 2010-2011 JoomPROD.com. All rights reserved.
 * @license		GNU/GPL
 */

defined('_JEXEC') or die();

jimport( 'joomla.filesystem.file' );

class AdsmanagerTableContent extends JTable
{
	var $id= null;
	var $userid= null; 
	var $ad_headline=null;
	var $ad_text=null;
	var $email=null;
	var $date_created = null;
	var $date_recall = null;
	var $expiration_date = null;
	var $recall_mail_sent = null;
	var $published = null;
			
    function __construct(&$db)
    {
    	parent::__construct( '#__adsmanager_ads', 'id', $db );
    }
    
    function save($post,$files,$conf,$model,$plugins,$isUpdateMode)
    {
    	$app = &JFactory::getApplication();
    			
		// Add Ad/Category relation
		$query = "SELECT catid FROM #__adsmanager_adcat WHERE adid = ".(int)$this->id;
		$this->_db->setQuery($query);
		$prevcats = $this->_db->loadResultArray();
		
		$query = "DELETE FROM #__adsmanager_adcat WHERE adid = ".(int)$this->id;
		$this->_db->setQuery($query);
		$this->_db->query();
		
		if (function_exists("getMaxCats"))
			$maxcats = getMaxCats($conf->nbcats);
		else
			$maxcats = $conf->nbcats;
			
		if ($maxcats > 1)
		{
			$selected_cats = $post["selected_cats"];
			if (count($selected_cats) > $maxcats)
			{
				$selected_cats = array_slice ($selected_cats, 0, $maxcats);
			}
	
			$query = "INSERT IGNORE INTO #__adsmanager_adcat (`adid`,`catid`) VALUES ";
			foreach($selected_cats as $key => $cat)
			{
				if ($key != 0)
						$query .= ",";
				$query .= "('".(int)$this->id."','".(int)$cat."')";
			}
			$this->_db->setQuery($query);
			$this->_db->query();
			$catid = $selected_cats[0];
		}
		else
		{
			$category = $post["category"];
			$query = "INSERT IGNORE INTO #__adsmanager_adcat (`adid`,`catid`) VALUES ('".(int)$this->id."','".(int)$category."')";
			$this->_db->setQuery($query);
			$this->_db->query();
			$catid = $category;
		}
		
		if (function_exists("savePaidAd"))
		{
			if ($maxcats == 1)
			{
				$selected_cats = array();
				$selected_cats[] = $category;
			}

			$errorMsg = JRequest::getString( 'errorMsg',	"" );	
			if ($app->isSite() == true)
				$mode = "front";
			else
				$mode = "admin";
			$status = savePaidAd($this->id,$this->userid,$isUpdateMode,$errormsg,$conf,$prevcats,$selected_cats,$mode);
			//echo "$status<br/>";
			if ($status == -1)
			{
				return;
			}
			else if ($status == -2)
			{
				$redirect_text = $errormsg;
			}
		}
		
		//get fields
		$this->_db->setQuery( "SELECT * FROM #__adsmanager_fields WHERE published = 1");
		$fields = $this->_db->loadObjectList();
		if ($this->_db -> getErrorNum()) {
			echo $this->_db -> stderr();
			return false;
		}	
		
		$query = "UPDATE #__adsmanager_ads ";
		
		$first=0;
		foreach($fields as $field)
		{ 	
			if ($field->type == "multiselect")
			{	
				$value = $value = JRequest::getVar($field->name, '');
				//$valueA = explode("|*|",$value);
				if ($value != "")
					$value = ",".implode(',', $value).",";	
			}
			else if (($field->type == "multicheckbox")||($field->type == "multicheckboximage"))
			{
				$value = $value = JRequest::getVar($field->name, '');
				if ($value != "")
					$value = ",".implode(',', $value).",";
			}
			else if ($field->type == "file")
			{
				if (isset( $files[$field->name]) and !$files[$field->name]['error'] ) {
					$this->_db->setQuery( "SELECT ".$field->name." FROM #__adsmanager_ads WHERE id = ".$this->id);
					$old_filename = $this->_db->loadResult();
					@unlink(JPATH_SITE."/images/com_adsmanager/files/".$old_filename);
					
					$filename = $files[$field->name]['name'];
					while(file_exists(JPATH_SITE."/images/com_adsmanager/files/".$filename)){
						$filename = "copy_".$filename;
					}
					@move_uploaded_file($files[$field->name]['tmp_name'],
										JPATH_SITE."/images/com_adsmanager/files/".$filename);	
					$value = $filename;								
				} else {
					continue;
				}
			}
			else if ($field->type == "editor")
			{
				$value = JRequest::getVar($field->name, '', 'post', 'string', JREQUEST_ALLOWHTML);
			}
			//Plugins
			else if (isset($plugins[$field->type]))
			{
				$plugins[$field->type]->onFormSave($this->id,$field->fieldid,$isUpdateMode);
				continue;
			}
			else
			{
				$value = JRequest::getVar($field->name, '');
			}
							
			if ($first == 0)
				$query .= "SET"; 
			else
				$query .= ",";
			$first = 1;
			$query .= " $field->name = ".$this->_db->Quote($value)." ";		
		}
		$query .= "WHERE id = ".(int)$this->id;
		
		//echo $query;
		
		if ($first != 0)
		{
			if (function_exists("savePaidFields")) 
			{
				//echo "savePaidFields";
				if (savePaidFields($isUpdateMode,$this,$errormsg,"admin") != 0) // Error
				{
					//echo "error";
					$redirect_text = $errormsg;
				}
				else
				{
					//echo "ok<br/>";
					//echo $query;
					$this->_db->setQuery( $query);
					$this->_db->query();
				}
			}
			else
			{
				$this->_db->setQuery( $query);
				$this->_db->query();
			}
		}
		
		$nbImages = $conf->nb_images;
		
		for($i = 1 ;$i < $nbImages + 1; $i++)
		{	
			$ext_name = chr(ord('a')+$i-1);
			if (isset($post["cb_image$i"]))
				$cb_image = $post["cb_image$i"];
			else
				$cb_image = "";
			// image1 delete
			if ( $cb_image == "delete") {
				$pict = JPATH_SITE."/images/com_adsmanager/ads/".$this->id.$ext_name."_t.jpg";
				if ( file_exists( $pict)) {
					unlink( $pict);
				}
				$pic = JPATH_SITE."/images/com_adsmanager/ads/".$this->id.$ext_name.".jpg";
				if ( file_exists( $pic)) {
					unlink( $pic);
				}
			}
								
			if (isset( $files["ad_picture$i"])) {
				if ( $files["ad_picture$i"]['size'] > $conf->max_image_size) {
					$app->redirect("index.php?option=com_adsmanager&c=contents&catid=".$this->category, JText::_('ADSMANAGER_IMAGETOOBIG'));
					return;
				}
			}
			
			// image1 upload
			if (isset( $files["ad_picture$i"]) and !$files["ad_picture$i"]['error'] ) {
				$model->createImageAndThumb($files["ad_picture$i"]['tmp_name'],$this->id.$ext_name.".jpg",$this->id.$ext_name."_t.jpg",
											$conf->max_width,
											$conf->max_height,
											$conf->max_width_t,
											$conf->max_height_t,
											$conf->tag,
											JPATH_SITE."/images/com_adsmanager/ads/",
											$files["ad_picture$i"]['name']);
			}
		}
    }
    
    function delete($adid,$conf,$plugins)
    {		
    	$adid = (int) $adid;
    	
		$this->_db->setQuery("SELECT * FROM #__adsmanager_ads WHERE id=$adid");
		$ad = $this->_db->loadObject();
		
		$this->_db->setQuery("DELETE FROM #__adsmanager_ads WHERE id=$adid");
		$this->_db->query();
		
		$this->_db->setQuery("DELETE FROM #__adsmanager_adcat WHERE adid=$adid");
		$this->_db->query();
		
		$this->_db->setQuery( "SELECT name FROM #__adsmanager_fields WHERE `type` = 'file'");
		$file_fields = $this->_db->loadObjectList();
		foreach($file_fields as $file_field)
		{
			$filename = "\$ad->".$file_field->name;
			eval("\$filename = \"$filename\";");
			JFile::delete(JPATH_SITE."/images/com_adsmanager/files/".$filename);
		}
	
		$nbImages = $conf->nb_images;
	
		for($i = 1 ;$i < $nbImages + 1; $i++)
		{	
			$ext_name = chr(ord('a')+$i-1);
			$pict = JPATH_SITE."/images/com_adsmanager/ads/".$adid.$ext_name."_t.jpg";
			if ( file_exists( $pict)) {
				JFile::delete($pict);
			}
			$pic = JPATH_SITE."/images/com_adsmanager/ads/".$adid.$ext_name.".jpg";
			if ( file_exists( $pic)) {
				JFile::delete($pic);
			}
		}
		
		foreach($plugins as $plugin)
		{
			$plugin->onDelete(0,$adid);
		}
		
		if (function_exists('deletePaidAd')){
			deletePaidAd($adid);
		}
    }
}