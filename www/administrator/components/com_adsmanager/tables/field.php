<?php
/**
 * @package		AdsManager
 * @copyright	Copyright (C) 2010-2011 JoomPROD.com. All rights reserved.
 * @license		GNU/GPL
 */

defined('_JEXEC') or die();

class AdsmanagerTableField extends JTable
{
   var $fieldid=null;
   var $name=null;
   var $description=null;
   var $title=null;
   var $display_title=null;
   var $type=null;
   var $maxlength=null;
   var $size=null;
   var $required=null;
   var $ordering=null;
   var $cols=null;
   var $rows=null;
   var $link_text = null;
   var $link_image = null;
   var $columnid    =null;
   var $columnorder =null;
   var $pos      = null;
   var $posorder = null;
   var $profile = null;
   var $cb_field = null;
   var $cbfieldvalues = null;
   var $editable = null;
   var $searchable = null;
   var $sort = null;
   var $sort_direction = null;
   var $catsid = null;
   var $published = 1;
			
    function __construct(&$db)
    {
    	parent::__construct( '#__adsmanager_fields', 'fieldid', $db );
    }
    
    function save($post,$plugins)
    {
		$fieldNames  = $post['vNames'];
		$fieldValues = $post['vValues'];
		$fieldImagesSelect = $post['vSelectImages'];
		$fieldImagesValues = $post['vImagesValues'];
		
		$j=1;
		if($this->fieldid > 0) {
			$this->_db->setQuery( "DELETE FROM #__adsmanager_field_values"
				. " WHERE fieldid='".(int)$this->fieldid."'" );
			$this->_db->query();
		} else {
			$this->_db->setQuery( "SELECT MAX(fieldid) FROM #__adsmanager_fields");
			$maxID=$this->_db->loadResult();
			$this->fieldid=$maxID;
			echo $this->_db->getErrorMsg();
		}
	
		switch($this->type) {
			case "select":
		    case "multiselect":
			case "radio":
			case "multicheckbox":
			case "price":
				$j=0;$i=0;
				while(isset($fieldNames[$i])){
					$fieldName  = $fieldNames[$i];
					$fieldValue = $fieldValues[$i];
					$i++;
					
					if(trim($fieldName)!=null || trim($fieldName)!='') {
						$this->_db->setQuery( "INSERT INTO #__adsmanager_field_values (fieldid,fieldtitle,fieldvalue,ordering)"
							. " VALUES('".(int)$this->fieldid."',".$this->_db->Quote($fieldName).",".$this->_db->Quote($fieldValue).",".(int)$j.")"
						);
						$this->_db->query();
						$j++;
					}
				}
				break;
			case 'radioimage':
			case 'multicheckboximage':
				$j=0;$i=0;
				while(isset($fieldImagesSelect[$i])){
					$fieldName  = $fieldImagesSelect[$i];
					$fieldValue = $fieldImagesValues[$i];
					$i++;
					
					if(trim($fieldName)!=null && trim($fieldName)!='' && trim($fieldName)!='null') {
						$this->_db->setQuery( "INSERT INTO #__adsmanager_field_values (fieldid,fieldtitle,fieldvalue,ordering)"
							. " VALUES('".(int)$this->fieldid."',".$this->_db->Quote($fieldName).",".$this->_db->Quote($fieldValue).",".(int)$j.")"
						);
						$this->_db->query();
						$j++;
					}
				}
				break;
		}
		
		$field_catsid = $post['field_catsid'];
		if (!is_array($field_catsid))
			$field_catsid = array();
			
		$field_catsid = ",".implode(',', $field_catsid).",";
		if ($field_catsid != "")
		{
			$query = "UPDATE #__adsmanager_fields SET catsid =".$this->_db->Quote($field_catsid)." WHERE fieldid=".(int)$this->fieldid;
			$this->_db->setQuery( $query);
			$this->_db->query();
		}
		
		$plugfield = false;
		if (isset($plugins["$this->type"]))
		{
			$plugins["$this->type"]->saveFieldOptions($this->fieldid);
			$plugfield = true;
		}
		$app =& JFactory::getApplication();
		
		
		if ($plugfield == false)
		{
			//Update Ad Fields
		    $this->_db->setQuery("SELECT count(*) FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = '".$app->getCfg('db')."' AND TABLE_NAME = '".$this->_db->getPrefix()."adsmanager_ads' AND column_name='{$this->name}'");
		    
		    $exist = $this->_db->loadResult();
			if (!$exist) {
				$this->_db->setQuery("ALTER TABLE #__adsmanager_ads ADD `$this->name` TEXT NOT NULL");
				$result = $this->_db->query();
		    }
		    
		    if ($this->profile == 1)
		    {
				//Update Profile Fields
				$this->_db->setQuery("SELECT count(*) FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = '".$app->getCfg('db')."' AND TABLE_NAME = '".$this->_db->getPrefix()."adsmanager_profile' AND column_name='{$this->name}'");
				$exist = $this->_db->loadResult();
				if (!$exist) {
					$this->_db->setQuery("ALTER TABLE #__adsmanager_profile ADD `$this->name` TEXT NOT NULL");
					$result = $this->_db->query();
				}
			}
			else
			{
				//Update Profile Fields
				$this->_db->setQuery("SELECT count(*) FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = '".$app->getCfg('db')."' AND TABLE_NAME = '".$this->_db->getPrefix()."adsmanager_profile' AND column_name='{$this->name}'");
				$exist = $this->_db->loadResult();
				if ($exist) {
					$this->_db->setQuery("ALTER TABLE #__adsmanager_profile DROP `$this->name`");
					$result = $this->_db->query();
				}
			}
		}	
    }
    
    function delete($id)
    {
    	$app = &JFactory::getApplication();
    	
		$this->_db->setQuery("SELECT name FROM #__adsmanager_fields WHERE fieldid = ".(int)$id);
		$name = $this->_db->loadResult();
	
		if(($name == "name")||($name == "email")||($name == "ad_text")||($name == "ad_headline"))
		{
			$app->redirect( 'index.php?option=com_adsmanager&c=fields', JText::_('ADSMANAGER_ERROR_SYSTEM_FIELD') );
			return;
		}
		
		//Update Ad Fields
		$this->_db->setQuery("SELECT count(*) FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = '".$app->getCfg('db')."' AND TABLE_NAME = '".$this->_db->getPrefix()."adsmanager_ads' AND column_name='$name'");
		$exist = $this->_db->loadResult();
		if ($exist) {
			$this->_db->setQuery("ALTER TABLE #__adsmanager_ads DROP `$name`");
			$result = $this->_db->query();
		}
			
		//Update Profile Fields
		$this->_db->setQuery("SELECT count(*) FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = '".$app->getCfg('db')."' AND TABLE_NAME = '".$this->_db->getPrefix()."adsmanager_profile' AND column_name='$name'");
		$exist = $this->_db->loadResult();
		if ($exist) {
			$this->_db->setQuery("ALTER TABLE #__adsmanager_profile DROP `$name`");
			$result = $this->_db->query();
		}
		
		$this->_db->setQuery("DELETE FROM #__adsmanager_fields WHERE fieldid = ".(int)$id);
		$this->_db->query();
		
		$this->_db->setQuery("DELETE FROM #__adsmanager_field_values WHERE fieldid = ".(int)$id);
    }
}
